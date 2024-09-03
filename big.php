<?php
include 'db_config.php'; // เชื่อมต่อกับฐานข้อมูล

function getParkingInfo() {
    global $pdo; // ใช้ PDO สำหรับการเชื่อมต่อกับฐานข้อมูล
    $sql = "
        SELECT card.user_license_plate, lot.parked_zone, lot.number
        FROM lot
        INNER JOIN card ON lot.lot_id = card.lot_id
        WHERE card.status_id = '6'
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$results = getParkingInfo();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Big Monitor</title>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
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
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 10px;
            padding: 20px;
            z-index: 1;
            position: relative;
            color: #f1c40f;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .box {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 2vw;
            color: #f1c40f;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
        }

        .box div {
            margin: 10px 0;
        }

        @media (max-width: 768px) {
            .box {
                font-size: 4vw;
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

<div class="container">
    <?php foreach ($results as $index => $result): ?>
        <div class="box">
            <div class="glow-text">ทะเบียน: <?php echo htmlspecialchars($result['user_license_plate']); ?></div>
            <div class="glow-text">โซน: <?php echo htmlspecialchars($result['parked_zone']); ?></div>
            <div class="glow-text">ช่องจอด: <?php echo htmlspecialchars($result['number']); ?></div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    setTimeout(function(){
        window.location.reload(1);
    }, 5000); // รีเฟรชทุก 5 วินาที

    function createStar() {
        const star = document.createElement("div");
        star.classList.add("star");
        star.style.width = `${Math.random() * 3}px`;
        star.style.height = `${Math.random() * 3}px`;
        star.style.top = `${Math.random() * 100}vh`;
        star.style.left = `${Math.random() * 100}vw`;
        document.getElementById("starfield").appendChild(star);

        setTimeout(() => {
            star.remove();
        }, 3000); // ลบดาวหลังจากการแอนิเมชันสิ้นสุด
    }

    setInterval(createStar, 100);

</script>

</body>
</html>
