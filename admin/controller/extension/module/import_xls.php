<?php
class ControllerExtensionModuleImportXls extends Controller
{
    private $error = array();

    private $data_to_view = array();

    public function __construct($registry)
    {
        /*$elementName = 'IMAGES>IMAGES_1';
        echo preg_match("/(\>|\*|\@)/i", $elementName) && !preg_match('/\s/',$elementName); die;*/
        //Call to parent __construct
            parent::__construct($registry);

        if(defined('IE_PRO_CRON')) {
            ob_start();
            $this->is_cron_task = true;
            $this->request->get['route'] = '';
            $this->request->get['ajax_function'] = 'launch_profile';
            $this->request->post['profile_id'] = PROFILE_ID;
        }

        //Check server requirements
            $this->_server_configuration();

        $this->_get_module_data();
        $this->_get_form_basic_data();

        if ($this->request->get['route'] == $this->real_extension_type.'/'.$this->extension_name)
            $this->form_array = $this->_construct_view_form();
    }

    public function index(){
        $this->_check_ajax_function();
        $this->document->setTitle($this->language->get('heading_title_2'));
        $this->_get_breadcrumbs();
        $this->_check_post_data();

        //Send token to view
            $this->data_to_view['token'] = $this->session->data[$this->token_name];
            $this->data_to_view['action'] = $this->url->link($this->real_extension_type.'/'.$this->extension_name, $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL');
            $this->data_to_view['cancel'] = $this->url->link(version_compare(VERSION, '2.0.0.0', '>=') ? $this->extension_url_cancel_oc_2x : $this->extension_url_cancel_oc_15x, $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL');

        $this->_check_errors_to_send();
        $this->_load_basic_languages();
        $form = $this->model_extension_devmanextensions_tools->_get_form_in_settings();
        $this->data_to_view['form'] =  !empty($form) ? $form : '';
        $this->_send_custom_variables_to_view();

        if(version_compare(VERSION, '2.0.0.0', '>='))
        {
            $data = $this->data_to_view;
            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');

            $this->response->setOutput($this->load->view($this->real_extension_type.'/'.$this->extension_view, $data));
        }
        else
        {
            $document_scripts = $this->document->getScripts();
            $scripts = array();
            foreach ($document_scripts as $key => $script)
                $scripts[] = $script;
            $this->data_to_view['scripts'] = $scripts;

            $document_styles = $this->document->getStyles();
            $styles = array();
            foreach ($document_styles as $key => $style)
                $styles[] = $style;
            $this->data_to_view['styles'] = $styles;

            $this->data = $this->data_to_view;
            $this->template = $this->real_extension_type.'/'.$this->extension_view;

            $this->response->setOutput($this->render());
        }
    }

    public function _server_configuration() {
        if (strpos(ini_get('default_charset'), ';') !== false) {
           ini_set('default_charset', 'UTF-8');
        }

        /*ini_set('max_input_vars', 50000);

        $memory_limit = $this->config->get('import_xls_memory_limit') ? $this->config->get('import_xls_memory_limit') : 1024;
        ini_set("memory_limit", $memory_limit.'M');

        $max_execution_time = $this->config->get('import_xls_max_execution_time') ? $this->config->get('import_xls_max_execution_time') : 3600;
        ini_set("max_execution_time",$max_execution_time);*/

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if (strpos(ini_get('default_charset'), ';') !== false) {
           ini_set('default_charset', 'UTF-8');
        }

        ini_set("memory_limit","8096M");
        ini_set("max_execution_time",600000000);

        if(phpversion() < '5.5') {
            die('ERROR: YOUR PHP VERSION IS <b>'.phpversion().'</b> REQUIRED <b>5.5.0 or higher</b>');
        }

        if( !extension_loaded('zip')) {
             die('ERROR: <b>php_zip</b> EXTENSION NEEDS BE ENABLED. IF YOU DON\'T KNOW HOW TO DO IT, YOUR HOSTING SUPPORT TEAM WILL CAN DO IT FOR YOU.');
        }
    }

    function _get_module_data() {
        $this->is_mijoshop = class_exists('MijoShop');

        if($this->is_mijoshop) {
            $app = JFactory::getApplication();
            $prefix = $app->get('dbprefix');
            $this->db_prefix = $prefix . 'mijoshop_';
        }
        else
            $this->db_prefix = DB_PREFIX;

        $this->extension_type = 'module';
        $this->real_extension_type = (version_compare(VERSION, '2.3', '>=') ? 'extension/':'').$this->extension_type;

        $this->extension_url_cancel_oc_15x = 'common/home';
        $this->extension_url_cancel_oc_2x = 'common/dashboard';

        $this->extension_name = 'import_xls';
        $this->extension_group_config = 'import_xls';
        $this->extension_id = '542068d4-ed24-47e4-8165-0994fa641b0a';

        $this->oc_version = version_compare(VERSION, '3.0.0.0', '>=') ? 3 : (version_compare(VERSION, '2.0.0.0', '>=') ? 2 : 1);
        $this->is_oc_3x = $this->oc_version >= 3;
        $this->is_ocstore = is_dir(DIR_APPLICATION . 'controller/octeam_tools');

        $this->data_to_view = array(
            'button_apply_allowed' => false,
            'button_save_allowed' => false,
            'extension_name' => $this->extension_name,
            'license_id' => $this->config->get($this->extension_group_config.'_license_id') ? $this->config->get($this->extension_group_config.'_license_id') : '',
            'oc_version' => $this->oc_version
        );

        $this->license_id = $this->config->get($this->extension_group_config.'_license_id') ? $this->config->get($this->extension_group_config.'_license_id') : '';
        $this->form_file_path = str_replace('system/', '', DIR_SYSTEM).$this->extension_name.'_form.txt';
        $this->form_file_url = HTTP_CATALOG.$this->extension_name.'_form.txt';

        $this->token_name = version_compare(VERSION, '3.0.0.0', '<') ? 'token' : 'user_token';
        if($this->is_cron_task)
            $this->session->data[$this->token_name] = '';

        $this->token = $this->session->data[$this->token_name];
        $this->extension_view = version_compare(VERSION, '3.0.0.0', '<') ? $this->extension_name.'.tpl' : $this->extension_name;

        $this->load->language($this->real_extension_type.'/'.$this->extension_name);
        $this->load->language($this->real_extension_type.'/ie_pro_general');
        $this->assets_path = DIR_SYSTEM.'assets/ie_pro_includes/';

        //<editor-fold desc="Get customer groups">
            if(version_compare(VERSION, '2.0.3.1', '<='))
            {
                $this->load->model('sale/customer_group');
                $this->customer_groups = $this->model_sale_customer_group->getCustomerGroups();
            }
            else
            {
                $this->load->model('customer/customer_group');
                $this->customer_groups = $this->model_customer_customer_group->getCustomerGroups();
            }
        //</editor-fold>
        $this->load->model('extension/devmanextensions/tools');
        $this->load->model('extension/module/ie_pro');
        $this->load->model('extension/module/ie_pro_tab_export_import');
        $this->load->model('extension/module/ie_pro_tab_migrations');

        $this->load->model('extension/module/ie_pro_profile');
        $this->model_extension_module_ie_pro_profile->_check_profiles_table();
        $this->model_profile = 'model_extension_module_ie_pro_profile';

        $this->has_cron = file_exists('model/extension/module/ie_pro_tab_crons.php');
        //$this->has_cron = false;
        if($this->has_cron)
            $this->load->model('extension/module/ie_pro_tab_crons');

        $this->load->model('extension/module/ie_pro_tab_profiles');
        $this->model_extension_module_ie_pro_tab_profiles->load_generic_data();

        //<editor-fold desc="Count languages active">
            $this->load->model('localisation/language');
            $languages = $this->model_localisation_language->getLanguages();
            $languages_ids = array();
            foreach ($languages as $key => $value) {
                $code_formatted = $this->model_extension_module_ie_pro->format_column_name($value['code']);
                $languages[$key]['code'] = $code_formatted;
                $languages_ids[$value['language_id']] = $code_formatted;
            }

            $this->languages = $languages;
            $this->languages_ids = $languages_ids;
            $this->count_languages = 0;

            foreach ($this->languages as $key => $lang) {
                if($lang['status'])
                    $this->count_languages++;
            }

            $this->default_language_code = $this->config->get('config_admin_language');
            $language = $this->db->query('SELECT `language_id` FROM `'.$this->db_prefix.'language` WHERE `code` = "'.$this->default_language_code.'"');
            $this->default_language_id = array_key_exists('language_id', $language->row) ? $language->row['language_id'] : die('Default language ID not found.');
        //</editor-fold>
        $this->api_url = defined('DEVMAN_SERVER_TEST') ? DEVMAN_SERVER_TEST : 'https://devmanextensions.com/';
        $this->libraries_url = $this->api_url.'opencart_admin/ext_ie_pro/libraries.zip';
        $this->isdemo =  strpos($_SERVER['HTTP_HOST'], 'devmanextensions.com') !== false;

        $this->root_path = substr(DIR_APPLICATION, 0, strrpos(DIR_APPLICATION, '/', -2)).'/';
        $this->path_progress = $this->root_path.'ie_pro/';
        $this->path_progress_file = $this->path_progress.'progress'.($this->is_cron_task ? '_cron':'').'.iepro';
        $this->path_cache_public = HTTPS_CATALOG.($this->is_mijoshop ? 'components/com_mijoshop/opencart/':'').'ie_pro/';
        $this->path_progress_public = $this->path_cache_public.'progress.iepro';
        $this->path_tmp = $this->path_progress.'tmp/';
        $this->path_tmp_public = $this->path_cache_public.'tmp/';
        $this->google_spreadsheet_json_file_path = $this->path_progress.'user_gdrive.json';

        $this->layouts = $this->model_extension_module_ie_pro->get_layouts();
        $this->tax_classes = $this->model_extension_module_ie_pro->get_tax_classes();
        $this->stock_statuses = $this->model_extension_module_ie_pro->get_stock_statuses();
        $this->stores_import_format = $this->model_extension_module_ie_pro->get_stores_import_format();
        $this->stores_count = count($this->stores_import_format);
        $this->hasFilters = version_compare(VERSION, '1.5.4', '>');
        $this->hasCustomerDescriptions = version_compare(VERSION, '1.5.2.1', '>');
        $this->length_classes = $this->model_extension_module_ie_pro->get_classes_length();
        $this->weight_classes = $this->model_extension_module_ie_pro->get_classes_weight();
        $this->table_seo = $this->is_oc_3x ? 'seo_url' : 'url_alias';
        $this->load->model('extension/module/ie_pro_database');
        $this->database_field_types = $this->model_extension_module_ie_pro_database->get_database_field_types();
        $this->database_schema = $this->model_extension_module_ie_pro_database->get_database_without_groups();
        $this->product_option_value = array_key_exists('option_value', $this->database_schema['product_option']) ? 'option_value' : 'value';
        $this->is_t = strpos($this->license_id, 'trial-') !== false;
        $this->data_to_view['link_trial'] = sprintf($this->language->get('link_trial'), $this->extension_id, HTTPS_CATALOG);
        $this->is_t_elem = ord(2);;

        $option_types_with_values = array(
            'select',
            'radio',
            'checkbox',
        );
        $this->tables_with_images = array(
            'product',
            'product_image',
            'category',
            'manufacturer',
            'option_value',
        );
        $this->option_types_with_values = $option_types_with_values;
        $this->image_path = version_compare(VERSION, '2', '<') ? 'data/' : 'catalog/';
    }

    function _get_form_basic_data() {
        $this->use_session_form = !$this->is_oc_3x;
        $this->form_token_name = 'devmanextensions_form_token_'.$this->extension_group_config;
        $this->form_session_name = 'devmanextensions_form_'.$this->extension_group_config;

        //Is the first time that configure extension?
            $this->setting_group_code = version_compare(VERSION, '2.0.1.0', '>=') ? 'code' : '`group`';
            $results = $this->db->query('SELECT setting_id FROM '. $this->db_prefix . 'setting WHERE '.$this->setting_group_code.' = "'.$this->extension_group_config.'" AND `key` NOT LIKE "%license_id%" LIMIT 1');
            $this->first_configuration = empty($results->row['setting_id']);
        //END

        $this->load->model('extension/devmanextensions/tools');

        //Devman Extensons - info@devmanextensions.com - 2016-10-09 19:39:52 - Load languages
            $this->load->model('localisation/language');
            $languages = $this->model_localisation_language->getLanguages();
            $this->langs = $this->model_extension_devmanextensions_tools->formatLanguages($languages);
        //END

        //Devman Extensions - info@devmanextensions.com - 2017-08-29 19:25:03 - Get customer groups
            $customer_groups = $this->model_extension_devmanextensions_tools->getCustomerGroups();
            $this->cg = $customer_groups;
        //END

        $this->oc_2 = version_compare(VERSION, '2.0.0.0', '>=');
        $this->oc_3 = version_compare(VERSION, '3.0.0.0', '>=');

        $form_basic_datas = array(
            'is_ocstore' => $this->is_ocstore,
            'tab_changelog' => true,
            'tab_help' => true,
            'tab_faq' => true,
            'extension_id' => $this->extension_id,
            'first_configuration' => $this->first_configuration,
            'positions' => $this->positions,
            'statuses' => $this->statuses,
            'stores' => $this->stores,
            'layouts' => $this->layouts,
            'languages' => $this->langs,
            'oc_version' => $this->oc_version,
            'oc_2' => $this->oc_2,
            'oc_3' => $this->oc_3,
            'customer_groups' => $this->cg,
            'version' => VERSION,
            'extension_version' => $this->language->get('extension_version'),
            'token' => $this->token,
            'extension_group_config' => $this->extension_group_config,
            'no_image_thumb' => $this->no_image_thumb,
            'lang' => array(
                'choose_store' => $this->language->get('choose_store'),
                'text_browse' => $this->language->get('text_browse'),
                'text_clear' => $this->language->get('text_clear'),
                'text_sort_order' => $this->language->get('text_sort_order'),
                'text_clone_row' => $this->language->get('text_clone_row'),
                'text_remove' => $this->language->get('text_remove'),
                'text_add_module' => $this->language->get('text_add_module'),
                'tab_help' => $this->language->get('tab_help'),
                'tab_changelog' => $this->language->get('tab_changelog'),
                'tab_faq' => $this->language->get('tab_faq'),
            ),
        );

        $this->form_basic_datas = $form_basic_datas;
    }

    public function _check_post_data() {
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->extension_module_iepro->validate_permiss()) {
            $this->session->data['error'] = '';

            //Devman Extensions - info@devmanextensions.com - 2016-10-21 18:57:30 - Custom functions
                if(
                    !empty($this->request->post['force_function']) || !empty($this->request->get['force_function'])
                    ||
                    !empty($this->request->post[$this->extension_group_config.'_force_function']) || !empty($this->request->get[$this->extension_group_config.'force_function'])
                )
                {
                    if(!empty($this->request->post['force_function']) || !empty($this->request->get['force_function']))
                        $index = 'force_function';
                    else
                        $index = $this->extension_group_config.'_force_function';

                    $post_get = !empty($this->request->post[$index]) ? 'post' : 'get';
                    $this->{$this->request->{$post_get}[$index]}();
                }
            //END

            //OC Versions compatibility
            $this->_redirect($this->real_extension_type.'/'.$this->extension_name);
        }
    }

    public function _check_ajax_function() {
        if(
            !empty($this->request->post['ajax_function']) || !empty($this->request->get['ajax_function'])
            ||
            !empty($this->request->post[$this->extension_group_config.'_ajax_function']) || !empty($this->request->get[$this->extension_group_config.'ajax_function'])
        )
        {
            if(!empty($this->request->post['ajax_function']) || !empty($this->request->get['ajax_function']))
                $index = 'ajax_function';
            else
                $index = $this->extension_group_config.'_force_function';

            $post_get = !empty($this->request->post[$index]) ? 'post' : 'get';
            $function_name = $this->request->{$post_get}[$index];

            if($function_name == 'profile_load') {
                $this->{$this->model_profile}->load();
            } else if($function_name == 'cancel_process') {
                $this->model_extension_module_ie_pro->cancel_process($this->request->post['error']);
            }

            $this->model_extension_module_ie_pro_tab_profiles->_check_ajax_function($function_name);
            $this->model_extension_module_ie_pro_tab_export_import->_check_ajax_function($function_name);
            $this->model_extension_module_ie_pro_tab_migrations->_check_ajax_function($function_name);
            if($this->has_cron)
                $this->model_extension_module_ie_pro_tab_crons->_check_ajax_function($function_name);

            $this->{$function_name}();
        }
    }

    public function _get_breadcrumbs() {
        $this->data_to_view['breadcrumbs'] = array();
        $this->data_to_view['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'),
            'separator' => false
        );

        $this->data_to_view['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_2'),
            'href'      => $this->url->link($this->real_extension_type.'/'.$this->extension_name, $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'),
            'separator' => ' :: '
        );
    }

