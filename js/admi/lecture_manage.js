document.addEventListener("DOMContentLoaded", () => {

    // const lectureInfo = getLectureInfo();
    let lectureInfo;

    fetch("../../controller/admi/lecture_manage.php"
    ).then((res) => {
        return res.json();
    }).then((data) => {
        console.log("data",data)
        if(data.status){
            lectureInfo = data.data;
            console.log("lectureInfo",lectureInfo)
            lectureForm.image_url.src = lectureInfo.image_url;

            lectureForm.tag_no.value = lectureInfo.tag_no;
            lectureForm.lec_name.value = lectureInfo.lec_name;
            lectureForm.instructor.value = lectureInfo.instructor;
            lectureForm.level.value = lectureInfo.level;
            lectureForm.time.value = lectureInfo.time;
            lectureForm.chapter.value = lectureInfo.chapter;
        } else {
            console.log("데이터 조회 실패")
        }
    })
    .catch((error) => console.error("Error:", error));

    

});

// 강의 정보 불러오기 함수
function getLectureInfo() {
    let lectureInfo;

    fetch("../../controller/admi/lecture_manage.php"
    ).then((res) => {
        return res.json();
    }).then((data) => {
        console.log("data",data)
        if(data.status){
            lectureInfo = data.data;
            console.log("lectureInfo",lectureInfo)
        } else {
            console.log("데이터 조회 실패")
        }
    })
    .catch((error) => console.error("Error:", error));

    return lectureInfo;
}