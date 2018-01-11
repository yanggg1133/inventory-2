<?php 
foreach($sales as $sale) { 
?>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"><title>Order #<?php echo $sale->order_id; ?></title>

<style type="text/css">
div#ups_label {
	position: absolute;
	
	top: 10px;
	left: 640px;
	z-index: 1;
	
}

div#returns_label {
	position: absolute;
	top: 595px;
	left: 610px;
	z-index: 1;
	
}

div#returns_label_CA {
	position: absolute;
	margin-top:10px;
	top: 0px;
	left: 610px;
    z-index: 1;
}

div#order_barcode {
	position: absolute;
	top: 0px;
	left: 188px;
	width: 400px;
	text-align: right; 
	z-index: -10;
	border: 0px solid;
}


div#message_logo {
	position: absolute;
	top: 0px;
	left: 430px;
	z-index: 1;
}

BODY {
		font-size: 12pt;
		font-family: Helvetica;
	   }



</style>
<script>(function (a){var b={},c;for(c in a||{})if(a.hasOwnProperty(c)&&"undefined"!=typeof a[c])try{b[c]=
JSON.stringify(a[c])}catch(d){console.log("Cannot stringify "+c)}a=document.createEvent("CustomEvent");a.initCustomEvent("RetrievedVariablesEvent",!0,!0,{variables:b});window.dispatchEvent(a)})({'studioV2': window['studioV2'],'richMediaIframeBreakoutCreatives': window['richMediaIframeBreakoutCreatives']})</script></head>

<body topmargin="0" leftmargin="0">	<div id="ups_label"><img border="0" src="data:image/jpg;base64,<?php echo $label; ?>" width="350" height="600"></div><div id="returns_label">

<table border="0" style="border-collapse: collapse" width="390" id="table1">
	<tbody><tr>
		<td width="400">
		<table border="1" style="border-collapse: collapse" width="300" align="right" cellpadding="5" bordercolor="#C0C0C0" cellspacing="5">
			<tbody><tr>
				<td><font face="Helvetica" size="2"><b>Ship to:</b><br>Returns #<?php echo $sale->order_id; ?><br>
				8650 S Pleasant Grove Rd<br>
				Inverness, FL 34453</font></td>
			</tr>
		</tbody></table>
		</td>
	</tr>
</tbody></table>
</div>

	<div id="order_barcode">
	</div>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="590">
  <tbody><tr>
    <td width="65%" valign="top" height="80"><font face="Helvetica" size="2"><img border="0" src="http://www.bluebinz.com/assets/tirelogo-grey.jpg" height="40">
	<table border="0" cellpadding="3" cellspacing="0" width="100%">
	  <tbody><tr>
		<td width="50%"><font face="Helvetica" size="2">Trailer Tire SuperCenter<br>
		700 S Thompson Ave<br>
        Lecanto, FL 34461</font></td>
		<td width="50%"><font face="Helvetica" size="2"><strong>(855) 315-0301</strong><br>www.TrailerTireSuperCenter.com</font></td>
	  </tr>
	</tbody></table>

	</font></td>
    <td width="35%" valign="bottom">

      <table border="1" cellpadding="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" cellspacing="0">
      <tbody><tr>
        <td width="50%" align="center" bgcolor="#DBEBFA"><b>
        <font face="Helvetica" size="2">Order Date</font></b></td>
        <td width="50%" align="center" bgcolor="#DBEBFA"><b>
        <font face="Helvetica" size="2">Order Nr</font></b></td>
      </tr>
      <tr>
        <td width="50%" align="center" bgcolor="#FDF9D8">
        <font face="Helvetica" size="2"><?php echo date(" m/d/Y", strtotime($sale->purchase_date)); ?></font></td>
        <td width="50%" align="center" bgcolor="#FDF9D8">
        <font face="Helvetica" size="2"><?php echo $sale->order_id; ?></font></td>
      </tr>
    </tbody></table>

    </td>
  </tr>
</tbody></table>
<hr noshade="" color="#000000" width="590" size="1" align="left">
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="590">
  <tbody><tr>
    <td width="50%" align="left" valign="top">
    <table border="1" cellpadding="3" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" height="100%" width="100%">
      <tbody><tr>
        <td width="100%" bgcolor="#DBEBFA"><b><font face="Helvetica" size="2">
        Shipping Address</font></b></td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#FDF9D8"><font face="Helvetica" size="2"><?php echo $sale->name; ?><br><?php echo $sale->address; ?><br><?php echo $sale->city; ?>, <?php echo $sale->state; ?>, <?php echo $sale->zip; ?><br>US<br>
</font></td>
      </tr>
    </tbody></table>
    </td>
  </tr>
