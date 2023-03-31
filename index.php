<?php
	require_once 'class/Session.php';
	require_once 'class/Downloader.php';
	require_once 'class/FileHandler.php';

	$session = Session::getInstance();
	$file = new FileHandler;

	if(!$session->is_logged_in())
	{
		header("Location: login.php");
		exit;
	}
	else
	{
		if(isset($_GET['kill']) && !empty($_GET['kill']) && $_GET['kill'] === "all")
		{
			Downloader::kill_them_all();
		}

		if(isset($_POST['urls']) && !empty($_POST['urls']))
		{
			$audio_only = false;
			if(isset($_POST['audio']) && !empty($_POST['audio']))
			{
				$audio_only = true;
			}

			$outfilename = False;
			if(isset($_POST['outfilename']) && !empty($_POST['outfilename']))
			{
				$outfilename = $_POST['outfilename'];
			}

			$vformat = False;
			if(isset($_POST['vformat']) && !empty($_POST['vformat']))
			{
				$vformat = $_POST['vformat'];
			}

			$downloader = new Downloader($_POST['urls']);
			$downloader->download($audio_only, $outfilename, $vformat);

			if(!isset($_SESSION['errors']))
			{
				header("Location: index.php");
				exit;
			}
		}
	}

	require 'views/header.php';
	?>
	<html>
		<head>
			<meta name="viewport" content="width=device-width,initial-scale=0.8">
		</head>
	<body>
	<br>
		<div class="container is-fluid">
			<div class="content" style="text-align: center;">
				<h1 class="title is-1">TaomNET</h1>
				<h2 class="subtitle is-5">A Web-based Downloader</h2>
			</div>
			<?php

				if(isset($_SESSION['errors']) && $_SESSION['errors'] > 0)
				{
					foreach ($_SESSION['errors'] as $e)
					{
						echo "<div class=\"alert alert-warning\" role=\"alert\">$e</div>";
					}
				}

			?>
			<form id="download-form" action="index.php" method="post" class="box" style="max-width:1024px;margin:auto;">
				<div class="field">
					<div class="control">
						<input id="box" class="input is-hovered" id="url" name="urls" type="text" placeholder="유튜브 링크를 입력하세요" required/>
					</div>
				</div>
			<div class="block">
			<div class="field is-grouped">
				<div class="control">
					<button type="submit" class="button is-primary">다운로드</button>
				</div>
					<label class="checkbox" for="audioCheck">
						<input class="form-check-input" type="checkbox" id="audioCheck" name="audio"/>
								오디오만 다운하기
					</label>
				</div>
				</div>
				</div>
		</div>
	</body>
	</html>
