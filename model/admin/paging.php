<?php

function getPageRange ($data) {
    global $conn;
    $plate = $data;
    $limit = $plate*50;
    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $sql = "select max(ll.no) as max
                from (
                    select l.no, l.lec_name, l.instructor, 
                        l.level, l.time, l.chapter, l.image_url, l.tag_no, t.category, l.created_at, l.updated_at
                    from
                        ( select row_number() over (order by created_at desc) as no, lec_name, instructor, 
                            level, time, chapter, image_url, tag_no, created_at, updated_at 
                        from lectures 
                        where 1=1
                        -- and tag_no=''
                        -- and lec_name like ''
                        -- and instructor like '%%'
                        ) l left join tags t on l.tag_no = t.code
                    limit ".$limit."
                ) ll ";
        $stmt = mysqli_prepare($conn,$sql);
        
        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);

        $ret = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);
        // print_r($ret);
        $endNum = $ret[0]['max'];
        // print_r($endNum);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        $result['startPage'] = ($plate-1)*10+1;
        $result['lastPage'] = $endNum == $limit ? $plate*10 : ceil($endNum/5);

        if(isset($result['startPage']) && isset($result['lastPage'])){
            $result['status'] = true;
        } else {
            $result['status'] = false;
        }
    }

    return $result;
}

?>