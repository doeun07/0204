<?php
//예약 정보 db에서 불러오기
if (isset($_GET["start"]) && isset($_GET["end"])) {
    $start = "D+" . $_GET["start"];
    $end = "D+" . $_GET["end"];
    $sql = "SELECT * FROM reservations WHERE status != 'W' AND date BETWEEN :start AND :end ORDER BY CAST(SUBSTRING(date, LOCATE('+', date) + 1) AS UNSIGNED) ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":start", $start);
    $stmt->bindParam(":end", $end);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT * FROM reservations WHERE status != 'W' ORDER BY CAST(SUBSTRING(date, LOCATE('+', date) + 1) AS UNSIGNED) ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUser($pdo, $user_idx)
{
    $sql = "SELECT * FROM users WHERE user_idx = :user_idx";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":user_idx", $user_idx);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//날짜 출력 함수
function getYYYYMMDD($dDay)
{
    $explodeDDay = explode("+", $dDay);
    $explodeDDay = $explodeDDay[1];
    $date = date(DATE_ATOM, mktime(0, 0, 0, date("m"), date("d") + $explodeDDay, date("Y")));
    $date = explode("T", $date);
    return $date[0];
}
// 예약 상태 구분
function getYaeyakStatus($status)
{
    if ($status == "W") {
        return "예약대기";
    } else if ($status == "R") {
        return "예약중";
    } else {
        return "예약완료";
    }
}

function getTotals($reservations) {
    $count = 0;
    $price = 0;
    foreach ($reservations as $reservation) {
        $count++;
        $price += $reservation["price"];
    }
    return [$count, $price];
}

$totals = getTotals($reservations);
?>

<div id="dateStertAndEnd">
    <h5>조회 기간 선택 : </h5>
    <select name="start" id="start">
    </select>
    <span>~</span>
    <select name="end" id="end">
    </select>
    <button onclick="yaeyakDateStartAndEndFetchAndPrint()" class='btn btn-primary btn_color' type='submit'>조회하기</button>

    <div id="totals">
        <ul>
            <li id="count">총 예약건수 : <?=$totals[0]?>건</li>
            <li id="price">합계 금액 : <?=number_format($totals[1])?>원</li>
        </ul>
    </div>
</div>


<table>
    <tr>
        <th>예약 날짜</th>
        <th>예약 자리</th>
        <th>예약자명</th>
        <th>예약자 휴대폰번호</th>
        <th>예약 상태</th>
        <th>예약 처리</th>
    </tr>
    <?php
    if ($reservations) {
        foreach ($reservations as $reservation) {
            $user = getUser($pdo, $reservation["user_idx"]);
            $divinnertext = "";
            $divinnertext .= "<tr id='" . $reservation["position"] . "' class='" . $reservation["res_idx"] . "'>";
            $divinnertext .= "<td>" . getYYYYMMDD($reservation["date"]) . "</td>";
            $divinnertext .= "<td> " . $reservation["position"] . "</td>";
            $divinnertext .= "<td>" . $user["username"] . "</td>";
            $divinnertext .= "<td>" . $user["phone_num"] . "</td>";
            $divinnertext .= "<td>" . getYaeyakStatus($reservation["status"]) . "</td>";
            $divinnertext .= "<td>" . "<button onclick='yaeyakOk(this)' class='btn btn-primary btn_color' type='submit'>승인</button> <button onclick='yaeyakNo(this)' class='btn btn-primary btn_color' type='submit'>취소</button>" . "</td>";
            $divinnertext .= "</tr>";
            echo $divinnertext;
        }
    }
    ?>
</table>

<script>
    setupyaeyakDateStartAndEnd()
</script>