<?php
// 강의 정보 list 가져오는 함수 + 페이지네이션, 검색 추가
function getLectureList ($param) {
    global $conn;

    $page = $param['page'];
    $tag_no = $param['tag_no'];
    $col = $param['col'];
    $word = $param['word'];
    
    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {

        $where_con1 = $tag_no == '0' ? "" : " and tag_no = ? ";
        $where_con2 = $word == '' ? "" : (" and ".$col." like ?");
        // $where_con2 = $word == '' ? "" : " and lec_name like '%?%'";
        $sql = "select 
                    ll.no, ll.lec_seq, ll.lec_name, ll.instructor, ll.level, ll.time, ll.chapter, ll.image_url, ll.tag_no, t.category, ll.created_at, ll.updated_at 
                from (
                    select l.no, l.lec_seq, l.lec_name, l.instructor, l.level, l.time, l.chapter, l.image_url, l.tag_no, l.created_at, l.updated_at 
                    from (
                        select row_number() over(order by created_at DESC) as no, lec_seq, lec_name, instructor, level, time, chapter, image_url, tag_no, created_at, updated_at 
                        from lectures
                            where 1=1".$where_con1.$where_con2."
                        ) l
                    where (no > (?-1)*10) and (no <=?*10)
                ) ll left join tags t on ll.tag_no = t.code";

        $stmt = mysqli_prepare($conn, $sql);
        
        if( $tag_no == 0 && $word == '') {
            mysqli_stmt_bind_param($stmt,"ii", $page, $page);
        }else if ( $tag_no == 0 && $word != '') {
            $word = "%".$word."%";
            mysqli_stmt_bind_param($stmt,"sii", $word, $page, $page);
        } else if ( $tag_no != 0 && $word == '') {
            mysqli_stmt_bind_param($stmt,"sii", $tag_no, $page, $page);
        } else{
            $word = "%".$word."%";
            mysqli_stmt_bind_param($stmt,"ssii", $tag_no, $word, $page, $page);
        }

        mysqli_stmt_execute($stmt);

        $queryResult = mysqli_stmt_get_result($stmt);
        $result['data'] = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);

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

// 강의 정보 list 가져오는 함수
function getLectureInfo () {
    global $conn;

    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $stmt = mysqli_prepare($conn,"select * from Lectures l join Tags t on l.tag_no = t.code limit 10");
        
        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);
        // $result['data'] = mysqli_fetch_assoc($queryResult);
        $result['data'] = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);

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

// 강의 정보 한개 view 가져오는 함수
function getLectureInfoOne ($seq) {
    global $conn;

    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $stmt = mysqli_prepare($conn,"select * from Lectures l join Tags t on l.tag_no = t.code where l.lec_seq = ?");
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

// 강의 정보 한개 삭제하는 함수
function deleteLectureInfo ($seq) {
    global $conn;

    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $stmt = mysqli_prepare($conn,"delete from lectures where lec_seq = ?");
        mysqli_stmt_bind_param($stmt,"s",$seq);
        mysqli_stmt_execute($stmt);
        
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $result['status'] = true;
            $result['message'] = "삭제 완료";
        } else {
            $result['status'] = false;
            $result['message'] = "삭제 실패";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

    return $result;
}

function createUserInfo($data){
    global $conn;

    $result = array();
        
    $lec_name = $data['lec_name'];
    $instructor = $data['instructor'];
    $level = $data['level'];
    $time = $data['time'];
    $chapter = $data['chapter'];
    $image_url = $data['image_url'];
    $tag_no = $data['tag_no'];

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $sql = "INSERT INTO Lectures 
                    (lec_name, instructor, level, time, chapter, image_url, tag_no)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssiiss", $lec_name, $instructor, $level, $time, $chapter, $image_url, $tag_no);

        $queryResult = mysqli_stmt_execute($stmt);
        
        if($queryResult){ 
            $result['status'] = true;
            $result['message'] = "등록 완료";
        }else{ 
            $result['status'] = false;
            $result['message'] = "등록 실패";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn); 
    }
    return $result;
}

function updateUserInfo($data){
    global $conn;

    $result = array();
        
    $lec_seq = $data['lec_seq'];
    $lec_name = $data['lec_name'];
    $instructor = $data['instructor'];
    $level = $data['level'];
    $time = $data['time'];
    $chapter = $data['chapter'];
    $image_url = $data['image_url'];
    $tag_no = $data['tag_no'];

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $sql = "UPDATE Lectures SET lec_name = ?, instructor = ?, level = ?, time = ?, chapter = ?, 
                    image_url = ?, tag_no = ?
                WHERE lec_seq = ?";


        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssiissi",  $lec_name, $instructor, $level, $time, $chapter, $image_url, $tag_no, $lec_seq);

        $queryResult = mysqli_stmt_execute($stmt);

        
        if($queryResult){ 
            $result['status'] = true;
            $result['message'] = "수정 완료";
        }else{ 
            $result['status'] = false;
            $result['message'] = "수정 실패";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn); 
    }
    return $result;
}

?>