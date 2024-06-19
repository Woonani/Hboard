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
});
