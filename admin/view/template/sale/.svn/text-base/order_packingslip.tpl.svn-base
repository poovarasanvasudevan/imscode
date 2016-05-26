<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>"><head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/osc_invoice/stylesheet.css">
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#ffffff" marginheight="0" marginwidth="0">
<?php if ($orders) { ?>
<?php foreach ($orders as $order) { ?>

<!-- body_text //-->
<table width="830px" border="0">
  <tbody><tr>
    <td><table width="100%" border="0">
        <tbody><tr>
          <td width="350">
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
              <tbody><tr>
                <td valign="top" align="center"><img src="view/osc_invoice/logo.png" alt="" border="0"></td>
              </tr>
              <tr>
                <td class="pageHeading-invoice" valign="top" align="left"><?php echo $order['store_name']; ?><br />
          <?php echo $order['address']; ?><br />
          <?php echo $text_telephone; ?> <?php echo $order['telephone']; ?><br />
          <?php if ($order['fax']) { ?>
          <?php echo $text_fax; ?> <?php echo $order['fax']; ?><br />
          <?php } ?>
          <?php echo $order['email']; ?><br />
          <?php echo $order['store_url']; ?></td>
              </tr>
            </tbody></table></td>
          <td>&nbsp;</td>
          <td valign="top" width="350" align="right">
            </td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody><tr>
          <td><hr></td>
          <td class="pageHeading" valign="middle" width="120" align="center"><em><b><?php echo $text_packingslip; ?></b></em></td>
          <td width="10%"> <hr></td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
        <tbody><tr>
          <td valign="top" width="350" align="left">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tbody><tr>
                <td width="11"> <img src="view/osc_invoice/mainwhite_01.gif" alt="" width="11" height="16"></td>
                <td background="view/osc_invoice/mainwhite_02.gif"> <img src="view/osc_invoice/mainwhite_02.gif" alt="" width="24" height="16"></td>
                <td width="19"> <img src="view/osc_invoice/mainwhite_03.gif" alt="" width="19" height="16"></td>
              </tr>
              <tr>
                <td background="view/osc_invoice/mainwhite_04.gif"> <img src="view/osc_invoice/mainwhite_04.gif" alt="" width="11" height="21"></td>
                <td align="center" bgcolor="#ffffff"> <table class="main" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                      <td valign="top" align="left"><b><?php echo $text_to; ?></b></td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left"><img src="view/osc_invoice/pixel_trans.gif" alt="" width="1" border="0" height="5"></td>
                    </tr>
                    <tr>
                      <td><?php echo $order['payment_address']; ?></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><img src="view/osc_invoice/pixel_trans.gif" alt="" width="1" border="0" height="1"></td>
                    </tr>                    
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody></table></td>
                <td background="view/osc_invoice/mainwhite_06.gif"> <img src="view/osc_invoice/mainwhite_06.gif" alt="" width="19" height="21"></td>
              </tr>
              <tr>
                <td> <img src="view/osc_invoice/mainwhite_07.gif" alt="" width="11" height="18"></td>
                <td background="view/osc_invoice/mainwhite_08.gif"> <img src="view/osc_invoice/mainwhite_08.gif" alt="" width="24" height="18"></td>
                <td> <img src="view/osc_invoice/mainwhite_09.gif" alt="" width="19" height="18"></td>
              </tr>
            </tbody></table></td>
          <td>&nbsp;</td>
          <td valign="top" width="350" align="right">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tbody><tr>
                <td width="11"> <img src="view/osc_invoice/mainwhite_01.gif" alt="" width="11" height="16"></td>
                <td background="view/osc_invoice/mainwhite_02.gif"> <img src="view/osc_invoice/mainwhite_02.gif" alt="" width="24" height="16"></td>
                <td width="19"> <img src="view/osc_invoice/mainwhite_03.gif" alt="" width="19" height="16"></td>
              </tr>
              <tr>
                <td background="view/osc_invoice/mainwhite_04.gif"> <img src="view/osc_invoice/mainwhite_04.gif" alt="" width="11" height="21"></td>
                <td align="center" bgcolor="#ffffff"> <table class="main" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                      <td valign="top" align="left"><b><?php echo $text_ship_to; ?></b></td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left"><img src="view/osc_invoice/pixel_trans.gif" alt="" width="1" border="0" height="5"></td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left"><?php echo$order['shipping_address']; ?></td>
                    </tr>
                    <tr>
                      <td valign="bottom" align="left">&nbsp;</td>
                    </tr>
                   </tbody></table></td>
                <td background="view/osc_invoice/mainwhite_06.gif"> <img src="view/osc_invoice/mainwhite_06.gif" alt="" width="19" height="21"></td>
              </tr>
              <tr>
                <td> <img src="view/osc_invoice/mainwhite_07.gif" alt="" width="11" height="18"></td>
                <td background="view/osc_invoice/mainwhite_08.gif"> <img src="view/osc_invoice/mainwhite_08.gif" alt="" width="24" height="18"></td>
                <td> <img src="view/osc_invoice/mainwhite_09.gif" alt="" width="19" height="18"></td>
              </tr>
            </tbody></table>
          </td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tbody><tr>
          <td class="main-payment"><b><?php echo $text_order_id; ?></b><br><?php echo $order['order_id']; ?></td>
          <td class="main-payment"><b><?php echo $text_date_added; ?></b><br><?php echo $order['date_added']; ?></td>
          <td class="main-payment"><b><?php echo $entry_payment_method; ?></b><br><?php echo $order['payment_method']; ?></td>
          <td class="main-payment"><b><?php echo $entry_shipping_method; ?></b><br><?php echo $order['shipping_method']; ?></td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><img src="view/osc_invoice/pixel_trans.gif" alt="" width="1" border="0" height="5"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tbody><tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent-invoice" colspan="2"><?php echo $column_product; ?></td>
        <td class="dataTableHeadingContent-invoice"><?php echo $column_model; ?></td>
      </tr>
      <?php foreach ($order['product'] as $product) { ?>
      <tr class="dataTableRow">
        <td class="dataTableContent" valign="top" align="right"><?php echo $product['quantity']; ?>&nbsp;x</td>
        <td class="dataTableContent" valign="top"><?php echo $product['name']; ?>
        <?php foreach ($product['option'] as $option) { ?>
        <br><nobr><small>&nbsp;<i> - <?php echo $option['name']; ?> <?php echo $option['value']; ?></i></small></nobr>
        <?php } ?></td>
        <td class="dataTableContent" valign="top"><?php echo $product['model']; ?></td>
      </tr>
      <?php } ?>
      </tbody></table></td>
  </tr>
  <tr>
    <td><img src="view/osc_invoice/pixel_trans.gif" alt="" width="1" border="0" height="5"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tbody><tr>
          <td class="main-payment2"><?php echo $entry_yellow_line; ?></td>
        </tr>
      </tbody></table></td>
  </tr>
  <tr>
    <td><img src="view/osc_invoice/pixel_trans.gif" alt="" width="1" border="0" height="5"></td>
  </tr>
  <tr>
    <td colspan="2" class="main" align="center"><b><?php echo $entry_thankyou; ?></b></td>
  </tr>
  <tr>
    <td><img src="view/osc_invoice/pixel_trans.gif" alt="" width="1" border="0" height="5"></td>
  </tr>
  <tr>
    <td align="center"><img src="view/osc_invoice/apple_logo.jpg" alt="" border="0">&nbsp;<img src="view/osc_invoice/hp_logo.jpg" alt="" border="0"></td>
  </tr>
  <tr>
    <td><img src="view/osc_invoice/pixel_trans.gif" alt="" width="1" border="0" height="5"></td>
  </tr>
</tbody>
</table>
<!-- body_text_eof //-->

<?php } ?>
<?php } else { ?>
<div style="position: absolute; top: 15%; left: 40%;">
<h4><?php echo $entry_no_orders_selected; ?></h4>
</div>
<?php } ?>

</body>
</html>