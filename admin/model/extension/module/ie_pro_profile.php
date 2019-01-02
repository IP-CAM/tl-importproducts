<?php
    class ModelExtensionModuleIeProProfile extends ModelExtensionModuleIePro {
        function save() {
            $this->request->post['no_exit'] = true;
            $this->validate_permiss();
            $profile_id = array_key_exists('profile_id', $this->request->post) ? $this->request->post['profile_id'] : '';
            $profile_name = array_key_exists('import_xls_profile_name', $this->request->post) ? $this->request->post['import_xls_profile_name'] : '';
            $profile_type = array_key_exists('profile_type', $this->request->post) ? $this->request->post['profile_type'] : '';

            $array_return = array('error' => false, 'message' => '');

            if(count($this->request->post, true) > ini_get('max_input_vars'))
                $this->exception(sprintf($this->language->get('profile_error_max_input_vars'), ini_get('max_input_vars'), count($this->request->post, true)));

            if(empty($profile_name))
                $this->exception($this->language->get('profile_error_empty_name'));

            if(array_key_exists('export_filter', $this->request->post)) {
                unset($this->request->post['export_filter']['replace_by_number']);

                $final_config = array(
                    'filters' => array(),
                    'config' => array(),
                );
                foreach ($this->request->post['export_filter'] as $key => $val) {
                    if(is_numeric($key)) {
                        $final_config['filters'][] = $val;
                    } else {
                        $final_config['config'][$key] = $val;
                    }
                }

                $this->request->post['export_filter'] = $final_config;

                if(empty($this->request->post['export_filter']['filters']))
                    unset($this->request->post['export_filter']);
                else
                    $this->request->post['export_filter']['filters'] = array_values($this->request->post['export_filter']['filters']);
            }

            if(array_key_exists('columns', $this->request->post) && !empty($this->request->post['columns'])) {
                $custom_names = array();
                foreach ($this->request->post['columns'] as $key => $col_info) {
                    if(empty($col_info['custom_name']))
                        $this->exception($this->language->get('profile_error_empty_column_custom_name'));

                    array_push($custom_names, $col_info['custom_name']);
                }
                $coun_repeats = array_count_values($custom_names);
                foreach ($coun_repeats as $col_name => $number) {
                    if($number > 1)
                        $this->exception(sprintf($this->language->get('profile_error_repeat_column_custom_name'), $number, $col_name));
                }

                $option_with_default_value = false;
                $table_option = array('product_option_value');
                $fields_option = array('option_name', 'name');

                foreach ($this->request->post['columns'] as $key => $col_info) {
                    if(array_key_exists('internal_configuration', $col_info) && !empty($col_info['internal_configuration'])) {
                        $internal_configuration = json_decode(str_replace("'", '"', $col_info['internal_configuration']), true);
                        if(array_key_exists('table', $internal_configuration) && in_array($internal_configuration['table'], $table_option) && array_key_exists('field', $internal_configuration) && in_array($internal_configuration['field'], $fields_option) && !empty($col_info['default_value'])) {
                            if(!empty($option_with_default_value))
                                $this->exception(sprintf($this->language->get('profile_error_option_option_value_default_filled'), $option_with_default_value, $col_info['custom_name']));
                            $option_with_default_value = $col_info['custom_name'];
                        }
                    }
                }
            }

            if($this->request->post['import_xls_file_format'] == 'xml') {
                foreach ($this->request->post['columns'] as $key => $col_info) {
                    if (!$this->isValidXmlElementName($col_info['custom_name'], $profile_type == 'import'))
                        $this->exception(sprintf($this->language->get('profile_error_xml_custom_columns'), $col_info['custom_name']));
                }
            }

            foreach ($this->request->post['columns'] as $key => $col_info) {
                if(array_key_exists('splitted_values', $col_info) && !empty($col_info['splitted_values']) && !preg_match("/(\>)/s", html_entity_decode($col_info['custom_name'])))
                    $this->exception(sprintf($this->language->get('profile_error_splitted_values'), $col_info['custom_name'], $col_info['custom_name']));
            }

            $config_json = $this->db->escape(json_encode($this->request->post));
            $profile_name = $this->db->escape($profile_name);

            if(!empty($profile_id)) {
                $sql = "UPDATE ".$this->escape_database_table_name('ie_pro_profiles')." SET ".$this->escape_database_field('type')." = ".$this->escape_database_value($profile_type).", ".$this->escape_database_field('name')." = ".$this->escape_database_value($profile_name).", ".$this->escape_database_field('profile')." = '".$config_json."', ".$this->escape_database_field('modified')." = NOW() WHERE id = ".$profile_id;
            } else {
                $sql = "INSERT INTO ".$this->escape_database_table_name('ie_pro_profiles')." SET ".$this->escape_database_field('type')." = ".$this->escape_database_value($profile_type).", ".$this->escape_database_field('name')." = ".$this->escape_database_value($profile_name).", ".$this->escape_database_field('profile')." = '".$config_json."', ".$this->escape_database_field('created')." = NOW(), ".$this->escape_database_field('modified')." = NOW();";
            }
            $this->db->query($sql);
            echo json_encode($array_return); die;
        }

        function isValidXmlElementName($elementName, $check_special_names)
        {
            $elementName = html_entity_decode($elementName);
            if($check_special_names && $this->is_special_xml_name($elementName) && !preg_match('/\s/',$elementName))
                return true;

            try {
                new DOMElement($elementName);
                return true;
            } catch (DOMException $e) {
                return false;
            }
            return false;
        }

        function delete() {
            $this->request->post['no_exit'] = true;
            $this->validate_permiss();
            $profile_id = array_key_exists('profile_id', $this->request->post) ? $this->request->post['profile_id'] : '';
            $array_return = array('error' => false, 'message' => '');
            if(empty($profile_id)) {
                $array_return['error'] = true;
                $array_return['message'] = $this->language->get('profile_error_delete_profile_id_empty');
                echo json_encode($array_return); die;
            }
            $sql = "DELETE FROM ".$this->escape_database_table_name('ie_pro_profiles')." WHERE ".$this->escape_database_field('id')." = ".$this->escape_database_value($profile_id);
            $this->db->query($sql);
            echo json_encode($array_return); die;
        }

        function load($force_id = '', $skip_json_encode = false) {
            $array_return = array('error' => false, 'message' => '');

            $profile_id_ajax = array_key_exists('profile_id', $this->request->post) ? $this->request->post['profile_id'] : '';
            $json_encode = !empty($profile_id_ajax) && !$skip_json_encode;
            $profile_id = !empty($profile_id_ajax) ? $profile_id_ajax : $force_id;

            $sql = "SELECT * FROM ".$this->escape_database_table_name('ie_pro_profiles')." WHERE ".$this->escape_database_field('id')." = ".$this->escape_database_value($profile_id);
            $result = $this->db->query($sql);

            if(empty($result->row)) {
                $array_return['error'] = true;
                $array_return['message'] = $this->language->get('profile_load_error_not_found');
                echo json_encode($array_return); die;
            }

            $result->row['profile'] = json_decode($this->sanitize_value(str_replace('&quot;', '\"', $result->row['profile'])), true);

            if($json_encode) {
                echo json_encode($result->row); die;
            }
            else return $result->row;
        }

        function get_profiles($type = '', $id = '', $select_format = false) {
            $sql = "SELECT * FROM ".$this->escape_database_table_name('ie_pro_profiles');
            if(!empty($type))
                $sql .= ' WHERE '.$this->escape_database_field('type').' = '.$this->escape_database_value($type);
            if(!empty($id))
                $sql .= ' WHERE '.$this->escape_database_field('id').' = "'.$this->escape_database_value($id);

            $sql .= ' ORDER BY '.$this->escape_database_field('type').' ASC, '.$this->escape_database_field('modified').' ASC';

            $result = $this->db->query($sql);

            foreach ($result->rows as $key => $profile) {
                $result->rows[$key]['profile'] = json_decode($profile['profile'], true);
                $result->rows[$key]['name'] = $this->language->get('profile_select_prefix_'.$profile['type']).' - '.$profile['name'];
            }

            if(!$select_format) {
                return $result->rows;
            } else {
                $final_profiles = array('' => $this->language->get('profile_select_text_empty'));
                foreach ($result->rows as $key => $profile) {
                    $final_profiles[$profile['id']] = $profile['name'];
                }
                return $final_profiles;
            }
        }

        public function _check_profiles_table() {
            $this->db->query("CREATE TABLE IF NOT EXISTS ".$this->escape_database_table_name('ie_pro_profiles')." (
              ".$this->escape_database_field('id')." int(11) unsigned NOT NULL AUTO_INCREMENT,
              ".$this->escape_database_field('type')." varchar(100) DEFAULT NULL,
              ".$this->escape_database_field('name')." varchar(360) DEFAULT NULL,
              ".$this->escape_database_field('profile')." MEDIUMTEXT,
              ".$this->escape_database_field('created')." datetime DEFAULT NULL,
              ".$this->escape_database_field('modified')." datetime DEFAULT NULL,
              PRIMARY KEY (".$this->escape_database_field('id').")
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        }
    }
?>