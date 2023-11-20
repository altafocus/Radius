<?php
	session_start();
	include "../lib/routeros.php";
	$api = new RouterosAPI();
	$api->debug = false;

	if(!isset($_POST["name"]) || empty($_POST["name"])){header("location: login.php");}
	elseif(!isset($_POST["address"]) || empty($_POST["address"])){header("location: login.php");}
	elseif(!isset($_POST["username"]) || empty($_POST["username"])){header("location: login.php");}
	elseif(!isset($_POST["password"]) || empty($_POST["password"])){header("location: login.php");}
	else{
		$status = $api->connect($_POST["address"], $_POST["username"], $_POST["password"]);
		if($status == 1){
			$version = $api->comm("/system/resource/print")[0]["version"];
			if(substr($version,0,1) == "6"){
				$login = array(
					"name" => $_POST["name"],
					"address" => $_POST["address"],
					"username" => $_POST["username"],
					"password" => $_POST["password"]
				);
				$_SESSION["login"] = $login;
				header("location: ../router.php?view=dashboard");
			}else{ ?>
				<p align="center" style="font-size: 24px; margin-top: 25%;">You cannot use this application on routeros version 7.<br>
				<a href="../index.php?view=router_list">Go Back</a>
				</p>
				<script type="text/javascript">
					setTimeout(function(){
						window.location.href = "../index.php?view=router_list";
					},6000);
				</script>
			<?php }
		}else{
			header("location: ../index.php?view=router_list");
		}
	}
?>