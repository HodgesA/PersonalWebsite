<?php 
include 'dbconfig.php';
echo"<title>Display Customers | Ahma'd Hodges'</title>";
$getCustomers = "select ID,login,password,Name,Gender,DOB,Street,City,State,Zipcode from CPS3740.Customers";
$displayCustomers = mysqli_query($con,$getCustomers);
echo "The following customers are in the bank system:";
echo "<table border='2'><tr><th>ID</th><th>login</th><th>password</th><th>Name</th><th>Gender</th><th>DOB</th><th>Street</th><th>City</th><th>State</th><th>Zipcode</th></tr>";

while($row = mysqli_fetch_assoc($displayCustomers)){ echo"<tr>";
    $ID = $row['ID'];
    $login = $row['login'];
    $password = $row['password'];
    $dob = $row['DOB'];
    $name = $row['Name'];
    $gender = $row['Gender'];
    $Street = $row['Street'];
    $City = $row['City'];
    $State = $row['State'];
    $Zipcode = $row['Zipcode'];
    
    $a1 = array($ID,$login,$password,$name,$gender,$dob,$Street,$City,$State,$Zipcode);
    echo"<td><center>".$a1[0]."<td><center> ".$a1[1]."<td><center> ".$a1[2]."<td><center> ".$a1[3]."<td><center> ".$a1[4]."<td><center> ".$a1[5]."<td><center> ".$a1[6]."<td><center> ".$a1[7]."<td><center> ".$a1[8]."<td><center> ".$a1[9];
    
}
echo"</table>";

?>