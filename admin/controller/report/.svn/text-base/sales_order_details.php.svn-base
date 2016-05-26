<?php
class ControllerReportSalesOrderDetails extends Controller { 
	public function index() {  
		$this->load->language('report/sales_order_details');

		$this->document->setTitle($this->language->get('heading_title'));

	
		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}	
		
	
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
						

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
							
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/sales_order_details', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->load->model('report/sale');
		
		$this->data['orders'] = array();
		
		$data = array(
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
		
		
		$results = $this->model_report_sale->getOrderDetails($data);
		
		
		// Add 
		if (isset($this->request->get['option'])) {
			$option = $this->request->get['option'] ;
		}else{
			$option = 'filter' ;
		}
		
		if ($option =='filter'){
		foreach ($results as $result) {
			$this->data['orders'][] = array(
				'order_id'     => $result['order_id'],
				'customer_name'     => $result['customer_name'],
				'shipping_city'     => $result['shipping_city'],
				'order_status'     => $result['order_status'],
				'date_added'     => $result['date_added'],
				'product_code'     => $result['product_code'],
				'product'   => $result['product'],
				'quantity'   => $result['quantity'],
				'price'        => $this->currency->format($result['price'], $this->config->get('config_currency')),
				'total'      => $this->currency->format($result['total'], $this->config->get('config_currency'))
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');
		
		$this->data['column_order_id'] = $this->language->get('column_order_id');
		$this->data['column_customer_name'] = $this->language->get('column_customer_name');
		$this->data['column_shipping_city'] = $this->language->get('column_shipping_city');
		$this->data['column_order_status'] = $this->language->get('column_order_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_product_code'] = $this->language->get('column_product_code');
		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_total'] = $this->language->get('column_total');

		
		$this->data['entry_status'] = $this->language->get('entry_status');
		
		// Add
		$this->data['button_csv'] = $this->language->get('button_csv');
		// End

		$this->data['button_filter'] = $this->language->get('button_filter');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$url = '';
						
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
			
		$pagination = new Pagination();
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/sales_order_details', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_order_status_id'] = $filter_order_status_id;
				 
		$this->template = 'report/sales_order_details.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render());
		
	}
	
	// Starts Here 
		else{
		
		//	print_r($results);
			
			$csv_output ="<table border=1> ";
			$csv_output .="<tr style='background-color:yellow;'>";
			$csv_output .="<th>".$this->language->get('column_order_id')."</th> ";
			$csv_output .="<th>".$this->language->get('column_customer_name')."</th> ";
			$csv_output .="<th>".$this->language->get('column_shipping_city')."</th> ";
			$csv_output .="<th>".$this->language->get('column_order_status')."</th> ";
			$csv_output .="<th>".$this->language->get('column_date_added')."</th> ";
			$csv_output .="<th>".$this->language->get('column_product_code')."</th> ";
			$csv_output .="<th>".$this->language->get('column_product')."</th> ";
			$csv_output .="<th>".$this->language->get('column_quantity')."</th> ";
			$csv_output .="<th>".$this->language->get('column_price')."</th> ";
			$csv_output .="<th>".$this->language->get('column_total')."</th> ";
			$csv_output .="</tr> ";

			foreach ($results as $result) {
				$total      = $this->currency->format($result['total'], $this->config->get('config_currency')) ;

			
				$csv_output .="<tr> ";
				$csv_output .= '<td>' .$result['order_id']."</td>";
				$csv_output .= '<td>' .$result['customer_name']."</td>";
				$csv_output .= '<td>' .$result['shipping_city']."</td>";
				$csv_output .= '<td>' .$result['order_status']."</td>";
				$csv_output .= '<td>' .$result['date_added']."</td>";
				$csv_output .= '<td>' .$result['product_code']."</td>";
				$csv_output .= '<td>' .$result['product']."</td>";
				$csv_output .= '<td>' .$result['quantity']."</td>";
				$csv_output .= '<td>' .$result['price']."</td>";
				$csv_output .= '<td>' .$result['total']."</td>";
				$csv_output .= '<td>' .$total."</td>";
				$csv_output .="</tr> ";
			}
			$csv_output .="</table> ";

			$filename = "SHPT_Sales_Order_Details_Report".date("d-m-Y",time());
			header("Content-type: application/vnd.ms-excel");
			header("Content-disposition: xls" . date("Y-m-d") . ".xls");
			header( "Content-disposition: filename=".$filename.".xls");
			print $csv_output;
			
	}
	} // Ends Here
}
?>