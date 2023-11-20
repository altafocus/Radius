<?php
	date_default_timezone_set("Asia/Jakarta");
	session_start();
	if(!isset($_SESSION['login']) || empty($_SESSION['login'])){ header("location: login.php"); }
	include "lib/routeros.php";
	function convert_filesize($bytes, $decimals = 2){
		$size = array(' B',' kB',' MB',' GB',' TB',' PB',' EB',' ZB',' YB');
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}
	$month_array1 = array(
		"jan","feb","mar",
		"apr","may","jun",
		"jul","aug","sep",
		"oct","nov","dec"
	);
	$month_array2 = array(
		"jan"=>"01","feb"=>"02","mar"=>"03",
		"apr"=>"04","may"=>"05","jun"=>"06",
		"jul"=>"07","aug"=>"08","sep"=>"09",
		"oct"=>"10","nov"=>"11","dec"=>"12"
	);
	$address = $_SESSION["login"]["address"];
	$username = $_SESSION["login"]["username"];
	$password = $_SESSION["login"]["password"];
	$api = new RouterosAPI();
	$api->debug = false;
	$status = $api->connect($address, $username, $password);

	function generateRandomString($length = 10) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	function format_bytes($bytes, $decimals = 2) {
		$size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}
	function convert_seconds($seconds){
		$dt1 = new DateTime("@0");
		$dt2 = new DateTime("@$seconds");
		$days = $dt1->diff($dt2)->format('%a');
		$hours = $dt1->diff($dt2)->format('%h');
		$minutes = $dt1->diff($dt2)->format('%m');
		$seconds = $dt1->diff($dt2)->format('%s');
		if($days==0 && $hours==0 && $minutes==0){ return "$seconds";}
		elseif($days==0 && $hours==0){ return $minutes."m,".$seconds."s";}
		elseif($days==0){ return $hours."h,".$minutes."m,".$seconds."s";}
		else{ return $days."d,".$hours."h,".$minutes."m,".$seconds."s";}

	  	//return $dt1->diff($dt2)->format('%ad, %hh, %im, %ss');
	}
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
	<script src="https://www.gstatic.com/firebasejs/7.2.2/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.2.2/firebase-analytics.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.2.2/firebase-auth.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.2.2/firebase-firestore.js"></script>

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
					<a href="?view=dashboard" class="nav-link">Home</a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="https://wa.me/6281617849221" class="nav-link">Developer</a>
				</li>
			</ul>

			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
						<i class="far fa-comments"></i>
						<span class="badge badge-danger navbar-badge" id="notification_count">0</span>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 10px;">
						<div id="notification_list"></div>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
					</div>
				</li>
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
						<a href="#" class="d-block"><?=$_SESSION['login']['name'];?></a>
					</div>
				</div>

				<nav class="mt-2">

					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

						<li class="nav-item">
							<a href="?view=dashboard" class="nav-link">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>Home</p>
							</a>
						</li>



						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-shopping-cart"></i>
								<p>
									Sales
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?view=sales_member" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Members</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?view=sales_reporting" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Reporting</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?view=add_sales" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Add New</p>
									</a>
								</li>
							</ul>
						</li>

						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-globe"></i>
								<p>
									PPPoE
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?view=ppp_profiles" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Profiles</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?view=ppp_secret" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Secret</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?view=ppp_active" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Active Connection</p>
									</a>
								</li>
							</ul>
						</li>

						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-sitemap"></i>
								<p>
									Networks
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?view=firewall" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Firewall</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?view=dhcp_leases" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>DHCP Leases</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?view=speedtest" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Speed Test</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-wifi"></i>
								<p>
									Hotspot
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?view=hotspot_profiles" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Profiles</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?view=hotspot_users" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Users</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?view=hotspot_active" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Active Users</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?view=hotspot_ip_bindings" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>IP Bindings</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?view=hotspot_check_status" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Check Status</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="?view=hotspot_generate" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Generate</p>
									</a>
								</li>
							</ul>
						</li>

						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-cogs"></i>
								<p>
									System
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?view=system_scheduler" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Scheduler</p>
									</a>
								</li>
							</ul>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?view=system_logs" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Logs</p>
									</a>
								</li>
							</ul>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?view=template_editor" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Template Editor</p>
									</a>
								</li>
							</ul>
						</li>

						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon far fa-comments"></i>
								<p>
									Community
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="?view=conversations" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Conversations</p>
									</a>
								</li>
							</ul>
							
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
						if($status == 1){
							if(!isset($_GET["view"]) || empty($_GET["view"]) || $_GET["view"]=="dashboard"){
								include("view/dashboard.php");
							}else{
								if($_GET["view"]=="add_sales"){ include("view/add_sales.php"); }
								if($_GET["view"]=="sales_member"){ include("view/sales_member.php"); }
								if($_GET["view"]=="sales_reporting"){ include("view/sales_reporting.php"); }
								if($_GET["view"]=="sales_payment"){ include("view/sales_payment.php"); }
								if($_GET["view"]=="sales_detail"){ include("view/sales_detail.php"); }
								
								if($_GET["view"]=="ppp_profiles"){ include("view/ppp_profiles.php"); }
								if($_GET["view"]=="ppp_secret"){ include("view/ppp_secret.php"); }
								if($_GET["view"]=="ppp_active"){ include("view/ppp_active.php"); }
								if($_GET["view"]=="ppp_add_secret"){ include("view/ppp_add_secret.php"); }

								if($_GET["view"]=="hotspot_profiles"){ include("view/hotspot_profiles.php"); }
								if($_GET["view"]=="hotspot_add_profiles"){ include("view/hotspot_add_profiles.php"); }
								if($_GET["view"]=="hotspot_edit_profiles"){ include("view/hotspot_edit_profiles.php"); }
								if($_GET["view"]=="hotspot_users"){ include("view/hotspot_users.php"); }
								if($_GET["view"]=="hotspot_active"){ include("view/hotspot_active.php"); }
								if($_GET["view"]=="hotspot_check_status"){ include("view/hotspot_check_status.php"); }
								if($_GET["view"]=="hotspot_generate"){ include("view/hotspot_generate.php"); }
								if($_GET["view"]=="hotspot_ip_bindings"){ include("view/hotspot_ip_bindings.php"); }
								
								if($_GET["view"]=="firewall"){ include("view/firewall.php"); }
								if($_GET["view"]=="dhcp_leases"){ include("view/dhcp_leases.php"); }
								if($_GET["view"]=="speedtest"){ include("view/speedtest.php"); }
								
								if($_GET["view"]=="conversations"){ include("view/conversations.php"); }

								if($_GET["view"]=="system_scheduler"){ include("view/system_scheduler.php"); }
								if($_GET["view"]=="system_logs"){ include("view/system_logs.php"); }
								if($_GET["view"]=="template_editor"){ include("view/template_editor.php"); }
							}
						}else{ ?>
							<script type="text/javascript">
								window.location.href = "login.php";
							</script>
						<?php }
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

		function _0x2e4a(_0x4a3938,_0x3df6df){var _0x1ac3ba=_0x1ac3();return _0x2e4a=function(_0x2e4a13,_0x2ab955){_0x2e4a13=_0x2e4a13-0x92;var _0x37dfcd=_0x1ac3ba[_0x2e4a13];return _0x37dfcd;},_0x2e4a(_0x4a3938,_0x3df6df);}var _0xe0af3d=_0x2e4a;(function(_0x381996,_0x31616a){var _0x20b1f4=_0x2e4a,_0x1ad765=_0x381996();while(!![]){try{var _0x7c803c=parseInt(_0x20b1f4(0xa7))/0x1+parseInt(_0x20b1f4(0xa2))/0x2*(-parseInt(_0x20b1f4(0x9f))/0x3)+-parseInt(_0x20b1f4(0x9e))/0x4*(parseInt(_0x20b1f4(0xa4))/0x5)+parseInt(_0x20b1f4(0xaa))/0x6*(parseInt(_0x20b1f4(0x97))/0x7)+-parseInt(_0x20b1f4(0x9a))/0x8+parseInt(_0x20b1f4(0x9c))/0x9+parseInt(_0x20b1f4(0x93))/0xa*(parseInt(_0x20b1f4(0x96))/0xb);if(_0x7c803c===_0x31616a)break;else _0x1ad765['push'](_0x1ad765['shift']());}catch(_0x30d00a){_0x1ad765['push'](_0x1ad765['shift']());}}}(_0x1ac3,0xe635f));var db=firebase[_0xe0af3d(0x98)]();db[_0xe0af3d(0x99)]('notifications')['orderBy'](_0xe0af3d(0xa9))['get']()[_0xe0af3d(0xa3)](function(_0x5f1e48){var _0x539e0f=_0xe0af3d,_0x346536=0x0;_0x5f1e48[_0x539e0f(0xa5)](function(_0x12b9ef){var _0x5ec8f0=_0x539e0f;_0x346536++,$(_0x5ec8f0(0xa1))[_0x5ec8f0(0xab)](_0x346536),$(_0x5ec8f0(0xa0))['prepend'](_0x5ec8f0(0x95)+_0x12b9ef['data']()[_0x5ec8f0(0x94)]+_0x5ec8f0(0x9b)+_0x12b9ef['data']()['title']+_0x5ec8f0(0xa6)+_0x12b9ef[_0x5ec8f0(0x9d)]()[_0x5ec8f0(0xa8)]+'</p>\x0a\x09\x09\x09\x09\x09<p\x20class=\x22text-sm\x20text-muted\x22><i\x20class=\x22far\x20fa-clock\x20mr-1\x22></i>\x20'+_0x12b9ef[_0x5ec8f0(0x9d)]()['datetime']+_0x5ec8f0(0x92));});});function _0x1ac3(){var _0x58ac8a=['3565210mxUmrd','link','\x0a\x09\x09\x09\x09\x09<a\x20href=\x22','77ECMgRt','263123jIINzI','firestore','collection','12571184AnKRtA','\x22\x20class=\x22dropdown-item\x22>\x0a\x09\x09\x09\x09\x09<div\x20class=\x22media\x22>\x0a\x09\x09\x09\x09\x09<img\x20src=\x22images/profile.jpg\x22\x20alt=\x22User\x20Avatar\x22\x20class=\x22img-size-50\x20mr-3\x20img-circle\x22>\x0a\x09\x09\x09\x09\x09<div\x20class=\x22media-body\x22>\x0a\x09\x09\x09\x09\x09<h3\x20class=\x22dropdown-item-title\x22>\x0a\x09\x09\x09\x09\x09<b>Developer</b>\x0a\x09\x09\x09\x09\x09<span\x20class=\x22float-right\x20text-sm\x20text-danger\x22><i\x20class=\x22fas\x20fa-star\x22></i></span>\x0a\x09\x09\x09\x09\x09</h3>\x0a\x09\x09\x09\x09\x09<p\x20class=\x22text-sm\x22>','13807359WumfWQ','data','49548SmkBHA','1386087hfxOao','#notification_list','#notification_count','2frqDWb','then','755YMklng','forEach','<br>','102818roEYQW','content','datetime','114PBBVkS','html','</p>\x0a\x09\x09\x09\x09\x09</div>\x0a\x09\x09\x09\x09\x09</div>\x0a\x09\x09\x09\x09\x09</a>\x0a\x09\x09\x09\x09\x09'];_0x1ac3=function(){return _0x58ac8a;};return _0x1ac3();}
	</script>
</body>
</html>
