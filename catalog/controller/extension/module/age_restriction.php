<?php
class ControllerExtensionModuleAgeRestriction extends Controller {

	public function index($setting = null) {
		$this->load->language('extension/module/age_restriction');

		if ($setting && $setting['status']) {
				$show_modal = false;
				$data = array();
				
				if (isset($this->session->data['module_age_restriction_pass']) && $this->session->data['module_age_restriction_pass'] < $setting['age']) {
					$show_modal = true;
				}

				if (!isset($this->session->data['module_age_restriction_pass'])) {
					$show_modal = true;
				}

				if ($show_modal) {
					$data['message'] = sprintf($setting['message'], $setting['age']);
					$data['age'] = $setting['age'];
					$data['redirect_url'] = $setting['redirect_url'];
					$data['session_redirect'] = $this->url->link('extension/module/age_restriction/startAgeSession');
	
					return $this->load->view('extension/module/age_restriction', $data);
				}
		}
	}

	public function startAgeSession() { //ajax
		$this->session->data['module_age_restriction_pass'] = $this->request->post['age'];

		if (isset ($this->session->data['module_age_restriction_pass'] )) {
			if ($this->request->post['age'] > $this->session->data['module_age_restriction_pass']) {
				$this->session->data['module_age_restriction_pass'] = $this->request->get['age'] ;
			} 
		} else {
			$this->session->data['module_age_restriction_pass'] = $this->request->post['age'];
		}

		$data = array();
		$data['success'] = true;
		$this->response->setOutput($this->load->view('extension/module/age_restriction_session', $data));
	}
	
}