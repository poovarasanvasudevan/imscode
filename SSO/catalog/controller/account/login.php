<?php 
class ControllerAccountLogin extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('account/customer');
		
		// Login override for admin users
		if (!empty($this->request->get['token'])) {
			$this->customer->logout();
			$this->cart->clear();

			unset($this->session->data['wishlist']);
			unset($this->session->data['shipping_address_id']);
			unset($this->session->data['shipping_country_id']);
			unset($this->session->data['shipping_zone_id']);
			unset($this->session->data['shipping_postcode']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_address_id']);
			unset($this->session->data['payment_country_id']);
			unset($this->session->data['payment_zone_id']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);

			$customer_info = $this->model_account_customer->getCustomerByToken($this->request->get['token']);

			if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
				// Default Addresses
				$this->load->model('account/address');

				$address_info = $this->model_account_address->getAddress($this->customer->getAddressId());

				if ($address_info) {
					if ($this->config->get('config_tax_customer') == 'shipping') {
						$this->session->data['shipping_country_id'] = $address_info['country_id'];
						$this->session->data['shipping_zone_id'] = $address_info['zone_id'];
						$this->session->data['shipping_postcode'] = $address_info['postcode'];	
					}

					if ($this->config->get('config_tax_customer') == 'payment') {
						$this->session->data['payment_country_id'] = $address_info['country_id'];
						$this->session->data['payment_zone_id'] = $address_info['zone_id'];
					}
				} else {
					unset($this->session->data['shipping_country_id']);	
					unset($this->session->data['shipping_zone_id']);	
					unset($this->session->data['shipping_postcode']);
					unset($this->session->data['payment_country_id']);	
					unset($this->session->data['payment_zone_id']);	
				}

				$this->redirect($this->url->link('account/account', '', 'SSL')); 
			}
		}		

		if ($this->customer->isLogged()) {  
                    $this->redirect($this->url->link('account/account', '', 'SSL'));
		}

		$this->language->load('account/login');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->redirect("http://profile.srcm.net/o/authorize?state=abc&response_type=code&client_id=".MYSRCM_CLIENT_ID."&redirect_uri=".REDIRECT_URI.'index.php');

			
		
	}

	// protected function validate() {
		// if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
			// $this->error['warning'] = $this->language->get('error_login');
		// }

		// $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

		// if ($customer_info && !$customer_info['approved']) {
			// $this->error['warning'] = $this->language->get('error_approved');
		// }

		// if (!$this->error) {
			// return true;
		// } else {
			// return false;
		// }
	// }
	
	public function setcustomerdata(){
		$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
		print_r($customer_info);
		$this->load->model('account/address');
		$cusData=array();
		$cusData["customer_id"]=$customer_info["customer_id"];
		$cusData["firstname"]=$customer_info["firstname"];
		$cusData["lastname"]=$customer_info["lastname"];
		$cusData["email"]=$customer_info["email"];
		$cusData["telephone"]=$customer_info["telephone"];
		$cusData["customer_id"]=$customer_info["customer_id"];
		$address=$this->model_account_address->getAddress($customer_info["address_id"]);
		$cusData["address_1"]=$address["address_1"];
		$cusData["address_2"]=$address["address_2"];
		$cusData["city"]=$address["city"];
		$cusData["country"]=$address["country"];
		$cusData["postcode"]=$address["postcode"];
		$this->response->setApidata($cusData);
	}
}
?>