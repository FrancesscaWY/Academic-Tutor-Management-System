<?php
$pwd=file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_pd= $pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_pd,$db_name) or die('Connected successfully');
$sql="CREATE TRIGGER trigger_tu_acc AFTER INSERT ON TEACHERS FOR EACH ROW";
$sql.="BEGIN";
$sql.="INSERT INTO T_ACCOUNT(T_ACC,T_PWD)VALUES(NEW.TNO,SUBSTR(NEW.TNO,-5));";
$sql.="END";
mysqli_query($conn,$sql) or die('Create trigger failed: '.mysqli_error($conn));
mysqli_close($conn);