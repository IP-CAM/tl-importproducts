<?php
$_['profile_start_to_work'] = 'Create your first profile in tab "<b>%sProfiles%s</b>" to start to work.';
$_['profile_legend_text'] = 'Manage profiles - Load a profile or create new profile';
$_['profile_select_text'] = 'Load profile';
$_['profile_or'] = 'OR';
$_['profile_select_prefix_import'] = 'Import';
$_['profile_select_prefix_export'] = 'Export';
$_['profile_select_text_empty'] = ' - Select a profile - ';
$_['profile_create_text'] = 'Create profile';
$_['profile_create_import_text'] = 'Click to create <b>Import profile</b>';
$_['profile_create_export_text'] = 'Click to create <b>Export profile</b>';
$_['profile_i_want_products'] = 'Products (+ related product data)';
$_['profile_i_want_specials'] = 'Product Specials';
$_['profile_i_want_discounts'] = 'Product Discounts';
$_['profile_i_want_categories'] = 'Categories';
$_['profile_i_want_attribute_groups'] = 'Attribute groups';
$_['profile_i_want_attributes'] = 'Attributes';
$_['profile_i_want_options'] = 'Options';
$_['profile_i_want_option_values'] = 'Option values';
$_['profile_i_want_manufacturers'] = 'Manufacturers';
$_['profile_i_want_filter_groups'] = 'Filter groups';
$_['profile_i_want_filters'] = 'Filters';
$_['profile_i_want_customer_groups'] = 'Customer groups';
$_['profile_i_want_customers'] = 'Customers';
$_['profile_i_want_addresses'] = 'Addresses';
$_['profile_i_want_orders'] = 'Orders';
$_['profile_i_want_coupons'] = 'Coupons';
$_['profile_legend_text_import'] = 'Import profile configuration';
$_['profile_legend_text_export'] = 'Export profile configuration';
$_['profile_save_configuration_import'] = 'Save import profile';
$_['profile_delete_configuration_import'] = 'Delete import profile';
$_['profile_save_configuration_export'] = 'Save export profile';
$_['profile_delete_configuration_export'] = 'Delete export profile';
$_['profile_import_file_format'] = 'Format file';
$_['profile_import_file_origin'] = 'I will get file from';
$_['profile_import_file_origin_manual'] = 'I will upload it manually';
$_['profile_import_file_origin_ftp'] = 'From external Server';
$_['profile_import_file_origin_url'] = 'From URL';
$_['profile_import_file_destiny'] = 'The file will be';
$_['profile_import_file_download'] = 'Downloaded from my web browser';
$_['profile_import_file_destiny_server'] = 'Saved to my server';
$_['profile_import_file_destiny_server_path'] = 'File path';
$_['profile_import_file_destiny_server_path_remodal_link'] = '<b>IMPORTANT</b>: Click to read';
$_['profile_import_file_destiny_server_path_remodal_title'] = 'File path';
$_['profile_import_file_destiny_server_path_remodal_description'] = 'Your Opencart root path is <b>%s</b>. Let\'s see some examples:
           <ol>
                <li><b>Path to save file in root:</b> %s</li>
                <li><b>Path to save file in root inside folder "export_products":</b> %sexport_products/</li>
                <li><b>Path to save file in root inside tree folders "export_products/category_cars/":</b> %sexport_products/category_cars/</li>
                <li><b>Path to save file outside root (example): </b>%s</li>
           </ol>';
$_['profile_import_file_destiny_server_file_name'] = 'File name';
$_['profile_import_file_destiny_server_file_name_help'] = 'Do NOT include file extension. (E.g. products is correct, products.xlsx is incorrect)';
$_['profile_import_file_destiny_server_file_name_sufix'] = 'File sufix';
$_['profile_import_file_destiny_server_file_name_sufix_none'] = 'No sufix (file will be replaced in new exports)';
$_['profile_import_file_destiny_server_file_name_sufix_date'] = 'Date export. Example "-2019-01-31.xlsx"';
$_['profile_import_file_destiny_server_file_name_sufix_datetime'] = 'Date and time export. Example "-2019-01-31-1035.xlsx"';
$_['profile_import_file_destiny_external_server'] = 'Saved into external server';
$_['profile_i_want'] = 'Elements';
$_['profile_import_csv_separator'] = 'CSV delimiter';
$_['profile_import_csv_separator_help'] = 'Leave blank for default delimiter (comma).';
$_['profile_import_xml_node'] = 'XML Item node';
$_['profile_import_xml_node_help'] = 'XML Item node';
$_['profile_import_xml_node_link'] = 'Learn about XML nodes';
$_['profile_import_xml_node_remodal_title'] = 'XML Node';
$_['profile_import_xml_node_remodal_description'] = '<p>For example, if you need to import this XML file:</p><img style="width: 630px;" src="%s"><br><br>
    <p>The mode XML is a tags tree separated by ">", case sensitive and without spaces.</p>
    <p>The node XML to this example file is: "<b>yml_catalog>shop>offers>offer</b>"</p>
    <p>After that, in section "Columns", translate columns that you want import and disable all columns that you don\'t need.</p><img style="width: 630px;" src="%s">';
