<?php
	session_start();
	include "../lib/txtdb.php";
	$db = new TxtDb([
		'dir'      => '../view/',
		'extension' => 'php',
		'encrypt'   => false,
	]);
	if(!isset($_POST["username"]) || empty($_POST["username"])){ header("location: ../login.php"); }
	elseif(!isset($_POST["password"]) || empty($_POST["password"])){ header("location: ../login.php"); }
	else{
		$username = $_POST["username"];
		$password = $_POST["password"];

		$simple_string = "$password\n";
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;

		
		
		$encryption_iv = '1234567891011121';
		$encryption_key = "SB4";
		$encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);

		/*
		$decryption_iv = '1234567891011121';
		$decryption_key = "SB4";
		$decryption = openssl_decrypt($encryption, $ciphering, $decryption_key, $options, $decryption_iv);
		*/

		$user = $db->select("user");
		foreach($user as $key => $value){
			if($value["password"] == $encryption){
				$_SESSION['admin'] = $username;
				header("location: ../index.php");
				echo $encryption;
			}else{
				header("location: ../login.php");
				echo $encryption;
			}
		}
	}
?>
