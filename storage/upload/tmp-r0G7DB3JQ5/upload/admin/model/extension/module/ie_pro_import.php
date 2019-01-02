<?php
    class ModelExtensionModuleIeProImport extends ModelExtensionModuleIePro {
        public function __construct($registry){
            parent::__construct($registry);
        }

        public function import($profile) {
            $profile_data = $this->profile['profile'];
            $this->profile = $profile_data;
            $this->multilanguage = array_key_exists('import_xls_multilanguage', $profile_data) && $profile_data['import_xls_multilanguage'];
            $this->cat_tree =  array_key_exists('import_xls_category_tree', $this->profile) && $this->profile['import_xls_category_tree'];
            $this->product_identificator = array_key_exists('import_xls_product_identificator', $this->profile) ? $this->profile['import_xls_product_identificator'] : 'product_id';
            $this->skip_on_edit = array_key_exists('import_xls_existing_products', $this->profile) && $this->profile['import_xls_existing_products'] == 'skip';
            $this->skip_on_create = array_key_exists('import_xls_new_products', $this->profile) && $this->profile['import_xls_new_products'] == 'skip';
            $this->last_cat_assign = array_key_exists('import_xls_category_tree_last_child', $this->profile) && $this->profile['import_xls_category_tree_last_child'];
            $this->sum_tax_price_on_create =  array_key_exists('import_xls_sum_tax', $this->profile) && $this->profile['import_xls_sum_tax'];
            $this->rest_tax_price_on_create =  array_key_exists('import_xls_rest_tax', $this->profile) && $this->profile['import_xls_rest_tax'];
            $this->strict_update =  $this->profile['import_xls_i_want'] == 'products' && array_key_exists('import_xls_strict_update', $this->profile) && $this->profile['import_xls_strict_update'];
            $this->auto_seo_generator = array_key_exists('import_xls_autoseo_gerator', $this->profile) ? $this->profile['import_xls_autoseo_gerator'] : false;
            $this->load->model('extension/module/ie_pro_database');
            $this->conditional_fields = $this->model_extension_module_ie_pro_database->get_tables_conditional_fields();
            $this->fields_without_main_conditional = $this->model_extension_module_ie_pro_database->get_tables_fields_main_conditional_remove();
            $this->load->model('extension/module/ie_pro_file');
            $this->filename = $this->model_extension_module_ie_pro_file->get_filename();
            $this->file_tmp_path = $this->path_tmp.$this->filename;

            $this->check_download_image_path();

            //<editor-fold desc="Values to conversions">
                $this->load->model('extension/module/ie_pro_manufacturers');
                $this->all_manufacturers_import = $this->model_extension_module_ie_pro_manufacturers->get_all_manufacturers_import_format();
                $this->stock_statuses_import = $this->get_stock_statuses(true);
                $this->tax_classes_import = $this->get_tax_classes(true);
                $this->weight_classes_import = $this->get_classes_weight(true);
                $this->length_classes_import = $this->get_classes_length(true);
                $this->layouts_import = $this->get_layouts(true);
            //</editor-fold>

            $columns = $this->clean_columns($profile_data['columns']);
            $this->columns = $columns;
            $this->conversion_fields = $this->get_conversion_fields($this->columns);
            $this->splitted_values_fields = $this->get_splitted_values_fields($this->columns);
            $this->custom_columns = $this->get_custom_columns($this->columns);

            $tables_info = $this->get_tables_info($this->columns);
            $this->tables_info = $tables_info;

            $elements_to_import = $profile['profile']['import_xls_i_want'];
            if(in_array($elements_to_import, array('specials', 'discounts'))) {
                $this->load->model('extension/module/ie_pro_products');
            }

            $model_name = 'ie_pro_'.$elements_to_import;
            $model_path = 'extension/module/'.$model_name;
            $model_loaded = 'model_extension_module_'.$model_name;
            $this->model_loaded = $model_loaded;
            $this->load->model($model_path);
            $this->{$model_loaded}->set_model_tables_and_fields();

            $format = $this->profile['import_xls_file_format'];
            $model_path = 'extension/module/ie_pro_file_'.$format;
            $model_name = 'model_extension_module_ie_pro_file_'.$format;
            $this->load->model('extension/module/ie_pro_file');
            $this->load->model($model_path);

            if($format != 'spreadsheet')
                $this->model_extension_module_ie_pro_file->upload_file_import();

            $data_file = $this->{$model_name}->get_data();
            if($this->splitted_values_fields != '')
                $data_file = $this->add_splitted_values($data_file);

            if($this->is_t && !empty($data_file['data']))
                $data_file['data'] = array_slice($data_file['data'], 0, $this->is_t_elem);

            $this->check_columns($data_file['columns']);
            $data_file = $this->assign_default_values_to_lost_columns($data_file);
            $data_file = $this->format_data_file($data_file);
            $data_file = $this->{$model_loaded}->pre_import($data_file);

            if(empty($data_file))
                $this->exception($this->language->get('progress_import_error_empty_data'));
            //Call function to translate boolean values, names instead of ids....
            $data_file = $this->conversion_values($data_file);

            /*if($this->splitted_values_fields != '')
                $data_file = $this->splitted_values($data_file);*/

            $this->import_data($data_file);
        }

        public function import_data($data_file) {
            $elements_created = 0;
            $elements_editted = 0;
            $elements_deteled = 0;
            $main_condition = $this->escape_database_field($this->main_field).' = ';

            $this->update_process(sprintf($this->language->get('progress_import_process_start'), '<i class="fa fa-coffee"></i>'));
            $element_to_process = count($data_file);
            $element_processed = 0;
            $this->update_process(sprintf($this->language->get('progress_import_process_imported'), $element_processed, $element_to_process));

            foreach ($data_file as $file_row => $elements) {
                $element_id = $elements[$this->main_table][$this->main_field];
                $main_condition_temp = $main_condition.$this->escape_database_value($element_id);

                $empty_columns = array_key_exists('empty_columns', $elements);
                $delete_element = $empty_columns && array_key_exists('delete', $elements['empty_columns']) && $this->translate_boolean_value($elements['empty_columns']['delete']);
                if($delete_element) {
                    $this->{$this->model_loaded}->delete_element($element_id);
                    $elements_deteled++;
                } else {
                    $creating = $empty_columns && array_key_exists('creating', $elements['empty_columns']) && $elements['empty_columns']['creating'];
                    $elements_created += $creating ? 1 : 0;
                    $editting = $empty_columns && array_key_exists('editting', $elements['empty_columns']) && $elements['empty_columns']['editting'];
                    $elements_editted += $editting ? 1 : 0;
                    unset($elements['empty_columns']);
                    foreach ($elements as $table_name => $fields) {

                        if($this->strict_update && $table_name != $this->main_table) {
                            $temp_conditions = $main_condition_temp;

                            if(in_array($table_name, array('seo_url', 'url_alias')))
                                $temp_conditions = $this->escape_database_field('query').' = '.$this->escape_database_value($this->main_field.'='.$element_id);

                            $this->db->query('DELETE FROM ' . $this->escape_database_table_name($table_name) . ' WHERE ' . $temp_conditions);
                        }

                        if(!empty($fields)) {
                            $conditional_fields = array_key_exists($table_name, $this->conditional_fields) ? $this->conditional_fields[$table_name] : '';

                            $depth = $this->array_depth($fields);

                            if ($depth == 1) $final_fields = array($fields);
                            else $final_fields = $fields;
                            foreach ($final_fields as $row_number => $row) {
                                if(is_array($row) && !empty($row)) {
                                    $table_conditions = $main_condition_temp;
                                    $extra_conditions = '';
                                    if (!empty($conditional_fields)) {
                                        foreach ($conditional_fields as $field_name) {
                                            if (array_key_exists($field_name, $row)) {
                                                $extra_conditions .= ' AND ' . $this->escape_database_field($field_name) . ' = ' . $this->escape_database_value($row[$field_name]);
                                            }
                                        }
                                    }

                                    $fields_no_main_conditional = '';

                                    if (array_key_exists($table_name, $this->fields_without_main_conditional) && array_key_exists($field_name, $this->fields_without_main_conditional[$table_name])) {
                                        if (array_key_exists($field_name, $row)) {
                                            $table_conditions = $this->escape_database_field($field_name) . ' = ' . $this->escape_database_value($row[$field_name]) . $extra_conditions;
                                        }
                                    } else {
                                        $table_conditions .= $extra_conditions;
                                    }

                                    $exist_element = $this->check_element_exist($table_name, $table_conditions);

                                    if (in_array($table_name, $this->tables_with_images) && array_key_exists('image', $row) && !empty($row['image']) && $this->is_url($row['image'])) {
                                        $row['image'] = $this->download_remote_image($table_name, $element_id, $row_number, $row['image']);
                                    }

                                    $sql = $this->get_sql($row, $table_name, $table_conditions, $exist_element);
                                    $this->db->query($sql);
                                    $last_id = $this->db->getLastId();

                                    if ($table_name == 'product_option_value' && !$exist_element) {
                                        $option_id = array_key_exists('option_id', $row) && !empty($row['option_id']) ? $row['option_id'] : '';
                                        if (!empty($option_id)) {
                                            $product_option_id = $this->model_extension_module_ie_pro_option_values->get_product_option_id($element_id, $option_id);
                                            if (!empty($product_option_id)) {

                                                $fields = array(
                                                    'product_option_id' => $product_option_id
                                                );
                                                $conditions_temp = $this->escape_database_field('product_option_value_id') . ' = ' . $this->escape_database_value($last_id);
                                                $sql = $this->get_sql($fields, $table_name, $conditions_temp, true);
                                                $this->db->query($sql);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $element_processed++;
                $this->update_process(sprintf($this->language->get('progress_import_process_imported'), $element_processed, $element_to_process), true);
            }
            $this->update_process($this->language->get('progress_import_applying_changes_safely'));
            $this->db->query("COMMIT");

            $data = array(
                'status' => 'progress_import_import_finished',
                'message' => sprintf($this->language->get('progress_import_finished'), '<i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;', $elements_created, $elements_editted, $elements_deteled)
            );
            $this->update_process($data);

            $this->ajax_die('progress_import_import_finished');
        }

        function format_data_file($data) {
            $columns = $data['columns'];
            $data = $data['data'];

            $this->update_process($this->language->get('progress_import_process_format_data_file'));
            $element_to_process = count($data);
            $element_processed = 0;
            $this->update_process(sprintf($this->language->get('progress_import_process_format_data_file_progress'), $element_processed, $element_to_process));

            $final_data = array();
            foreach ($data as $key => $fields) {
                $temp_data = array();
                foreach ($fields as $col_index => $value) {
                    $column_name = array_key_exists($col_index, $columns) ? $columns[$col_index] : '';
                    if(!empty($column_name) && array_key_exists($column_name, $this->custom_columns)) {
                        $column_data = $this->custom_columns[$column_name];
                        $table = $column_data['table'];
                        $field = $column_data['field'];

                        if(!array_key_exists($table, $temp_data))
                            $temp_data[$table] = array();

                        $identificator = array_key_exists('identificator', $column_data) ? $column_data['identificator'] : '';
                        $store_id = array_key_exists('store_id', $column_data) ? $column_data['store_id'] : '';
                        $language_id = array_key_exists('language_id', $column_data) ? $column_data['language_id'] : '';
                        $default_value = array_key_exists('default_value', $column_data) ? $column_data['default_value'] : '';

                        $value = empty($value) && !empty($default_value) ? $this->sanitize_value($default_value) : $this->sanitize_value($value);

                        if(empty($identificator) && $store_id === '' && empty($language_id)) {
                            $temp_data[$table][$field] = $value;
                        } elseif(!empty($language_id) && $store_id === '' && empty($identificator)) {
                            $temp_data[$table][$language_id][$field] = $value;
                        } elseif($store_id !== '' && empty($language_id) && empty($identificator)) {
                            $temp_data[$table][$store_id][$field] = $value;
                        } elseif(!empty($identificator) && empty($language_id) && $store_id === '') {
                            $levels = explode("_", $identificator);
                            if (count($levels) == 1) {
                                $temp_data[$table][$levels[0]][$field] = $value;
                            } else if (count($levels) == 2) {
                                $temp_data[$table][$levels[0]][$levels[1]][$field] = $value;
                            }
                        } elseif(!empty($language_id) && $store_id !== '' && empty($identificator)) {
                            $temp_data[$table][$store_id][$field][$language_id] = $value;
                        } elseif(!empty($identificator) && !empty($language_id) && $store_id === '') {
                            $levels = explode("_", $identificator);
                            unset($levels[count($levels)-1]);
                            if (count($levels) == 1) {
                                $temp_data[$table][$levels[0]][$field][$language_id] = $value;
                            } else if (count($levels) == 2) {
                                $temp_data[$table][$levels[0]][$levels[1]][$field][$language_id] = $value;
                            }
                        }

                        if(!empty($language_id) && !$this->multilanguage && $this->count_language > 1) {
                            foreach ($this->languages as $key => $lang_info) {

                            }
                        }
                    }
                }

                if(!empty($temp_data))
                    $final_data[] = $temp_data;

                $element_processed++;
                $this->update_process(sprintf($this->language->get('progress_import_process_format_data_file_progress'), $element_processed, $element_to_process), true);
            }

            return $final_data;
        }

        public function assign_default_values_to_lost_columns($elements) {
            $columns_imported = $elements['columns'];
            $columns_expected = array_keys($this->custom_columns);
            $column_lost = array_diff($columns_expected, $columns_imported);

            if(!empty($column_lost)) {
                foreach ($column_lost as $key => $col_nane) {
                    if(array_key_exists($col_nane, $this->custom_columns) && array_key_exists('default_value', $this->custom_columns[$col_nane]) && $this->custom_columns[$col_nane]['default_value'] !== '') {
                        array_push($elements['columns'], $col_nane);
                        $default_value = $this->custom_columns[$col_nane]['default_value'];
                        foreach ($elements['data'] as $row_number => $data) {
                            if(is_array($data))
                                array_push($elements['data'][$row_number], $default_value);
                        }
                    }
                }
            }
            return $elements;
        }

        public function conversion_values($data_file) {

            $this->update_process($this->language->get('progress_import_elements_conversion_start'));
            $element_to_process = count($data_file);
            $element_processed = 0;
            $this->update_process(sprintf($this->language->get('progress_import_elements_converted'), $element_processed, $element_to_process));

            foreach ($data_file as $key => $rows) {
                $creating = array_key_exists('empty_columns', $rows) && array_key_exists('creating', $rows['empty_columns']) && $rows['empty_columns']['creating'];
                $editting = array_key_exists('empty_columns', $rows) && array_key_exists('editting', $rows['empty_columns']) && $rows['empty_columns']['editting'];
                foreach ($rows as $table_name => $fields) {
                    if(!empty($fields)) {
                        $depth = $this->array_depth($fields);
                        if ($depth == 2)
                            $temp = $fields;
                        else
                            $temp = array(0 => $fields);
                        foreach ($temp as $key2 => $row_data) {
                            foreach ($row_data as $field_name => $value) {
                                if (array_key_exists($table_name.'_'.$field_name, $this->conversion_fields)) {
                                    $conv_field_info = $this->conversion_fields[$table_name.'_'.$field_name];
                                    $rule = $conv_field_info['rule'];

                                    $final_val = $value;
                                    if($rule == 'boolean_field') {
                                        $true_value = $conv_field_info['true_value'];
                                        $final_val = $value == $true_value ? 1 : 0;
                                    }

                                    if($rule == 'product_id_identificator' && !empty($value)) {
                                        $field = $conv_field_info['product_id_identificator'];
                                        $temp_val = $this->model_extension_module_ie_pro_products->get_product_id($field, $value);
                                        $temp_val = !$temp_val ? '' : $temp_val;
                                        $final_val = $temp_val;
                                    }

                                    if($rule == 'name_instead_id') {
                                        $conversion_global_var = $conv_field_info['conversion_global_var'].'_import';
                                        $conversion_global_index = $conv_field_info['conversion_global_index'];

                                        if($field_name == 'manufacturer_id')
                                            $value = $value . '_' . $this->default_language_id;

                                        if(is_array($this->{$conversion_global_var}) && array_key_exists($value, $this->{$conversion_global_var})) {
                                            $final_val = $this->{$conversion_global_var}[$value];
                                        }
                                    }

                                    if($rule == 'profit_margin' && $creating && !empty($value) && (float)$value > 0) {
                                        $profit_margin = $conv_field_info['profit_margin'];
                                        $final_val  = $this->add_profit_margin($value, $profit_margin);
                                    }

                                    if ($depth == 2)
                                        $data_file[$key][$table_name][$key2][$field_name] = $final_val;
                                    else
                                        $data_file[$key][$table_name][$field_name] = $final_val;
                                }
                            }
                        }
                    }
                }

                $element_processed++;
                $this->update_process(sprintf($this->language->get('progress_import_elements_converted'), $element_processed, $element_to_process), true);
            }
            return $data_file;
        }

        /*public function splitted_values($data_file) {
            $this->update_process($this->language->get('progress_import_elements_splitted_values_start'));
            $element_to_process = count($data_file);
            $element_processed = 0;
            $this->update_process(sprintf($this->language->get('progress_import_elements_splitted_progress'), $element_processed, $element_to_process));

            foreach ($data_file as $key => $rows) {
                foreach ($rows as $table_name => $fields) {
                    if(!empty($fields)) {
                        $depth = $this->array_depth($fields);
                        if ($depth == 2)
                            $temp = $fields;
                        else
                            $temp = array(0 => $fields);
                        $copy_splitted_values_fields = $this->splitted_values_fields;
                        foreach ($temp as $key2 => $row_data) {
                            foreach ($row_data as $field_name => $value) {
                                if (array_key_exists($table_name.'_'.$field_name, $this->splitted_values_fields)) {
                                    $split_by = $this->splitted_values_fields[$table_name.'_'.$field_name]['symbol'];
                                    $position = $copy_splitted_values_fields[$table_name.'_'.$field_name]['position'];
                                    $copy_splitted_values_fields[$table_name.'_'.$field_name]['position']++;

                                    $temp_splitted_value = explode($split_by, $value);

                                    $final_val = array_key_exists($position, $temp_splitted_value) ? $temp_splitted_value[$position] : '';

                                    if(!empty($final_val)) {
                                        if ($depth == 2)
                                            $data_file[$key][$table_name][$key2][$field_name] = $final_val;
                                        else
                                            $data_file[$key][$table_name][$field_name] = $final_val;
                                    } else {
                                        unset($data_file[$key][$table_name][$key2]);
                                        unset($data_file[$key][$table_name][$field_name]);
                                    }
                                }
                            }
                        }
                    }
                }

                $element_processed++;
                $this->update_process(sprintf($this->language->get('progress_import_elements_splitted_progress'), $element_processed, $element_to_process), true);
            }
            return $data_file;
        }*/

        public function add_splitted_values($data_file) {
            //<editor-fold desc="Add columns">
                foreach ($this->splitted_values_fields as $column_name => $split_info) {
                    $data_file['columns'][] = $column_name;
                }
            //</editor-fold>

            //<editor-fold desc="Add splited values to each element">
                $columns_file = $data_file['columns'];
                foreach ($data_file['data'] as $key => $element) {
                    foreach ($this->splitted_values_fields as $column_name => $split_info) {
                        $custom_name_real = $split_info['custom_name_real'];
                        $index_element = array_search($custom_name_real, $columns_file);
                        $final_value = '';
                        if(is_numeric($index_element) && array_key_exists($index_element, $element) && is_numeric($split_info['position'])) {
                            $value_splited = explode($split_info['symbol'], $element[$index_element]);
                            if(array_key_exists($split_info['position'], $value_splited))
                                $final_value = $value_splited[$split_info['position']];
                        }
                        $data_file['data'][$key][] = $final_value;
                    }
                }
            //</editor-fold>

            //<editor-fold desc="Remove real column names">
                foreach ($this->splitted_values_fields as $column_name => $split_info) {
                    $index_to_delete = array_search($split_info['custom_name_real'], $data_file['columns']);
                    if(is_numeric($index_to_delete)) {
                        unset($data_file['columns'][$index_to_delete]);
                        $data_file['columns'] = array_values($data_file['columns']);

                        foreach ($data_file['data'] as $key => $element) {
                            unset($element[$index_to_delete]);
                            $element = array_values($element);
                            $data_file['data'][$key] = $element;
                        }
                    }
                }
            //</editor-fold>

            return $data_file;
        }

        function process_special_row($config_row, $fields) {
            $config_split = explode('|', $config_row);
            $table = $config_split[1];
            $store_id = $config_split[3];
            $language_id = $config_split[5];
            $identificator = $config_split[7];
            if (!empty($store_id)) $fields['store_id'] = $store_id;
            if (!empty($language_id)) $fields['language_id'] = $language_id;

            return $fields;
        }
        
        function check_download_image_path() {
            $extra_route = array_key_exists('import_xls_download_image_route', $this->profile) && !empty($this->profile['import_xls_download_image_route']) ? $this->profile['import_xls_download_image_route'] : '';
            if(!empty($extra_route) && !is_dir(DIR_IMAGE.$this->image_path.$extra_route)) {
                mkdir(DIR_IMAGE.$this->image_path.$extra_route, 0755, true);
            }
            $this->extra_image_route = !empty($extra_route) ? rtrim($extra_route, '/').'/' : '';
        }
    }
?>