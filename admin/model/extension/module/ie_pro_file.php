<?php
    class ModelExtensionModuleIeProFile extends ModelExtensionModuleIePro {
        public function __construct($registry){
            parent::__construct($registry);
            $loader = new Loader($registry);
            $loader->language($this->real_extension_type.'/'.'ie_pro_file');
            if($this->profile) {
                $this->file_destiny = array_key_exists('import_xls_file_destiny', $this->profile) ? $this->profile['import_xls_file_destiny'] : '';
                $this->file_type = array_key_exists('import_xls_file_format', $this->profile) ? $this->profile['import_xls_file_format'] : '';
            }
        }

        public function get_filename() {
            $filename = 'NO DEFINED';
            if($this->profile)
                $filename = ucfirst($this->profile['profile_type']).'-'.ucfirst($this->profile['import_xls_i_want']).'-'.date('Y-m-d-His').'.'.$this->profile['import_xls_file_format'];
            elseif($this->force_filename)
                $filename = $this->force_filename.'-'.date('Y-m-d-His').'.'.$this->file_type;

            return $filename;
        }

        /*
         * Called from model ie_pro_export.php
         * */
        function download_file_export() {
            if($this->profile['import_xls_file_format'] == 'spreadsheet') {
                $data = array(
                    'status' => 'progress_export_finished',
                    'message' => sprintf($this->language->get('google_spreadsheet_export_finished'), $this->filename)
                );
                $this->update_process($data);
            } else {
                if ($this->file_destiny == 'download') {
                    $this->update_process($this->language->get('progress_export_preparing_to_download'));

                    $downloadPath = $this->file_type == 'xml' ? $this->get_force_download_link() : $this->get_download_link();

                    $data = array(
                        'status' => 'progress_export_finished',
                        'redirect' => $downloadPath,
                        'message' => $this->language->get('progress_export_finished')
                    );
                    $this->update_process($data);

                } elseif ($this->file_destiny == 'server') {
                    $this->update_process($this->language->get('progress_export_copying_file_to_destiny'));
                    $new_path = rtrim($this->profile['import_xls_file_destiny_server_path'], '/') . '/';

                    if (empty($new_path)) $this->exception($this->language->get('progress_export_empty_internal_server_path'));
                    if (!file_exists($new_path)) mkdir($new_path, 0775, true);

                    $filename = $this->_get_filename_with_sufix();
                    $final_path = $new_path . $filename;

                    copy($this->filename_path, $final_path);

                    $data = array(
                        'status' => 'progress_export_finished',
                        'message' => sprintf($this->language->get('progress_export_file_copied'), $final_path)
                    );
                    $this->update_process($data);
                } elseif ($this->file_destiny == 'external_server') {
                    $new_path = rtrim($this->profile['import_xls_ftp_path'], '/') . '/';
                    $filename = $this->profile['import_xls_ftp_file'] . '.' . $this->file_type;

                    if (empty($this->profile['import_xls_ftp_file'])) $this->exception($this->language->get('progress_export_ftp_empty_filename'));

                    $final_path = $new_path . $filename;

                    $connection = $this->ftp_open_connection();

                    try {
                        ftp_chdir($connection, $new_path);
                    } catch (Exception $e) {
                        ftp_mkdir($connection, $new_path);
                    }

                    $upload = ftp_put($connection, $final_path, $this->filename_path, FTP_BINARY);

                    if (!$upload)
                        $this->exception(sprintf($this->language->get('progress_export_ftp_error_uploaded'), $final_path));

                    ftp_close($connection);

                    $data = array(
                        'status' => 'progress_export_finished',
                        'message' => sprintf($this->language->get('progress_export_ftp_file_uploaded'), $final_path)
                    );
                    $this->update_process($data);
                }
            }
        }

        /*
         * Called from model ie_pro_import.php
         * */
        function upload_file_import() {
            $this->file_format = $this->profile == '' ? $this->file_format : $this->profile['import_xls_file_format'];
            $this->origin = $this->profile == '' ? 'manual' : $this->profile['import_xls_file_origin'];

            if($this->origin == 'manual') {
                $file_tmp_name = array_key_exists('file', $_FILES) && array_key_exists('tmp_name', $_FILES['file']) ? $_FILES['file']['tmp_name'] : '';
                $file_name = array_key_exists('file', $_FILES) && array_key_exists('name', $_FILES['file']) ? $_FILES['file']['name'] : '';
                if(empty($file_name) || empty($file_name))
                    $this->exception($this->language->get('progress_import_error_empty_file'));

                $this->check_extension_profile($file_name);

                copy($file_tmp_name, $this->file_tmp_path);
            } elseif($this->origin == 'ftp') {
                $ftp_path = rtrim($this->profile['import_xls_ftp_path'], '/') . '/';
                $filename = $this->profile['import_xls_ftp_file'] . '.' . $this->file_type;
                if (empty($this->profile['import_xls_ftp_file'])) $this->exception($this->language->get('progress_export_ftp_empty_filename'));
                $final_path = $ftp_path . $filename;

                $connection = $this->ftp_open_connection();

                ftp_get($connection, $this->file_tmp_path, $final_path, FTP_BINARY);
                ftp_close($connection);
            } else {
                $file_url = !empty($this->profile['import_xls_url']) ? $this->profile['import_xls_url'] : $this->exception($this->language->get('progress_import_error_file_url_empty'));
                $this->check_extension_profile($file_url);
                file_put_contents($this->file_tmp_path, fopen($file_url, 'r'));
            }
        }

        function check_extension_profile($file_name) {
            $extension_file =  strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if($extension_file != $this->file_format)
                $this->exception(sprintf($this->language->get('progress_import_error_extension'), $this->file_format, $extension_file));

        }

        function ftp_open_connection() {
            $server = $this->profile['import_xls_ftp_host'];
            $username = $this->profile['import_xls_ftp_username'];
            $password = $this->profile['import_xls_ftp_password'];
            $port = $this->profile['import_xls_ftp_port'] ? $this->profile['import_xls_ftp_port'] : 21;

            $connection = ftp_connect($server, $port);
            if (!$connection)
                $this->exception($this->language->get('progress_export_ftp_error_connection'));
            $login = ftp_login($connection, $username, $password);
            if (!$login)
                $this->exception($this->language->get('progress_export_ftp_error_login'));

            return $connection;
        }

        function _get_filename_with_sufix() {
            $sufix = '';
            if(!empty($this->profile['import_xls_file_destiny_server_file_name_sufix'])) {
                $sufix_type = $this->profile['import_xls_file_destiny_server_file_name_sufix'];
                $sufix = '-'.($sufix_type == 'date' ? date('Y-m-d') : date('Y-m-d-His'));
            }
            $filename = $this->profile['import_xls_file_destiny_server_file_name'].$sufix.'.'.$this->file_type;
            return $filename;
        }

        function get_download_link() {
            $download_link = $this->path_tmp_public.$this->filename;
            return $download_link;
        }

        function get_force_download_link() {
            $download_link = html_entity_decode($this->url->link($this->real_extension_type.'/import_xls/download_file', $this->token_name.'=' . $this->session->data[$this->token_name].'&filename='.$this->filename, 'SSL'));
            return $download_link;
        }
    }
?>