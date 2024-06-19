<!-- <script src="../js/review/list.js"></script> -->




  <div class="search-info">
    <div class="search-form f-r">
      <select id="tagSelect" class="input-sel" style="width: 158px">
        <option value="0">분류</option>
        <option value="1">일반직무</option>
        <option value="2">산업직무</option>
        <option value="3">공통역량</option>
        <option value="4">어학 및 자격증</option>
      </select>
      <select id="wordSelect" class="input-sel" style="width: 158px">
        <option value="lec_name">강의명</option>
        <option value="instructor">강사명</option>
      </select>
      <input
        id="wordInput"
        type="text"
        class="input-text"
        placeholder="강의명을 입력하세요."
        style="width: 158px"
      />
      <button id="searchBtn" type="button" class="btn-s-dark">검색</button>
    </div>
  </div>

  <table cellpadding="0" cellspacing="0" class="tbl-bbs">
    <caption class="hidden">
      수강후기
    </caption>
    <colgroup>
      <col style="width: 8%" />
      <col style="width: 8%" />
      <col />
      <col style="width: 15%" />
      <col style="width: 12%" />
    </colgroup>

    <thead>
      <tr>
        <th scope="col">번호</th>
        <th scope="col">분류</th>
        <th scope="col">제목</th>
        <th scope="col">강좌만족도</th>
        <th scope="col">작성자</th>
      </tr>
    </thead>

    <tbody id="reviewList">
      <!-- set -->
      <!-- 동적테이블 생성 -->
      <!-- //set -->
    </tbody>
  </table>

  <div class="box-paging" style="display: flex; justify-content: center">
    <a id="firstBtn" href="#"
      ><i class="icon-first"><span class="hidden">첫페이지</span></i></a
    >
    <div id="beforeBtn" value="" href="#" style="cursor: pointer">
      <i class="icon-prev"><span class="hidden">이전페이지</span></i>
    </div>
    <div id="pNumBox">
      <!-- 동적 페이지 번호 생성 -->
    </div>
    <div id="nextBtn" value="" href="#" style="cursor: pointer">
      <i class="icon-next"><span class="hidden">다음페이지</span></i>
    </div>
    <a id="lastBtn" href="#"
      ><i class="icon-last"><span class="hidden">마지막페이지</span></i></a
    >
  </div>


