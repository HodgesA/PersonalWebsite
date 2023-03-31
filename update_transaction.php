<?php 
include "dbconfig.php";
if(isset($_COOKIE['Customer_ID'])){
    echo"<title>Display Transaction | Ahma'd Hodges</title>";
    echo"<a href='logout.php'>User logout</a> <br>";

    $delLenVals = 0;
    //$UpdateLenVals = '';
    if(isset($_POST['id'])){
        $countArrLen = count($_POST['id']);
        $i=0;
        $a1 = array();
        $value = $_COOKIE['Customer_ID'];
        while($i!=$countArrLen){
            $a1[$i] = $_POST['id'][$i];
            $delFromQuery = "DELETE FROM CPS3740_2022F.Money_hodgesa WHERE id={$a1[$i]}";
            $execDel = mysqli_query($con,$delFromQuery);
            $delLenVals++;
            //echo "THIS IS {$a1[$i]} YOU GOT IT!<BR>";
            $i++;
        }
        //echo count($_POST['id']). "<br />";
    }
    
    if(isset($_POST['note'])){
        $countArrLenNote = count($_POST['note']);
        $j=0;
        $a2 = array();
        $updateTrans = 0;
        $value = $_COOKIE['Customer_ID'];
        //$ide = $_POST['id'][$j];
        while($j!=$countArrLenNote){
            
            //echo $_POST['secret'][$j];
            //echo $_POST['note'][$j];
            
            //$j++;
            
            $getNotes = "SELECT count(*) as count from CPS3740_2022F.Money_hodgesa where note != '{$_POST['note'][$j]}' and id = {$_POST['secret'][$j]};";
            $takeNotes = mysqli_query($con,$getNotes);
            while($row = mysqli_fetch_assoc($takeNotes)){
                $ab = $row['count'];
                //echo $ab;
                if($ab!=0){
                    $a2[$j] = $_POST['secret'][$j];
                    $updateFromQuery = "UPDATE CPS3740_2022F.Money_hodgesa SET mydatetime= now() ,note='{$_POST['note'][$j]}' where id={$a2[$j]}";
                    $execUpdate = mysqli_query($con,$updateFromQuery);
                    $updateView = "SELECT code from CPS3740_2022F.Money_hodgesa where id={$a2[$j]}";
                    $execUpdateView = mysqli_query($con,$updateView);
                    while($row = mysqli_fetch_assoc($execUpdateView)){
                        echo "Successfully update transaction code: <b>{$row['code']}</b>";
                        echo"<br>";
                        $updateTrans++;
                    
                    }
                    //$updateTrans++;
                    //update and increment
                    //echo$a2[$j];
                }
                
            }
            $j++;    
        }
}

    //$delFromQuery = "DELETE FROM CPS3740_2022F.Money_hodgesa WHERE id={$a1[$i]}";
    $k=0;/*
    while($k!=$UpdateLenVals){
        echo $a2[$k];
        $k++;
    }*/

    echo "<br>Finish deleting {$delLenVals} records and updating {$updateTrans} transactions";






    $value = $_COOKIE['Customer_ID'];
    $getTable = "SELECT h.id,h.code,h.cid,s.name,h.type,h.amount,h.mydatetime,h.note from CPS3740_2022F.Money_hodgesa join CPS3740.Sources s on h.sid = s.id";
    $displayTable = mysqli_query($con,$getTable);
    
    }
else{
    echo"<title>You are not Logged in!</title>";
    echo"You are not logged in";
    echo"<META HTTP-EQUIV=Refresh CONTENT='6'; URL='index.html'>";
}
?>