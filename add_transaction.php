<?php
include "dbconfig.php";

if(isset($_COOKIE['Customer_ID'])){
    echo"<title>Add Transaction | Ahma'd Hodges</title>";
    $value = $_COOKIE['Customer_ID'];
    $getCredentials = "select Name from CPS3740.Customers where ID = ".$value;
    $displayCredentials = mysqli_query($con,$getCredentials);
    //echo $getCredentials;
    $name = '';
    while($row = mysqli_fetch_assoc($displayCredentials)){ 
        $name = $row['Name'];}
    echo"<a href='logout.php'>User logout</a>";
    echo"<br>";
    echo"<br> <b>Add Transaction</b>";
    $get = "select Name from CPS3740.Customers where ID = ".$value;
    $displayCredentials = mysqli_query($con,$getCredentials);
    //echo $getCredentials;
    $name = '';
    while($row = mysqli_fetch_assoc($displayCredentials)){ 
        $name = $row['Name'];}
        $setDeposit = "select sum(amount) as a from CPS3740_2022F.Money_hodgesa where cid = {$value} and type = 'D'";
        $setWithdraw = "select sum(amount) as b from CPS3740_2022F.Money_hodgesa where cid = {$value} and type = 'W'";
        $getDeposit = mysqli_query($con,$setDeposit);
        $getWithdraw = mysqli_query($con,$setWithdraw);
        $deposit = 0;
        while($row = mysqli_fetch_array($getDeposit)){$deposit = $row['a']; }
        $withdraw = 0;
        while($row = mysqli_fetch_assoc($getWithdraw)){$withdraw =$row['b']; }
        $totalBalance = $deposit - $withdraw;
        if($totalBalance>0){echo "<br> <b>{$name}</b> current balance is <font color='blue'><b>{$totalBalance}</b></font>";
        }
        if($totalBalance<0){echo "<br> <b>{$name}</b> current balance is <font color='red'><b>{$totalBalance}</b></font>";
        }
        if($totalBalance==0){echo "<br> <b>{$name}</b> current balance is <font color='blue'><b>{$totalBalance}</b></font>";
        }

    //echo"<br> <b>{$name}</b> current balance is <b>".$balance."</b>.";
    
    echo"<form action='insert_transaction.php' method='POST'>";
    echo"Transaction code: <input type='text' name='code' required='required'><br>";
    echo"<input type='radio' name='type' value='D'>Deposit";
    echo"<input type='radio' name='type' value='W'>Withdraw <br>";
    echo"Amount: <input type='text' name='amount' required='required'><br>";
    $getSources = "SELECT * from CPS3740.Sources";
    $displaySources = mysqli_query($con, $getSources);
    
    echo"Select a source: <select name='source_id' required='required'>";
    echo'<option value></option>';
    $i=0;
    $a1 = array();
    while($row = mysqli_fetch_assoc($displaySources)){
        $a1[$i]=$row['id'];
        echo'<option value='.$row['id'].'>'.$row['name'].'</option>';
        }
    echo"</select>";
    
    echo"<br>Note: <input type='text' name='note' required='required'><br>";
    echo"<input type='submit' value='Submit'>";
    
    //echo"<br>".$a1[0];

}
else{
    echo"<title>You are not Logged in!</title>";
    echo"You must login first";
    echo"<META HTTP-EQUIV=Refresh CONTENT='6'; URL='index.html'>";
}

?>