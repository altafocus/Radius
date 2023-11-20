<?php
	$api->write("/ppp/profile/print");
	$profiles = $api->read();

	if(!isset($_POST["save"])){}
	else{
		$name = $_POST["name"];
		$password = $_POST["password"];
		$profile = $_POST["profile"];
		$save = $api->comm("/ppp/secret/add", array(
			"name" => $name,
			"password" => $password,
			"profile" => $profile
		));
		if($save){ ?>
			<script type="text/javascript">
				window.location.href = "?view=ppp_secret";
			</script>
		<?php }
	}
?>
<div class="row">
	<div class="col-md-6">
		<form action="?view=ppp_add_secret" method="POST">
			Username
			<input class="form-control mb-2" name="name" placeholder="Username" required>
			Password
			<input class="form-control mb-2" name="password" placeholder="Passsword" required>
			Profile
			<select class="form-control mb-2" name="profile">
				<?php
					foreach($profiles as $profileskey => $profilesrow){
						if($profilesrow["name"] == "expire"){}
						else{ ?>
							<option value="<?=$profilesrow["name"];?>"><?=$profilesrow["name"];?></option>
						<?php }
					}
				?>
			</select>
			<button name="save" class="btn btn-success btn-block">Save</button>
		</form>
	</div>
</div>