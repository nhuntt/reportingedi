<?php
// $title = 'View Record'; 
// $servername='127.0.0.1';
// $database='edi_solution';
// $username="root";
// $password="Xiu@16031977";

$conn = mysqli_connect('localhost', 'u269067746_root', 'Tonhu@1603', 'u269067746_EDI_SOLUTION');
// Check connection
if (mysqli_connect_error()){
    echo "connection fail".mysqli_connect_error();
}
else { echo "connection successfully";};


// $vCount_header = 0;
// if(!isset($_GET['EDIROWID'])){
//     echo "fail";
// } else{
//     $id = $_GET['EDIROWID'];
// }
// // $sql = "SELECT EDIROWID, SenderISA FROM Inbox ";
// $sql2 = "SELECT po.PODate, po.PurchaseOrderNumber, PO.CurrencyCode, PO.ExchangeRate,
// ADDBY.NAME as AD_Name_BY,ADDBY.CODE as AD_CODE_BY,ADDBY.ADDRESS1 as AD_ADDRESS1_BY,ADDBY.ADDRESS2 as AD_ADDRESS2_BY,ADDBY.CITY as AD_CITY_BY,ADDBY.STATE as AD_STATE_BY,ADDBY.POSTALCODE as AD_POSTALCODE_BY,ADDBY.COUNTRYCODE as AD_COUNTRYCODE_BY,
// ADDST.NAME as AD_Name_ST,ADDST.CODE as AD_CODE_ST,ADDST.ADDRESS1 as AD_ADDRESS1_ST,ADDST.ADDRESS2 as AD_ADDRESS2_ST,ADDST.CITY as AD_CITY_ST,ADDST.STATE as AD_STATE_ST,ADDST.POSTALCODE as AD_POSTALCODE_ST,ADDST.COUNTRYCODE as AD_COUNTRYCODE_ST,
// RFFDP.ReferenceIdentification as REFDP,RFFZZ.ReferenceIdentification as REFZZ,
// DT01.DATE as DT01 ,DT02.DATE as DT02,
// ACP.AC_INDICATOR as AC_INDICATOR_P,ACP.AMOUNT as AMOUNT_P,ACP.PERCENT as PERCENT_P,
// POL.ASSIGNED_IDENTIFICATION,POL.PRODUCT_CODE1,POL.PRODUCT_CODE2,POL.QUANTITY_ORDERED,POL.UNIT_PRICE,POL.Item_Description,
// ACL.AC_INDICATOR as AC_INDICATOR_L,ACL.AMOUNT as AMOUNT_L,ACL.PERCENT as PERCENT_L from Inbox INB 
// INNER join PURCHASE_ORDER PO on INB.EDIROWID=PO.EDIROWID
// LEFT JOIN ADDRESS_DB ADDBY on PO.ID=ADDBY.PO_ID
// LEFT JOIN ADDRESS_DB ADDST on PO.ID=ADDST.PO_ID
// LEFT JOIN REFERENCE_INFORMATION RFFDP ON PO.ID=RFFDP.PO_ID
// LEFT JOIN REFERENCE_INFORMATION RFFZZ ON PO.ID=RFFZZ.PO_ID
// LEFT JOIN DATETIMEINFORMATION DT01 ON PO.ID=DT01.PO_ID
// LEFT JOIN DATETIMEINFORMATION DT02 ON PO.ID=DT02.PO_ID
// LEFT JOIN ALLOWANCE_CHARGE_PO ACP ON PO.ID=ACP.PO_ID
// INNER JOIN PURCHASE_ORDER_LINEITEM POL ON PO.ID=POL.PO_ID
// LEFT JOIN ALLOWANCE_CHARGE_LINEITEM ACL ON POL.ID=ACL.LINE_ID

