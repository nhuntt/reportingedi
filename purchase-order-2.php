<?php
session_start();
$uname = $_SESSION['User'];
echo $uname;
// $dsn="mysql:host=localhost;dbname=edi_solution";
$conn = mysqli_connect('localhost', 'u269067746_root', 'Tonhu@1603', 'u269067746_EDI_SOLUTION');
// Check connection
if (mysqli_connect_error()){
    echo "connection fail".mysqli_connect_error();
}
else { echo "connection successfully";};
if ($conn->connect_error) {
    die("Connection failed: " 
        . $conn->connect_error);
}
    echo "Connected successfully"."<br>";
    $sql_RecISA = "select cp.ISA_ID from Customer_Profile cp inner join ACCOUNT_WEB_SUPPLIER acw on cp.CustomerID = acw.CustomerID where acw.UserName_web = '$uname' ";
    $result_RecISA = $conn->query($sql_RecISA);
    while($row_RecISA = $result_RecISA->fetch_assoc()) {
      echo $row_RecISA["ISA_ID"];
    }
    $sql = "select * from Inbox inb inner join Customer_Profile cp on inb.ReceiveISA = cp.ISA_ID inner join ACCOUNT_WEB_SUPPLIER acw on cp.CustomerID = acw.CustomerID where acw.UserName_web = '$uname'";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<body>
