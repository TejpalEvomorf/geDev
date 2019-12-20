<!DOCTYPE html>

<html>

<head>

	<title>Codeigniter 3 - Generate PDF from view using dompdf library with example</title>

</head>

<body>

<table style="width:100%; font-size:12px; font-family: Helvetica, sans-serif; ">

<tr>
		<td valign="top" style="width:42%">
        <table style="width:100%; font-size:12px; ">
        <tr>
        <td><img src="http://www.gediculture.com/ge/static/system/img/ge-pdf-logo.png" width="173px" height="46px"></td>
        </tr>
        <tr>
        <td style="padding-top:20px;">PO Box Q680 SYDNEY NSW 1230 AUSTRALIA </td>
        </tr>
        </table>
        </td>

		<td valign="top" style="width:33%">
        <b>Invoice Date</b><br>
        31 Aug 2017<br><br>
        <b>Invoice Number</b><br>
        17427<br><br>
        <b>ABN</b><br>
        32 088 449 512
        </td>

		<td valign="top" style="width:25%">
        Name<br>
        Email       
        </td>

</tr>

</table>

<table border="0" cellspacing="0" cellpadding="0" style="width:100%; margin-top:50px; font-size:12px;  font-family: Helvetica, sans-serif; ">

	<tr>

		<th style="border-bottom:1px solid black; text-align:left; padding:5px 0;">Description</th>

		<th style="border-bottom:1px solid black; text-align:right; padding:5px 0;">Quantity</th>

		<th style="border-bottom:1px solid black; text-align:right; padding:5px 0;">Unit Price<br>Excl. GST</th>
        
        <th style="border-bottom:1px solid black; text-align:right; padding:5px 0;">GST</th>
        
        <th style="border-bottom:1px solid black; text-align:right; padding:5px 0;">Amount<br>Excl. GST AUD</th>

	</tr>

	<tr>

		<td style="border-bottom:1px solid grey; text-align:left; padding:5px 0;">SUN Weihan<br>6 nights as standard homestay<br>16.09.17 - 21.09.17</td>

		<td style="border-bottom:1px solid grey; text-align:right;">6.00</td>

		<td style="border-bottom:1px solid grey; text-align:right;">46.00</td>
        
        <td style="border-bottom:1px solid grey; text-align:right;">GST Free</td>
        
        <td style="border-bottom:1px solid grey; text-align:right;">276.00</td>

	</tr>
    
    	<tr>

		<td style="border-bottom:1px solid grey; text-align:left; padding:5px 0;">SUN Weihan<br>6 nights as standard homestay<br>16.09.17 - 21.09.17</td>

		<td style="border-bottom:1px solid grey; text-align:right;">6.00</td>

		<td style="border-bottom:1px solid grey; text-align:right;">46.00</td>
        
        <td style="border-bottom:1px solid grey; text-align:right;">GST Free</td>
        
        <td style="border-bottom:1px solid grey; text-align:right;">276.00</td>

	</tr>
    
    	<tr>

		<td style="border-bottom:1px solid grey; text-align:left; padding:5px 0;">SUN Weihan<br>16.09.17 - 21.09.17</td>

		<td style="border-bottom:1px solid grey; text-align:right;">6.00</td>

		<td style="border-bottom:1px solid grey; text-align:right;">46.00</td>
        
        <td style="border-bottom:1px solid grey; text-align:right;">GST Free</td>
        
        <td style="border-bottom:1px solid grey; text-align:right;">276.00</td>

	</tr>
    
    	<tr>

		<td style="border-bottom:1px solid grey; text-align:left; padding:5px 0;">SUN Weihan<br>6 nights as standard homestay<br>16.09.17 - 21.09.17</td>

		<td style="border-bottom:1px solid grey; text-align:right;">6.00</td>

		<td style="border-bottom:1px solid grey; text-align:right;">46.00</td>
        
        <td style="border-bottom:1px solid grey; text-align:right;">GST Free</td>
        
        <td style="border-bottom:1px solid grey; text-align:right;">276.00</td>

	</tr>
    
      <tr>

		<td style=" "></td>

		<td style=""></td>

		<td style=""></td>
        
        <td style="text-align:right; padding:5px 0;">Subtotal</td>
        
        <td style="text-align:right;">912.00</td>

	</tr>
    
    <tr>

		<td style=" "></td>

		<td style=""></td>

		<td style="border-bottom:1px solid black;"></td>
        
        <td style="border-bottom:1px solid black; text-align:right; padding:5px 0;">Total GST Free</td>
        
        <td style="border-bottom:1px solid black; text-align:right;">0.00</td>

	</tr>
    
     <tr>

		<td style=" "></td>

		<td style=""></td>

		<td style=""></td>
        
        <td style="text-align:right; padding:5px 0;">Invoice Total AUD</td>
        
        <td style="text-align:right;">912.00</td>

	</tr>
    
    <tr>

		<td style=" "></td>

		<td style=""></td>

		<td style="border-bottom:2px solid black;"></td>
        
        <td style="border-bottom:2px solid black; text-align:right; padding:5px 0;">Total Net Payments AUD</td>
        
        <td style="border-bottom:2px solid black; text-align:right;">0.00</td>

	</tr>

<tr>

		<td style=" "></td>

		<td style=""></td>

		<td style=""></td>
        
        <td style="text-align:right; padding:5px 0;"><b>Amount Due AUD</b></td>
        
        <td style="text-align:right;"><b>912.00</b></td>

	</tr>

</table>

<table style="width:100%; font-size:12px;  font-family: Helvetica, sans-serif; ">

    <tr>
        
        <td style="padding:5px 0 10px;"><b>Due Date: 16 Sep 2017</b></td>

	</tr>
    
    <tr>
        
        <td style="">Bank Name: Westpac; Account Name: Global Experience; Branch Number (BSB): 032 324; Account Number: 192 180</td>

	</tr>

</table>


</body>

</html>