    public function _add_css_js_to_document() {
        //Add scripts and css
            if(version_compare(VERSION, '2.0.0.0', '<'))
            {
                $this->document->addScript($this->api_url.'/opencart_admin/common/js/jquery-2.1.1.min.js?'.date('Ymdhis'));
                $this->document->addScript($this->api_url.'/opencart_admin/common/js/bootstrap.min.js?'.date('Ymdhis'));
                $this->document->addStyle($this->api_url.'/opencart_admin/common/css/bootstrap.min.css?'.date('Ymdhis'));

                $this->document->addScript($this->api_url.'/opencart_admin/common/js/datetimepicker/moment.js?'.date('Ymdhis'));
                $this->document->addScript($this->api_url.'/opencart_admin/common/js/datetimepicker/bootstrap-datetimepicker.min.js?'.date('Ymdhis'));
                $this->document->addStyle($this->api_url.'/opencart_admin/common/css/bootstrap-datetimepicker.min.css?'.date('Ymdhis'));
            }

            $this->document->addStyle($this->api_url.'/opencart_admin/common/css/colpick.css?'.date('Ymdhis'));
            $this->document->addStyle($this->api_url.'/opencart_admin/common/css/bootstrap-select.min.css?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'/opencart_admin/common/js/colpick.js?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'/opencart_admin/common/js/bootstrap-select.min.js?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'/opencart_admin/common/js/tools.js?'.date('Ymdhis'));
            $this->document->addStyle($this->api_url.'/opencart_admin/common/css/license_form.css?'.date('Ymdhis'));

            $this->document->addStyle($this->api_url.'/opencart_admin/common/js/remodal/remodal.css?'.date('Ymdhis'));
            $this->document->addStyle($this->api_url.'/opencart_admin/common/js/remodal/remodal-default-theme.css?'.date('Ymdhis'));
            $this->document->addStyle($this->api_url.'/opencart_admin/common/js/remodal/remodal-default-theme-override.css?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'/opencart_admin/common/js/remodal/remodal.min.js?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'/opencart_admin/common/js/remodal/remodal-improve.js?'.date('Ymdhis'));

            if(version_compare(VERSION, '2.0.0.0', '>='))
            {
                $this->document->addScript($this->api_url.'/opencart_admin/common/js/oc2x.js?'.date('Ymdhis'));
                $this->document->addStyle($this->api_url.'/opencart_admin/common/css/oc2x.css?'.date('Ymdhis'));
            }
            else
            {
                $this->document->addScript($this->api_url.'/opencart_admin/common/js/oc2x.js?'.date('Ymdhis'));
                $this->document->addStyle($this->api_url.'/opencart_admin/common/css/oc2x.css?'.date('Ymdhis'));
                $this->document->addStyle($this->api_url.'/opencart_admin/common/css/oc15x.css?'.date('Ymdhis'));
                $this->document->addScript('view/javascript/ckeditor/ckeditor.js?'.date('Ymdhis'));
                $this->document->addStyle('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css?'.date('Ymdhis'));
            }
        //END Add scripts and css

        //Add custom css
            $this->document->addStyle($this->api_url.'/opencart_admin/ext_ie_pro/css/general.css?'.date('Ymdhis'));
    }

    public function _check_errors_to_send() {
        if(version_compare(VERSION, '3.0.0.0', '>='))
        {
            if(!empty($this->session->data['error']))
            {
                $this->data_to_view['error_warning_2'] = $this->session->data['error'];
                unset($this->session->data['error']);
            }

            if(array_key_exists('new_version', $this->session->data) && !empty($this->session->data['new_version']))
            {
                $this->data_to_view['new_version'] = $this->session->data['new_version'];
                unset($this->session->data['new_version']);
            }

            if(!empty($this->session->data['error_expired']))
            {
                $this->data_to_view['error_warning_expired'] = $this->session->data['error_expired'];
                unset($this->session->data['error_expired']);
            }

            if(!empty($this->session->data['success']))
            {
                $this->data_to_view['success_message'] = $this->session->data['success'];
                unset($this->session->data['success']);
            }

            if(!empty($this->session->data['info']))
            {
                $this->data_to_view['info_message'] = $this->session->data['info'];
                unset($this->session->data['info']);
            }
        }
    }

    public function _load_basic_languages() {
        $lang_array = array(
            'heading_title_2',
            'button_save',
            'button_cancel',
            'apply_changes',
            'text_image_manager',
            'text_browse',
            'text_clear',
            'image_upload_description',
            'text_validate_license',
            'text_license_id',
            'text_send',
        );

        foreach ($lang_array as $key => $value) {
            $this->data_to_view[$value] = $this->language->get($value);
        }

        $this->data_to_view['heading_title'] = $this->language->get('heading_title');
    }

    public  function _redirect($url) {
        if(version_compare(VERSION, '2.0.0.0', '>='))
            $this->response->redirect($this->url->link($url, $this->token_name.'=' . $this->session->data[$this->token_name]));
        else
            $this->redirect($this->url->link($url, $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'));
    }

    function catchError($errno = '', $errstr = '', $errfile = '', $errline = '') {
        $message = '<b>Error number</b>: '.$errno.'<br>';
        $message .= '<b>Error details</b>: '.$errstr.'<br>';
        $message .= '<b>Error file</b>: '.$errfile.'<br>';
        $message .= '<b>Error line</b>: '.$errline;

        throw new Exception($message);
    }

    public function _send_custom_variables_to_view() {
        $jquery_variables = array();

        $jquery_variables = array(
            'token' => $this->session->data[$this->token_name],
            'token_name' => $this->token_name,
            'action' => html_entity_decode($this->url->link($this->real_extension_type.'/import_xls', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL')),
            'link_ajax_get_form' => htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=ajax_get_form', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL')),
            'link_ajax_open_ticket' => htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=ajax_open_ticket', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL')),
            'text_image_manager' => $this->language->get('text_image_manager'),
            'convert_to_innodb_url' => htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=convert_to_innodb', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL')),
            'download_libraries_url' => htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=download_libraries', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL')),
            'libraries_download_error' => $this->language->get('libraries_download_error'),
            'remodal_button_confirm_loading_text' => $this->language->get('remodal_button_confirm_loading_text'),
            'profile_load_url' => htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=profile_load', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL')),
            'cancel_process_url' => htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=cancel_process', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL')),
        );

        $jquery_variables = $this->model_extension_module_ie_pro_tab_profiles->_send_custom_variables_to_view($jquery_variables);
        $jquery_variables = $this->model_extension_module_ie_pro_tab_export_import->_send_custom_variables_to_view($jquery_variables);
        $jquery_variables = $this->model_extension_module_ie_pro_tab_migrations->_send_custom_variables_to_view($jquery_variables);
        if($this->has_cron)
            $jquery_variables = $this->model_extension_module_ie_pro_tab_crons->_send_custom_variables_to_view($jquery_variables);

        $this->data_to_view['jquery_variables'] = $jquery_variables;
    }

    public function ajax_open_ticket()
    {
        $data = $this->request->post;
        $data['domain'] = HTTPS_CATALOG;
        $data['license_id'] = $this->config->get($this->extension_group_config.'_license_id');
        $result = $this->model_extension_devmanextensions_tools->curl_call($data, $this->api_url.'opencart/ajax_open_ticket');

        //from API are in json_encode
        echo $result; die;
    }

    public function convert_to_innodb() {
        $this->load->language($this->real_extension_type.'/import_xls');
        $array_return = array('error' => false, 'message' => $this->language->get('innodb_success'));

        $rs = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
        WHERE TABLE_SCHEMA = '".DB_DATABASE."' 
        AND ENGINE = 'MyISAM'");

        foreach ($rs->rows as $key => $table) {
            try {
                $this->db->query("ALTER TABLE `".$table['TABLE_NAME']."` ENGINE=INNODB");
            } catch (Exception $e) {
                $array_return['error'] = true;
                $array_return['message'] = $e->getMessage();
                break;
            }
        }

        if(!$array_return['error'])
        {
            $temp = array(
                'import_xls_innodb_converted' => true,
                'import_xls_license_id' => $this->config->get($this->extension_group_config.'_license_id')
            );

            $this->load->model('setting/setting');
            $this->model_setting_setting->editSetting('import_xls', $temp);
        }

        echo json_encode($array_return); die;
    }

    public function download_libraries() {
        $array_return = array('error' => false, 'message' => $this->language->get('libraries_download_successfull'));
        try {
            $file_path = DIR_SYSTEM."temp.zip";

            $f = file_put_contents($file_path, fopen($this->libraries_url, 'r'), LOCK_EX);

            if(FALSE === $f)
                throw new Exception($this->language->get('libraries_download_error_download'));

            $zip = new ZipArchive;
            $res = $zip->open($file_path);
            if ($res === TRUE) {
                $zip->extractTo(DIR_SYSTEM);
                $zip->close();
            } else {
                throw new Exception($this->language->get('libraries_download_error_download'));
            }

            unlink($file_path);
        } catch (Exception $e) {
            $array_return['error'] = true;
            $array_return['message'] = $e->getMessage();
        }
        echo json_encode($array_return); die;

    }

    public function _add_innodb_remodal($form_view) {

        $remodal_options = array(
            'open_on_ready' => true,
            'button_confirm_text' => '<i class="fa fa-database"></i>'.$this->language->get('innodb_modal_button_confirm'),
            'remodal_options' => 'closeOnConfirm: false'
        );

        $remodal_html = $this->model_extension_module_ie_pro->get_remodal('innodb', $this->language->get('innodb_modal_title'), $this->language->get('innodb_modal_description'), $remodal_options);

        $this->document->addScript($this->api_url.'/opencart_admin/ext_ie_pro/js/innodb.js?'.date('Ymdhis'));

        $form_view['tabs'][$this->language->get('tab_export_import')]['fields'][] = array(
            'type' => 'html_hard',
            'html_code' => $remodal_html
        );

        return $form_view;
    }

    public function _add_libraries_remodal($form_view) {
        $remodal_options = array(
            'open_on_ready' => true,
            'button_confirm_text' => '<i class="fa fa-download"></i>'.$this->language->get('libraries_download_confirm_download'),
            'button_cancel' => false,
            'button_close' => false,
            'button_cancel' => false,
            'remodal_options' => 'closeOnConfirm: false, closeOnEscape: false, closeOnOutsideClick: false'
        );

        $remodal_html = $this->model_extension_module_ie_pro->get_remodal('download_libraries', $this->language->get('libraries_download_remodal_title'), sprintf($this->language->get('libraries_download_remodal_description'), $this->libraries_url), $remodal_options);

        $form_view['tabs'][$this->language->get('tab_export_import')]['fields'][] = array(
            'type' => 'html_hard',
            'html_code' => $remodal_html
        );
        return $form_view;
    }

    public function _add_trial_remodal($form_view) {
        $remodal_options = array(
            'open_on_ready' => true,
            'button_cancel' => false,
        );

        $remodal_html = $this->model_extension_module_ie_pro->get_remodal('trial_remodal', $this->language->get('trial_remodal_modal_title'), $this->language->get('trial_remodal_modal_description'), $remodal_options);

        $form_view['tabs'][$this->language->get('tab_export_import')]['fields'][] = array(
            'type' => 'html_hard',
            'html_code' => $remodal_html
        );

        return $form_view;
    }

    public function _construct_view_form() {

        $this->_add_css_js_to_document();

        $form_view = array(
            'action' => $this->url->link($this->real_extension_type.'/'.$this->extension_name, $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'),
            'id' => $this->extension_name,
            'extension_name' => $this->extension_name,
            'columns' => 1,
            'tabs' => array(
                $this->language->get('tab_export_import') => array(
                    'icon' => '<i class="fa fa-database"></i>',
                    'fields' => $this->model_extension_module_ie_pro_tab_export_import->get_fields(),
                ),
                $this->language->get('tab_profiles') => array(
                    'icon' => '<i class="fa fa-user"></i>',
                    'fields' => $this->model_extension_module_ie_pro_tab_profiles->get_fields(),
                ),
                $this->language->get('tab_custom_fields') => array(
                    'icon' => '<i class="fa fa-flask"></i>',
                    'fields' => $this->_get_fields_tab_custom_fields(),
                ),
                $this->language->get('tab_cron_jobs') => array(
                    'icon' => '<i class="fa fa-calendar"></i>',
                    'fields' => $this->has_cron ? $this->model_extension_module_ie_pro_tab_crons->get_fields() : $this->_get_fields_tab_cron_jobs(),
                ),
                $this->language->get('tab_migration') => array(
                    'icon' => '<i class="fa fa-database"></i>',
                    'fields' => $this->model_extension_module_ie_pro_tab_migrations->get_fields(),
                ),
            )
        );

        $no_libraries = !is_dir(DIR_SYSTEM.'library/Spout') || !is_dir(DIR_SYSTEM.'library/xml2array') || !is_dir(DIR_SYSTEM.'library/google_spreadsheets');
        $innodb = $this->config->get('import_xls_innodb_converted');

        if($no_libraries)
            $form_view = $this->_add_libraries_remodal($form_view);
        elseif(!$innodb)
            $form_view = $this->_add_innodb_remodal($form_view);
        elseif($this->is_t && $innodb)
            $form_view = $this->_add_trial_remodal($form_view);

        $form_view = $this->model_extension_devmanextensions_tools->_get_form_values($form_view);

        return $form_view;
    }

    public function download_file() {
        $filename = $this->request->get['filename'];
        $filePath = $this->path_tmp_public.$filename;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        $output = file_get_contents($filePath);
        header('Content-type: text/'.$ext);
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        echo $output;
        exit();
    }

    public function _get_fields_tab_custom_fields() {
        $fields = array(
            array(
                'type' => 'html_hard',
                'html_code' => '<p style="font-size:18px; font-weight: bold;"><i class="fa fa-spinner fa-pulse"></i>Working in Custom fields, will be ready soon as possible.<br>This will be AN OPTIONAL COMPONENT that will have to be purchased to add to Import/Export PRO.</p>'
            )
        );
        return $fields;
    }

    public function _get_fields_tab_cron_jobs() {
        $cron_purchase_message = $this->model_extension_devmanextensions_tools->curl_call(array('lang' => $this->is_ocstore ? 'rus' : 'eng'), $this->api_url.'opencart_export_import_pro/cron_get_purchase_message');

        $fields = array(
            array(
                'type' => 'html_hard',
                'html_code' => $cron_purchase_message
            )
        );
        return $fields;
    }

    public function ajax_get_form($license_id = '') {
        $this->model_extension_devmanextensions_tools->ajax_get_form($license_id);
    }
}
