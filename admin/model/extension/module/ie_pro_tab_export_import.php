<?php
    class ModelExtensionModuleIeProTabExportImport extends ModelExtensionModuleIePro
    {
        public function __construct($registry) {
            parent::__construct($registry);

            $this->load->language($this->real_extension_type.'/ie_pro_tab_export_import');
        }

        public function get_fields() {
            $this->document->addStyle($this->api_url.'/opencart_admin/ext_ie_pro/css/tab_export_import.css?'.date('Ymdhis'));
            $this->document->addScript($this->api_url.'/opencart_admin/ext_ie_pro/js/tab_export_import.js?'.date('Ymdhis'));

            $fields = array(
                array(
                    'type' => 'legend',
                    'text' => '<i class="fa fa-user"></i>'.$this->language->get('export_import_profile_legend_text'),
                    'remove_border_button' => true,
                ),
                array(
                    'label' => $this->language->get('export_import_profile_load_select'),
                    'type' => 'select',
                    'options' => $this->profiles_select,
                    'name' => 'profiles',
                    'onchange' => 'check_profile_selected()',
                    'after' => '<div style="clear: both; height: 4px;"></div><a href="javascript:{}" onclick="launch_profile(true)">'.$this->language->get('export_import_download_empy_file').'</a>'
                ),
                array(
                    'type' => 'text',
                    'class' => 'input_profile_export',
                    'name' => 'from',
                    'label' => $this->language->get('export_import_profile_input_from'),
                    'help' =>$this->language->get('export_import_profile_input_from_help'),
                ),
                array(
                    'type' => 'text',
                    'class' => 'input_profile_export',
                    'name' => 'to',
                    'label' => $this->language->get('export_import_profile_input_to'),
                    'help' =>$this->language->get('export_import_profile_input_to_help'),
                ),
                array(
                    'type' => 'button',
                    'class' => 'input_profile_import',
                    'label' => $this->language->get('export_import_profile_upload_file'),
                    'text' => '<i class="fa fa-upload"></i> '.$this->language->get('export_import_profile_upload_file').'<span></span>',
                    'onclick' => "$(this).next('input').click();",
                    'help' =>$this->language->get('export_import_profile_upload_file_help'),
                    'after' => '<input onchange="readURL($(this));" name="upload" type="file" style="display:none;">'
                ),
                array(
                    'type' => 'button',
                    'label' => $this->language->get('export_import_start_button'),
                    'text' => '<i class="fa fa-rocket"></i> '.$this->language->get('export_import_start_button'),
                    'onclick' => 'launch_profile();',
                    'class_container' => 'launch_profile',
                    'after' => (!$this->isdemo ? '<br>'.$this->get_remodal('export_import_remodal_server_config', $this->language->get('export_import_remodal_server_config_title'), $this->language->get('export_import_remodal_server_config_description'), array('link' => '<b style="color:#f00;">'.$this->language->get('export_import_remodal_server_config_link').'</b>',  'button_cancel' => false, 'remodal_options' => 'hashTracking: false')) : '').$this->get_remodal('export_import_remodal_process', $this->language->get('export_import_remodal_process_title'), '', array('subtitle' => $this->language->get('export_import_remodal_process_subtitle'), 'button_close' => false, 'button_cancel' => false,  'remodal_options' => 'closeOnOutsideClick: false, closeOnEscape: false, hashTracking: false, closeOnCancel: false'))
                ),
            );

            if($this->is_t) {
                $legend = array(
                    'type' => 'html_hard',
                    'html_code' => '<div class="alert alert-danger" style="margin-bottom: 0px;"><i class="fa fa-exclamation-circle"></i>'.sprintf($this->language->get('trial_operation_restricted'),$this->is_t_elem).'<button type="button" class="close" data-dismiss="alert">×</button></div>'
                );
                array_unshift($fields, $legend);
            }
            return $fields;
        }

        public function _send_custom_variables_to_view($variables) {
            $variables['launch_profile_url'] = htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=launch_profile', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'));
            $variables['clean_progress_url'] = htmlspecialchars_decode($this->url->link($this->real_extension_type.'/'.$this->extension_name.'&ajax_function=clean_previous_process', $this->token_name.'=' . $this->session->data[$this->token_name], 'SSL'));
            $variables['progress_route'] = htmlspecialchars_decode($this->path_progress_public);
            return $variables;
        }

        public function _check_ajax_function($function_name) {
            if($function_name == 'launch_profile') {
                $this->launch_profile();
            }else if($function_name == 'clean_previous_process') {
                $this->create_progress_file();
                $this->ajax_die('Process created');
            }
        }

        public function launch_profile() {
            set_error_handler(array(&$this, 'customCatchError'));
            register_shutdown_function(array(&$this, 'fatalErrorShutdownHandler'));
            try {
                $profile_id = array_key_exists('profile_id', $this->request->post) && !empty($this->request->post['profile_id']) ? $this->request->post['profile_id'] : '';

                if(empty($profile_id))
                    $this->_exception($this->language->get('export_import_error_empty_profile'));

                $profile = $this->{$this->model_profile}->load($profile_id, true);
                if(empty($profile))
                    $this->_exception($this->language->get('export_import_error_profile_not_found'));

                $this->profile = $profile;

                $empty_profile = array_key_exists('empty', $this->request->post) && $this->request->post['empty'] == 'true';

                if($empty_profile) {
                    $this->load->model('extension/module/ie_pro_export');
                    $profile['profile']['import_xls_file_destiny'] = 'download';
                    $profile['type'] = $profile['profile']['profile_type'] = 'export';
                    $this->profile = $profile;
                    $this->request->post['from'] = 1;
                    $this->request->post['to'] = 2;
                    $this->load->model('extension/module/ie_pro_export');
                    $this->update_process($this->language->get('progress_export_starting_process'));
                    $this->model_extension_module_ie_pro_export->export($this->profile);
                } else {
                    if ($this->is_cron_task) {
                        $this->load->model('extension/module/ie_pro_tab_crons');
                        $this->create_progress_file();
                        $this->model_extension_module_ie_pro_tab_crons->check_profile($this->profile);
                    }
                    if ($this->profile['type'] == 'export') {
                        $this->load->model('extension/module/ie_pro_export');
                        $this->update_process($this->language->get('progress_export_starting_process'));
                        $this->model_extension_module_ie_pro_export->export($this->profile);
                    } else {
                        $this->db->query("START TRANSACTION");
                        $this->load->model('extension/module/ie_pro_import');
                        $this->update_process($this->language->get('progress_import_starting_process'));
                        $this->model_extension_module_ie_pro_import->import($this->profile);
                    }
                }
            } catch (Exception $e) {
                if(isset($profile) && $profile == 'import')
                    $this->db->query("ROLLBACK");

                $data = array(
                    'status' => 'error',
                    'message' => $e->getMessage(),
                );

                $this->update_process($data);
            }
            restore_error_handler();
        }
    }
?>