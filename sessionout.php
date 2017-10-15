<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   session_destroy();
   echo "<script>
         alert('You Have Logged Out - All Sessions Cleared');
         window.location.href='index.php';
         </script>";
?>