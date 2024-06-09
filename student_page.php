<?php
// 获取数据库连接信息
$pwd = file_get_contents('./src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_password = $pwd;
$db_name = 'Academic_Tutor_Management_System';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die('Database connection error');

// 获取导师表中的所有数据
$sql = "SELECT * FROM TUTORS";
$result = mysqli_query($conn, $sql);
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
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['T_ID'] . "</td>";
    echo "<td>" . $row['TNO'] . "</td>";
    echo "<td>" . $row['TNAME'] . "</td>";
    echo "<td>" . $row['PROFESSIONAL_TITLE'] . "</td>";
    echo "<td>" . $row['TSEX'] . "</td>";
    echo "<td>" . $row['MAJIOR'] . "</td>";
    echo "<td>" . $row['RESEARCH_FIELD'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_free_result($result); // 释放结果集

// 获取学生信息
$sno = $_COOKIE['copy_account'];
$sql1 = "SELECT SNO, SNAME, SDEPT FROM STUDENTS WHERE SNO = $sno";
$result1 = mysqli_query($conn, $sql1);
if ($row1 = mysqli_fetch_assoc($result1)) {
    $NAME = $row1['SNAME'];
    $DEPT = $row1['SDEPT'];
    $SNO = $row1['SNO'];
} else {
    die('Student not found.');
}
mysqli_free_result($result1); // 释放结果集

// 检查是否提交了导师申请
$sql2 = "SELECT * FROM S_CHOICE_T WHERE SNO = $sno";
$result2 = mysqli_query($conn, $sql2);

$application = 0;
$re_choose = 0;
$first_tno = '';
$second_tno = '';
$third_tno = '';
$first_tname = '';
$second_tname = '';
$third_tname = '';
$matched_tno = '';
$matched_tname = '';

if ($row2 = mysqli_fetch_assoc($result2)) {
    $application = 1; // 表示申请已提交
    $first_tno = $row2['FRIST_TNO'];
    $second_tno = $row2['SECOND_TNO'];
    $third_tno = $row2['THIRD_TNO'];

    // 获取导师的名字
    $sql_tutors = "SELECT TNO, TNAME FROM TUTORS WHERE TNO IN ('$first_tno', '$second_tno', '$third_tno')";
    $result_tutors = mysqli_query($conn, $sql_tutors);
    while ($row_tutor = mysqli_fetch_assoc($result_tutors)) {
        if ($row_tutor['TNO'] == $first_tno) {
            $first_tname = $row_tutor['TNAME'];
        } elseif ($row_tutor['TNO'] == $second_tno) {
            $second_tname = $row_tutor['TNAME'];
        } elseif ($row_tutor['TNO'] == $third_tno) {
            $third_tname = $row_tutor['TNAME'];
        }
    }
    mysqli_free_result($result_tutors); // 释放结果集

    // 检查导师是否选择了该学生
    $sql3 = "SELECT * FROM T_CHOICE_S WHERE SNO = $sno";
    $result3 = mysqli_query($conn, $sql3);
    if ($row3 = mysqli_fetch_assoc($result3)) {
        $re_choose = 1; // 表示导师已选择该学生
        $matched_tno = $row3['TNO'];

        // 获取匹配导师的名字
        $sql_matched_tutor = "SELECT TNAME FROM TUTORS WHERE TNO = '$matched_tno'";
        $result_matched_tutor = mysqli_query($conn, $sql_matched_tutor);
        if ($row_matched_tutor = mysqli_fetch_assoc($result_matched_tutor)) {
            $matched_tname = $row_matched_tutor['TNAME'];
        }
        mysqli_free_result($result_matched_tutor); // 释放结果集
    }
    mysqli_free_result($result3); // 释放结果集
}
mysqli_free_result($result2); // 释放结果集

mysqli_close($conn); // 关闭数据库连接
?>

<!DOCTYPE html>
<html>
<head>
    <title>学生页面</title>
    <meta charset="zh_cn">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .application {
            border: 1px solid black;
            margin: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>
<h1>选择导师</h1>
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
<div>
    <h2>导师申请进度</h2>
    <div class="application" id="app_status"></div>
    <div class="application" id="result_status"></div>
    <div class="application" id="review_status"></div>
    <div class="application" id="application_details"></div>
</div>
</body>

<script>
    // 自动填写学生信息
    document.getElementById('sno').value = "<?php echo $SNO; ?>";
    document.getElementById('sname').value = "<?php echo $NAME; ?>";
    document.getElementById('sdept').value = "<?php echo $DEPT; ?>";

    // 设置申请状态和选择状态
    let application = <?php echo $application; ?>;
    let re_choose = <?php echo $re_choose; ?>;
    let first_tno = "<?php echo $first_tno; ?>";
    let second_tno = "<?php echo $second_tno; ?>";
    let third_tno = "<?php echo $third_tno; ?>";
    let first_tname = "<?php echo $first_tname; ?>";
    let second_tname = "<?php echo $second_tname; ?>";
    let third_tname = "<?php echo $third_tname; ?>";
    let matched_tno = "<?php echo $matched_tno; ?>";
    let matched_tname = "<?php echo $matched_tname; ?>";

    // 检查申请状态
    if (application == 0) {
        // 情况1: 学生尚未提交申请
        document.getElementById('app_status').innerHTML = '<h3>您尚未提交导师申请</h3>';
        document.getElementById('review_status').innerHTML = '<h3>请填写申请表并提交。</h3>';
    } else {
        // 情况2: 学生已提交申请
        document.getElementById('app_status').innerHTML = '<h3>您的导师申请已提交</h3>';
        document.getElementById('application_details').innerHTML = `
            <h3>您申请的导师信息：</h3>
            <p>第一志愿导师：编号 - ${first_tno}，姓名 - ${first_tname}</p>
            <p>第二志愿导师：编号 - ${second_tno}，姓名 - ${second_tname}</p>
            <p>第三志愿导师：编号 - ${third_tno}，姓名 - ${third_tname}</p>
        `;

        if (re_choose == 0) {
            // 情况3: 学生已提交申请，但导师尚未选择
            document.getElementById('review_status').innerHTML = '<h3>导师正在查看您的申请，请耐心等待......</h3>';
            document.getElementById('result_status').innerHTML = '<h3>您目前还没有被导师选择。</h3>';
        } else {
            // 情况4: 学生已提交申请，且导师已选择
            document.getElementById('review_status').innerHTML = `
                <h3>导师选择信息：</h3>
                <p>您已被导师选择：</p>
                <p>导师编号 - ${matched_tno}，姓名 - ${matched_tname}</p>
            `;
            document.getElementById('result_status').innerHTML = '<h3>恭喜！您已被导师选择。</h3>';
        }
    }
</script>
