<?php

// 리뷰 정보 한개 가져오는 함수
function getReviewInfo ($seq) {
    global $conn;

    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $sql = "select r.rev_seq, r.rev_title, r.contents, r.rating, r.lec_seq, r.author,
                    t.category,
                    l.lec_seq, l.lec_name, l.instructor, l.level, l.time, l.chapter, l.image_url, l.tag_no,
                    u.id, u.username, u.user_id	
                from ( select * from Reviews where rev_seq = ? ) r
                left join Lectures l on r.lec_seq = l.lec_seq
                left join Tags t on l.tag_no = t.code
                left join Users u on r.author = u.id ";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt,"s",$seq);
        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);
        $result['data'] = mysqli_fetch_assoc($queryResult);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        if(isset($result['data'])){
            $result['status'] = true;
            $result['message'] = "조회 완료";
        } else {
            $result['status'] = false;
            $result['message'] = "조회 실패";
        }
    }

    return $result;

}