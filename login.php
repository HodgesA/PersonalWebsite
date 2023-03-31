<?php
include "dbconfig.php";
echo"<title>Login | Ahma'd Hodges</title>";
$username = $_POST['username'];
$password = $_POST['password'];
$custID = "Customer_ID";
echo"<a href='logout.php'>User logout</a> <br>";
echo"Your IP: ".$_SERVER['REMOTE_ADDR'];
echo"<br> Your browser and OS: ".$_SERVER['HTTP_USER_AGENT'];
$keanCheck = substr($_SERVER['REMOTE_ADDR'],0,3);
$keanCheck1 = substr($_SERVER['REMOTE_ADDR'],0,2);
if($keanCheck=='131' || $keanCheck1=='10'){
    echo"<br> You are from Kean University!";
}
else{
    echo"<br> You are NOT from Kean University.";
}
$getCredentials ="SELECT login,password FROM CPS3740.Customers  where  login = '$username' and password = '$password'";
$credChecker = mysqli_query($con, $getCredentials);
$getCredentials2 ="SELECT login,password FROM CPS3740.Customers  where  login = '$username' and password != '$password'";
$credChecker2 = mysqli_query($con, $getCredentials2);
$getCredentials3 ="SELECT login,password FROM CPS3740.Customers  where  login = '$username'";
$credChecker3 = mysqli_query($con, $getCredentials3);
if(mysqli_num_rows($credChecker)>0){
    //echo"<br>Logged in!";
    //echo"<a href='index.html'>Project Home Page</a> <br>";
    $getCustomerCredentials = "SELECT Name,ID,img,concat(Street,', ',City,', ',State,', ',Zipcode) as Address, DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), DOB)), '%Y') AS Age from CPS3740.Customers where login = '$username'";
    $displayCustomerCredentials = mysqli_query($con,$getCustomerCredentials);
    $gc = '';
    $img = '';
    $cname = '';
    if($displayCustomerCredentials){
        while($row = mysqli_fetch_assoc($displayCustomerCredentials)){
            echo "<br> Welcome Customer: <b>".$row['Name']."</b>";
            echo "<br> Age: ".substr($row['Age'],2);
            echo "<br> Address: ".$row['Address'];
            $gc = $row['ID'];
            $img = $row['img'];
            $cname = $row['Name'];
    }
    setcookie($custID,$gc, time() + (86400 * 1), "/");
    echo "<br> <img src='data:image/jpeg;base64," . base64_encode( $img ) ."' width='10%' height='12%'>";
    echo"<hr>";
    $getTransactions = "SELECT Count(*) as count from CPS3740_2022F.Money_hodgesa where cid = '$gc'";
    $displayTransactions = mysqli_query($con,$getTransactions);
    $countTransactions = '';
    while($row = mysqli_fetch_assoc($displayTransactions)){
        if($row['count']!=0){
            echo"There are <b>{$row['count']}</b> transactions for customer: <b>{$cname}</b>";
        }
        else{
            echo"No record found for customer: <b>{$cname}</b>";
        }
        $countTransactions = $row['count'];
    }
    $getTable = "SELECT h.id,h.code,h.cid,s.name,h.type,h.amount,h.mydatetime,h.note from CPS3740_2022F.Money_hodgesa h join CPS3740.Sources s on h.sid = s.id where cid = '$gc'";
    $displayTable = mysqli_query($con,$getTable);
    if($countTransactions>=1){
    echo"<table border=3>";
    echo"<TR><TD><center>ID</center><TD><center>Code</center><TD><center>Type</center><TD><center>Amount</center><TD><center>Source</center><TD><center>Date Time</center><TD><center>Note</center>";
    $cid = '';
    while($row = mysqli_fetch_assoc($displayTable)){echo"<tr>";
        $ID = $row['id'];
        $code = $row['code'];
        $cid = $row['cid'];
        $sid = $row['name'];
        $type= $row['type'];
        $amount = $row['amount'];
        $mydatetime = $row['mydatetime'];
        $note = $row['note'];
        $a1 = array($ID,$code,$cid,$sid,$type,$amount,$mydatetime,$note);
        if($type=='D'){
                echo"<td><center>".$a1[0]."<td><center> ".$a1[1]."<td><center>deposit<td><center><font color='blue'> ".$a1[5]."</font><td><center> ".$a1[3]."<td><center> ".$a1[6]."<td><center> ".$a1[7];
        }
        if($type=='W'){
            echo"<td><center>".$a1[0]."<td><center> ".$a1[1]."<td><center>withdraw<td><center><font color='red'> ".$a1[5]."</font><td><center> ".$a1[3]."<td><center> ".$a1[6]."<td><center> ".$a1[7];
        }
        

    }
    echo"</table>";
    
}
    
    $setDeposit = "select sum(amount) as a from CPS3740_2022F.Money_hodgesa where cid = {$cid} and type = 'D'";
    $setWithdraw = "select sum(amount) as b from CPS3740_2022F.Money_hodgesa where cid = {$cid} and type = 'W'";
    $getDeposit = mysqli_query($con,$setDeposit);
    $getWithdraw = mysqli_query($con,$setWithdraw);
    $deposit = 0;
    while($row = mysqli_fetch_array($getDeposit)){$deposit = $row['a']; }
    $withdraw = 0;
    while($row = mysqli_fetch_assoc($getWithdraw)){$withdraw =$row['b']; }
    $totalBalance = $deposit - $withdraw;
    if($totalBalance>0){echo "Total balance: <font color='blue'>{$totalBalance}</font>";
    }
    if($totalBalance<0){echo "Total balance: <font color='red'>{$totalBalance}</font>";
    }
    if($totalBalance==0){echo "Total balance: <font color='blue'>{$totalBalance}</font>";
    }
    echo"<br>";
    echo"<br><a href='add_transaction.php'><button>Add Transaction</button></a>";
    echo"<a href='display_transaction.php'>Display and update transaction</a>";
    echo"<a href='display_stores.php'>Display Stores</a>";
    echo'<br><br><form action="search.php" method="get"> Keyword:<input type="text" name="keyword" required="required">
    <input type="submit" value="Search transaction"></form>';
}
}
if(mysqli_num_rows($credChecker2)>0){
    echo"<br>User $username is in the database, but wrong password was entered.";
    echo"<br><a href='index.html'>Project Home Page</a> <br>";
}
if(mysqli_num_rows($credChecker3)==0){
    echo"<br>User $username is not in the database. ";
    echo"<br><a href='index.html'>Project Home Page</a> <br>";

}
//READ select sum(amount) as a from CPS3740_2022F.hodgesa where cid = {$_COOKIE['Customer_ID']} and type = 'D';
//"select sum(amount) as a from CPS3740_2022F.Money_hodgesa where cid = {$value} and type = 'D' and note like '%$keyword%'";
//$deposit = 0;
//while($row = mysqli_fetch_assoc($getDeposit)){$deposit = $row['a']; }
// select sum(amount) as b from CPS3740_2022F.hodgesa where cid = {$_COOKIE['Customer_ID']} and type = 'W';
//$withdraw = 0;
//while($row = mysqli_fetch_assoc($getWithdraw)){$withdraw =$row['b']; }
//$totalBalance = $deposit - $withdraw;
//echo "Total balance: ".$totalBalance;
// THIS IS FOR THE DISPLAY_TRANSACTION

//<TABLE border=1>
//<TR><TH>ID<TH>Code<TH>Amount<TH>Type<TH>Source<TH>Date Time<TH>Note<TH>Delete
//</TABLE>


//THIS IS FOR SEARCH_TRANSACTION
//<TABLE border=1>
//<TR><TH>ID<TH>Code<TH>Type<TH>Amount<TH>Date Time<TH>Note<TH>Source
//</TABLE>


?>

