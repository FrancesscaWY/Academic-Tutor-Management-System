<?php
$pwd = file_get_contents('D:/PHP/file/S_T_ADMIN_SYS/src/pw.txt');
$db_host = 'localhost';
$db_user = 'root';
$db_password = $pwd;
$db_name = 'Academic_Tutor_Management_System';
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die('Database connection error');

// 获取当前导师的编号
$current_tutor_no = $_COOKIE['copy_account'];

//获取当前老师的姓名
$sql = "SELECT TNAME FROM TUTORS WHERE TNO=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $current_tutor_no);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$t_name = $row['TNAME'];

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

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="zh_cn">
    <title>导师页面</title>
    <link rel="stylesheet" href="src/tutor__.css">
</head>
<body>
<div id="container">
    <div id="sidebar">
        <h2>导师导航</h2>
        <a href="#home" onclick="showSection('home')">首页</a>
        <a href="#my-students" onclick="showSection('my-students')">我的学生</a>
        <a href="#student-applications" onclick="showSection('student-applications')">学生申请</a>
        <a href="#cancellation-requests" onclick="showSection('cancellation-requests')">退选申请</a>
    </div>
    <div id="main-content">
        <div id="home" class="content-section">
            <h2><?php echo $t_name ?>老师，您好！</h2>
            <p>欢迎来到导师页面。</p>
            <p>您可以在这里查看您已选择的学生、选择您为导师的学生以及处理学生的退选请求。</p>
            <p>您可以通过左侧的导航链接查看相关内容。</p>
            <p>如果您有任何问题，请联系管理员。</p>
            <p>谢谢！</p>
            <p>祝您工作愉快！</p>
            <p>请选择左侧的导航链接以查看相关内容。</p>
        </div>
        <div id="my-students" class="content-section">
            <h2>您已选择的学生</h2>
            <?php
            $sql_selected = "SELECT SNO, SNAME, SDEPT FROM T_CHOICE_S WHERE TNO='$current_tutor_no'";
            $result_selected = mysqli_query($conn, $sql_selected);

            echo "<table border='1'>
            <tr>
            <th>学号</th>
            <th>姓名</th>
            <th>专业</th>
            </tr>";

            while ($row = mysqli_fetch_assoc($result_selected)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['SNO']) . "</td>";
                echo "<td>" . htmlspecialchars($row['SNAME']) . "</td>";
                echo "<td>" . htmlspecialchars($row['SDEPT']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>
        <div id="student-applications" class="content-section">
            <h2>选择您为导师的学生</h2>
            <table border='1'>
                <tr>
                    <th>学号</th>
                    <th>姓名</th>
                    <th>专业</th>
                    <th>志愿类型</th>
                    <th>操作选项</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['SNO']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['SNAME']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['SDEPT']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['CHOICE_TYPE']) . "</td>";
                    echo "<td><button class='t_choice_s' onclick='selectStudent(this)'>选择他/她</button></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <div id="cancellation-requests" class="content-section">
            <h2>退选请求</h2>
            <?php
            $sql = "SELECT request_id, student_no, sname, request_message, request_date
                    FROM CANCELLATION_REQUESTS
                    WHERE tutor_no = '$current_tutor_no' AND request_status = 'pending'";
            $result = mysqli_query($conn, $sql);

            echo "<table border='1'>
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
        </div>
    </div>
</div>
<script>
    // 显示特定的内容区域
    function showSection(sectionId) {
        var sections = document.getElementsByClassName('content-section');
        for (var i = 0; i < sections.length; i++) {
            sections[i].style.display = 'none';
        }
        document.getElementById(sectionId).style.display = 'block';

        // 设置导航栏的活动状态
        var navLinks = document.querySelectorAll('#sidebar a');
        navLinks.forEach(link => link.classList.remove('active'));
        var activeLink = Array.from(navLinks).find(link => link.onclick.toString().includes(sectionId));
        if (activeLink) {
            activeLink.classList.add('active');
        }
    }

    // 默认显示首页
    window.onload = function() {
        showSection('home');
    }

    // 选择学生的处理函数
    function selectStudent(button) {
        let row = button.parentNode.parentNode;
        let sno = row.children[0].innerText;
        let sname = row.children[1].innerText;
        let sdept = row.children[2].innerText;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'store_t_s_choice.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('sno=' + sno + '&sname=' + sname + '&sdept=' + sdept);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const status = xhr.responseText
                console.log("状态码：" + status)
                if (status === "1") {
                    alert('操作成功');
                } else {
                    alert('操作失败');
                }
                button.innerText = '已选择';
                button.disabled = true;
                location.reload(); // 刷新页面以更新显示
            }
        }
    }

    // 处理退选请求
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
</body>
</html>
