document.addEventListener("DOMContentLoaded", () => {
    const pNumBox = document.querySelector("#pNumBox");
    const beforeBtn = document.querySelector("#beforeBtn");
    const nextBtn = document.querySelector("#nextBtn");
    // const firstBtn = document.querySelector("#firstBtn");
    // const lastBtn = document.querySelector("#lastBtn");

    const searchBtn = document.querySelector("#searchBtn");
    const tagSelect = document.querySelector("#tagSelect");
    const wordSelect = document.querySelector("#wordSelect");
    const wordInput = document.querySelector("#wordInput");
    const pageSelect = document.querySelector("#pageSelect");

    let plateNum = 1;
    let pageNum = 1;
    getPagingBar(plateNum);
    getLectureList(pageNum)
  
    // 페이지네이션 바 번호 값 가녀오는 이벤트
    pNumBox.addEventListener("click", (event) => {
      let pageNum = event.target.innerText;
      getLectureList(pageNum);
    });
  
    beforeBtn.addEventListener("click", () => {
      if(plateNum-1 >0){
          getPagingBar(--plateNum);
      }
    });
  
    nextBtn.addEventListener("click", () => {
      getPagingBar(plateNum++);
    });

    
    // 검색 기능
    searchBtn.addEventListener('click', ()=>{
        getPagingBar(1)
        getLectureList(1)
    })
  
    // 페이지네이션 바 가져오는함수
    function getPagingBar(plate) {
      let tag_no =  tagSelect.value;
      let col =  wordSelect.value;
      let word = wordInput.value;
      
      fetch(`../../controller/admin/listPaging.php?plate=${plate}&tag_no=${tag_no}&col=${col}&word=${word}`)
        .then((res) => {
          return res.json();
        })
        .then((data) => {
          if (data.status) {
            console.log("paging data : ", data);
  
            let rows = [];
  
            for (let i = data.startPage; i <= data.lastPage; i++) {
              const row = `<a id="p${i}" value=${i} style="cursor:pointer" >${i}</a>`;
              rows.push(row);
            }
  
            pNumBox.innerHTML = rows.join("");
          } else {
            console.log("데이터 조회 실패");
          }
        })
        .catch((error) => console.error("Error:", error));
    }
  
    // 선택된 페이지번호의 강의List 가져오는 함수
    function getLectureList(pageNum) {
      let tag_no =  tagSelect.value;
      let col =  wordSelect.value;
      let word = wordInput.value;
      fetch(`../../controller/admin/listPaging.php?mode=list&page=${pageNum}&tag_no=${tag_no}&col=${col}&word=${word}`)
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        if (data.status) {
          const rows = data.data.map((data, idx) => {
            const row = `<tr id="${data.lec_seq}"style="cursor:pointer" class="bbs-sbj">
                  <td>${data.no}</td><td>${data.category}</td><td>${data.lec_name}</td>
                  <td>${data.instructor}</td><td>${data.level}</td><td>${data.created_at}</td></tr>`;
            return row;
          });
  
          lectureList.innerHTML = rows.join("");
        } else {
          console.log("데이터 조회 실패");
        }
      })
      .catch((error) => console.error("Error:", error));
    }



  

  });