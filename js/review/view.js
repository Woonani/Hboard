document.addEventListener("DOMContentLoaded", () => {
  const rev_title = document.querySelector("#rev_title");
  const user_id = document.querySelector("#user_id");
  const rating = document.querySelector("#rating");
  const contents = document.querySelector("#contents");
  const user_id2 = document.querySelector("#user_id2");
  const image_url = document.querySelector("#image_url");
  const lec_name = document.querySelector("#lec_name");
  const lec_info = document.querySelector("#lec_info");

  const params = getQueryParams();
  const seq = params.seq;

  // 리뷰 정보 하나 불러오는 함수
  fetch(`../../controller/review/view.php?mode=view&seq=${seq}`)
    .then((res) => {
      return res.json();
    })
    .then((data) => {
      console.log("data", data.data);
      if (data.status) {
        const viewInfo = data.data;

        rev_title.innerText = "제목 | " + viewInfo.rev_title;
        user_id.innerText = "작성자 | " + viewInfo.user_id;
        rating.innerText = viewInfo.rating;
        contents.innerText = viewInfo.contents;
        user_id2.innerText = viewInfo.user_id + "님의 수강하신 강의 정보";
        image_url.src = viewInfo.image_url;
        lec_name.innerText = viewInfo.lec_name;
        lec_info.innerText =
          "강사: " +
          viewInfo.instructor +
          " | 학습난이도 : " +
          viewInfo.level +
          " | 교육시간: " +
          viewInfo.time +
          "간 (" +
          viewInfo.chapter +
          "강)";
      } else {
        console.log("데이터 조회 실패");
        return false;
      }
    })
    .catch((error) => console.error("Error:", error));

  function getQueryParams() {
    const params = {};
    const queryString = window.location.search.slice(1);
    const queries = queryString.split("&");
    queries.forEach((query) => {
      const [key, value] = query.split("=");
      params[key] = value;
    });
    return params;
  }
});
