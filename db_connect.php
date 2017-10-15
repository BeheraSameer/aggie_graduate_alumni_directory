<?php

function OpenCon()
 {

 $dbhost = "localhost";
 $dbuser = "id3185300_localhost";
 $dbpass = "Sam@123";
 $db = "id3185300_my_db";
 
 $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connection Failed: %s\n". $conn -> error);
 
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
?>