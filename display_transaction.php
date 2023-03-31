<?php 
include "dbconfig.php";
if(isset($_COOKIE['Customer_ID'])){
    echo"<title>Display Transaction | Ahma'd Hodges</title>";
    $value = $_COOKIE['Customer_ID'];
    echo "<a href='logout.php'>User logout</a><br>";
    $checkID = "SELECT * from CPS3740_2022F.Money_hodgesa where cid = ".$value;
    $retrieveID = mysqli_query($con,$checkID);
    $counter = 0;
    while($row = mysqli_fetch_assoc($retrieveID)){
        if($row['cid']==$value){
            $counter++;
        }
    }
    if($counter>0){

        $getTable = "SELECT h.id,h.code,h.cid,s.name,h.type,h.amount,h.mydatetime,h.note from CPS3740_2022F.Money_hodgesa h join CPS3740.Sources s on h.sid = s.id";
        $displayTable = mysqli_query($con,$getTable);
        echo"You can only update <b>Note</b> column.";
        echo"<form action='update_transaction.php' method='post'>";
        echo"<TABLE border=1>";
        echo"<TR><TH>ID<TH>Code<TH>Type<TH>Amount<TH>Source<TH>Date Time<TH>Note<TH>Delete";


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
                    $a1[4] = 'Deposit';
                    echo"<td><center>".$a1[0]."<td><center> ".$a1[1]."<td><center> ".$a1[4]."<td><center><font color='blue'> ".$a1[5]."</font><td><center> ".$a1[3]."<td><center> ".$a1[6]."<td bgcolor='yellow'><center><input type='text' value='{$a1[7]}' name='note[]' style='background-color:yellow;'><td><input type='checkbox' name='id[]' value='{$a1[0]}'><input type='hidden' name='secret[]' value='{$a1[0]}'>";
                }
                if($type=='W'){
                    $a1[4] = 'Withdraw';
                    echo"<td><center>".$a1[0]."<td><center> ".$a1[1]."<td><center> ".$a1[4]."<td><center><font color='red'> ".$a1[5]."</font><td><center> ".$a1[3]."<td><center> ".$a1[6]."<td bgcolor='yellow'><center><input type='text' value='{$a1[7]}' name='note[]' style='background-color:yellow;'><td><input type='checkbox' name='id[]' value='{$a1[0]}'><input type='hidden' name='secret[]' value='{$a1[0]}'>";
                }
            }
        }
        echo"</TABLE>";
        $setDeposit = "select sum(amount) as a from CPS3740_2022F.Money_hodgesa where cid = {$value} and type = 'D'";
        $setWithdraw = "select sum(amount) as b from CPS3740_2022F.Money_hodgesa where cid = {$value} and type = 'W'";
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
        if($totalBalance==0){echo "Total balance: <font color='black'>{$totalBalance}</font>";
        }
        echo"<br><input type='submit' value='Update transaction'></form>";
    }
    else{
        echo"<font color=red>No transcation records found.</font>";
    }
}

else{
    echo"<title>You are not Logged in!</title>";
    echo"You are not logged in";
}




?>