$_['profile_import_spreadsheet_name'] = 'G. Spreadsheet name';
$_['profile_import_spreadsheet_name_help'] = 'Remember that this name have to be exactly same that your Google root file name.';
$_['profile_import_spreadsheet_remodal_title'] = 'Google Drive API configuration';
$_['profile_import_spreadsheet_remodal_description'] = '        <h3>1.- Create API and download .json credentials file</h3>
        <p>By default, a new spreadsheet cannot be accessed via Google’s API. You will need to go to your Google APIs console and create a new project and set it up to expose your Spreadsheet’s data.</p>
        <ol>
            <li>Go to the <a href="https://console.developers.google.com/" taget="_blank">Google APIs Console</a>.</li>
            <li>Create a new project.</li>
            <li>Click Enable API. Search for and enable the Google Drive API.</li>
            <li>Create credentials for a Web Server to access Application Data.</li>
            <li>Name the service account and grant it a Project Role of Editor.</li>
            <li>A JSON file will be downloaded.</li>
        </ol>
        <img style="margin-bottom: 15px;" src="%s">
        <h3>2.- Upload .json credentials file</h3>%s
        </br>
        <h3>3.- Share Sheets with your Service Account ID</h3>
        <p>Finally, to works with spreadsheet files saved in your Google Drive root path, you need share these files with your "Service account ID", this is: <b>%s</b></p>
        
