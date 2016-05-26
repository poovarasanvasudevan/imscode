<?php
class ModelReportCustomerWiseReport extends Model {
	public function getOrders($data = array(), $isExport) { 
	
		$sql   = "SELECT 
					o.order_id AS orderid, 
					SUBSTRING_INDEX(email, '@', 1) AS username, 
					CONCAT(o.shipping_firstname, ' ', o.shipping_lastname) AS shipping_customer, 
					o.shipping_firstname AS shipping_firstname, 
					o.payment_lastname AS shipping_lastname, 
					CONCAT(o.shipping_address_1, ', ', o.shipping_address_2, ', ', shipping_city) AS shipping_full_address, 
					o.shipping_address_1 AS shipping_address1, 
					o.shipping_address_2 AS shipping_address2, 
					o.shipping_city AS shipping_city, 
					o.shipping_postcode AS shipping_zipcode, 
					o.shipping_zone As shipping_state, 
					o.shipping_country AS shipping_country, 
					o.shipping_country AS country,
					op.product_id AS pdtcode,
					opt.value AS options,
					opt.order_product_id AS ordprdid,
					op.order_product_id AS optprdid, 
					op.quantity AS opquantity,
					pd.name AS pdtname,
					FORMAT(op.price,2) AS price,
					o.date_added AS order_date,
					(SELECT os.name FROM order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '1') AS status, 
					FORMAT(o.total, 2) AS invoice_total
					FROM `order` AS o
					LEFT JOIN order_product op ON (o.order_id = op.order_id)
					LEFT JOIN product_description pd ON (pd.product_id = op.product_id) 
					LEFT JOIN order_option opt ON (opt.order_product_id = op.order_product_id)";
			
		if (!is_null($data['filter_order_status_id']) && $data['filter_order_status_id'] <> 0) {
			$sql .= " where o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " where o.order_status_id > '0'";
		}
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
						
		$sql .= " GROUP BY o.customer_id, o.order_id, op.product_id ORDER BY o.customer_id	";
		
		if($isExport == FALSE){
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}			
	
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
				
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
		}
		
		$this->log->write('customer_wise_order_report sql  =  '  . $sql);
			
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getTotalOrders($data = array()) { 
	
		$sql = "SELECT *				
				FROM `order` AS o
				LEFT JOIN order_product op ON (o.order_id = op.order_id)
				LEFT JOIN product_description pd ON (pd.product_id = op.product_id) 
				LEFT JOIN order_option opt ON (opt.order_product_id = op.order_product_id)";
			
		if (!is_null($data['filter_order_status_id']) && $data['filter_order_status_id'] <> 0) {
			$sql .= " where o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " where o.order_status_id > '0'";
		}
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		$sql .= " GROUP BY o.customer_id, o.order_id, op.product_id ORDER BY o.customer_id	";

		//$this->log->write('getTotalOrders sql  =  '  . $sql);
		
		$query = $this->db->query($sql);
	
		return $query->num_rows;
	}
	
	public function getTotalProducts($order_id) {
		$sql = "SELECT COUNT(DISTINCT op.order_product_id) AS total_products FROM order_product AS op WHERE op.order_id = " . (int)$order_id;
	
		$query = $this->db->query($sql);
	
		return $query->row['total_products'];
	}
}
?>