<?php
	$user = $db->select("user");

	foreach($user as $key => $value){
		//$simple_string = "$password\n";
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;

		/*
		$encryption_iv = '1234567891011121';
		$encryption_key = "SB4";
		$encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);
		*/
		
		$password = $value["password"];
		$decryption_iv = '1234567891011121';
		$decryption_key = "SB4";
		$decryption = openssl_decrypt($password, $ciphering, $decryption_key, $options, $decryption_iv);
		
		$userkey = $key;
		$username = $value["username"];
		$old_password = $decryption;
	}
?>

<div class="row">
	<div class="col-md-6">
		<form action="" method="POST">
			<?php
				if(!isset($_POST["update"])){}
				else{
					$new_password = $_POST["password"]."\n";

					$encryption_iv = '1234567891011121';
					$encryption_key = "SB4";
					$encryption = openssl_encrypt($new_password, $ciphering, $encryption_key, $options, $encryption_iv);
					$update = $db->update("user", array(
						"username" => $_POST["username"],
						"password" => "$encryption"
					), $_POST["key"]);
					if($update){ ?>
						<script type="text/javascript">
							window.location.href = "?view=setting&status=update_success";
						</script>
					<?php }
				}
			?>
			<input type="hidden" name="key" value="<?=$key;?>">
			Username
			<input name="username" class="form-control" value="<?=$username;?>" required>
			Password
			<input name="password" type="password" class="form-control mt-2" value="<?=$old_password;?>" required>
			<button name="update" class="btn btn-block btn-success mt-2">Update</button>
		</form>
	</div>
</div>