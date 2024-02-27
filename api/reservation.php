<?php
    $sql = "SELECT * FROM reservations";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $reservations = json_encode($reservations);
    header('Content-Type: application/json');
    echo $reservations;
?>