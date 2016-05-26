<?php
class ControllerPaymentFssNet extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/FssNet');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('FssNet', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['entry_MID'] = $this->language->get('entry_MID');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_action_code'] = $this->language->get('entry_action_code');
		$this->data['entry_tran_lang'] = $this->language->get('entry_tran_lang');
		$this->data['entry_currency_code'] = $this->language->get('entry_currency_code');
		$this->data['entry_debuglog'] = $this->language->get('entry_debuglog');
		$this->data['entry_success_status'] = $this->language->get('entry_success_status');
        $this->data['entry_pending_status'] = $this->language->get('entry_pending_status');
        $this->data['entry_failed_status'] = $this->language->get('entry_failed_status');
		$this->data['entry_RedirectURL'] = $this->language->get('entry_RedirectURL');
		$this->data['entry_ErrorURL'] = $this->language->get('entry_ErrorURL');
		//$this->data['entry_SecurePgURL'] = $this->language->get('entry_SecurePgURL');
		//$this->data['entry_Wkey'] = $this->language->get('entry_Wkey');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['MID'])) {
			$this->data['error_MID'] = $this->error['MID'];
		} else {
			$this->data['error_MID'] = '';
		}
        
		if (isset($this->error['Password'])) {
			$this->data['error_password'] = $this->error['error_password'];
		} else {
			$this->data['error_password'] = '';
		}
		
		if (isset($this->request->post['FssNet_test'])) {
			$this->data['FssNet_test'] = $this->request->post['FssNet_test'];
		} else {
			$this->data['FssNet_test'] = $this->config->get('FssNet_test');
		}
		
        if (isset($this->error['RedirectURL'])) {
			$this->data['error_RedirectURL'] = $this->error['RedirectURL'];
		} else {
			$this->data['error_RedirectURL'] = '';
		}

		if (isset($this->error['ErrorURL'])) {
			$this->data['error_ErrorURL'] = $this->error['ErrorURL'];
		} else {
			$this->data['error_ErrorURL'] = '';
		}
		
		/*if (isset($this->error['SecurePgURL'])) {
			$this->data['error_SecurePgURL'] = $this->error['SecurePgURL'];
		} else {
			$this->data['error_SecurePgURL'] = '';
		}*/
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],      		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'],
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => HTTPS_SERVER . 'index.php?route=payment/FssNet&token=' . $this->session->data['token'],
      		'separator' => ' :: '
   		);

		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/FssNet&token=' . $this->session->data['token'];

		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];

		if (isset($this->request->post['FssNet_MID'])) {
			$this->data['FssNet_MID'] = $this->request->post['FssNet_MID'];
		} else {
			$this->data['FssNet_MID'] = $this->config->get('FssNet_MID');
		}

		if (isset($this->request->post['FssNet_Password'])) {
			$this->data['FssNet_Password'] = $this->request->post['FssNet_Password'];
		} else {
			$this->data['FssNet_Password'] = $this->config->get('FssNet_Password');
		}
				
		if (isset($this->request->post['FssNet_RedirectURL'])) {
			$this->data['FssNet_RedirectURL'] = $this->request->post['FssNet_RedirectURL'];
		} else {
			$this->data['FssNet_RedirectURL'] = $this->config->get('FssNet_RedirectURL');
		}
        
        //$this->data['FssNet_ErrorURL'] = HTTP_CATALOG . 'index.php?route=payment/FssNet/callback';
        
        if (isset($this->request->post['FssNet_ErrorURL'])) {
        	$this->data['FssNet_ErrorURL'] = $this->request->post['FssNet_ErrorURL'];
        } else {
        	$this->data['FssNet_ErrorURL'] = $this->config->get('FssNet_ErrorURL');
        }
        
        /*if (isset($this->request->post['FssNet_SecurePgURL'])) {
        	$this->data['FssNet_SecurePgURL'] = $this->request->post['FssNet_SecurePgURL'];
        } else {
        	$this->data['FssNet_SecurePgURL'] = $this->config->get('FssNet_SecurePgURL');
        }*/
        
        //$this->data['FssNet_ErrorURL'] = HTTP_CATALOG . 'index.php?route=payment/FssNet/callback';
        
        /*if (isset($this->request->post['FssNet_Wkey'])) {
			$this->data['FssNet_Wkey'] = $this->request->post['FssNet_Wkey'];
		} else {
			$this->data['FssNet_Wkey'] = $this->config->get('FssNet_Wkey');
		}*/
        
        //$this->log->write('FssNet_action_code = = ' . $this->config->get('FssNet_action_code'));
        
        if (isset($this->request->post['FssNet_action_code'])) {
        	$this->data['FssNet_action_code'] = $this->request->post['FssNet_action_code'];
        } else {
        	$this->data['FssNet_action_code'] = $this->config->get('FssNet_action_code');
        }
        
        if (isset($this->request->post['FssNet_tran_lang'])) {
        	$this->data['FssNet_tran_lang'] = $this->request->post['FssNet_tran_lang'];
        } else {
        	$this->data['FssNet_tran_lang'] = $this->config->get('FssNet_tran_lang');
        }
        
        if (isset($this->request->post['FssNet_currency_code'])) {
        	$this->data['FssNet_currency_code'] = $this->request->post['FssNet_currency_code'];
        } else {
        	$this->data['FssNet_currency_code'] = $this->config->get('FssNet_currency_code');
        }
        
        if (isset($this->request->post['FssNet_debuglog'])) {
        	$this->data['FssNet_debuglog'] = $this->request->post['FssNet_debuglog'];
        } else {
        	$this->data['FssNet_debuglog'] = $this->config->get('FssNet_debuglog');
        }
        
        if (isset($this->request->post['FssNet_success_status_id'])) {
			$this->data['FssNet_success_status_id'] = $this->request->post['FssNet_success_status_id'];
		} else {
			$this->data['FssNet_success_status_id'] = $this->config->get('FssNet_success_status_id');
		}
        
        if (isset($this->request->post['FssNet_pending_status_id'])) {
			$this->data['FssNet_pending_status_id'] = $this->request->post['FssNet_pending_status_id'];
		} else {
			$this->data['FssNet_pending_status_id'] = $this->config->get('FssNet_pending_status_id');
		}
        
        if (isset($this->request->post['FssNet_failed_status_id'])) {
			$this->data['FssNet_failed_status_id'] = $this->request->post['FssNet_failed_status_id'];
		} else {
			$this->data['FssNet_failed_status_id'] = $this->config->get('FssNet_failed_status_id');
		}
        
		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['FssNet_geo_zone_id'])) {
			$this->data['FssNet_geo_zone_id'] = $this->request->post['FssNet_geo_zone_id'];
		} else {
			$this->data['FssNet_geo_zone_id'] = $this->config->get('FssNet_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['FssNet_status'])) {
			$this->data['FssNet_status'] = $this->request->post['FssNet_status'];
		} else {
			$this->data['FssNet_status'] = $this->config->get('FssNet_status');
		}
		
		if (isset($this->request->post['FssNet_sort_order'])) {
			$this->data['FssNet_sort_order'] = $this->request->post['FssNet_sort_order'];
		} else {
			$this->data['FssNet_sort_order'] = $this->config->get('FssNet_sort_order');
		}

		$this->template = 'payment/FssNet.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
        
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
        //$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/FssNet')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['FssNet_MID']) {
			$this->error['MID'] = $this->language->get('error_MID');
		}
        
		if (!$this->request->post['FssNet_Password']) {
			$this->error['Password'] = $this->language->get('error_password');
		}
		
        if (!$this->request->post['FssNet_RedirectURL']) {
			$this->error['RedirectURL'] = $this->language->get('error_RedirectURL');
		}

		if (!$this->request->post['FssNet_ErrorURL']) {
			$this->error['ErrorURL'] = $this->language->get('error_ErroURL');
		}
		
		/*if (!$this->request->post['FssNet_SecurePgURL']) {
			$this->error['SecurePgURL'] = $this->language->get('error_SecurePgURL');
		}*/
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>