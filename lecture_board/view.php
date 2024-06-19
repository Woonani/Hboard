<script src="../js/review/list.js"></script>
<script src="../js/review/view.js"></script>

<div id="content" class="content">
  <div class="tit-box-h3">
    <h3 class="tit-h3">수강후기</h3>
    <div class="sub-depth">
      <span
        ><i class="icon-home"><span>홈</span></i></span
      >
      <span>직무교육 안내</span>
      <strong>수강후기</strong>
    </div>
  </div>

  <table border="0" cellpadding="0" cellspacing="0" class="tbl-bbs-view">
    <caption class="hidden">
      수강후기
    </caption>
    <colgroup>
      <col style="*" />
      <col style="width: 20%" />
    </colgroup>
    <tbody>
      <tr>
        <th id="rev_title" scope="col"></th>
        <th id="user_id" scope="col" class="user-id"></th>
      </tr>
      <tr>
        <td colspan="2">
          <div class="box-rating">
            <span class="tit_rating">강의만족도</span>
            <span class="star-rating">
              <span id="rating" class="star-inner" style="width: 80%"></span>
            </span>
          </div>
          <div id="contents"></div>
        </td>
      </tr>
    </tbody>
  </table>

  <p class="mb15">
    <strong id="user_id2" class="tc-brand fs16"></strong>
  </p>

  <table border="0" cellpadding="0" cellspacing="0" class="tbl-lecture-list">
    <caption class="hidden"></caption>
    <colgroup>
      <col style="width: 166px" />
      <col style="*" />
      <col style="width: 110px" />
    </colgroup>
    <tbody>
      <tr>
        <td>
          <a href="#" class="sample-lecture">
            <img
              id="image_url"
              src="http://via.placeholder.com/144x101"
              alt=""
              width="144"
              height="101"
            />
            <span class="tc-brand">샘플강의 ▶</span>
          </a>
        </td>
        <td class="lecture-txt">
          <em id="lec_name" class="tit mt10"></em>
          <p id="lec_info" class="tc-gray mt20"></p>
        </td>
        <td class="t-r">
          <a href="#" class="btn-square-line">강의<br />상세</a>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="box-btn t-r">
    <a
      href="http://test.hackers.com/lecture_board/index.php?mode=list"
      class="btn-m-gray"
      >목록</a
    >
    <a
      href="http://test.hackers.com/lecture_board/index.php?mode=rewrite"
      class="btn-m ml5"
      >수정</a
    >
    <a href="#" class="btn-m-dark">삭제</a>
  </div>

  
<?php include "./board.php"
?>

</div>
