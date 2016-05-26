<html>
<head >
	<table border="1" align="center"  width="100%" >
		<tr>
		<td align="Left" width="90%"><font  size = 5 color = darkblue face = verdana ><b>HDFC Payment Gateway</td>
		<td align="right"width="10%"><IMG SRC="images/fssnet.JPG" WIDTH="169" HEIGHT="37" BORDER="0" ALT=""></td>
		</tr>
	</table>
</head>
<BODY bgcolor="white">
	
<?php
$file = '/tmp/prabhu3.txt';

file_put_contents($file, " Inside FailedTRAN.php---->>>>>> ", FILE_APPEND | LOCK_EX);

file_put_contents($file, " \n\n _GET ====  " . print_r($_GET, TRUE), FILE_APPEND | LOCK_EX);

$strMessage =  isset($_GET['Message']) ? $_GET['Message'] : '';
$strMTRCKID =  isset($_GET['ResTrackId']) ? $_GET['ResTrackId'] : '';
$strAmt =  isset($_GET['ResAmount']) ? $_GET['ResAmount'] : '';
$strError =  isset($_GET['ResError']) ? $_GET['ResError'] : '';
?>

  <br><br> <br><br> 
	<table border="1" align="center" >
	<tr>
		<th colspan="50" bgcolor="darkblue" ><p style= "color:white">Transaction Failed Response </th>
	</tr>
	
			<tr>
				<td colspan="35"> Transaction Status </td>
				<td> <?php echo $strMessage;?></td>
			</tr>
			<tr>
				<td colspan="35"> Merchant Reference No:[TRACK_ID] </td>
				<td> <?php echo $strMTRCKID;?> </td>
			</tr>
			<tr>
				<td colspan="35"> Transaction Amount </td>
				<td> <?php echo $strAmt;?> </td>
			</tr>
					
			<tr>
				<td colspan="35"> Error Description </td>
				<td><center><FONT color="red"><b> <?php echo $strError;?></FONT></td>
			</tr>		
	</table>
<br><br><br><br><br>
<table border="1" align="center"  width="100%" >
	<tr>
	<td align="Left" width="90%"><font  size = 5 color = darkblue face = verdana ><b>HDFC Payment Gateway</td>
	<td align="right"width="10%"><IMG SRC="images/fssnet.JPG" WIDTH="169" HEIGHT="37" BORDER="0" ALT=""></td>
	</tr>
	</table>
</body>
</html>
<!-- Disclaimer:- Important Note in Sample Pages
- This is a sample demonstration page only ment for demonstration, this page should not be used in production
- Transaction data should only be accepted once from a browser at the point of input, and then kept in a way that does not allow others to modify it (example server session, database  etc.)
- Any transaction information displayed to a customer, such as amount, should be passed only as display information and the actual transactional data should be retrieved from the secure source last thing at the point of processing the transaction.
- Any information passed through the customer's browser can potentially be modified/edited/changed/deleted by the customer, or even by third parties to fraudulently alter the transaction data/information. Therefore, all transaction information should not be passed through the browser to Payment Gateway in a way that could potentially be modified (example hidden form fields). 
 -->