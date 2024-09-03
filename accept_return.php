<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APS KU - Accept Return</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h2>APS KU</h2>
        </div>
        <ul>
            <li><a href="accept_return.php" class="menu-item active">Accept Return</a></li>
            <li><a href="update_status.php" class="menu-item">Update Status</a></li>
            <li><a href="small.php" class="menu-item">Monitor</a></li>
        </ul>
        <div class="version">
            <p>Version 2.0</p>
        </div>
    </div>

    <div class="main-content">
        <h1>Accept Return</h1>
        <div class="return-section">
            <form action="accept_return.php" method="POST">
                <label>ไอดีการ์ด:</label>
                <input type="text" name="card_id" placeholder="กรอกไอดีการ์ด" required>
                <button type="submit">ยืนยัน</button>
            </form>
        </div>

        <div class="return-details">
            <h2>รายละเอียดการคืน</h2>
            <table>
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>โซน</th>
                        <th>เลขช่องจอด</th>
                        <th>วันที่</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // ตัวอย่างโค้ดสำหรับดึงข้อมูลจากฐานข้อมูล
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

                    // คิวรีข้อมูลจากฐานข้อมูล
                    $sql = "SELECT his_id, lot_id, license_plate, time_in FROM history";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["his_id"] . "</td>
                                    <td>" . $row["lot_id"] . "</td>
                                    <td>" . $row["license_plate"] . "</td>
                                    <td>" . $row["time_in"] . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>ไม่มีข้อมูล</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
