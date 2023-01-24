<?php
// define variables and set to empty values
$bnameErr = $dbanameErr = $streetErr = "";
$bname = $dbaname = $street = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["bname"])) {
     $bnameErr = "Business na=ame is required";
   } else {
     $bnameErr = test_input($_POST["bname"]);
   }
   
   if (empty($_POST["dbaname"])) {
     $dbanameErr = "DBAname is requied";
   } else {
     $dbanameErr = test_input($_POST["dbaname"]);
   }
     
   if (empty($_POST["street"])) {
     $street = "Street is required";
   } else {
     $street = test_input($_POST["street"]);
   }
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>