<div class="nav-section">
			<div class="inner p-r">
				<h1><a href="/"><img src="https://cdn.hackershrd.com/img_hrd/main/re_210929/logo_black.png" alt="해커스 HRD LOGO" width="165" height="37"/></a></h1>
				<div class="nav-box">
					<h2 class="hidden">주메뉴 시작</h2>
					
					<ul class="nav-main-lst">
						<li class="mnu">
							<a href="#">일반직무</a>
							<ul class="nav-sub-lst">
								<li><a href="#">서브메뉴</a></li>
								<li><a href="#">서브메뉴</a></li>
								<li><a href="#">서브메뉴</a></li>
								<li><a href="#">서브메뉴</a></li>
								<li><a href="#">서브메뉴</a></li>
								<li><a href="#">서브메뉴</a></li>
								<li><a href="#">서브메뉴</a></li>
							</ul>
						</li>
						<li class="mnu2">
							<a href="#">산업직무</a>
							<ul class="nav-sub-lst">
								<!-- <li><a href="#">서브메뉴</a></li>
								<li><a href="#">서브메뉴</a></li> -->
							</ul>
						</li>
						<li class="mnu3">
							<a href="#">공통역량</a>
							<ul class="nav-sub-lst">
								<!-- <li><a href="#">서브메뉴</a></li>
								<li><a href="#">서브메뉴</a></li> -->
							</ul>
						</li>
						<li class="mnu4">
							<a href="#">어학 및 자격증</a>
							<ul class="nav-sub-lst">
								<!-- <li><a href="#">서브메뉴</a></li>
								<li><a href="#">서브메뉴</a></li> -->
							</ul>
						</li>
						<li class="mnu5">
							<a href="#">직무교육 안내</a>
							<ul class="nav-sub-lst">
								<!-- <li><a href="#">서비스소개</a></li>
								<li><a href="#">사업주훈련</a></li>
								<li><a href="#">국민내일배움카드안내</a></li>
								<li><a href="#">학습안내</a></li> -->
								<li><a href="http://test.hackers.com/lecture_board/index.php?mode=list">수강후기</a></li>
								<!-- <li><a href="#">역량강화 자료모음</a></li>
								<li><a href="#">실무활용무료자료</a></li> -->
							</ul>
						</li>
						<li class="mnu6">
                            <?php					
                                // 관리자 메뉴
                                if(isset($_SESSION['login_user_id']) && $_SESSION['login_user_id']=='admin') {	
                            ?>
							<a href="#">관리자 메뉴</a>
							<ul class="nav-sub-lst">
								<li><a href="http://test.hackers.com/admin/index.php">강의 관리</a></li>
							</ul>
                            <?php		
                                } else {
                                // 일반 사용자 메뉴
                                
                            ?>	
                            <a href="#">내 강의실</a>
							<ul class="nav-sub-lst">
								<li><a href="#">서브메뉴</a></li>
								<li><a href="#">서브메뉴</a></li>
							</ul>
                            <?php 
                            }
                            ?>
						</li>
					</ul>
				</div>
			</div>

			<div class="nav-sub-box">
				<div class="inner"><!-- <a href="#"><img src="/" alt="배너이미지" width="171" height="196"></a> --></div>
			</div>

		</div>