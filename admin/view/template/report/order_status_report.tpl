<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td><?php echo $entry_status; ?>
            <select name="filter_order_status_id">
              <option value="0"><?php echo $text_all_status; ?></option>
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
		  <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a>&nbsp;
		  <!--<a onclick="filter('export');" class="button"><?php echo $button_csv; ?></a></td>
		  <td style="text-align: right;">-->
		  <a onclick="filter('export');" class="button"><?php echo $button_export; ?></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_orderid; ?></td>
            <td class="left"><?php echo $column_status; ?></td>
            <td class="left"><?php echo $column_date; ?></td>
            <td class="left"><?php echo $column_time; ?></td>
            <td class="left"><?php echo $column_email; ?></td>
            <td class="left"><?php echo $column_payment_customer; ?></td>
            <td class="left"><?php echo $column_payment_firstname; ?></td>
            <td class="left"><?php echo $column_payment_lastname; ?></td>
            <td class="left"><?php echo $column_payment_full_address; ?></td>
            <td class="left"><?php echo $column_payment_address_1; ?></td>
            <td class="left"><?php echo $column_payment_address_2; ?></td>
            <td class="left"><?php echo $column_payment_city; ?></td>
            <td class="left"><?php echo $column_payment_zipcode; ?></td>
            <td class="left"><?php echo $column_payment_state; ?></td>
            <td class="left"><?php echo $column_payment_country; ?></td>
            <td class="left"><?php echo $column_payment_phone; ?></td>
            <td class="left"><?php echo $column_payment_email; ?></td>
            <td class="left"><?php echo $column_shipping_customer; ?></td>
            <td class="left"><?php echo $column_shipping_firstname; ?></td>
            <td class="left"><?php echo $column_shipping_lastname; ?></td>
            <td class="left"><?php echo $column_shipping_full_address; ?></td>
            <td class="left"><?php echo $column_shipping_address_1; ?></td>
            <td class="left"><?php echo $column_shipping_address_2; ?></td>
            <td class="left"><?php echo $column_shipping_city; ?></td>
            <td class="left"><?php echo $column_shipping_zipcode; ?></td>
            <td class="left"><?php echo $column_shipping_state; ?></td>
            <td class="left"><?php echo $column_shipping_country; ?></td>
            
            <td class="left"><?php echo $column_pdtcode; ?></td> 
            <td class="left"><?php echo $column_pdtname; ?></td>
            <td class="left"><?php echo $column_quantity; ?></td>
            <td class="left"><?php echo $column_total; ?></td>
            <td class="left"><?php echo $column_category; ?></td>
            <td class="left"><?php echo $column_order_total; ?></td>
            <td class="left"><?php echo $column_payment_tran_id; ?></td>
            <td class="left"><?php echo $column_shipping_charges; ?></td>
            <td class="left"><?php echo $column_taxes; ?></td>
            <td class="left"><?php echo $column_invoice_id; ?></td>
            <td class="left"><?php echo $column_invoice_total; ?></td>

			<!--
			<td class="left"><?php echo $column_payment_id; ?></td>
			<td class="left"><?php echo $column_payment_ref_id; ?></td>
			-->
			
          </tr>
        </thead>
        <tbody>
          <?php if ($customers) { ?>
          <?php foreach ($customers as $customer) { ?>
          <tr>
            <td class="left"><?php echo $customer['order_id']; ?></td>
            <td class="left"><?php echo $customer['status']; ?></td>
            <td class="left"><?php echo $customer['order_date']; ?></td>
            <td class="left"><?php echo $customer['order_time']; ?></td>
            <td class="left"><?php echo $customer['username']; ?></td>
            <td class="left"><?php echo $customer['payment_customer']; ?></td>
            <td class="left"><?php echo $customer['payment_firstname']; ?></td>
            <td class="left"><?php echo $customer['payment_lastname']; ?></td>
            <td class="left"><?php echo $customer['payment_full_address']; ?></td>
            <td class="left"><?php echo $customer['payment_address_1']; ?></td>
            <td class="left"><?php echo $customer['payment_address_2']; ?></td>
            <td class="left"><?php echo $customer['payment_city']; ?></td>
            <td class="left"><?php echo $customer['payment_zipcode']; ?></td>
            <td class="left"><?php echo $customer['payment_state']; ?></td>
            <td class="left"><?php echo $customer['payment_country']; ?></td>
            <td class="left"><?php echo $customer['payment_phone']; ?></td>
            <td class="left"><?php echo $customer['payment_email']; ?></td>
            <td class="left"><?php echo $customer['shipping_customer']; ?></td>
            <td class="left"><?php echo $customer['shipping_firstname']; ?></td>
            <td class="left"><?php echo $customer['shipping_lastname']; ?></td>
            <td class="left"><?php echo $customer['shipping_full_address']; ?></td>
            <td class="left"><?php echo $customer['shipping_address_1']; ?></td>
            <td class="left"><?php echo $customer['shipping_address_2']; ?></td>
            <td class="left"><?php echo $customer['shipping_city']; ?></td>
            <td class="left"><?php echo $customer['shipping_zipcode']; ?></td>
            <td class="left"><?php echo $customer['shipping_state']; ?></td>
            <td class="left"><?php echo $customer['shipping_country']; ?></td>
            
            <td class="left"><?php echo $customer['pdtcode']; ?></td>
            <td nowrap="nowrap"><?php echo $customer['pdtname']; ?></td>
            <td class="left"><?php echo $customer['quantity']; ?></td>
            <td class="left"><?php echo $customer['total']; ?></td>
            <td class="left" nowrap="nowrap"><?php echo $customer['category']; ?></td>
            <td class="left"><?php echo $customer['order_total']; ?></td>
            <td class="left"><?php echo $customer['payment_tran_id']; ?></td>
            <td class="left"><?php echo $customer['shipping_charge']; ?></td>
            <td class="left"><?php echo $customer['order_tax']; ?></td>
            <td class="left"><?php echo $customer['invoice_id']; ?></td>
            <td class="left"><?php echo $customer['invoice_total']; ?></td>

			<!--
			<td class="left"><?php echo $customer['payment_id']; ?></td>
			<td class="left"><?php echo $customer['payment_ref_id']; ?></td>
			-->
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="12"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/order_status_report&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
	
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');
	
	if (filter_order_status_id) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
function filter(param) {
	
	url = 'index.php?route=report/order_status_report&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}

	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');
	
	if (filter_order_status_id != 0) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}	
	if(param == "export"){
		url +="&option=export";
	}
	else if(param == "excelexport"){
		url +="&option=excelexport";
	}
	location = url;
}
//--></script>
<script type="text/javascript"><!--
function excelexport() {
	alert("hi");
	url = 'index.php?route=report/order_status_report/excelreport&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}

	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');
	
	if (filter_order_status_id != 0) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}	

	location = url;
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<?php echo $footer; ?>