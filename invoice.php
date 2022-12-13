<?php
session_start();
$uname = $_SESSION['User'];
// echo $uname."<br>";

$title = 'View Record'; 
$conn = mysqli_connect('localhost', 'u269067746_root', 'Tonhu@1603', 'u269067746_EDI_SOLUTION');
// Check connection
if (mysqli_connect_error()){
    echo "connection fail".mysqli_connect_error();
}
// else { echo "connection successfully";};
if ($conn->connect_error) {
    die("Connection failed: " 
        . $conn->connect_error);
}
    // echo "Connected successfully"."<br>";

$vCount_header = 0;
if(!isset($_GET['EDIROWID'])){
    echo "fail";
} else{
    $id = $_GET['EDIROWID'];
}


// ------------------------------Get data from PO------------------
// $sql = "SELECT EDIROWID, SenderISA FROM Inbox ";
$sql2 = "SELECT PO.PODate, PO.PurchaseOrderNumber, PO.CurrencyCode, PO.ExchangeRate,
ADDBY.NAME as AD_Name_BY,ADDBY.CODE as AD_CODE_BY,ADDBY.ADDRESS1 as AD_ADDRESS1_BY,ADDBY.ADDRESS2 as AD_ADDRESS2_BY,ADDBY.CITY as AD_CITY_BY,ADDBY.STATE as AD_STATE_BY,ADDBY.POSTALCODE as AD_POSTALCODE_BY,ADDBY.COUNTRYCODE as AD_COUNTRYCODE_BY,
ADDST.NAME as AD_Name_ST,ADDST.CODE as AD_CODE_ST,ADDST.ADDRESS1 as AD_ADDRESS1_ST,ADDST.ADDRESS2 as AD_ADDRESS2_ST,ADDST.CITY as AD_CITY_ST,ADDST.STATE as AD_STATE_ST,ADDST.POSTALCODE as AD_POSTALCODE_ST,ADDST.COUNTRYCODE as AD_COUNTRYCODE_ST,
RFFDP.ReferenceIdentification as REFDP,RFFZZ.ReferenceIdentification as REFZZ,
DT01.IFDATE as DT01 ,DT02.IFDATE as DT02,
ACP.AC_INDICATOR as AC_INDICATOR_P,ACP.AMOUNT as AMOUNT_P,ACP.PERCENT_ as PERCENT_P,
POL.ASSIGNED_IDENTIFICATION,POL.PRODUCT_CODE1,POL.PRODUCT_CODE2,POL.QUANTITY_ORDERED AS QUANTITY_ORDERED,POL.UNIT_PRICE,POL.Item_Description,
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
AND DT02.Qualifier='002'

";
$result = $conn->query($sql2);
$resultPO = $conn->query($sql2);
$resultIT=$conn->query($sql2);
$resultPOCode=$conn->query($sql2);

if ($resultPO->num_rows > 0){
    $vsubtotal=0;
        while($row = $resultPO->fetch_assoc()) { 
$PODate= $row["PODate"];
$PONumber= $row["PurchaseOrderNumber"];
$REFDP=$row["REFDP"];
$AD_Name_BY_N102=$row["AD_Name_BY"];
$AD_Name_ST_N102=$row["AD_Name_ST"];
$AD_CODE_BY_N104=$row["AD_CODE_BY"];
$AD_CODE_ST_N104=$row["AD_CODE_ST"];
$N103="92";
$AD_STREET_BY_N301=$row["AD_ADDRESS1_BY"];
$AD_STREET_BY_N302=$row["AD_ADDRESS2_BY"];
$AD_STREET_ST_N301=$row["AD_ADDRESS1_ST"];
$AD_STREET_ST_N302=$row["AD_ADDRESS2_ST"];
$AD_CITY_BY_N401=$row["AD_CITY_BY"];
$AD_CITY_ST_N401=$row["AD_CITY_ST"];
$AD_STATE_BY_N402=$row["AD_STATE_BY"];
$AD_STATE_ST_N402=$row["AD_STATE_ST"];
$AD_POSTALCODE_BY_N403=$row["AD_POSTALCODE_BY"];
$AD_POSTALCODE_ST_N403=$row["AD_POSTALCODE_ST"];
$AD_COUNTRYCODE_BY_N404=$row["AD_COUNTRYCODE_BY"];
$AD_COUNTRYCODE_ST_N404=$row["AD_COUNTRYCODE_ST"];
$CUR02=$row["CurrencyCode"];
$CUR03=$row["ExchangeRate"];
$QTY=$ROW["QUANTITY_ORDERED"];
		}}

