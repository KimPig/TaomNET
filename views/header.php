<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>TaomNET</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.css">
		<link rel="Shortcut Icon" href="./favicon.png" type="image/x-icon">
	</head>
	<body>
	<script src="https://use.fontawesome.com/releases/v6.2.1/js/all.js"></script>
		<nav class="navbar is-dark">
			<div id="main navigation" class="navbar-brand">
				<a class="navbar-item" href="./">TaomNET</a>
					<a class="navbar-item" href="./">
					  <span class="icon-text">
							<span class="icon">
								<i class="fas fa-home-alt"></i>
							</span>
							<span>홈</span>
						</span>
					</a>
					<?php
						if($session->is_logged_in() && isset($file))
					{
						?>
					<a class="navbar-item" href="./files.php">
					<span class="icon-text">
					<span class="icon">
							<i class="fa-solid fa-file"></i></span>
							<span>
						<?php
						// 파일 목록
						$filesCount = count($file->listFiles());
						if ($filesCount < 1) {
							echo '							파일 목록';
						} else {
							echo '							<b>파일 목록</b> ('.($filesCount).')';
						}
						unset($filesCount);
						?>
						
						</span>
						</span>
						</a>
						<a class="navbar-item">
									<?php if(Downloader::background_jobs() > 0) echo "다운로드 중..."; else echo "다운로드 완료!"; ?><?php if(Downloader::background_jobs() > 0) echo "<b>"; ?> <span class="caret"></span></a>
					<?php
						}
					?>
					<?php if(Downloader::background_jobs() > 0) header("refresh: 3;"); ?>
					</div>
		</nav>
