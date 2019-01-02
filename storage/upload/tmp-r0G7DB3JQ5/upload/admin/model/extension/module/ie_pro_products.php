<?php
    class ModelExtensionModuleIeProProducts extends ModelExtensionModuleIePro
    {
        var $products_models = array();
        public function __construct($registry)
        {
            parent::__construct($registry);
        }

        public function set_model_tables_and_fields($special_tables = array(), $special_tables_description = array(), $delete_tables = array()) {
            $this->main_table = 'product';
            $this->main_field = 'product_id';

            $delete_tables = array(
                'product_attribute',
                'product_description',
                'product_discount',
                'product_filter',
                'product_image',
                'product_option',
                'product_option_value',
                'product_related',
                'product_related',
                'product_reward',
                'product_special',
                'product_to_category',
                'product_to_download',
                'product_to_layout',
                'product_to_store',
                'review',
                'product_recurring',
                'product_profile',
                'coupon_product',
            );

            $delete_tables = $this->remove_tables($this->database_schema, $delete_tables);

            $this->delete_tables_special = array(
                'product_related',
                'seo_url',
                'url_alias',
            );
            
            $special_tables = array(
                'product_to_category',
                'product_filter',
                'product_attribute',
                'product_special',
                'product_discount',
                'product_related',
                'product_reward',
                'product_image',
                'product_to_store',
                'product_to_download',
                'product_to_layout',
                'product_option_value',
                'seo_url'
            );

            $special_tables_description = array('filter_group_description');
            parent::set_model_tables_and_fields($special_tables, $special_tables_description, $delete_tables);
        }
        public function get_columns($configuration = array())
        {
            $configuration = $this->clean_array_extension_prefix($configuration);
            $profile_id = array_key_exists('profile_id', $configuration) && !empty($configuration['profile_id']) ? $configuration['profile_id'] : '';

            $multilanguage = array_key_exists('multilanguage', $configuration) ? $configuration['multilanguage'] : false;
            $category_tree = array_key_exists('category_tree', $configuration) && $configuration['category_tree'];
            $cat_number = array_key_exists('cat_number', $configuration) && $configuration['cat_number'] ? (int)$configuration['cat_number'] : 0;
            $cat_tree_number = array_key_exists('cat_tree_number', $configuration) && $configuration['cat_tree_number'] ? (int)$configuration['cat_tree_number'] : 0;
            $cat_tree_children_number = array_key_exists('cat_tree_children_number', $configuration) && $configuration['cat_tree_children_number'] ? (int)$configuration['cat_tree_children_number'] : 0;
            $image_number = array_key_exists('image_number', $configuration) && $configuration['image_number'] ? (int)$configuration['image_number'] : 0;
            $attribute_number = array_key_exists('attribute_number', $configuration) && $configuration['attribute_number'] ? (int)$configuration['attribute_number'] : 0;
            $special_number = array_key_exists('special_number', $configuration) && $configuration['special_number'] ? (int)$configuration['special_number'] : 0;
            $discount_number = array_key_exists('discount_number', $configuration) && $configuration['discount_number'] ? (int)$configuration['discount_number'] : 0;
            $filter_group_number = array_key_exists('filter_group_number', $configuration) && $configuration['filter_group_number'] ? (int)$configuration['filter_group_number'] : 0;
            $filter_number = array_key_exists('filter_number', $configuration) && $configuration['filter_number'] ? (int)$configuration['filter_number'] : 0;
            $download_number = array_key_exists('download_number', $configuration) && $configuration['download_number'] ? (int)$configuration['download_number'] : 0;

            $columns = $this->get_columns_formatted($multilanguage);

            $final_columns = array();
            foreach ($columns as $column_name => $field_info) {
                if ($column_name == 'categories_tree' || $column_name == 'filters') {
                    $col_number = $column_name == 'categories_tree' ? $cat_tree_number : $filter_group_number;
                    $col_number2 = $column_name == 'categories_tree' ? $cat_tree_children_number : $filter_number;
                    $col_number = $column_name == 'categories_tree' && !$category_tree ? 0 : $col_number;

                    if ($col_number > 0) {
                        $col_parent = $field_info['parent'];
                        $col_parent_name = $field_info['parent']['name'];
                        $col_children = $field_info['children'];
                        $col_children_name = $field_info['children']['name'];
                        if ($col_number > 0) {
                            for ($i = 1; $i <= $col_number; $i++) {
                                $col_info = $col_parent;
                                $col_name = sprintf($col_info['hidden_fields']['name'], $i);
                                $col_info['hidden_fields']['name'] = $col_name;
                                $col_info['custom_name'] = $col_name;
                                $col_info['hidden_fields']['identificator'] = $i;
                                $final_columns[$col_name] = $col_info;

                                if ($col_number2 > 0) {
                                    for ($j = 1; $j <= $col_number2; $j++) {
                                        $col_info = $col_children;
                                        $col_name = sprintf($col_info['hidden_fields']['name'], $i, $j);
                                        $col_info['hidden_fields']['name'] = $col_name;
                                        $col_info['custom_name'] = $col_name;
                                        $col_info['hidden_fields']['identificator'] = $i . '_' . $j;
                                        $final_columns[$col_name] = $col_info;

                                    }
                                }
                            }
                        }
                    }
                } else if (($column_name == 'Cat. %s') || $column_name == 'Image %s') {
                    $col_number = $column_name == 'Cat. %s' ? $cat_number : $image_number;
                    $col_number = $column_name == 'Cat. %s' && $category_tree ? 0 : $col_number;

                    if ($col_number > 0) {
                        for ($i = 1; $i <= $col_number; $i++) {
                            $col_info = $field_info;
                            $col_name = sprintf($col_info['hidden_fields']['name'], $i);
                            $col_info['hidden_fields']['name'] = $col_name;
                            $col_info['hidden_fields']['identificator'] = $i;
                            $col_info['custom_name'] = $col_name;
                            $final_columns[$col_name] = $col_info;
                        }
                    }
                } else if (in_array($column_name, array('specials', 'discounts'))) {
                    $col_number = $column_name == 'specials' ? $special_number : $discount_number;

                    if ($col_number > 0) {
                        for ($i = 1; $i <= $col_number; $i++) {
                            foreach ($this->customer_groups as $id => $cg) {
                                foreach ($field_info as $field_info_temp) {
                                    $col_info = $field_info_temp;
                                    $col_name = sprintf($col_info['hidden_fields']['name'], $i, $cg['name']);
                                    $col_info['hidden_fields']['name'] = $col_name;
                                    $col_info['hidden_fields']['customer_group_id'] = $cg['customer_group_id'];
                                    $col_info['custom_name'] = $col_name;
                                    $col_info['hidden_fields']['identificator'] = $i.'_'.$cg['customer_group_id'];
                                    $final_columns[$col_name] = $col_info;
                                }
                            }
                        }
                    }
                } else if ($column_name == 'Points %s') {
                    foreach ($this->customer_groups as $id => $cg) {
                        $col_name = sprintf($column_name, $cg['name']);
                        $field_info['hidden_fields']['name'] = $col_name;
                        $field_info['hidden_fields']['customer_group_id'] = $cg['customer_group_id'];
                        $field_info['hidden_fields']['identificator'] = $cg['customer_group_id'];
                        $field_info['custom_name'] = $col_name;
                        $final_columns[$col_name] = $field_info;
                    }
                } else if (in_array($column_name, array('attributes', 'downloads'))) {
                    $col_number = $column_name == 'attributes' ? $attribute_number : $download_number;

                    if ($col_number > 0) {
                        for ($i = 1; $i <= $col_number; $i++) {
                            foreach ($field_info as $field_info_temp) {
                                $col_info = $field_info_temp;
                                $col_name = sprintf($col_info['hidden_fields']['name'], $i);
                                $col_info['hidden_fields']['identificator'] = $i;
                                $col_info['hidden_fields']['name'] = $col_name;
                                $col_info['custom_name'] = $col_name;
                                $final_columns[$col_name] = $col_info;
                            }
                        }
                    }
                } else {
                    $final_columns[$column_name] = $field_info;
                }
            }
            $columns = $this->format_columns_multilanguage_multistore($final_columns);

            if (!empty($profile_id)) {
                $col_map = $this->model_extension_module_ie_pro_tab_profiles->get_columns($profile_id);
                foreach ($columns as $col_name => $col_info) {
                    if (!array_key_exists($col_name, $col_map)) {
                        $col_info['status'] = 0;
                        $col_map[$col_name] = $col_info;
                    }
                }
                $columns = $col_map;
            }
            
            if($configuration['file_format'] == 'xml' && empty($profile_id)) {
                foreach ($columns as $column_name => $col_info) {
                    $columns[$column_name]['custom_name'] = $this->format_column_name($col_info['custom_name']);
                }
            }

            return $columns;
        }

        function get_columns_formatted($multilanguage)
        {
            $fields = array(
                'Product ID' => array('hidden_fields' => array('table' => 'product', 'field' => 'product_id')),
                'Model' => array('hidden_fields' => array('table' => 'product', 'field' => 'model')),
                'Name' => array('hidden_fields' => array('table' => 'product_description', 'field' => 'name'), 'multilanguage' => $multilanguage),
                'Description' => array('hidden_fields' => array('table' => 'product_description', 'field' => 'description'), 'multilanguage' => $multilanguage),
                'Meta description' => array('hidden_fields' => array('table' => 'product_description', 'field' => 'meta_description'), 'multilanguage' => $multilanguage),
                'Meta title' => array('hidden_fields' => array('table' => 'product_description', 'field' => 'meta_title'), 'multilanguage' => $multilanguage),
                'Meta H1' => array('hidden_fields' => array('table' => 'product_description', 'field' => 'meta_h1'), 'multilanguage' => $multilanguage),
                'Meta keywords' => array('hidden_fields' => array('table' => 'product_description', 'field' => 'meta_keyword'), 'multilanguage' => $multilanguage),
                'SEO url' => array('hidden_fields' => array('table' => 'seo_url', 'field' => 'keyword'), 'multilanguage' => $multilanguage && $this->is_oc_3x, 'multistore' => $this->is_oc_3x),
                'Tags' => array('hidden_fields' => array('table' => 'product_description', 'field' => 'tag'), 'multilanguage' => $multilanguage),
                'SKU' => array('hidden_fields' => array('table' => 'product', 'field' => 'sku')),
                'EAN' => array('hidden_fields' => array('table' => 'product', 'field' => 'ean')),
                'UPC' => array('hidden_fields' => array('table' => 'product', 'field' => 'upc')),
                'JAN' => array('hidden_fields' => array('table' => 'product', 'field' => 'jan')),
                'MPN' => array('hidden_fields' => array('table' => 'product', 'field' => 'mpn')),
                'ISBN' => array('hidden_fields' => array('table' => 'product', 'field' => 'isbn')),
                'Minimum' => array('hidden_fields' => array('table' => 'product', 'field' => 'minimum')),
                'Subtract' => array('hidden_fields' => array('table' => 'product', 'field' => 'subtract')),
                'Out stock status' => array('hidden_fields' => array('table' => 'product', 'field' => 'stock_status_id', 'conversion_global_var' => 'stock_statuses', 'conversion_global_index' => 'name')),
                'Price' => array('hidden_fields' => array('table' => 'product', 'field' => 'price'), 'profit_margin' => ''),
                'Tax class' => array('hidden_fields' => array('table' => 'product', 'field' => 'tax_class_id', 'conversion_global_var' => 'tax_classes', 'conversion_global_index' => 'title')),
                'Quantity' => array('hidden_fields' => array('table' => 'product', 'field' => 'quantity')),
                'Main image' => array('hidden_fields' => array('table' => 'product', 'field' => 'image'), 'splitted_values' => ''),
                'Image %s' => array('hidden_fields' => array('table' => 'product_image', 'field' => 'image'), 'splitted_values' => ''),
                'Manufacturer' => array('hidden_fields' => array('table' => 'product', 'field' => 'manufacturer_id', 'name_instead_id' => true, 'conversion_global_var' => 'all_manufacturers')),
                'Cat. %s' => array('hidden_fields' => array('table' => 'product_to_category', 'field' => 'category_id'), 'multilanguage' => $multilanguage, 'splitted_values' => ''),
                'categories_tree' => array(
                    'parent' => array('name' => 'Cat. tree %s parent', 'hidden_fields' => array('table' => 'product_to_category', 'field' => 'name'), 'multilanguage' => $multilanguage, 'splitted_values' => ''),
                    'children' => array('name' => 'Cat. tree %s level %s', 'hidden_fields' => array('table' => 'product_to_category', 'field' => 'name'), 'multilanguage' => $multilanguage, 'splitted_values' => ''),
                ),
                'Points' => array('hidden_fields' => array('table' => 'product', 'field' => 'points')),
                'Points %s' => array('hidden_fields' => array('table' => 'product_reward', 'field' => 'points')),
                'Weight class' => array('hidden_fields' => array('table' => 'product', 'field' => 'weight_class_id', 'conversion_global_var' => 'weight_classes', 'conversion_global_index' => 'title')),
                'Weight' => array('hidden_fields' => array('table' => 'product', 'field' => 'weight')),
                'Length class' => array('hidden_fields' => array('table' => 'product', 'field' => 'length_class_id', 'conversion_global_var' => 'length_classes', 'conversion_global_index' => 'title')),
                'Length' => array('hidden_fields' => array('table' => 'product', 'field' => 'length')),
                'Width' => array('hidden_fields' => array('table' => 'product', 'field' => 'width')),
                'Height' => array('hidden_fields' => array('table' => 'product', 'field' => 'height')),
                'Option' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'option_name'), 'multilanguage' => $multilanguage),
                'Option required' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'option_required')),
                'Option type' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'option_type')),
                'Option value' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'name'), 'multilanguage' => $multilanguage),
                'Option value sort order' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'sort_order')),
                'Option subtract' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'subtract')),
                'Option image' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'image')),
                'Option quantity' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'quantity')),
                'Option price prefix' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'price_prefix')),
                'Option price' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'price'), 'profit_margin' => ''),
                'Option points prefix' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'points_prefix')),
                'Option points' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'points')),
                'Option weight prefix' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'weight_prefix')),
                'Option weight' => array('hidden_fields' => array('table' => 'product_option_value', 'field' => 'weight')),
                'Products related' => array('hidden_fields' => array('table' => 'product_related', 'field' => 'related')),
                'Date available' => array('hidden_fields' => array('table' => 'product', 'field' => 'date_available')),
                'Date added' => array('hidden_fields' => array('table' => 'product', 'field' => 'date_added')),
                'Date modified' => array('hidden_fields' => array('table' => 'product', 'field' => 'date_modified')),
                'Requires shipping' => array('hidden_fields' => array('table' => 'product', 'field' => 'shipping')),
                'Location' => array('hidden_fields' => array('table' => 'product', 'field' => 'location')),
                'Sort order' => array('hidden_fields' => array('table' => 'product', 'field' => 'sort_order')),
                'Store' => array('hidden_fields' => array('table' => 'product_to_store', 'field' => 'store_id')),
                'Status' => array('hidden_fields' => array('table' => 'product', 'field' => 'status')),
                'Layout' => array('multistore' => true, 'hidden_fields' => array('table' => 'product_to_layout', 'field' => 'layout_id', 'conversion_global_var' => 'layouts')),
                'specials' => array(
                    'Spe. %s Priority %s' => array('hidden_fields' => array('table' => 'product_special', 'field' => 'priority'),),
                    'Spe. %s Price %s' => array('hidden_fields' => array('table' => 'product_special', 'field' => 'price'),),
                    'Spe. %s Date start %s' => array('hidden_fields' => array('table' => 'product_special', 'field' => 'date_start'),),
                    'Spe. %s Date end %s' => array('hidden_fields' => array('table' => 'product_special', 'field' => 'date_end'),),
                ),
                'discounts' => array(
                    'Dis. %s Quantity %s' => array('hidden_fields' => array('table' => 'product_discount', 'field' => 'quantity'),),
                    'Dis. %s Priority %s' => array('hidden_fields' => array('table' => 'product_discount', 'field' => 'priority'),),
                    'Dis. %s Price %s' => array('hidden_fields' => array('table' => 'product_discount', 'field' => 'price'),),
                    'Dis. %s Date start %s' => array('hidden_fields' => array('table' => 'product_discount', 'field' => 'date_start'),),
                    'Dis. %s Date end %s' => array('hidden_fields' => array('table' => 'product_discount', 'field' => 'date_end'),),
                ),
                'attributes' => array(
                    'Attr. Group %s' => array('hidden_fields' => array('table' => 'product_attribute', 'field' => 'attribute_group'), 'multilanguage' => $multilanguage),
                    'Attribute %s' => array('hidden_fields' => array('table' => 'product_attribute', 'field' => 'attribute'), 'multilanguage' => $multilanguage),
                    'Attribute value %s' => array('hidden_fields' => array('table' => 'product_attribute', 'field' => 'attribute_value'), 'multilanguage' => $multilanguage),
                ),
                'filters' => array(
                    'parent' => array('hidden_fields' => array('table' => 'product_filter', 'field' => 'name'), 'name' => 'Filter Group %s', 'multilanguage' => $multilanguage),
                    'children' => array('hidden_fields' => array('table' => 'product_filter', 'field' => 'name'), 'name' => 'Filter Gr. %s filter %s', 'multilanguage' => $multilanguage),
                ),
                'downloads' => array(
                    'Download name %s' => array('hidden_fields' => array('table' => 'product_to_download', 'field' => 'name'),'multilanguage' => $multilanguage),
                    'Download file %s' => array('hidden_fields' => array('table' => 'product_to_download', 'field' => 'filename')),
                    'Download hash %s' => array('hidden_fields' => array('table' => 'product_to_download', 'field' => 'hash')),
                    'Download mask %s' => array('hidden_fields' => array('table' => 'product_to_download', 'field' => 'mask')),
                ),
                'Delete' => array('hidden_fields' => array('table' => 'empty_columns', 'field' => 'delete', 'is_boolean' => true)),
            );

            if(version_compare(VERSION, '2', '<')) {
                unset($fields['Meta title']);
            }

            if (!$this->is_ocstore) {
                unset($fields['Meta H1']);
                unset($fields['Main category']);
            }

            if(!$this->is_oc_3x) {
                unset($fields['SEO url']['multistore']);
                unset($fields['SEO url']['multilanguage']);
            }

            $final_fields = array();

            foreach ($fields as $col_name => $col_info) {
                if (in_array($col_name, array('specials', 'discounts', 'categories_tree', 'attributes', 'filters', 'downloads'))) {
                    $final_fields[$col_name] = array();
                    if (in_array($col_name, array('categories_tree', 'filters'))) {
                        $to_each = array('parent', 'children');
                        foreach ($to_each as $key => $col_type) {
                            $col_info_temp = $this->format_default_column($col_info[$col_type]['name'], $col_info[$col_type]);
                            $final_fields[$col_name][$col_type] = $col_info_temp;
                        }
                    } else {
                        $columns = $col_info;
                        foreach ($columns as $col_name_temp => $col_info_temp) {
                            $col_info_temp = $this->format_default_column($col_name_temp, $col_info_temp);
                            $final_fields[$col_name][$col_name_temp] = $col_info_temp;
                        }
                    }
                } else {
                    $final_fields[$col_name] = $this->format_default_column($col_name, $col_info);
                }
            }

            $final_fields = parent::put_type_to_columns_formatted($final_fields);

            return $final_fields;
        }

        /*
         * In this function create first data related with products before import products (categories, options, filters...)
         * Also format all product data to structure
         */
        public function pre_import($data_file) {
            $this->pre_import_create_product_associated_data($data_file);

            $special_tables = array(
                'product_description',
                'product_option_value',
                'product_image',
                'product_to_category',
                'product_attribute',
                'product_filter',
                'product_to_download',
                'seo_url',
                'product_reward',
                'product_related',
                'product_to_store',
                'product_to_layout',
                'product_special',
                'product_discount',
            );

            $product_id = '';
            $main_counter_product_ids = 1;

            $copy_data_file = array();

            $this->update_process($this->language->get('progress_import_elements_process_start'));
            $element_to_process = count($data_file);
            $element_processed = 0;
            $this->update_process(sprintf($this->language->get('progress_import_elements_processed'), $element_processed, $element_to_process));

            foreach ($data_file as $row_file_number => $tables_fields) {
                $temp = array();
                $is_option_row = false;
                $skipped = false;

                if($this->has_options) {
                    $options_formated = $this->_importing_process_format_product_option_value($tables_fields['product_option_value'], $row_file_number, $product_id);
                    $product_identificator = $tables_fields[$this->main_table][$this->product_identificator];
                    $some_options_data = array_filter($options_formated);

                    $is_option_row = empty($product_identificator) && !empty($some_options_data);

                    if(!$is_option_row) {
                        if (!empty($some_options_data)) {
                            $this->exception(sprintf($this->language->get('progress_import_product_error_option_data_in_main_row'), ($row_file_number+2)));
                        }
                        $temp['product_option'] = array();
                        $temp['product_option_value'] = array();
                    } else {
                        $has_option_value = $options_formated['option_value_id'];

                        if($has_option_value)
                            $temp['product_option_value'] = $options_formated;

                        $temp['product_option'] = $options_formated;
                    }
                    unset($tables_fields['product_option_value']);
                }

                if(!$is_option_row) {
                    $creating = false;
                    $editting = false;
                    $product_id = $this->search_product_id($tables_fields);
                    $creating = empty($product_id);
                    $editting = !empty($product_id);
                    if(($creating && $this->skip_on_create) || ($editting && $this->skip_on_edit)) {
                        $product_id = 'SKIPPED';
                        $skipped = true;
                    } else {
                        if(empty($product_id)) {
                            $product_id = $this->assign_product_id($main_counter_product_ids);
                            $main_counter_product_ids++;
                        }

                    }

                    if(!$skipped) {
                        foreach ($tables_fields as $table_name => $fields) {
                            if ($table_name == $this->main_table || !in_array($table_name, $special_tables)) {
                                $temp[$table_name] = $fields;
                                if($table_name != 'empty_columns')
                                    $temp[$table_name]['product_id'] = $product_id;
                            } else {
                                $temp[$table_name] = $this->{'_importing_process_format_' . $table_name}($fields, $product_id, $row_file_number);
                            }

                            if($table_name == 'seo_url' && !$this->is_oc_3x) {
                                $copy_seo_url = $temp['seo_url'];
                                unset($temp['seo_url']);
                                $temp['url_alias'] = $copy_seo_url;
                            }
                        }
                    }
                } else {
                    $skipped = true;
                    if($product_id != 'SKIPPED') {
                        $last_index = count($copy_data_file)-1;
                        $copy_data_file[$last_index]['product_option_value'][] = $options_formated;
                        $copy_data_file[$last_index]['product_option'][] = $options_formated;
                    }
                }

                if(!$skipped) {
                    $model = array_key_exists($this->main_table, $temp) && array_key_exists('model', $temp[$this->main_table]) && !empty($temp[$this->main_table]['model']) ? $temp[$this->main_table]['model'] : '';
                    if(!empty($model)) $this->products_models[$model] = $product_id;

                    //<editor-fold desc="Rest - Sum tax class in creating">
                        $price = array_key_exists($this->main_table, $temp) && array_key_exists('price', $temp[$this->main_table]) && !empty($temp[$this->main_table]['price']) ? (float)$temp[$this->main_table]['price'] : '';
                        $tax_class_id = array_key_exists($this->main_table, $temp) && array_key_exists('tax_class_id', $temp[$this->main_table]) && !empty($temp[$this->main_table]['tax_class_id']) ? (float)$temp[$this->main_table]['tax_class_id'] : '';
                        if($creating && ($this->sum_tax_price_on_create || $this->rest_tax_price_on_create) && !empty($price) && !empty($tax_class_id)) {
                            $temp[$this->main_table]['price'] = $this->price_tax_calculate('', $price, $this->sum_tax_price_on_create ? 'sum' : 'rest', $tax_class_id);
                        }
                    //</editor-fold>

                    //<editor-fold desc="Autogenerate SEO url">
                        if(array_key_exists($this->table_seo, $temp) && empty($temp[$this->table_seo]) && $this->auto_seo_generator != '') {
                            $temp[$this->table_seo] = $this->get_seo_url_autogenerated($temp);
                        }
                    //</editor-fold>

                    if(!array_key_exists('empty_columns', $temp))
                        $temp['empty_columns'] = array();

                    $temp['empty_columns']['editting'] = $editting;
                    $temp['empty_columns']['creating'] = $creating;

                    $copy_data_file[] = $temp;
                }

                $element_processed++;
                $this->update_process(sprintf($this->language->get('progress_import_elements_processed'), $element_processed, $element_to_process), true);
            }

            return $copy_data_file;
        }

        public function get_seo_url_autogenerated($product_data) {
            $final_seo_url = array();
            $product_id = $product_data[$this->main_table]['product_id'];
            $query = 'product_id='.$product_id;
            if($this->auto_seo_generator == 'model') {
                $seo_url = $this->format_seo_url($product_data[$this->main_table]['model']);
                if($this->is_oc_3x) {
                    foreach ($this->stores_import_format as $store) {
                        $store_id = $store['store_id'];
                        foreach ($this->languages as $key => $lang) {
                            $language_id = $lang['language_id'];
                            $final_seo_url[] = array(
                                'language_id' => $language_id,
                                'store_id' => $store_id,
                                'query' => $query,
                                'keyword' => $seo_url
                            );
                        }
                    }
                } else {
                    $final_seo_url = array(
                        'query' => $query,
                        'keyword' => $seo_url
                    );
                }
            } else if(array_key_exists('product_description', $product_data)) {
                if($this->is_oc_3x) {
                    foreach ($this->stores_import_format as $store) {
                        $store_id = $store['store_id'];
                        foreach ($this->languages as $key => $lang) {
                            $language_id = $lang['language_id'];

                            $name = '';

                            foreach ($product_data['product_description'] as $key => $description) {
                                if(array_key_exists($this->auto_seo_generator, $description) && $description['language_id'] == $language_id) {
                                    $name = $description[$this->auto_seo_generator];
                                    break;
                                }
                            }
                            if(!empty($name)) {
                                $seo_url = $this->format_seo_url($name);
                                $final_seo_url[] = array(
                                    'language_id' => $language_id,
                                    'store_id' => $store_id,
                                    'query' => $query,
                                    'keyword' => $seo_url
                                );
                            }
                        }
                    }
                } else {
                    foreach ($this->languages as $key => $lang) {
                        $language_id = $lang['language_id'];
                        $name = '';
                        $name_main_language = '';
                        foreach ($product_data['product_description'] as $key => $description) {
                            if(array_key_exists($this->auto_seo_generator, $description) && $description['language_id'] == $language_id) {
                                $name = $description[$this->auto_seo_generator];
                                if($language_id == $this->default_language_id)
                                    $name_main_language = $description[$this->auto_seo_generator];
                            }
                        }
                        if(!empty($name) || !empty($name_main_language)) {
                            $final_name = !empty($name_main_language) ? $name_main_language : $name;
                            $seo_url = $this->format_seo_url($final_name);
                            $final_seo_url = array(
                                'query' => $query,
                                'keyword' => $seo_url
                            );
                        }
                    }
                }
            }
            return $final_seo_url;
        }
        public function search_product_id($prod_data) {
            if($this->product_identificator != $this->main_field && array_key_exists($this->main_table, $prod_data) && array_key_exists($this->main_field, $prod_data[$this->main_table]) && !empty($prod_data[$this->main_table][$this->main_field]))
                return $prod_data[$this->main_table][$this->main_field];

            $identificator_value = array_key_exists($this->product_identificator, $prod_data[$this->main_table]) ? $prod_data[$this->main_table][$this->product_identificator] : '';
            $product_id = $this->get_product_id($this->product_identificator, $identificator_value);
            return $product_id;
        }

        public function pre_import_create_product_associated_data($data_file) {
            $this->has_categories =
                ($this->cat_tree && (int)$this->profile['import_xls_cat_tree_number'] > 0 && array_key_exists('product_to_category', $data_file[0]))
                ||
                (!$this->cat_tree && (int)$this->profile['import_xls_cat_number'] > 0 && array_key_exists('product_to_category', $data_file[0]));
            if($this->has_categories) {
                $this->load->model('extension/module/ie_pro_categories');
                $this->model_extension_module_ie_pro_categories->create_categores_from_product($data_file);
                $this->all_categories = $this->model_extension_module_ie_pro_categories->{$this->cat_tree ? 'get_all_categories_tree_import_format' : 'get_all_categories_import_format'}();
            }

            if($this->hasFilters) {
                $this->has_filters = array_key_exists(0, $data_file) && array_key_exists('product_filter', $data_file[0]) && (int)$this->profile['import_xls_filter_group_number'] > 0;
                if($this->has_filters) {
                    $this->load->model('extension/module/ie_pro_filter_groups');
                    $this->model_extension_module_ie_pro_filter_groups->create_filter_groups_from_product($data_file);
                    $this->all_filter_groups = $this->model_extension_module_ie_pro_filter_groups->get_all_filter_groups_import_format();

                    $this->load->model('extension/module/ie_pro_filters');
                    $this->model_extension_module_ie_pro_filters->create_filters_from_product($data_file);
                    $this->all_filters = $this->model_extension_module_ie_pro_filters->get_all_filters_import_format();
                    $this->all_filters_simple = $this->model_extension_module_ie_pro_filters->get_all_filters_import_format(true);
                }
            }

            $this->has_attributes = array_key_exists(0, $data_file) && array_key_exists('product_attribute', $data_file[0]) && (int)$this->profile['import_xls_attribute_number'] > 0;
            if($this->has_attributes) {
                $this->load->model('extension/module/ie_pro_attribute_groups');
                $this->model_extension_module_ie_pro_attribute_groups->create_attribute_groups_from_product($data_file);
                $this->all_attribute_groups = $this->model_extension_module_ie_pro_attribute_groups->get_all_attribute_groups_import_format();

                $this->load->model('extension/module/ie_pro_attributes');
                $this->model_extension_module_ie_pro_attributes->create_attributes_from_product($data_file);
                $this->all_attributes = $this->model_extension_module_ie_pro_attributes->get_all_attributes_import_format();
                $this->all_attributes_simple = $this->model_extension_module_ie_pro_attributes->get_all_attributes_import_format(false);
            }

            $this->has_manufacturers = array_key_exists(0, $data_file) && array_key_exists($this->main_table, $data_file[0]) && array_key_exists('manufacturer_id', $data_file[0][$this->main_table]);
            if($this->has_manufacturers) {
                $this->load->model('extension/module/ie_pro_manufacturers');
                $this->model_extension_module_ie_pro_manufacturers->create_manufacturers_from_product($data_file);
                $this->all_manufacturers = $this->model_extension_module_ie_pro_manufacturers->get_all_manufacturers_import_format();
            }

            $this->has_options = array_key_exists(0, $data_file) && array_key_exists('product_option_value', $data_file[0]);
            if($this->has_options) {

                $first_row = $data_file[0];

                if(!array_key_exists($this->main_table, $first_row) || !array_key_exists($this->product_identificator, $first_row[$this->main_table]))
                    $this->exception(sprintf($this->language->get('progress_import_from_product_creating_options_error_empty_main_field'), $this->product_identificator));

                $this->load->model('extension/module/ie_pro_options');
                $this->model_extension_module_ie_pro_options->create_options_from_product($data_file);
                $this->all_options = $this->model_extension_module_ie_pro_options->get_all_options_import_format();

                $this->load->model('extension/module/ie_pro_option_values');
                $this->model_extension_module_ie_pro_option_values->create_option_values_from_product($data_file);
                $this->all_option_values = $this->model_extension_module_ie_pro_option_values->get_all_option_values_import_format();
            }

            $this->has_downloads = array_key_exists(0, $data_file) && array_key_exists('product_to_download', $data_file[0]);
            if($this->has_downloads) {
                $this->load->model('extension/module/ie_pro_downloads');
                $this->model_extension_module_ie_pro_downloads->create_downloads_from_product($data_file);
                $this->all_downloads = $this->model_extension_module_ie_pro_downloads->get_all_downloads_import_format();
            }
        }

        function get_product_id($field, $value) {
            $sql = "SELECT ".$this->escape_database_field('product_id')." FROM ".$this->escape_database_table_name('product')." WHERE ".$this->escape_database_field($field)." = ".$this->escape_database_value($value);
            $result = $this->db->query($sql);
            return !empty($result->row) && array_key_exists('product_id', $result->row) ? $result->row['product_id'] : '';
        }

        function assign_product_id($main_counter_product_ids) {
            $sql = "SELECT ".$this->escape_database_field('product_id')." FROM ".$this->escape_database_table_name('product')." ORDER BY ".$this->escape_database_field('product_id').' DESC LIMIT 1';
            $result = $this->db->query($sql);
            return !empty($result->row['product_id']) ? (int)$result->row['product_id'] + $main_counter_product_ids : $main_counter_product_ids;
        }


        public function get_product_categories($product_id, $limit = '')
        {
            $result = $this->db->query('SELECT category_id FROM ' . $this->escape_database_table_name('product_to_category') . ' WHERE ' . $this->escape_database_field('product_id') . ' = ' . $this->escape_database_value($product_id) . ' GROUP BY category_id' . (!empty($limit) ? ' LIMIT ' . $limit : ''));
            $final_cat = array();
            if (!empty($result->rows)) {
                foreach ($result->rows as $key => $cat_id) {
                    $final_cat[] = $cat_id['category_id'];
                }
            }
            $final_cat = array_values(array_unique($final_cat));
            return $final_cat;
        }

        public function get_product_manufacturer($product_id) {
            $result = $this->db->query('SELECT manufacturer_id FROM ' . $this->escape_database_table_name('product') . ' WHERE ' . $this->escape_database_field('product_id') . ' = ' . $this->escape_database_value($product_id));
            return array_key_exists('manufacturer_id', $result->row) ? $result->row['manufacturer_id'] : '';
        }
        public function get_product_categories_tree($product_id, $parent_number, $children_number)
        {
            $categories = $this->get_product_categories($product_id);
            $parents = array();
            foreach ($categories as $key => $cat_id) {
                $parents[] = $cat_id;
                $has_parent = true;
                while ($has_parent) {

                    $cat_id = $this->model_extension_module_ie_pro_categories->get_parent_id($cat_id);

                    if ($cat_id)
                        $parents[] = $cat_id;
                    else
                        $has_parent = false;
                }
            }
            $parent_ids = array_unique($parents);

            //Get parents data
            $parent_data = array();
            foreach ($parent_ids as $key => $parent_id) {
                if(array_key_exists($parent_id, $this->all_categories))
                    $parent_data[] = $this->all_categories[$parent_id];
            }

            $final_tree = !empty($parent_data) ? $this->model_extension_module_ie_pro_categories->build_categories_tree($parent_data) : array();
            return $final_tree;
        }

        public function get_product_filters($product_id) {
            $sql = 'SELECT pf.`filter_id`, fi.`filter_group_id`
                    FROM '.$this->escape_database_table_name('product_filter').' pf
                    LEFT JOIN (SELECT * from '.$this->escape_database_table_name('filter').' fi2 ORDER BY fi2.`sort_order` ASC) fi ON(fi.filter_id = pf.filter_id)
                    LEFT JOIN (SELECT * from '.$this->escape_database_table_name('filter_group').' fg ORDER BY fg.`sort_order` ASC) fg ON(fi.filter_group_id = fg.filter_group_id)
                    WHERE product_id = '.$this->escape_database_value($product_id).'
                    ORDER BY fg.sort_order, fi.sort_order';
            $resuls = $this->db->query($sql);

            $final_filters = array();
            if(!empty($resuls->rows)) {
                foreach ($resuls->rows as $key => $fil_info) {
                    $filter_group_id = $fil_info['filter_group_id'];
                    $filter_id = $fil_info['filter_id'];
                    if(!array_key_exists($filter_group_id, $final_filters))
                        $final_filters[$filter_group_id] = array();

                    $final_filters[$filter_group_id][] = $filter_id;
                }
            }

            $final_filters_2 = array();
            foreach ($final_filters as $filter_group_id => $filter_ids) {
                $final_filters_2[] = array(
                    'filter_group_id' => $filter_group_id,
                    'filters' => $filter_ids
                );
            }
            return $final_filters_2;
        }

        /*
         * IMPORTANT - TO THIS FUNCTION WORKS, NEED SET $this->all_attributes variable, example in model ie_pro_export.php
         * */
        public function get_product_attributes($product_id) {
            $prod_attr = $this->db->query('SELECT pa.`attribute_id` FROM '.$this->escape_database_table_name('product_attribute').' pa WHERE pa.product_id = '.$this->escape_database_value($product_id).' GROUP BY pa.`attribute_id`');

            $final_attributes = array();
            foreach ($prod_attr->rows as $key => $attr) {
                $attribute_id = $attr['attribute_id'];
                if(array_key_exists($attribute_id, $this->all_attributes)) {
                    $prod_attr_values = $this->db->query('SELECT pa.`text`, pa.`language_id` FROM '.$this->escape_database_table_name('product_attribute').' pa WHERE pa.product_id = '.$this->escape_database_value($product_id).' AND pa.attribute_id = '.$attribute_id);
                    $temp = array();
                    $temp = $this->all_attributes[$attribute_id];
                    $temp['text'] = array();
                    foreach ($prod_attr_values->rows as $key2 => $attr_text)
                        $temp['text'][$attr_text['language_id']] = $attr_text['text'];

                    $final_attributes[] = $temp;
                }
            }
            return $final_attributes;
        }

        public function get_product_seo_urls($product_id) {
            if($this->is_oc_3x) {
                $final_seo_urls = array();
                $url = $this->db->query('SELECT '.$this->escape_database_field('keyword').','.$this->escape_database_field('language_id').','.$this->escape_database_field('store_id').' FROM '.$this->escape_database_table_name('seo_url').' WHERE '.$this->escape_database_field('query').' = '.$this->escape_database_value('product_id='.$product_id));
                foreach ($url->rows as $key => $seo_url) {
                    if(!array_key_exists($seo_url['store_id'], $final_seo_urls))
                        $final_seo_urls[$seo_url['store_id']] = array();

                    $final_seo_urls[$seo_url['store_id']][$seo_url['language_id']] = $seo_url['keyword'];
                }
                return $final_seo_urls;
            } else {
                $url = $this->db->query('SELECT '.$this->escape_database_field('keyword').' FROM '.$this->escape_database_table_name('url_alias').' WHERE '.$this->escape_database_field('query').' = '.$this->escape_database_value('product_id='.$product_id));
                return array_key_exists('keyword', $url->row) ? $url->row['keyword'] : '';
            }
        }

        public function get_product_specials($product_id) {
            $specials = $this->db->query('SELECT * FROM '.$this->escape_database_table_name('product_special').' WHERE '.$this->escape_database_field('product_id').' = '.$this->escape_database_value($product_id));

            $customer_groups_id = array();
            foreach ($this->customer_groups as $key => $cg) {
                $customer_groups_id[$cg['customer_group_id']] = 1;
            }

            $final_specials = array();
            foreach ($specials->rows as $key => $spe) {
                $cg_id = $spe['customer_group_id'];
                if (array_key_exists($cg_id, $customer_groups_id)) {
                    $number = $customer_groups_id[$cg_id];
                    $customer_groups_id[$cg_id]++;
                    $identificator = $number . '_' . $cg_id;
                    $final_specials[$identificator] = $spe;
                }
            }
            return $final_specials;
        }

        public function get_product_discounts($product_id) {
            $discounts = $this->db->query('SELECT * FROM '.$this->escape_database_table_name('product_discount').' WHERE '.$this->escape_database_field('product_id').' = '.$this->escape_database_value($product_id));

            $customer_groups_id = array();
            foreach ($this->customer_groups as $key => $cg) {
                $customer_groups_id[$cg['customer_group_id']] = 1;
            }

            $final_discounts = array();
            foreach ($discounts->rows as $key => $discount) {
                $cg_id = $discount['customer_group_id'];
                $number = $customer_groups_id[$cg_id];
                $customer_groups_id[$cg_id]++;
                $identificator = $number.'_'.$cg_id;
                $final_discounts[$identificator] = $discount;
            }

            return $final_discounts;
        }

        public function get_product_rewards($product_id) {
            $rewards = $this->db->query('SELECT '.$this->escape_database_field('customer_group_id').', '.$this->escape_database_field('points').' FROM '.$this->escape_database_table_name('product_reward').' WHERE '.$this->escape_database_field('product_id').' = '.$this->escape_database_value($product_id));

            $final_rewards = array();
            foreach ($rewards->rows as $key => $reward) {
                $cg_id = $reward['customer_group_id'];
                $final_rewards[$cg_id] = $reward['points'];
            }

            return $final_rewards;
        }

        public function get_product_related($product_id) {
            $related = $this->db->query('
                SELECT pr.product_id, group_concat(pr.related_id SEPARATOR \'|\') as ids, group_concat(pror.model SEPARATOR \'|\')  as models
                FROM '.$this->escape_database_table_name('product_related').' pr
                LEFT JOIN '.$this->escape_database_table_name('product').' pror ON (pror.product_id = pr.related_id)
                WHERE pr.product_id = '.$this->escape_database_value($product_id).'
            ');

            return !empty($related->row) ? $related->row : array();
        }

        public function get_product_stores($product_id) {
            $stores = $this->db->query('SELECT '.$this->escape_database_field('store_id').' FROM '.$this->escape_database_table_name('product_to_store').' WHERE product_id = '.$this->escape_database_value($product_id));
            $final_stores = array();
            foreach ($stores->rows as $key => $val) {
                $final_stores[] = $val['store_id'];
            }
            return $final_stores;
        }

        public function get_product_layouts($product_id) {
            $layouts = $this->db->query('SELECT '.$this->escape_database_field('layout_id').', '.$this->escape_database_field('store_id').' FROM '.$this->escape_database_table_name('product_to_layout').' WHERE product_id = '.$this->escape_database_value($product_id));
            $final_layouts = array();
            foreach ($layouts->rows as $key => $val) {
                $store_id = $val['store_id'];
                $final_layouts[$store_id] = $val['layout_id'];
            }
            return $final_layouts;
        }

        public function get_product_images($product_id) {
            $related = $this->db->query('
                SELECT '.$this->escape_database_field('image').' FROM '.$this->escape_database_table_name('product_image').'
                WHERE product_id = '.$this->escape_database_value($product_id).' ORDER BY sort_order
            ');

            return !empty($related->rows) ? $related->rows : array();
        }

        public function get_product_downloads($product_id) {
            $downloads = $this->db->query('SELECT '.$this->escape_database_field('download_id').' FROM '.$this->escape_database_table_name('product_to_download').' WHERE product_id = '.$this->escape_database_value($product_id));
            $final_downloads = array();
            foreach ($downloads->rows as $key => $val) {
                $final_downloads[] = $val['download_id'];
            }
            return $final_downloads;
        }

        public function get_product_option_values($product_id) {
            $option_values = $this->db->query('SELECT pov.*, ov.sort_order FROM '.$this->escape_database_table_name('product_option_value').' pov LEFT JOIN '.$this->escape_database_table_name('option_value').' ov ON(pov.option_value_id = ov.option_value_id) WHERE product_id = '.$this->escape_database_value($product_id));
            $final_option_values = array();
            foreach ($option_values->rows as $key => $val) {
                $final_option_values[] = $val;
            }

            $option = $this->db->query('SELECT prodopt.option_id, prodopt.'.$this->product_option_value.', prodopt.required, opt.type  FROM '.$this->escape_database_table_name('product_option').' prodopt LEFT JOIN '.$this->escape_database_table_name('option').' opt ON(opt.option_id = prodopt.option_id) WHERE product_id = '.$this->escape_database_value($product_id));
            $final_options = array();
            foreach ($option->rows as $key => $val) {
                $final_options[$val['option_id']] = $val;
            }

            foreach ($final_option_values as $key => $val) {
                $option_id = $val['option_id'];
                if(array_key_exists($option_id, $final_options)) {
                    $final_option_values[$key]['option'] = $final_options[$option_id];
                }
            }

            return $final_option_values;
        }

        public function get_product_field($product_id, $field) {
            $result = $this->db->query('SELECT '.$this->escape_database_field($field).' FROM '.$this->escape_database_table_name('product').'
                WHERE product_id = '.$this->escape_database_value($product_id));

            return array_key_exists($field, $result->row) ? $result->row[$field] : false;
        }

        public function _importing_process_format_product_description($descriptions, $product_id, $row_file_number) {
            $final_descriptions = array();
            if(!empty($descriptions) && is_array($descriptions)) {
                foreach ($descriptions as $language_id => $fields) {
                    $some_data = array_filter($fields);

                    if(!empty($some_data)) {
                        $fields['language_id'] = $language_id;
                        $fields['product_id'] = $product_id;
                        $final_descriptions[] = $fields;
                    }

                }
            }
            return $final_descriptions;
        }

        public function _importing_process_format_product_image($images, $product_id, $row_file_number) {
            $fnal_images = array();
            if(!empty($images) && is_array($images)) {
                foreach ($images as $language_id => $fields) {
                    $some_data = array_filter($fields);
                    if(!empty($some_data)) {
                        $fields['product_id'] = $product_id;
                        $fnal_images[] = $fields;
                    }

                }
            }
            return $fnal_images;
        }

        public function _importing_process_format_product_to_category($categories, $product_id, $row_file_number) {
            $array_cat_ids = array();
            if($this->cat_tree) {
                $child_number = (int)$this->profile['import_xls_cat_tree_children_number']+1;
                foreach ($categories as $position => $cat_names) {
                    $last_cat_id = false;
                    for ($i = 0; $i < $child_number; $i++) {
                        $parent_id = false;
                        if($i == 0)
                            $cat_names_temp = array_key_exists('name', $cat_names) ? $cat_names['name'] : '';
                        else
                            $cat_names_temp = array_key_exists($i, $cat_names) ? $cat_names[$i]['name'] : '';

                        $some_cat_with_name = false;
                        if(!empty($cat_names_temp)) {
                            foreach ($cat_names_temp as $lang_id => $cat_name) {
                                if(!empty($cat_name)) {
                                    $some_cat_with_name = true;
                                    if ($i == 0)
                                        $previous_parent_id = 0;

                                    $name_formatted = $cat_name . '_' . $previous_parent_id . '_' . $lang_id;

                                    if (array_key_exists($name_formatted, $this->all_categories)) {
                                        $parent_id = $this->all_categories[$name_formatted];
                                        $previous_parent_id = $parent_id;
                                        if(!$this->last_cat_assign)
                                            $array_cat_ids[] = $parent_id;
                                        $last_cat_id = $parent_id;
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if($this->last_cat_assign && $last_cat_id)
                        $array_cat_ids[] = $last_cat_id;
                }
            } else {
                $cat_number = (int)$this->profile['import_xls_cat_number'];
                if(!empty($categories)) {
                    for ($i = 1; $i <= $cat_number; $i++) {
                        $cat_names = array_key_exists($i, $categories) && array_key_exists('category_id', $categories[$i]) ? $categories[$i]['category_id'] : array();
                        $cat_found = $some_cat_with_name = false;
                        foreach ($cat_names as $lang_id => $name) {
                            if (!empty($name)) {
                                $some_cat_with_name = true;
                                if (array_key_exists($name . '_' . $lang_id, $this->all_categories)) {
                                    $array_cat_ids[] = $this->all_categories[$name . '_' . $lang_id];
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            $array_cat_ids = array_unique($array_cat_ids);

            $final_categories = array();
            foreach ($array_cat_ids as $key => $cat_id) {
                $temp = array(
                    'product_id' => $product_id,
                    'category_id' => $cat_id,
                );

                $final_categories[] = $temp;
            }

            return $final_categories;
        }

        public function _importing_process_format_product_attribute($attributes, $product_id, $row_file_number) {
            $final_attributes = array();
            if(!empty($attributes) && is_array($attributes)) {
                foreach ($attributes as $key => $element) {

                    $names = $element['attribute_group'];
                    $attribute_group_id = false;
                    foreach ($names as $lang_id => $name) {
                        if (!empty($name)) {
                            if (array_key_exists($name . '_' . $lang_id, $this->all_attribute_groups)) {
                                $attribute_group_id = $this->all_attribute_groups[$name . '_' . $lang_id];
                                break;
                            }
                        }
                    }

                    $names = array_key_exists('attribute', $element) ? $element['attribute'] : '';
                    if (!empty($names)) {
                        foreach ($names as $lang_id => $name) {
                            $attribute_value = $element['attribute_value'][$lang_id];
                            if (!empty($name) && !empty($attribute_value)) {
                                $index = $name . '_' . $lang_id;

                                if (
                                    (!$attribute_group_id && array_key_exists($index, $this->all_attributes_simple)) ||
                                    (!empty($attribute_group_id) && array_key_exists($attribute_group_id . '_' . $index, $this->all_attributes))
                                ) {
                                    $attribute_id = $this->all_attributes[$attribute_group_id . '_' . $index];
                                    $temp = array(
                                        'product_id' => $product_id,
                                        'attribute_id' => $attribute_id,
                                        'language_id' => $lang_id,
                                        'text' => $attribute_value
                                    );
                                    $final_attributes[] = $temp;
                                }
                            }
                        }
                    }
                }
            }
            return $final_attributes;
        }

        public function _importing_process_format_product_filter($filters, $product_id, $row_file_number) {
            $final_filters = array();
            $filter_number = (int)$this->profile['import_xls_filter_number'];
            if(!empty($filters) && is_array($filters)) {
                foreach ($filters as $key => $element) {
                    $names = $element['name'];
                    $filter_group_id = false;
                    foreach ($names as $lang_id => $name) {
                        if (!empty($name)) {
                            if (array_key_exists($name . '_' . $lang_id, $this->all_filter_groups)) {
                                $filter_group_id = $this->all_filter_groups[$name . '_' . $lang_id];
                                break;
                            }
                        }
                    }

                    for ($i = 1; $i <= $filter_number; $i++) {
                        $names = array_key_exists($i, $element) && array_key_exists('name', $element[$i]) ? $element[$i]['name'] : '';
                        if (!empty($names)) {
                            $found = $some_with_name = false;
                            foreach ($names as $lang_id => $name) {
                                if (!empty($name)) {
                                    $some_with_name = true;
                                    $index = $name . '_' . $lang_id;

                                    if (
                                        (!$filter_group_id && array_key_exists($index, $this->all_filters_simple)) ||
                                        (!empty($filter_group_id) && array_key_exists($filter_group_id . '_' . $index, $this->all_filters))
                                    ) {
                                        $filter_id = $this->all_filters[$filter_group_id . '_' . $index];
                                        $temp = array(
                                            'product_id' => $product_id,
                                            'filter_id' => $filter_id,
                                        );
                                        $final_filters[] = $temp;
                                        break;
                                    }
                                }
                            }
                        }
                    }

                }
            }
            return $final_filters;
        }

        public function _importing_process_format_product_to_download($downloads, $product_id, $row_file_number) {
            $final_downloads = array();
            if(!empty($downloads) && is_array($downloads)) {
                foreach ($downloads as $key => $element) {
                    $names = $element['name'];
                    $found = $some_with_name = false;
                    foreach ($names as $lang_id => $name) {
                        if(!empty($name)) {
                            $some_with_name = true;
                            if(array_key_exists($name.'_'.$lang_id, $this->all_downloads)) {
                                $download_id = $this->all_downloads[$name.'_'.$lang_id];
                                $temp = array(
                                    'product_id' => $product_id,
                                    'download_id' => $download_id,
                                );
                                $final_downloads[] = $temp;
                                break;
                            }
                        }
                    }
                }
            }
            return $final_downloads;
        }

        public function _importing_process_format_seo_url($seo_urls, $product_id, $row_file_number) {
            $query = 'product_id='.$product_id;
            $final_seo_url = array();
            if($this->is_oc_3x) {
                foreach ($seo_urls as $store_id => $names) {
                    foreach ($names['keyword'] as $lang_id => $name) {
                        if(!empty($name)) {
                            $final_seo_url[] = array(
                                'query' => $query,
                                'store_id' => $store_id,
                                'language_id' => $lang_id,
                                'keyword' => $name
                            );
                        }
                    }

                }
            } else {
                $final_seo_url = array(
                    'query' => $query,
                    'keyword' => $seo_urls['keyword']
                );
            }
            return $final_seo_url;
        }

        public function _importing_process_format_product_reward($reward, $product_id, $row_file_number) {
            $final_rewards = array();

            foreach ($reward as $customer_group_id => $points) {
                $points = (int)$points['points'];
                if($points > 0) {
                    $final_rewards[] = array(
                        'product_id' => $product_id,
                        'points' => $points,
                        'customer_group_id' => $customer_group_id,
                    );
                }
            }
            return $final_rewards;
        }

        public function _importing_process_format_product_related($related, $product_id, $row_file_number) {
            $final_related = array();
            $related = explode('|', $related['related']);

            foreach ($related as $key => $model) {
                if(!empty($model)) {
                    $related_id = $this->get_product_id('model', $model);

                    if (empty($related_id) && !array_key_exists($model, $this->products_models))
                        $this->exception(sprintf($this->language->get('progress_import_product_error_product_related_not_found'), $row_file_number, $model, $row_file_number));

                    $related_id = array_key_exists($model, $this->products_models) ? $this->products_models[$model] : $related_id;

                    $final_related[] = array(
                        'product_id' => $product_id,
                        'related_id' => $related_id
                    );
                }
            }
            return $final_related;
        }

        public function _importing_process_format_product_to_store($stores, $product_id, $row_file_number) {
            $final_stores = array();
            $stores = explode('|', $stores['store_id']);

            foreach ($stores as $key => $store_id) {
                $final_stores[] = array(
                    'product_id' => $product_id,
                    'store_id' => $store_id,
                );

            }
            return $final_stores;
        }

        public function _importing_process_format_product_to_layout($layouts, $product_id, $row_file_number) {
            $final_layouts = array();
            if(!empty($layouts) && is_array($layouts)) {
                foreach ($layouts as $store_id => $layout_id) {
                    $final_layouts[] = array(
                        'layout_id' => is_array($layout_id) ? $layout_id['layout_id'] : '',
                        'store_id' => $store_id,
                        'product_id' => $product_id,
                    );

                }
            }
            return $final_layouts;
        }

        public function _importing_process_format_product_special($specials, $product_id, $row_file_number) {
            $final_specials = array();
            if(!empty($specials) && is_array($specials)) {
                foreach ($specials as $number => $special_datas) {
                    foreach ($special_datas as $customer_group_id => $special_data) {
                        $some_special_data = array_filter($special_data);
                        if($some_special_data) {
                            $special_data['product_id'] = $product_id;
                            $special_data['customer_group_id'] = $customer_group_id;
                            $final_specials[] = $special_data;
                        }
                    }
                }
            }
            return $final_specials;
        }

        public function _importing_process_format_product_discount($discounts, $product_id, $row_file_number) {
            $final_discounts = array();
            if(!empty($discounts) && is_array($discounts)) {
                foreach ($discounts as $number => $discount_datas) {
                    foreach ($discount_datas as $customer_group_id => $discount_data) {
                        $some_discount_data = array_filter($discount_data);
                        if($some_discount_data) {
                            $discount_data['product_id'] = $product_id;
                            $discount_data['customer_group_id'] = $customer_group_id;
                            $final_discounts[] = $discount_data;
                        }
                    }
                }
            }
            return $final_discounts;
        }

        public function _importing_process_format_product_option_value($option_values, $row_number, $product_id) {
            $option_id = $option_value_id = $simple_option_value = '';

            if(!empty($option_values)) {
                $option_type = array_key_exists('option_type', $option_values) ? $option_values['option_type'] : '';
                $option_no_values = !empty($option_type) && !in_array($option_type, $this->option_types_with_values);
                $image = array_key_exists('image', $option_values) ? $option_values['image'] : '';
                $sort_order = array_key_exists('sort_order', $option_values) ? $option_values['sort_order'] : '';

                $option_id = false;
                foreach ($this->languages as $key => $lang) {
                    $language_id = $lang['language_id'];
                    $option_name = array_key_exists($language_id, $option_values) && array_key_exists('option_name', $option_values[$language_id]) ? $option_values[$language_id]['option_name'] : '';

                    if (!empty($option_name)) {
                        if (empty($option_type))
                            $this->exception(sprintf($this->language->get('progress_import_from_product_creating_option_values_error_option_type'), ($row_number+2), $option_name));

                        $index = $option_name . '_' . $option_type . '_' . $language_id;

                        if (array_key_exists($index, $this->all_options)) {
                            $option_id = $this->all_options[$index];
                            break;
                        }
                    }
                }


                foreach ($this->languages as $key => $lang) {
                    $language_id = $lang['language_id'];
                    $option_value_name = array_key_exists($language_id, $option_values) && array_key_exists('name', $option_values[$language_id]) ? $option_values[$language_id]['name'] : '';

                    if (!empty($option_value_name) && !$option_no_values) {
                        $index = $option_id . '_' . $option_value_name . '_' . $language_id;
                        if (array_key_exists($index, $this->all_option_values)) {
                            $option_value_id = $this->all_option_values[$index];
                            break;
                        }
                    } elseif (!empty($option_value_name) && $option_no_values) {
                        $simple_option_value = $option_value_name;
                        break;
                    }
                }
            }

            foreach ($this->languages as $key => $lang) {
                $lang_id = $lang['language_id'];
                if(array_key_exists($lang_id, $option_values))
                    unset($option_values[$lang_id]);
            }

            $option_values['required'] = array_key_exists('option_required', $option_values) ? $option_values['option_required'] : '';
            $option_values['option_id'] = $option_id;
            $option_values['option_value_id'] = $option_value_id;
            $option_values['value'] = $simple_option_value;

            if(!empty(array_filter($option_values)))
                $option_values['product_id'] = $product_id;

            if(!$option_id)
                $option_values = array();

            return $option_values;
        }

        public function _exporting_process_product_to_category($current_data, $product_id, $columns) {

            if(!$this->cat_tree) {
                $cat_number = $this->profile['import_xls_cat_number'];
                $categories = $this->get_product_categories($product_id, $cat_number);

                foreach ($categories as $position => $cat_id) {
                    $real_position = $position + 1;

                    foreach ($columns as $key => $col_info) {
                        $identificator_split = explode('_', $col_info['identificator']);
                        if ($real_position == $identificator_split[0]) {
                            foreach ($this->languages as $key2 => $lang) {
                                if ($identificator_split[1] == $lang['language_id']) {
                                    $current_data[$col_info['custom_name']] = array_key_exists($cat_id, $this->all_categories) && array_key_exists($lang['language_id'], $this->all_categories[$cat_id]['name']) ? $this->all_categories[$cat_id]['name'][$lang['language_id']] : '';
                                    break;
                                }
                            }
                        }
                    }
                }
            } else {
                $cat_parent_number = $this->profile['import_xls_cat_tree_number'];
                $cat_children_number = $this->profile['import_xls_cat_tree_children_number'];

                $categories_tree = $this->get_product_categories_tree($product_id, $cat_parent_number, $cat_children_number);
                $temp_branches = array();

                foreach($categories_tree as $c) {
                    $array = $this->_get_all_category_branches($c['childrens'], $c) ;
                    foreach($array as $a) {
                        array_push($temp_branches,$a);
                    }
                }

                $categories_tree = $temp_branches;

                foreach ($categories_tree as $position => $cat_info) {
                    $cat_id = $cat_info['category_id'];
                    $real_position = $position+1;
                    foreach ($columns as $key => $col_info) {
                         $identificator_split = explode('_', $col_info['identificator']);
                         if($real_position == $identificator_split[0]) {
                             foreach ($this->languages as $key2 => $lang) {
                                 if (count($identificator_split) == 2) { //Parent category
                                     if ($identificator_split[1] == $lang['language_id']) {
                                         $current_data[$col_info['custom_name']] = array_key_exists($cat_id, $this->all_categories) && array_key_exists($lang['language_id'], $this->all_categories[$cat_id]['name']) ? $this->all_categories[$cat_id]['name'][$lang['language_id']] : '';
                                         break;
                                     }
                                 } else { //Children category
                                     $deep_childrens = $identificator_split[1];
                                     $language_id = $identificator_split[2];

                                     $exist_children = true;
                                     $current_category = $cat_info;

                                     for ($i = 0; $i < $deep_childrens; $i++) {
                                         if (!empty($current_category['childrens']))
                                             $current_category = $current_category['childrens'][0];
                                         else
                                             $exist_children = false;
                                     }
                                     if ($exist_children) {
                                         $cat_id_temp = $current_category['category_id'];
                                         if (array_key_exists($language_id, $current_category['name']))
                                             $current_data[$col_info['custom_name']] = $this->all_categories[$cat_id_temp]['name'][$language_id];
                                     }
                                 }
                             }
                         }
                    }
                }
            }
            return $current_data;
        }

        function _get_all_category_branches($c1,$c2) {
              $Array = array();

              foreach($c1 as $c3) {
                if (!empty($c3['childrens'])) {
                    array_push($Array,array('name'=>$c2['name'],'parent_id'=>$c2['parent_id'],'category_id'=>$c2['category_id'],'childrens'=>$this->_get_all_category_branches($c3['childrens'], $c3))) ;
                }

                else {

                    $arrayC = array($c3);
                    array_push($Array,array('name'=>$c2['name'],'parent_id'=>$c2['parent_id'],'category_id'=>$c2['category_id'],'childrens'=>$arrayC));
                }
            }
              return $Array;
        }

        public function _exporting_process_product_filter($current_data, $product_id, $columns) {
            $filter_group_number = $this->profile['import_xls_filter_group_number'];
            $filter_filter_number = $this->profile['import_xls_filter_number'];
            $filters = $this->get_product_filters($product_id, $filter_group_number, $filter_filter_number);
            foreach ($filters as $filter_group_position => $fg_info) {
                $filter_group_id = $fg_info['filter_group_id'];
                $filters = $fg_info['filters'];
                $real_position = $filter_group_position+1;
                if(!empty($filter_group_id)) {
                    foreach ($columns as $key => $col_info) {
                        $identificator_split = explode('_', $col_info['identificator']);
                        if ($real_position == $identificator_split[0]) {
                            foreach ($this->languages as $key2 => $lang) {
                                if (count($identificator_split) == 2) { //Filter group
                                    if ($identificator_split[1] == $lang['language_id']) {
                                        $current_data[$col_info['custom_name']] = array_key_exists($filter_group_id, $this->all_filters) && array_key_exists($lang['language_id'], $this->all_filters[$filter_group_id]['name']) ? $this->all_filters[$filter_group_id]['name'][$lang['language_id']] : '';
                                        break;
                                    }
                                } else { //Filter
                                    $deep_filter = $identificator_split[1] - 1;
                                    $language_id = $identificator_split[2];

                                    $filter_id = array_key_exists($deep_filter, $filters) ? $filters[$deep_filter] : '';
                                    if (!empty($filter_id) && array_key_exists($filter_id, $this->all_filters[$filter_group_id]['filters']) && array_key_exists($language_id, $this->all_filters[$filter_group_id]['filters'][$filter_id]['name'])) {
                                        $current_data[$col_info['custom_name']] = $this->all_filters[$filter_group_id]['filters'][$filter_id]['name'][$language_id];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $current_data;
        }

        public function _exporting_process_product_attribute($current_data, $product_id, $columns) {
            $attribute_number = $this->profile['import_xls_attribute_number'];
            $attributes = $this->get_product_attributes($product_id);
            foreach ($columns as $key => $col_info) {
                 $identificator_split = explode('_', $col_info['identificator']);
                 $position = $identificator_split[0]-1;
                 $language_id = $identificator_split[1];

                 $is_attribute_group = $col_info['field'] == 'attribute_group';
                 $is_attribute = $col_info['field'] == 'attribute';
                 $is_attribute_value = $col_info['field'] == 'attribute_value';

                 if(array_key_exists($position, $attributes)) {
                     foreach ($this->languages as $key2 => $lang) {
                         if($language_id == $lang['language_id']) {
                             $index = $is_attribute_group ? 'attribute_group_name' : ($is_attribute ? 'name' : ($is_attribute_value ? 'text' : ''));
                             if(!empty($index) && array_key_exists($lang['language_id'], $attributes[$position][$index]) && !empty($attributes[$position][$index][$lang['language_id']])) {
                                 $current_data[$col_info['custom_name']] = $attributes[$position][$index][$lang['language_id']];
                             }
                         }
                     }
                 }
            }
            return $current_data;
        }

        public function _exporting_process_seo_url($current_data, $product_id, $columns) {
            $seo_urls = $this->get_product_seo_urls($product_id);
            if($this->is_oc_3x) {
                foreach ($columns as $key => $col_info) {
                    $store_id = $col_info['store_id'];
                    $language_id = !array_key_exists('language_id', $col_info) ? $this->default_language_id : $col_info['language_id'];
                    foreach ($seo_urls as $seo_url_store_id => $seo_url_names) {
                        if ($store_id == $seo_url_store_id && array_key_exists($language_id, $seo_url_names) && !empty($seo_url_names[$language_id]))
                            $current_data[$col_info['custom_name']] = $seo_url_names[$language_id];
                    }
                }
            } else {
                foreach ($columns as $key => $col_info) {
                    $current_data[$col_info['custom_name']] = $seo_urls;
                }
            }
            return $current_data;
        }

        public function _exporting_process_product_special($current_data, $product_id, $columns) {
            $product_specials = $this->get_product_specials($product_id);

            if(!empty($product_specials)) {
                foreach ($columns as $key => $col_info) {
                    $identificator = $col_info['identificator'];
                    $field = $col_info['field'];
                    if(array_key_exists($identificator, $product_specials) && array_key_exists($field, $product_specials[$identificator])) {
                        $current_data[$col_info['custom_name']] = $product_specials[$identificator][$field];
                    }
                }
            }
            return $current_data;
        }

        public function _exporting_process_product_discount($current_data, $product_id, $columns) {
            $product_discounts = $this->get_product_discounts($product_id);
            if(!empty($product_discounts)) {
                foreach ($columns as $key => $col_info) {
                    $identificator = $col_info['identificator'];
                    $field = $col_info['field'];
                    if(array_key_exists($identificator, $product_discounts) && array_key_exists($field, $product_discounts[$identificator])) {
                        $current_data[$col_info['custom_name']] = $product_discounts[$identificator][$field];
                    }
                }
            }
            return $current_data;
        }

        public function _exporting_process_product_related($current_data, $product_id, $columns) {
            $related = $this->get_product_related($product_id);
            $some_related = !empty($related['models']);
            if(!empty($some_related)) {
                foreach ($columns as $key => $col_info) {
                    $current_data[$col_info['custom_name']] = $related['models'];
                }
            }
            return $current_data;
        }

        public function _exporting_process_product_reward($current_data, $product_id, $columns) {
            $rewards = $this->get_product_rewards($product_id);

            if(!empty($rewards)) {
                foreach ($columns as $key => $col_info) {
                    $identificator = $col_info['identificator'];
                    if(array_key_exists($identificator, $rewards)) {
                        $current_data[$col_info['custom_name']] = $rewards[$identificator];
                    }
                }
            }
            return $current_data;
        }

        public function _exporting_process_product_image($current_data, $product_id, $columns) {
            $images = $this->get_product_images($product_id);
            if(!empty($images)) {
                foreach ($columns as $key => $col_info) {
                    $identificator = $col_info['identificator']-1;
                    if(array_key_exists($identificator, $images)) {
                        $current_data[$col_info['custom_name']] = $images[$identificator]['image'];
                    }
                }
            }
            return $current_data;
        }

        public function _exporting_process_product_manufacturer($current_data, $product_id, $columns) {
            $manufacturer_id = $this->get_product_manufacturer($product_id);
            if(!empty($manufacturer_id)) {
                foreach ($columns as $key => $col_info) {
                     $language_id = array_key_exists('language_id', $col_info) && !empty($col_info['language_id']) ? $col_info['language_id'] : $this->default_language_id;
                     $current_data[$col_info['custom_name']] = array_key_exists($manufacturer_id, $this->all_manufacturers) && array_key_exists($language_id, $this->all_manufacturers[$manufacturer_id]) ? $this->all_manufacturers[$manufacturer_id][$language_id] : '';
                }
            }
            return $current_data;
        }

        public function _exporting_process_product_to_store($current_data, $product_id, $columns) {
            $stores = $this->get_product_stores($product_id);

            if(!empty($stores)) {
                foreach ($columns as $key => $col_info) {
                    $current_data[$col_info['custom_name']] = implode('|',$stores);
                }
            }
            return $current_data;
        }

        public function _exporting_process_product_to_layout($current_data, $product_id, $columns) {
            $layouts = $this->get_product_layouts($product_id);

            if(!empty($layouts)) {
                foreach ($columns as $key => $col_info) {
                    $name_instead_id = array_key_exists('name_instead_id', $col_info) && $col_info['name_instead_id'];
                    $conversion_global_var = array_key_exists('conversion_global_var', $col_info) && $col_info['conversion_global_var'] ? $col_info['conversion_global_var'] : '';

                    $store_id = $col_info['store_id'];
                    if(array_key_exists($store_id, $layouts)) {
                        $layout_id = $layouts[$store_id];
                        $current_data[$col_info['custom_name']] = $name_instead_id && $conversion_global_var && array_key_exists($layout_id, $this->{$conversion_global_var}) ? $this->{$conversion_global_var}[$layout_id] : $layout_id;
                    }
                }
            }
            return $current_data;
        }

        public function _exporting_process_product_to_download($current_data, $product_id, $columns) {
            $downloads = $this->get_product_downloads($product_id);
            if(!empty($downloads)) {
                foreach ($columns as $key => $col_info) {
                    $identificator_split = explode('_', $col_info['identificator']);
                    $position = $identificator_split[0] - 1;
                    $language_id = array_key_exists(1, $identificator_split) ? $identificator_split[1] : '';

                    $is_name = $col_info['field'] == 'name';
                    if (array_key_exists($position, $downloads)) {
                        $download_id = $downloads[$position];
                        if (array_key_exists($download_id, $this->all_downloads)) {
                            if ($is_name && array_key_exists($language_id, $this->all_downloads[$download_id]['name']))
                                $current_data[$col_info['custom_name']] = $this->all_downloads[$download_id]['name'][$language_id];
                            else
                                $current_data[$col_info['custom_name']] = $this->all_downloads[$download_id][$col_info['field']];
                        }
                    }
                }
            }
            return $current_data;
        }

        public function _exporting_process_product_option_value($product_id, $columns) {
            $new_columns = array();
            $product_option_values = $this->get_product_option_values($product_id);

            if(!empty($product_option_values)) {
                foreach ($product_option_values as $key => $opval) {
                    $optval_id = $opval['option_value_id'];
                    $optval_name = array_key_exists($optval_id, $this->all_option_values) ? $this->all_option_values[$optval_id]['name'] : '';
                    $opt_name = array_key_exists($optval_id, $this->all_option_values) ? $this->all_option_values[$optval_id]['option']['name'] : '';
                    $temp = array();
                    if(!empty($optval_id)) {
                        foreach ($columns as $key => $col_info) {
                            $language_id = array_key_exists('language_id', $col_info) ? $col_info['language_id'] : '';
                            $field_name = $col_info['field'];
                            $is_option_field = strpos($field_name, 'option_') !== false;
                            $field_name = $is_option_field ? str_replace('option_', '', $field_name) : $field_name;
                            $final_field = $is_option_field ? $opval['option'] : $opval;
                            if (!$language_id && array_key_exists($field_name, $final_field))
                                $temp[$col_info['custom_name']] = $final_field[$field_name];
                            else if ($language_id && $is_option_field && is_array($opt_name) && array_key_exists($language_id, $opt_name))
                                $temp[$col_info['custom_name']] = $opt_name[$language_id];
                            else if ($language_id && !$is_option_field && is_array($optval_name) && array_key_exists($language_id, $optval_name))
                                $temp[$col_info['custom_name']] = $optval_name[$language_id];
                        }
                        if (!empty($temp)) {
                            $new_columns[] = $temp;
                        }
                    }
                }

            }

            return $new_columns;
        }

        public function delete_element($element_id) {
            foreach ($this->delete_tables_special as $key => $table_name) {
                if(array_key_exists($table_name, $this->database_schema)) {
                    if(in_array($table_name, array('seo_url', 'url_alias')))
                        $this->db->query("DELETE FROM ".$this->escape_database_table_name($table_name)." WHERE ".$this->escape_database_field('query')." = ".$this->escape_database_value($this->main_field.'='.(int)$element_id));
                    else if($table_name == 'product_related')
                        $this->db->query("DELETE FROM ".$this->escape_database_table_name($table_name)." WHERE related_id = '" . (int)$element_id . "'");
                }
            }
            parent::delete_element($element_id);
            $this->cache->delete('product');
        }
    }
?>