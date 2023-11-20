<?php
	date_default_timezone_set("Asia/Jakarta");
	session_start();
	if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])){ header("location: login.php"); }
	include "lib/routeros.php";
	include "lib/txtdb.php";
	$db = new TxtDb([
		'dir'      => 'view/',
		'extension' => 'php',
		'encrypt'   => false,
	]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>STARS BILLING</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="title" content="MIKROTIK EXPERT - Free MikroTik RouterOS Online Tools.">
	<meta name="description" content="Free MikroTik RouterOS Online Tools Generator, the most complete Router tools to make it easier for you maker RouterOS Mikrotik scripts!">
	<meta name="keywords" content="mikrotik, router os, tools, load balancing, queue, vpn, routing, winbox, termimal, rsc, script, hotspot, wireless, mangle, nat, mikrotik expert">
	<meta name="robots" content="index, follow">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="English">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="themes/v3/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="themes/v3/dist/css/adminlte.min.css">
	<style type="text/css">
		/* width */
		::-webkit-scrollbar {
		  width: 10px;
		  height: 10px;
		}

		/* Track */
		::-webkit-scrollbar-track {
		  background: #f1f1f1;
		}

		/* Handle */
		::-webkit-scrollbar-thumb {
		  background: #888;
		}

		/* Handle on hover */
		::-webkit-scrollbar-thumb:hover {
		  background: #555;
		}
	</style>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed">
	<script src="themes/v3/plugins/jquery/jquery.min.js"></script>
	<script src="themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="themes/v3/dist/js/adminlte.js"></script>
	<script type="text/javascript">
		// For Firebase JS SDK v7.20.0 and later, measurementId is optional
		const firebaseConfig = {
		  apiKey: "AIzaSyDCNDxekv-5OWBLpkl0E0t7pB_CbxmiYcw",
		  authDomain: "septian-127001.firebaseapp.com",
		  databaseURL: "https://septian-127001-default-rtdb.asia-southeast1.firebasedatabase.app",
		  projectId: "septian-127001",
		  storageBucket: "septian-127001.appspot.com",
		  messagingSenderId: "25544442912",
		  appId: "1:25544442912:web:b0f990bcdb34a06d666845",
		  measurementId: "G-7WTFCKJ5CS"
		};
	  // Initialize Firebase
		firebase.initializeApp(firebaseConfig);
		firebase.analytics();
	</script>
	<div class="wrapper">
		<div class="preloader flex-column justify-content-center align-items-center">
			<img src="images/loader.gif" width="100" height="100"><br><b>Loading...</b>
		</div>
		<nav id="navbar" class="main-header navbar navbar-expand navbar-dark">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="?view=router_list" class="nav-link">Home</a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="https://wa.me/6281617849221" class="nav-link">Developer</a>
				</li>
			</ul>

			<ul class="navbar-nav ml-auto">
				
				<li class="nav-item">
					<a class="nav-link" data-widget="fullscreen" href="#" role="button">
						<i class="fas fa-expand-arrows-alt"></i>
					</a>
				</li>
				<li class="nav-item" onclick="change_theme()">
					<a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
						<i class="fa fa-lightbulb"></i>
					</a>
				</li>
			</ul>
		</nav>

		<aside id="sidebar" class="main-sidebar sidebar-light-primary elevation-4">

			<div class="sidebar">
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="themes/v3/dist/img/user.png" class="img-circle elevation-2" alt="User Image">
					</div>
					<div class="info">
						<a href="#" class="d-block"><?=$_SESSION['admin'];?></a>
					</div>
				</div>

				<nav class="mt-2">

					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

						<li class="nav-item">
							<a href="?view=router_list" class="nav-link">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>Home</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-shopping-cart"></i>
								<p>
									Router
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?view=router_add_new" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Add New</p>
									</a>
								</li>
								
							</ul>
						</li>

						<li class="nav-item">
							<a href="?view=setting" class="nav-link">
								<i class="nav-icon fas fa-cog"></i>
								<p>Setting</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="view/disconnect.php" class="nav-link">
								<i class="nav-icon fas fa-lock"></i>
								<p>Exit</p>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</aside>
		<div class="content-wrapper">
			<div class="content-header">
				<div class="container-fluid">

				</div>
			</div>
			<section class="content">
				<div class="container-fluid">
					<?php
						if(!isset($_GET["view"]) || empty($_GET["view"])){
							include("view/router_list.php");
						}else{
							if($_GET["view"] == "router_list"){ include("view/router_list.php"); }
							if($_GET["view"] == "router_add_new"){ include("view/router_add_new.php"); }
							if($_GET["view"] == "setting"){ include("view/setting.php"); }
						}
					?>
				</div>
			</section>
		</div>
	</div>

	<script type="text/javascript">
		function set_theme_dark(){
			$("body").addClass("dark-mode");
			$("#navbar").removeClass("navbar-light");
			$("#navbar").addClass("navbar-dark");
			$("#sidebar").removeClass("sidebar-light-primary");
			$("#sidebar").addClass("sidebar-dark-primary");
			localStorage.setItem("dark-mode", 1);
		}

		function set_theme_light(){
			$("body").removeClass("dark-mode");
			$("#navbar").removeClass("navbar-dark");
			$("#navbar").addClass("navbar-light");
			$("#sidebar").removeClass("sidebar-dark-primary");
			$("#sidebar").addClass("sidebar-light-primary");
			localStorage.setItem("dark-mode", 0);;
		}

		function change_theme(){
			var dark = document.getElementsByClassName("dark-mode");
			if(dark.length>0){
				set_theme_light();
			}else{
				set_theme_dark();
			}
		}

		if(localStorage.getItem("dark-mode") == 1){
			set_theme_dark();
		}else{
			set_theme_light();
		}
	</script>
</body>
</html>
