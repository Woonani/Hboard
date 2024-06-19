
	<div class="top-section">
		<div class="inner">
			<div class="link-box">
				<?php					
					// 로그인 전
					if(!isset($_SESSION['login_user_id'])) {	
				?>					
				<!-- <a href="http://test.hackers.com/controller/member/login.php">로그인</a> -->
				<a href="http://test.hackers.com/member/index.php">로그인</a>
				<a href="http://test.hackers.com/member/index.php?mode=step_01">회원가입</a>
				<a href="#">상담/고객센터</a>
				<?php		
					} else {
					// 로그인 후
				?>				
				<a href="http://test.hackers.com/controller/member/auth.php?mode=logout">로그아웃</a>
				<a href="http://test.hackers.com/member/index.php?mode=modify">내정보</a>
				<a href="#">상담/고객센터</a>
				<?php 
				}
				?>
			</div>
		</div>
	</div>
</div>