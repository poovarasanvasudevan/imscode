<?php
class ControllerModuleHighPerformanceCategoryLoad extends Controller {
	private $error = array(); 

	public function index() {   
		$this->load->language('module/high_performance_category_load');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_setting_setting->editSetting('high_performance_category_load', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['link'] = $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		}else{
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/high_performance_category_load', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('module/high_performance_category_load', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['high_performance_category_load_status'])) {
			$this->data['high_performance_category_load_status'] = $this->request->post['high_performance_category_load_status'];
		}elseif($this->config->get('high_performance_category_load_status')) {
			$this->data['high_performance_category_load_status'] = $this->config->get('high_performance_category_load_status');
		}else{
			$this->data['high_performance_category_load_status'] = '';
		}

		// chama a view
		$this->template = 'module/high_performance_category_load.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());
	}

    public function install() {
		$query = $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "sql_records` 
									(
										`sql_md5` char(32) NOT NULL,
										`sql_records_number` int(11) NOT NULL,
										`sql_txt` text NOT NULL,
										PRIMARY KEY (`sql_md5`)
									) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");
	}

    public function uninstall() {
		$query = $this->db->query("DROP TABLE `" . DB_PREFIX . "sql_records`");

		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('high_performance_category_load', array('high_performance_category_load_status' => '0'));
    }       
}
?>