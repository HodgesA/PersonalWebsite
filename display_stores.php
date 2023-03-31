<?php
if(isset($_COOKIE['Customer_ID'])){
    include "dbconfig.php";
    $sql ="SELECT sid, Name, Zipcode, State, city, address, concat('(',latitude,', ',longitude,')') as latlong FROM CPS3740.Stores2";
    $result = mysqli_query($con,$sql);
    echo"<title>View Stores | Ahma'd Hodges</title>";
    echo"<center><b>The following stores are in the database: Stores2</b></center>";
    echo "<center><table border='4'><tr><th>ID</th><th>Name</th><th>Zipcode</th><th>State</th><th>City</th><th>Address</th><th>latitude & longitude</th></tr>";
    $null = 'NULL';

while($row = mysqli_fetch_assoc($result)){ echo"<tr>";
    $ID = $row['sid'];
    $Name = $row['Name'];
    $Address = $row['address'];
    $City = $row['city'];
    $State = $row['State'];
    $Zipcode = $row['Zipcode'];
    $latlong = $row['latlong'];
        
    $a1 = array($ID,$Name,$Address,$City,$State,$Zipcode,$latlong);
    if($City!=''){
        echo"<td><center>".$a1[0]."<td><center> ".$a1[1]."<td><center> ".$a1[5]."<td><center> ".$a1[4]."<td><center> ".$a1[3]."<td><center> ".$a1[2]."<td><center> ".$a1[6];
    }
}
echo"</table></center>";
    
}
else{
    echo"<title>You are not Logged in!</title>";
    echo"You are not logged in";
    echo"<META HTTP-EQUIV=Refresh CONTENT='6'; URL='index.html'>";

}
?>