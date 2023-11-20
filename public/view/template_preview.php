<?php
	session_start();
	if(!isset($_GET["mode"]) || empty($_GET["mode"])){
		for($x=0; $x<500; $x++){
			$themes = file_get_contents("../themes/voucher.html");
			$set_name = str_replace("~name~", $_SESSION["login"]["name"], $themes);
			$set_code_voucher = str_replace("~username~", "TEST", $set_name);
			$set_profile = str_replace("~profile~","5 Hours",$set_code_voucher);
			$set_price = str_replace("~price~",number_format(3000), $set_profile);
			$set_number = str_replace("~num~", $x, $set_price);
			$output = $set_number;
			echo $output;
		}
	}else{
		switch($_GET["mode"]){
			case "vc":
				for($x=0; $x<500; $x++){
					$themes = file_get_contents("../themes/voucher.html");
					$set_name = str_replace("~name~", $_SESSION["login"]["name"], $themes);
					$set_code_voucher = str_replace("~username~", "TEST", $set_name);
					$set_profile = str_replace("~profile~","5 Hours",$set_code_voucher);
					$set_price = str_replace("~price~",number_format(3000), $set_profile);
					$set_number = str_replace("~num~", $x, $set_price);
					$output = $set_number;
					echo $output;
				}
			break;
			case "us":
				for($x=0; $x<500; $x++){
					$themes = file_get_contents("../themes/member.html");
					$set_name = str_replace("~name~", $_SESSION["login"]["name"], $themes);
					$set_username = str_replace("~username~", "TEST", $set_name);
					$set_password = str_replace("~password~", "TEST", $set_username);
					$set_profile = str_replace("~profile~","5 Hours",$set_password);
					$set_price = str_replace("~price~",number_format(3000), $set_profile);
					$set_number = str_replace("~num~", $x, $set_price);
					$output = $set_number;
					echo $output;
				}
			break;
		}
	}
?>
<script type="text/javascript">
	window.print();
</script>