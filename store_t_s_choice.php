<?php
$pwd=file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host='localhost';
$db_user='root';
$db_password=$pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_password,$db_name) or die('Database connection error');
echo'Connected successfully<br>';
$sname=$_POST['sname'];
$sno=$_POST['sno'];
$sdept=$_POST['sdept'];
$status=0;

$sql="SELECT TNAME,TNO,MAJIOR FROM TUTORS WHERE TNO=".$_COOKIE['copy_account'];
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$tname=$row['TNAME'];
$tno=$row['TNO'];
$major=$row['MAJIOR'];
$sql1="INSERT INTO T_CHOICE_S(TNO,TNAME,MAJIOR,SNO,SNAME,SDEPT) VALUES(?,?,?,?,?,?)";
$stmt=$conn->prepare($sql1);
$stmt->bind_param('isssss',$tno,$tname,$major,$sno,$sname,$sdept);
if($stmt->execute()){
    echo'Insert data successfully<br>';
    $status=1;
}else{
    echo'Insert data failed: '.$stmt->error;

}
//将status返回给tutor_page.php
echo $status;

$stmt->close();
$conn->close();
?>