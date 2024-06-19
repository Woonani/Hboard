<!--  board.php 구조화를 위한 js 파일 분리 -->
<script src="../js/review/list.js"></script>
<script src="../js/review/tap.js"></script>

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

  <ul id="tapBox" class="tab-list tab5">
    <li class="on"><a id="op0" href="#">전체</a></li>
    <li><a id="op1" href="#">일반직무</a></li>
    <li><a id="op2" href="#">산업직무</a></li>
    <li><a id="op3" href="#">공통역량</a></li>
    <li><a id="op4" href="#">어학 및 자격증</a></li>
  </ul>


<?php 
// view.php에서 재사용을 위한 구조화
include "./board.php";
?>

  

  <div class="box-btn t-r">
    <a
      href="http://test.hackers.com/lecture_board/index.php?mode=write"
      class="btn-m"
      >후기 작성</a
    >
  </div>
</div>
