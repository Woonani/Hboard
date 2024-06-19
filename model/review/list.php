<?php

// 페이지네이션 바 범위 가져오는 함수
function getPageRange ($param) {
    global $conn;
    // $page = $param['page'];
    $tag_no = $param['tag_no'];
    $col = $param['col'];
    $word = $param['word'];
    $plate = $param['plate'];
    $limit = $plate*20*10;
    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $where_con1 = $tag_no == '0' ? "" : " and l.tag_no = ? ";
        $where_con2 = $word == '' ? "" : (" and l.".$col." like ?");

        $sql = "select max(ll.no) as max
                from (
                    select list.no, list.rev_seq, list.rev_title, list.rating, list.lec_seq, list.lec_name, 
                        list.instructor, list.id, list.username, list.tag_no, list.category
                    from
                    (	select row_number() over (order by r.created_at desc) as no, r.rev_seq, 
                            r.rev_title, r.rating, l.lec_seq, l.lec_name, l.instructor, u.id, u.username, l.tag_no, t.category
                        from Reviews r left join Lectures l 
                            on r.lec_seq = l.lec_seq
                            left join Tags t
                            on l.tag_no = t.code
                            left join Users u
                            on r.author = u.id
                        where 1=1".$where_con1.$where_con2."
                    ) list
                    where ( list.no > ".($limit-200).") and (list.no <= ".$limit.")
                )ll";

                
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
        $result['lastPage'] = $endNum == $limit ? $plate*10 : ceil($endNum/20);


        if(isset($result['startPage']) && isset($result['lastPage'])){
            $result['status'] = true;
        } else {
            $result['status'] = false;
        }
    }

    return $result;
}

// 강의 정보 list 가져오는 함수 + 페이지네이션, 검색 추가
function getReviewList ($param) {
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

        $where_con1 = $tag_no == '0' ? "" : " and l.tag_no = ? ";
        $where_con2 = $word == '' ? "" : (" and l.".$col." like ?");

        $sql = "select list.no, list.rev_seq, list.rev_title, list.rating, list.lec_seq, list.lec_name, 
                    list.instructor, list.id, list.username, list.tag_no, list.category
                from
                (	select row_number() over (order by r.created_at desc) as no, r.rev_seq, 
                        r.rev_title, r.rating, l.lec_seq, l.lec_name, l.instructor, u.id, u.username, l.tag_no, t.category
                    from Reviews r left join Lectures l 
                        on r.lec_seq = l.lec_seq
                        left join Tags t
                        on l.tag_no = t.code
                        left join Users u
                        on r.author = u.id
                    where 1=1".$where_con1.$where_con2."
                ) list
                where ( list.no > (?-1)*20) and (list.no <= ?*20)";

        $stmt = mysqli_prepare($conn, $sql);

        // echo $sql;
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