<?php
$pwd=file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host='localhost';
$db_user='root';
$db_password=$pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_password,$db_name) or die('Database connection error');
echo 'Connected successfully<br>';
//$sql1="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20180001','张三','男','2000-01-01','计算机系');";
//$sql2="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20180002','李四','女','2000-02-02','计算机系');";
//$sql3="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20180003','王五','男','2000-03-03','计算机系');";
////$sql4="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170001','张教授','教授','男','1970-01-01','计算机系','人工智能');";
//mysqli_query($conn,$sql1) or die('Insert data failed: '.mysqli_error($conn));
//mysqli_query($conn,$sql2) or die('Insert data failed: '.mysqli_error($conn));
//mysqli_query($conn,$sql3) or die('Insert data failed: '.mysqli_error($conn));


//$sql="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170002','李光','教授','男','1970-02-02','计算机系','人工智能');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170003','王刚','教授','男','1970-03-03','计算机系','人工智能');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170004','赵心','教授','女','1970-04-04','计算机系','量子计算机');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170005','孙明','教授','男','1970-05-05','计算机系','量子计算机');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170006','周杰','教授','男','1970-06-06','计算机系','量子计算机');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170007','吴亮','教授','男','1970-07-07','计算机系','量子计算机');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170008','郑明','教授','男','1970-08-08','计算机系','量子计算机');";
//$sql.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170009','马亮','教授','男','1970-09-09','计算机系','量子计算机');";
//mysqli_multi_query($conn,$sql) or die('Insert data failed: '.mysqli_error($conn));
//$sql0="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181001','钱六','男','2004-01-01','软件工程');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181002','周七','女','2004-02-02','软件工程');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181003','吴八','男','2004-03-03','软件工程');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181004','郑九','女','2004-04-04','软件工程');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181005','马十','男','2004-05-05','网络工程');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181006','陈十一','女','2004-06-06','网络工程');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181007','黄十二','男','2004-07-07','网络工程');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181008','林十三','女','2004-08-08','网络工程');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181009','张十四','男','2004-09-09','信息安全');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181010','李十五','女','2004-10-10','信息安全');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181011','王十六','男','2004-11-11','信息安全');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181012','赵十七','女','2004-12-12','信息安全');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181013','孙十八','男','2004-01-13','物联网');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181014','周十九','女','2004-02-14','物联网');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181015','吴二十','男','2004-03-15','物联网');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181016','郑二十一','女','2004-04-16','物联网');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181017','钱二十二','男','2004-05-17','大数据');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181018','马二十三','女','2004-06-18','大数据');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181019','陈二十四','男','2004-07-19','大数据');";
//$sql0.="INSERT INTO STUDENTS(SNO,SNAME,SSEX,BIRTHDATE,SDEPT)VALUES('20181020','黄二十五','女','2004-08-20','大数据');";
//$sql0="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170210','张新','教授','男','1970-10-10','计算机系','人工智能');";
//$sql0.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170211','李明','教授','女','1970-2-11','计算机系','区块链');";
$sql0.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170212','王亮','教授','男','1970-3-12','计算机系','人工智能');";
$sql0.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170213','赵明','教授','女','1970-4-13','计算机系','区块链');";
$sql0.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170214','孙亮','教授','男','1970-5-14','计算机系','人工智能');";
$sql0.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170215','周明','教授','女','1970-6-15','计算机系','区块链');";
$sql0.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170216','吴亮','教授','男','1970-7-16','计算机系','人工智能');";
$sql0.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170217','郑明','教授','女','1970-8-17','计算机系','区块链');";
$sql0.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170218','马亮','教授','男','1970-9-18','计算机系','软件工程理论');";
$sql0.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170219','陈明','教授','女','1970-10-19','计算机系','软件工程理论');";
$sql0.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170220','黄亮','教授','男','1970-11-20','计算机系','软件工程理论');";
$sql0.="INSERT INTO TUTORS(TNO,TNAME,PROFESSIONAL_TITLE,TSEX,TBIRTHDATE,MAJIOR,RESEARCH_FIELD)VALUES('20170221','林欣','教授','女','1970-12-21','计算机系','软件工程理论');";
$result=mysqli_multi_query($conn,$sql0) or die('Insert data failed: '.mysqli_error($conn));
echo 'Insert data successfully<br>';
$conn->close();
?>