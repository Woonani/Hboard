document.addEventListener("DOMContentLoaded", () => {
    const lectureList = document.querySelector("#lectureList");
    const imgSpan = document.querySelector("#imgSpan");
    const imgInput = document.querySelector("#imgInput");
    const addBtn = document.querySelector("#addBtn");
    const submitAddBtn = document.querySelector("#submitAddBtn");
    const updateBtn = document.querySelector("#updateBtn");
    const submitUpdateBtn = document.querySelector("#submitUpdateBtn");
    const delBtn = document.querySelector("#delBtn");
    const searchBtn = document.querySelector("#searchBtn");
    const tagSelect = document.querySelector("#tagSelect");
    const wordSelect = document.querySelector("#wordSelect");
    const wordInput = document.querySelector("#wordInput");
    const pageSelect = document.querySelector("#pageSelect");

    // 로드시 폼, 버튼 설정 초기화
    disableForm(true); // 폼 막음
    addBtn.style.display = "block"; // 등록, 수정 버튼 보이기
    updateBtn.style.display = "block";
    submitAddBtn.style.display = "none"; // 등록제출, 수정제출 안보이기
    submitUpdateBtn.style.display = "none";
    addBtn.disabled = false; // 등록 활성화
    updateBtn.disabled = true; // 수정, 삭제 비활성화
    delBtn.disabled = true;
  
    fetch("../../controller/admin/lecture_manage.php?mode=list")
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        if (data.status) {
          const rows = data.data.map((data, idx) => {
            const row = `<tr id="${data.lec_seq}"style="cursor:pointer" class="bbs-sbj">
                  <td>${data.lec_seq}</td><td>${data.category}</td><td>${data.lec_name}</td>
                  <td>${data.instructor}</td><td>${data.level}</td><td>${data.created_at}</td></tr>`;
            return row;
          });
  
          lectureList.innerHTML = rows.join("");
        } else {
          console.log("데이터 조회 실패");
        }
      })
      .catch((error) => console.error("Error:", error));
  
  
    lectureList.addEventListener("click", async (event) => {
      const target = event.target;
  
      const viewInfo = await getLectureInfoOne(target.parentNode.id);
      console.log("viewInfo : ", viewInfo);
  
      lectureForm.lec_seq.id = viewInfo.lec_seq;
      // lectureForm.image_url.src = viewInfo.image_url;
      // const imgUrl = document.querySelector('#imgUrl');
      console.log("imgUrl", viewInfo.image_url);
      document.querySelector("#imgUrl").setAttribute("src", viewInfo.image_url);
      lectureForm.image_url.alt = viewInfo.lec_name;
      lectureForm.tag_no.value = viewInfo.tag_no;
      lectureForm.lec_name.value = viewInfo.lec_name;
      lectureForm.instructor.value = viewInfo.instructor;
      lectureForm.level.value = viewInfo.level;
      lectureForm.time.value = viewInfo.time;
      lectureForm.chapter.value = viewInfo.chapter;
  
      // 불러온 정보에 대한 수정, 삭제 버튼 활성화
      disableForm(true); // 폼 막음
      addBtn.style.display = "block"; // 등록, 수정 버튼 보이기
      updateBtn.style.display = "block";
      addBtn.disabled = false; // 등록, 수정, 삭제 활성화
      updateBtn.disabled = false;
      delBtn.disabled = false;
      submitAddBtn.style.display = "none"; // 등록제출, 수정제출 안보이기
      submitUpdateBtn.style.display = "none";
    });
  
    // 파일 업로드버튼 연동
    imgSpan.addEventListener("click", (e) => {
      imgInput.click(e);
    });
  
    // 파일 업로드 이벤트
    imgInput.addEventListener("change", (e) => {
      
      const file = e.target.files[0];

      if (file.type != "image/png" && file.type != "image/jpeg") {
        alert("JPG 또는 PNG 형식의 파일만 업로드할 수 있습니다.");
        return;
      }

      if (file.size > 64/1024*1.5) {
        alert('파일용량이 너무 큽니다. 60kb 미만의 파일을 올려주세요.')
        return ;
      }
      
      const reader = new FileReader();

      reader.onload = (event) => {
        lectureForm.imgUrl.setAttribute("src", event.target.result);
      };

      reader.onerror = (error) => {
        console.error("파일을 읽는 중 오류가 발생했습니다: ", error);
      };

      reader.readAsDataURL(file);

    });
  
    // 등록 버튼
    addBtn.addEventListener("click", (e) => {
      e.preventDefault(); // 폼 전송 방지
  
      lectureForm.reset();
      lectureForm.imgInput.value = "";
      lectureForm.image_url.src = "http://via.placeholder.com/144x101";
  
      // 불러온 정보에 대한 수정, 삭제 버튼 활성화
      disableForm(false); // 폼 열기
      addBtn.style.display = "none"; // 등록 버튼 안보이기
      updateBtn.style.display = "block"; // 수정 버튼 보이기
      addBtn.disabled = true; // 등록, 수정, 삭제 비 활성화
      updateBtn.disabled = true;
      delBtn.disabled = true;
      submitAddBtn.style.display = "block"; // 등록제출 보이기
      submitUpdateBtn.style.display = "none"; // 수정제출 안보이기
    });
  
    // 등록 제출 버튼
    submitAddBtn.addEventListener("click", async (e) => {
      e.preventDefault();
  
      if (checkInput()) {
        let data = new URLSearchParams({
          mode: "regist",
          lec_name: lectureForm.lec_name.value,
          instructor: lectureForm.instructor.value,
          level: lectureForm.level.value,
          time: lectureForm.time.value,
          chapter: lectureForm.chapter.value,
          image_url: lectureForm.imgUrl.src,
          tag_no: lectureForm.tag_no.value,
        });
  
        await setLectureInfo(data);
      }
    });
  
    // 수정 버튼
    updateBtn.addEventListener("click", async (e) => {
      e.preventDefault();
  
      // 폼 활성화, 수정, 삭제 버튼 비활성화
      disableForm(false);
      updateBtn.style.display = "none";
      submitUpdateBtn.style.display = "block";
    });
  
    // 수정 제출 버튼
    submitUpdateBtn.addEventListener("click", async (e) => {
      e.preventDefault();
      if (checkInput()) {
        const seq = lectureForm.lec_seq.id;
  
        let data = new URLSearchParams({
          mode: "modify",
          lec_seq: seq,
          lec_name: lectureForm.lec_name.value,
          instructor: lectureForm.instructor.value,
          level: lectureForm.level.value,
          time: lectureForm.time.value,
          chapter: lectureForm.chapter.value,
          image_url: lectureForm.imgUrl.src,
          tag_no: lectureForm.tag_no.value,
        });
        console.log("수정 data : ", data);
        const result = await modifyLectureInfo(data);
  
        if (result) {
          disableForm(true); // 폼 닫기
          addBtn.style.display = "block"; // 등록 버튼 보이기
          updateBtn.style.display = "block"; // 수정 버튼 보이기
          addBtn.disabled = false; // 등록, 수정, 삭제 활성화
          updateBtn.disabled = false;
          delBtn.disabled = false;
          submitAddBtn.style.display = "none"; // 등록제출 안보이기
          submitUpdateBtn.style.display = "none"; // 수정제출 안보이기
        } else {
          location.href = "../../admin/index.php";
        }
      }
    });
  
    // 삭제 버튼
    delBtn.addEventListener("click", (e) => {
      e.preventDefault();
      const seq = lectureForm.lec_seq.id;
      if (confirm("삭제하시겠습니까?")) {
        deleteLectureInfo(seq);
      }
    });
  
    function disableForm(tf) {
      lectureForm.imgInput.disabled = tf;
      lectureForm.tag_no.disabled = tf;
      lectureForm.lec_name.disabled = tf;
      lectureForm.instructor.disabled = tf;
      let levels = document.forms["lectureForm"].elements["level"];
      for (let i = 0; i < levels.length; i++) {
        levels[i].disabled = tf;
      }
      lectureForm.time.disabled = tf;
      lectureForm.chapter.disabled = tf;
    }


    // 검색 기능
    searchBtn.addEventListener('click', ()=>{
      console.log("tagSelect 확인 : ", tagSelect.value)
      console.log("wordSelect 확인 : ", wordSelect.value)
      console.log("wordInput 확인 : ", wordInput.value)
      let page = pageSelect.value;
      let tag_no =  tagSelect.value;
      let col =  wordSelect.value;
      let word = wordInput.value;
      fetch(`../../controller/admin/lecture_manage.php?page=${page}&tag_no=${tag_no}&col=${col}&word=${word}`)
        .then((res) => {
          return res.json();
        })
        .then((data) => {
          console.log(data);
          if (data.status) {
            
            const rows = data.data.map((data, idx) => {
              const row = `<tr id="${data.lec_seq}"style="cursor:pointer" class="bbs-sbj">
                    <td>${data.lec_seq}</td><td>${data.category}</td><td>${data.lec_name}</td>
                    <td>${data.instructor}</td><td>${data.level}</td><td>${data.created_at}</td></tr>`;
              return row;
            });
    
            lectureList.innerHTML = rows.join("");
          } else {
            console.log("데이터 조회 실패");
          }
        })
        .catch((error) => console.error("Error:", error));
    })



    // -----DOMContentLoaded---------------- 끝
  });
  
  // 강의 정보 불러오기 함수
  function getLectureInfo() {
    let lectureInfo;
  
    fetch("../../controller/admin/lecture_manage.php")
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        console.log("data", data);
        if (data.status) {
          lectureInfo = data.data;
          // console.log("lectureInfo",lectureInfo)
        } else {
          console.log("데이터 조회 실패");
        }
      })
      .catch((error) => console.error("Error:", error));
  
    return lectureInfo;
  }
  
  // 강의 정보 하나 불러오는 함수
  const getLectureInfoOne = async (seq) => {
    let lectureInfoOne;
  
    await fetch(
      `../../controller/admin/lecture_manage.php?mode=view&lec_seq=${seq}`
    )
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        console.log("data", data);
        if (data.status) {
          lectureInfoOne = data.data;
          console.log("lectureInfoOne : ", lectureInfoOne);
        } else {
          console.log("데이터 조회 실패");
        }
      })
      .catch((error) => console.error("Error:", error));
  
    return lectureInfoOne;
  };
  
  // 강의 정보 등록 함수
  const setLectureInfo = async (params) => {
    console.log("등록함수 params : ", params);
  
    await fetch(`../../controller/admin/lecture_manage.php`, {
      method: "POST",
      cache: "no-cache",
      headers: {
        "content-Type": "application/x-www-form-urlencoded; charset=utf-8",
      },
      body: params,
    })
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        if (data.status) {
          alert("등록 완료.");
          location.href = "../../admin/index.php";
        } else {
          alert("오류발생! 다시 시작해 주세요");
        }
      })
      .catch((error) => console.error("Error:", error));
  };
  
  // 강의 정보 수정 함수
  const modifyLectureInfo = async (params) => {
    let ret = false;
    await fetch(`../../controller/admin/lecture_manage.php`, {
      method: "POST",
      cache: "no-cache",
      headers: {
        "content-Type": "application/x-www-form-urlencoded; charset=utf-8",
      },
      body: params,
    })
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        if (data.status) {
          alert("수정되었습니다.");
          ret = true;
        } else {
          alert("오류발생! 다시 시작해 주세요");
        }
      })
      .catch((error) => console.error("Error:", error));
  
    return ret;
  };
  
  // 강의 정보 삭제 함수
  const deleteLectureInfo = async (seq) => {
    await fetch(
      `../../controller/admin/lecture_manage.php?mode=delete&lec_seq=${seq}`
    )
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        if (data.status) {
          alert("삭제되었습니다.");
          location.href = "../../admin/index.php";
        } else {
          alert("오류발생! 다시 시작해 주세요");
        }
      })
      .catch((error) => console.error("Error:", error));
  };
  
  // input 값 체크
  function checkInput() {
    if (lectureForm.imgInput.value == "") {
      alert("강의 이미지를 업로드 해주세요.");
      lectureForm.imgInput.focus();
      return false;
    }
    if (lectureForm.tag_no.value == "0") {
      alert("강의 분류를 선택해주세요.");
      lectureForm.tag_no.focus();
      return false;
    }
    if (lectureForm.lec_name.value == "") {
      alert("강의명 입력해주세요.");
      lectureForm.lec_name.focus();
      return false;
    }
    if (lectureForm.instructor.value == "") {
      alert("강사를 입력해주세요.");
      lectureForm.instructor.focus();
      return false;
    }
    if (lectureForm.level.value == "") {
      alert("학습 난이도를 입력해주세요.");
      lectureForm.level.focus();
      return false;
    }
    if (lectureForm.time.value == "") {
      alert("교육시간을 입력해주세요.");
      lectureForm.time.focus();
      return false;
    }
    if (lectureForm.chapter.value == "") {
      alert("교육시간을 입력해주세요.");
      lectureForm.chapter.focus();
      return false;
    }
  
    return true;
  }