<?php
class ModelReportShptReport extends Model {
	public function getOrders($data = array(), $isExport) { 
	
		$sql   = "SELECT ptc.category_id AS cat_id,
					o.order_id AS orderid, DATE(o.date_added) AS order_date, 
					TIME(o.date_added) AS order_time,
					SUBSTRING_INDEX(email, '@', 1) AS username, 
					CONCAT(o.payment_firstname, ' ', o.payment_lastname) AS payment_customer, 
					o.payment_firstname AS payment_firstname, 
					o.payment_lastname AS payment_lastname, 
					CONCAT(o.payment_address_1, ', ', o.payment_address_2, ', ', payment_city) AS payment_full_address, 
					o.payment_address_1 AS payment_address1, 
					o.payment_address_2 AS payment_address2, 
					o.payment_city AS payment_city, 
					o.payment_postcode AS payment_zipcode, 
					o.payment_zone As payment_state, 
					o.payment_country AS payment_country, 
					o.telephone AS payment_phone, 
					o.email AS payment_email, 
					CONCAT(o.shipping_firstname, ' ', o.shipping_lastname) AS shipping_customer, 
					o.shipping_firstname AS shipping_firstname, 
					o.payment_lastname AS shipping_lastname, 
					CONCAT(o.shipping_address_1, ', ', o.shipping_address_2, ', ', shipping_city) AS shipping_full_address, 
					o.shipping_address_1 AS shipping_address1, 
					o.shipping_address_2 AS shipping_address2, 
					o.shipping_postcode AS shipping_zipcode, 
					o.shipping_zone As shipping_state, 
					o.shipping_country AS shipping_country, 
					o.shipping_city AS shipping_city, 
					o.shipping_country AS country,
					o.payment_id AS payment_id,
					i.invoice_id AS invoice_id,
					o.payment_ref_id AS payment_ref_id,o.payment_tran_id AS payment_tran_id,
					(SELECT os.name FROM order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '1') AS status,
					o.shipping_city AS city,
					op.product_id AS pdtcode,
					pd.name AS pdtname,
					FORMAT(op.total,2) AS total,
					FORMAT((SELECT SUM(op1.total) FROM order_product op1
					WHERE op1.order_id = op.order_id GROUP BY op.order_id), 2) AS order_total,				
					opt.value AS options, 
					opt.order_product_id AS ordprdid,
					op.order_product_id AS optprdid, 
					op.quantity AS opquantity,
					op.tax AS order_tax,
					FORMAT(o.total, 2) AS invoice_total,
					(SELECT GROUP_CONCAT(DISTINCT cd.name ORDER BY cp.level SEPARATOR ' > ')
					FROM category_path cp
					LEFT JOIN category c ON (cp.path_id = c.category_id)
					LEFT JOIN category_description cd ON (c.category_id = cd.category_id)
					LEFT JOIN
					product_to_category ptc2 ON (ptc2.category_id = c.category_id) 
					WHERE cp.category_id = ptc.category_id) AS prod_category,
					(SELECT FORMAT(value, 2) 
					FROM order_total 
					WHERE code='shipping' AND order_id= o.order_id) AS shipping_charge
					FROM `order` AS o
					LEFT JOIN invoice i ON (o.order_id = i.order_id)
					LEFT JOIN order_product op ON (o.order_id = op.order_id)
					LEFT JOIN product_description pd ON (pd.product_id = op.product_id AND pd.language_id = o.language_id ) 
					LEFT JOIN order_option opt ON (opt.order_product_id = op.order_product_id)  
					LEFT JOIN product_to_category ptc ON (ptc.product_id = op.product_id)";

		/*$sql = "SELECT cp.category_id AS cat_id, o.order_id AS orderid, DATE(o.date_added) AS order_date, TIME(o.date_added) AS order_time, 
					CONCAT(o.payment_firstname, ' ', o.payment_lastname) AS payment_customer, o.payment_firstname AS payment_firstname, 
					o.payment_lastname AS payment_lastname, CONCAT(o.payment_address_1, ', ', o.payment_address_2, ', ', payment_city) AS payment_full_address, 
					o.payment_address_1 AS payment_address1, o.payment_address_2 AS payment_address2, o.payment_city AS payment_city, 
					o.payment_postcode AS payment_zipcode, o.payment_zone As payment_state, o.payment_country AS payment_country, 
					o.telephone AS payment_phone, o.email AS payment_email, CONCAT(o.shipping_firstname, ' ', o.shipping_lastname) AS shipping_customer, 
					o.shipping_firstname AS shipping_firstname, o.payment_lastname AS shipping_lastname, 
					CONCAT(o.shipping_address_1, ', ', o.shipping_address_2, ', ', shipping_city) AS shipping_full_address, 
					o.shipping_address_1 AS shipping_address1, o.shipping_address_2 AS shipping_address2, o.shipping_postcode AS shipping_zipcode, 
					o.shipping_zone As shipping_state, o.shipping_country AS shipping_country, o.shipping_city AS shipping_city, o.shipping_country AS country,
					o.payment_id AS payment_id, o.payment_ref_id AS payment_ref_id,o.payment_tran_id AS payment_tran_id, 
					(SELECT os.name FROM order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '1') AS status,
					o.shipping_city AS city, GROUP_CONCAT(DISTINCT op.product_id SEPARATOR '<br>') AS pdtcode, 
	    			GROUP_CONCAT(DISTINCT pd.name SEPARATOR '<br>') AS pdtname, 
	    			GROUP_CONCAT(DISTINCT op.quantity SEPARATOR '<br>') AS quantity,
	    			GROUP_CONCAT(DISTINCT FORMAT(op.total, 2) SEPARATOR '<br>') AS total,
					FORMAT(SUM(DISTINCT op.total), 2) AS order_total,
	    			GROUP_CONCAT(opt.value ) AS options, 
	    			GROUP_CONCAT(opt.order_product_id ) AS ordprdid,
	    			GROUP_CONCAT(op.order_product_id ) AS optprdid, 
	    			GROUP_CONCAT(DISTINCT op.quantity SEPARATOR '<br>') AS opquantity,
					(SELECT GROUP_CONCAT(DISTINCT cd.name ORDER BY cp.level SEPARATOR ' > ')
					FROM category_path cp 
					LEFT JOIN category c ON (cp.path_id = c.category_id)
					LEFT JOIN category_description cd ON (c.category_id = cd.category_id)
					LEFT JOIN product_to_category ptc ON (ptc.category_id = c.category_id)
					WHERE cp.category_id = cat_id) AS prod_category,
					(SELECT FORMAT(value, 2) FROM order_total WHERE code='shipping' AND order_id= orderid) AS shipping_charge
					FROM `order` o 
					LEFT JOIN order_product op ON (op.order_id = o.order_id) 
					LEFT JOIN product_description pd ON (pd.product_id = op.product_id)  
					LEFT JOIN order_option opt ON (opt.order_product_id = op.order_product_id)   
					LEFT JOIN product_to_category ptc ON (ptc.product_id = op.product_id) 
					LEFT JOIN category_path cp ON (cp.category_id = ptc.category_id) 
					LEFT JOIN category c ON (cp.path_id = c.category_id) 
					LEFT JOIN category_description cd ON (c.category_id = cd.category_id) ";*/
		
/*	    $sql = "select o.order_id,  DATE(o.date_added) AS order_date, TIME(o.date_added) AS order_time, CONCAT(o.payment_firstname, ' ', o.payment_lastname) AS payment_customer, 
	    			o.payment_firstname AS payment_firstname, o.payment_lastname AS payment_lastname, CONCAT(o.payment_address_1, ', ', o.payment_address_2, ', ', 
	    			payment_city) AS payment_full_address, o.payment_address_1 AS payment_address1, o.payment_address_2 AS payment_address2, o.payment_city AS payment_city, 
	    			o.payment_postcode AS payment_zipcode, o.payment_zone As payment_state, o.payment_country AS payment_country, o.telephone AS payment_phone, 
	    			o.email AS payment_email, CONCAT(o.shipping_firstname, ' ', o.shipping_lastname) AS shipping_customer, o.shipping_firstname AS shipping_firstname, 
	    			o.payment_lastname AS shipping_lastname, CONCAT(o.shipping_address_1, ', ', o.shipping_address_2, ', ', shipping_city) AS shipping_full_address, 
	    			o.shipping_address_1 AS shipping_address1, o.shipping_address_2 AS shipping_address2, o.shipping_postcode AS shipping_zipcode, 
	    			o.shipping_zone As shipping_state, o.shipping_country AS shipping_country, o.shipping_city AS shipping_city, o.shipping_country AS country,
	    			o.payment_id AS payment_id, o.payment_ref_id AS payment_ref_id, o.payment_tran_id AS payment_tran_id,
	    			(SELECT os.name FROM " . DB_PREFIX . " order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS status, 
	    			o.shipping_city AS city,
	    			GROUP_CONCAT(op.product_id) AS pdtcode, 
	    			GROUP_CONCAT(pd.name) AS pdtname, 
	    			GROUP_CONCAT(op.quantity) AS quantity,
	    			GROUP_CONCAT(FORMAT(op.total, 2)) AS total,
	    			GROUP_CONCAT(opt.value ) AS options, 
	    			GROUP_CONCAT(opt.order_product_id ) AS ordprdid,
	    			GROUP_CONCAT(op.order_product_id ) AS optprdid, 
	    			GROUP_CONCAT(op.quantity) AS opquantity from `" . DB_PREFIX . "order` o 
	    			LEFT JOIN " . DB_PREFIX . "order_product op ON (op.order_id = o.order_id) 
	    			LEFT JOIN " . DB_PREFIX . "product_description pd ON (pd.product_id = op.product_id) 
	    			LEFT JOIN " . DB_PREFIX . "order_option opt ON (opt.order_product_id = op.order_product_id) ";	*/
			
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
						
		$sql .= " group by o.order_id,o.customer_id, op.product_id ";
		
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
		
		//$this->log->write('shptreport sql  =  '  . $sql);
			
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getTotalOrders($data = array()) { 
	
		$sql = "SELECT *
				FROM `order` AS o
				LEFT JOIN order_product op ON (o.order_id = op.order_id)
				LEFT JOIN product_description pd ON (pd.product_id = op.product_id) 
				LEFT JOIN order_option opt ON (opt.order_product_id = op.order_product_id)  
				LEFT JOIN product_to_category ptc ON (ptc.product_id = op.product_id) ";	
			
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
		
		$sql .= " group by o.order_id,o.customer_id, op.product_id ORDER BY o.order_id	";

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