';
$_['profile_import_spreadsheet_remodal_link'] = '<b>IMPORTANT: Click to configure Google Drive API</b>';
$_['profile_import_spreadsheet_remodal_json_uploaded'] = 'File uploaded correctly! Page will be reloaded in a few seconds.';
$_['profile_import_spreadsheet_remodal_json_error_extension'] = '<b>Error:</b> Upload correct <b>.json</b> file in <b>step 2</b>.';
$_['profile_import_spreadsheet_remodal_json_error_uploading'] = '<b>Error:</b> File could not be uploaded.';
$_['profile_import_spreadsheet_remodal_json_client_id_not_file'] = 'Will appear after uploaded .json file.';
$_['profile_import_spreadsheet_remodal_json_client_id_not_found'] = 'Client ID not found, upload again .json file.';
$_['profile_import_url'] = 'Url';
$_['profile_import_ftp_host'] = 'FTP - Host';
$_['profile_import_ftp_username'] = 'FTP - Username';
$_['profile_import_ftp_password'] = 'FTP - Password';
$_['profile_import_ftp_port'] = 'FTP - Port';
$_['profile_import_ftp_port_help'] = 'By default, system will assign port 21';
$_['profile_import_ftp_path'] = 'FTP - Path to file';
$_['profile_import_ftp_path_help'] = 'Path example: /httpdocs/myfiles/';
$_['profile_import_ftp_file'] = 'FTP - File name';
$_['profile_import_ftp_file_help'] = 'Not include extension. (for example .xlsx NOT)';
$_['profile_import_products_legend'] = 'General products configuration';
$_['profile_import_products_strict_update'] = 'Strict update';
$_['profile_import_products_strict_update_link'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_import_products_strict_update_help'] = '    <p>With this feature enabled, <b>ALL RELATED PRODUCT DATA FOUND IN FILE WILL BE CLEANED BEFORE UPDATE THESE</b>.</p>
    <p>This mode enabled is useful when:
        <ol>
            <li>You want do a bulk update of your related product data, or want to remove all product related data.</li>
            <li>Your provider is giving your related product data, and these changing everyday, removing rows, adding rows..</li>
        </ol>
    </p>
    <p><b>Example</b>: Imagine that you want keep 2 of 5 seconday images in an existing product saved in your store (see next excel screenshot, images marked with green we can keep these).</p>
    <img style="width: 605px;" src="%s">
    <br><br>
    <p>Currently, this product has assigned these 5 images:
    <ol>
        <li>catalog/image1.jpg</li>
        <li>catalog/image2.jpg</li>
        <li>catalog/image3.jpg</li>
        <li>catalog/image4.jpg</li>
        <li>catalog/image5.jpg</li>
    </ol>
    </p>
    <p>We deleted red images and moved green images to first columns, we also need add a new image (marked in purple), the result is next:</p>
    <img style="width: 605px;" src="%s">
    <br><br>
    <p>With "<b>Strict update</b>" enabled, after import this excel, product images will be deleted and only be assigned new images:</p>
    <ol>
        <li>catalog/image2.jpg</li>
        <li>catalog/image5.jpg</li>
        <li>catalog/image6.jpg</li>
    </ol>
    <p>In case that we need <b>DELETE ALL RELATED DATA</b>, simple let in blank all related data columns, in our case:</p>
    <img style="width: 605px;" src="%s">
    <br><br>
    <p>With "<b>Strict update</b>" enabled, after import this excel, all product images will be deleted.</p>
';
$_['profile_import_products_multilanguage'] = 'Multilanguage';
$_['profile_import_products_multilanguage_help'] = '<p>With this model, all columns compatible with multilanguage will be duplicated each language.</p>
    <p>Example columns with "Multilanguage" <b>DISABLED</b>:
        </p><ul>
            <li>Name</li>
            <li>Description</li>
            <li>Meta description</li>
            <li>Meta title</li>
            <li>...</li>
        </ul>
    <p></p>
    <p>* If you have more than 1 language installed in your shop and "multilanguage" is disabled, the value put in multilanguage column will be replicated to another languages automatically.</p>
    <p>Example columns with "Multilanguage" <b>ENABLED</b>:
    </p><ul>
        <li>Name en-gb</li>
        <li>Name nl-nl</li>
        <li>Description en-gb</li>
        <li>Description nl-nl</li>
        <li>Meta description en-gb</li>
        <li>Meta description nl-nl</li>
        <li>Meta title en-gb</li>
        <li>Meta title nl-nl</li>
        <li>...</li>
    </ul>';
$_['profile_import_products_category_tree'] = 'Category tree';
$_['profile_import_products_profile_cat_tree_remodal_title'] = 'Category tree VS no category tree';
$_['profile_import_products_profile_cat_tree_remodal_description'] = '    <p><b>Category tree DISABLED</b>: Keep disabled if your don\'t want use categories tree or you want assign individual categories to your products.
    <br>
    Excel example (columns marked in red):</p>
    <img style="width: 605px;" src="%s">
    <br><br>
    <p><b>Category tree ENABLED</b>: Enable it if your want use categories tree in your products.
    <br>
    Excel example (columns marked in red, rows tree 1 marked in yellow, rows tree 2 marked in blue):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_products_profile_cat_tree_link_title'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_import_products_category_tree_last_child'] = 'Category last child assign';
$_['profile_import_products_category_tree_last_child_modal_title'] = 'Category last child assign';
$_['profile_import_products_category_tree_last_child_modal_description'] = '    <p>Example import result with "Last child assign" <b>DISABLED</b>:</p><img style="width: 260px;" src="%s">
    <br><br>
    <p>Example import result with "Last child assign" <b>ENABLED</b>:</p><img style="width: 260px;" src="%s">
';
$_['profile_import_products_rest_tax'] = 'Subtract tax from prices';
$_['profile_import_products_rest_tax_remodal_title'] = 'Subtract tax from prices';
$_['profile_import_products_rest_tax_remodal_description'] = '    <p><b>Import process</b>: If product has a tax class assigned, this tax value will be <b>subtracted from price</b>, this only will happen IN PRODUCT CREATION. This can be useful is you are getting product files from your provider, and their prices are <b>with TAXES</b>, however you want import these prices without taxes.</p>
    <p><b>Export process:</b> If product has a tax class assigned, this tax value will be <b>subtracted from price</b>. This can be useful when your OpenCart product prices include taxes and you are sending products to a  platform that requires prices without taxes.</p>
