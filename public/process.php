<?php
	session_start();
	include("lib/routeros.php");
	if(!isset($_POST["data"])){}
	elseif(!isset($_POST["process"])){}
	else{
		$data = $_POST["data"];
		$process = $_POST["process"];
		if($process == "Remove"){
			
			$api = new RouterosAPI();
			$api->debug = false;
			$conn = $api->connect($_SESSION['login']['address'], $_SESSION['login']['username'], $_SESSION['login']['password']);
			if($conn == 1){
				$array = explode("|", $data);
				foreach($array as $value){
					$voucher = explode("/", $value);
					if(!isset($value[0])){}
					else{
						$api->comm("/ip/hotspot/user/remove", array(".id"=> $voucher[0]));
					}
				}
				if($array){ ?>
					<script type="text/javascript">
						window.location.href = "./router.php?view=hotspot_users";
					</script>
				<?php }
			}
		}
		if($process == "Print"){
			$array = explode("|", $data);
			$num = 0;
			foreach($array as $value){
				$voucher = explode("/", $value);
				if(count($voucher)>0){
					if(!isset($voucher[3])){}
					else{
						$num++;
						$detail = explode("~", $voucher[3]);
						if($voucher[1] == $voucher[2]){
							$themes = file_get_contents("themes/voucher.html");
							$set_name = str_replace("~name~", $_SESSION["login"]["name"], $themes);
							$set_code_voucher = str_replace("~username~", $voucher[1], $set_name);
							$set_profile = str_replace("~profile~",$detail[0],$set_code_voucher);
							$set_price = str_replace("~price~",number_format($detail[1]), $set_profile);
							$set_number = str_replace("~num~", $num, $set_price);
							$output = $set_number;
							echo $output;
						}else{
							$themes = file_get_contents("themes/member.html");
							$set_name = str_replace("~name~", $_SESSION["login"]["name"], $themes);
							$set_username = str_replace("~username~", $voucher[1], $set_name);
							$set_password = str_replace("~password~", $voucher[2], $set_username);
							$set_profile = str_replace("~profile~",$detail[0],$set_password);
							$set_price = str_replace("~price~",number_format($detail[1]), $set_profile);
							$set_number = str_replace("~num~", $num, $set_price);
							$output = $set_number;
							echo $output;
						}
					}
				}
			}
			if($num>0){ ?>
				<script type="text/javascript">window.print();</script>
			<?php }
		}
	}
?>