</tbody></table>
<br>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="590">
  <tbody><tr>
    <td width="100%">
    <table border="1" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
      <tbody><tr>
        <td width="50" bgcolor="#DBEBFA"><b><font face="Helvetica" size="2">
        ID</font></b></td>
     <td width="30" bgcolor="#DBEBFA"><b><font face="Helvetica" size="2">Qty</font></b></td>
        <td width="400" bgcolor="#DBEBFA"><b><font face="Helvetica" size="2">
        Name</font></b></td>
	        <td width="70" bgcolor="#DBEBFA" align="right"><b><font face="Helvetica" size="2">
	        Cost</font></b></td>
	        <td width="70" bgcolor="#DBEBFA" align="right"><b><font face="Helvetica" size="2">
	        Amount</font></b></td>
			<td width="20" bgcolor="#DBEBFA" align="right"></td> </tr>
	        	<?php 
	        	setlocale(LC_MONETARY, 'en_US.UTF-8');
	        	$sub_total = 0.00;
	        	$shipping = 0.00;
	        	$discount = 0.00;
	        	$tax = 0.00;
	        	foreach($items as $item) { ?>
	            <tr>
	                <td><font face="Helvetica" size="2"><?php echo $item->aid; ?></font></td>
			    	<td><font face="Helvetica" size="2"><?php echo $item->quantity; ?></font></td>
	            	<td><font face="Helvetica" size="2"><?php echo $item->title; ?></font></td><td align="right"><font face="Helvetica" size="2"><strike><?php echo $item->cost_per_item; ?></strike><br><?php echo $item->cost_per_item; ?></font></td>
		            <?php 
		            	if ($source == 'cs-cart')
		            	{ ?>
						<td align="right"><font face="Helvetica" size="2"><?php echo ($item->cost_per_item * $item->quantity); ?></font></td>		            	
		            <?php	} 
		            else
		            { ?>
						<td align="right"><font face="Helvetica" size="2"><?php echo $item->total; ?></font></td>
		            <?php } ?>
		            
				    <td align="right"><font face="Helvetica" size="2">&nbsp;</font></td>
				</tr>
				<?php
					if ($source == 'cs-cart')
					{
						$sub_total += ($item->cost_per_item * $item->quantity);
					}
					else {
						$sub_total += $item->total;
					}
					
					$shipping = $item->shipping;
					$tax += $item->tax;
				 } ?>
      <tr>
        <td bgcolor="#FDF9D8" align="right" colspan="4"><b><font face="Helvetica" size="2">Sub Total</font></b></td>
        <td bgcolor="#FDF9D8" align="right"><b><font face="Helvetica" size="2"><?php echo money_format('%n', $sub_total); ?></font></b></td>
		<td bgcolor="#FDF9D8" align="right"><font face="Helvetica" size="2">&nbsp;</font></td>
      </tr>
      <tr>
        <td bgcolor="#FDF9D8" align="right" colspan="4"><b><font face="Helvetica" size="2">Discount</font></b></td>
        <td bgcolor="#FDF9D8" align="right"><b><font face="Helvetica" size="2"><?php echo money_format('%n',  $discount); ?></font></b></td>
		<td bgcolor="#FDF9D8" align="right"><font face="Helvetica" size="2">&nbsp;</font></td>
      </tr>
      <tr>
        <td bgcolor="#FDF9D8" align="right" colspan="4"><b><font face="Helvetica" size="2">Shipping &amp; Handling</font></b></td>
        <td bgcolor="#FDF9D8" align="right"><b><font face="Helvetica" size="2"><?php echo money_format('%n', $shipping); ?></font></b></td>
		<td bgcolor="#FDF9D8" align="right"><font face="Helvetica" size="2">&nbsp;</font></td>
      </tr>
      <tr>
        <td bgcolor="#FDF9D8" align="right" colspan="4"><b><font face="Helvetica" size="2">Tax</font></b></td>
        <td bgcolor="#FDF9D8" align="right"><b><font face="Helvetica" size="2"><?php echo money_format('%n',  $tax); ?></font></b></td>
		<td bgcolor="#FDF9D8" align="right"><font face="Helvetica" size="2">&nbsp;</font></td>
      </tr>
      <tr>
        <td bgcolor="#FDF9D8" align="right" colspan="4"><b><font face="Helvetica" size="2">Total</font></b></td>
        <td bgcolor="#FDF9D8" align="right"><b><font face="Helvetica" size="2"><?php echo money_format('%n', ($tax + $sub_total + $shipping)); ?></font></b></td>
		<td bgcolor="#FDF9D8" align="right"><font face="Helvetica" size="2">&nbsp;</font></td>
      </tr>
    </tbody></table>
    </td>
  </tr>
</tbody></table>
	
	<br>
	
	<table border="1" cellpadding="3" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="590">
	  <tbody><tr>
	    <td width="100%" bgcolor="#FDF9D8"><font face="Helvetica" size="2">
	
	<b>Dear <?php echo $sale->name; ?></b>,<br>
	I would like to personally thank you for placing your order with the Trailer Tire Supercenter. I hope the items have arrived to your satisfaction. 
	
	If you have any questions or concerns in regards to your order, please call us toll free at (855) 315-0301. You can also email us support@trailertiresupercenter.com.
	<br><br>
	Thanks,
	<br>
	Chris Kingree<br>Store Manager of Trailer Tire SuperCenter
	</font></td>
	  </tr>
	</tbody></table>
	<img src="http://www.bluebinz.com/assets/bwnetwork.jpg" width="600px" style="margin-top: 40px;"/>


</body
<?php
}
?>
></html>