<?php
$pwd=file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host='localhost';
$db_user='root';
$db_password=$pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_password,$db_name) or die('Database connection error');
echo 'Connected successfully<br>';
$sql1="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20180001','张三','男','2000-01-01','计算机系');";
$sql2="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20180002','李四','女','2000-02-02','计算机系');";
$sql3="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20180003','王五','男','2000-03-03','计算机系');";
//$sql4="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170001','张教授','教授','男','1970-01-01','计算机系','人工智能');";
mysqli_query($conn,$sql1) or die('Insert data failed: '.mysqli_error($conn));
mysqli_query($conn,$sql2) or die('Insert data failed: '.mysqli_error($conn));
mysqli_query($conn,$sql3) or die('Insert data failed: '.mysqli_error($conn));


//$sql="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170002','李光','教授','男','1970-02-02','计算机系','人工智能');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170003','王刚','教授','男','1970-03-03','计算机系','人工智能');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170004','赵心','教授','女','1970-04-04','计算机系','量子计算机');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170005','孙明','教授','男','1970-05-05','计算机系','量子计算机');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170006','周杰','教授','男','1970-06-06','计算机系','量子计算机');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170007','吴亮','教授','男','1970-07-07','计算机系','量子计算机');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170008','郑明','教授','男','1970-08-08','计算机系','量子计算机');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170009','马亮','教授','男','1970-09-09','计算机系','量子计算机');";
//mysqli_multi_query($conn,$sql) or die('Insert data failed: '.mysqli_error($conn));
echo 'Insert data successfully<br>';
$conn->close();
?>