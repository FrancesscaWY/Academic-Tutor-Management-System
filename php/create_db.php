<?php
//读取pwd.txt文件中的数据库密码
$pwd = file_get_contents('./src/pw.txt');
$db_host='localhost';
$db_user='root';
$db_password=$pwd;
$conn=mysqli_connect($db_host,$db_user,$db_password) or die('Database connection error');
echo 'Connected successfully';
//创建数据库
$sql0='CREATE DATABASE IF NOT EXISTS Academic_Tutor_Management_System;';
mysqli_query($conn,$sql0) or die('Database creation failed');
echo 'Database created successfully';
