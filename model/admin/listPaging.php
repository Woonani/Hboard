<?php

// 페이지네이션 바 범위 가져오는 함수
function getPageRange ($param) {
    global $conn;
    // $page = $param['page'];
    $tag_no = $param['tag_no'];
    $col = $param['col'];
    $word = $param['word'];
    $plate = $param['plate'];
    $limit = $plate*50;
    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $where_con1 = $tag_no == '0' ? "" : " and tag_no = ? ";
        $where_con2 = $word == '' ? "" : (" and ".$col." like ?");
        $sql = "select max(ll.no) as max
                from (
                    select l.no, l.lec_name, l.instructor, 
                        l.level, l.time, l.chapter, l.image_url, l.tag_no, t.category, l.created_at, l.updated_at
                    from
                        ( select row_number() over (order by created_at desc) as no, lec_name, instructor, 
                            level, time, chapter, image_url, tag_no, created_at, updated_at 
                        from lectures 
                        where 1=1".$where_con1.$where_con2."
                        ) l left join tags t on l.tag_no = t.code
                         
                    where l.no > ".($limit-50)." and l.no <= ".$limit."
                ) ll";
        $stmt = mysqli_prepare($conn,$sql);

        if( $tag_no == 0 && $word == '') {
            // mysqli_stmt_bind_param($stmt,"ii", $page, $page);
        }else if ( $tag_no == 0 && $word != '') {
            $word = "%".$word."%";
            mysqli_stmt_bind_param($stmt,"s", $word);
        } else if ( $tag_no != 0 && $word == '') {
            mysqli_stmt_bind_param($stmt,"s", $tag_no);
        } else{
            $word = "%".$word."%";
            mysqli_stmt_bind_param($stmt,"ss", $tag_no, $word);
        }

        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);

        $ret = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);
        $endNum = $ret[0]['max'];

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        $result['startPage'] = ($plate-1)*10+1;
        $result['endNum'] = $endNum;
        $result['lastPage'] = $endNum == $limit ? $plate*10 : ceil($endNum/5);


        if(isset($result['startPage']) && isset($result['lastPage'])){
            $result['status'] = true;
        } else {
            $result['status'] = false;
        }
    }

    return $result;
}

// 강의 정보 list 가져오는 함수 + 페이지네이션, 검색 추가
function getLectureList ($param) {
    global $conn;
    //page=${pageNum}&tag_no=${tag_no}&col=${col}&word=${word}
    $page = $param['page'];
    $tag_no = $param['tag_no'];
    $col = $param['col'];
    $word = $param['word'];
    // print_r($param) ;
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
                        select row_number() over (order by created_at DESC) as no, lec_seq, lec_name, instructor, level, time, chapter, image_url, tag_no, created_at, updated_at 
                        from lectures
                            where 1=1".$where_con1.$where_con2."
                        ) l
                    where (no > (?-1)*5) and (no <=?*5)
                ) ll left join tags t on ll.tag_no = t.code
                 order by ll.no
                ";

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

?>