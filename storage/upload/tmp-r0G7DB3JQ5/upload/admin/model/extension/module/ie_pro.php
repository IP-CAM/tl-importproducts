<?php
    class ModelExtensionModuleIePro extends Model {
        public function format_columns_multilanguage_multistore($columns, $lang_fields_skyp = array()) {
            $final_columns = array();

            $languages = $this->languages;

            foreach ($columns as $col_name => $column_info) {
                $multilanguage = $this->count_languages > 1 && array_key_exists('multilanguage', $column_info) && $column_info['multilanguage'];
                $multistore = array_key_exists('multistore', $column_info) && $column_info['multistore'];
                $column_info['conditions'] = array();
                $hidden_fields = $column_info['hidden_fields'];
                $table = array_key_exists('table', $hidden_fields) ? $hidden_fields['table'] : '';
                $field = array_key_exists('field', $hidden_fields) ? $hidden_fields['field'] : '';

                if(!$multilanguage || in_array($col_name, $lang_fields_skyp)) {
                    if($multistore) {
                        foreach ($this->stores_import_format as $store) {
                            $final_name = $col_name . ' ' . $store['store_id'];
                            $new_column = $this->change_column_name($column_info, $final_name);
                            $new_column['hidden_fields']['store_id'] = $store['store_id'];

                            if(array_key_exists('identificator', $hidden_fields))
                                $new_column['hidden_fields']['identificator'] .= '_'.$store['store_id'];

                            if(array_key_exists('multilanguage', $new_column)) {
                                $new_column['hidden_fields']['conditions'][] = 'language_id = ' . $this->default_language_id;
                                $new_column['hidden_fields']['language_id'] = $this->default_language_id;
                                if(array_key_exists('identificator', $hidden_fields))
                                    $new_column['hidden_fields']['identificator'] .= '_'.$this->default_language_id;
                            }

                            $final_columns[$final_name] = $new_column;
                        }

                    }
                    else {
                        if(array_key_exists('multilanguage', $column_info)) {
                            $skip_conditions = !$this->is_ocstore && $table == 'manufacturer';
                            if(!$skip_conditions)
                                $column_info['hidden_fields']['conditions'][] = 'language_id = ' . $this->default_language_id;
                            $column_info['hidden_fields']['language_id'] = $this->default_language_id;
                            if(array_key_exists('identificator', $hidden_fields))
                                $column_info['hidden_fields']['identificator'] .= '_'.$this->default_language_id;
                            if(array_key_exists('multistore', $column_info) && $column_info['multistore'])
                                $new_column['hidden_fields']['store_id'] = 0;
                        }
                        $final_columns[$col_name] = $column_info;
                    }
                }
                else
                {
                    foreach ($languages as $key2 => $lang) {
                        if($multistore){
                            foreach ($this->stores_import_format as $store) {
                                $final_name = $col_name.' '.$store['store_id'].' '.$lang['code'];
                                $new_column = $this->change_column_name($column_info, $final_name);
                                $new_column['hidden_fields']['conditions'][] = 'store_id = '.$store['store_id'];
                                $new_column['hidden_fields']['conditions'][] = 'language_id = '.$lang['language_id'];
                                $new_column['hidden_fields']['language_id'] = $lang['language_id'];
                                $new_column['hidden_fields']['store_id'] = $store['store_id'];

                                if(array_key_exists('identificator', $hidden_fields))
                                    $new_column['hidden_fields']['identificator'] .= '_'.$new_column['store_id'].'_'.$lang['language_id'];

                                $final_columns[$final_name] = $new_column;
                            }
                        } else {
                            $final_name = $col_name.' '.$lang['code'];
                            $new_column = $this->change_column_name($column_info, $final_name);
                            $new_column['hidden_fields']['language_id'] = $lang['language_id'];
                            $new_column['hidden_fields']['conditions'][] = 'language_id = '.$lang['language_id'];
                            if(array_key_exists('identificator', $hidden_fields))
                                $new_column['hidden_fields']['identificator'] .= '_'.$lang['language_id'];
                            if(array_key_exists('multistore', $column_info) && $column_info['multistore'])
                                $new_column['hidden_fields']['store_id'] = 0;
                            $final_columns[$final_name] = $new_column;
                        }
                    }
                }
            }

            $columns = $final_columns;
            return $columns;
        }

        public function change_column_name($col_info, $new_name) {
            $col_info['hidden_fields']['name'] = $new_name;
            $col_info['custom_name'] = $new_name;
            return $col_info;
        }
        
        public function format_column_name($col_name) {
            $col_name_format = str_replace(' ', '_', $col_name);
            $col_name_format = str_replace('-', '_', $col_name_format);
            $col_name_format = str_replace('.', '', $col_name_format);
            $col_name_format = str_replace('*', '', $col_name_format);
            $col_name_format = str_replace('(', '', $col_name_format);
            $col_name_format = str_replace(')', '', $col_name_format);
            $col_name_format = strtolower($col_name_format);

            return $col_name_format;
        }
        
        public function get_legible_database_field_name($string) {
            $string = str_replace('_', ' ', $string);
            $string = ucfirst($string);
            return $string;
        }

        public function get_remodal($modal_id, $title, $description, $options = array()) {
            $open_on_ready = array_key_exists('open_on_ready', $options) && $options['open_on_ready'];
            $button_close = !array_key_exists('button_close', $options) || (array_key_exists('button_close', $options) && $options['button_close']);
            $button_confirm_text = array_key_exists('button_confirm_text', $options) && !empty($options['button_confirm_text']) ? $options['button_confirm_text'] : $this->language->get('remodal_button_confirm_text');
            $button_cancel_text = array_key_exists('button_cancel_text', $options) && !empty($options['button_cancel_text']) ? $options['button_cancel_text'] : $this->language->get('remodal_button_cancel_text');
            $open_on_ready = array_key_exists('open_on_ready', $options) && $options['open_on_ready'];
            $button_confirm = !array_key_exists('button_confirm', $options) || (array_key_exists('button_confirm', $options) && $options['button_confirm']);
            $button_cancel = !array_key_exists('button_cancel', $options) || (array_key_exists('button_cancel', $options) && $options['button_cancel']);
            $remodal_options = array_key_exists('remodal_options', $options) && !empty($options['remodal_options']) ? $options['remodal_options'] : '';
            $subtitle = array_key_exists('subtitle', $options) && !empty($options['subtitle']) ? $options['subtitle'] : '';
            $link = array_key_exists('link', $options) && !empty($options['link']) ? $this->language->get($options['link']) : '';

            $remodal_html = '';
            if($link) {
                $remodal_html .= '<a href="javascript:{}" data-remodal-target="'.$modal_id.'">'.$link.'</a>';
            }
            $remodal_html .= '
                <div class="remodal '.$modal_id.'" data-remodal-id="'.$modal_id.'"'.($remodal_options ? ' data-remodal-options="'.$remodal_options.'"' : '').'>
                    '.($button_close ? '<button data-remodal-action="close" class="remodal-close"></button>' : '').'
                    <h1>'.$title.'</h1>
                    '.(!empty($subtitle) ? '<h2>'.$subtitle.'</h2>' : '').'
                    <div class="remodal_content">'.$description.'</div>
                    <br>
                    '.($button_cancel ? '<button data-remodal-action="cancel" class="remodal-cancel">'.$button_cancel_text.'</button>' : '').'
                    '.($button_confirm ? '<button data-remodal-action="confirm" class="remodal-confirm">'.$button_confirm_text.'</button>' : '').'
                </div>
            ';

            if($open_on_ready) {
                $remodal_options = !empty($remodal_options) ? '{'.$remodal_options.'}' : '';
                $remodal_html .= '<script type="text/javascript">var inst = $(\'[data-remodal-id='.$modal_id.']\').remodal('.$remodal_options.');inst.open();</script>';
            }

            return $remodal_html;
        }

        public function clean_array_extension_prefix($array) {
            $new_array = array();
            foreach ($array as $key => $val) {
                $new_key = str_replace($this->extension_group_config.'_', '', $key);
                $new_array[$new_key] = $val;
            }
            return $new_array;
        }

        public function get_stores_import_format() {
            $this->load->model('setting/store');
			$stores = array();
			$stores[0] = array(
				'store_id' => '0',
				'name' => $this->config->get('config_name')
			);

			$stores_temp = $this->model_setting_store->getStores();
			foreach ($stores_temp as $key => $value) {
				$stores[] = $value;
			}
			return $stores;
        }

        public function validate_permiss() {
            if (!$this->user->hasPermission('modify', $this->real_extension_type.'/'.$this->extension_name)) {
                if(!empty($this->request->post['no_exit']))
                {
                    $array_return = array(
                        'error' => true,
                        'message' => $this->language->get('error_permission')
                    );
                    echo json_encode($array_return); die;
                }
                else
                    throw new Exception($this->language->get('error_permission'));

                return false;
            }
            return true;
        }

        public function format_default_column($col_name, $column_info, $from_profile = false, $format_custom_name = false) {
            $column_info['hidden_fields'] = array_key_exists('hidden_fields', $column_info) ? $column_info['hidden_fields'] : array();
            $column_info['hidden_fields']['name'] = $col_name;
            if(!$from_profile) {
                $column_info['custom_name'] = $format_custom_name ? $this->format_column_name($col_name) : $col_name;
                $column_info['status'] = 1;
            } else {
                $col_custom_name = array_key_exists('custom_name', $column_info) && !empty($column_info['custom_name']) ? $column_info['custom_name'] : $col_name;
                $column_info['custom_name'] = $format_custom_name ? $this->format_column_name($col_custom_name) : $col_custom_name;
                $column_info['status'] = array_key_exists('status', $column_info) ? $column_info['status'] : 0;
            }
            return $column_info;
        }

        public function escape_database_field($name) {
            return "`".$name."`";
        }
        public function escape_database_value($value) {
            return "'".$this->db->escape($value)."'";
        }
        public function escape_database_table_name($name) {
            return "`".$this->db_prefix.$name."`";
        }
        public function sanitize_value($value) {
            return trim(htmlspecialchars_decode($value));
        }

        public function set_model_tables_and_fields($special_tables = array(), $special_tables_description = array(), $delete_tables = array()) {
            if($this->profile['profile_type'] == 'export')
                array_push($special_tables, 'empty_columns');
            $this->special_tables = $special_tables;
            $this->delete_tables = $delete_tables;
            $this->special_tables_description = $special_tables_description;
        }

        public function get_columns($configuration) {
            $configuration = $this->clean_array_extension_prefix($configuration);
            $profile_id = array_key_exists('profile_id', $configuration) && !empty($configuration['profile_id']) ? $configuration['profile_id'] : '';
            //$multilanguage = array_key_exists('multilanguage', $configuration) ? $configuration['multilanguage'] : $this->count_languages > 1;
            $multilanguage = true;

            $columns = $this->get_columns_formatted($multilanguage);
            $columns = $this->format_columns_multilanguage_multistore($columns);

            if(!empty($profile_id)) {
                $col_map = $this->model_extension_module_ie_pro_tab_profiles->get_columns($configuration);
                foreach ($columns as $col_name => $col_info) {
                    if(!array_key_exists($col_name, $col_map)) {
                        $col_info['status'] = 0;
                        $col_map[$col_name] = $col_info;
                    }
                }
                $columns = $col_map;
            }
            
            $final_columns = array();

            foreach ($columns as $col_name => $col_info)
                $final_columns[$col_name] = $this->format_default_column($col_name, $col_info, !empty($profile_id), $configuration['file_format'] == 'xml' && empty($profile_id));

            return $final_columns;
        }

        public function remove_tables($database_schema, $tables) {
            $final_tables = array();
            $real_tables = array_keys($database_schema);

            foreach ($tables as $key => $table_name) {
                if(in_array($table_name, $real_tables))
                    $final_tables[] = $table_name;
            }

            return $final_tables;
        }
        
        public function check_columns($columns_from_file) {
            $some_column_found = false;
            foreach ($columns_from_file as $key => $col_name) {
                if(array_key_exists($col_name, $this->custom_columns)) {
                    if($this->custom_columns[$col_name]['field'] != 'delete') {
                        $some_column_found = true;
                        break;
                    }
                }
            }

            if(!$some_column_found) {
                $custom_columns = array();
                foreach ($this->custom_columns as $col_name => $col_info) {
                    $custom_columns[] = $col_name;
                }

                $html_custom_columns = '<ul><li>'.implode("</li><li>", $custom_columns).'</ul>';
                $html_columns = '<ul><li>'.implode("</li><li>", $columns_from_file).'</ul>';
                $this->exception(sprintf($this->language->get('progress_import_error_columns'), $html_columns, $html_custom_columns));
            }
        }

        public function get_custom_columns($columns) {
            $final_columns = array();
            foreach ($columns as $key => $col_info) {
                $final_columns[$col_info['custom_name']] = $col_info;
            }
            return $final_columns;
        }

        public function get_conversion_fields($columns) {
            $fields = array();

            foreach ($columns as $key => $col_info) {

                $index = $col_info['table'].'_'.$col_info['field'];

                if(array_key_exists('name_instead_id', $col_info) && $col_info['name_instead_id']) {
                    $temp = array(
                        'rule' => 'name_instead_id',
                        'conversion_global_var' => $col_info['conversion_global_var'],
                        'conversion_global_index' => array_key_exists('conversion_global_index', $col_info) ? $col_info['conversion_global_index'] : '',
                    );
                    $fields[$index] = $temp;
                }

                if(array_key_exists('true_value', $col_info)) {
                    $temp = array(
                        'rule' => 'boolean_field',
                        'true_value' => $col_info['true_value'],
                        'false_value' => $col_info['false_value'],
                    );
                    $fields[$index] = $temp;
                }

                if(array_key_exists('product_id_identificator', $col_info) && $col_info['product_id_identificator'] && $col_info['product_id_identificator'] != 'product_id') {
                    $temp = array(
                        'rule' => 'product_id_identificator',
                        'product_id_identificator' => $col_info['product_id_identificator'],
                    );
                    $fields[$index] = $temp;
                }

                if(array_key_exists('profit_margin', $col_info) && !empty($col_info['profit_margin']) && is_numeric($col_info['profit_margin'])) {
                    $temp = array(
                        'rule' => 'profit_margin',
                        'profit_margin' => $col_info['profit_margin'],
                    );
                    $fields[$index] = $temp;
                }
            }

            return $fields;
        }

        public function get_splitted_values_fields($columns) {
            $fields = array();

            foreach ($columns as $key => $col_info) {
                if(array_key_exists('splitted_values', $col_info) && $col_info['splitted_values']) {
                    $fields[$col_info['custom_name']] = array(
                        'custom_name' => $col_info['custom_name'],
                        'custom_name_real' => explode('>', $col_info['custom_name'])[0],
                        'position' => explode('>', $col_info['custom_name'])[1],
                        'table' => $col_info['table'],
                        'field' => $col_info['field'],
                        'symbol' => $col_info['splitted_values'],
                    );
                }
            }

            return empty($fields) ? '' : $fields;
        }

        public function add_profit_margin($price, $margin) {
            $multiplicator = ($margin/100) + 1;
            $price *= $multiplicator;
            return $price;
        }
        
        public function format_column_names($columns) {
            foreach ($columns as $column_name => $column_info) {
                $col_name_formatted = $this->format_column_name($column_name);
                $columns[$column_name]['custom_name'] = $col_name_formatted;
            }
            return $columns;
        }

        public function from_camel_case($input) {
            preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
            $ret = $matches[0];
            foreach ($ret as &$match) {
                $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
            }
            return implode('_', $ret);
        }

        public function select_constructor($select_name, $values, $value, $extra = array()) {
            $onchange = array_key_exists('onchange', $extra) ? ' onchange="'.$extra['onchange'].'" ' : '';
            $class = array_key_exists('class', $extra) ? ' class="'.$extra['class'].'" ' : '';

            $select = '<select name="'.$select_name.'"'.$class.$onchange.'data-live-search="true">';
                foreach ($values as $option_value => $option_name) {
                    $select .= '<option '.($value == $option_value ? 'selected="selected"' : '').' value="'.$option_value.'">'.$option_name.'</option>';
                }
            $select .= '</select>';

            return $select;
        }

        public function check_element_exist($table, $conditions) {
            $query = "SELECT * FROM ".$this->escape_database_table_name($table).' WHERE '.$conditions.' LIMIT 1';
            $result = $this->db->query($query);

            return $result->num_rows;
        }

        public function get_sql($fields, $table, $conditions, $update) {
            $sql = '';
            if($update) {
                $sql .= "UPDATE " . $this->escape_database_table_name($table) . ' SET ';

                foreach ($fields as $field_name => $value) {
                    if($this->check_field_exists($this->database_schema, $table, $field_name)) {
                        $value = $this->format_value_by_type($table, $field_name, $value);
                        $sql .= $this->escape_database_field($field_name) . ' = ' . $this->escape_database_value($value) . ', ';
                    }
                }
                $sql = rtrim($sql, ', ')." WHERE " . $conditions;
            }
            else {
                $sql .= "INSERT INTO " . $this->escape_database_table_name($table);
                $fields_temp = $values_temp = array();
                foreach ($fields as $field_name => $value) {
                    if($this->check_field_exists($this->database_schema, $table, $field_name)) {
                        $value = $this->format_value_by_type($table, $field_name, $value);
                        $fields_temp[] = $this->escape_database_field($field_name);
                        $values_temp[] = $this->escape_database_value($value);
                    }
                }

                $sql .= ' ('.implode(", ", $fields_temp).') VALUES ('.implode(", ", $values_temp).')';
            }


            if($update && empty($conditions))
                $this->exception(sprintf($this->language->get('progress_import_error_updating_conditions'), $sql));

            return $sql;
        }

        public function check_field_exists($database_schema, $table, $field) {
            return array_key_exists($table, $database_schema) && array_key_exists($field, $database_schema[$table]);
        }

        public function format_value_by_type($table, $field, $value) {
            $type = array_key_exists($table, $this->database_field_types) && array_key_exists($field, $this->database_field_types[$table]) && array_key_exists('type', $this->database_field_types[$table][$field]) ? $this->database_field_types[$table][$field]['type'] : '';

            if(!empty($type)) {
                if($type == 'boolean')
                    $value = $this->translate_boolean_value($value);
            }
            return $value;
        }

        public function pre_import($data_file) {
            $id_assigned_count = 1;

            $this->update_process($this->language->get('progress_import_elements_process_start'));
            $element_to_process = count($data_file);
            $element_processed = 0;
            $this->update_process(sprintf($this->language->get('progress_import_elements_processed'), $element_processed, $element_to_process));

            foreach ($data_file as $row_file_num => $fields_tables) {
                $creating = $editting = false;
                $element_id = array_key_exists($this->main_table, $fields_tables) && array_key_exists($this->main_field, $fields_tables[$this->main_table]) && !empty($fields_tables[$this->main_table][$this->main_field]) ? $fields_tables[$this->main_table][$this->main_field] : '';

                if(empty($element_id) && array_key_exists($this->main_table, $fields_tables) && array_key_exists($this->main_table, $this->conditional_fields)) {
                    $element_id = $this->find_element_id_by_conditional_fields($fields_tables[$this->main_table], $this->conditional_fields[$this->main_table], $this->main_table, $this->main_field);
                    if(!empty($element_id) && array_key_exists($this->main_table, $fields_tables)) {
                        $fields_tables[$this->main_table][$this->main_field] = $element_id;
                    }
                }

                if(empty($element_id)) {
                    $creating = true;
                    $element_id = $this->assign_element_id($id_assigned_count);
                    $id_assigned_count++;
                } else {
                    $element_exist = $this->check_element_exist($this->main_table, $this->escape_database_field($this->main_field).' = '.$this->escape_database_value($element_id));
                    if($element_exist)
                        $editting = true;
                    else
                        $creating = true;
                }

                foreach ($fields_tables as $table_name => $data) {
                    if((!$this->special_tables || (!in_array($table_name, $this->special_tables))) && $table_name != 'empty_columns') {
                        $array_depth = $this->array_depth($data_file[$row_file_num][$table_name]);
                        if($array_depth == 1)
                            $data_file[$row_file_num][$table_name][$this->main_field] = $element_id;
                        else {
                            foreach ($data_file[$row_file_num][$table_name] as $key => $data2) {
                                $data_file[$row_file_num][$table_name][$key][$this->main_field] = $element_id;
                            }
                        }
                    }

                    if(in_array($table_name, $this->special_tables_description))
                        $data_file[$row_file_num][$table_name] = $this->add_language_id_table_description($data_file[$row_file_num][$table_name], $element_id);
                }

                if(!array_key_exists('empty_columns', $data_file[$row_file_num]))
                    $data_file[$row_file_num]['empty_columns'] = array();

                $data_file[$row_file_num]['empty_columns']['creating'] = $creating;
                $data_file[$row_file_num]['empty_columns']['editting'] = $editting;

                $element_processed++;
                $this->update_process(sprintf($this->language->get('progress_import_elements_processed'), $element_processed, $element_to_process), true);
            }

            return $data_file;
        }

        public function add_language_id_table_description($descriptions, $element_id) {
            $final_descriptions = array();
            if(!empty($descriptions) && is_array($descriptions)) {
                foreach ($descriptions as $language_id => $fields) {
                    $some_data = array_filter($fields);

                    if(!empty($some_data)) {
                        $fields['language_id'] = $language_id;
                        $fields[$this->main_field] = $element_id;
                        $final_descriptions[] = $fields;
                    }

                }
            }
            return $final_descriptions;
        }

        public function find_element_id_by_conditional_fields($data, $conditional_fields, $table, $main_field) {
            $condition = '';
            foreach ($conditional_fields as $key => $field) {
                $value = array_key_exists($field, $data) ? $data[$field] : '';
                if(!empty($value)) {
                    $condition .= $this->escape_database_field($field).' = '.$this->escape_database_value($value).' AND ';
                }
            }

            if(!empty($condition)) {
                $condition = rtrim($condition, ' AND ');
                $sql = "SELECT ".$this->escape_database_field($main_field)." FROM ".$this->escape_database_table_name($table)." WHERE ".$condition.' LIMIT 1';
                $result = $this->db->query($sql);
                return !empty($result->row) ? $result->row[$main_field] : false;
            }
            return false;
        }
        public function put_type_to_columns_formatted($columns_formated) {
            foreach ($columns_formated as $col_name => $field_info) {
                if(array_key_exists('hidden_fields', $field_info)) {
                    $table = array_key_exists('table', $field_info['hidden_fields']) ? $field_info['hidden_fields']['table'] : '';
                    $field = array_key_exists('field', $field_info['hidden_fields']) ? $field_info['hidden_fields']['field'] : '';

                    if (!empty($table)
                        && !empty($field)
                        && array_key_exists($table, $this->database_field_types)
                        && array_key_exists($field, $this->database_field_types[$table])
                    ) {
                        if (array_key_exists('type', $this->database_field_types[$table][$field]) && $field != 'image') {
                            $type = $this->database_field_types[$table][$field]['type'];
                            if ($type == 'boolean') {
                                $columns_formated[$col_name]['hidden_fields']['is_boolean'] = true;
                            }
                        } else if ($field == 'image') {
                            $columns_formated[$col_name]['hidden_fields']['is_image'] = true;
                        }
                    }
                }
            }

            return $columns_formated;
        }

        public function download_remote_image($table_name, $element_id, $row_number, $image_url) {
            $multiple_images = false;
            if($table_name == 'option_value')
                $table_name = 'option-value';
            elseif($table_name == 'product_image') {
                $table_name = 'product_image';
                $multiple_images = true;
            }

            $img_temp = preg_replace('/\?.*/', '', $image_url);
            $ext = pathinfo($img_temp, PATHINFO_EXTENSION);

            $image_name = $table_name.'-'.$element_id.($multiple_images ? '-'.($row_number+1):'').'.'.$ext;

            if(strpos($image_url, 'dropbox') !== false) {
			    $image_url = preg_replace('/\?.*/', '', $image_url);
			    $image_url = str_replace('www', 'dl', $image_url);
            } else
                $image_url = preg_replace("/\?.*$/", "", $image_url);

            try {
                copy($image_url, DIR_IMAGE.$this->image_path.$this->extra_image_route.$image_name);
            } catch (Exception $e) {
                return '';
            }

            return $this->image_path.$this->extra_image_route.$image_name;
        }

        //Generic function to delete elements from normal tables
        public function delete_element($element_id) {
            $sql = "DELETE FROM ".$this->escape_database_table_name($this->main_table).' WHERE '.$this->escape_database_field($this->main_field).' = '.$this->escape_database_value($element_id).'; ';
            $this->db->query($sql);
            foreach ($this->delete_tables as $key => $table_name) {
                $sql = "DELETE FROM ".$this->escape_database_table_name($table_name).' WHERE '.$this->escape_database_field($this->main_field).' = '.$this->escape_database_value($element_id).'; ';
                $this->db->query($sql);
            }
        }

        function assign_element_id($main_counter_ids) {
            $sql = "SELECT ".$this->escape_database_field($this->main_field)." FROM ".$this->escape_database_table_name($this->main_table)." ORDER BY ".$this->escape_database_field($this->main_field).' DESC LIMIT 1';
            $result = $this->db->query($sql);
            return !empty($result->row[$this->main_field]) ? (int)$result->row[$this->main_field] + $main_counter_ids : $main_counter_ids;
        }

        function array_depth(array $array) {
            $max_depth = 1;
            foreach ($array as $value) {
                if (is_array($value)) {
                    $depth = $this->array_depth($value) + 1;

                    if ($depth > $max_depth) {
                        $max_depth = $depth;
                    }
                }
            }
            return $max_depth;
        }


        public function exception($message) {
            throw new Exception($message);
        }

        public function ajax_die($message, $error = true) {
            $array_return = array();
            $array_return['error'] = $error;
            $array_return['message'] = $message;
            echo json_encode($array_return); die;
        }

        public function clean_columns($columns) {
            foreach ($columns as $key => $col) {
                if(!array_key_exists('status', $col) || !$col['status'])
                    unset($columns[$key]);
                else {
                    $internal_configuration = json_decode(str_replace("'", '"', $col['internal_configuration']), true);
                    
                    foreach ($internal_configuration as $input_name => $value)
                        $columns[$key][$input_name] = $value;

                    if($this->profile['profile_type'] == 'import' && !$this->is_ocstore && $columns[$key]['table'] == 'manufacturer' && $columns[$key]['field'] == 'name') {
                        unset($columns[$key]['language_id']);
                        unset($columns[$key]['conditions']);
                    }

                    unset($columns[$key]['internal_configuration']);

                    if(empty($col['custom_name']))
                        $columns[$key]['custom_name'] = $col['name'];
                }
            }

            return $columns;
        }

        public function is_special_xml_name($elemen_name) {
            return preg_match("/(\>|\*|\@)/s", $elemen_name);
        }

        public function get_tables_info($colums) {
            $tables_info = array();
            foreach ($colums as $key => $col) {
                $table_name = $col['table'];
                if(!array_key_exists($table_name, $tables_info)) {
                    $tables_info[$table_name] = array(
                        'language_id' => false,
                        'store_id' => false,
                        'customer_group_id' => false,
                        'conditions' => false,
                        'identificator' => false,
                    );

                    if(array_key_exists('language_id', $col) && !empty($col['language_id']))
                         $tables_info[$table_name]['language_id'] = true;
                    if(array_key_exists('store_id', $col) && !empty($col['store_id']))
                         $tables_info[$table_name]['store_id'] = true;
                    if(array_key_exists('customer_group_id', $col) && !empty($col['customer_group_id']))
                         $tables_info[$table_name]['customer_group_id'] = true;
                    if(array_key_exists('conditions', $col) && !empty($col['conditions']))
                         $tables_info[$table_name]['conditions'] = $col['conditions'];
                    if(array_key_exists('identificator', $col) && !empty($col['identificator']))
                         $tables_info[$table_name]['identificator'] = $col['identificator'];
                }
            }

            return $tables_info;
        }

        public function get_stock_statuses($import_format = false) {
			$sql = "SELECT * FROM ".$this->escape_database_table_name('stock_status')." WHERE language_id = ".(int)$this->default_language_id.";";
			$result = $this->db->query( $sql );
			$stock_statuses = $result->rows;
			$final_statuses = array();
			foreach ($stock_statuses as $key => $status) {
			    if(!$import_format)
			        $final_statuses[$status['stock_status_id']] = $status;
			    else
                    $final_statuses[$status['name']] = $status['stock_status_id'];
			}
			if(!$import_format) {
                $stock_statuses = $this->model_extension_devmanextensions_tools->aasort($final_statuses, 'name');
                return $stock_statuses;
            } else {
			    return $final_statuses;
            }
		}

		public function get_classes_length($import_format = false) {
            $this->load->model('localisation/length_class');
            $length_classes = $this->model_localisation_length_class->getLengthClasses();
            $final_length_classes = array();
            $config = $this->config->get('config_length_class_id');
            foreach ($length_classes as $key => $class_length) {
                $id = $class_length['length_class_id'];
                if($config == $id)
                    $class_length['default'] = true;

                if(!$import_format)
                    $final_length_classes[$id] = $class_length;
                else
                    $final_length_classes[$class_length['title']] = $id;
            }
            return $final_length_classes;
        }

        public function get_layouts($import_format = false) {
            $this->load->model('design/layout');
            $layouts_temp = $this->model_design_layout->getLayouts();
            $layouts = array();
            foreach ($layouts_temp as $key => $layout) {
                if(!$import_format)
                    $layouts[$layout['layout_id']] = $layout['name'];
                else
                    $layouts[$layout['name']] = $layout['layout_id'];
            }
            return $layouts;
        }

        public function get_tax_classes($import_format = false) {
            $this->load->model('localisation/tax_class');
            $this->load->model('localisation/tax_rate');
            $tax_clases = $this->model_localisation_tax_class->getTaxClasses(array('order' => 'ASC'));
            $final_tax = array();

            if(version_compare(VERSION, '1.5.1', '>'))
            {
                foreach ($tax_clases as $key => $tax_class) {
                    $tax_rules = $this->model_localisation_tax_class->getTaxRules($tax_class['tax_class_id']);

                    foreach ($tax_rules as $key2 => $tax_rule) {
                        if($tax_rule['based'] == 'store')
                        {
                            $tax_rate = $this->model_localisation_tax_rate->getTaxRate($tax_rule['tax_rate_id']);
                            $tax_clases[$key]['rule'] = $tax_rate;
                        }
                    }
                }
            }
            else
            {
                foreach ($tax_clases as $key => $tax_class) {
                    $tax_rate = $this->model_localisation_tax_class->getTaxRates($tax_class['tax_class_id']);
                    $tax_clases[$key]['rule'] = $tax_rate;
                }
            }

            foreach ($tax_clases as $key => $tax_class) {
                if(!$import_format)
                    $final_tax[$tax_class['tax_class_id']] = $tax_class;
                else
                    $final_tax[$tax_class['title']] = $tax_class['tax_class_id'];
            }
            return $final_tax;
        }

        public function get_classes_weight($import_format = false) {
            $this->load->model('localisation/weight_class');
            $weight_classes = $this->model_localisation_weight_class->getWeightClasses();
            $final_weight_classes = array();
            $config = $this->config->get('config_weight_class_id');
            foreach ($weight_classes as $key => $class_weight) {
                $id = $class_weight['weight_class_id'];
                if($config == $id)
                    $class_weight['default'] = true;

                if(!$import_format)
                    $final_weight_classes[$id] = $class_weight;
                else
                    $final_weight_classes[$class_weight['title']] = $id;
            }
            return $final_weight_classes;
        }

        public function price_tax_calculate($product_id, $price, $operation, $force_tax_class_id = false) {
            $tax_class_id = !empty($force_tax_class_id) ? $force_tax_class_id : $this->model_extension_module_ie_pro_products->get_product_field($product_id,'tax_class_id');
            if(is_numeric($tax_class_id)) {
                $tax = array_key_exists((int)$tax_class_id, $this->tax_classes) ? $this->tax_classes[$tax_class_id] : '';
                if(!empty($tax) && array_key_exists('rule', $tax)) {
                    $rule = $tax['rule'];
                    $type = $rule['type'];
                    $rate = $rule['rate'];

                    $tax_price = $type == 'F' ? $rate : (($price*(100-$rate)) / 100);
                    $price = $operation == 'sum' ? ($price + $tax_price) : ($price - $tax_price);
                }
            }

            return $price;
        }

        public function _exception($error) {
            throw new Exception($error);
        }

        public function format_seo_url($string) {
            $string = trim($string); // Trim String
            $string = strtolower($string); //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
            $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);  //Strip any unwanted characters
            $string = preg_replace("/[\s-]+/", " ", $string); // Clean multiple dashes or whitespaces
            $string = preg_replace("/[\s_]/", "-", $string); //Convert whitespaces and underscore to dash
            return $string;
        }

        function is_url($string) {
            return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $string);
        }

        public function create_progress_file() {
            if(!is_dir($this->path_progress)) {
                mkdir($this->path_progress, 0755);
            }

            $htaccess_file = $this->path_progress . '.htaccess';
            if (!file_exists($htaccess_file)) {
                $htaccess = 'AddType text/iepro iepro
                    <FilesMatch "\.(json|xlsx|ods|xml|xls|txt|iepro)$">
                        allow from all
                    </FilesMatch>';
                file_put_contents($htaccess_file, $htaccess);
            }

            if(!is_dir($this->path_tmp))
                mkdir($this->path_tmp, 0755);

            //$fp = fopen($this->path_progress_file, 'w');
            file_put_contents($this->path_progress_file, '[]');

            return true;
        }

        function update_process($data, $replace_last_line = false) {
            $data = is_string($data) ? array('message' => $data) : $data;
            $continue = array_key_exists('continue', $data) ? $data['continue'] : true;
            $status = array_key_exists('status', $data) ? $data['status'] : '';
            $message = array_key_exists('message', $data) ? $data['message'] : $this->language->get($status);
            $redirect = array_key_exists('redirect', $data) ? $data['redirect'] : '';

            switch ($status) {
                case 'progress_import_import_finished':
                    $continue = false;
                    $message = '<div class="alert alert-success">'.$message.'</div>';
                break;
                case 'progress_export_finished':
                    $continue = false;
                    $message = '<div class="alert alert-success">'.$message.'</div>';
                break;
                case 'error':
                    $continue = false;
                    $message = '<div class="alert alert-danger">'.$message.'</div>';
                break;
                default:
                    $message = date('Y-m-d H:i:s').' - '.$message;
                break;
            }


            $content = file_get_contents($this->path_progress_file);
            $content_array = json_decode($content, true);

            $content_array['continue'] = $continue;
            $content_array['status'] = $status;
            $content_array['redirect'] = $redirect;

            if (!array_key_exists('message', $content_array))
                $content_array['message'] = array();

            if ($replace_last_line)
                array_pop($content_array['message']);

            $content_array['message'][] = $message;

            file_put_contents($this->path_progress_file, json_encode($content_array));

            if(!$this->is_cron_task && in_array($status, array('error'))) {
                echo json_encode($content_array); die;
            }

            if($this->is_cron_task) {
                if(in_array($status, array('error')) || !$continue) {
                    echo implode('<br>', $content_array['message']);
                    echo '<br><br>----------------<br><br>';
                    $this->model_extension_module_ie_pro_tab_crons->email_report($content_array['message']);
                    die('<b>Finished!</b>');
                }
            }
            return true;
        }

        function cancel_process($error) {
            $params = array(
                'message' => $error,
                'status' => 'error'
            );

            $this->update_process($params);
        }

        function translate_boolean_value($value) {
            $value = strtolower($value);

            $true_values = array(1, 'true', 'yes');
            if(in_array($value, $true_values))
                return true;

            return false;
        }

        function fatalErrorShutdownHandler()
        {
            $last_error = error_get_last();
            if(is_array($last_error)) {
                $code = array_key_exists('code', $last_error) ? $last_error['code'] : '';
                $type = array_key_exists('type', $last_error) ? $last_error['type'] : '';
                $message = array_key_exists('message', $last_error) ? $last_error['message'] : '';
                $file = array_key_exists('file', $last_error) ? str_replace(DIR_APPLICATION, '', $last_error['file']) : '';
                $line = array_key_exists('line', $last_error) ? $last_error['line'] : '';

                $final_message = '<ul>';
                $final_message .= !empty($code) ? '<li><b>Error code:</b> ' . $code . '</li>' : '';
                $final_message .= !empty($file) ? '<li><b>Error file:</b> ' . $file . '</li>' : '';
                $final_message .= !empty($line) ? '<li><b>Error line:</b> ' . $line . '</li>' : '';
                $final_message .= !empty($message) ? '<li><b>Error message:</b> ' . $message . '</li>' : '';
                $final_message .= '</ul>';

                $data = array(
                'status' => 'error',
                'message' => $final_message,
                );
                $this->update_process($data);

                throw new Exception($final_message);

            }
            return false;
        }

        function customCatchError($errno = '', $errstr = '', $errfile = '', $errline = '') {
            $file = str_replace(DIR_APPLICATION, '', $errfile);
            if(!$errno)
                $final_message = $errstr;
            else {
                $final_message = '<ul>';
                    $final_message .= '<li><b>Error code:</b> '.$errno.'</li>';
                    $final_message .= '<li><b>Error file:</b> '.$file.'</li>';
                    $final_message .= '<li><b>Error line:</b> '.$errline.'</li>';
                    $final_message .= '<li><b>Error message:</b> '.$errstr.'</li>';
                $final_message .= '</ul>';
            }

            throw new Exception($final_message);
        }

        function onDie(){
            $message = ob_get_contents();
            ob_end_clean();

            throw new Exception($message);
        }

        function get_image_link($image_name) {
            $img_link = $this->api_url.'opencart_admin/ext_ie_pro/img/'.$image_name;
            return $img_link;
        }
    }
?>