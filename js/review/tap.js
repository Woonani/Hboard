document.addEventListener("DOMContentLoaded", () => {
  const tapBox = document.querySelector("#tapBox");

  // 분류탭 이벤트
  tapBox.addEventListener("click", (event) => {
    let tag = event.target.id.slice(2);

    // 기존 on 클래스를 가진 요소에서 on 클래스 제거
    const activeElement = document.querySelector(".tab-list.tab5 .on");
    if (activeElement) {
      activeElement.classList.remove("on");
    }

    // 선택한 요소에 on 클래스 추가
    event.target.parentNode.classList.add("on");

    tagSelect.value = tag;
    getRevieweList(1);
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

});
