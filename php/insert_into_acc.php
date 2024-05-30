<?php
$pwd=file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host ='localhost';
$db_user='root';
$db_password=$pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_password,$db_name) or die('Database connection error');
echo 'Connected successfully<br>';
//从students表中获取数据插入到std_account表中
$sql="SELECT SNO FROM STUDENTS";
$result=mysqli_query($conn,$sql);
//取学号后六位为密码
while($row=mysqli_fetch_assoc($result)){
    $account=$row['SNO'];
    $password=substr($account,-6);
    $sql1="INSERT INTO STD_ACCOUNT(STD_ACC,STD_PD) VALUES(?,?)";
    $stmt=$conn->prepare($sql1);
    $stmt->bind_param('ss',$account,$password);
    if($stmt->execute()){
        echo 'Insert data successfully<br>';
    }else{
        echo 'Insert data failed: '.$stmt->error;
    }
}
$stmt->close();

//创建触发器，当students表中插入数据时，将学号和学号后六位插入std_acc表
//创建触发器
$conn->close();
?>

