<?php
    class ModelExtensionModuleIeProTabProfiles extends ModelExtensionModuleIePro {
        public function __construct($registry) {
            parent::__construct($registry);

            $this->filter_conditionals_number = array(
                '>=' => '≥',
                '<=' => '≤',
                '>' => '&gt;',
                '<' => '&lt;',
                '=' => '=',
                '!=' => '≠',
            );

            $this->filter_conditionals_string = array(
                'like' => $this->language->get('profile_products_filters_conditional_contain'),
                'not_like' => $this->language->get('profile_products_filters_conditional_not_contain'),
                '=' => $this->language->get('profile_products_filters_conditional_is_exactly'),
                '!=' => $this->language->get('profile_products_filters_conditional_is_not_exactly'),
            );

            $this->filter_conditionals_date = array(
                '>=' => '≥',
                '<=' => '≤',
                '>' => '&gt;',
                '<' => '&lt;',
                '=' => '=',
                '!=' => '≠',
                'like' => $this->language->get('profile_products_filters_conditional_contain'),
                'not_like' => $this->language->get('profile_products_filters_conditional_not_contain'),
                'years_ago' => $this->language->get('profile_products_filters_conditional_years_ago'),
                'months_ago' => $this->language->get('profile_products_filters_conditional_months_ago'),
                'days_ago' => $this->language->get('profile_products_filters_conditional_days_ago'),
                'hours_ago' => $this->language->get('profile_products_filters_conditional_hours_ago'),
                'minutes_ago' => $this->language->get('profile_products_filters_conditional_minutes_ago'),
            );

            $this->filter_conditionals_boolean = array(
                '0' => $this->language->get('profile_products_filters_conditional_is_yes'),
                '1' => $this->language->get('profile_products_filters_conditional_is_no'),
            );

            $this->filter_field_types = array(
                'number',
                'string',
                'date',
                'boolean',
            );

            $this->conditionals = array(
                'AND' => $this->language->get('profile_products_filters_main_conditional_and'),
                'OR' => $this->language->get('profile_products_filters_main_conditional_or'),
            );

            $this->product_identificators = array(
                'product_id' => $this->language->get('profile_product_identificator_product_id'),
                'model' => $this->language->get('profile_product_identificator_model'),
                'sku' => $this->language->get('profile_product_identificator_sku'),
                'upc' => $this->language->get('profile_product_identificator_upc'),
                'ean' => $this->language->get('profile_product_identificator_ean'),
                'jan' => $this->language->get('profile_product_identificator_jan'),
                'isbn' => $this->language->get('profile_product_identificator_isbn'),
                'mpn' => $this->language->get('profile_product_identificator_mpn'),
            );

            $this->load->language($this->real_extension_type.'/ie_pro_tab_profiles');

            $this->possible_values_text = $this->language->get('profile_products_columns_possible_values');
        }

        public function get_fields() {
            $this->document->addScript($this->api_url.'/opencart_admin/ext_ie_pro/js/tab_profiles.js?'.date('Ymdhis'));
            $this->document->addStyle($this->api_url.'/opencart_admin/ext_ie_pro/css/tab_profiles.css?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'/opencart_admin/ext_ie_pro/js/jquery-sortable.js?'.date('Ymdhis'));

            $ie_categories = array(
                '' => $this->language->get('select_empty'),
                'products' => $this->language->get('profile_i_want_products'),
                'specials' => $this->language->get('profile_i_want_specials'),
                'discounts' => $this->language->get('profile_i_want_discounts'),
                'categories' => $this->language->get('profile_i_want_categories'),
                'attribute_groups' => $this->language->get('profile_i_want_attribute_groups'),
                'attributes' => $this->language->get('profile_i_want_attributes'),
                'options' => $this->language->get('profile_i_want_options'),
                'option_values' => $this->language->get('profile_i_want_option_values'),
                'manufacturers' => $this->language->get('profile_i_want_manufacturers'),
                'filter_groups' => $this->language->get('profile_i_want_filter_groups'),
                'filters' => $this->language->get('profile_i_want_filters'),
                'customer_groups' => $this->language->get('profile_i_want_customer_groups'),
                'customers' => $this->language->get('profile_i_want_customers'),
                'addresses' => $this->language->get('profile_i_want_addresses'),
                'orders' => $this->language->get('profile_i_want_orders'),
                'coupons' => $this->language->get('profile_i_want_coupons'),
            );

            $spread_sheet_account_id = $this->spread_sheet_get_account_id();
            
            $this->load->model('extension/module/ie_pro_categories');
            $categories_select_format = $this->model_extension_module_ie_pro_categories->get_all_categories_branches_select();

            $this->load->model('extension/module/ie_pro_manufacturers');
            $manufacturers_select_format = $this->model_extension_module_ie_pro_manufacturers->get_all_manufacturers_import_format(true);


            $dir_catalog = str_replace('/catalog', '', DIR_CATALOG);
            $catalog_folder_split = explode('/', $dir_catalog);
            $folders = array();
            foreach ($catalog_folder_split as $key => $folder) {
                if($folder != '')
                    $folders[] = $folder;

                if(count($folders) == 2)
                    break;
            }
            $final_out_folder = '/'.implode('/', $folders).'/';

            $fields = array(
                array(
                    'type' => 'legend',
                    'text' => '<i class="fa fa-user"></i>'.$this->language->get('profile_legend_text'),
                    'remove_border_button' => true,
                ),
                array(
                    'label' => $this->language->get('profile_select_text'),
                    'type' => 'select',
                    'options' => $this->profiles_select,
                    'name' => 'profiles',
                    'onchange' => 'profile_load($(this))',
                    'columns' => 3
                ),

                array(
                    'type' => 'html_code',
                    'html_code' => '- '.$this->language->get('profile_or').' -',
                    'columns' => 3,
                    'class_container' => 'or',
                ),

                array(
                    'type' => 'html_code',
                    'label' => $this->language->get('profile_create_text'),
                    'html_code' => '
                        <a class="profile_create_link" href="javascript:{}" onclick="profile_create(\'import\')"><i class="fa fa-upload"></i>'.$this->language->get('profile_create_import_text').'</a><input type="hidden" name="profile_type" value=""><input type="hidden" name="profile_id" value="">
                        <a class="profile_create_link" href="javascript:{}" onclick="profile_create(\'export\')"><i class="fa fa-download"></i>'.$this->language->get('profile_create_export_text').'</a>
                    ',
                    'columns' => 3
                ),

                array(
                    'type' => 'legend',
                    'text' => '<i class="fa fa-upload"></i>'.$this->language->get('profile_legend_text_import'),
                    'remove_border_button' => true,
                    'class_container' => 'profile_import',
                    'style' => 'margin-top: 17px;'
                ),

                array(
                    'type' => 'legend',
                    'text' => '<i class="fa fa-download"></i>'.$this->language->get('profile_legend_text_export'),
                    'remove_border_button' => true,
                    'class_container' => 'profile_export',
                    'style' => 'margin-top: 17px;'
                ),

                array(
                    'label' => $this->language->get('profile_import_file_format'),
                    'type' => 'select',
                    'options' => array(
                        'xlsx' => '.xlsx',
                        'csv' => '.csv',
                        'xml' => '.xml',
                        'ods' => '.ods',
                        'spreadsheet' => 'Google Spreadsheet'
                    ),
                    'name' => 'file_format',
                    'class_container' => 'profile_import profile_export main_configuration configuration',
                    'onchange' => 'profile_check_format($(this).val())',
                    'after' => '<br>'.$this->get_remodal('mapping_xml_columns', $this->language->get('profile_import_mapping_xml_columns_remodal_title'), sprintf($this->language->get('profile_import_mapping_xml_columns_remodal_description'), $this->get_image_link('xml_mapping_example_1.jpg'), $this->get_image_link('xml_mapping_example_2.jpg'), $this->get_image_link('xml_mapping_example_3.jpg'), $this->get_image_link('xml_mapping_example_4.jpg')), array('button_cancel' => false, 'link' => 'profile_import_mapping_xml_columns_link_title')),
                ),

                array(
                    'label' => $this->language->get('profile_import_csv_separator'),
                    'help' => $this->language->get('profile_import_csv_separator_help'),
                    'type' => 'text',
                    'name' => 'csv_separator',
                    'class_container' => 'profile_import profile_export csv_separator main_configuration configuration',
                ),

                array(
                    'label' => $this->language->get('profile_import_xml_node'),
                    'type' => 'text',
                    'name' => 'node_xml',
                    'class_container' => 'profile_import profile_export node_xml main_configuration configuration',
                    'after' => '<a href="javascript:{}" data-remodal-target="profile_import_xml_node">'.$this->language->get('profile_import_xml_node_link').'</a>'.$this->get_remodal('profile_import_xml_node', $this->language->get('profile_import_xml_node_remodal_title'), sprintf($this->language->get('profile_import_xml_node_remodal_description'), $this->get_image_link('xml_node.jpg'), $this->get_image_link('xml_node_columns.jpg')), array('button_cancel' => false, 'button_confirm' => false)),
                ),

                array(
                    'label' => $this->language->get('profile_import_file_origin'),
                    'type' => 'select',
                    'options' => array(
                        'manual' => $this->language->get('profile_import_file_origin_manual'),
                        'ftp' => $this->language->get('profile_import_file_origin_ftp'),
                        'url' => $this->language->get('profile_import_file_origin_url'),
                    ),
                    'name' => 'file_origin',
                    'class_container' => 'profile_import file_origin main_configuration configuration no_refresh_columns',
                    'onchange' => 'profile_import_check_origin($(this).val())'
                ),

                array(
                    'label' => $this->language->get('profile_import_file_destiny'),
                    'type' => 'select',
                    'options' => array(
                        'download' => $this->language->get('profile_import_file_download'),
                        'server' => $this->language->get('profile_import_file_destiny_server'),
                        'external_server' => $this->language->get('profile_import_file_destiny_external_server'),
                    ),
                    'name' => 'file_destiny',
                    'class_container' => 'profile_export file_destiny main_configuration configuration no_refresh_columns',
                    'onchange' => 'profile_export_check_destiny($(this).val())'
                ),

                array(
                    'label' => $this->language->get('profile_import_file_destiny_server_path'),
                    'type' => 'text',
                    'name' => 'file_destiny_server_path',
                    'class_container' => 'profile_export server main_configuration configuration',
                    'after' => '<a href="javascript:{}" data-remodal-target="profile_export_file_destiny_server_path">'.$this->language->get('profile_import_file_destiny_server_path_remodal_link').'</a>'.$this->get_remodal('profile_export_file_destiny_server_path', $this->language->get('profile_import_file_destiny_server_path_remodal_title'), sprintf($this->language->get('profile_import_file_destiny_server_path_remodal_description'), $dir_catalog,$dir_catalog,$dir_catalog,$dir_catalog,$final_out_folder), array('button_cancel' => false, 'button_confirm' => false, '')),
                ),

                array(
                    'label' => $this->language->get('profile_import_file_destiny_server_file_name'),
                    'help' => $this->language->get('profile_import_file_destiny_server_file_name_help'),
                    'type' => 'text',
                    'name' => 'file_destiny_server_file_name',
                    'class_container' => 'profile_export server main_configuration configuration',
                ),

                array(
                    'label' => $this->language->get('profile_import_file_destiny_server_file_name_sufix'),
                    'type' => 'select',
                    'options' => array(
                        '' => $this->language->get('profile_import_file_destiny_server_file_name_sufix_none'),
                        'date' => $this->language->get('profile_import_file_destiny_server_file_name_sufix_date'),
                        'datetime' => $this->language->get('profile_import_file_destiny_server_file_name_sufix_datetime'),
                    ),
                    'name' => 'file_destiny_server_file_name_sufix',
                    'class_container' => 'profile_export server main_configuration configuration no_refresh_columns',
                ),

                array(
                    'label' => $this->language->get('profile_import_url'),
                    'type' => 'text',
                    'name' => 'url',
                    'class_container' => 'profile_import url main_configuration configuration'
                ),

                array(
                    'label' => $this->language->get('profile_import_ftp_host'),
                    'type' => 'text',
                    'name' => 'ftp_host',
                    'class_container' => 'profile_import profile_export ftp main_configuration configuration'
                ),

                array(
                    'label' => $this->language->get('profile_import_ftp_username'),
                    'type' => 'text',
                    'name' => 'ftp_username',
                    'class_container' => 'profile_import profile_export ftp main_configuration configuration'
                ),

                array(
                    'label' => $this->language->get('profile_import_ftp_password'),
                    'type' => 'text',
                    'name' => 'ftp_password',
                    'class_container' => 'profile_import profile_export ftp main_configuration configuration'
                ),

                array(
                    'label' => $this->language->get('profile_import_ftp_port'),
                    'help' => $this->language->get('profile_import_ftp_port_help'),
                    'type' => 'text',
                    'name' => 'ftp_port',
                    'class_container' => 'profile_import profile_export ftp main_configuration configuration',
                    'default' => '21'
                ),

                array(
                    'label' => $this->language->get('profile_import_ftp_path'),
                    'help' => $this->language->get('profile_import_ftp_path_help'),
                    'type' => 'text',
                    'name' => 'ftp_path',
                    'class_container' => 'profile_import profile_export ftp main_configuration configuration',
                ),

                array(
                    'label' => $this->language->get('profile_import_ftp_file'),
                    'help' => $this->language->get('profile_import_ftp_file_help'),
                    'type' => 'text',
                    'name' => 'ftp_file',
                    'class_container' => 'profile_import profile_export ftp main_configuration configuration',
                ),

                array(
                    'label' => $this->language->get('profile_import_spreadsheet_name'),
                    'help' => $this->language->get('profile_import_spreadsheet_name_help'),
                    'type' => 'text',
                    'name' => 'spreadsheet_name',
                    'class_container' => 'profile_import profile_export spreadsheet_name main_configuration configuration',
                    'after' => $this->get_remodal('profile_import_spreadsheet_remodal', $this->language->get('profile_import_spreadsheet_remodal_title'), sprintf($this->language->get('profile_import_spreadsheet_remodal_description'), $this->get_image_link('google_spreadsheet_create_googl_drive_api.gif'), '<input name="spreadsheet_json" type="file">', $spread_sheet_account_id), array('link' => 'profile_import_spreadsheet_remodal_link', 'remodal_options' => 'closeOnConfirm: false, hashTracking: false')),
                ),

                array(
                    'label' => $this->language->get('profile_i_want'),
                    'type' => 'select',
                    'options' => $ie_categories,
                    'name' => 'i_want',
                    'class_container' => 'profile_import profile_export main_configuration configuration',
                    'onchange' => 'profile_check_i_want()'
                ),

                array(
                    'type' => 'legend',
                    'text' => '<i class="fa fa-cog"></i>'.$this->language->get('profile_import_products_legend'),
                    'remove_border_button' => true,
                    'class_container' => 'profile_import profile_export configuration products',
                ),

                array(
                    'label' => $this->language->get('profile_import_products_strict_update'),
                    'after' => '<a href="javascript:{}" data-remodal-target="profile_strict_update">'.$this->language->get('profile_import_products_strict_update_link').'</a>'.$this->get_remodal('profile_strict_update', $this->language->get('profile_import_products_strict_update'), sprintf($this->language->get('profile_import_products_strict_update_help'), $this->get_image_link('strict_update_images_1.jpg'), $this->get_image_link('strict_update_images_2.jpg'), $this->get_image_link('strict_update_images_3.jpg')), array('button_cancel' => false, 'button_confirm' => false)),
                    'type' => 'boolean',
                    'name' => 'strict_update',
                    'class_container' => 'profile_import configuration products no_refresh_columns',
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_products_multilanguage'),
                    'after' => '<a href="javascript:{}" data-remodal-target="profile_multilanguage">'.$this->language->get('profile_import_products_strict_update_link').'</a>'.$this->get_remodal('profile_multilanguage', $this->language->get('profile_import_products_multilanguage'), $this->language->get('profile_import_products_multilanguage_help'), array('button_cancel' => false, 'button_confirm' => false)),
                    'type' => 'boolean',
                    'name' => 'multilanguage',
                    'class_container' => 'profile_import profile_export configuration products',
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_products_category_tree'),
                    'type' => 'boolean',
                    'name' => 'category_tree',
                    'after' => $this->get_remodal('profile_cat_tree', $this->language->get('profile_import_products_profile_cat_tree_remodal_title'), sprintf($this->language->get('profile_import_products_profile_cat_tree_remodal_description'), $this->get_image_link('excel_example_categories.jpg'), $this->get_image_link('excel_example_categories_tree.jpg')), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_import_products_profile_cat_tree_link_title')),
                    'class_container' => 'profile_import profile_export configuration products',
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_products_category_tree_last_child'),
                    'type' => 'boolean',
                    'name' => 'category_tree_last_child',
                    'after' => '<a href="javascript:{}" data-remodal-target="profile_cat_last_tree_assign">'.$this->language->get('profile_import_products_strict_update_link').'</a>'.$this->get_remodal('profile_cat_last_tree_assign', $this->language->get('profile_import_products_category_tree_last_child_modal_title'), sprintf($this->language->get('profile_import_products_category_tree_last_child_modal_description'), $this->get_image_link('strict_update_disabled.jpg'), $this->get_image_link('strict_update_enabled.jpg')), array('button_cancel' => false, 'button_confirm' => false)),
                    'class_container' => 'profile_import configuration products no_refresh_columns',
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_products_sum_tax'),
                    'after' => $this->get_remodal('sum_tax', $this->language->get('profile_import_products_sum_tax_remodal_title'), $this->language->get('profile_import_products_sum_tax_remodal_description'), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_import_products_sum_tax_link_title')),
                    'type' => 'boolean',
                    'name' => 'sum_tax',
                    'class_container' => 'profile_import profile_export configuration products no_refresh_columns',
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_products_rest_tax'),
                    'after' => $this->get_remodal('rest_tax', $this->language->get('profile_import_products_rest_tax_remodal_title'), $this->language->get('profile_import_products_rest_tax_remodal_description'), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_import_products_rest_tax_link_title')).'<div style="clear:both;"></div>',
                    'type' => 'boolean',
                    'name' => 'rest_tax',
                    'class_container' => 'profile_import profile_export configuration products no_refresh_columns',
                    'columns' => 3,
                ),

                array(
                    'label' => $this->language->get('profile_product_identificator'),
                    'type' => 'select',
                    'name' => 'product_identificator',
                    'options' => $this->product_identificators,
                    'class_container' => 'profile_import configuration products no_refresh_columns',
                    'columns' => 3
                ),
                array(
                    'label' => $this->language->get('profile_import_products_autoseo_gerator'),
                    'type' => 'select',
                    'name' => 'autoseo_gerator',
                    'options' => array(
                        '' => $this->language->get('profile_import_products_autoseo_gerator_none'),
                        'name' => $this->language->get('profile_import_products_autoseo_gerator_name'),
                        'meta_title' => $this->language->get('profile_import_products_autoseo_gerator_meta_title'),
                        'model' => $this->language->get('profile_import_products_autoseo_gerator_model')
                    ),
                    'class_container' => 'profile_import configuration products no_refresh_columns',
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_products_existing_products'),
                    'type' => 'select',
                    'name' => 'existing_products',
                    'options' => array(
                        'edit' => $this->language->get('profile_import_products_existing_products_edit'),
                        'skip' => $this->language->get('profile_import_products_existing_products_skip'),
                    ),
                    'class_container' => 'profile_import configuration products no_refresh_columns',
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_products_new_products'),
                    'type' => 'select',
                    'name' => 'new_products',
                    'options' => array(
                        'edit' => $this->language->get('profile_import_products_new_products_edit'),
                        'skip' => $this->language->get('profile_import_products_new_products_skip'),
                    ),
                    'class_container' => 'profile_import configuration products no_refresh_columns',
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_products_download_image_route'),
                    'type' => 'text',
                    'name' => 'download_image_route',
                    'class_container' => 'profile_import configuration products no_refresh_columns no_refresh_columns',
                    'columns' => 3,
                    'after' => $this->get_remodal('profile_import_products_download_image_route', $this->language->get('profile_import_products_download_image_route_remodal_title'), sprintf($this->language->get('profile_import_products_download_image_route_remodal_description'), '/image/'.$this->image_path, '/image/'.$this->image_path), array('link' => 'profile_import_products_download_image_route_remodal_link', 'remodal_options' => 'button_cancel: false')),
                ),

                array(
                    'type' => 'legend',
                    'text' => '<i class="fa fa-plug"></i>'.$this->language->get('profile_import_products_data_related_legend'),
                    'remove_border_button' => true,
                    'class_container' => 'profile_import profile_export configuration products profile_import_products_data_related_legend',
                ),

                array(
                    'label' => $this->language->get('profile_import_cat_number'),
                    'type' => 'text',
                    'name' => 'cat_number',
                    'force_value' => 0,
                    'class_container' => 'profile_import profile_export configuration products',
                    'after' => $this->get_remodal('profile_cat_number', $this->language->get('profile_cat_number_remodal_title'), sprintf($this->language->get('profile_cat_number_remodal_description'), $this->get_image_link('excel_example_number_categories.jpg')), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_cat_number_link')),
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_cat_tree_number_parent'),
                    'type' => 'text',
                    'name' => 'cat_tree_number',
                    'force_value' => 0,
                    'class_container' => 'profile_import profile_export configuration products',
                    'after' => $this->get_remodal('profile_cat_tree_number_parent', $this->language->get('profile_cat_tree_number_parent_remodal_title'), sprintf($this->language->get('profile_cat_tree_number_parent_remodal_description'), $this->get_image_link('excel_example_number_categories_tree_parents.jpg')), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_cat_tree_number_parent_link')),
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_cat_tree_number_children'),
                    'type' => 'text',
                    'name' => 'cat_tree_children_number',
                    'force_value' => 0,
                    'class_container' => 'profile_import profile_export configuration products',
                    'after' => $this->get_remodal('profile_cat_tree_number_children', $this->language->get('profile_cat_tree_number_children_remodal_title'), sprintf($this->language->get('profile_cat_tree_number_children_remodal_description'), $this->get_image_link('excel_example_number_categories_tree_childrens.jpg')), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_cat_tree_number_children_link')),
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_image_number'),
                    'type' => 'text',
                    'name' => 'image_number',
                    'force_value' => 0,
                    'class_container' => 'profile_import profile_export configuration products',
                    'after' => $this->get_remodal('profile_import_image_number', $this->language->get('profile_import_image_number_remodal_title'), sprintf($this->language->get('profile_import_image_number_remodal_description'), $this->get_image_link('excel_example_number_images.jpg')), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_import_image_number_link')),
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_attribute_number'),
                    'type' => 'text',
                    'name' => 'attribute_number',
                    'force_value' => 0,
                    'class_container' => 'profile_import profile_export configuration products',
                    'after' => $this->get_remodal('profile_import_attribute_number', $this->language->get('profile_import_attribute_number_remodal_title'), sprintf($this->language->get('profile_import_attribute_number_remodal_description'), $this->get_image_link('excel_example_number_attributes.jpg')), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_import_attribute_number_link')),
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_special_number'),
                    'type' => 'text',
                    'name' => 'special_number',
                    'force_value' => 0,
                    'class_container' => 'profile_import profile_export configuration products',
                    'after' => $this->get_remodal('profile_import_special_number', $this->language->get('profile_import_special_number_remodal_title'), sprintf($this->language->get('profile_import_special_number_remodal_description'), $this->get_image_link('excel_example_number_specials.jpg')), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_import_special_number_link')),
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_discount_number'),
                    'type' => 'text',
                    'name' => 'discount_number',
                    'force_value' => 0,
                    'class_container' => 'profile_import profile_export configuration products',
                    'after' => $this->get_remodal('profile_import_discount_number', $this->language->get('profile_import_discount_number_remodal_title'), sprintf($this->language->get('profile_import_discount_number_remodal_description'), $this->get_image_link('excel_example_number_discounts.jpg')), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_import_discount_number_link')),
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_filter_group_number'),
                    'type' => 'text',
                    'name' => 'filter_group_number',
                    'force_value' => 0,
                    'class_container' => 'profile_import profile_export configuration products',
                    'after' => $this->get_remodal('profile_import_filter_group_number', $this->language->get('profile_import_filter_group_number_remodal_title'), sprintf($this->language->get('profile_import_filter_group_number_remodal_description'), $this->get_image_link('excel_example_number_filter_groups.jpg')), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_import_filter_group_number_link')),
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_filter_number'),
                    'type' => 'text',
                    'name' => 'filter_number',
                    'force_value' => 0,
                    'class_container' => 'profile_import profile_export configuration products',
                    'after' => $this->get_remodal('profile_import_filter_number', $this->language->get('profile_import_filter_number_remodal_title'), sprintf($this->language->get('profile_import_filter_number_remodal_description'), $this->get_image_link('excel_example_number_filters.jpg')), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_import_filter_number_link')),
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_import_download_number'),
                    'type' => 'text',
                    'name' => 'download_number',
                    'force_value' => 0,
                    'class_container' => 'profile_import profile_export configuration products',
                    'after' => $this->get_remodal('profile_import_download_number', $this->language->get('profile_import_download_number_remodal_title'), sprintf($this->language->get('profile_import_download_number_remodal_description'), $this->get_image_link('excel_example_number_downloads.jpg')), array('button_cancel' => false, 'button_confirm' => false, 'link' => 'profile_import_download_number_link')),
                    'columns' => 3
                ),

                array(
                    'type' => 'legend',
                    'text' => '<i class="fa fa-sort"></i>'.$this->language->get('profile_export_sort_order'),
                    'remove_border_button' => true,
                    'class_container' => 'profile_export configuration generic',
                    'style' => 'margin-top: 17px;'
                ),

                array(
                    'type' => 'html_hard',
                    'html_code' => '<div class="sort_order_configuration col-md-12"></div>',
                    'class_container' => 'profile_export configuration generic sort_order_configuration'
                ),

                array(
                    'type' => 'legend',
                    'text' => '<i class="fa fa-filter"></i>'.$this->language->get('profile_products_quick_filter'),
                    'remove_border_button' => true,
                    'class_container' => 'profile_export configuration products',
                    'style' => 'margin-top: 17px;'
                ),

                 array(
                    'label' => $this->language->get('profile_products_quick_filter_categories'),
                    'help' => $this->language->get('profile_products_quick_filter_categories_help'),
                    'type' => 'select',
                    'name' => 'quick_filter_category_ids',
                    'multiple' => true,
                    'all_options' => true,
                    'options' => $categories_select_format,
                    'class_container' => 'profile_export configuration products no_refresh_columns',
                    'columns' => 3
                ),

                array(
                    'label' => $this->language->get('profile_products_quick_filter_manufacturers'),
                    'help' => $this->language->get('profile_products_quick_filter_manufacturers_help'),
                    'type' => 'select',
                    'name' => 'quick_filter_manufacturer_ids',
                    'multiple' => true,
                    'all_options' => true,
                    'options' => $manufacturers_select_format,
                    'class_container' => 'profile_export configuration products no_refresh_columns',
                    'columns' => 3
                ),

                array(
                    'type' => 'legend',
                    'text' => '<i class="fa fa-filter"></i>'.$this->language->get('profile_products_filters'),
                    'remove_border_button' => true,
                    'class_container' => 'profile_export configuration generic',
                    'style' => 'margin-top: 17px;'
                ),

                array(
                    'type' => 'html_hard',
                    'html_code' => '<div class="profile_export configuration generic filters_configuration"></div>',
                    'class_container' => 'profile_export configuration generic filters_configuration'
                ),

                array(
                    'type' => 'legend',
                    'text' => '<i class="fa fa-columns"></i>'.$this->language->get('profile_products_columns'),
                    'remove_border_button' => true,
                    'class_container' => 'profile_export profile_import configuration generic',
                    'style' => 'margin-top: 17px;'
                ),

                array(
                    'type' => 'html_hard',
                    'html_code' => '<div class="profile_export profile_import configuration generic columns_configuration col-md-12"></div>',
                    'class_container' => 'profile_import profile_export configuration generic columns_configuration'
                ),

                array(
                    'label' => $this->language->get('profile_import_profile_name'),
                    'type' => 'text',
                    'name' => 'profile_name',
                    'class_container' => 'profile_import profile_export configuration generic profile_name'
                ),

                array(
                    'type' => 'button',
                    'label' => $this->language->get('profile_save_configuration_import'),
                    'text' => '<i class="fa fa-floppy-o"></i> '.$this->language->get('profile_save_configuration_import'),
                    'onclick' => 'profile_save(\'import\');',
                    'class_container' => 'profile_import'
                ),
                array(
                    'type' => 'button',
                    'label' => $this->language->get('profile_save_configuration_export'),
                    'text' => '<i class="fa fa-floppy-o"></i> '.$this->language->get('profile_save_configuration_export'),
                    'onclick' => 'profile_save(\'export\');',
                    'class_container' => 'profile_export'
                ),
                array(
                    'type' => 'button',
                    'class' => 'danger',
                    'label' => $this->language->get('profile_delete_configuration_import'),
                    'text' => '<i class="fa fa-trash"></i> '.$this->language->get('profile_delete_configuration_import'),
                    'onclick' => 'profile_delete(\'import\');',
                    'class_container' => 'profile_import button_delete_profile'
                ),
                array(
                    'type' => 'button',
                    'class' => 'danger',
                    'label' => $this->language->get('profile_delete_configuration_export'),
                    'text' => '<i class="fa fa-trash"></i> '.$this->language->get('profile_delete_configuration_export'),
                    'onclick' => 'profile_delete(\'export\');',
                    'class_container' => 'profile_export button_delete_profile'
                ),
            );
            return $fields;
        }

        function get_columns($profile_id, $from_ajax = false) {
            $profile = $this->{$this->model_profile}->load($profile_id, true);

            //Add hidden fields when load a profile
            if(!empty($profile_id)) {
                $no_hidden_fields = array('custom_name', 'default_value', 'status');
                $final_columns = array();

                foreach ($profile['profile']['columns'] as $col_name => $col_info) {
                    $internal_configuration = json_decode(str_replace("'", '"', $col_info['internal_configuration']), true);
                    $profile['profile']['columns'][$col_name]['hidden_fields'] = array();
                    foreach ($internal_configuration as $input_name => $value) {
                        if(in_array($input_name, $no_hidden_fields))
                            $profile['profile']['columns'][$col_name][$input_name] = $value;
                        else
                            $profile['profile']['columns'][$col_name]['hidden_fields'][$input_name] = $value;
                    }
                    unset($profile['profile']['columns'][$col_name]['internal_configuration']);
                }
            }

            if($from_ajax) {
                echo json_encode($profile['profile']['columns']); die;
            }
            return $profile['profile']['columns'];
        }

        public function get_filters_from_profile($profile_id) {
            if(empty($profile_id))
                return array();

            $profile = $this->{$this->model_profile}->load($profile_id, true);

            return array_key_exists('profile', $profile) && array_key_exists('export_filter', $profile['profile']) ? $profile['profile']['export_filter'] : array();
        }

        public function get_sort_order_from_profile($profile_id) {
            if(empty($profile_id))
                return array();

            $profile = $this->{$this->model_profile}->load($profile_id, true);
            return array_key_exists('profile', $profile) && array_key_exists('export_sort_order', $profile['profile']) ? $profile['profile']['export_sort_order'] : array();
        }

        function get_profile_columns_html($colums) {
            $html = '';

            $html .= '
            <table class="table table-bordered table-hover">
                <thead>';

            if(count($this->profiles_select) > 1) {
                $profile_id = array_key_exists('profile_id', $this->request->post) && !empty($this->request->post['profile_id']) ? $this->request->post['profile_id'] : '';
                $profiles_select_copy = $this->profiles_select;
                if(!empty($profile_id) && array_key_exists($profile_id, $profiles_select_copy))
                    unset($profiles_select_copy[$profile_id]);

                if(count($profiles_select_copy) > 1) {
                    $html .= '
                    <tr>
                        <td colspan="4" style="text-align: right;">'.$this->language->get('profile_import_column_config_thead_clone_columns').'</td>
                        <td colspan="2"><select name="load_custom_names_from_profile" data-live-search="true" onchange="profile_get_custom_names_from_profile($(this));" class="selectpicker form-control">';
                            foreach ($profiles_select_copy as $key => $prof) {
                                 $html .= '<option value="'.$key.'">'.$prof.'</option>';
                            }
                        $html .= '</select><script type="text/javascript">$(\'select[name="load_custom_names_from_profile"]\').selectpicker();</script></td>
                    </tr>';
                }
            }

            $html .= '
                    <tr>
                        <td colspan="5" style="text-align: right;">'.$this->language->get('profile_import_column_config_thead_select_all').'</td>
                        <td><label class="checkbox_container"><input onchange="profile_check_uncheck_all($(this))" name="columns_select_add" type="checkbox" class="ios-switch green" value="1" checked="selected"><div><div></div></div></label></td>
                    </tr>
                    <tr>
                        <td style="width:85px;">'.$this->language->get('profile_import_column_config_thead_sort_order').'</td>
                        <td>'.$this->language->get('profile_import_column_config_thead_column').'</td>
                        <td>'.$this->language->get('profile_import_column_config_thead_column_custom_name').'</td>
                        <td>'.$this->language->get('profile_import_column_config_thead_column_default_value').$this->get_remodal('columns_default_value', $this->language->get('columns_default_value_title'), $this->language->get('columns_default_value_description'),array('link' => 'columns_default_value_link', 'button_cancel' => false)).'</td>
                        <td>'.$this->language->get('profile_import_column_config_thead_column_extra_configuration').'</td>
                        <td>'.$this->language->get('profile_import_column_config_thead_status').'</td>
                    </tr>
                </thead>
                <tbody>';
                    foreach ($colums as $column_name => $col_info) {
                        $checked = array_key_exists('status', $col_info) && $col_info['status'];
                        $default_value = array_key_exists('default_value', $col_info) ? $col_info['default_value'] : '';

                        $internal_configuration = array('name' => $column_name);

                        $hidden_fields = array_key_exists('hidden_fields', $col_info) ? $col_info['hidden_fields'] : array();

                        if(!empty($hidden_fields)) {
                            foreach ($hidden_fields as $input_name => $value) {
                                $internal_configuration[$input_name] = $value;
                            }
                        }

                        $extra_configuration = $this->get_profile_columns_html_extra_column_configuration($column_name, $col_info);

                        $html .= '<tr>
                            <td class="draggable_element"><i class="fa fa-reorder"></i></td>
                            <td>'.$column_name.$this->get_possible_values($col_info).'</td>
                            <td>
                                <input type="hidden" name="columns['.$column_name.'][internal_configuration]" value="'.str_replace('"', "'", json_encode($internal_configuration)).'">';
                                $html .= '<input placeholder="'.$this->language->get('profile_import_column_config_thead_column_custom_name').'" type="text" class="form-control custom_name" name="columns['.$column_name.'][custom_name]" value="'.$col_info['custom_name'].'">
                            </td>
                            <td><input placeholder="'.$this->language->get('profile_import_column_config_thead_column_default_value').'" type="text" class="form-control default_value" name="columns['.$column_name.'][default_value]" value="'.$default_value.'"></td>
                            <td class="extra_configuration">'.$extra_configuration.'</td>
                            <td><label class="checkbox_container"><input name="columns['.$column_name.'][status]" type="checkbox" class="ios-switch green" value="1" '.($checked ? 'checked="selected"': '' ).'><div><div></div></div></label></td>
                        </tr>';
                    }
                $html .= '</tbody>
            </table>
            ';

            return $html;
        }

        public function get_profile_columns_html_extra_column_configuration($column_name, $col_info) {
            $hidden_fields = array_key_exists('hidden_fields', $col_info) ? $col_info['hidden_fields'] : array();
            $is_boolean = array_key_exists('is_boolean', $hidden_fields) && $hidden_fields['is_boolean'];
            $is_image = $this->profile_type == 'export' && array_key_exists('hidden_fields', $col_info) && array_key_exists('is_image', $col_info['hidden_fields']);
            $product_id_identificator = array_key_exists('product_id_identificator', $col_info) && $col_info['product_id_identificator'];
            $splitted_values = $this->profile_type == 'import' && array_key_exists('splitted_values', $col_info);
            $profit_margin = $this->profile_type == 'import' && array_key_exists('profit_margin', $col_info);

            $extra_configuration = '';

            $extra_configuration_config = array('label_size' => 8);

            if($splitted_values) {
                $value = array_key_exists('splitted_values', $col_info) ? $col_info['splitted_values'] : '';
                $info_remodal = $this->get_remodal('profile_column_config_extra_splitted_values', $this->language->get('profile_column_config_extra_splitted_values_title'), sprintf($this->language->get('profile_column_config_extra_splitted_values_description'), $this->get_image_link('splitted_values_example.jpg')),array('link' => 'profile_column_config_extra_splitted_values_link', 'button_cancel' => false));
                $extra_configuration .= $this->get_field_html($this->language->get('profile_column_config_extra_configuration_splitted_values').$info_remodal, '<input class="form-control extra_column_configuration" name="columns['.$column_name.'][splitted_values]" type="text" value="'.$value.'">', $extra_configuration_config);
            }

            if($is_boolean) {
                $true_value = array_key_exists('true_value', $col_info) ? $col_info['true_value'] : 1;
                $false_value = array_key_exists('false_value', $col_info) ? $col_info['false_value'] : '0';
                $extra_configuration .= $this->get_field_html($this->language->get('profile_column_config_extra_configuration_value_true'), '<input class="form-control extra_column_configuration" name="columns['.$column_name.'][true_value]" type="text" value="'.$true_value.'">', $extra_configuration_config);
                $extra_configuration .= $this->get_field_html($this->language->get('profile_column_config_extra_configuration_value_false'), '<input class="form-control extra_column_configuration" name="columns['.$column_name.'][false_value]" type="text" value="'.$false_value.'">', $extra_configuration_config);
            }
            elseif($is_image) {
                $image_full_link = array_key_exists('image_full_link', $col_info) ? $col_info['image_full_link'] : 0;
                $checkbox = $this->get_checkbox_html('columns['.$column_name.'][image_full_link]', $image_full_link);
                $extra_configuration_config['class_label'] = 'checkbox_label';
                $extra_configuration .= $this->get_field_html($this->language->get('profile_column_config_extra_configuration_image_link'), $checkbox, $extra_configuration_config);
            } else if(in_array($column_name, array('Out stock status', 'Weight class', 'Length class', 'Tax class')) || strstr($column_name, 'Layout')) {
                $name_instead_id = array_key_exists('name_instead_id', $col_info) ? $col_info['name_instead_id'] : 0;
                $checkbox = $this->get_checkbox_html('columns['.$column_name.'][name_instead_id]', $name_instead_id);
                $extra_configuration_config['class_label'] = 'checkbox_label';
                $extra_configuration .= $this->get_field_html($this->language->get('profile_column_config_extra_configuration_names_instead_of_id'), $checkbox, $extra_configuration_config);
            } else if ($product_id_identificator) {
                $extra_configuration_config = array('label_size' => 6);
                $copy_prod_identificators = $this->product_identificators;
                $extra = array('class' => 'selectpicker form-control');
                $value = array_key_exists('product_id_identificator', $col_info) && !empty($col_info['product_id_identificator']) ? $col_info['product_id_identificator'] : 'product_id';
                $field_select = $this->select_constructor('columns['.$column_name.'][product_id_identificator]', $copy_prod_identificators, $value, $extra);
                $extra_configuration .= $this->get_field_html($this->language->get('profile_column_config_extra_configuration_product_id_identificator'), $field_select, $extra_configuration_config);
            } else if($profit_margin) {
                $help = $this->get_tooltip_help_html($this->language->get('profile_column_config_extra_configuration_profit_margin_help'));
                $extra_configuration .= $this->get_field_html($this->language->get('profile_column_config_extra_configuration_profit_margin').$help, '<input class="form-control extra_column_configuration" name="columns['.$column_name.'][profit_margin]" type="text" value="'.$col_info['profit_margin'].'">', $extra_configuration_config);
            }
            return $extra_configuration;
        }
        public function get_select_from_database_fields($database_fields, $empty_value = '') {
            $fields_to_select = array();
            if(!empty($empty_value)) {
                $fields_to_select[''] = $empty_value;
            }
            foreach ($database_fields as $table_name => $fields) {
                $table_name_formatted = $this->get_legible_database_field_name($table_name);
                foreach ($fields as $field_name => $field_info) {
                    $field_name_formatted = $this->get_legible_database_field_name($field_name);
                    $type = $field_info['type'];
                    $final_name = $table_name_formatted.' - '.$field_name_formatted.' ('.$type.')';
                    $fields_to_select[$table_name.'-'.$field_name.'-'.$type] = $final_name;
                }
            }

            return $fields_to_select;
        }
        public function get_profile_filters_html($database_fields) {
            $profile_id = array_key_exists('profile_id', $this->request->post) && !empty($this->request->post['profile_id']) ? $this->request->post['profile_id'] : '';
            $config_filters = $this->get_filters_from_profile($profile_id);
            $filters_num = !empty($config_filters['filters']) ? count($config_filters['filters']) : 0;
            $main_conditional = !empty($config_filters) && array_key_exists('main_conditional', $config_filters['config']) ? $config_filters['config']['main_conditional'] : 'AND';

            $fields_to_select = $this->get_select_from_database_fields($database_fields);

            $button_add_filter = '<a href="javascript:{}" onclick="profile_add_filter($(this));" class="button" title="'.$this->language->get('profile_products_filters_add_filter').'"><i class="fa fa-plus-square" aria-hidden="true"></i></a>';
            $button_remove_filter = '<a href="javascript:{}" onclick="profile_remove_filter($(this));" class="button danger" title="'.$this->language->get('profile_products_filters_remove_filter').'"><i class="fa fa-minus-square" aria-hidden="true"></i></a>';

            $html = '
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td colspan="3" style="text-align:right;">'.$this->language->get('profile_products_filters_add_filter').'</td>
                        <td style="width: 68px;">'.$button_add_filter.'</td>
                    </tr>
                    <tr>
                        <td>'.$this->language->get('profile_products_filters_thead_field').'</td>
                        <td>'.$this->language->get('profile_products_filters_thead_condition').'</td>
                        <td>'.$this->language->get('profile_products_filters_thead_value').'</td>
                        <td>'.$this->language->get('profile_products_filters_thead_actions').'</td>
                    </tr>
                </thead>
                <tbody>';
                    $html .= $this->get_filter_row('replace_by_number', $fields_to_select, array(), $button_remove_filter, true, $filters_num);
                    if(!empty($config_filters['filters'])) {
                        foreach ($config_filters['filters'] as $key => $config_filter) {
                            $html .= $this->get_filter_row($key, $fields_to_select, $config_filter, $button_remove_filter);
                        }
                    }
                $html .= '</tbody>
                <tfoot style="display:none;">
                    <tr>
                        <td colspan="2">'.$this->language->get('profile_products_filters_main_conditional').'</td>
                        <td colspan="2">'.$this->select_constructor('export_filter[main_conditional]', $this->conditionals, $main_conditional).'
                    </tr>
                </tfoot>
            </table>
            ';
            
            return $html;
        }

        function get_filter_row($number, $fields_to_select, $filter_config = array(), $button_remove_filter, $is_model = false, $filter_number = false) {
            $extra = array('class' => 'selectpicker form-control conditional field', 'onchange' => 'profile_filter_reset_profile($(this).closest(\'tr\'))');

            $value = !empty($filter_config) && array_key_exists('field', $filter_config) ? $filter_config['field'] : '';
            $field_select = $this->select_constructor('export_filter['.$number.'][field]', $fields_to_select, $value, $extra);

            $conditionals_selects = '';
            foreach ($this->filter_field_types as $key => $type) {
                $value = !empty($filter_config) && array_key_exists($type, $filter_config['conditional']) ? $filter_config['conditional'][$type] : '';
                $extra = array('class' => 'selectpicker form-control conditional '.$type);
                $conditionals_selects .= $this->select_constructor('export_filter['.$number.'][conditional]['.$type.']', $this->{'filter_conditionals_'.$type}, $value, $extra);

            }

            $value = !empty($filter_config) && array_key_exists('value', $filter_config) ? $filter_config['value'] : '';
            $value_inputs = '<input name="export_filter['.$number.'][value]" type="text" class="form-control" value="'.$value.'">';
            
            return '<tr'.($is_model ? ' data-filterNumber="'.$filter_number.'" class="filter_model"': '').'>
                            <td class="fields">'.$field_select.'</td>
                            <td class="conditionals">'.$conditionals_selects.'</td>
                            <td class="values">'.$value_inputs.'</td>
                            <td class="remove">'.$button_remove_filter.'</td>
                        </tr>';
        }

        public function get_profile_sort_order_html($database_fields) {
            $fields_to_select = $this->get_select_from_database_fields($database_fields, $this->language->get('profile_export_sort_order_none'));
            $extra = array('class' => 'selectpicker form-control');
            $profile_id = array_key_exists('profile_id', $this->request->post) && !empty($this->request->post['profile_id']) ? $this->request->post['profile_id'] : '';
            $sort_order_config = $this->get_sort_order_from_profile($profile_id);
            $value = !empty($sort_order_config) && array_key_exists('table_field', $sort_order_config) ? $sort_order_config['table_field'] : '';
            $field_select = $this->select_constructor('export_sort_order[table_field]', $fields_to_select, $value, $extra);

            $select_html = $this->get_field_html($this->language->get('profile_export_sort_order_table_field'), $field_select, array('class' => 'profile_export configuration generic sort_order_configuration'));

            $fields_to_select = array(
                'ASC' => $this->language->get('profile_export_sort_order_asc'),
                'DESC' => $this->language->get('profile_export_sort_order_desc'),
            );
            $value = !empty($sort_order_config) && array_key_exists('sort_order', $sort_order_config) ? $sort_order_config['sort_order'] : '';
            $field_select = $this->select_constructor('export_sort_order[sort_order]', $fields_to_select, $value, $extra);
            $select_html .= $this->get_field_html($this->language->get('profile_export_sort_order_order'), $field_select,  array('class' => 'profile_export configuration generic sort_order_configuration'));
            return $select_html;
        }

        function get_field_html($label, $field, $extra_config = array()) {
            $form_group_class = array_key_exists('class', $extra_config) ? $extra_config['class'] : '';
            $label_class = array_key_exists('class_label', $extra_config) ? $extra_config['class_label'] : '';
            $label_size = array_key_exists('label_size', $extra_config) ? $extra_config['label_size'] : 2;
            $content_size = 12 - $label_size;

            $field_html = '<div class="form-group '.$form_group_class.'">
                <label class="col-md-'.$label_size.' '.$label_class.' control-label">'.$label.'</label>
                <div class="col-md-'.$content_size.'">'.$field.'</div>
            </div>';

            return $field_html;
        }

        function get_tooltip_help_html($message) {
            $tooltip = '<span data-toggle="tooltip" data-html="true" title="" data-original-title="'.$message.'"></span>';
            return $tooltip;
        }

        function get_checkbox_html($name, $checked = false) {
            $field_html = '<label class="checkbox_container"><input name="'.$name.'" type="checkbox" class="ios-switch green" value="1" '.($checked ? 'checked="checked"' : '').'><div><div></div></div></label>';

            return $field_html;
        }

        function get_possible_values($col_info) {
            $possible_values = '';
            $modal_options = array('button_cancel' => false, 'button_confirm' => false, 'link' => $this->possible_values_text);

            $is_image = array_key_exists('hidden_fields', $col_info) && array_key_exists('is_image', $col_info['hidden_fields']);
            $column_name = $col_info['hidden_fields']['name'];

            if($is_image) {
                $possible_values = array(
                    sprintf($this->language->get('profile_products_columns_possible_values_image_local'),$this->image_path, $this->image_path),
                    sprintf($this->language->get('profile_products_columns_possible_values_image_external'),$this->image_path),
                );
            } else {
                switch ($column_name) {
                    case 'Tax class':
                        $possible_values = array();
                        foreach ($this->tax_classes as $key => $tax_class) {
                             $possible_values[] = '<b>'.$tax_class['tax_class_id'].'</b>: '.$tax_class['title'].' ('.$tax_class['description'].')';
                        }
                    break;
                    case 'Out stock status':
                        $possible_values = array();
                        foreach ($this->stock_statuses as $key => $stock_status) {
                             $possible_values[] = '<b>'.$this->language->get('profile_products_columns_possible_values_id').':</b> '.$stock_status['stock_status_id'].' - <b>'.$this->language->get('profile_products_columns_possible_values_name').':</b> '.$stock_status['name'];
                        }
                    break;
                    case 'Products related':
                        $possible_values = array($this->language->get('profile_products_columns_possible_values_products_related'));
                    break;
                    case 'Option type':
                        $possible_values = array(
                            'select',
                            'radio',
                            'checkbox',
                            'image',
                            'text',
                        );
                    break;
                    case 'Option price prefix':case 'Option points prefix':case 'Option weight prefix':
                        $possible_values = array(
                            '+',
                            '-',
                        );
                    break;
                    case 'Store':
                        $possible_values = array(
                            $this->language->get('profile_products_columns_possible_values_stores')
                        );
                        foreach ($this->stores_import_format as $key => $store_info) {
                            $possible_values[] = '<b>'.$store_info['store_id'].'</b>: '.$store_info['name'];
                        }
                    break;
                    case 'Weight class':
                        $possible_values = array();
                        foreach ($this->weight_classes as $key => $weight_class) {
                            $possible_values[] = '<b>'.$this->language->get('profile_products_columns_possible_values_id').':</b> '.$weight_class['weight_class_id'].' - <b>'.$this->language->get('profile_products_columns_possible_values_name').':</b> '.$weight_class['title'];
                        }
                    break;
                    case 'Length class':
                        $possible_values = array();
                        foreach ($this->length_classes as $key => $length_class) {
                            $possible_values[] = '<b>'.$this->language->get('profile_products_columns_possible_values_id').':</b> '.$length_class['length_class_id'].' - <b>'.$this->language->get('profile_products_columns_possible_values_name').':</b> '.$length_class['title'];
                        }
                    break;

                    case 'Parent id':
                        $possible_values = array($this->language->get('profile_categories_columns_possible_values_parent_id'));
                    break;

                    case 'Filters':
                        $possible_values = array(sprintf($this->language->get('profile_categories_columns_possible_values_filters'), $this->default_language_code));
                    break;

                    case strstr($column_name, 'Layout'):
                        $possible_values = array();
                        foreach ($this->layouts as $layout_id => $layout_name) {
                            $possible_values[] = '<b>'.$this->language->get('profile_products_columns_possible_values_id').':</b> '.$layout_id.' - <b>'.$this->language->get('profile_products_columns_possible_values_name').':</b> '.$layout_name;
                        }

                    break;
                }
            }

            if(!empty($possible_values)) {
                $possible_values = '<ul><li>'.implode('</li><li>', $possible_values).'</li></ul>';
                $remodal_identificator = 'possible_value_'.$this->format_column_name($column_name);
                $possible_values = ' - '.$this->get_remodal($remodal_identificator, $this->language->get($this->possible_values_text), $possible_values, $modal_options);
            }
            return is_array($possible_values) ? '' : $possible_values;
        }

        function _check_ajax_function($function_name) {
            if($function_name == 'get_columns_html') {
                $type = array_key_exists('import_xls_i_want', $this->request->post) ? $this->request->post['import_xls_i_want'] : die('No import_xls_i_want data');
                $this->profile_type = array_key_exists('profile_type', $this->request->post) ? $this->request->post['profile_type'] : 'export';
                $model_name = 'ie_pro_'.$type;
                $model_path = 'extension/module/'.$model_name;
                $model_loaded = 'model_extension_module_'.$model_name;
                $this->load->model($model_path);
                $columns = $this->{$model_loaded}->get_columns($this->request->post);
                $columns_html = $this->get_profile_columns_html($columns);
                $array_return = array('html' => $columns_html);
                echo json_encode($array_return); die;
            } elseif($function_name == 'get_filters_html') {
                $category = array_key_exists('import_xls_i_want', $this->request->post) ? $this->request->post['import_xls_i_want'] : die('No import_xls_i_want data');
                $this->load->model('extension/module/ie_pro_database');
                $tables = $this->model_extension_module_ie_pro_database->get_database($category, array('is_filter' => true));
                $columns_html = $this->get_profile_filters_html($tables[$category]);
                $array_return = array('html' => $columns_html);
                echo json_encode($array_return); die;
            } elseif($function_name == 'get_sort_order_html') {
                $category = array_key_exists('import_xls_i_want', $this->request->post) ? $this->request->post['import_xls_i_want'] : die('No import_xls_i_want data');
                $this->load->model('extension/module/ie_pro_database');
                $tables = $this->model_extension_module_ie_pro_database->get_database($category, array('is_filter' => true));
                $columns_html = $this->get_profile_sort_order_html($tables[$category]);
                $array_return = array('html' => $columns_html);
                echo json_encode($array_return); die;
            } elseif($function_name == 'profile_save') {
                try {
                    $this->{$this->model_profile}->save();
                } catch (Exception $e) {
                    $array_return = array();
                    $array_return['error'] = true;
                    $array_return['message'] = $e->getMessage();
                    echo json_encode($array_return); die;
                }
            }elseif($function_name == 'profile_delete') {
                $this->{$this->model_profile}->delete();
            }elseif($function_name == 'get_columns') {
                $profile_id = array_key_exists('profile_id', $this->request->post) ? $this->request->post['profile_id'] : die('No profile_id data');
                $this->get_columns($profile_id, true);
            }elseif($function_name == 'spread_sheet_upload_json') {
                $this->spread_sheet_upload_json();
            }
        }

        function spread_sheet_upload_json() {
            $array_return = array('error' => false, 'message' => $this->language->get('profile_import_spreadsheet_remodal_json_uploaded'));
            $file_tmp_name = array_key_exists('file', $_FILES) && array_key_exists('tmp_name', $_FILES['file']) ? $_FILES['file']['tmp_name'] : '';
            $file_name = array_key_exists('file', $_FILES) && array_key_exists('name', $_FILES['file']) ? $_FILES['file']['name'] : '';

            $this->validate_permiss();

            $extension_file =  strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if(!in_array($extension_file, array('json')))
            {
                $array_return['error'] = true;
                $array_return['message'] = $this->language->get('profile_import_spreadsheet_remodal_json_error_extension');
                echo json_encode($array_return); die;
            }

            if(!copy($file_tmp_name, $this->google_spreadsheet_json_file_path)) {
                $array_return['error'] = true;
                $array_return['message'] = $this->language->get('profile_import_spreadsheet_remodal_json_error_uploading');
                echo json_encode($array_return); die;
            }

            echo json_encode($array_return); die;
        }

        function spread_sheet_get_account_id() {
            if(file_exists($this->google_spreadsheet_json_file_path)) {
                $gdrive_config = file_get_contents($this->google_spreadsheet_json_file_path);
                $gdrive_config = json_decode($gdrive_config, true);
                $service_account_id = array_key_exists('client_email', $gdrive_config) ? $gdrive_config['client_email'] : $this->language->get('profile_import_spreadsheet_remodal_json_client_id_not_found');
            } else {
                $service_account_id = $this->language->get('profile_import_spreadsheet_remodal_json_client_id_not_file');
            }
            return $service_account_id;
        }
        function _send_custom_variables_to_view($variables) {
            $variables['get_columns_html_url'] = htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=get_columns_html', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'));
            $variables['get_columns_from_profile_url'] = htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=get_columns', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'));
            $variables['get_filters_html_url'] = htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=get_filters_html', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'));
            $variables['get_sort_order_html_url'] = htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=get_sort_order_html', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'));
            $variables['profile_save_url'] = htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=profile_save', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'));
            $variables['profile_delete_url'] = htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=profile_delete', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'));
            $variables['profile_error_uncompleted'] = $this->language->get('profile_error_uncompleted');
            $variables['spread_sheet_upload_json'] = htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=spread_sheet_upload_json', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'));
            return $variables;
        }

        function load_generic_data() {
            $this->profiles_select_import = $this->{$this->model_profile}->get_profiles('import', '', true);
            $this->profiles_select_export = $this->{$this->model_profile}->get_profiles('export', '', true);
            $this->profiles_select = $this->{$this->model_profile}->get_profiles('', '', true);

            if(count($this->profiles_select) == 1)
                $this->session->data['info'] = sprintf($this->language->get('profile_start_to_work'), '<a href="javascript:{}" onclick="$(\'a.tab_profiles\').click()">' , '</a>');
        }
    }
?>