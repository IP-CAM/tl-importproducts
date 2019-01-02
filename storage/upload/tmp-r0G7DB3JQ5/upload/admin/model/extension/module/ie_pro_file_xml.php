<?php
    require_once DIR_SYSTEM . 'library/xml2array/XML2Array.php';
    require_once DIR_SYSTEM . 'library/xml2array/Array2XML.php';

    class ModelExtensionModuleIeProFileXml extends ModelExtensionModuleIeProFile {
        public function __construct($registry){
            parent::__construct($registry);
            $this->xml2array = new XML2Array();
        }
        function create_file() {
            $this->filename = $this->get_filename();
            $this->filename_path = $this->path_tmp.$this->filename;

            $this->xw = xmlwriter_open_memory();
            xmlwriter_set_indent($this->xw, 1);
            $res = xmlwriter_set_indent_string($this->xw, ' ');

            xmlwriter_start_document($this->xw, '1.0', 'UTF-8');
        }

        function insert_columns($columns) {}

        function insert_data($columns, $elements) {
            $xml_node = trim($this->profile['import_xls_node_xml']);

            if(empty($xml_node))
                $this->exception($this->language->get('export_import_error_xml_item_node'));
            
            $xml_node_split = explode(">",$this->sanitize_value($xml_node));

            $parent_tags = $xml_node_split;
            if(count($parent_tags) > 1) {
                unset($parent_tags[(count($parent_tags) - 1)]);
                $child_tag = $xml_node_split[(count($xml_node_split) - 1)];
            } else {
                $parent_tags = array('elements');
                $child_tag = $xml_node_split[0];
            }

            $count = 0;
            $elements_to_insert = count($elements);
            $message = sprintf($this->language->get('progress_export_elements_inserted'), 0, $elements_to_insert);
            $this->update_process($message);

            foreach ($parent_tags as $key => $parent_tag)
            xmlwriter_start_element($this->xw, $parent_tag);
                foreach ($elements as $element_id => $values) {
                    xmlwriter_start_element($this->xw, $child_tag); xmlwriter_start_attribute($this->xw, 'id'); xmlwriter_text($this->xw, $element_id); xmlwriter_end_attribute($this->xw);
                        foreach ($values as $column_name => $value) {
                            xmlwriter_start_element($this->xw, $column_name);
                                xmlwriter_text($this->xw, trim($value));
                            xmlwriter_end_element($this->xw);
                        }
                    xmlwriter_end_element($this->xw);

                    $count++;
                    $message = sprintf($this->language->get('progress_export_elements_inserted'), $count, $elements_to_insert);
                    $this->update_process($message, true);
                }
            foreach ($parent_tags as $key => $parent_tag)
            xmlwriter_end_document($this->xw);

            file_put_contents($this->filename_path, xmlwriter_output_memory($this->xw));
        }
        
        function insert_data_multisheet($data) {
            xmlwriter_start_element($this->xw, 'elements');
                foreach ($data as $table_name => $values) {
                    $message = sprintf($this->language->get('progress_export_inserting_sheet_data'), $table_name);
                    $this->update_process($message);

                    xmlwriter_start_element($this->xw, 'table'); xmlwriter_start_attribute($this->xw, 'table'); xmlwriter_text($this->xw, $table_name); xmlwriter_end_attribute($this->xw);
                        $columns = $values['columns'];
                        foreach ($values['data'] as $element_id => $values) {
                            xmlwriter_start_element($this->xw, 'element'); xmlwriter_start_attribute($this->xw, 'id'); xmlwriter_text($this->xw, $element_id); xmlwriter_end_attribute($this->xw);
                                foreach ($values as $key => $val) {
                                    xmlwriter_start_element($this->xw, $columns[$key]);
                                        xmlwriter_text($this->xw, trim($val));
                                    xmlwriter_end_element($this->xw);
                                }
                            xmlwriter_end_element($this->xw);
                        }
                    xmlwriter_end_element($this->xw);
                }
            xmlwriter_end_document($this->xw);

            file_put_contents($this->filename_path, xmlwriter_output_memory($this->xw));
        }
        function get_data() {
            $xml_node = trim($this->profile['import_xls_node_xml']);

            if(empty($xml_node))
                $this->exception($this->language->get('export_import_error_xml_item_node'));

            $xml_node_split = explode(">",$this->sanitize_value($xml_node));

            $xml_content = file_get_contents($this->file_tmp_path);
            //$xml_content = utf8_encode($xml_content);

            $temp_array = $this->xml2array->createArray($xml_content);
            
            foreach ($xml_node_split as $key => $node) {
                if(!array_key_exists($node, $temp_array))
                    $this->exception(sprintf($this->language->get('export_import_error_xml_item_node_not_found'), $xml_node));
                $temp_array = $temp_array[$node];
            }
            
            $temp_array = !empty($temp_array) && is_array($temp_array) && !array_key_exists(0, $temp_array) ? array($temp_array) : $temp_array;

            $elements = $this->translate_elements($temp_array, $this->columns);
            //$elements = $this->remove_xml_attributes($temp_array);

            $final_data = array(
                'columns' => array(),
                'data' => array(),
            );

            $final_data['columns'] = array_keys($elements[0]);

            $elements = $this->remove_xml_indexes($elements);

            $final_data['data'] = array_values($elements);
            return $final_data;
        }

        function get_data_multisheet() {
            $xml = simplexml_load_file($this->file_tmp_path);
            $json = str_replace(':{}',':null',json_encode($xml));
            $xml_data = json_decode($json,TRUE);

            if(!array_key_exists('table', $xml_data))
                $this->exception($this->language->get('migration_import_error_xml_incompatible'));

            $final_data = array();

            foreach ($xml_data['table'] as $key => $table_info) {
                if(!array_key_exists('@attributes', $table_info) || !array_key_exists('table', $table_info['@attributes']))
                    $this->exception($this->language->get('migration_import_error_xml_incompatible'));

                $table_name = $table_info['@attributes']['table'];
                $final_data[$table_name] = array(
                    'columns' => array(),
                    'data' => array(),
                );

                $array_depth = $this->array_depth($table_info['element']);
                if($array_depth == 2)
                    $element_to_foreach = array($table_info['element']);
                else
                    $element_to_foreach = $table_info['element'];

                foreach ($element_to_foreach as $key2 => $row) {
                    if(array_key_exists('@attributes', $row))
                        unset($row['@attributes']);

                    $final_data[$table_name]['data'][] = $row;
                }

                if(!empty($final_data[$table_name]['data'])) {
                    $final_data[$table_name]['columns'] = array_keys($final_data[$table_name]['data'][0]);

                    foreach ($final_data[$table_name]['data'] as $key_data => $row) {
                        $final_data[$table_name]['data'][$key_data] = array_values($row);
                    }
                } else {
                    unset($final_data[$table_name]);
                }
            }

            return $final_data;
        }
        
        function translate_elements($elements, $columns) {
            $final_elements = array();
            foreach ($elements as $key => $element) {
                $temp_element = array();
                foreach ($columns as $key2 => $col_info) {
                    $custom_name = $col_info['custom_name'];
                    if($this->is_special_xml_name($custom_name)) {
                        $key_column = $custom_name;
                        $indexes = $this->get_keys_from_special_xml_name($key_column);
                        $copy_element = $element;
                        foreach ($indexes as $tag_name_temp) {
                            if(is_array($copy_element) && array_key_exists($tag_name_temp, $copy_element)) {
                                $copy_element = $copy_element[$tag_name_temp];
                            }
                        }

                        $temp_element[$key_column] = !is_array($copy_element) ? $copy_element : '';
                    } else {
                        $key_column = $custom_name;
                        $temp_value = array_key_exists($key_column, $element) ? $element[$key_column] : '';
                        $temp_value = is_array($temp_value) && array_key_exists('@value', $temp_value) ? $temp_value['@value'] : $temp_value;
                        $temp_element[$key_column] = $temp_value;
                    }
                }
                if(!empty($temp_element))
                    $final_elements[] = $temp_element;
            }

            return $final_elements;
        }

        function get_keys_from_special_xml_name($name) {
            $keys = array();
            $is_attribute = false;
            if(preg_match("/(\>)/s", $name)) {
                $col_name_split = explode('>', $name);
            } elseif(preg_match("/(\*)/s", $name)) {
                $col_name_split = explode('*', $name);
            } elseif(preg_match("/(\@)/s", $name)) {
                $col_name_split = explode('@', $name);
                $is_attribute = true;
            } else {
                $col_name_split = explode('>', $name);
            }

            foreach ($col_name_split as $count => $key) {
                if(!$this->is_special_xml_name($key)) {
                    $keys[] = $key;
                    if($is_attribute && $count == 0) {
                        $keys[] = '@attributes';
                    }
                }
                else {
                    $temp_keys = $this->get_keys_from_special_xml_name($key);
                    foreach ($temp_keys as $subkey)
                       $keys[] = $subkey;
                }
            }
            
            return $keys;
        }
        function remove_xml_indexes($xml_data) {
            $final_xml_data = array();
            foreach ($xml_data as $key => $xml_data) {
                $final_xml_data[] = array_values($xml_data);
            }
            return $final_xml_data;
        }
        
        function remove_xml_attributes($xml_data) {
           foreach ($xml_data as $key => $rows) {
               foreach ($rows as $key2 => $row) {
                    if(is_array($row))
                        unset($xml_data[$key][$key2]);
               }
           }
           return $xml_data;
        }
    }
?>