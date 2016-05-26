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
          <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a>&nbsp;<a onclick="filter('export');" class="button"><?php echo $button_csv; ?></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
			<td class="right"><?php echo $column_order_id; ?></td>
			<td class="right"><?php echo $column_customer_name; ?></td>
			<td class="right"><?php echo $column_shipping_city; ?></td>
			<td class="right"><?php echo $column_order_status; ?></td>
			<td class="right"><?php echo $column_date_added; ?></td>
			<td class="right"><?php echo $column_product_code; ?></td>
			<td class="right"><?php echo $column_product; ?></td>
			<td class="right"><?php echo $column_quantity; ?></td>
			<td class="right"><?php echo $column_price; ?></td>
			<td class="right"><?php echo $column_total; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($orders) { ?>
          <?php foreach ($orders as $order) {?>
          <tr>
			<td class="right"><?php echo $order['order_id']; ?></td>
			<td class="right"><?php echo $order['customer_name']; ?></td>
			<td class="right"><?php echo $order['shipping_city']; ?></td>
			<td class="right"><?php echo $order['order_status']; ?></td>
			<td class="right"><?php echo $order['date_added']; ?></td>
			<td class="right"><?php echo $order['product_code']; ?></td>
			<td class="right"><?php echo $order['product']; ?></td>
			<td class="right"><?php echo $order['quantity']; ?></td>
			<td class="right"><?php echo $order['price']; ?></td>
			<td class="right"><?php echo $order['total']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter(param) {
	
	url = 'index.php?route=report/sales_order_details&token=<?php echo $token; ?>';
	
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');
	
	if (filter_order_status_id != 0) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}	
	if(param == "export"){
		url +="&option=export";
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