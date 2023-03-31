<?php
if (isset($_COOKIE['Customer_ID'])) {
    echo"<title>Logout | Ahma'd Hodges</title>";
     echo "Successfully logged out.";
    echo "<br><a href='index.html'>Project home page</a><br><br>";
    unset($_COOKIE['Customer_ID']); 
    } 
else{
  echo"<title>You are not Logged in!</title>";
  echo"You are not logged in";
  echo"<META HTTP-EQUIV=Refresh CONTENT='6'; URL='index.html'>";
}  
?>