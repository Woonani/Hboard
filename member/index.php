<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<!--[if (IE 7)]><html class="no-js ie7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko"><![endif]-->
<!--[if (IE 8)]><html class="no-js ie8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko"><![endif]-->

<head>
	<?php include "../include/head.html" ?>
</head>
<body>
	<!-- skip nav -->
	<div id="skip-nav">
		<a href="#content">본문 바로가기</a>
	</div>
	<!-- //skip nav -->

	<div id="wrap">
		<div id="header" class="header">
			<?php include "../include/navbar.html" ?>
			<?php include "../include/topbar.html" ?>
            <!-- 아래 방법으로 수정할 것 -->
            <!-- include_once $_SERVER['DOCUMENT_ROOT']."/include/header.html"; -->
			
		</div>
        <div id="container">
            <?php
                $file = isset($_GET['mode']) ? $_GET['mode'].".html" : '';

                if($file && file_exists($file)) {
                    include_once $file;
                } else {
                    // 아래코드는 무한 실행..
                    // echo "<script>window.location.href = 'index.php';</script>";
                    // exit; 
                    include_once "../404.html";
                }                
            ?>
        </div>

		<script type="text/javascript">
		$(document).ready(function(){
			//main_slider_applyclass
			var bnrWrap = $('.slider-applyclass')
			var bnr_slider = bnrWrap.find('.bxslider');

			slider = bnr_slider.bxSlider({
				auto: true,
				mode : 'fade',
				cutLimit: 4,
				speed: 500,
				autoStart:true,
				pagerCustom: '#bx-pager-apply',
				onSliderLoad: function(selector){
					bnrWrap.css("overflow","visible");
				}
			});
			$('.page-applyclass').mouseover(function(){
				slider.startAuto();
			});
		});
		</script>
		
		<!-- <?php include_once $_SERVER['DOCUMENT_ROOT']."/include/footer.html"; ?> -->
		<?php include "../include/footer.html" ?>
	</div>
</body>
</html>
