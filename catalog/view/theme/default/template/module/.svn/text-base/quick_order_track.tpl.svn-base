<div class="box">
	<div class="top">
		<img src="catalog/view/theme/default/image/quick_order_track.png" alt="" />
		<?php echo $heading_title; ?>
	</div>
	<div class="middle">
		<table cellpadding="2" cellspacing="0" style="width: 100%;">
			<tr>
				<td valign="top"><?php echo $title_order_id;?></td>
			</tr>
			<tr>
				<td>
					<input type="text" id="track_order_id" name="order_id" value="" style="width:90%;" />
				</td>
			</tr>
			<tr>
				<td valign="top">
				<?php echo $title_email;?>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" id="track_email" name="email" value="" style="width:90%;" />
				</td>
			</tr>
			<tr>
				<td style="text-align:right;">
					<a onclick="fn_track_now();" class="button"><span><?php echo $text_track_now; ?></span></a>
				</td>
			</tr>			
		</table>
	</div>
	<div class="bottom">
		&nbsp;
	</div>
</div>

<script type="text/javascript">
	function fn_track_now()
	{
		if($("#track_order_id").val() == "")
		{
			alert("<?php echo $error_missing_id;?>");
		}
		else if($("#track_email").val() == "")
		{
			alert("<?php echo $error_missing_email;?>");
		}
		else
		{
			var order_track_href = "<?php echo str_replace('&', '&amp;', $order_track_href); ?>";
			
			tb_show("Order Tracking",order_track_href + "&order_id=" + $("#track_order_id").val() + "&email=" + $("#track_email").val());
		}
		
	}
</script>