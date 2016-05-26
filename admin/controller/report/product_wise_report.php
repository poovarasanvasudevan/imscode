<?php
class ControllerReportProductWiseReport extends Controller {
	public function index() {     
		$this->load->language('report/product_wise_report');

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
			'href'      => $this->url->link('report/product_wise_report', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->load->model('report/product_wise_report');
		
		$this->data['customers'] = array();
		
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
		
		$order_total1 = $this->model_report_product_wise_report->getTotalOrders($data);
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
			
		$results = $this->model_report_product_wise_report->getOrders($data, $isExport);
		
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
					'pdtname'           	=> $result['pdtname'],
					//'category'          	=> $result['prod_category'],
					'pdtcode'           	=> $result['pdtcode'],
					'quantity'          	=> $result['opquantity'],
					'price'          		=> $result['price'],
					'status'            	=> $result['status'] ,
					'action'            	=> $action
				);
			}		
			 
	 		$this->data['heading_title'] = $this->language->get('heading_title');
			 
			$this->data['text_no_results'] = $this->language->get('text_no_results');
			$this->data['text_all_status'] = $this->language->get('text_all_status');
			
			$this->data['column_pdtcode'] = $this->language->get('column_pdtcode');
			$this->data['column_pdtname'] = $this->language->get('column_pdtname');
			$this->data['column_category'] = $this->language->get('column_category');
			$this->data['column_order_total'] = $this->language->get('column_order_total');
			
			$this->data['column_status'] = $this->language->get('column_status');
			$this->data['column_date'] = $this->language->get('column_date');
			$this->data['column_time'] = $this->language->get('column_time');
			$this->data['column_orders'] = $this->language->get('column_orders');
			$this->data['column_products'] = $this->language->get('column_products');
			$this->data['column_total'] = $this->language->get('column_total');
			
			$this->data['column_quantity'] = $this->language->get('column_quantity');
			$this->data['column_action'] = $this->language->get('column_action');
			
			$this->data['entry_date_start'] = $this->language->get('entry_date_start');
			$this->data['entry_date_end'] = $this->language->get('entry_date_end');
			$this->data['entry_status'] = $this->language->get('entry_status');
	
			$this->data['button_filter'] = $this->language->get('button_filter');
			$this->data['button_csv'] = $this->language->get('button_csv');
			$this->data['button_export'] = $this->language->get('button_export');
			
			$this->data['excelexport'] = $this->url->link('report/product_wise_report/excelreport', 'token=' . $this->session->data['token'] . $url, 'SSL');
			
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
			$pagination->url = $this->url->link('report/product_wise_report', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
				
			$this->data['pagination'] = $pagination->render();
			
			$this->data['filter_date_start'] = $filter_date_start;
			$this->data['filter_date_end'] = $filter_date_end;		
			$this->data['filter_order_status_id'] = $filter_order_status_id;
					 
			$this->template = 'report/product_wise_report.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);
					
			$this->response->setOutput($this->render());
		
		} else if($option =='export') {
	
			$csv_output ="<table border=1> ";
			$csv_output .="<tr style='background-color:yellow;'>";
			
			$csv_output .="<th>".$this->language->get('column_pdtname')."</th> ";
//			$csv_output .="<th>".$this->language->get('column_category')."</td>";
			$csv_output .="<th>".$this->language->get('column_pdtcode')."</td>";		
			$csv_output .="<th>".$this->language->get('column_quantity')."</td>";
			$csv_output .="<th>".$this->language->get('column_total')."</td>";
			$csv_output .="<th>".$this->language->get('column_status')."</td>";			
			
			$csv_output .="</tr> ";
			
			foreach ($results as $result) {
				$csv_output .="<tr> ";
				
				$csv_output .= '<td>' .$result['pdtname']."</td>";
//				$csv_output .= '<td>' .$result['prod_category']."</td>";
				$csv_output .= '<td>' .$result['pdtcode']."</td>";
				$csv_output .= '<td>' .$result['opquantity']."</td>";
				$csv_output .= '<td>' .$result['price']."</td>";
				$csv_output .= '<td>' .$result['status']."</td>";
				
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
		$filename = "product_wise_report".date("d-m-Y",time()).".xlsx";
		
		$objPHPExcel = new PHPExcel();
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename = ' . $filename);
		header('Cache-Control: max-age=0');
		
		$objPHPExcel->getProperties()->setCreator("SHPT")
			->setLastModifiedBy("SHPT")
			->setTitle("SHPT Reports")
			->setSubject("SHPT Product Wise Report")
			->setDescription("SHPT Product Wise Report.")
			->setKeywords("shpt reports")
			->setCategory("Reports");
		
		//Set report title
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$cCell = 'B1';
		//Set row color
		$color = array('rgb'=>'FF9933');
		$this->cellBackColor($objPHPExcel, $cCell, $color);
		////set row height to 25
		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->mergeCells('B1:D1');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Customer Wise Order Report');
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
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
		foreach ($results as $result) {
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $result['pdtname']);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $result['prod_category']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $result['pdtcode']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $result['opquantity']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $result['price']);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $result['status']);
			
			$i++;
		}
		
		//autosize
		for($col = 'A'; $col !== 'G'; $col++ ){
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		//$this->autoFitColumnWidthToContent($objPHPExcel);
		
		//set border
		$this->SetBorder($objPHPExcel, $j-1, $i-1);
		
		//Set Title for the sheet
		$objPHPExcel->getActiveSheet()->setTitle('Customer Wise Order Report');
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}
	
	Private function CreateHeader($objPHPExcel){
		$objPHPExcel->getActiveSheet()->getStyle("A5:AL5")->getFont()->setBold(true);
		$i = 5;
	
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $this->language->get('column_pdtname'));
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $this->language->get('column_category'));		
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $this->language->get('column_pdtcode'));		
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $this->language->get('column_quantity'));
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $this->language->get('column_total'));
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $this->language->get('column_status'));

		
		//set row background color
		$color = array('rgb'=>'002164');
		$cCell = 'A'.$i.':F'.$i;
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
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$j.':F'.$i)->applyFromArray($BStyle);
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