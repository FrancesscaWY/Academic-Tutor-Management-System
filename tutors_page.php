<?php
$pwd=file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_pd= $pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_pd,$db_name) or die('Connected successfully');
echo"Connected successfully";