$sql_findinvoiceno="SELECT CI.COUNT_INVOICE 
FROM count_invoice CI INNER JOIN ACCOUNT_WEB_SUPPLIER AWS
ON CI.CUST_ID = AWS.CustomerID
WHERE AWS.USERNAME_WEB = '$uname'";

$result_countinvce = $conn->query($sql_findinvoiceno);
if ($result_countinvce->num_rows > 0){
	while($row_countline = $result_countinvce->fetch_assoc()) { 
		 $count_line =  $row_countline["COUNT_INVOICE"] + 1;
	 }
}
// echo $count_line."<br>";
$sql_getData="SELECT 	ti.TaxTypeCode,ti.MonetaryAmount,ti.Percent
FROM taxinformation ti
inner join ACCOUNT_WEB_SUPPLIER aws on ti.CustomerID= aws.CustomerID
WHERE aws.UserName_web='$uname'";

$result_getData = $conn->query($sql_getData);
// echo $sql_getData;
if ($result_getData->num_rows > 0){
	while($row_getData = $result_getData->fetch_assoc()) { 
		 $getTaxTypeCode =  $row_getData["TaxTypeCode"];
		 $getMonetaryAmount =  $row_getData["MonetaryAmount"];
		 $getPercent =  $row_getData["Percent"];
	 }
}

// ------------- Create ISA and GS ----------
$sql_getISA="SELECT SenderISA,ReceiveISA
FROM `Inbox` 
WHERE EDIROWID='$id'";

$result_getISA = $conn->query($sql_getISA);
//echo $sql_getISA;
if ($result_getISA ->num_rows > 0){
	while($row_getISA = $result_getISA->fetch_assoc()) { 
		 $ReceiverCust =  $row_getISA["SenderISA"];
		 $SenderCust =  $row_getISA["ReceiveISA"];
	 }
}
$sql_GetHubinfor = "SELECT * from Customer_Profile 
where ISA_ID = '$ReceiverCust'";

$result_Gethub = $conn->query($sql_GetHubinfor);
if ($result_Gethub ->num_rows > 0){
	while($row_getHub = $result_Gethub->fetch_assoc()) { 
		 $hub_ISA = $row_getHub["ISA_ID"];
		 $hub_IDQual = $row_getHub["IDQualifier"];
		 $ISA12 = $row_getHub["InterchangeControlVersion"];
		 $hub_GS = $row_getHub["OutGSID"];
		 $GS08 = $row_getHub["VersionIdentify"];
		 $segment_char = $row_getHub["SegmentSeparator"];
		 $element_char = $row_getHub["ElementSeparator"];
		 $ISA09_Date = date("ymd");
		 $ISA10_Time = date("Hi");
		 $GS04_Date = date("Ymd");
		 $GS05_Time = date("His");		 
	 }
}
//---------------
$sql_Get_custID="SELECT CustomerID from ACCOUNT_WEB_SUPPLIER where UserName_web = '$uname'";
$result_Get_custID = $conn->query($sql_Get_custID);
if ($result_Get_custID ->num_rows > 0){
	while($row_Get_custID = $result_Get_custID->fetch_assoc()) { 
	    $vendor_ID2= $row_Get_custID["CustomerID"];
	 }
}


$sql_GetVendorinfor = "SELECT * from Customer_Profile 
where ISA_ID = '$SenderCust'";

$result_GetVendor = $conn->query($sql_GetVendorinfor);
if ($result_GetVendor ->num_rows > 0){
	while($row_getVendor = $result_GetVendor->fetch_assoc()) { 
	    $vendor_ID= $row_getVendor["CustomerID"];
		 $vendor_ISA = $row_getVendor["ISA_ID"];
		 $vendor_IDQual = $row_getVendor["IDQualifier"];
		 $vendor_GS = $row_getVendor["OutGSID"];
		 
// 		 echo "cusID".$vendor_ID;
		 //$ISA12 = $row_getHub["InterchangeControlVersion"];
	 }
}
//SELECT COUNT ENVELOPE
$sql_CountEnvelope = "SELECT CountEnvelope from countenvelopecontrolnumber";
$result_countEnvelope = $conn->query($sql_CountEnvelope);
if ($result_countEnvelope ->num_rows > 0){
	while($row_countEnvelope = $result_countEnvelope->fetch_assoc()) { 
		 $countEnvelope = $row_countEnvelope["CountEnvelope"];
	 }
}
// echo $countEnvelope."<br>";
//-----------------------------------------------------------------------------------


