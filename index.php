<?php
   ob_start();
   session_start();
?>

<html lang = "en">
   
   <head>
      <title>Login Page</title>
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
      
      <style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #ADABAB;
         }
         
         .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            color: #017572;
         }
         
         .form-signin .form-signin-heading,
         .form-signin .checkbox {
            margin-bottom: 10px;
         }
         
         .form-signin .checkbox {
            font-weight: normal;
         }
         
         .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
         }
         
         .form-signin .form-control:focus {
            z-index: 2;
         }
         
         .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#006699;
         }
         
         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-color:#017572;
         }
         
         h1{
            text-align: center;
            color: #006699;
         }
         h3{
            text-align: center;
            color: #336699;
         }
      </style>
      
   </head>
	
   <body>
      
      <h1>Howdy! Welcome to the CSE/ECE Department Graduate Alumni Directory!</h1> 
      <div class = "container form-signin">
         
         <?php
            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
				
               if ($_POST['username'] == 'Admin' && 
                  $_POST['password'] == 'Pass@123') {
                  $_SESSION['loggedin'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = 'Admin';
                  header('location:search.php');
                  
               }
			   else
			   {
                  $msg = 'Wrong Username or Password';
               }
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
      
         <center><form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input align="center" type = "text" class = "form-control" 
               name = "username" placeholder = "Enter Username" required autofocus></br>
            <input align="center" type = "password" class = "form-control"
               name = "password" placeholder = "Enter Password" required></br>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               align="center" name = "login">Login</button>
         </form></center>
			
         <center><h4><a href = "sessionout.php" tite = "Logout">Clear Session</a></h4></center></br>
         </br></br></br></br></br></br></br></br></br></br>
      </div> 
      <center><h3>Developed By: Sameer Kumar Behera</h3></center>
      <center><h3>Project For CSCE 608: Database Systems</h3></center>
      
   </body>
</html>