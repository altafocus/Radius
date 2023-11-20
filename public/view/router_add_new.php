<div class="row">
	<div class="col-md-6">
		<form action="" method="POST" autocomplete="off">
			<?php
				if(!isset($_POST["save"])){}
				else{
					$simple_string = $_POST["password"]."\n";
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
					$save = $db->insert("router", array(
						"name" => $_POST["name"],
						"address" => $_POST["address"],
						"username" => $_POST["username"],
						"password" => $encryption
					));
					if($save){ ?>
						<script type="text/javascript">
							window.location.href = "?view=router_list";
						</script>
					<?php }
				}
			?>
			Name
			<input name="name" class="form-control" placeholder="Name" required>
			Address
			<input name="address" class="form-control mt-2" placeholder="IP Address / VPN Remote" required>
			Username
			<input name="username" class="form-control mt-2" placeholder="Username" required>
			Password
			<input name="password" type="password" class="form-control mt-2" placeholder="Password" required>
			<button name="save" class="btn btn-block btn-success mt-2">Save</button>
		</form>
	</div>
</div>