function CreateSegment($anArray, $separator, $Segmentname){
	foreach ($anArray as $element){
	$Segmentname = $Segmentname.$separator.$element;
	}
	return $Segmentname. "^";
	}
	$ISA_array= array("00","          ","00","          ",$vendor_IDQual,str_pad($vendor_ISA, 15, " "), $hub_IDQual,str_pad($hub_ISA, 15, " "), $ISA09_Date,$ISA10_Time,$countEnvelope,$ISA12);
	$GS_array=array("IN",$vendor_ISA,$hub_ISA,$GS04_Date,$GS05_Time,$countEnvelope,"X",$GS08);
	$ST_array=array("810",$countEnvelope);
	//$newdate = date("Ymd", strtotime($PODate));
	$BIG_array=array(date("Ymd"), "INV-".$count_line,$newdate = date("Ymd", strtotime($PODate)),$PONumber);
	$CUR_array =array("01",$CUR02,$CUR03);
	$REF_array=array("DP",$REFDP);
	$N1_BT_array=array("BT",$AD_Name_BY_N102,$N103,$AD_CODE_BY_N104);
	$N1_ST_array=array("ST",$AD_Name_ST_N102,$N103,$AD_CODE_ST_N104);
	$N3_BT_array=array($AD_STREET_BY_N301,$AD_STREET_BY_N302);
	$N3_ST_array=array($AD_STREET_ST_N301,$AD_STREET_ST_N302);
	$N4_BT_array=array($AD_CITY_BY_N401,$AD_STATE_BY_N402,$AD_POSTALCODE_BY_N403,$AD_COUNTRYCODE_BY_N404);
	$N4_ST_array=array($AD_CITY_ST_N401,$AD_STATE_ST_N402,$AD_POSTALCODE_ST_N403,$AD_COUNTRYCODE_ST_N404);
	
	
	$ISA=CreateSegment($ISA_array,$element_char,'ISA');
	$GS=CreateSegment($GS_array,$element_char,'GS');
	$ST=CreateSegment($ST_array,$element_char,'ST');
	$BIG=CreateSegment($BIG_array,$element_char,'BIG');
	$REF=CreateSegment($REF_array,$element_char,'REF');
	$CUR=CreateSegment($CUR_array,$element_char,'CUR');
	$N1_BT=CreateSegment($N1_BT_array,$element_char,'N1');
	$N3_BT=CreateSegment($N3_BT_array,$element_char,'N3');
	$N4_BT=CreateSegment($N4_BT_array,$element_char,'N4');
	$N1_ST=CreateSegment($N1_ST_array,$element_char,'N1');
	$N3_ST=CreateSegment($N3_ST_array,$element_char,'N3');
	$N4_ST=CreateSegment($N4_ST_array,$element_char,'N4');
