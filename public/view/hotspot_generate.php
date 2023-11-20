<?php
	$api->write("/system/script/print");
	$script = $api->read();

	$api->write("/ip/hotspot/user/profile/print");
	$profile = $api->read();

	function generate_code($char, $length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
	    if($char == "1"){ $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';}
	    if($char == "2"){ $characters = '0123456789';}
	    if($char == "3"){ $characters = 'abcdefghijklmnopqrstuvwxyz';}
	    if($char == "4"){ $characters = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ';}
	    if($char == "5"){ $characters = '123456789abcdefghjklmnpqrstuvwxyz';}

	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[random_int(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	if(!isset($_POST["sales_phone"]) || empty($_POST["sales_phone"])){}
	elseif(!isset($_POST["profile"]) || empty($_POST["profile"])){}
	elseif(!isset($_POST["quantity"]) || empty($_POST["quantity"])){}
	elseif(!isset($_POST["mode"]) || empty($_POST["mode"])){}
	elseif(!isset($_POST["char"]) || empty($_POST["char"])){}
	elseif(!isset($_POST["length"]) || empty($_POST["length"])){}
	else{
		$date = date("Y/m/d");
		$time = date("h:i:s");

		$g_sales_phone = $_POST['sales_phone'];
		$g_profile = $_POST['profile'];
		$g_quantity = $_POST['quantity'];
		$g_mode = $_POST['mode'];
		$g_char = $_POST['char'];
		$g_length = $_POST['length'];

		// 085862375600/[13/3/2023] [7:16:52] [160]
		$g_comment = "$g_sales_phone/[$date] [$time] [$g_quantity]";

		for($i=0; $i<$g_quantity; $i++){
			switch($g_mode){
				case "=":
					$username = generate_code($g_char, $g_length);
					$password = $username;
				break;
				case "&";
					$username = generate_code($g_char, $g_length);
					$password = generate_code($g_char, $g_length);
				break;
			}
			$api->comm("/ip/hotspot/user/add", array(
				"name" => $username,
				"password" => $password,
				"profile" => $g_profile,
				"comment" => $g_comment
			));
		}
		if($g_comment){ ?>
			<script type="text/javascript">
				window.location.href = "?view=hotspot_users&profile=<?=$g_profile;?>&comment=<?=$g_comment;?>";
			</script>
		<?php }
	}
?>
<form action="" method="POST">
	Sales
	<select name="sales_phone" class="form-control mb-4">
		<option value="default">None</option>
		<?php
			foreach($script as $key => $row){
				$explode = explode("/", $row["source"]);
				if(count($explode) == 2){ ?>
					<option value="<?=$explode[0];?>"><?=$explode[1];?></option>
				<?php }
			}
		?>
	</select>

	Profile
	<select name="profile" class="form-control mb-4">
		<?php
			foreach($profile as $key => $row){ ?>
				<option value="<?=$row['name'];?>"><?=$row["name"];?></option>
			<?php }
		?>
	</select>
	Quantity
	<input type="text" name="quantity" placeholder="0" class="form-control mb-4" required>

	Mode
	<select class="form-control mb-4" name="mode">
		<option value="=">Username = Password</option>
		<option value="&">Username & Password</option>
	</select>

	Characters
	<select class="form-control mb-4" name="char">
		<option value="1">ABCDEF</option>
		<option value="2">123456</option>
		<option value="3">abcdef</option>
		<option value="4">123ABC</option>
		<option value="5">123abc</option>
	</select>
	Characters Length
	<select class="form-control mb-4" name="length">
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
	</select>
	<button class="btn btn-block btn-success">Generate</button>
</form>