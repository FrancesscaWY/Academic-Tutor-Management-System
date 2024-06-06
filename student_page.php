<?php
$pwd=file_get_contents('./src/pw.txt');
$db_host='localhost';
$db_user='root';
$db_password=$pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_password,$db_name) or die('Database connection error');
//将Tutor表中的数据显示出来
$sql="SELECT * FROM TUTORS";
$result=mysqli_query($conn,$sql);
echo "<table border='1' id='chose_teacher'>
<tr>
<th>序号</th>
<th>教师编号</th>
<th>姓名</th>
<th>职称</th>
<th>性别</th>
<th>专业</th>
<th>研究方向</th>
</tr>";
while($row=mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>".$row['T_ID']."</td>";
    echo "<td>".$row['TNO']."</td>";
    echo "<td>".$row['TNAME']."</td>";
    echo "<td>".$row['PROFESSIONAL_TITLE']."</td>";
    echo "<td>".$row['TSEX']."</td>";
    echo "<td>".$row['MAJIOR']."</td>";
    echo "<td>".$row['RESEARCH_FIELD']."</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($conn);
?>
<?php
$pwd=file_get_contents('./src/pw.txt');
$db_host='localhost';
$db_user='root';
$db_password=$pwd;
$db_name='Academic_Tutor_Management_System';
$conn=mysqli_connect($db_host,$db_user,$db_password,$db_name) or die('Database connection error');
$sql1="SELECT SNO,SNAME,SDEPT FROM STUDENTS WHERE SNO=".$_COOKIE['copy_account'];
$result1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_assoc($result1);
$NAME=$row1['SNAME'];
$DEPT=$row1['SDEPT'];
$SNO=$row1['SNO'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>学生选课</title>
    <style>
        table{
            width: 50%;
            border-collapse: collapse;

        }
        table,th,td{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>学生选课</h1>
    <form action="store_std_choice.php" method="POST">
        <label for="sno">学号:</label>
        <input type="text" name="sno" id="sno"><br>
        <label for="sname">姓名:</label>
        <input type="text" name="sname" id="sname"><br>
        <label for="sdept">专业:</label>
        <input type="text" name="sdept" id="sdept"><br>
        <label for="first_tno">第一志愿教师编号:</label>
        <input type="text" name="first_tno" id="first_tno"><br>
        <label for="second_tno">第二志愿教师编号:</label>
        <input type="text" name="second_tno" id="second_tno"><br>
        <label for="third_tno">第三志愿教师编号:</label>
        <input type="text" name="third_tno" id="third_tno"><br>
        <input type="submit" value="提交">
    </form>
</body>
<SCRIPT>
    document.getElementById('sno').value="<?php echo $SNO;?>";
    document.getElementById('sname').value="<?php echo $NAME;?>";
    document.getElementById('sdept').value="<?php echo $DEPT;?>";
</SCRIPT>
</html>


