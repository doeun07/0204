<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["is_deleted"])) {
        $babi_idx = $_POST["babi_idx"];
        $sql = "UPDATE babiq SET status = '취소' WHERE babi_idx = :babi_idx";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":babi_idx", $babi_idx);
        $stmt->execute();
        echo "취소 되었습니다.";
        return 0;
    }

    if (isset($_POST["is_delivery"])) {
        $babi_idx = $_POST["babi_idx"];
        $sql = "UPDATE babiq SET status = '배달완료' WHERE babi_idx = :babi_idx";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":babi_idx", $babi_idx);
        $stmt->execute();
        echo "배달 되었습니다.";
        return 0;
    }

    $res_idx = $_POST["res_idx"];
    $orderArr = $_POST["orderArr"];

    for ( $i = 0; $i < count($orderArr); $i++ ) {
        $orderArr[$i] = intval($orderArr[$i]);
    }

    // orderArr = [바비큐 그릴, 돼지 바비큐, 해산물 바비큐, 음료, 주류, 과자세트];
    $orderArrToJson = json_encode($orderArr);

    $sql = "INSERT INTO babiq (res_idx, orderList, status) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$res_idx, $orderArrToJson, '접수']);

    echo getBabiqCount($pdo, $res_idx);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $res_idx = $_GET["res_idx"];
    if(isset($_GET["getConut"])) {
        echo getBabiqCount($pdo, $res_idx);
        return 0;
    }
    // $babi_idx = $_GET["babi_idx"];

    $sql = "SELECT * FROM babiq WHERE res_idx = :res_idx";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam("res_idx", $res_idx);
    $stmt->execute();
    $babiq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header("Content-Type: application/json");
    echo json_encode($babiq);
}

function getBabiqCount($pdo, $res_idx) {
    $sql = "SELECT * FROM babiq WHERE res_idx = :res_idx";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam("res_idx", $res_idx);
    $stmt->execute();
    $babiq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $babiqCount = count($babiq);
    return $babiqCount;
}
?>