// 	$SAC=CreateSegment($SAC_array,$element_char,'SAC');
	
	if ($resultIT->num_rows > 0){
		$vsubtotal=0;
		$IT_Loop='';
			while($row = $resultIT->fetch_assoc()) { 
				$ASSIGNED_IDENTIFICATION_IT101=$row["ASSIGNED_IDENTIFICATION"];
				$QUANTITY_INVOICED=$row["QUANTITY_ORDERED"];
				$UOM="EA";
				$UNIT_PRICE=$row["UNIT_PRICE"];
				$PRODUCT_QUALIFIER1_IE106="BP";
				$PRODUCT_CODE1_IT107=$row["PRODUCT_CODE1"];
				$PRODUCT_QUALIFIER2_IE108="BN";
				$PRODUCT_CODE1_IT109=$row["PRODUCT_CODE2"];
				$PRODUCT_QUALIFIER2_IT110="";
				$PRODUCT_CODE1_IT111="";
				$PRODUCT_QUALIFIER2_IE112="";
				$PRODUCT_CODE1_IT113="";
				$PRODUCT_QUALIFIER2_IE114="";
				$PRODUCT_CODE1_IT115="";
				$PRODUCT_QUALIFIER2_IE116="";
				$PRODUCT_CODE1_IT117="";
				$PRODUCT_QUALIFIER2_IE118="";
				$PRODUCT_CODE1_IT119="";
				$PRODUCT_QUALIFIER2_IE120="";
				$PRODUCT_CODE1_IT121="";
				$PRODUCT_QUALIFIER2_IE122="";
				$PRODUCT_CODE1_IT123="";
				$PRODUCT_QUALIFIER2_IE124="";
				$PRODUCT_CODE1_IT125="";
				$IT1_array= array($ASSIGNED_IDENTIFICATION_IT101,$QUANTITY_INVOICED,$UOM,$UNIT_PRICE,"",$PRODUCT_QUALIFIER1_IE106,$PRODUCT_CODE1_IT107,$PRODUCT_QUALIFIER2_IE108,$PRODUCT_CODE1_IT109,$PRODUCT_QUALIFIER2_IT110,$PRODUCT_CODE1_IT111,$PRODUCT_QUALIFIER2_IE112,$PRODUCT_CODE1_IT113,$PRODUCT_QUALIFIER2_IE114,$PRODUCT_CODE1_IT115,$PRODUCT_QUALIFIER2_IE116,$PRODUCT_CODE1_IT117,$PRODUCT_QUALIFIER2_IE118,$PRODUCT_CODE1_IT119,$PRODUCT_QUALIFIER2_IE120,$PRODUCT_CODE1_IT121,$PRODUCT_QUALIFIER2_IE122,$PRODUCT_CODE1_IT123,$PRODUCT_QUALIFIER2_IE124,$PRODUCT_CODE1_IT125);
				$IT1=CreateSegment($IT1_array,$element_char,'IT1');
				// echo $IT1."<br>";
				$IT_Loop=$IT_Loop.$IT1;
				// echo $IT_Loop;

				$AC_INDICATOR_SAC01=$row["AC_INDICATOR_L"];
				$AC_CODE_L_SAC02=$row["AC_CODE_L"];
				$AGENCY_QUALIFIER_CODE_L_SAC03=$row["AGENCY_QUALIFIER_CODE_L"];
				$AGENCY_AC_CODE_SAC04=$row["AGENCY_AC_CODE_L"];
				$AMOUNT_L_SAC05=$row["AMOUNT_L"];
				$PERCENT_QUALIFIER_L_SAC06=$row["PERCENT_QUALIFIER_L"];
				$PERCENT_L_SAC07=$row["PERCENT_L"];
				$RATE_L_SAC08=$row["RATE_L"];
				$UOM_L_SAC09=$row["UOM_L"];
				$Quantity_L_SAC10=$row["Quantity_L"];
				$SAC_array= array($AC_INDICATOR_SAC01,$AC_CODE_L_SAC02,$AGENCY_QUALIFIER_CODE_L_SAC03,$AGENCY_AC_CODE_SAC04,$AMOUNT_L_SAC05,$PERCENT_QUALIFIER_L_SAC06,$PERCENT_L_SAC07,$RATE_L_SAC08,$UOM_L_SAC09,$Quantity_L_SAC10);
				$SAC=CreateSegment($SAC_array,$element_char,'SAC');
				
				$SAC_loop=$SAC_loop.$SAC;
				$EDIFULLMESSAGE=$ISA.$GS.$ST.$BIG.$CUR.$REF.$N1_BT.$N3_BT.$N4_BT.$N1_ST.$N3_ST.$N4_ST.$IT_Loop.$SAC_loop;
			}
			// echo $IT1;
		}
// 		echo $EDIFULLMESSAGE."<br>";


  ?>
  
