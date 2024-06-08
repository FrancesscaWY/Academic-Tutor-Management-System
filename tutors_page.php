<!--//将学生的选择以表格形式输出-->
<?php
$pwd = file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_pd = $pwd;
$db_name = 'Academic_Tutor_Management_System';
$conn = mysqli_connect($db_host, $db_user, $db_pd, $db_name) or die('Connected successfully');
echo "Connected successfully";

if (isset($_COOKIE['account'])) {
    $account = htmlspecialchars($_COOKIE['account']);
    echo "Welcome back, " . $account . "!";
} else {
    echo "Welcome, guest!";
}
echo $_COOKIE['copy_account'];
//为什么存入的COOKie只有一个数字，而不是账号
$sql = "SELECT SNO,SNAME,SDEPT FROM S_CHOICE_T WHERE FRIST_TNO=" . $_COOKIE['copy_account'];
$result = mysqli_query($conn, $sql);
//将学生的选择以表格形式输出
echo "<h2>第一选择为您的学生</h2><table border='1'>
<tr>
<th>学号</th>
<th>姓名</th>
<th>专业</th>
<th colspan='2'>操作选项</th>
</tr>";
while ($row = mysqli_fetch_assoc($result)) {
    $sql = "SELECT SNO,SNAME,SDEPT FROM T_CHOICE_S WHERE SNO=" . $row['SNO'];
    $result2 = mysqli_query($conn, $sql);
    if ($result2 == false) {
        echo "<tr>";
        echo "<td>" . $row['SNO'] . "</td>";
        echo "<td>" . $row['SNAME'] . "</td>";
        echo "<td>" . $row['SDEPT'] . "</td>";
        echo "<td><button>查看学生信息</button></td>";
        echo "<td><button class='t_choice_s'>选择他/她</button></td>";
        echo "</tr>";
    }
}
echo "</table>";
$sql0 = "SELECT SNO,SNAME,SDEPT FROM S_CHOICE_T WHERE SECOND_TNO=" . $_COOKIE['copy_account'];
$result0 = mysqli_query($conn, $sql0);
//将学生的选择以表格形式输出
echo "<h2>第二选择为您的学生</h2><table border='1'>
<tr>
<th>学号</th>
<th>姓名</th>
<th>专业</th>
<th colspan='2'>操作选项</th>
</tr>";
while ($row = mysqli_fetch_assoc($result0)) {
    $sql = "SELECT SNO,SNAME,SDEPT FROM T_CHOICE_S WHERE SNO=" . $row['SNO'];
    $result3 = mysqli_query($conn, $sql);
    if ($result3 == false) {
        echo "<tr>";
        echo "<td>" . $row['SNO'] . "</td>";
        echo "<td>" . $row['SNAME'] . "</td>";
        echo "<td>" . $row['SDEPT'] . "</td>";
        echo "<td><button>查看学生信息</button></td>";
        echo "<td><button class='t_choice_s'>选择他/她</button></td>";
        echo "</tr>";
    }
}
echo "</table>";
$sql1 = "SELECT SNO,SNAME,SDEPT FROM S_CHOICE_T WHERE THIRD_TNO=" . $_COOKIE['copy_account'];
$result1 = mysqli_query($conn, $sql1);
//将学生的选择以表格形式输出
echo "<h2>第三选择为您的学生</h2><table border='1'>
<tr>
<th>学号</th>
<th>姓名</th>
<th>专业</th>
<th colspan='2'>操作选项</th>
</tr>";
while ($row = mysqli_fetch_assoc($result1)) {
    $sql = "SELECT SNO,SNAME,SDEPT FROM T_CHOICE_S WHERE SNO=" . $row['SNO'];
    $result4 = mysqli_query($conn, $sql);

    if ($result4 == false) {
        echo "<tr>";
        echo "<td>" . $row['SNO'] . "</td>";
        echo "<td>" . $row['SNAME'] . "</td>";
        echo "<td>" . $row['SDEPT'] . "</td>";
        echo "<td><button>查看学生信息</button></td>";
        echo "<td><button class='t_choice_s'>选择他/她</button></td>";
        echo "</tr>";
    }
}
echo "</table>";

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="zh_cn">
    <title>导师页面</title>
</head>
<body>

</body>
<!--点击按钮选择学生-->
<script>
    //为按钮绑定事件
    var store_T_S = document.getElementsByClassName('t_choice_s');
    //当点击按钮时，将学生的选择存入数据库
    for (let i = 0; i < store_T_S.length; i++) {
        store_T_S[i].onclick = function () {
            let sname = this.parentNode.parentNode.children[1].innerText;
            let sno = this.parentNode.parentNode.children[0].innerText;
            let sdept = this.parentNode.parentNode.children[2].innerText;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'store_t_s_choice.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('sname=' + sname + '&sno=' + sno + '&sdept=' + sdept);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                }
            }
        }
    }
    //按钮点击后，不可再次点击，即使刷新页面也不可再次点击
    for (let i = 0; i < store_T_S.length; i++) {
        store_T_S[i].onclick = function () {
            this.innerText = '已选择';
            this.disabled = true;
        }
    }

</script>
<!--//查询已选择的学生-->
<?php
$pwd = file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_password = $pwd;
$db_name = 'Academic_Tutor_Management_System';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die('Database connection error');
$sql = "SELECT SNO,SNAME,SDEPT FROM T_CHOICE_S WHERE TNO=" . $_COOKIE['copy_account'];
$result = mysqli_query($conn, $sql);
echo "<h2>您已选择的学生</h2><table border='1'>
        <tr>
        <th>学号</th>
        <th>姓名</th>
        <th>专业</th>
        </tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['SNO'] . "</td>";
    echo "<td>" . $row['SNAME'] . "</td>";
    echo "<td>" . $row['SDEPT'] . "</td>";
    echo "</tr>";
}
echo "</table>";
if ($result) {
    echo "查询成功";
} else {
    echo "查询失败";
}
?>
</html>
