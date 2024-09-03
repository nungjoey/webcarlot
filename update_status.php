<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APS KU - Update Status</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h2>APS KU</h2>
        </div>
        <ul>
            <li><a href="accept_return.php" class="menu-item">Accept Return</a></li>
            <li><a href="update_status.php" class="menu-item active">Update Status</a></li>
            <li><a href="small.php" class="menu-item">Monitor</a></li>
        </ul>
        <div class="version">
            <p>Version 2.0</p>
        </div>
    </div>

    <div class="main-content">
        <h1>Update Status</h1>

        <div class="status-update-section">
            <form action="update_status.php" method="POST">
                <label>อัพเดทสถานะเมื่อผ่านที่กั้น:</label>
                <input type="text" name="gate_id" placeholder="ไอดีการ์ด" required>
                <button type="submit" name="update_gate_status">อัพเดท</button>
            </form>
        </div>

        <div class="status-update-section">
            <form action="update_status.php" method="POST">
                <label>อัพเดทการ์ดไอดีว่าง:</label>
                <input type="text" name="card_id" placeholder="ไอดีการ์ด" required>
                <button type="submit" name="update_card_status">อัพเดท</button>
            </form>
        </div>

        <!-- ส่วนอื่นๆ สามารถทำตามรูปแบบนี้ได้ -->
    </div>

    <?php
    // การเชื่อมต่อฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "carlot";

    // สร้างการเชื่อมต่อ
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // อัพเดทสถานะการ์ดเมื่อผ่านที่กั้น
    if (isset($_POST['update_gate_status'])) {
        $gate_id = $_POST['gate_id'];
        $sql = "UPDATE your_table_name SET status='ผ่านที่กั้น' WHERE id='$gate_id'";

        if ($conn->query($sql) === TRUE) {
            echo "สถานะการ์ดอัพเดทสำเร็จ!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    // อัพเดทการ์ดไอดีว่าง
    if (isset($_POST['update_card_status'])) {
        $card_id = $_POST['card_id'];
        $sql = "UPDATE your_table_name SET status='ว่าง' WHERE id='$card_id'";

        if ($conn->query($sql) === TRUE) {
            echo "สถานะการ์ดว่างอัพเดทสำเร็จ!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    $conn->close();
    ?>

</body>
</html>
