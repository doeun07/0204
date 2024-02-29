<?php
$sql = "SELECT * FROM reservations WHERE status != 'W'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

function getYYYYMMDD($dDay)
{
    $explodeDDay = explode("+", $dDay);
    $explodeDDay = $explodeDDay[1];
    $date = date(DATE_ATOM, mktime(0, 0, 0, date("m"), date("d") + $explodeDDay, date("Y")));
    $date = explode("T", $date);
    return $date[0];
}
function getBabiqCount($pdo, $res_idx)
{
    $sql = "SELECT * FROM babiq WHERE res_idx = :res_idx AND status != '취소'";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam("res_idx", $res_idx);
    $stmt->execute();
    $babiq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $babiqCount = count($babiq);
    return $babiqCount;
}
if (!isset($_SESSION["user_idx"])) {
    echo "<script>alert('로그인 후 이용하실 수 있습니다.'); location.href = './login';</script>";
}

function getDeliveryCount($pdo, $res_idx)
{
    $sql = "SELECT * FROM babiq WHERE res_idx = :res_idx AND status != '취소'";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam("res_idx", $res_idx);
    $stmt->execute();
    $babiqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = 0;
    foreach ($babiqs as $babiq) {
        $babiq["status"] == "배달완료" ? $count++ : null;
    }
    return $count;
}

function getTotalPrice($pdo, $res_idx)
{
    $sql = "SELECT * FROM babiq WHERE res_idx = :res_idx AND status != '취소'";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam("res_idx", $res_idx);
    $stmt->execute();
    $babiqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalPrice = 0;
    foreach ($babiqs as $babiq) {
        $totalPrice += setPrice(json_decode($babiq["orderList"]))[6];
    }
    return $totalPrice;
}
// 총 합계 금액 계산
function setPrice($orderArr)
{
    $babiqGrillPrice = 10000;
    $pigBabiqPrice = 12000;
    $haesanBabiqPrice = 15000;
    $juicePrice = 3000;
    $sojuPrice = 5000;
    $gajaSetPrice = 4000;

    $babiqGrillTotal = $babiqGrillPrice * $orderArr[0];
    $pigBabiqTotal = $pigBabiqPrice * $orderArr[1];
    $haesanBabiqTotal = $haesanBabiqPrice * $orderArr[2];
    $juiceTotal = $juicePrice * $orderArr[3];
    $sojuTotal = $sojuPrice * $orderArr[4];
    $gajaSetTotal = $gajaSetPrice * $orderArr[5];
    $totalPrice = $babiqGrillTotal + $pigBabiqTotal + $haesanBabiqTotal + $juiceTotal + $sojuTotal + $gajaSetTotal;
    return [$babiqGrillTotal, $pigBabiqTotal, $haesanBabiqTotal, $juiceTotal, $sojuTotal, $gajaSetTotal, $totalPrice];
}

function getTotals($pdo)
{
    $sql = "SELECT * FROM babiq";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $babiqs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalTotal = 0;
    $totalNoTotal = 0;
    $totalOkTotal = 0;
    $totalOkTotalPriceTotal = 0;
    foreach ($babiqs as $babiq) {
        $totalTotal++;
        $babiq["status"] == "취소" ? $totalNoTotal++ : null;
        $babiq["status"] == "배달완료" ? $totalOkTotal++ : null;
        $babiq["status"] == "배달완료" ? $totalOkTotalPriceTotal += setPrice(json_decode($babiq["orderList"]))[6] : null;
    }
    return [$totalTotal, $totalNoTotal, $totalOkTotal, $totalOkTotalPriceTotal];
}

$totals = getTotals($pdo);
?>

<div id="totals">
    <ul>
        <li id="count">총 주문 건수 :
            <?= $totals[0] ?>건,  
            총 취소 주문 건수 :
            <?= $totals[1] ?>건
        </li>
        <li id="price">총 배달 완료 건수 :
            <?= $totals[2] ?>건,
            배달완료 합계 금액 :
            <?= number_format($totals[3]) ?>원
        </li>
    </ul>
</div>

<table>
    <tr>
        <th>예약 날짜</th>
        <th>자리 번호</th>
        <th>주문건수</th>
        <th>배달 완료 건수</th>
        <th>주문 합계 금액</th>
        <th>주문 상세 보기</th>
    </tr>
    <?php
    if ($reservations) {
        foreach ($reservations as $reservation) {
            $divinnertext = "";
            $divinnertext .= "<tr id='" . $reservation["position"] . "' class='" . $reservation["res_idx"] . "'>";
            $divinnertext .= "<td>" . getYYYYMMDD($reservation["date"]) . "</td>";
            $divinnertext .= "<td> " . $reservation["position"] . "</td>";
            $divinnertext .= "<td>" . getBabiqCount($pdo, $reservation["res_idx"]) . "</td>";
            $divinnertext .= "<td>" . getDeliveryCount($pdo, $reservation["res_idx"]) . "</td>";
            $divinnertext .= "<td>" . number_format(getTotalPrice($pdo, $reservation["res_idx"])) . "</td>";
            $divinnertext .= "<td>" . "<button onclick='babiqOrderCheckAdmin(this)' class='btn btn-primary btn_color' type='submit'>주문상세보기</button>" . "</td>";
            $divinnertext .= "</tr>";
            echo $divinnertext;
        }
    }
    ?>
</table>

<!-- 주문내역확인 Modal Start -->
<div class="modal fade" id="babiqOrderCheckAdmin" tabindex="-1" aria-labelledby="exampleModalLiveLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLiveLabel">주문 내역 확인</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <h6 id="babiqCheck">바비큐 그릴 대여(도구 및 숯 등 포함) : 0개</h6>
        <h6 id="pigBabiqCheck">돼지고기 바비큐 세트 : 0세트</h6>
        <h6 id="haesanBabiqCheck">해산물 바비큐 세트 : 0세트</h6>
        <h6 id="juiceCheck">음료 : 0병</h6>
        <h6 id="sojuCheck">주류 : 0병</h6>
        <h6 id="gajaSetCheck">과자세트 : 0세트</h6>
        <h5 id="totalPriceCheck">총 주문 금액 : 0원</h5> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>
<!-- 주문내역확인 Modal End -->