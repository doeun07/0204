<?php
    $sql = "SELECT * FROM reservations 
        ORDER BY CAST(SUBSTRING(date, LOCATE('+', date) + 1) AS UNSIGNED) ASC,
        position ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $reservations = json_encode($reservations);
    header('Content-Type: application/json');
    echo $reservations;
?>