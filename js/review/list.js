document.addEventListener("DOMContentLoaded", () => {
  const reviewList = document.querySelector("#reviewList");
  // const tapBox = document.querySelector("#tapBox");
  const pNumBox = document.querySelector("#pNumBox");

  const searchBtn = document.querySelector("#searchBtn");
  const tagSelect = document.querySelector("#tagSelect");
  const wordSelect = document.querySelector("#wordSelect");
  const wordInput = document.querySelector("#wordInput");

  const beforeBtn = document.querySelector("#beforeBtn");
  const nextBtn = document.querySelector("#nextBtn");
  const firstBtn = document.querySelector("#firstBtn");
  const lastBtn = document.querySelector("#lastBtn");

  let plateNum = 1;
  let pageNum = 1;
  getRevieweList(pageNum);
  getPagingBar(plateNum);

  // 검색 기능
  searchBtn.addEventListener("click", () => {
    getPagingBar(1);
    getRevieweList(1);
  });

  // 페이지 네이션 바 버튼 이벤트

  beforeBtn.addEventListener("click", () => {
    if (plateNum - 1 > 0) {
      getPagingBar(--plateNum);
    }
  });

  nextBtn.addEventListener("click", () => {
    getPagingBar(plateNum++);
  });

  firstBtn.addEventListener("click", () => {
    getPagingBar(1);
  });

  lastBtn.addEventListener("click", () => {
    getPagingBar(100);
  });

  // 페이지네이션 바 번호 값 가져오는 이벤트
  pNumBox.addEventListener("click", (event) => {
    let pageNum = event.target.innerText;
    // 기존 active 클래스를 가진 요소에서 active 클래스 제거
    const activeElement = document.querySelector(".box-paging .active");
    if (activeElement) {
      activeElement.classList.remove("active");
    }

    // 선택한 요소에 active 클래스 추가
    event.target.classList.add("active");

    getRevieweList(pageNum);
  });

  // 선택된 페이지번호의 수강후기 List 가져오는 함수
  function getRevieweList(pageNum) {
    let tag_no = tagSelect.value;
    let col = wordSelect.value;
    let word = wordInput.value;
    fetch(
      `../../controller/review/list.php?mode=list&page=${pageNum}&tag_no=${tag_no}&col=${col}&word=${word}`
    )
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        // console.log(data.data)
        if (data.status) {
          const rows = data.data.map((data, idx) => {
            const row = `<tr id="${data.rev_seq} class="bbs-sbj">
                            <td>${data.no}</td>
                            <td>${data.category}</td>
                            <td>
                                <a href="http://test.hackers.com/lecture_board/index.php?mode=view&seq=${data.rev_seq}">
                                    <span class="tc-gray ellipsis_line">수강 강의명 : ${data.lec_name}</span>
                                    <strong class="ellipsis_line">${data.rev_title}</strong>
                                </a>
                            </td>
                            <td>
                                <span class="star-rating">
                                    <span class="star-inner" style="width:80%">${data.rating}</span>
                                </span>
                            </td>
                            <td class="last">${data.username}</td>
                        </tr>`;

            return row;
          });

          reviewList.innerHTML = rows.join("");
        } else {
          console.log("데이터 조회 실패");
        }
      })
      .catch((error) => console.error("Error:", error));
  }

  // 페이지네이션 바 가져오는함수
  function getPagingBar(plate) {
    let tag_no = tagSelect.value;
    let col = wordSelect.value;
    let word = wordInput.value;

    fetch(
      `../../controller/review/list.php?plate=${plate}&tag_no=${tag_no}&col=${col}&word=${word}`
    )
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        if (data.status) {
          console.log("paging data : ", data);

          let rows = [];

          for (let i = data.startPage; i <= data.lastPage; i++) {
            let row;
            if (i % 10 == 1) {
              row = `<a class="active" id="p${i}" value=${i} style="cursor:pointer" >${i}</a>`;
            } else {
              row = `<a id="p${i}" value=${i} style="cursor:pointer" >${i}</a>`;
            }
            rows.push(row);
          }

          pNumBox.innerHTML = rows.join("");
        } else {
          console.log("데이터 조회 실패");
        }
      })
      .catch((error) => console.error("Error:", error));
  }
});
