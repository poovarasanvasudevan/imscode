<?php  
class ControllerModulePricefilter extends Controller {
	protected function index($setting) {
		$this->language->load('module/pricefilter');
		$pricefilterpriceto=0;
		$pricefilterpricefrom=0;
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$this->data['pricefilter_id'] = $parts[0];
		} else {
			$this->data['pricefilter_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}
							
		$this->load->model('catalog/pricefilter');
		$this->load->model('catalog/product');

		$this->data['pricefilters'] = array();
					
		$pricefilters = $this->model_catalog_pricefilter->getpricefilters(0);
		foreach($pricefilters as $pricefilter)
		{
			$this->data['pricefilters'][] = array(
				'name'        => $pricefilter['name'] ,
				'href'        => $this->url->link('product/pricefilter')
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/pricefilter.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/pricefilter.tpl';
		} else {
			$this->template = 'default/template/module/pricefilter.tpl';
		}
		
		$this->render();
  	}
}
?>