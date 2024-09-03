<?php
include 'db_config.php';

function getLatestParkingInfo() {
    global $pdo;
    $sql = "
        SELECT card.user_license_plate, lot.parked_zone, lot.number, distance.distance
        FROM lot
        INNER JOIN card ON lot.lot_id = card.lot_id
        INNER JOIN distance_data AS distance ON card.lot_id = distance.distance_id
        WHERE card.status_id='3'
        LIMIT 1
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$result = getLatestParkingInfo();

function calculateParkingBay($height) {
    // ช่องจอดสำหรับรถที่สูงกว่า 190 ซม.
    if ($height > 190) {
        $zones = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $bay_number = intval($height / 10) % 4 + 1; // คำนวณหมายเลขช่องจอด
        $zone = $zones[intval($height / 10) % 8]; // คำนวณโซนที่เหมาะสม
        return $zone . $bay_number . '01'; // ช่องจอดจาก A101 ถึง H104
    } else {
        // ช่องจอดสำหรับรถที่สูงต่ำกว่า 190 ซม.
        $zones = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $bay_number = intval($height / 10) % 5 + 1; // คำนวณหมายเลขช่องจอด
        $zone = $zones[intval($height / 10) % 8]; // คำนวณโซนที่เหมาะสม
        return $zone . '20' . $bay_number; // ช่องจอดจาก A201 ถึง H705
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Small Monitor</title>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Bai Jamjuree', sans-serif;
            color: yellow;
            background: black;
            overflow: hidden;
        }

        
        .starfield {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at bottom, #1b2735 0%, #090a0f 100%);
            overflow: hidden;
        }

        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            animation: star-animation 3s infinite linear;
        }

        
        @keyframes star-animation {
            0% {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) scale(0.1);
                opacity: 0;
            }
        }

        .container {
            text-align: center;
            font-size: 5vw;
            z-index: 1;
            position: relative;
            color: #f1c40f;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            letter-spacing: 2px;
        }

        
        @media (max-width: 768px) {
            .container {
                font-size: 7vw;
            }
        }

        .glow-text {
            background: linear-gradient(45deg, #ffdd00, #f39c12);
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: 0px 0px 10px rgba(255, 223, 0, 0.7);
        }

    </style>
</head>
<body>

<div class="starfield" id="starfield"></div>

<div class="container" id="data-container">
    <?php if ($result): ?>
        <?php
        $distance = $result['distance'];
        $bay = calculateParkingBay($distance); // คำนวณช่องจอด
        ?>
        <div class="glow-text" id="license-plate">ทะเบียน: <?php echo htmlspecialchars($result['user_license_plate']); ?></div>
        <div class="glow-text" id="zone">โซน: <?php echo htmlspecialchars($result['parked_zone']); ?></div>
        <div class="glow-text" id="bay">ช่องจอด: <?php echo htmlspecialchars($bay); ?></div>
    <?php else: ?>
        <div>ไม่มีข้อมูล</div>
    <?php endif; ?>
</div>

<script>
    // โค้ด JavaScript ของคุณ
</script>

</body>
</html>
