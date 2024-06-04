<div class="top-section">
	<div class="inner">
		<div class="link-box">
			<!-- 로그인전 -->
			<a href="#">로그인</a>
			<!-- 상대경로는 안먹고, 절대경로는 깨지는 이유...? 
				<a href="../pages/01_member_01.php" >회원가입</a> 
			<a href="./app/views/pages/01_member_01.php" >회원가입</a>-->
			<?php  $rootPath = $_SERVER['DOCUMENT_ROOT']."/member/index.php?mode=step_01";
			?>
			<a href="./member/index.php?mode=step_01" >회원가입</a>

			<a href="#">상담/고객센터</a>
			<!-- 로그인후 -->
			<!-- <a href="#">로그아웃</a>
			<a href="#">내정보</a>
			<a href="#">상담/고객센터</a> -->
		</div>
	</div>
</div>