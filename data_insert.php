<?php
include("./config/DBconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dDay = $_POST["dDay"];
    $loc_num = $_POST["loc_num"];
    $status = $_POST["status"];

    // idx가 1부터 시작하지 않을 경우 초기화 하는 쿼리 문
    // ALTER TABLE reservations AUTO_INCREMENT = 1;

    try {
        $sql = "INSERT INTO reservations (position, data, status) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$loc_num, $dDay, $status]);
        echo "저장이 완료 되었다.";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Insert</title>
</head>

<body>
    <script src="./jquery/jquery-3.6.0.js"></script>
    <script>
        //Reservation.html
        function reservation() {
            //JSON 파일에서 데이터 불러오기
            async function fetchReservation() {
                const getReservationJSON = await fetch("./api/reservation.json");
                const reservationJSON = await getReservationJSON.json();

                return reservationJSON["reservition"];
            }

            async function updateReservation() {
                const reservation = await fetchReservation();

                for (let i = 0; i < 14; i++) {
                    for (let k = 0; k < 17; k++) {
                        // const data = reservation[i][`D+${i}`][k]["status"];
                        const dDay = `D+${i}`;
                        const loc_num = reservation[i][dDay][k]["loc_num"];
                        const status = reservation[i][dDay][k]["status"];
                        const data = (dDay, loc_num, status);
                        console.log(dDay, loc_num, status);
                        $.post("./data_insert.php", {
                            "dDay" : dDay,
                            "loc_num": loc_num,
                            "status": status
                        })
                    }
                }
            }
            updateReservation();
        }
        reservation();
    </script>
</body>

</html>