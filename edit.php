<?php
session_start();

if (!isset($_SESSION['loggedin']))
{
	$_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
	header('location:index.php');
}
?>
<html>
<head>
<title>Edit Records</title>
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
<h1>Update Contact Information</h1>
</head>
<body>
<center><p><a href="search.php">Back to Search</a></p></center>
<?php
// Connect to the database
include('db_connect.php');
$conn = OpenCon();
// Check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['edit']))
{
$id = $_GET['edit'];

// Get results from database
$sql = "SELECT A.STU_ID AS STU_ID,FIRST_NAME,LAST_NAME,DOB,GENDER,LOCAL_ADDRESS,EMAIL,MOBILE,GRAD_YEAR,
C.MAJOR_CD AS MAJOR_CD,MAJOR,OPTIONS,E.DEPT_CD AS DEPT_CD,DEPARTMENT_NAME,DEPT_LOCATION,G.MEM_TAKEN AS MEM_TAKEN,FREE_RING,MEM_TY,REWARD_EXPECT
FROM student A JOIN stu_maj B ON A.STU_ID=B.STU_ID JOIN majors C ON C.MAJOR_CD=B.MAJOR_CD JOIN stu_dept D ON A.STU_ID=D.STU_ID
JOIN department E ON E.DEPT_CD=D.DEPT_CD JOIN stu_mem F ON A.STU_ID=F.STU_ID JOIN membership G ON G.MEM_TAKEN=F.MEM_TAKEN WHERE A.STU_ID = '$id'";

$result = $conn->query($sql);
?>
<table border='1' cellpadding='1'>
<tr> <th>Id</th> <th>First Name</th> <th>Last Name</th> <th>DOB</th> <th>Gender</th> <th>Local Address</th> <th>E-Mail</th> <th>Mobile</th> <th>Grad_Year</th>
<th>Major_Cd</th> <th>Major</th> <th>Options</th> <th>Dept_Cd</th> <th>Department</th> <th>Dept_Location</th> <th>Membership</th> <th>Aggie Ring</th>
<th>Membership Type</th> <th>Expected Rewards</th> <th>Update Info</th></tr>

<?php
// Display results of database query in a table
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
}
//mysqli_free_result($result);
if (isset($_POST['submit']))
{
$same_id = $_POST['same_id'];
$new_addr = $_POST['new_addr'];
$new_email = $_POST['new_email'];
$new_mob = preg_replace('/[^0-9+-]/', '', $_POST['new_mob']);
$nsql = "UPDATE student SET LOCAL_ADDRESS = '$new_addr', EMAIL = '$new_email', MOBILE = '$new_mob' WHERE STU_ID = '$same_id'";

// Print Response from MySQL
if ($conn->query($nsql) === TRUE)
    {
	echo "<script>
    alert('Records Got Updated into the Tables Successfully!!!');
    window.location.href='search.php';
    </script>";
	}
else {
	die ("Error: {$conn->errno} : {$conn->error}");
	}
}
CloseCon($conn);
?>

<form action=edit.php method=post>
<tr>
 <td> <input type = "text" name = "same_id" value = "<?php echo $row['STU_ID']; ?>" readonly> </td>           
 <td> <?php echo $row['FIRST_NAME']; ?></td>
 <td> <?php echo $row['LAST_NAME']; ?></td>
 <td> <?php echo $row['DOB']; ?></td>
 <td> <?php echo $row['GENDER']; ?></td>
 <td> <input type = "text" maxlength = "180" name = "new_addr" value = "<?php echo $row['LOCAL_ADDRESS']; ?>"> </td>
 <td> <input type = "text" maxlength = "35" name =  "new_email" value = "<?php echo $row['EMAIL']; ?>"> </td>
 <td> <input type = "text" maxlength = "15" name = "new_mob" value = "<?php echo $row['MOBILE']; ?>"> </td>
 <td> <?php echo $row['GRAD_YEAR']; ?></td>
 <td> <?php echo $row['MAJOR_CD']; ?></td>
 <td> <?php echo $row['MAJOR']; ?></td>
 <td> <?php echo $row['OPTIONS']; ?></td>
 <td> <?php echo $row['DEPT_CD']; ?></td>
 <td> <?php echo $row['DEPARTMENT_NAME']; ?></td>
 <td> <?php echo $row['DEPT_LOCATION']; ?></td>
 <td> <?php echo $row['MEM_TAKEN']; ?></td>
 <td> <?php echo $row['FREE_RING']; ?></td>
 <td> <?php echo $row['MEM_TY']; ?></td>
 <td> <?php echo $row['REWARD_EXPECT']; ?></td>
 <td><input type="submit" name="submit" value="Update"></td>
</tr>
</form>
</table>
</body>
</html>