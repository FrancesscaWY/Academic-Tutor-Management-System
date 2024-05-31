<?php
$pwd=file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_pd= $pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_pd,$db_name) or die('Connected successfully');
//创建触发器
$sql="CREATE TRIGGER triger_std_acc AFTER INSERT ON STUDENTS FOR EACH ROW";
$sql.="BEGIN";
//
$sql.="INSERT INTO STD_ACCOUNT(STD_ACC,STD_PD)VALUE(NEW.SNO,SUBSTRING(NEW.SNO,-6));";
$sql.="END";
if(mysqli_query($conn,$sql)){
    echo 'Create trigger successfully';
}else{
    echo 'Create trigger failed: '.mysqli_error($conn);
}
mysqli_close($conn);