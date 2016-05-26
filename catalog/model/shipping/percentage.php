<?php
class ModelShippingPercentage extends Model {
	function getQuote($address) {
		$this->language->load('shipping/percentage');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('percentage_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (!$this->config->get('percentage_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$products = $this->cart->getProducts();
		$product_total = 0;
		
		foreach ($products as $product) {
			$product_total += $product['total'];
		}
		
		if($product_total >= 1000){
			$shipping_cost = 0.0;
		}
		else{
			/*$shipping_cost1 = $this->config->get('percentage_cost') * $product_total / 100;
			$shipping_cost2 = $this->config->get('flat_cost');
			
			$shipping_cost = ($shipping_cost1 > $shipping_cost2) ? $shipping_cost1 : $shipping_cost2;*/
			$shipping_cost = 100.0;
		}
		
		
		$method_data = array();

		if ($status) {
			$quote_data = array();

			$quote_data['percentage'] = array(
				'code'         => 'percentage.percentage',
				'title'        => $this->language->get('text_description'),
				'cost'         => $shipping_cost,
				'tax_class_id' => $this->config->get('percentage_tax_class_id'),
				'text'         => $this->currency->format($this->tax->calculate($shipping_cost, $this->config->get('percentage_tax_class_id'), $this->config->get('config_tax')))
			);

			$method_data = array(
				'code'       => 'percentage',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('percentage_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}
?>