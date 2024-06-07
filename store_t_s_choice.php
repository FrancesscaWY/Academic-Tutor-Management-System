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
    $status++;
}else{
    echo'Insert data failed: '.$stmt->error;

}
//将status返回给tutor_page.php
echo $status;

$stmt->close();
$conn->close();
?>
<html>
<head>
    <title>store_t_s_choice</title>
</head>
<body>
    <h1>store_t_s_choice</h1>
</body>
<script>
    let status=<?php echo $status;?>;
    if(status==1){
        alert('选择成功');
    }
    if(status>1){
        alert('重复选择');
    }
    if(status<1){
        alert('选择失败');
    }
</script>

</html>
