<?php
    class ModelExtensionModuleIeProExport extends ModelExtensionModuleIePro {
        public function __construct($registry){
            parent::__construct($registry);
        }

        public function export($profile) {
            $profile_data = $profile['profile'];
            $this->profile = $profile_data;
            $this->multilanguage = array_key_exists('import_xls_multilanguage', $profile_data) && $profile_data['import_xls_multilanguage'];
            $this->cat_tree =  array_key_exists('import_xls_category_tree', $this->profile) && $this->profile['import_xls_category_tree'];
            $columns = $this->clean_columns($profile_data['columns']);
            $this->columns = $columns;
            $this->conversion_fields = $this->get_conversion_fields($this->columns);
            $this->custom_columns = $this->get_custom_columns($this->columns);
            $elements_to_export = $profile['profile']['import_xls_i_want'];
            $model_name = 'ie_pro_'.$elements_to_export;
            $model_path = 'extension/module/'.$model_name;
            $this->model_loaded = 'model_extension_module_'.$model_name;
            $this->load->model($model_path);
            $this->{$this->model_loaded}->set_model_tables_and_fields();
            $format = $this->profile['import_xls_file_format'];

            if(in_array($elements_to_export, array('products'))) {
                $this->load->model('extension/module/ie_pro_categories');
                $this->all_categories = $this->model_extension_module_ie_pro_categories->get_all_categories_export_format();

                if($this->hasFilters) {
                    $this->load->model('extension/module/ie_pro_filters');
                    $this->all_filters = $this->model_extension_module_ie_pro_filters->get_all_filters_export_format();
                }

                $this->load->model('extension/module/ie_pro_attribute_groups');
                $this->all_attribute_groups = $this->model_extension_module_ie_pro_attribute_groups->get_all_attribute_groups_export_format();

                $this->load->model('extension/module/ie_pro_attributes');
                $this->all_attributes = $this->model_extension_module_ie_pro_attributes->get_all_attributes_export_format($this->all_attribute_groups);

                $this->load->model('extension/module/ie_pro_manufacturers');
                $this->all_manufacturers = $this->model_extension_module_ie_pro_manufacturers->get_all_manufacturers_export_format();

                $this->load->model('extension/module/ie_pro_option_values');
                $this->all_option_values = $this->model_extension_module_ie_pro_option_values->get_all_option_values_export_format();

                $this->load->model('extension/module/ie_pro_downloads');
                $this->all_downloads = $this->model_extension_module_ie_pro_downloads->get_all_downloads_export_format();
            } else if(in_array($elements_to_export, array('specials', 'discounts'))) {
                $this->load->model('extension/module/ie_pro_products');
            }

            $element_ids = $this->get_elements_id($profile);
            $this->update_process(sprintf($this->language->get('progress_export_element_numbers'), count($element_ids)));
            $elements = array();
            if(!empty($element_ids)) {
                $tables_fields = $this->get_col_map_tables_fields($columns);
                if(!empty($tables_fields)) {
                    $this->update_process(sprintf($this->language->get('progress_export_processing_elements'), count($element_ids)));
                    $elements = $this->get_elements($tables_fields, $element_ids);
                }
            }
            
            $elements = $this->insert_default_values($this->columns, $elements);
            $elements = $this->conversion_values($this->custom_columns, $elements);
            $elements = $this->insert_modifications_values($this->columns, $elements);

            if($format == 'xlsx') {
                $this->load->model('extension/module/ie_pro_file');
                $this->load->model('extension/module/ie_pro_file_xlsx');
                $this->model_extension_module_ie_pro_file_xlsx->check_cell_limit($elements);
            }

            $this->insert_elemements_into_file($elements);
        }

        /*
         * Proccess all export filters and optain only element_id
         * */
        public function get_elements_id($profile) {
            $category = $profile['profile']['import_xls_i_want'];

            $main_table = $this->main_table;
            $main_field = $this->main_field;
            $main_table_formatted = $this->escape_database_field($this->db_prefix.$main_table);
            $main_field_formatted = 'main_table.'.$main_field;

            $sql = 'SELECT '.$main_field_formatted.' FROM '.$main_table_formatted.' main_table ';

            $filters = array_key_exists('export_filter', $profile['profile']) && array_key_exists('filters', $profile['profile']['export_filter']) && !empty($profile['profile']['export_filter']['filters']) ? $profile['profile']['export_filter']['filters'] : array();
            $filters_config = array_key_exists('export_filter', $profile['profile']) && array_key_exists('config', $profile['profile']['export_filter']) && !empty($profile['profile']['export_filter']['config']) ? $profile['profile']['export_filter']['config'] : array();

            $joins = '';
            $where = '';

            if(!empty($filters)) {
                $main_conditional = (array_key_exists('main_conditional', $filters_config) ? $filters_config['main_conditional'] : 'OR').' ';
                $filters_by_table = $this->format_filters_by_table($filters);

                foreach ($filters_by_table as $table_name => $field) {
                    if($table_name == $main_table) {
                        if(empty($where))
                            $where .= ' WHERE ';

                        foreach ($field as $field_name => $values) {
                            foreach ($values as $key2 => $val) {
                                $condition = $this->translate_condition($val['condition']);
                                $value = $this->translate_condition_value($val['condition'], $val['value']);
                                $like = in_array($val['condition'], array('like','not_like'));
                                $where .= 'main_table.'.$field_name." ".$condition." '".($like ? '%':'').$value.($like ? '%':'')."' ".$main_conditional;
                            }
                        }
                        $where = rtrim($where, $main_conditional);
                    } else {
                        $table_formatted = $this->escape_database_field($this->db_prefix.$table_name);
                        $table_join = 'ij_'.$table_name;

                        $joins .= 'INNER JOIN '.$table_formatted.' '.$table_join.' ON (main_table.'.$main_field.' = '.$table_join.'.'.$main_field.' AND (';
                            foreach ($field as $field_name => $values) {
                                foreach ($values as $key2 => $val) {
                                    $condition = $this->translate_condition($val['condition']);
                                    $value = $this->translate_condition_value($val['condition'], $val['value']);
                                    $like = in_array($val['condition'], array('like','not_like'));
                                    $joins .= $table_join.'.'.$field_name." ".$condition." '".($like ? '%':'').$value.($like ? '%':'')."' ".$main_conditional;
                                }
                            }
                        $joins = rtrim($joins, $main_conditional);
                        $joins .= ')) '."\n";
                    }
                }
            }

            if($category == 'products') {
                $category_id_filters = array_key_exists('import_xls_quick_filter_category_ids', $profile['profile']) && !empty($profile['profile']['import_xls_quick_filter_category_ids']);
                if(!empty($category_id_filters)) {
                    $joins .= ' INNER JOIN ' . $this->escape_database_table_name('product_to_category') . ' ptc ON (main_table.product_id = ptc.product_id AND ptc.category_id IN(' . implode(',', $profile['profile']['import_xls_quick_filter_category_ids']) . ')) ';
                }

                $manufacturer_id_filters = array_key_exists('import_xls_quick_filter_manufacturer_ids', $profile['profile']) && !empty($profile['profile']['import_xls_quick_filter_manufacturer_ids']);
                if(!empty($manufacturer_id_filters)) {
                     if(empty($where))
                         $where .= ' WHERE ';
                     else
                         $where .= 'AND';

                     $where .= ' main_table.manufacturer_id IN ('.implode(',', $profile['profile']['import_xls_quick_filter_manufacturer_ids']).')';
                }
            }

            $sql = $sql.$joins.$where.' GROUP BY main_table.'.$main_field;
            $from = array_key_exists('from', $this->request->post) ? (int)$this->request->post['from'] : 0;
            $to = array_key_exists('to', $this->request->post) ? (int)$this->request->post['to'] : 0;

            if($to < $from)
                $this->exception($this->language->get('progress_export_error_range'));

            if($this->is_t && ($to - $from) > $this->is_t_elem)
                $this->exception(sprintf($this->language->get('trial_operation_restricted_export'), $this->is_t_elem, ($to - $from)));

            if($from > 0 || $to > 0)
                $sql .= ' LIMIT ';
            if($from > 0)
                $sql .= ($from-1).($to == 0 ? ',100000000000000':'');
            if($to > 0)
                $sql .= ($from == 0 ? '1':'').','.($to-1);

            $sort_order = array_key_exists('export_sort_order', $profile['profile']) && !empty($profile['profile']['export_sort_order']['table_field']);
            if($sort_order) {
                $table_field = $profile['profile']['export_sort_order']['table_field'];
                $sort_mode = $profile['profile']['export_sort_order']['sort_order'];
                $table_field_split = explode('-', $table_field);
                $table = $table_field_split[0];
                $field = $table_field_split[1];
                $has_language = array_key_exists($table, $this->database_schema) && array_key_exists('language_id', $this->database_schema[$table]) && $field != 'language_id';

                $final_sql = 'SELECT results.* FROM ('.$sql.') as results ';

                $extra_lang_condition = $has_language ? ' AND innerJoinTable.language_id = '.$this->escape_database_value($this->default_language_id) : '';
                $final_sql .= ' INNER JOIN '.$this->escape_database_table_name($table).' innerJoinTable ON(innerJoinTable.'.$this->main_field.' = results.'.$this->main_field.$extra_lang_condition.') ORDER BY innerJoinTable.'.$field.' '.$sort_mode;
            } else
                $final_sql = $sql;

            $result = $this->db->query($final_sql);

            $final_result = array();
            if(!empty($result->rows)) {
                foreach ($result->rows as $key => $val) {
                    $final_result[] = $val[$main_field];
                }
            }

            if($this->is_t && count($final_result) > $this->is_t_elem)
                $this->exception(sprintf($this->language->get('trial_operation_restricted_export'), $this->is_t_elem, count($final_result)));

            return $final_result;
        }

        public function translate_condition($condition) {
            if(is_numeric($condition))
                return '=';

            switch ($condition) {
                case 'not_like':
                    return 'NOT LIKE';
                    break;
                case 'years_ago': case 'months_ago': case 'days_ago': case 'hours_ago': case 'minutes_ago':
                    return '>=';
                    break;
                default:
                    return $condition;
                    break;
            }
        }

        public function translate_condition_value($condition, $value) {
            if(in_array($condition, array('years_ago', 'months_ago', 'days_ago', 'hours_ago', 'minutes_ago'))) {
                $php_name = '';
                if($condition == 'years_ago') $php_name = 'years';
                elseif($condition == 'months_ago') $php_name = 'months';
                elseif($condition == 'days_ago') $php_name = 'days';
                elseif($condition == 'hours_ago') $php_name = 'hours';
                elseif($condition == 'minutes_ago') $php_name = 'minutes';

                return date('Y-m-d H:i:s', strtotime('-'.(int)$value.' '.$php_name));
            }

            if(is_numeric($condition))
                return $condition;

            return $value;
        }

        public function get_elements($table_fields, $ids) {

            $table_fields_formatted = array();

            foreach ($this->columns as $col_name_real => $col_info) {
                $custom_name = array_key_exists('custom_name', $col_info) ? $col_info['custom_name'] : '';
                if(!empty($custom_name))
                    $table_fields_formatted[$custom_name] = $col_info;
            }

            $final_data = array();

            $element_to_process = count($ids);
            $element_processed = 0;
            $this->update_process(sprintf($this->language->get('progress_export_processing_elements_processed'), $element_processed, $element_to_process));

            foreach ($ids as $key => $id) {
                $final_data[$id] = array();
                foreach ($table_fields as $table_name => $fields_info) {
                    $explode_table = explode("-", $table_name);
                    $table_name = $explode_table[0];

                    $conversion_global_vars = array();
                    //Normal process to get fields from database (include multilanguages)
                    if(!in_array($table_name, $this->special_tables)) {
                        $fields = array();
                        $conditions = array();

                        $conditions_query = '';
                        foreach ($fields_info as $key => $fii) {
                            $fields[] = $this->escape_database_field($fii['field']) . ' AS "' . $fii['custom_name'] . '"';
                            if (array_key_exists('conditions', $fii) && !empty($fii['conditions'])) {
                                foreach ($fii['conditions'] as $cond) {
                                    $conditions[] = $cond;
                                }
                            }
                            $conversion_global_vars = $this->_extract_conversion_values($fii, $conversion_global_vars);
                        }

                        if (!empty($conditions)) {
                            $conditions = array_unique($conditions);
                            $conditions_query = ' AND ' . implode(' AND ', $conditions);
                        }

                        $fields_formatted = implode(",", $fields);
                        $table_formatted = $this->escape_database_field($this->db_prefix . $table_name);
                        $main_field_formatted = $this->escape_database_field($this->main_field);
                        $sql = 'SELECT ' . $fields_formatted . ' FROM ' . $table_formatted . ' WHERE ' . $main_field_formatted . ' = ' . $this->escape_database_value($id) . $conditions_query;

                        $result = $this->db->query($sql);
                        if(!empty($result->row)) {
                            $values_converted = $this->_apply_conversions_to_row($result->row, $conversion_global_vars);
                            foreach ($values_converted as $colname => $final_val)
                                $final_data[$id][$colname] = $final_val;
                        }
                    } else {
                        if(!in_array($table_name, array('product_option_value', 'empty_columns'))) {
                            $final_data[$id] = $this->{$this->model_loaded}->{'_exporting_process_' . $table_name}($final_data[$id], $id, $fields_info);
                        } else {
                            if($table_name == 'product_option_value') {
                                $options_rows = $this->{$this->model_loaded}->{'_exporting_process_' . $table_name}($id, $fields_info);
                                if (!empty($options_rows)) {
                                    foreach ($options_rows as $key => $option_row) {
                                        $final_data[$id . '_option_' . ($key + 1)] = $option_row;
                                    }
                                }
                            }elseif($table_name == 'empty_columns') {
                                $final_data[$id] = $this->_exporting_empty_columns($final_data[$id], $id, $fields_info);
                            }
                        }
                    }
                }

                $element_processed++;
                $this->update_process(sprintf($this->language->get('progress_export_processing_elements_processed'), $element_processed, $element_to_process), true);
            }

            return $final_data;
        }

        function _apply_conversions_to_row($row, $conversion_global_vars) {
            $temp = array();
            foreach ($row as $col_name => $final_val) {
                if(!empty($conversion_global_vars) && array_key_exists($col_name, $conversion_global_vars)) {
                    $var_name = $conversion_global_vars[$col_name]['var_name'];
                    if(array_key_exists($final_val, $this->{$var_name})) {
                        $index = array_key_exists('index', $conversion_global_vars[$col_name]) ? $conversion_global_vars[$col_name]['index'] : '';
                        $multilanguage = $conversion_global_vars[$col_name]['multilanguage'];
                        if(empty($index) && !empty($multilanguage)) {
                            $final_val = $this->{$var_name}[$final_val][$this->default_language_id];
                        }else if(!empty($index)) {
                            $final_val = $this->{$var_name}[$final_val][$index];
                        }
                        else
                            $final_val = $this->{$var_name}[$final_val];
                    } else {
                        $final_val = '';
                    }
                }

                $row[$col_name] = !is_array($final_val) ? htmlspecialchars_decode(trim($final_val)) : $final_val;
            }

            return $row;
        }
        function _extract_conversion_values($field_info, $conversion_global_vars) {
            if (array_key_exists('conversion_global_var', $field_info) && !empty($field_info['conversion_global_var']) && array_key_exists('name_instead_id', $field_info) && !empty($field_info['name_instead_id'])) {
                $conversion_global_vars[$field_info['custom_name']] = array();
                $conversion_global_vars[$field_info['custom_name']]['var_name'] = $field_info['conversion_global_var'];
                $conversion_global_vars[$field_info['custom_name']]['index'] = array_key_exists('conversion_global_index', $field_info) ? $field_info['conversion_global_index'] : '';
                $conversion_global_vars[$field_info['custom_name']]['multilanguage'] = array_key_exists('multilanguage', $field_info) && $field_info['multilanguage'] || $field_info['name'] = 'Manufacturer';
            }
            return $conversion_global_vars;
        }
        public function _exporting_empty_columns($current_data, $product_id, $columns) {
            foreach ($columns as $key => $col_info) {
                 $current_data[$col_info['custom_name']] = 0;
            }

            return $current_data;
        }

        public function format_filters_by_table($filters) {
            $final_filters = array();

            foreach ($filters as $key => $fil) {
                $field_split = explode('-', $fil['field']);
                $table = $field_split[0];
                $field = $field_split[1];
                $type = $field_split[2];

                if(!array_key_exists($table, $final_filters))
                    $final_filters[$table] = array();
                if(!array_key_exists($field, $final_filters[$table]))
                    $final_filters[$table][$field] = array();

                $condition = $fil['conditional'][$type];

                $final_filters[$table][$field][] = array(
                    'value' => $this->db->escape($fil['value']),
                    'condition' => html_entity_decode($condition)
                );
            }

            return $final_filters;
        }

        public function get_col_map_tables_fields($columns) {
            $final_fields = array();
            
            foreach ($columns as $key => $val) {
                $table = $val['table'];
                if($this->special_tables && !in_array($table, $this->special_tables)) {
                    if (array_key_exists('language_id', $val) && !empty($val['language_id']))
                        $table .= '-language_id_'.$val['language_id'];
                    if (array_key_exists('store_id', $val) && !empty($val['store_id']))
                        $table .= '-store_id_'.$val['store_id'];
                }

                if(!array_key_exists($table, $final_fields))
                    $final_fields[$table] = array();

                $final_fields[$table][] = $val;
            }
            return $final_fields;
        }

        public function insert_default_values($columns, $elements) {
            foreach ($elements as $el_id => $el) {
                foreach ($this->columns as $key => $col_info) {
                    $default_value = $col_info['default_value'];
                    $custom_name = $col_info['custom_name'];

                    if(!empty($default_value) && array_key_exists($custom_name, $el) && empty($el[$custom_name]))
                        $elements[$el_id][$custom_name] = $default_value;
                }
            }

            return $elements;
        }

        public function conversion_values($columns, $elements) {
            foreach ($elements as $key => $fields) {
                foreach ($fields as $col_name => $value) {
                    $col_info = array_key_exists($col_name, $columns) ? $columns[$col_name]: false;
                    if($col_info) {
                        if(array_key_exists('image_full_link', $col_info) && $col_info['image_full_link'])
                            $elements[$key][$col_name] = HTTPS_CATALOG.'image/'.$value;

                        if(array_key_exists('true_value', $col_info))
                            $elements[$key][$col_name] = $value ? $col_info['true_value'] : $col_info['false_value'];

                        if(array_key_exists('product_id_identificator', $col_info)) {
                            $field = $col_info['product_id_identificator'];
                            $final_value = $this->model_extension_module_ie_pro_products->get_product_field($value,$field);
                            $final_value = !$final_value ? '' : $final_value;
                            $elements[$key][$col_name] = $final_value;
                        }
                    }
                }
            }
            return $elements;
        }

        public function insert_modifications_values($columns, $elements) {
            $is_products = $this->profile['import_xls_i_want'] == 'products';
            $exist_price_column = array_key_exists('Price', $columns);
            $tax_rest = array_key_exists('import_xls_rest_tax', $this->profile) && $this->profile['import_xls_rest_tax'];
            $tax_sum = array_key_exists('import_xls_sum_tax', $this->profile) && $this->profile['import_xls_sum_tax'];

            $some_modification = $is_products && $exist_price_column && ($tax_rest || $tax_sum);

            if($some_modification) {
                foreach ($elements as $el_id => $el) {
                    foreach ($this->columns as $column_name => $col_info) {
                        $custom_name = $col_info['custom_name'];
                        if($column_name == 'Price' && array_key_exists($custom_name, $el) && !empty($el[$custom_name]))
                            $elements[$el_id][$custom_name] = $this->price_tax_calculate($el_id, $el[$custom_name], $tax_sum ? 'sum' : 'rest');
                    }
                }
            }
            return $elements;
        }

        public function insert_elemements_into_file($elements) {
            $format = $this->profile['import_xls_file_format'];
            $model_path = 'extension/module/ie_pro_file_'.$format;
            $model_name = 'model_extension_module_ie_pro_file_'.$format;
            $this->load->model('extension/module/ie_pro_file');
            $this->load->model($model_path);
            $this->{$model_name}->create_file();
            $this->{$model_name}->insert_columns($this->columns);
            $this->{$model_name}->insert_data($this->columns, $elements);
            $this->{$model_name}->download_file_export();

            $this->ajax_die('Export process finished', false);
        }
    }
?>