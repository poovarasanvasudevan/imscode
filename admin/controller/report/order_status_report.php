<?php
class ControllerReportOrderStatusReport extends Controller {
	public function index() {     
		$this->load->language('report/order_status_report');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d');
		}
		
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
		
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

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
			'href'      => $this->url->link('report/order_status_report', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->load->model('report/shptreport');
		
		$this->data['customers'] = array();
		
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
		
		$order_total1 = $this->model_report_shptreport->getTotalOrders($data);
		$order_total=0;
		
		// Add 
		if (isset($this->request->get['option'])) {
			$option = $this->request->get['option'] ;
		}else{
			$option = 'filter' ;
		}
		
		$isExport = FALSE;
		if($option == 'excelexport' OR $option == 'export') {
			$isExport = TRUE;
		}
			
		$results = $this->model_report_shptreport->getOrders($data, $isExport);
		
		if ($option =='filter'){
			foreach ($results as $result) {
				$order_total += 1;
				$action = array();
			
				$action[] = array(
					'text' => $this->language->get('text_edit'),
					'href' => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&order_id=' . $result['orderid'] . $url, 'SSL')
				);
				
				// To Include the option value
				$a = explode(',', $result['options']);
				$b = explode(',', $result['ordprdid']);
				$c = explode(',', $result['optprdid']);
				$d = explode(',', $result['opquantity']);
	
				$i=0;
				$optionvalue='';
				if($result['options']<>''){
				foreach ($b as $option) {
					$optionvalue .= $a[$i] . '(' . $d[array_search($b[$i], $c)] . '), ' ;
					$i += 1;
				}
				}
				$optionvalue = trim($optionvalue,', ');			
							
				$this->data['customers'][] = array(
					'order_id'          	=> $result['orderid'],
					'status'            	=> $result['status'] ,
					'order_date'			=> $result['order_date'],
					'order_time'			=> $result['order_time'],
					'username'				=> $result['username'],
					'payment_customer'  	=> $result['payment_customer'],
					'payment_firstname' 	=> $result['payment_firstname'],
					'payment_lastname'  	=> $result['payment_lastname'],
					'payment_full_address'  => $result['payment_full_address'],
					'payment_address_1'  	=> $result['payment_address1'],
					'payment_address_2'  	=> $result['payment_address2'],
					'payment_city'  		=> $result['payment_city'],
					'payment_zipcode'  		=> $result['payment_zipcode'],
					'payment_state'  		=> $result['payment_state'],
					'payment_country'  		=> $result['payment_country'],
					'payment_phone'  		=> $result['payment_phone'],
					'payment_email'  		=> $result['payment_email'],
					'shipping_customer'  	=> $result['shipping_customer'],
					'shipping_firstname' 	=> $result['shipping_firstname'],
					'shipping_lastname'  	=> $result['shipping_lastname'],
					'shipping_full_address' => $result['shipping_full_address'],
					'shipping_address_1'  	=> $result['shipping_address1'],
					'shipping_address_2'  	=> $result['shipping_address2'],
					'shipping_city'  		=> $result['shipping_city'],
					'shipping_zipcode'  	=> $result['shipping_zipcode'],
					'shipping_state'  		=> $result['shipping_state'],
					'shipping_country'  	=> $result['shipping_country'],
	
					'pdtcode'           	=> $result['pdtcode'],
					'pdtname'           	=> $result['pdtname'],
					'quantity'          	=> $result['opquantity'],
					'total'          		=> $result['total'],
					'order_total'          	=> $result['order_total'],
					'category'          	=> $result['prod_category'],
					'shipping_charge'       => $result['shipping_charge'],
					'order_tax'       		=> $result['order_tax'],
					'invoice_total'       	=> $result['invoice_total'],
					'invoice_id'	       	=> $result['invoice_id'],

					'payment_id'			=> $result['payment_id'],
					'payment_ref_id'		=> $result['payment_ref_id'],
					'payment_tran_id'		=> $result['payment_tran_id'],
					'action'            	=> $action
				);
			}		
			 
	 		$this->data['heading_title'] = $this->language->get('heading_title');
			 
			$this->data['text_no_results'] = $this->language->get('text_no_results');
			$this->data['text_all_status'] = $this->language->get('text_all_status');
			
			$this->data['column_payment_customer'] = $this->language->get('column_payment_customer');
			$this->data['column_payment_firstname'] = $this->language->get('column_payment_firstname');
			$this->data['column_payment_lastname'] = $this->language->get('column_payment_lastname');
			$this->data['column_payment_full_address'] = $this->language->get('column_payment_full_address');
			$this->data['column_payment_address_1'] = $this->language->get('column_payment_address_1');
			$this->data['column_payment_address_2'] = $this->language->get('column_payment_address_2');
			$this->data['column_payment_city'] = $this->language->get('column_payment_city');
			$this->data['column_payment_zipcode'] = $this->language->get('column_payment_zipcode');
			$this->data['column_payment_state'] = $this->language->get('column_payment_state');
			$this->data['column_payment_country'] = $this->language->get('column_payment_country');
			$this->data['column_payment_phone'] = $this->language->get('column_payment_phone');
			$this->data['column_payment_email'] = $this->language->get('column_payment_email');
			
			$this->data['column_shipping_customer'] = $this->language->get('column_shipping_customer');
			$this->data['column_shipping_firstname'] = $this->language->get('column_shipping_firstname');
			$this->data['column_shipping_lastname'] = $this->language->get('column_shipping_lastname');
			$this->data['column_shipping_full_address'] = $this->language->get('column_shipping_full_address');
			$this->data['column_shipping_address_1'] = $this->language->get('column_shipping_address_1');
			$this->data['column_shipping_address_2'] = $this->language->get('column_shipping_address_2');
			$this->data['column_shipping_city'] = $this->language->get('column_shipping_city');
			$this->data['column_shipping_zipcode'] = $this->language->get('column_shipping_zipcode');
			$this->data['column_shipping_state'] = $this->language->get('column_shipping_state');
			$this->data['column_shipping_country'] = $this->language->get('column_shipping_country');
					
			$this->data['column_pdtcode'] = $this->language->get('column_pdtcode');
			$this->data['column_pdtname'] = $this->language->get('column_pdtname');
			$this->data['column_category'] = $this->language->get('column_category');
			$this->data['column_order_total'] = $this->language->get('column_order_total');
			
			$this->data['column_city'] = $this->language->get('column_city');
			$this->data['column_country'] = $this->language->get('column_country');
			$this->data['column_orderid'] = $this->language->get('column_orderid');
			$this->data['column_email'] = $this->language->get('column_email');
			$this->data['column_phone'] = $this->language->get('column_phone');
			$this->data['column_customer_group'] = $this->language->get('column_customer_group');
			$this->data['column_payment_id'] = $this->language->get('column_payment_id');
			$this->data['column_payment_ref_id'] = $this->language->get('column_payment_ref_id');
			$this->data['column_payment_tran_id'] = $this->language->get('column_payment_tran_id');
			$this->data['column_status'] = $this->language->get('column_status');
			$this->data['column_date'] = $this->language->get('column_date');
			$this->data['column_time'] = $this->language->get('column_time');
			$this->data['column_orders'] = $this->language->get('column_orders');
			$this->data['column_products'] = $this->language->get('column_products');
			$this->data['column_total'] = $this->language->get('column_total');
			
			$this->data['column_shipping_charges'] = $this->language->get('column_shipping_charges');
			$this->data['column_taxes'] = $this->language->get('column_taxes');
			$this->data['column_invoice_total'] = $this->language->get('column_invoice_total');
			$this->data['column_invoice_id'] = $this->language->get('column_invoice_id');

			$this->data['column_quantity'] = $this->language->get('column_quantity');
			$this->data['column_action'] = $this->language->get('column_action');
			
			$this->data['entry_date_start'] = $this->language->get('entry_date_start');
			$this->data['entry_date_end'] = $this->language->get('entry_date_end');
			$this->data['entry_status'] = $this->language->get('entry_status');
	
			$this->data['button_filter'] = $this->language->get('button_filter');
			$this->data['button_csv'] = $this->language->get('button_csv');
			$this->data['button_export'] = $this->language->get('button_export');
			
			$this->data['excelexport'] = $this->url->link('report/order_status_report/excelreport', 'token=' . $this->session->data['token'] . $url, 'SSL');
			
			$this->data['token'] = $this->session->data['token'];
			
			$this->load->model('localisation/order_status');
			
			$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
				
			$url = '';
							
			if (isset($this->request->get['filter_date_start'])) {
				$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
			}
			
			if (isset($this->request->get['filter_date_end'])) {
				$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
			}
	
			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}
					
			$pagination = new Pagination();
			$pagination->total = $order_total1;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_admin_limit');
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('report/order_status_report', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
				
			$this->data['pagination'] = $pagination->render();
			
			$this->data['filter_date_start'] = $filter_date_start;
			$this->data['filter_date_end'] = $filter_date_end;		
			$this->data['filter_order_status_id'] = $filter_order_status_id;
					 
			$this->template = 'report/order_status_report.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);
					
			$this->response->setOutput($this->render());
		
		} else if($option =='export') {
	
			$csv_output ="<table border=1> ";
			$csv_output .="<tr style='background-color:yellow;'>";
			$csv_output .="<th>".$this->language->get('column_orderid')."</th> ";
			$csv_output .="<th>".$this->language->get('column_status')."</th> ";
			$csv_output .="<th>".$this->language->get('column_date')."</th> ";
			$csv_output .="<th>".$this->language->get('column_time')."</th> ";
					
			$csv_output .="<th>".$this->language->get('column_username')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_customer')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_firstname')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_lastname')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_full_address')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_address_1')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_address_2')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_city')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_zipcode')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_state')."</th> ";
			$csv_output .="<th>". $this->language->get('column_payment_country')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_phone')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_email')."</th> ";
			$csv_output .="<th>".$this->language->get('column_shipping_customer')."</th> ";
					
			$csv_output .="<th>".$this->language->get('column_shipping_firstname')."</th> ";
			$csv_output .="<th>".$this->language->get('column_shipping_lastname')."</th> ";
			$csv_output .="<th>".$this->language->get('column_shipping_full_address')."</th> ";
			$csv_output .="<th>".$this->language->get('column_shipping_address_1')."</th> ";
			$csv_output .="<th>".$this->language->get('column_shipping_address_2')."</th> ";
			$csv_output .="<th>".$this->language->get('column_shipping_city')."</th> ";
			$csv_output .="<th>".$this->language->get('column_shipping_zipcode')."</th> ";
			$csv_output .="<th>".$this->language->get('column_shipping_state')."</th> ";
			$csv_output .="<th>".$this->language->get('column_shipping_country')."</th> ";
					
			$csv_output .="<th>".$this->language->get('column_pdtcode')."</th> ";
			$csv_output .="<th>".$this->language->get('column_pdtname')."</th> ";
			$csv_output .="<th>".$this->language->get('column_quantity')."</th> ";
			$csv_output .="<th>".$this->language->get('column_total')."</th> ";
			$csv_output .="<th>".$this->language->get('column_category')."</th> ";
			$csv_output .="<th>".$this->language->get('column_order_total')."</th> ";
			$csv_output .="<th>".$this->language->get('column_payment_tran_id')."</th> ";
			$csv_output .="<th>".$this->language->get('column_shipping_charges')."</th> ";
			$csv_output .="<th>".$this->language->get('column_taxes')."</th> ";
			$csv_output .="<th>".$this->language->get('column_invoice_total')."</th> ";
			
			$csv_output .="</tr> ";
			
			foreach ($results as $result) {
				$csv_output .="<tr> ";
				$csv_output .= '<td>' . $result['orderid']."</td>";
				$csv_output .= '<td>' .$result['status']."</td>";
				$csv_output .= '<td>' .$result['order_date']."</td>";
				$csv_output .= '<td>' .$result['order_time']."</td>";
				$csv_output .= '<td>' .$result['username']."</td>";
				$csv_output .= '<td>' .$result['payment_customer']."</td>";
				$csv_output .= '<td>' .$result['payment_firstname']."</td>";
				$csv_output .= '<td>' .$result['payment_lastname']."</td>";
				$csv_output .= '<td>' .$result['payment_full_address']."</td>";
				$csv_output .= '<td>' .$result['payment_address1']."</td>";
				$csv_output .= '<td>' .$result['payment_address2']."</td>";
				$csv_output .= '<td>' .$result['payment_city']."</td>";
				$csv_output .= '<td>' .$result['payment_zipcode']."</td>";
				$csv_output .= '<td>' .$result['payment_state']."</td>";
				$csv_output .= '<td>' .$result['payment_country']."</td>";
				$csv_output .= '<td>' .$result['payment_phone']."</td>";
				$csv_output .= '<td>' .$result['payment_email']."</td>";
				$csv_output .= '<td>' .$result['shipping_customer']."</td>";
				$csv_output .= '<td>' .$result['shipping_firstname']."</td>";
				$csv_output .= '<td>' .$result['shipping_lastname']."</td>";
				$csv_output .= '<td>' .$result['shipping_full_address']."</td>";
				$csv_output .= '<td>' .$result['shipping_address1']."</td>";
				$csv_output .= '<td>' .$result['shipping_address2']."</td>";
				$csv_output .= '<td>' .$result['shipping_city']."</td>";
				$csv_output .= '<td>' .$result['shipping_zipcode']."</td>";
				$csv_output .= '<td>' .$result['shipping_state']."</td>";
				$csv_output .= '<td>' .$result['shipping_country']."</td>";
							
				$csv_output .= '<td>' .$result['pdtcode']."</td>";
				$csv_output .= '<td>' .$result['pdtname']."</td>";
				$csv_output .= '<td>' .$result['opquantity']."</td>";
				$csv_output .= '<td>' .$result['total']."</td>";
				$csv_output .= '<td>' .$result['prod_category']."</td>";
				$csv_output .= '<td>' .$result['order_total']."</td>";
				$csv_output .= '<td>' .$result['payment_tran_id']."</td>";
				$csv_output .= '<td>' .$result['shipping_charge']."</td>";
				$csv_output .= '<td>' .$result['order_tax']."</td>";
				$csv_output .= '<td>' .$result['invoice_total']."</td>";
				
				$csv_output .="</tr> ";
				
			}
			$csv_output .="</table> ";

			$filename = "SHPT_Sales_Order_List_Report".date("d-m-Y",time());
			header("Content-type: application/vnd.ms-excel");
