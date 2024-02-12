/**
 * 메인 페이지 슬라이드 (자동 슬라이드, 일시 정지, 재개 기능 구현)
 */
function carouselSlide() {
  //new bootstrap
  const myCarouselElement = document.querySelector(
    "#carouselExampleIndicators"
  );
  const carousel = new bootstrap.Carousel(myCarouselElement, {
    interval: 2000,
    pause: false,
  });
}

function pauseCarousel() {
  const myCarouselElement = document.querySelector("#carouselExampleIndicators");
  $(myCarouselElement).carousel("pause");
}

function playCarousel() {
  const myCarouselElement = document.querySelector(
    "#carouselExampleIndicators"
  );
  $(myCarouselElement).carousel("cycle");
}

//Reservation
function reservation() {
  //JSON 파일에서 데이터 불러오기
  async function fetchReservation() {
    const getReservationJSON = await fetch("../api/reservation.json");
    const reservationJSON = await getReservationJSON.json();
    console.log(reservationJSON["reservition"]);

    return reservationJSON["reservition"];
  }
  //test code
  // const reservationData = fetchReservation();
  // console.log(reservationData);

  const resDateTableElem = document.querySelector("#resDateTable");
  for (let i = 0; i < 14; i++) {
    // 날짜&요일 가져오기
    const date = new Date();
    date.setDate(date.getDate() + i);
    const year = date.getFullYear();
    const month = ("0" + (date.getMonth() + 1)).slice(-2);
    const day = ("0" + date.getDate()).slice(-2);
    const week = date.getDay();
    // const weekToString = ((week == 0) || (week == 6)) ? "주말" : "주중";
    //(조건식 ? 참일 때의 값 : 거짓일 때의 값;)
    // console.log(`${year}.${month}.${day} (${week})`);

    // 토요일, 일요일 구분 출력
    if (week == 0) {
      resDateTableElem.innerHTML += `<th class="sun">${year}.${month}.${day}</th>`;
    } else if (week == 6) {
      resDateTableElem.innerHTML += `<th class="sat">${year}.${month}.${day}</th>`;
    } else {
      resDateTableElem.innerHTML += `<th>${year}.${month}.${day}</th>`;
    }

    //날짜 Table로 출력
    // resDateTableElem.innerHTML += `<th>${year}.${month}.${day}</th>`;
  }
  // 표 만들기
  for (let i = 0; i < 14; i++) {
    for (let k = 0; k < 17; k++) {
      document.querySelector(`#row${k}`).innerHTML += `<td></td>`;
    }
  }
  async function updateReservation() {
    const reservation = await fetchReservation();

    // console.log(reservation[0]["D+0"][0]["status"]);
    // 예약 현황 구분하여 아이콘으로 표에 나타내기
    for (let i = 0; i < 14; i++) {
      for (let k = 0; k < 17; k++) {
        const data = reservation[i][`D+${i}`][k]["status"];
        const tdElem = document.querySelector(`#row${k} > td:nth-of-type(${i + 1})`);
        
        if (data == "W") {
          tdElem.innerText = "●";
          tdElem.className = `W D+${i} ${k}`;
        } else if (data == "R") {
          tdElem.innerText = "▲";
          tdElem.className = `R D+${i} ${k}`;
        } else{
          tdElem.innerText = "■";
          tdElem.className = `C D+${i} ${k}`;
          // document.querySelector(`#row${i}`).innerHTML += `<td>${reservation[j][`D+${j}`][i]["status"]}</td>`;
        }
      }
    }
  }
  updateReservation();
}