';
$_['profile_import_products_rest_tax_link_title'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_import_products_sum_tax'] = 'Add tax to prices';
$_['profile_import_products_sum_tax_remodal_title'] = 'Add tax to prices';
$_['profile_import_products_sum_tax_remodal_description'] = '    <p><b>Import process</b>: If product has a tax class assigned, this tax value will be <b>added</b> to price, this only will happen IN PRODUCT CREATION. This can be useful is you are getting product files from your provider, and their prices are <b>without TAXES</b>, hovewer you want import these prices with taxes because you are managing prices with taxes (without using default Opencart tax rates).</p>
    <p><b>Export process:</b> If product has a tax class assigned, this tax value will be <b>added</b> to price. This can be useful if you are sending products to another plataform wich requires prices with taxes.</p>
';
$_['profile_import_products_sum_tax_link_title'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_import_products_data_related_legend'] = 'Product related data';
$_['profile_import_cat_number'] = 'Categories number';
$_['profile_cat_number_remodal_title'] = 'Categories number';
$_['profile_cat_number_remodal_description'] = '    <p>This value set the number of "<b>Categories columns</b>" number on file, example file with <b><u>3</u></b> "<b>Categories number</b>" (columns marked in red):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_cat_number_link'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_cat_tree_number_parent'] = 'Category parent numbers';
$_['profile_cat_tree_number_parent_remodal_title'] = 'Category parent numbers';
$_['profile_cat_tree_number_parent_remodal_description'] = '    <p>This number set the number of  "<b>Category parent columns</b>" on file, example file with <b><u>2</u></b> "<b>Category parent numbers</b>" (columns marked in red):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_cat_tree_number_parent_link'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_cat_tree_number_children'] = 'Category childrens level';
$_['profile_cat_tree_number_children_remodal_title'] = 'Category childrens level';
$_['profile_cat_tree_number_children_remodal_description'] = '    <p>This number set the number of "<b>Category children levels</b>" in file, example file with <b><u>2</u></b> "<b>Category children level</b>" in each category tree (columns marked in red):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_cat_tree_number_children_link'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_import_image_number'] = 'Images number';
$_['profile_import_image_number_remodal_title'] = 'Images number';
$_['profile_import_image_number_remodal_description'] = '    <p>This number set the "<b>Images columns</b>" number in file, example file with <b><u>5</u></b> "<b>Images number</b>" (columns marked in red):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_image_number_link'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_import_attribute_number'] = 'Attributes number';
$_['profile_import_attribute_number_remodal_title'] = 'Attributes number';
$_['profile_import_attribute_number_remodal_description'] = '    <p>This value sets the number of "<b>Attributes columns</b>" in file, example file with <b><u>2</u></b> "<b>Attributes number</b>" (columns marked in red):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_attribute_number_link'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_import_special_number'] = 'Specials number';
$_['profile_import_special_number_remodal_title'] = 'Specials number';
$_['profile_import_special_number_remodal_description'] = '    <p>This value set the number of "<b>Specials columns</b>" in file, example file with <b><u>1</u></b> "<b>Specials number</b>" (columns marked in red):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_special_number_link'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_import_discount_number'] = 'Discounts number';
$_['profile_import_discount_number_remodal_title'] = 'Discounts number';
$_['profile_import_discount_number_remodal_description'] = '    <p>This value set the number of "<b>Discounts columns</b>" in file, example file with <b><u>1</u></b> "<b>Discounts number</b>" (columns marked in red):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_discount_number_link'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_import_filter_group_number'] = 'Filter groups number';
$_['profile_import_filter_group_number_remodal_title'] = 'Filter groups number';
$_['profile_import_filter_group_number_remodal_description'] = '    <p>This value set the number of "<b>Filter groups columns</b>" in file, example file with <b><u>3</u></b> "<b>Filter groups number</b>" (columns marked in red):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_filter_group_number_link'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_import_filter_number'] = 'Filters number for each filter group';
$_['profile_import_filter_number_remodal_title'] = 'Filters number for each filter group';
$_['profile_import_filter_number_remodal_description'] = '    <p>This value set the number of "<b>Filters columns for each filter group</b>" in file, example file with <b><u>1</u></b> "<b>Filters number for each filter group</b>" (columns marked in red):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_filter_number_link'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_import_download_number'] = 'Downloads number';
$_['profile_import_download_number_remodal_title'] = 'Downloads number';
$_['profile_import_download_number_remodal_description'] = '    <p>This value set the number of "<b>Downloads columns</b>" in file, example file with <b><u>1</u></b> "<b>Downloads number</b>" (columns marked in red):</p>
    <img style="width: 605px;" src="%s">
';
$_['profile_import_download_number_link'] = '<b>IMPORTANT</b>: Click to read!';
$_['profile_export_sort_order'] = 'Sort order to export (optional)';
$_['profile_export_sort_order_config'] = 'Export sort order';
$_['profile_export_sort_order_table_field'] = 'Sort order field';
$_['profile_export_sort_order_none'] = ' - None - ';
$_['profile_export_sort_order_order'] = 'Sort order mode';
$_['profile_export_sort_order_asc'] = 'Ascendancy a-z, 0-9';
$_['profile_export_sort_order_desc'] = 'Descendant z-a, 9-0';
$_['profile_product_identificator'] = 'Product identificator';
$_['profile_product_identificator_product_id'] = 'Product ID';
$_['profile_product_identificator_model'] = 'Product Model';
$_['profile_product_identificator_sku'] = 'Product SKU';
$_['profile_product_identificator_upc'] = 'Product UPC';
$_['profile_product_identificator_ean'] = 'Product EAN';
$_['profile_product_identificator_jan'] = 'Product JAN';
$_['profile_product_identificator_isbn'] = 'Product ISBN';
$_['profile_product_identificator_mpn'] = 'Product MPN';
$_['profile_import_products_autoseo_gerator'] = 'Auto SEO keyword';
$_['profile_import_products_autoseo_gerator_none'] = 'I will put SEO keyword manually';
$_['profile_import_products_autoseo_gerator_name'] = 'Auto generate SEO keyword from product name';
$_['profile_import_products_autoseo_gerator_meta_title'] = 'Auto generate SEO keyword from product meta title';
$_['profile_import_products_autoseo_gerator_model'] = 'Auto generate SEO keyword from product model';
$_['profile_import_products_existing_products'] = 'For existing products';
$_['profile_import_products_existing_products_edit'] = 'Edit these';
$_['profile_import_products_existing_products_skip'] = 'Skip these';
$_['profile_import_products_new_products'] = 'For new products';
$_['profile_import_products_new_products_edit'] = 'Create these';
$_['profile_import_products_new_products_skip'] = 'Skip these';
$_['profile_import_products_download_image_route'] = 'Path to downloaded images';
$_['profile_import_products_download_image_route_remodal_title'] = 'Path to downloaded images';
$_['profile_import_products_download_image_route_remodal_description'] = '    <p>The system will detect if links exist in "<b>Image</b>" columns, in this case, the import system will download image and assign it to your elements.</p>
    <p>By default, your images downloaded will be saved in directory "<b>%s</b>".</p>
    <p>In this field, you can add subfolders to this route, to order your images like you want. For example, if you put int his field "<b>my_provider/cars/accessories</b>", the images will be saved in final route "<b>%smy_provider/cars/accesories</b>"</p>
';
$_['profile_import_products_download_image_route_remodal_link'] = '<b>IMPORTANT:</b> Click to read!';
$_['profile_products_columns'] = 'Columns mapping';
$_['profile_import_column_config'] = 'Columns';
$_['profile_import_column_config_thead_clone_columns'] = 'Get columns configuration from profile:';
$_['profile_import_column_config_thead_select_all'] = 'Check/Uncheck All';
$_['profile_import_column_config_thead_sort_order'] = 'Sort order';
$_['profile_import_column_config_thead_column'] = 'Column';
$_['profile_import_column_config_thead_column_custom_name'] = 'Custom column name';
$_['profile_import_column_config_thead_column_default_value'] = 'Default value';
$_['columns_default_value_title'] = 'Default value';
$_['columns_default_value_description'] = '        <p><b>Export process:</b> If you put "<b>Default value</b>" in some column and this column is enabled, when you export this file, export system assign this value <b>IF EMPTY</b>.</p>
        <br>
        <p><b>Import process:</b> If you put "<b>Default value</b>" in some column and this column is enabled, when you import file, import system assign this value in case of this column <b>IS EMPTY OR DOESN\'T EXIST</b>. This is useful if your external provider is giving you product data file without some basic data for you (for example, categories, filters....).</p>
    ';
$_['columns_default_value_link'] = '  <i style="font-size: 14px;" class="fa fa-info-circle"></i>';
$_['profile_import_column_config_thead_column_extra_configuration'] = 'Extra configuration';
$_['profile_column_config_extra_configuration_value_true'] = 'True value like:';
$_['profile_column_config_extra_configuration_value_false'] = 'False value like:';
$_['profile_column_config_extra_configuration_image_link'] = 'Full image link:';
$_['profile_column_config_extra_configuration_names_instead_of_id'] = 'Name instead of ID:';
$_['profile_column_config_extra_configuration_product_id_identificator'] = 'Product ID like:';
$_['profile_column_config_extra_configuration_profit_margin'] = 'Profit margin (%)';
$_['profile_column_config_extra_configuration_profit_margin_help'] = 'In <b><u>product creation</u></b> the system will increment this price in percentage that you put in this field. <b><u>ONLY NUMBERS</b></u>';
$_['profile_import_column_config_thead_status'] = 'Status';
$_['profile_products_columns_possible_values'] = 'Possible values';
$_['profile_products_columns_possible_values_id'] = 'ID';
$_['profile_products_columns_possible_values_name'] = 'Name';
$_['profile_products_columns_possible_values_yes'] = 'Yes';
$_['profile_products_columns_possible_values_no'] = 'No';
$_['profile_products_columns_possible_values_products_related'] = '<b>Product models</b> split by "|", example: ADTR4|ROFK8|DK8723';
$_['profile_products_columns_possible_values_stores'] = 'If product has more than 1 store assigned, separate store IDs with symbol "|", for example: <b>0|1|2</b>';
$_['profile_products_columns_possible_values_image_local'] = '<b>Local image</b>: Image path has to start like "<b>%s</b>", example "<b>%scars/tesla-model-3.jpg</b>"';
$_['profile_products_columns_possible_values_image_external'] = '<b>Remote image</b>: Direct link to image, example: <b>https://www.external-plataform.com/images/tesla-model-3.jpg</b>, the system will download image (in directory "<b>/image/%s</b>") and assign it to your elements:
            <ul>
                <li><b>Products</b>: "product-product-id.extension", example: "<b>product-134.jpg</b>" (to main image). "<b>product-134-1.jpg</b>" (to first adittional image)...</li>
                <li><b>Categories</b>: "category-category-id.extension", example: "<b>category-134.jpg</b>"</li>
                <li><b>Manufacturers</b>: "manufacturer-manufacturer-id.extension", example: "<b>manufacturer-134.jpg</b>"</li>
                <li><b>Option values</b>: "option-value-option-value-id.extension", example: "<b>option-value-134.jpg</b>"</li>
            </ul>
        ';
$_['profile_categories_columns_possible_values_parent_id'] = 'Category ID';
$_['profile_categories_columns_possible_values_filters'] = 'Filter names separated by "|" with your default language "<b>%s</b>". Example: Wheels|Accesories|Cars';
$_['profile_products_quick_filter'] = 'Quick product filters';
$_['profile_products_quick_filter_categories'] = 'Categories';
$_['profile_products_quick_filter_categories_help'] = '(Nothing selected = All categories) The system will export products whose categories are one of the categories marked.';
$_['profile_products_quick_filter_manufacturers'] = 'Manufacturers';
$_['profile_products_quick_filter_manufacturers_help'] = '(Nothing selected = All manufacturers) The system will export products whose manufacturer are one of the manufacturers marked.';
$_['profile_products_filters'] = 'Filters configuration';
$_['profile_import_filter_config'] = 'Filters';
$_['profile_products_filters_add_filter'] = 'Click to add new filter';
$_['profile_products_filters_remove_filter'] = 'Click to remove filter';
$_['profile_products_filters_thead_field'] = 'Field';
$_['profile_products_filters_thead_condition'] = 'Condition';
$_['profile_products_filters_thead_value'] = 'Value';
$_['profile_products_filters_thead_actions'] = 'Actions';
$_['profile_products_filters_conditional_contain'] = 'Contain';
$_['profile_products_filters_conditional_not_contain'] = 'NOT contain';
$_['profile_products_filters_conditional_is_exactly'] = 'Is exactly';
$_['profile_products_filters_conditional_is_not_exactly'] = 'Is NOT exactly';
$_['profile_products_filters_conditional_is_yes'] = 'Is YES';
$_['profile_products_filters_conditional_is_no'] = 'Is NOT';
$_['profile_products_filters_main_conditional'] = 'Set main conditional to your filters';
$_['profile_products_filters_main_conditional_or'] = 'OR';
$_['profile_products_filters_main_conditional_and'] = 'AND';
$_['profile_import_profile_name'] = 'Profile name';
$_['profile_load_error_not_found'] = 'Profile not found';
$_['profile_error_delete_profile_id_empty'] = 'Param profile id not found.';
$_['profile_error_empty_column_custom_name'] = '<b>Error:</b> Detected empty column custom name';
$_['profile_error_repeat_column_custom_name'] = '<b>Error:</b> Detected <b>%s</b> repeat column custom name "<b>%s</b>"';
$_['profile_error_option_option_value_default_filled'] = '<b>Error:</b> Default value only allowed to column "<b>%s</b>" or "<b>%s</b>", not both.';
$_['profile_error_empty_name'] = 'Error saving profile: Put a profile name.';
$_['profile_error_max_input_vars'] = '<b>Error saving profile</b>: Exceeded PHP directive "<b>max_input_vars</b>" wich value is <b>%s</b> vars and you are sending <b>%s</b> vars. Reduce column numbers or increase directive "<b>max_input_vars</b>" value in your server settings. You may ask your host company how to do that.';
$_['profile_error_uncompleted'] = 'Error saving profile: Complete all profile form.';
$_['profile_column_config_extra_configuration_splitted_values'] = 'Values splitted';
$_['profile_column_config_extra_splitted_values_title'] = 'Column splitted values';
$_['profile_column_config_extra_splitted_values_description'] = '   <p>In case that you need <b>import</b> a file that contains multiple values in same column <b>separated by symbols</b>, you have to use next configuration:</b></p>
   <ol>
    <li><b>Custom column name:</b> "COLUMN_NAME>POSITION" (0=1, 1=2, 2=3...)</li>
    <li><b>Extra configuration -> "Values splitted":</b> Enter symbol used to separate values.</li>
    </ol>
<img style="width: 605px;" src="%s">
<br><br>
<p>Following image example:</p>
<ul>
<li><b>Categories>0</b> = Men</li>
<li><b>Categories>1</b> = Accesories</li>
<li><b>Categories>2</b> = Shoes</li>
</ul>
';
$_['profile_column_config_extra_splitted_values_link'] = '<i style="font-size: 14px;" class="fa fa-info-circle"></i>';
$_['profile_products_filters_conditional_years_ago'] = 'Last Х years';
$_['profile_products_filters_conditional_months_ago'] = 'Last X Months';
$_['profile_products_filters_conditional_days_ago'] = 'Last X days';
$_['profile_products_filters_conditional_hours_ago'] = 'Last X hours';
$_['profile_products_filters_conditional_minutes_ago'] = 'Last X minutes';
$_['profile_error_xml_custom_columns'] = 'Error saving profile: Custom column "<b>%s</b>" has a incorrect name, spaces or symbols found (symbols "<b>></b>", "<b></b>*" and "<b></b>@" only allowed in <b>import</b> profiles).';
$_['profile_error_splitted_values'] = 'Error saving profile: Custom column "<b>%s</b>" excepted "<b>></b>" symbol because you marked this column with "<b>Values splitted</b>". Example "<b>%s>0</b>"';
$_['profile_import_mapping_xml_columns_remodal_title'] = 'XML COLUMN MAPPING EXAMPLES';
$_['profile_import_mapping_xml_columns_remodal_description'] = '    <p>Here you can see all possible cases of "<b>Custom column names</b>" to <b>XML</b> format in <b>Import processes</b></p><br>
    <img style="width: 605px;" src="%s">
    <p>"<b>CODE</b>" = 23434</p>
    <img style="width: 605px;" src="%s">
    <p>"<b>CATEGORIES>CATEGORY*0</b>" = Woman<br>
    "<b>CATEGORIES>CATEGORY*1</b>" = Accesories<br>
    "<b>CATEGORIES>CATEGORY*2</b>" = Necklaces</p>
    <img style="width: 605px;" src="%s">
    <p>"<b>parameters>parameter*0@type_explanation</b>" = Gr<br>
    "<b>parameters>parameter*0@value</b>" = 200<br>
    "<b>parameters>parameter*1@type_explanation</b>" = Cm<br>
    "<b>parameters>parameter*1@value</b>" = 35</p>
    <img style="width: 605px;" src="%s">
    <p>In this case, have to apply "<b>Splitted values</b>" rules.
';
$_['profile_import_mapping_xml_columns_link_title'] = 'IMPORTANT: READ ABOUT XML COLUMN MAPPING IN IMPORT PROCESSES';
?>