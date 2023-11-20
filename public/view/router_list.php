<div class="table-responsive">
	<table class="table table-sm table-hover text-nowrap table-striped">
		<tr class="bg-success">
			<th>#</th>
			<th>Name</th>
			<th>Address</th>
			<th>Username</th>
			<th>Action</th>
		</tr>
		<?php
			$router = $db->select("router");
			if(!isset($_GET["action"]) || empty($_GET["action"])){}
			else{
				$id = $_GET["id"];
				$delete = $db->delete("router", $id);
				if($delete){ ?>
					<script type="text/javascript">
						window.location.href = "?view=router_list";
					</script>
				<?php }
			}
			$num = 0;
			foreach($router as $key => $value){
				$password = $value["password"];

				$simple_string = "$password\n";
				$ciphering = "AES-128-CTR";
				$iv_length = openssl_cipher_iv_length($ciphering);
				$options = 0;

				/*
				$encryption_iv = '1234567891011121';
				$encryption_key = "SB4";
				$encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);
				*/

				$decryption_iv = '1234567891011121';
				$decryption_key = "SB4";
				$decryption = openssl_decrypt($password, $ciphering, $decryption_key, $options, $decryption_iv);
				$num++;
				?>
				<tr>
					<td><?=$num;?>
					<td><?=$value["name"];?></td>
					<td><?=$value["address"];?></td>
					<td><?=$value["username"];?></td>
					<td>
						<form action="view/connect.php" method="POST">
							<input type="hidden" name="name" value="<?=$value['name'];?>">
							<input type="hidden" name="address" value="<?=$value['address'];?>">
							<input type="hidden" name="username" value="<?=$value['username'];?>">
							<input type="text" name="password" value="<?=$decryption;?>" style="display: none;">
							<button class="btn btn-sm btn-success">Open</button>
							<a href="?view=router_list&action=remove&id=<?=$key;?>" class="btn btn-sm btn-danger">Remove</a>
						</form>
					</td>
				</tr>
			<?php }
		?>
	</table>
</div>