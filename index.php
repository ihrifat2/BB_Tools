<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>BB</title>
	<link href="asset/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="asset/style.css">
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
		<a class="navbar-brand" href="#">BBHelper</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
				</li>
			</ul>
            <form class="form-inline my-2 my-lg-0" method="post">
                <input class="form-control mr-sm-2 target" type="text" name="setTarget" placeholder="Your Target" aria-label="Target">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="btn_setTarget">Submit</button>
            </form>
		</div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col button-default bg-danger">
				<a href="cjCheck/">ClickJacking Check</a>
			</div>
			<div class="col button-default bg-primary">
				<a href="InputScanner/">Input Scanner</a>
			</div>
			<div class="col button-default bg-info">
				<a href="jsscan/">Js Scan</a>
			</div>
			<div class="col button-default bg-success">	
				<a href="cname/">Cname Checker</a>
			</div>
		</div>
	</div>
	<script src="asset/bootstrap.min.js"></script>
</body>
</html>
<?php
if (isset($_POST['btn_setTarget'])) {
    $site = trim($_POST['setTarget']);
    echo "<div class='text-center text-danger'>Your Target is Set</div>";
    $myfile = fopen("InputScanner/urls.txt", "w") or die("Unable to open file!");
	$txt = "http://". $site ."\n";
	fwrite($myfile, $txt);
	$txt = "https://". $site;
	fwrite($myfile, $txt);
	fclose($myfile);
	$url = $site;
}