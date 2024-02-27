<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $phone_num = $_POST['phone_num'];
    $position = $_POST['position'];
    $date = $_POST['date'];
    $price = $_POST['price'];
    function findUser($pdo, $username, $phone_num)
    {
        $sql_1 = "SELECT * FROM users WHERE username = :username AND phone_num = :phone_num";
        $stmt_1 = $pdo->prepare($sql_1);
        $stmt_1->bindParam("username", $username);
        $stmt_1->bindParam("phone_num", $phone_num);
        $stmt_1->execute();
        $user = $stmt_1->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION["user_idx"] = $user["user_idx"];
            $_SESSION["is_admin"] = (($user["username"] == "관리자") && ($user["phone_num"] == "000-0000-0000")) ? true : false;
        }
        return $user;
    }

    $user = findUser($pdo, $username, $phone_num);

    if (!$user) {
        $sql_2 = "INSERT INTO users (username, phone_num) VALUES (?, ?)";
        $stmt_2 = $pdo->prepare($sql_2);
        $stmt_2->execute([$username, $phone_num]);
    }

    $user = findUser($pdo, $username, $phone_num);

    $sql_3 = "SELECT * FROM reservations WHERE position = :position AND date = :date";
    $stmt_3 = $pdo->prepare($sql_3);
    $stmt_3->bindParam("position", $position);
    $stmt_3->bindParam("date", $date);
    $stmt_3->execute();
    $yaeyak = $stmt_3->fetch(PDO::FETCH_ASSOC);

    if ($yaeyak["status"] == "W") {
        $sql_4 = "UPDATE reservations SET user_idx = :user_idx, price = :price, status ='R' WHERE position = :position AND date = :date";
        $stmt_4 = $pdo->prepare($sql_4);
        $stmt_4->bindParam(":position", $position);
        $stmt_4->bindParam(":price", $price);
        $stmt_4->bindParam(":user_idx", $user["user_idx"]);
        $stmt_4->bindParam(":date", $date);
        $stmt_4->execute();

        echo "정상적으로 등록되었습니다.";
    } else {
        echo "이미 예약이 완료된 자리입니다.";
    }
}

?>