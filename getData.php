<?php
session_start();
$uname = $_SESSION['User'];

$conn = mysqli_connect('localhost', 'u269067746_root', 'Tonhu@1603', 'u269067746_EDI_SOLUTION');

if (mysqli_connect_error()){
    echo "connection fail".mysqli_connect_error();
}

if ($conn->connect_error) {
    die("Connection failed: " 
        . $conn->connect_error);
}
   
    $sql_RecISA = "select cp.ISA_ID from Customer_Profile cp inner join ACCOUNT_WEB_SUPPLIER acw on cp.CustomerID = acw.CustomerID where acw.UserName_web = '$uname' ";
    $result_RecISA = $conn->query($sql_RecISA);
    while($row_RecISA = $result_RecISA->fetch_assoc()) {

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
  <div class="app">
    <div class="container-fluid px-0;  ">
      <header>
        <div class="logo">
            EDISOLUTION WEB SUPPLIER
            <a href="default.php">
            <i class='bx bx-log-out'style="margin-left:1300px"></i>
            <span class="links_name">Đăng xuất</span>
          </a>
        </div>
        <div>
        </div>
      </header>
      <main>
        <div class="container-fluid px-0">
          <div class="d-flex">
            <!--<div class="sidebar">-->
            <!--  In-->
            <!--</div>-->
            <div class="contents-wrapper">
              <div class="content">
                  <form method="POST" action="#">
        <input type="text" name="search" placeholder="">
        <input type="submit" value="Search" ></form>
                <table>
                    <tr>
                      <th>EDIROWID</th>
                      <th>SenderISA</th>
                      <th>Received Date</th>
                      <th>Transaction</th>
                      <th>Document Nubmer</th>
                      <th>ViewDocument</th>
                      <th>INVOICE</th>
                      <!--<th>INVENTORY REPORT</th>-->
                    </tr>
    <?php
    //collect
    if (isset($_POST['search'])){
        $searchq = $_POST['search'];
        // $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);
        // echo $searchq;
        $query = "select * from Inbox inb inner join Customer_Profile cp on inb.ReceiveISA = cp.ISA_ID inner join ACCOUNT_WEB_SUPPLIER acw on cp.CustomerID = acw.CustomerID where inb.DocumentID = '$searchq' or inb.EDIROWID='$searchq'";
        // echo $query;
        $result_search = $conn->query($query);
    if($result_search->num_rows > 0){
        while($row = $result_search->fetch_assoc()){?>
            <tr>
                 <td><?php echo $row["EDIROWID"] ?></td>
                 <td><?php 
                 $sendername =  $row["SenderISA"];
                 $sql_sendername = "select CustomerName from Customer_Profile where ISA_ID = '$sendername'"; 
                 $result_sendername = $conn->query($sql_sendername);
                 if ($result_sendername->num_rows > 0) { 
                   while($row_sendername = $result_sendername->fetch_assoc()) {
                     echo $row_sendername["CustomerName"];
                     }
                  }?></td>
              <td><?php echo $row["ReceivedDate"] ?></td>   
              <td><?php echo $row["Transactions"] ?></td>  
              <td><?php echo $row["DocumentID"] ?></td>            
              <td><a href="purchase-order.php?EDIROWID=<?php echo $row['EDIROWID'] ?>" class="btn btn-primary" style="background-color: #136a8a; border: none;">View </a></td>
              <td><a href="invoice.php?EDIROWID=<?php echo $row['EDIROWID'] ?>" class="btn btn-primary" style="background-color: #136a8a; border: none;">View</a></td>
              <!--<td><a href="invenroty_report.php.php?EDIROWID=<?php echo $row['EDIROWID'] ?>" class="btn btn-primary">Create </a></td>-->
              </tr>
               <?php }?>
        <?php }?>
    <?php } else {?>

          <?php
          $result = $conn->query($sql);
          if ($result->num_rows > 0) { 
            // echo "<p>".$result."</p>";
            // echo "<table><tr><th>EDIROWID</th><th>SenderISA</th></tr>";
            // output data of each row
            while($row = $result->fetch_assoc()) { ?>
              
               <tr>
                 <td><?php echo $row["EDIROWID"] ?></td>
                 <td><?php $sendername =  $row["SenderISA"];$sql_sendername = "select CustomerName from Customer_Profile where ISA_ID = '$sendername'"; 
                 $result_sendername = $conn->query($sql_sendername);
                 if ($result_sendername->num_rows > 0) { 
                   while($row_sendername = $result_sendername->fetch_assoc()) {
                     echo $row_sendername["CustomerName"];
                     }
                  }?></td>
              <td><?php echo $row["ReceivedDate"] ?></td>   
              <td><?php echo $row["Transactions"] ?></td>  
              <td><?php echo $row["DocumentID"] ?></td>            
              <td><a href="purchase-order.php?EDIROWID=<?php echo $row['EDIROWID'] ?>" class="btn btn-primary" style="background-color: #136a8a; border: none;">View </a></td>
              <td><a href="invoice.php?EDIROWID=<?php echo $row['EDIROWID'] ?>" class="btn btn-primary" style="background-color: #136a8a; border: none;">View</a></td>
              <!--<td><a href="invenroty_report.php.php?EDIROWID=<?php echo $row['EDIROWID'] ?>" class="btn btn-primary">Create </a></td>-->
              </tr>
              <?php }?>
             <?php }?>
              <?php } 
           ?>
           
                  </table>
              </div>
            </div>
          </div>
        </div>
      </main>
      <footer>
        <div class="footer-wrapper">
          <div class="copyright">
            EDISOLUTION WEB SUPPLIER
          </div>
        </div>
      </footer>
      <!-- <td><input style="WIDTH: 200px" type="submit" value="View" onclick="location.href='viewDocument.html'" ></td></tr> -->
      
    </div>
  </div>
</body>
</html>