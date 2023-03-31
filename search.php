<?php 
include "dbconfig.php";
if(isset($_COOKIE['Customer_ID'])){
    $keyword = $_GET['keyword'];
    echo"<title>Transaction: ".$keyword." | Ahma'd Hodges</title>";
    $value = $_COOKIE['Customer_ID'];
    $getCredentials = "select Name from CPS3740.Customers where ID = ".$value;
    $displayCredentials = mysqli_query($con,$getCredentials);
    $name = '';
    while($row = mysqli_fetch_array($displayCredentials)){ 
        $name = $row['Name'];}

    if($keyword!='*'){
        $getTable = "SELECT h.id,h.code,h.cid,s.name,h.type,h.amount,h.mydatetime,h.note from CPS3740_2022F.Money_hodgesa h join CPS3740.Sources s on h.sid = s.id where note like '%$keyword%'";
        $setDeposit = "select sum(amount) as a from CPS3740_2022F.Money_hodgesa where cid = {$value} and type = 'D' and note like '%$keyword%'";
        $setWithdraw = "select sum(amount) as b from CPS3740_2022F.Money_hodgesa where cid = {$value} and type = 'W' and note like '%$keyword%'";
        $setTable = "select count(*) as a from CPS3740_2022F.Money_hodgesa where cid = {$value} and note like '%$keyword%'";
        }
    else{
        $getTable = "SELECT h.id,h.code,h.cid,s.name,h.type,h.amount,h.mydatetime,h.note from CPS3740_2022F.Money_hodgesa h join CPS3740.Sources s on h.sid = s.id where h.cid = {$value}";
        $setDeposit = "select sum(amount) as a from CPS3740_2022F.Money_hodgesa where cid = {$value} and type = 'D'";
        $setWithdraw = "select sum(amount) as b from CPS3740_2022F.Money_hodgesa where cid = {$value} and type = 'W'";
        $setTable = "select count(*) as a from CPS3740_2022F.Money_hodgesa where cid = {$value}";           
    }
    $displayTable = mysqli_query($con,$getTable);
    $getDeposit = mysqli_query($con,$setDeposit);
    $getWithdraw = mysqli_query($con,$setWithdraw);

    $setTableResult = mysqli_query($con,$setTable);
    $getRowsVal=0;
    while($row = mysqli_fetch_assoc($setTableResult)){$getRowsVal = $row['a']; }
    if($getRowsVal>=1){
        echo "The transaction in customer <b>{$name}</b> records matched keyword <b>{$keyword}</b> are:";
        echo"<TABLE border=1>";
        echo"<TR><TH>ID<TH>Code<TH>Type<TH>Amount<TH>Source<TH>Date Time<TH>Note";


        while($row = mysqli_fetch_assoc($displayTable)){
            if($row['cid']==$value){echo"<tr>";
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
                    echo"<td><center>".$a1[0]."<td><center> ".$a1[1]."<td><center>Deposit<td><center><font color='blue'> ".$a1[5]."</font><td><center> ".$a1[3]."<td><center> ".$a1[6]."<td><center> ".$a1[7];
                }
                if($type=='W'){
                    echo"<td><center>".$a1[0]."<td><center> ".$a1[1]."<td><center>Withdraw<td><center><font color='red'> ".$a1[5]."</font><td><center> ".$a1[3]."<td><center> ".$a1[6]."<td><center> ".$a1[7];
                }
            }
        }
        echo"</TABLE>";
        $deposit = 0;
        while($row = mysqli_fetch_array($getDeposit)){$deposit = $row['a']; }
        $withdraw = 0;
        while($row = mysqli_fetch_assoc($getWithdraw)){$withdraw =$row['b']; }
        $totalBalance = $deposit - $withdraw;
        if($totalBalance>0){echo "Total balance: <font color='blue'>{$totalBalance}</font>";
        }
        if($totalBalance<0){echo "Total balance: <font color='red'>{$totalBalance}</font>";
        }
        if($totalBalance==0){echo "Total balance: <font color='black'>{$totalBalance}</font>";
        }
    }
    else{
        echo"There are no transactions in customer <b>{$name}</b> records that matched the keyword {$keyword}.";
    }
}
else{
    echo"<title>You are not Logged in!</title>";
    echo"You are not logged in";
}?>