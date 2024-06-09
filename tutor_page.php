<?php
$pwd = file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_password = $pwd;
$db_name = 'Academic_Tutor_Management_System';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die('Database connection error');

// 获取当前导师的编号
$current_tutor_no = $_COOKIE['copy_account'];

// 查询所有选择当前导师为第一、第二或第三志愿的学生
$sql = "
SELECT DISTINCT 
    SCHOICES.SNO, 
    SCHOICES.SNAME, 
    SCHOICES.SDEPT, 
    CASE 
        WHEN SCHOICES.FRIST_TNO = '$current_tutor_no' THEN '第一志愿'
        WHEN SCHOICES.SECOND_TNO = '$current_tutor_no' THEN '第二志愿'
        WHEN SCHOICES.THIRD_TNO = '$current_tutor_no' THEN '第三志愿'
    END AS CHOICE_TYPE
FROM 
    S_CHOICE_T SCHOICES
WHERE 
    '$current_tutor_no' IN (SCHOICES.FRIST_TNO, SCHOICES.SECOND_TNO, SCHOICES.THIRD_TNO)
    AND NOT EXISTS (
        SELECT 1
        FROM T_CHOICE_S T_CHOICES 
        WHERE T_CHOICES.SNO = SCHOICES.SNO 
        AND T_CHOICES.TNO = '$current_tutor_no'
    )
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Query error: ' . mysqli_error($conn));
}

echo "<h2>选择您为导师的学生</h2><table border='1'>
<tr>
<th>学号</th>
<th>姓名</th>
<th>专业</th>
<th>志愿类型</th>
<th>操作选项</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['SNO']) . "</td>";
    echo "<td>" . htmlspecialchars($row['SNAME']) . "</td>";
    echo "<td>" . htmlspecialchars($row['SDEPT']) . "</td>";
    echo "<td>" . htmlspecialchars($row['CHOICE_TYPE']) . "</td>";
    echo "<td><button class='t_choice_s'>选择他/她</button></td>";
    echo "</tr>";
}
echo "</table>";






$sql_selected = "SELECT SNO, SNAME, SDEPT FROM T_CHOICE_S WHERE TNO='$current_tutor_no'";
$result_selected = mysqli_query($conn, $sql_selected);

echo "<h2>您已选择的学生</h2><table border='1'>
<tr>
<th>学号</th>
<th>姓名</th>
<th>专业</th>
</tr>";

while ($row = mysqli_fetch_assoc($result_selected)) {
    echo "<tr>";
    echo "<td>" . $row['SNO'] . "</td>";
    echo "<td>" . $row['SNAME'] . "</td>";
    echo "<td>" . $row['SDEPT'] . "</td>";
    echo "</tr>";
}
echo "</table>";


$sql = "SELECT request_id, student_no, sname, request_message, request_date
FROM CANCELLATION_REQUESTS
WHERE tutor_no = '$current_tutor_no' AND request_status = 'pending'";
$result = mysqli_query($conn, $sql);

echo "<h2>退选请求</h2><table border='1'>
    <tr>
        <th>学号</th>
        <th>学生姓名</th>
        <th>请求内容</th>
        <th>请求日期</th>
        <th>操作</th>
    </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
        echo "<td>" . htmlspecialchars($row['student_no']) . "</td>";
        echo "<td>" . htmlspecialchars($row['sname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['request_message']) . "</td>";
        echo "<td>" . htmlspecialchars($row['request_date']) . "</td>";
        echo "<td>
            <button onclick=\"handleRequest('approve', " . $row['request_id'] . ")\">同意</button>
            <button onclick=\"handleRequest('reject', " . $row['request_id'] . ")\">拒绝</button>
        </td>";
        echo "</tr>";
    }
    echo "</table>";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="zh_cn">
    <title>导师页面</title>
</head>
<body>
</body>
<script>
    // 为按钮绑定事件
    var store_T_S = document.getElementsByClassName('t_choice_s');

    for (let i = 0; i < store_T_S.length; i++) {
        store_T_S[i].onclick = function () {
            let row = this.parentNode.parentNode;
            let sno = row.children[0].innerText;
            let sname = row.children[1].innerText;
            let sdept = row.children[2].innerText;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'store_t_s_choice.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('sno=' + sno + '&sname=' + sname + '&sdept=' + sdept);

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    // 将按钮状态更新为“已选择”
                    store_T_S[i].innerText = '已选择';
                    store_T_S[i].disabled = true;
                }
            }
        }
    }

    // 页面加载时禁用已经选择的按钮
    window.onload = function() {
        for (let i = 0; i < store_T_S.length; i++) {
            if (store_T_S[i].innerText == '已选择') {
                store_T_S[i].disabled = true;
            }
        }
    }

    function handleRequest(action, requestId) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'handle_cancel_request.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('action=' + action + '&request_id=' + requestId);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                location.reload(); // 刷新页面以更新显示
            }
        }
    }
</script>
</html>