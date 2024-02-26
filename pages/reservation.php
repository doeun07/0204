<div class="reservation_main">
  <div class="reservation_manu">
    <div class="reservation_sbmanu" style="color: green;">
      <p>● 예약가능</p>
    </div>
    <div class="reservation_sbmanu" style="color: red;">
      <p>▲ 예약중</p>
    </div>
    <div class="reservation_sbmanu" style="color: gray;">
      <p>■ 예약완료</p>
    </div>
  </div>

  <!-- table -->
  <table id="resTable">
    <tr id="resDateTable">
      <th>자리/날짜</th>
    </tr>
    <tr id="row0">
      <th>A01</th>
    </tr>
    <tr id="row1">
      <th>A02</th>
    </tr>
    <tr id="row2">
      <th>A03</th>
    </tr>
    <tr id="row3">
      <th>A04</th>
    </tr>
    <tr id="row4">
      <th>A05</th>
    </tr>
    <tr id="row5">
      <th>A06</th>
    </tr>
    <tr id="row6">
      <th>A07</th>
    </tr>
    <tr id="row7">
      <th>T01</th>
    </tr>
    <tr id="row8">
      <th>T02</th>
    </tr>
    <tr id="row9">
      <th>T03</th>
    </tr>
    <tr id="row10">
      <th>T04</th>
    </tr>
    <tr id="row11">
      <th>T05</th>
    </tr>
    <tr id="row12">
      <th>T06</th>
    </tr>
    <tr id="row13">
      <th>T07</th>
    </tr>
    <tr id="row14">
      <th>T08</th>
    </tr>
    <tr id="row15">
      <th>T09</th>
    </tr>
    <tr id="row16">
      <th>T10</th>
    </tr>
  </table>
</div>

<!-- Modal Start -->
<div class="modal fade" id="exampleModalLive" tabindex="-1" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLiveLabel">예약하기</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5 id="position">자리 :</h5>
        <h5 id="price">금액 :</h5>
        <div class="input-group mb-3">
          <input type="text" id="name" class="form-control" placeholder="이름" aria-label="이름"
            aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
          <input type="text" id="phoneNumber" class="form-control" placeholder="전화번호" aria-label="전화번호"
            aria-describedby="button-addon2" oninput="regexPhonNumber(this)" maxlength="13">
          <button class="btn btn-outline-secondary" type="button" id="button-addon2"
            onclick="sendVerifyNumber(this)">인증번호 발송</button>
        </div>
        <div class="input-group mb-3">
          <input type="text" id="phoneVerify" class="form-control" placeholder="인증번호" aria-label="인증번호"
            aria-describedby="basic-addon1" maxlength="4" oninput="regexVerifyNumber(this)" disabled>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
        <button type="button" class="btn btn-primary" onclick="reservationSubmit()">예약하기</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal End -->

<!-- Toast Starts -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">예약 안내</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      예약 정보가 정상적으로 등록되었습니다.
      관리자 승인 후 예약이 최종 완료됩니다.
    </div>
  </div>
</div>
<script>
  reservation();
</script>