//			header("Content-disposition: xls" . date("Y-m-d") . ".xls");
			header("Content-disposition: filename=".$filename.".xls");
			print $csv_output;
		} 
		else if($option =='excelexport') {
			$this->excelexport($data, $results);
		}			
	}
	
	public function excelexport($data, $results) {	
		/** Include PHPExcel */
		require_once (DIR_SYSTEM . '/PHPExcel/Classes/PHPExcel.php');
		$filename = "SHPT_Order_Status_Report".date("d-m-Y",time()).".xlsx";
		
		$objPHPExcel = new PHPExcel();
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename = ' . $filename);
		header('Cache-Control: max-age=0');
		
		$objPHPExcel->getProperties()->setCreator("SHPT")
			->setLastModifiedBy("SHPT")
			->setTitle("SHPT Reports")
			->setSubject("SHPT All Sales Report")
			->setDescription("SHPT All Sales Report.")
			->setKeywords("shpt reports")
			->setCategory("Reports");
		
		//Set report title
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$cCell = 'C1';
		//Set row color
		$color = array('rgb'=>'FF9933');
		$this->cellBackColor($objPHPExcel, $cCell, $color);
		////set row height to 25
		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->mergeCells('C1:E1');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'All Order Status Report');
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Date Range From');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'To');
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		
		$time = strtotime($data['filter_date_start']);
		$sdate = date('d-M-Y', $time);
		$objPHPExcel->getActiveSheet()->setCellValue('B2', $sdate);
		$time = strtotime($data['filter_date_end']);
		$edate = date('d-M-Y', $time);
		$objPHPExcel->getActiveSheet()->setCellValue('B3', $edate);
		
		//create header
		$this->CreateHeader($objPHPExcel);		
		//Fill the data now
		$i = 6;
		$j = $i;
		$counter = 0;
		$prevOrderId = '';
		$sameOrderFlag = FALSE;
		$mergeFlag = FALSE;
		$count = count($results);
		$cellStart = 0;
		$cellEnd = 0;
		$prevUser = '';
		$sameCustflag = FALSE;
		$newRowFlag = FALSE;
		$emptyRowNum = 0;
		foreach ($results as $result) {
			$counter++;
			if($sameOrderFlag == FALSE && $prevOrderId == $result['orderid']){
				$sameOrderFlag = TRUE;
				$mergeFlag = FALSE;
				$cellStart = $i - 1;
			}
			if($sameOrderFlag == TRUE && ($prevOrderId != $result['orderid'])){
				$mergeFlag = TRUE;
				$sameOrderFlag = FALSE;
				$cellEnd = $i - 1;
			}
			if($sameOrderFlag == TRUE && $counter == $count){
				$mergeFlag = TRUE;
				$cellEnd = $i;
			}
			//check if same user and club them together
			if(!empty($prevUser) && $prevUser != $result['username']){
				//$sameCustflag = TRUE;
				$newRowFlag = TRUE;
				$emptyRowNum = $i;
			}
			else{
				$newRowFlag = FALSE;
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $result['orderid']);			
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $result['status']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $result['order_date']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $result['order_time']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $result['username']);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $result['payment_customer']);
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $result['payment_firstname']);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $result['payment_lastname']);
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $result['payment_full_address']);
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $result['payment_address1']);
			$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $result['payment_address2']);
			$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $result['payment_city']);
			$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $result['payment_zipcode']);
			$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $result['payment_state']);
			$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $result['payment_country']);
			$objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $result['payment_phone']);
			$objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $result['payment_email']);
			$objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $result['shipping_customer']);
			$objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $result['shipping_firstname']);
			$objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $result['shipping_lastname']);
			$objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $result['shipping_full_address']);
			$objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $result['shipping_address1']);
			$objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $result['shipping_address2']);
			$objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $result['shipping_city']);
			$objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $result['shipping_zipcode']);
			$objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $result['shipping_state']);
			$objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $result['shipping_country']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $result['pdtcode']);
			$objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $result['pdtname']);
			$objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $result['opquantity']);
			$objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, $result['total']);
			$objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $result['prod_category']);
			$objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, $result['order_total']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, $result['payment_tran_id']);
			$objPHPExcel->getActiveSheet()->getStyle('AH' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			$objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, $result['shipping_charge']);
			$objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, $result['order_tax']);
			$objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, $result['invoice_total']);
			$objPHPExcel->getActiveSheet()->getStyle('AK' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			$prevOrderId = $result['orderid'];
			$prevUser = $result['username'];
			
			if($mergeFlag == TRUE){
				//merge order total cells
				$str = 'AG' . $cellStart . ':AG' . $cellEnd;
				$objPHPExcel->getActiveSheet()->mergeCells($str);
				$objPHPExcel->getActiveSheet()->getStyle($str)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				//merge shipping cells
				$str = 'AI' . $cellStart . ':AI' . $cellEnd;
				$objPHPExcel->getActiveSheet()->mergeCells($str);
				$objPHPExcel->getActiveSheet()->getStyle($str)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				//merge total cells
				$str = 'AK' . $cellStart . ':AK' . $cellEnd;
				$objPHPExcel->getActiveSheet()->mergeCells($str);
				$objPHPExcel->getActiveSheet()->getStyle($str)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			}
			if($newRowFlag == TRUE){
				$objPHPExcel->getActiveSheet()->insertNewRowBefore($emptyRowNum, 1);
				$cCell = 'A'.$emptyRowNum.':AK'.$emptyRowNum;
				//Set row color
				$color = array('rgb'=>'CCCCFF');
				$this->cellBackColor($objPHPExcel, $cCell, $color);
				//set row height to 5 mm
				$objPHPExcel->getActiveSheet()->getRowDimension( $emptyRowNum )->setRowHeight(5);
				$i++;
				$newRowFlag = FALSE;
				$emptyRowNum = 0;
			}
			$i++;
		}
		
		//autosize
		/*foreach(range('AA','AC') as $columnID)
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}*/
		for($col = 'B'; $col !== 'AL'; $col++ ){
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		//$this->autoFitColumnWidthToContent($objPHPExcel);
		
		//set border
		$this->SetBorder($objPHPExcel, $j-1, $i-1);
		
		//Set Title for the sheet
		$objPHPExcel->getActiveSheet()->setTitle('All Sales Report');
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}
	
	Private function CreateHeader($objPHPExcel){
		$objPHPExcel->getActiveSheet()->getStyle("A5:AL5")->getFont()->setBold(true);
		$i = 5;
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $this->language->get('column_orderid'));
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $this->language->get('column_status'));
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $this->language->get('column_date'));
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $this->language->get('column_time'));
		
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $this->language->get('column_username'));
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $this->language->get('column_payment_customer'));
		$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $this->language->get('column_payment_firstname'));
		$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $this->language->get('column_payment_lastname'));
		$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $this->language->get('column_payment_full_address'));
		$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $this->language->get('column_payment_address_1'));
		$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $this->language->get('column_payment_address_2'));
		$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $this->language->get('column_payment_city'));
		$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $this->language->get('column_payment_zipcode'));
		$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $this->language->get('column_payment_state'));
		$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $this->language->get('column_payment_country'));
		$objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $this->language->get('column_payment_phone'));
		$objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $this->language->get('column_payment_email'));
		$objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $this->language->get('column_shipping_customer'));
		
		$objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $this->language->get('column_shipping_firstname'));
		$objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $this->language->get('column_shipping_lastname'));
		$objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $this->language->get('column_shipping_full_address'));
		$objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $this->language->get('column_shipping_address_1'));
		$objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $this->language->get('column_shipping_address_2'));
		$objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $this->language->get('column_shipping_city'));
		$objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $this->language->get('column_shipping_zipcode'));
		$objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $this->language->get('column_shipping_state'));
		$objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $this->language->get('column_shipping_country'));
		
		$objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $this->language->get('column_pdtcode'));
		$objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $this->language->get('column_pdtname'));
		$objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $this->language->get('column_quantity'));
		$objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, $this->language->get('column_total'));
		$objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $this->language->get('column_category'));
		$objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, $this->language->get('column_order_total'));
		$objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, $this->language->get('column_payment_tran_id'));
		$objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, $this->language->get('column_shipping_charges'));
		$objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, $this->language->get('column_taxes'));
		$objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, $this->language->get('column_invoice_total'));
		
		//set row background color
		$color = array('rgb'=>'002164');
		$cCell = 'A'.$i.':AK'.$i;
		$this->cellBackColor($objPHPExcel, $cCell, $color);
		//set row height to 20
		$objPHPExcel->getActiveSheet()->getRowDimension( $i )->setRowHeight(20);
		
		//set vertical alighment to center
		$objPHPExcel->getActiveSheet()->getStyle($cCell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	}
	
	Private function SetBorder($objPHPExcel, $j, $i){
		$BStyle = array(
				'borders' => array(
						'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
						)
				)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':AK'.$i)->applyFromArray($BStyle);
		unset($BStyle);
	}
	
	Private function autoFitColumnWidthToContent($objPHPExcel) {
        /*if (empty($toCol) ) {//not defined the last column, set it the max one
            $toCol = $sheet->getColumnDimension($sheet->getHighestColumn())->getColumnIndex();
        }
        
        for($i = $fromCol; $i <= $toCol; $i++) {
            $sheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
            
        }*/
		
		foreach(range('B', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
			$objPHPExcel->getActiveSheet()
			->getColumnDimension($col)
			->setAutoSize(true);
		}
        
        //$sheet->calculateColumnWidths();
    }
    
    Private  function cellBackColor($objPHPExcel, $cells, $color){
    	$headerStyle = array(
    			'fill' => array(
    					'type' => PHPExcel_Style_Fill::FILL_SOLID,
    					'color' => $color,
    			),
    			'font' => array(
    					'bold' => true,
    					'color' => array('rgb'=>'FFFFFF'),
    			)
    	);
    	
    	$objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($headerStyle);
	}
}
?>