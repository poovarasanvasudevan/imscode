<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_MID; ?></td>
            <td><input type="text" name="FssNet_MID" value="<?php echo $FssNet_MID; ?>" />
              <?php if ($error_MID) { ?>
              <span class="error"><?php echo $error_MID; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td width="25%"><span class="required">*</span> <?php echo $entry_password; ?></td>
            <td><input type="text" name="FssNet_Password" value="<?php echo $FssNet_Password; ?>" />
            <br />
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_test; ?></td>
            <td><?php if ($FssNet_test) { ?>
              <input type="radio" name="FssNet_test" value="1" checked="checked" />
              <?php echo $text_yes; ?>
              <?php } else { ?>
              <input type="radio" name="FssNet_test" value="1" />
              <?php echo $text_yes; ?>
              <?php } ?>
              <?php if (!$FssNet_test) { ?>
              <input type="radio" name="FssNet_test" value="0" checked="checked" />
              <?php echo $text_no; ?>
              <?php } else { ?>
              <input type="radio" name="FssNet_test" value="0" />
              <?php echo $text_no; ?>
              <?php } ?></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_RedirectURL; ?></td>
            <td><input type="text" name="FssNet_RedirectURL" value="<?php echo $FssNet_RedirectURL; ?>" />
              <?php if ($error_RedirectURL) { ?>
              <span class="error"><?php echo $error_RedirectURL; ?></span>
              <?php } ?></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_ErrorURL; ?></td>
            <td><input type="text" name="FssNet_ErrorURL" value="<?php echo $FssNet_ErrorURL; ?>" />
              <?php if ($error_ErrorURL) { ?>
              <span class="error"><?php echo $error_ErrorURL; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_action_code; ?></td>
            <td>
            	<select name="FssNet_action_code">
            		<?php if ($FssNet_action_code == "1") { ?>
            			<option value="1" selected="selected"><?php echo "1. Purchase Transaction"; ?></option>
            			<option value="4"><?php echo "4. Authorization (pre-auth)"; ?></option>
            		<?php } elseif($FssNet_action_code == "4") { ?>
            			<option value="1"><?php echo "1. Purchase Transaction"; ?></option>
            			<option value="4" selected="selected"><?php echo "4. Authorization (pre-auth)"; ?></option>
            		<?php } ?>            			
            	</select>
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_tran_lang; ?></td>
            <td>
            	<select name="FssNet_tran_lang">
            		<option value="USA" selected="selected"><?php echo "USA"; ?></option>
            	</select>
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_currency_code; ?></td>
            <td>
            	<select name="FssNet_currency_code">
            		<option value="356" selected="selected"><?php echo "INR"; ?></option>
            	</select>
            </td>
          </tr>
        <tr>
          <td><?php echo $entry_debuglog; ?></td>
          <td><?php if ($FssNet_debuglog) { ?>
            <input type="radio" name="FssNet_debuglog" value="1" checked="checked" />
            <?php echo $text_enabled; ?>
            <input type="radio" name="FssNet_debuglog" value="0" />
            <?php echo $text_disabled; ?>
            <?php } else { ?>
            <input type="radio" name="FssNet_debuglog" value="1" />
            <?php echo $text_enabled; ?>
            <input type="radio" name="FssNet_debuglog" value="0" checked="checked" />
            <?php echo $text_disabled; ?>
            <?php } ?></td>
        </tr>
          <tr>
            <td><?php echo $entry_success_status; ?></td>
            <td><select name="FssNet_success_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $FssNet_success_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_pending_status; ?></td>
            <td><select name="FssNet_pending_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $FssNet_pending_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_failed_status; ?></td>
            <td><select name="FssNet_failed_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $FssNet_failed_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="FssNet_geo_zone_id">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $FssNet_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="FssNet_status">
                <?php if ($FssNet_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="FssNet_sort_order" value="<?php echo $FssNet_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 