// WHERE INB.EDIROWID='$id'
// AND ADDBY.IDENTIFIER_CODE='BY'
// AND ADDST.IDENTIFIER_CODE='ST'
// AND RFFDP.ReferenceQualifier='DP'
// AND RFFZZ.ReferenceQualifier='ZZ'
// AND DT01.Qualifier='001'
// AND DT02.Qualifier='002'";
$vCount_header = 0;
if(!isset($_GET['EDIROWID'])){
    echo "fail";
} else{
    $id = $_GET['EDIROWID'];
    // echo $id;
}
// $sql = "SELECT EDIROWID, SenderISA FROM Inbox ";
$sql2 = "SELECT PO.PODate, PO.PurchaseOrderNumber, PO.CurrencyCode, PO.ExchangeRate,
ADDBY.NAME as AD_Name_BY,ADDBY.CODE as AD_CODE_BY,ADDBY.ADDRESS1 as AD_ADDRESS1_BY,ADDBY.ADDRESS2 as AD_ADDRESS2_BY,ADDBY.CITY as AD_CITY_BY,ADDBY.STATE as AD_STATE_BY,ADDBY.POSTALCODE as AD_POSTALCODE_BY,ADDBY.COUNTRYCODE as AD_COUNTRYCODE_BY,
ADDST.NAME as AD_Name_ST,ADDST.CODE as AD_CODE_ST,ADDST.ADDRESS1 as AD_ADDRESS1_ST,ADDST.ADDRESS2 as AD_ADDRESS2_ST,ADDST.CITY as AD_CITY_ST,ADDST.STATE as AD_STATE_ST,ADDST.POSTALCODE as AD_POSTALCODE_ST,ADDST.COUNTRYCODE as AD_COUNTRYCODE_ST,
RFFDP.ReferenceIdentification as REFDP,RFFZZ.ReferenceIdentification as REFZZ,
DT01.IFDATE as DT01 ,DT02.IFDATE as DT02,
ACP.AC_INDICATOR as AC_INDICATOR_P,ACP.AMOUNT as AMOUNT_P,ACP.PERCENT_ as PERCENT_P,
POL.ASSIGNED_IDENTIFICATION,POL.PRODUCT_CODE1,POL.PRODUCT_CODE2,POL.QUANTITY_ORDERED,POL.UNIT_PRICE,POL.Item_Description,
ACL.AC_INDICATOR as AC_INDICATOR_L,ACL.AMOUNT as AMOUNT_L,ACL.PERCENT_ as PERCENT_L from Inbox INB 
INNER join PURCHASE_ORDER PO on INB.EDIROWID=PO.EDIROWID
LEFT JOIN ADDRESS_DB ADDBY on PO.ID=ADDBY.PO_ID
LEFT JOIN ADDRESS_DB ADDST on PO.ID=ADDST.PO_ID
LEFT JOIN REFERENCE_INFORMATION RFFDP ON PO.ID=RFFDP.PO_ID
LEFT JOIN REFERENCE_INFORMATION RFFZZ ON PO.ID=RFFZZ.PO_ID
LEFT JOIN DATETIMEINFORMATION DT01 ON PO.ID=DT01.PO_ID
LEFT JOIN DATETIMEINFORMATION DT02 ON PO.ID=DT02.PO_ID
LEFT JOIN ALLOWANCE_CHARGE_PO ACP ON PO.ID=ACP.PO_ID
INNER JOIN PURCHASE_ORDER_LINEITEM POL ON PO.ID=POL.PO_ID
LEFT JOIN ALLOWANCE_CHARGE_LINEITEM ACL ON POL.ID=ACL.LINE_ID

WHERE INB.EDIROWID='$id'
AND ADDBY.IDENTIFIER_CODE='BY'
AND ADDST.IDENTIFIER_CODE='ST'
AND RFFDP.ReferenceQualifier='DP'
AND RFFZZ.ReferenceQualifier='ZZ'
AND DT01.Qualifier='001'
AND DT02.Qualifier='002'";
$result = $conn->query($sql2);
// if ($result->num_rows > 0) { 
//     // echo "<p>".$result."</p>";
//     echo "<table><tr><th>EDIROWID</th><th>SenderISA</th></tr>";
	