<?php 
if(isset($_POST['Create'])){
$sql="UPDATE count_invoice
            SET COUNT_INVOICE = '$count_line'
            WHERE CUST_ID='$vendor_ID2'";
            mysqli_query($conn, $sql);
chdir("./../../");
$dir = getcwd();
echo $dir."<br>";
// chdir('domains');
chdir('edisolution.online');
$dir2 = getcwd();
// echo $dir2."<br>";
chdir("Outbox");
$dir3 = getcwd();
// echo $dir3."<br>";

$myfile = fopen("810.txt", "w") or die("Unable to open file!");

$content=fwrite($myfile, $EDIFULLMESSAGE);
// echo "noi dung EDI truoc khi viet file:".$EDIFULLMESSAGE. "/<br>";
fclose($myfile);

}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title>INVOICE</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
		<td align="left" valign=middle bgcolor="#7E9BCF"><font face="Arial" size= 3 style="text-transform:uppercase;"><?php echo $uname ?></font></td>
		<td align="left" width="100"valign=bottom><br></td>
		<td align="left" width="100"valign=bottom><br></td>
		<td align="right" valign=bottom><b><font face="Arial" size=6 color="#7B8EC5">INVOICE</font></b></td>
		<td>
		    <a href="getData.php">
            <i class='bx bx-log-out'style="margin-left:300px"></i>
            <span class="links_name" <font color="#7B8EC5">MENU</font></span>
          </a>
		</td>
	</tr>
</table>
<table cellspacing="0" border="0" height = "40">
	<tr>
		<td></td>
	</tr>
</table>
<table cellspacing="0" border="0">
	<tr>
	<td align="right" valign=middle><font face="Arial">INVOICE DATE</font></td>
		<td style="border-top: 1px solid #a6a6a6; border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" align="center" width="100" valign=middle sdnum="1033;1033;M/D/YYYY"><font face="Arial"><?php echo  date("Y/m/d") . "<br>"; ?></font></td>
		<td align="left" width="200" valign=middle><font face="Arial"><br></font></td>
		<td align="right" valign=middle><font face="Arial">PO DATE</font></td>
		<td style="border-top: 1px solid #a6a6a6; border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" align="center" width="100" valign=middle sdnum="1033;1033;M/D/YYYY"><font face="Arial"><?php echo $row["PODate"]; ?></font></td>
	</tr>
	<tr>
	<td align="right" valign=middle><font face="Arial">INVOICE NUMBER</font></td>
		<td style="border-top: 1px solid #a6a6a6; border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" align="center" width="100" valign=middle sdnum="1033;1033;M/D/YYYY"><font face="Arial"><?php echo "INV-".$count_line; ?></font></td>
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
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF"><font face="Arial">EXCHANGE RATE</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF"><font face="Arial">CURRENTCY CODE</font></td>

		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">TAX_1</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">TAX_2</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle bgcolor="#3B4E87"><b><font face="Arial" color="#FFFFFF">TAX_3</font></b></td>
		<td align="left" valign=middle><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
		<td align="left" valign=bottom><font face="Arial" color="#3B4E87"><br></font></td>
		<td align="left" valign=bottom><br></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="24" align="center" valign=middle><font face="Arial"><?php echo $row["REFDP"]; ?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" width="100" valign=middle><font face="Arial"><?php echo $row["ExchangeRate"]; ?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" width="100" valign=middle><font face="Arial"><?php echo $row["CurrencyCode"]; ?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><font face="Arial"><?php echo $getTaxTypeCode; ?></font></td>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $getMonetaryAmount; ?></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php echo $getPercent; ?></font></td>
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
		<td style="border-bottom: 1px solid #d9d9d9; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle><font face="Arial"><?php $PO_Code_pur=$row["PRODUCT_CODE1"]; echo $row["PRODUCT_CODE1"]; ?></font></td>
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
		<td style="border-top: 1px solid #000000" align="right" valign=middle bgcolor="#F2F2F2" sdval="0" sdnum="1033;0;_(* #,##0.00_);_(* \(#,##0.00\);_(* &quot;-&quot;??_);_(@_)"><font face="Arial"> <?php echo $vsubtotal; ?>  </font></td>
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
		<td style="border-top: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="24" align="left" valign=middle><font face="Arial"><input type="text" name="" value="" id=""</font></td>
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
	
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #a6a6a6; border-left: 1px solid #a6a6a6; border-right: 1px solid #a6a6a6" colspan=4 height="24" align="left" valign=middle><font face="Arial"><br></font></td>

	</tr>
	
</table>
<br>
<form method="post">
	<input type="submit" name="Create" value="Create INVOICE" Class="btn btn-primary"  style="background-color: #136a8a; border: none;" />
</form>
<td><a href="inventory.php?EDIROWID=<?php echo $id ?>" class="btn btn-primary" style="background-color: #136a8a; border: none;">Check INVENTORY </a></td>
<?php } ?>
<!-- ************************************************************************** -->
</body>

</html>