<?php if ($result->num_rows > 0){
    $vsubtotal=0;
        while($row = $result->fetch_assoc()) { 
            $vCount_header = $vCount_header + 1;
            if ($vCount_header == 1) {
                $vGeneral_Comments = $row["REFZZ"];?>
<table cellspacing="0" border="0">
	<tr>
		<td align="left" valign=middle bgcolor="#7E9BCF"><font face="Arial" size=2 style="text-transform:uppercase;"><?php echo $uname ?></font></td>
		<td align="left" width="100"valign=bottom><br></td>
		<td align="left" width="100"valign=bottom><br></td>
		<td align="right" valign=bottom><b><font face="Arial" size=6 color="#7B8EC5">PURCHASE ORDER</font></b></td>
	</tr>
</table>
<table cellspacing="0" border="0" height = "40">
	<tr>
		<td></td>
	</tr>
</table>
<table cellspacing="0" border="0">
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="30"  align="left" valign=middle bgcolor="#7E9BCF"><font face="Arial">CURRENTCY CODE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" width="100" valign=middle><font face="Arial"><?php echo $row["CurrencyCode"]; ?></font></td>
		<td align="left" width="200" valign=middle><font face="Arial"><br></font></td>
		<td align="right" valign=middle><font face="Arial">PO DATE</font></td>
		<td style="border-top: 1px solid #a6a6a6; border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" align="center" width="100" valign=middle sdnum="1033;1033;M/D/YYYY"><font face="Arial"><?php echo $row["PODate"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="30" align="left" valign=middle bgcolor="#7E9BCF"><font face="Arial">EXCHANGE RATE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" width="100" valign=middle><font face="Arial"><?php echo $row["ExchangeRate"]; ?></font></td>
		<td align="left" width="200" valign=middle><font face="Arial"><br></font></td>
		<td align="right" valign=middle><font face="Arial">PO NUMBER</font></td>
		<td style="border-top: 1px solid #a6a6a6; border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" align="center" width="100" valign=middle><font face="Arial"><?php echo $row["PurchaseOrderNumber"]; ?></font></td>
	</tr>
</table>
<table cellspacing="0" border="0">
	<tr>
		<td height="30" align="left" valign=middle><font face="Arial"><br></font></td>
	</tr>
	<tr>
		<td height="30" align="left" valign=middle><font face="Arial"><br></font></td>
	</tr>
</table>
<table cellspacing="0" border="0">
	<tr>
		<td height="34" align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">BUYER</font></b></td>
		<td align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF"><br></font></b></td>
		<td align="left" width ="200" valign=middle><font face="Arial"><br></font></td>
		<td align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">SHIP TO</font></b></td>
		<td align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="30" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">Name</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_Name_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">Name</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_Name_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="30" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">BuyerCode</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_CODE_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">Code</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_CODE_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="30" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">Street</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_ADDRESS1_BY"].", ".$row["AD_ADDRESS2_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">Street</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_ADDRESS1_ST"].", ".$row["AD_ADDRESS2_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="30" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">CITY</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_CITY_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">CITY</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_CITY_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="30" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">STATE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_STATE_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">STATE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_STATE_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="30" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">ZIPCODE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_POSTALCODE_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">ZIPCODE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_POSTALCODE_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="30" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">POSTAL CODE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_COUNTRYCODE_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">POSTAL CODE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_COUNTRYCODE_ST"]; ?></font></td>
	</tr>
</table>
<table cellspacing="0" border="0">
	<tr>
		<td height="40" align="left" valign=middle><font face="Arial"><br></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #3b4e87; border-bottom: 1px solid #3b4e87; border-left: 1px solid #3b4e87" height="34" align="center" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">DEPARTMENT NO</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">EXPECTED DELIVERY DATE</font></b></td>
		<td style="border-top: 1px solid #3b4e87; border-bottom: 1px solid #3b4e87" align="center" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">CANCEL AFTER</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">A/C IDENTIFY</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">AMOUNT</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">PERCENT</font></b></td>
		<td align="left" valign=middle><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="34" align="center" valign=middle><font face="Arial"><?php echo $row["REFDP"]; ?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["DT01"]; ?></font></td>
		<td style="border-top: 1px solid #3b4e87; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["DT02"]; ?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><font face="Arial"><?php echo $row["AC_INDICATOR_P"]; ?><?php $AC_INDICATOR_P = $row["AC_INDICATOR_P"]; ?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AMOUNT_P"]; ?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["PERCENT_P"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=middle><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td height="30" align="left" valign=middle><br></td>
	</tr>
	</table>
<table cellspacing="0" border="0">
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="34" align="center" valign=middle bgcolor="#3B4E87" sdnum="1033;0;0.00%"><b><font face="Arial" color="#FFFFFF">ITEM #</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#3B4E87" sdnum="1033;0;0.00%"><b><font face="Arial" color="#FFFFFF">PRODUCTCODE1</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#3B4E87" sdnum="1033;0;0.00%"><b><font face="Arial" color="#FFFFFF">PRODUCTCODE2</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#3B4E87" sdnum="1033;0;0.00%"><b><font face="Arial" color="#FFFFFF">DESCRIPTION</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">QTY</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">UNIT PRICE</font></b></td>
	
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">TOTAL</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">A/C IDENTIFY</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">AMOUNT</font></b></td>

		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">PERCENT</font></b></td>
		

	</tr>
	<?php } ?>
	<tr>
		<td style="border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" height="30" align="left" valign=middle><font face="Arial"><?php echo $row["ASSIGNED_IDENTIFICATION"]; ?></font></td>
		<td style="border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["PRODUCT_CODE1"]; ?></font></td>
		<td style="border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["PRODUCT_CODE2"]; ?></font></td>
		<td style="border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["Item_Description"]; ?></font></td>
		<td style="border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><font face="Arial"><?php $vQuantity = $row["QUANTITY_ORDERED"]; echo $vQuantity; ?></font></td>
		<td style="border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=middle sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><font face="Arial"> <?php $vUnit_Price = $row["UNIT_PRICE"]; echo $row["UNIT_PRICE"]; ?> </font></td>
		<td style="border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#F2F2F2" sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><font face="Arial"> <?php $AC=$row["AC_INDICATOR_L"];$Amount=$row["AMOUNT_L"];$Per=$row["PERCENT_L"] ; $Price = $vUnit_Price;$Per2=($Price/100)*$Per; $Price = $Price*$vQuantity;if ($AC =="A") {$Price = $Price -$Amount-$Per2;} elseif($AC =="C") {$Price = $Price +$Amount+$Per2;};$vsubtotal = $vsubtotal + $Price; echo $Price; ?> </font></td>
		<td style="border-top: 1px solid #d9d9d9; border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><font face="Arial"><br></font><?php  echo $row["AC_INDICATOR_L"]; ?></td>
		<td style="border-top: 1px solid #d9d9d9; border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><font face="Arial"><br></font><?php  echo $row["AMOUNT_L"]; ?></td>
		<td style="border-top: 1px solid #d9d9d9; border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><font face="Arial"><br></font><?php  echo $row["PERCENT_L"]; ?></td>
		

	</tr>
	<?php } ?>
	<tr>
		<td style="border-top: 1px solid #000000" colspan=4 height="34" align="center" valign=middle><br></td>
		<td style="border-top: 1px solid #000000" align="left" valign=middle><font size=1 color="#FFFFFF">[42]</font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=middle><font face="Arial">SUBTOTAL</font></td>
		<td style="border-top: 1px solid #000000" align="right" valign=middle bgcolor="#F2F2F2" sdval="0" sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><font face="Arial"> <?php echo $vsubtotal; ?>d  </font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #a6a6a6; border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="34" align="left" valign=middle bgcolor="#BFBFBF"><b><font face="Arial">Comments or Special Instructions</font></b></td>
		<td align="left" valign=middle><font size=1 color="#FFFFFF"><br></font></td>
		<td align="left" valign=middle><font face="Arial">TAX</font></td>
		<td style="border-top: 1px solid #c0c0c0; border-bottom: 1px solid #c0c0c0; border-left: 1px solid #c0c0c0; border-right: 1px solid #c0c0c0" align="right" valign=middle sdval="0" sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><font face="Arial"> -   </font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=middle><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="34" align="left" valign=middle><font face="Arial">REF02 (REF01=ZZ)</font></td>
		<td align="left" valign=middle><br></td>
		<td align="left" valign=middle><font face="Arial">SHIPPING</font></td>
		<td style="border-top: 1px solid #c0c0c0; border-bottom: 1px solid #c0c0c0; border-left: 1px solid #c0c0c0; border-right: 1px solid #c0c0c0" align="right" valign=middle sdval="0" sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><font face="Arial"> -   </font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=middle><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="34" align="left" valign=middle><font face="Arial"><br></font></td>
		<td align="left" valign=middle><br></td>
		<td style="border-bottom: 2px double #000000" align="left" valign=middle><font face="Arial">OTHER</font></td>
		<td style="border-top: 1px solid #c0c0c0; border-left: 1px solid #c0c0c0; border-right: 1px solid #c0c0c0" align="right" valign=middle sdval="0" sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><font face="Arial"> -   </font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="34" align="left" valign=middle><font face="Arial"><br></font></td>
		<td align="left" valign=middle><br></td>
		<td align="left" valign=middle><b><font face="Arial">TOTAL</font></b></td>
		<td style="border-top: 2px double #000000" align="right" valign=middle bgcolor="#A7B3D9" sdval="0" sdnum="1033;0;_(&quot;$&quot;* #,##0.00_);_(&quot;$&quot;* \(#,##0.00\);_(&quot;$&quot;* &quot;-&quot;??_);_(@_)"><b><font face="Arial"> <?php  echo $total=$vsubtotal; ?>   </font></b></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=middle><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="34" align="left" valign=middle><font face="Arial"><br></font></td>
		<td align="left" valign=middle><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="34" align="left" valign=middle><font face="Arial"><br></font></td>
		<td align="left" valign=middle><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
	</tr>
</table>
<?php } ?>
<!-- ************************************************************************** -->
</body>

</html>