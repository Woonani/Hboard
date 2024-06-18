document.addEventListener("DOMContentLoaded", () => {
  const pNumBox = document.querySelector("#pNumBox");
  // const firstBtn = document.querySelector("#firstBtn");
  const beforeBtn = document.querySelector("#beforeBtn");
  const nextBtn = document.querySelector("#nextBtn");
  // const lastBtn = document.querySelector("#lastBtn");
  let plateNum = 1;
  getPagingBar(plateNum);

  beforeBtn.addEventListener("click", () => {
    plateNum = --plateNum < 0 ? 1 : --plateNum;
    getPagingBar(plateNum);
  });

  nextBtn.addEventListener("click", () => {
    getPagingBar(plateNum++);
  });

  function getPagingBar(plate) {
    fetch(`../../controller/admin/paging.php?plate=${plate}`)
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        if (data.status) {
          console.log("paging data : ", data);

          let rows = [];

          for (let i = data.startPage; i <= data.lastPage; i++) {
            const row = `<a id="p"+${i} value=${i} href="#">${i}</a>`;
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
