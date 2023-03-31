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

	if($session->is_logged_in() && isset($_GET["delete"]))
	{
		$file->delete($_GET["delete"]);
		header("Location: files.php");
		exit;
	}

	$files = $file->listFiles();
	$parts = $file->listParts();

	require 'views/header.php';
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width,initial-scale=0.8">
	</head>
	<body>
		<div class="container is-fluid">
		<?php
			if(!empty($files))
			{
		?>
		<br>
		<div class="content" style="text-align: center;">
			<h1 class="title is-1">TaomNET</h1>
			<h2 class="subtitle is-5">A Web-based Downloader</h2>
		</div>
			<table class="table is-hoverable" style="max-width:1024px;margin:auto;">
				<thead>
					<tr>
						<th>파일 이름</th>
						<th>용량</th>
						<th><span class="pull-right">  </span></th>
					</tr>
				</thead>
				<tbody>
			<?php
				foreach($files as $f)
				{
					echo "<tr>";
					if ($file->get_relative_downloads_folder())
					{
						echo "<td><a href=\"".rawurlencode($file->get_relative_downloads_folder()).'/'.rawurlencode($f["name"])."\" download>".$f["name"]."</a></td>";
					}
					else
					{
						echo "<td>".$f["name"]."</td>";
					}
					echo "<td>".$f["size"]."</td>";
					echo "<td><a href=\"./files.php?delete=".sha1($f["name"])."\" class=\"button is-small is-danger is-light\">삭제</a></td>";
					echo "</tr>";
				}
			?>
				</tbody>
			</table>
		<?php
			}
			else
			{
				echo "<br><div class=\"alert alert-warning\" role=\"alert\">다운로드된 파일이 없습니다</div>";
			}
		?>
			<br/>
		<?php
			if(!empty($parts))
			{
		?>
		<div class="content" style="text-align: center;">
			<h2 class="subtitle is-5">다운로드 중/실패한 파일</h2>
		</div>
			<table class="table is-hoverable" style="max-width:1024px;margin:auto;">
				<thead>
					<tr>
						<th>파일 이름</th>
						<th>용량</th>
						<th><span class="pull-right"> </span></th>
					</tr>
				</thead>
				<tbody>
			<?php
				foreach($parts as $f)
				{
					echo "<tr>";
					if ($file->get_relative_downloads_folder())
					{
						echo "<td><a href=\"".rawurlencode($file->get_relative_downloads_folder()).'/'.rawurlencode($f["name"])."\" download>".$f["name"]."</a></td>";
					}
					else
					{
						echo "<td>".$f["name"]."</td>";
					}
					echo "<td>".$f["size"]."</td>";
					echo "<td><a href=\"./files.php?delete=".sha1($f["name"])."\" class=\"button is-small is-danger is-light\">삭제</a></td>";
					echo "</tr>";
				}
			?>
				</tbody>
			</table>
			<br/>
			<br/>
		<?php
			}
		?>
			<br/>
		</div>
		</body>
		</html>
