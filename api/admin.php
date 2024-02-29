<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $command = $_POST["command"];
    if ($command == "yaeyakOk") {
        $res_idx = $_POST["res_idx"];
        $sql = "UPDATE reservations SET status = 'C' WHERE res_idx = :res_idx";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":res_idx", $res_idx);
        $stmt->execute();
        echo "예약 승인되었습니다.";
        return 0;
    }

    if ($command == "yaeyakNo") {
        $res_idx = $_POST["res_idx"];
        $sql = "UPDATE reservations SET status = 'W', user_idx = null, price = null WHERE res_idx = :res_idx";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":res_idx", $res_idx);
        $stmt->execute();
        echo "예약 취소되었습니다.";
        return 0;
    }
}
?>