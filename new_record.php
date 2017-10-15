<?php
session_start();

if (!isset($_SESSION['loggedin']))
{
	$_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
	header('location:index.php');
}
?>
<?php
// Since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($first, $last, $l_dob, $gen, $gyr, $maj_cd, $a_pm, $error)
{
?>
<html>
<head>
<title>New Record</title>
<style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #ADABAB;
         }
		 h1{
            text-align: center;
            color: #006699;
         }
      </style>
<h1>Add Records</h1>
</head>
<body>

<?php
// If there are any errors then display them
if ($error != '')
{
echo '<center><div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div></center>';
}
?>

<center><form action="new_record.php" method="post">

<div>
First Name: <font color = "red">*</font> <input type = "text" placeholder = "Enter First Name" maxlength = "25" name = "fname" value = "<?php echo $first; ?>"><br/><br/>

Last Name: <font color = "red">*</font> <input type = "text" placeholder = "Enter Last Name" maxlength = "15" name = "lname" value = "<?php echo $last; ?>"><br/><br/>

Date of Birth: <font color = "red">*</font> <input type = "text" placeholder = "DDMMYYYY" maxlength = "8" name = "dob" value = "<?php echo $l_dob; ?>"><br/><br/>

Gender: <font color = "red">*</font> <select name = "gender">
                                     <option value = "">Select...</option>
                                     <option value = "M">Male</option>
									 <option value = "F">Female</option>
									 </select><br/><br/>

Local Address: <input type = "text" placeholder = "Enter Address" maxlength = "200" name = "addr"><br/><br/>

E-Mail Id: <input type = "text" placeholder = "Enter E-Mail Id" maxlength = "40" name = "email"><br/><br/>

Mobile Number: <input type = "text" placeholder = "Eg. +1-979-739-8772" maxlength = "20" name = "mob"><br/><br/>

Graduation Year: <font color = "red">*</font> <input type = "text" placeholder = "YYYY" maxlength = "4" name = "gyear" value = "<?php echo $gyr; ?>"><br/><br/>

Major: <font color = "red">*</font> <select name = "mj_cd">
                                    <option value="">Select...</option>
	                                <option value="MSCE">MSCE</option>
	                                <option value="MCE">MCE</option>
	                                <option value="MSCS">MSCS</option>
	                                <option value="MCS">MCS</option>
	                                <option value="MSEE">MSEE</option>
	                                <option value="MEE">MEE</option>
                                    <option value="MSCN">MSCN</option>
	                                <option value="MCN">MCN</option>
                                    </select><br/><br/>
Premium Membership Taken: <font color = "red">*</font> <select name = "pm">
                                    <option value="">Select...</option>
	                                <option value="Y">Yes</option>
	                                <option value="N">No</option>
									</select><br/><br/>
<input type = "reset" name = "reset">
<input type = "submit" name = "submit">
</div>
</form></center>
<center><h4>NOTE: <font color = "red">*</font> Marked Fields are Mandatory!</h4></center>
<center><a href="search.php">Back to Search</a></center>

<?php
}
// Check if the form has been submitted. If it has, start to process the form and save it to the database
if (isset($_POST['submit']))
{
// Connect to the database
include('db_connect.php');
$conn = OpenCon();

//$data = preg_replace('/[^A-Za-z0-9]/', "", $data);
// Get form data, making sure it is valid
$first = strtoupper(trim(preg_replace('/[^ A-Za-z0-9]/', '', $_POST['fname'])));
$last = strtoupper(trim(preg_replace('/[^ A-Za-z0-9]/', '', $_POST['lname'])));
//$first = strtoupper(mysqli_real_escape_string($conn,htmlspecialchars(trim($_POST['fname']))));
//$last = strtoupper(mysqli_real_escape_string($conn,htmlspecialchars(trim($_POST['lname']))));
$l_dob = preg_replace('/[^0-9]/', '', $_POST['dob']);
$gen = $_POST['gender'];
$l_addr = $_POST['addr'];
$l_email = $_POST['email'];
$l_mob = preg_replace('/[^0-9+-]/', '', $_POST['mob']);
$gyr = preg_replace('/[^0-9]/', '', $_POST['gyear']);
$maj_cd = $_POST['mj_cd'];
$a_pm = $_POST['pm'];
$stu_id = substr($first,0,3).substr($last,0,3).strval($l_dob);
$cur_yr = date('Y');
$strt_yr = 1876;
// Check to make sure both fields are entered
if ($first == '' || $last == '' || $l_dob == '' || $gen == '' || $gyr == '' || $maj_cd == '' || $a_pm == '' || $gyr > $cur_yr || $gyr < $strt_yr)
{
// Generate error message
$error = 'Please Fill In All the Mandatory/Correct Fields!';

// If either field is blank, display the form again
renderForm($first, $last, $l_dob, $gen, $gyr, $maj_cd, $a_pm, $error);
}

else
{
// Save the data to the database
$sql = "INSERT INTO student (STU_ID,FIRST_NAME,LAST_NAME,DOB,GENDER,LOCAL_ADDRESS,EMAIL,MOBILE,GRAD_YEAR) VALUES ('$stu_id','$first','$last','$l_dob','$gen','$l_addr','$l_email','$l_mob','$gyr');
INSERT INTO stu_maj (STU_ID,MAJOR_CD) VALUES ('$stu_id','$maj_cd');
INSERT INTO stu_dept (STU_ID,DEPT_CD) SELECT A.STU_ID, B.DEPT_CD FROM stu_maj A JOIN maj_dep B ON A.MAJOR_CD = B.MAJOR_CD WHERE A.STU_ID = '$stu_id';
INSERT INTO stu_mem (STU_ID,MEM_TAKEN) VALUES ('$stu_id','$a_pm');";

//$res = $conn->multi_query($sql);
// Print Response from MySQL
if ($conn->multi_query($sql) === TRUE)
    {
	//$last_id = $conn->insert_id;
	echo "<script>
    alert('Records Added Successfully to the Tables!!!');
    window.location.href='search.php';
    </script>";
	}
else {
	die ("Error: {$conn->errno} : {$conn->error}");
	}

//$conn->close();;
}
CloseCon($conn);
}

else
// If the form hasn't been submitted, display the form
{
renderForm('','','','','','','','');
}

//CloseCon($conn);
?>
</body>
</html>