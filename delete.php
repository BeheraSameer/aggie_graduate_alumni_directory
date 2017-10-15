<?php
session_start();

if (!isset($_SESSION['loggedin']))
{
	$_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
	header('location:index.php');
}
?>
<?php
// Check if the 'id' variable is set in URL, and check that it is valid
if (isset($_GET['delete']))
{
$id = $_GET['delete'];
//$new_dt = date('Y')-30;
// Connect to the database
include('db_connect.php');
$conn = OpenCon();

// Delete the entry
$sql = "DELETE t1, t2, t3, t4 From stu_mem as t1 INNER JOIN stu_dept as t2 on t1.STU_ID = t2.STU_ID
INNER JOIN  stu_maj as t3 on t1.STU_ID=t3.STU_ID INNER JOIN  student as t4 on t1.STU_ID=t4.STU_ID
WHERE t1.STU_ID = '$id'";
$result = $conn->query($sql);

if ($conn->affected_rows>0)
{
echo "<script>
    alert('Records Deleted');
    window.location.href='search.php';
    </script>";
}
else
{
echo "<script>
    alert('No Records Deleted');
    window.location.href='search.php';
    </script>";
}
mysqli_free_result($result);
CloseCon($conn);
}

else
// If Id isn't set, or isn't valid, redirect back to view page
{
echo "<script>
    alert('No Valid Delete Id Found);
    window.location.href='search.php';
    </script>";
}

?>