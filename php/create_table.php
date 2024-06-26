<?php
$pwd=file_get_contents('D:\PHP\file\S_T_ADMIN_SYS\src\pw.txt');
$db_host='localhost';
$db_user='root';
$db_password=$pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_password,$db_name) or die('Database connection error');
echo'Connected successfully<br>';
$sql1='CREATE TABLE IF NOT EXISTS STUDENTS(
    STD_ID INT PRIMARY KEY AUTO_INCREMENT UNIQUE ,
    SNO CHAR(20) NOT NULL,
    SNAME CHAR(20) NOT NULL,
    SSEX CHAR(10) NOT NULL,
    BIRTHDATE DATE,
    SDEPT CHAR(20)
);';
mysqli_query($conn,$sql1) or die('Table creation failed');
echo 'Table_S created successfully<br>';

$SQL2='CREATE TABLE IF NOT EXISTS TUTORS (
    T_ID INT AUTO_INCREMENT PRIMARY KEY UNIQUE,
    TNO CHAR(13) NOT NULL,
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
    SNO CHAR(13) NOT NULL UNIQUE ,
    SNAME CHAR(20) NOT  NULL,
    SDEPT CHAR(20),
    FRIST_TNO CHAR(13) NOT NULL,
    SECOND_TNO CHAR(13) ,
    THIRD_TNO CHAR(13),
    APP_DATE TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (SNO,FRIST_TNO,SECOND_TNO,THIRD_TNO)
);';
mysqli_query($conn,$sql3) or die('table_S_C_T created error');
echo 'Table_S_C_T created successfully<br>';

$sql4='CREATE TABLE IF NOT EXISTS T_CHOICE_S(
    TNO CHAR(13) NOT NULL,
    TNAME CHAR(20),
    MAJIOR CHAR(20),
    SNO CHAR(13) NOT NULL  UNIQUE,
    SNAME CHAR(20),
    SDEPT CHAR(20),
    CHOOSE_DATE TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    PRIMARY KEY (TNO,SNO) 
);';
mysqli_query($conn,$sql4) or die('table_T_C_S created error');
echo 'Table_T_C_S created successfully<br>';

$sql5='CREATE TABLE IF NOT EXISTS STD_ACCOUNT(
    SA_ID INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
    STD_ACC CHAR(20) UNIQUE ,
    STD_PD CHAR(10) UNIQUE 
)';
$sql6='CREATE TABLE IF NOT EXISTS T_ACCOUNT(
    TA_ID INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
    T_ACC CHAR(13) UNIQUE ,
    T_PWD CHAR(20) UNIQUE 
)';
mysqli_query($conn,$sql5) or die('table std_account created error');
echo 'hi';
mysqli_query($conn,$sql6) or die('table t_accounr created error');
echo'hii';

$sql7="CREATE TABLE IF NOT EXISTS CANCELLATION_REQUESTS(
    REQUEST_ID INT AUTO_INCREMENT PRIMARY KEY ,
    STUDENT_NO VARCHAR(13) NOT NULL UNIQUE,
    SNAME CHAR(20),
    TUTOR_NO VARCHAR(13) NOT NULL,
    TNAME CHAR(20),
    REQUEST_MESSAGE TEXT NOT NULL,
    REQUEST_STATUS ENUM('PENDING','APPROVED','REJECTED')DEFAULT 'PENDING',
    REQUEST_DATE TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
)";
mysqli_query($conn,$sql7) or die('table cancellation_request created error');
echo 'h_ii_ii';