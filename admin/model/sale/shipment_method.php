<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/5/16
 * Time: 10:48 AM
 */
class ModelSaleShipmentMethod extends Model
{

    public function addShipmentMethod($shipment_method_name)
    {
        if ($this->db->query("INSERT INTO " . DB_PREFIX . "shippment_method VALUES (NULL,'" . $shipment_method_name . "',NULL)")) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteShipmentMethod($shipmentMethodId)
    {
        if ($this->db->query("DELETE FROM " . DB_PREFIX . "shippment_method WHERE shipment_method_id=" . $shipmentMethodId)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllShipmentMethod()
    {
        $result = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "shippment_method");
        return $query->rows;

    }
}