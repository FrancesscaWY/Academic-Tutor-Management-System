<?php
$pwd=file_get_contents('./src/pw.txt');
$db_host='localhost';
$db_user='root';
$db_password=$pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_password,$db_name) or die('Database connection error');
echo'Connected successfully<br>';
$sql1='CREATE TABLE IF NOT EXISTS STUDENTS(
    STD_ID INT PRIMARY KEY,
    SNO INT(20) NOT NULL,
    SNAME CHAR(20) NOT NULL,
    SSEX CHAR(10) NOT NULL,
    BIRTHDATE DATE,
    SDEPT CHAR(20)
);';
mysqli_query($conn,$sql1) or die('Table creation failed');
echo 'Table_S created successfully<br>';
$SQL2='CREATE TABLE IF NOT EXISTS TUTORS (
    T_ID INT PRIMARY KEY,
    TNO INT(13) NOT NULL,
    TNAME CHAR(20) NOT NULL,
    PROFESSIONAL_TITLE CHAR(20),
    TSEX CHAR(1) NOT NULL,
    TBIRTHDATE DATE,
    MAJIOR CHAR(20),
    RESEARCH_FIELD CHAR(20)
);';
mysqli_query($conn,$SQL2) or die('table_T created error');
echo'Table_T created successfully<br>';
$sql3='CREATE TABLE IF NOT EXISTS S_CHOICE_T(
    S_C_ID INT PRIMARY KEY,
    SNO INT(13) NOT NULL,
    SNAME CHAR(20) NOT  NULL,
    FRIST_TNO INT(13) NOT NULL,
    SECOND_TNO INT(13) ,
    THIRD_TNO INT(13)                                 
);';
mysqli_query($conn,$sql3) or die('table_S_C_T created error');
echo 'Table_S_C_T created successfully<br>';
$sql4='CREATE TABLE IF NOT EXISTS T_CHOICE_S(
    T_C_ID INT PRIMARY KEY,
    TNO INT(13) NOT NULL,
    TNAME CHAR(20),
    SNO INT(13) NOT NULL,
    SNAME CHAR(20)
);';
mysqli_query($conn,$sql4) or die('table_T_C_S created error');
echo 'Table_T_C_S created successfully<br>';