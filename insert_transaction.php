<?php 

if(isset($_COOKIE['Customer_ID'])){
    echo"<title>Insert Transaction | Ahma'd Hodges</title>";
    include "dbconfig.php";
    echo"<a href='logout.php'>User logout</a>";
    $code = $_POST['code'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $source_id = $_POST['source_id'];
    $note = $_POST['note'];
    $datetime = 'now()';
    $cid = intval($_COOKIE['Customer_ID']);
    $getTransactions = "SELECT * from CPS3740_2022F.Money_hodgesa where cid = {$cid}";
    $displayTransactions = mysqli_query($con,$getTransactions);
    if(mysqli_num_rows($displayTransactions)<=0){
        if($type=='W'){
            $getNames = "SELECT Name,id from CPS3740.Customers where id = {$cid}";
            $displayNames = mysqli_query($con,$getNames);
            while($row = mysqli_fetch_assoc($displayNames)){
                echo"<br>Customer {$row['Name']} has no transaction records in database.";
                echo"<br><font color='red'>Error! Customer {$row['Name']} has $0 in the bank, and tries to withdraw $".$amount." Not enough money!</font>";}
         }
         if($type=='D'){
            $insertTransaction = "INSERT INTO CPS3740_2022F.Money_hodgesa (id, code, cid, sid, type, amount,mydatetime,note) VALUES ('', '".$code."', ".$cid.", ".$source_id.", '".$type."', ".$amount.",now(),'".$note."')";
            $runInsert = mysqli_query($con,$insertTransaction);
            echo"<br>Customer {$row['Name']} has no transaction records in database.";
            echo"<br>You successfully inserted {$code} into the database.";
        
        
            $setDeposit = "select sum(amount) as a from CPS3740_2022F.Money_hodgesa where cid = {$cid} and type = 'D'";
            $setWithdraw = "select sum(amount) as b from CPS3740_2022F.Money_hodgesa where cid = {$cid} and type = 'W'";
            $getDeposit = mysqli_query($con,$setDeposit);
            $getWithdraw = mysqli_query($con,$setWithdraw);


            while($row = mysqli_fetch_array($getDeposit)){$deposit = $row['a']; }
            $withdraw = 0;
            while($row = mysqli_fetch_assoc($getWithdraw)){$withdraw =$row['b']; }
            $totalBalance = $deposit - $withdraw;
            if($totalBalance>0){echo "New balance: <font color='blue'>{$totalBalance}</font>";
            }
            if($totalBalance<0){echo "New balance: <font color='red'>{$totalBalance}</font>";
            }
            if($totalBalance==0){echo "New balance: <font color='black'>{$totalBalance}</font>";
            }
        
        
            }
            //echo "<br>".$insertTransaction; }
    
        
    }
    while($row = mysqli_fetch_assoc($displayTransactions)){
        if($row['code']!=$code){
            $getAmount = "select sum(amount) as sum from CPS3740_2022F.Money_hodgesa where cid = {$cid}";
            $chkAmount = mysqli_query($con,$getAmount);
            while($row = mysqli_fetch_assoc($chkAmount)){
                if($type=='W'){
                    if(($row['sum']>=$amount)){
                        $insertTransaction = "INSERT INTO CPS3740_2022F.Money_hodgesa (id, code, cid, sid, type, amount,mydatetime,note) VALUES ('', '".$code."', ".$cid.", ".$source_id.", '".$type."', ".$amount.",now(),'".$note."')";
                        $runInsert = mysqli_query($con,$insertTransaction);
                        echo"<br>You successfully inserted <b>{$code}</b> into the database.";

                        $setDeposit = "select sum(amount) as a from CPS3740_2022F.Money_hodgesa where cid = {$cid} and type = 'D'";
                        $setWithdraw = "select sum(amount) as b from CPS3740_2022F.Money_hodgesa where cid = {$cid} and type = 'W'";
                        $getDeposit = mysqli_query($con,$setDeposit);
                        $getWithdraw = mysqli_query($con,$setWithdraw);


                        while($row = mysqli_fetch_array($getDeposit)){$deposit = $row['a']; }
                        $withdraw = 0;
                        while($row = mysqli_fetch_assoc($getWithdraw)){$withdraw =$row['b']; }
                        $totalBalance = $deposit - $withdraw;
                        if($totalBalance>0){echo "<br>New balance: <font color='blue'>{$totalBalance}</font>";
                        }
                        if($totalBalance<0){echo "<br>New balance: <font color='red'>{$totalBalance}</font>";
                        }
                        if($totalBalance==0){echo "<br>New balance: <font color='black'>{$totalBalance}</font>";
                        }
                        
                    }
                }
                if($type=='D'){
                    if(!($amount<=0)){
                        $insertTransaction = "INSERT INTO CPS3740_2022F.Money_hodgesa (id, code, cid, sid, type, amount,mydatetime,note) VALUES ('', '".$code."', ".$cid.", ".$source_id.", '".$type."', ".$amount.",now(),'".$note."')";
                        $runInsert = mysqli_query($con,$insertTransaction);
                        echo"<br>You successfully inserted {$code} into the database.";

                        $setDeposit = "select sum(amount) as a from CPS3740_2022F.Money_hodgesa where cid = {$cid} and type = 'D'";
                        $setWithdraw = "select sum(amount) as b from CPS3740_2022F.Money_hodgesa where cid = {$cid} and type = 'W'";
                        $getDeposit = mysqli_query($con,$setDeposit);
                        $getWithdraw = mysqli_query($con,$setWithdraw);


                        while($row = mysqli_fetch_array($getDeposit)){$deposit = $row['a']; }
                        $withdraw = 0;
                        while($row = mysqli_fetch_assoc($getWithdraw)){$withdraw =$row['b']; }
                        $totalBalance = $deposit - $withdraw;
                        if($totalBalance>0){echo "<br>New balance: <font color='blue'>{$totalBalance}</font>";
                        }
                        if($totalBalance<0){echo "<br>New balance: <font color='red'>{$totalBalance}</font>";
                        }
                        if($totalBalance==0){echo "<br>New balance: <font color='black'>{$totalBalance}</font>";
                        }
                    }
                    else{
                        echo"balance can not be less than or equal to 0";
                    } 
                }

            }
        }
        else{
            if($row['code']==$code){
                echo"Error! There is same transaction code in database.";
            }
            $getAmount = "select sum(amount) as sum from CPS3740_2022F.Money_hodgesa where cid = {$cid}";
            $chkAmount = mysqli_query($con,$getAmount);
            while($row = mysqli_fetch_assoc($chkAmount)){
                if($type=='W'&&$row['sum']<$amount){
                    echo"<font color='red'>Error! Customer {$row['customer']} has ${$row['sum']} in the bank, and tries to withdraw ${$amount}. Not enough money!</font>";
            }

        }
        
        //echo"There are {$row['type']} transactions for customer";
    }
   
}
}
else{
    echo"<title>You are not Logged in!</title>";
    echo"You are not logged in";
    echo"<META HTTP-EQUIV=Refresh CONTENT='6'; URL='index.html'>";

}

?>