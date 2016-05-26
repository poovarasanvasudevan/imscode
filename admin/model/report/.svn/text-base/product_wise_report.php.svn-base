<?php
class ModelReportProductWiseReport extends Model {
	public function getOrders($data = array(), $isExport) { 
	
		$sql   = "SELECT
					o.order_id AS orderid,
					pd.name AS pdtname,
					op.product_id AS pdtcode,
					opt.value AS options,
					opt.order_product_id AS ordprdid,
					op.order_product_id AS optprdid,
					SUM(op.quantity) AS opquantity,
					FORMAT(op.price,2) AS price,
					(SELECT os.name FROM order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '1') AS status
					FROM `order` AS o
					LEFT JOIN order_product op ON (o.order_id = op.order_id)
					LEFT JOIN product_description pd ON (pd.product_id = op.product_id)
					LEFT JOIN order_option opt ON (opt.order_product_id = op.order_product_id)";
		
/*		$sql   = "SELECT
					o.order_id AS orderid, 
					ptc.category_id AS cat_id,
					pd.name AS pdtname,
					(SELECT GROUP_CONCAT(DISTINCT cd.name ORDER BY cp.level SEPARATOR ' > ')
					FROM category_path cp
					LEFT JOIN category c ON (cp.path_id = c.category_id)
					LEFT JOIN category_description cd ON (c.category_id = cd.category_id)
					LEFT JOIN product_to_category ptc ON (ptc.category_id = c.category_id)
					WHERE cp.category_id = cat_id) AS prod_category,
					op.product_id AS pdtcode,
					opt.value AS options,
					opt.order_product_id AS ordprdid,
					op.order_product_id AS optprdid, 
					SUM(op.quantity) AS opquantity,
					FORMAT(op.price,2) AS price,
					(SELECT os.name FROM order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '1') AS status
					FROM `order` AS o
					LEFT JOIN order_product op ON (o.order_id = op.order_id)
					LEFT JOIN product_description pd ON (pd.product_id = op.product_id)
					LEFT JOIN product_to_category ptc ON (ptc.product_id = op.product_id)
					LEFT JOIN order_option opt ON (opt.order_product_id = op.order_product_id)";*/
			
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
						
		$sql .= " GROUP BY op.product_id ORDER BY op.name	";
		
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
		
		$this->log->write('product_wise_report sql  =  '  . $sql);
			
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
		
		$sql .= " GROUP BY op.product_id ORDER BY op.name	";

		//$this->log->write('getTotalOrders sql  =  '  . $sql);
		
		$query = $this->db->query($sql);
	
		return $query->num_rows;
	}
		
}
?>