//      //output data of each row
//  	  while($row = $result->fetch_assoc()) { 
//       $vCount_header = $vCount_header + 1;}}
// 	  echo $vCount_header;
  ?>
  


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title>Purchase Order</title>
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p {margin-left: 20; font-family:"Trebuchet MS" }
		a.comment-indicator:hover + comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em;  } 
		a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em;  } 
		comment { display:none;  } 
	</style>
	
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
		<td align="left" valign=middle bgcolor="#7E9BCF"><font face="Arial" size=2>[VENDOR NAME]</font></td>
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
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20"  align="left" valign=middle bgcolor="#7E9BCF"><font face="Arial">CURRENTCY CODE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" width="100" valign=middle><font face="Arial"><?php echo $row["CurrencyCode"]; ?></font></td>
		<td align="left" width="200" valign=middle><font face="Arial"><br></font></td>
		<td align="right" valign=middle><font face="Arial">PO DATE</font></td>
		<td style="border-top: 1px solid #a6a6a6; border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" align="center" width="100" valign=middle sdnum="1033;1033;M/D/YYYY"><font face="Arial"><?php echo $row["PODate"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle bgcolor="#7E9BCF"><font face="Arial">EXCHANGE RATE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" width="100" valign=middle><font face="Arial"><?php echo $row["ExchangeRate"]; ?></font></td>
		<td align="left" width="200" valign=middle><font face="Arial"><br></font></td>
		<td align="right" valign=middle><font face="Arial">PO NUMBER</font></td>
		<td style="border-top: 1px solid #a6a6a6; border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" align="center" width="100" valign=middle><font face="Arial"><?php echo $row["PurchaseOrderNumber"]; ?></font></td>
	</tr>
</table>
<table cellspacing="0" border="0">
	<tr>
		<td height="20" align="left" valign=middle><font face="Arial"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign=middle><font face="Arial"><br></font></td>
	</tr>
</table>
<table cellspacing="0" border="0">
	<tr>
		<td height="24" align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">BUYER</font></b></td>
		<td align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF"><br></font></b></td>
		<td align="left" width ="200" valign=middle><font face="Arial"><br></font></td>
		<td align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">SHIP TO</font></b></td>
		<td align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF"><br></font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">Name</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_Name_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">Name</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_Name_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">BuyerCode</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_CODE_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">Code</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_CODE_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">Street</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_ADDRESS1_BY"].", ".$row["AD_ADDRESS2_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">Street</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_ADDRESS1_ST"].", ".$row["AD_ADDRESS2_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">CITY</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_CITY_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">CITY</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_CITY_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">STATE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_STATE_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">STATE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_STATE_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">ZIPCODE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_POSTALCODE_BY"]; ?></font></td>
		<td align="left" valign=middle><font face="Arial"><br></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">ZIPCODE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $row["AD_POSTALCODE_ST"]; ?></font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle bgcolor="#D4DEEF"><font face="Arial">POSTAL CODE</font></td>
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
		<td style="border-top: 1px solid #3b4e87; border-bottom: 1px solid #3b4e87; border-left: 1px solid #3b4e87" height="24" align="center" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">DEPARTMENT NO</font></b></td>
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
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="24" align="center" valign=middle><font face="Arial"><?php echo $row["REFDP"]; ?></font></td>
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
		<td height="20" align="left" valign=middle><br></td>
	</tr>
	</table>
<table cellspacing="0" border="0">
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="24" align="center" valign=middle bgcolor="#3B4E87" sdnum="1033;0;0.00%"><b><font face="Arial" color="#FFFFFF">ITEM #</font></b></td>
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
		<td style="border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" height="20" align="left" valign=middle><font face="Arial"><?php echo $row["ASSIGNED_IDENTIFICATION"]; ?></font></td>
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
		<td style="border-top: 1px solid #000000" colspan=4 height="24" align="center" valign=middle><br></td>
		<td style="border-top: 1px solid #000000" align="left" valign=middle><font size=1 color="#FFFFFF">[42]</font></td>
		<td style="border-top: 1px solid #000000" align="left" valign=middle><font face="Arial">SUBTOTAL</font></td>
		<td style="border-top: 1px solid #000000" align="right" valign=middle bgcolor="#F2F2F2" sdval="0" sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><font face="Arial"> <?php echo $vsubtotal; ?>d  </font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #a6a6a6; border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="24" align="left" valign=middle bgcolor="#BFBFBF"><b><font face="Arial">Comments or Special Instructions</font></b></td>
		<td align="left" valign=middle><font size=1 color="#FFFFFF"><br></font></td>
		<td align="left" valign=middle><font face="Arial">TAX</font></td>
		<td style="border-top: 1px solid #c0c0c0; border-bottom: 1px solid #c0c0c0; border-left: 1px solid #c0c0c0; border-right: 1px solid #c0c0c0" align="right" valign=middle sdval="0" sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><font face="Arial"> -   </font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=middle><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="24" align="left" valign=middle><font face="Arial">REF02 (REF01=ZZ)</font></td>
		<td align="left" valign=middle><br></td>
		<td align="left" valign=middle><font face="Arial">SHIPPING</font></td>
		<td style="border-top: 1px solid #c0c0c0; border-bottom: 1px solid #c0c0c0; border-left: 1px solid #c0c0c0; border-right: 1px solid #c0c0c0" align="right" valign=middle sdval="0" sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><font face="Arial"> -   </font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=middle><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="24" align="left" valign=middle><font face="Arial"><br></font></td>
		<td align="left" valign=middle><br></td>
		<td style="border-bottom: 2px double #000000" align="left" valign=middle><font face="Arial">OTHER</font></td>
		<td style="border-top: 1px solid #c0c0c0; border-left: 1px solid #c0c0c0; border-right: 1px solid #c0c0c0" align="right" valign=middle sdval="0" sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><font face="Arial"> -   </font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="24" align="left" valign=middle><font face="Arial"><br></font></td>
		<td align="left" valign=middle><br></td>
		<td align="left" valign=middle><b><font face="Arial">TOTAL</font></b></td>
		<td style="border-top: 2px double #000000" align="right" valign=middle bgcolor="#A7B3D9" sdval="0" sdnum="1033;0;_(&quot;$&quot;* #,##0.00_);_(&quot;$&quot;* \(#,##0.00\);_(&quot;$&quot;* &quot;-&quot;??_);_(@_)"><b><font face="Arial"> <?php  echo $total=$vsubtotal; ?>   </font></b></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=middle><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="24" align="left" valign=middle><font face="Arial"><br></font></td>
		<td align="left" valign=middle><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="24" align="left" valign=middle><font face="Arial"><br></font></td>
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