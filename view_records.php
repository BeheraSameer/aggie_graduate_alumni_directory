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
<title>View Records</title>
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
<h1>All Alumni Records</h1>
</head>
<body>
<center><p><a href="search.php">Back to Search</a>&nbsp&nbsp<a href="new_record.php">Add a New Alumni</a></p></center>

<?php
// Connect to the database
include('db_connect.php');
$conn = OpenCon();

// Get results from database
$sql = "SELECT A.STU_ID AS STU_ID,FIRST_NAME,LAST_NAME,DOB,GENDER,LOCAL_ADDRESS,EMAIL,MOBILE,GRAD_YEAR,
C.MAJOR_CD AS MAJOR_CD,MAJOR,OPTIONS,E.DEPT_CD AS DEPT_CD,DEPARTMENT_NAME,DEPT_LOCATION,G.MEM_TAKEN AS MEM_TAKEN,FREE_RING,MEM_TY,REWARD_EXPECT
FROM student A JOIN stu_maj B ON A.STU_ID=B.STU_ID JOIN majors C ON C.MAJOR_CD=B.MAJOR_CD JOIN stu_dept D ON A.STU_ID=D.STU_ID
JOIN department E ON E.DEPT_CD=D.DEPT_CD JOIN stu_mem F ON A.STU_ID=F.STU_ID JOIN membership G ON G.MEM_TAKEN=F.MEM_TAKEN ORDER BY GRAD_YEAR DESC";

$result = $conn->query($sql);
?>
<table border='1' cellpadding='1'>
<tr> <th>Id</th> <th>First Name</th> <th>Last Name</th> <th>DOB</th> <th>Gender</th> <th>Local Address</th> <th>E-Mail</th> <th>Mobile</th> <th>Grad_Year</th>
<th>Major_Cd</th> <th>Major</th> <th>Options</th> <th>Dept_Cd</th> <th>Department</th> <th>Dept_Location</th> <th>Membership</th> <th>Aggie Ring</th>
<th>Membership Type</th> <th>Expected Rewards</th> <th>Update Info</th> <th>Remove Record</th></tr>
<?php
// Loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
{
$id = $row['STU_ID'];
$fname = $row['FIRST_NAME'];
$lname = $row['LAST_NAME'];
$dob = $row['DOB'];
$gen = $row['GENDER'];
$addr = $row['LOCAL_ADDRESS'];
$email = $row['EMAIL'];
$mob = $row['MOBILE'];
$gyear = $row['GRAD_YEAR'];
$mj_cd = $row['MAJOR_CD'];
$mj = $row['MAJOR'];
$opt = $row['OPTIONS'];
$d_cd = $row['DEPT_CD'];
$dname = $row['DEPARTMENT_NAME'];
$d_loc = $row['DEPT_LOCATION'];
$m = $row['MEM_TAKEN'];
$ring = $row['FREE_RING'];
$m_ty = $row['MEM_TY'];
$rew = $row['REWARD_EXPECT'];
?>

 <tr>
 <td> <?php echo $id; ?></td>           
 <td> <?php echo $fname; ?></td>
 <td> <?php echo $lname; ?></td>
 <td> <?php echo $dob; ?></td>
 <td> <?php echo $gen; ?></td>
 <td> <?php echo $addr; ?></td>
 <td> <?php echo $email; ?></td>
 <td> <?php echo $mob; ?></td>
 <td> <?php echo $gyear; ?></td>
 <td> <?php echo $mj_cd; ?></td>
 <td> <?php echo $mj; ?></td>
 <td> <?php echo $opt; ?></td>
 <td> <?php echo $d_cd; ?></td>
 <td> <?php echo $dname; ?></td>
 <td> <?php echo $d_loc; ?></td>
 <td> <?php echo $m; ?></td>
 <td> <?php echo $ring; ?></td>
 <td> <?php echo $m_ty; ?></td>
 <td> <?php echo $rew; ?></td>
 <td><a href="edit.php?edit=<?php echo $id; ?>">Edit</a></td>
 <td><a href="delete.php?delete=<?php echo $id; ?>" onclick="return confirm('Are You Sure?');">Delete</a></td>
 </tr>

<?php
}
mysqli_free_result($result);
CloseCon($conn);
?>
</table>
</body>
</html>