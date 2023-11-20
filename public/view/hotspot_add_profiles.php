<?php
	if(!isset($_POST["name"]) || empty($_POST["name"])){}
	elseif(!isset($_POST["price"]) || empty($_POST["price"])){}
	elseif(!isset($_POST["sales_price"]) || empty($_POST["sales_price"])){}
	elseif(!isset($_POST["validity"]) || empty($_POST["validity"])){}
	elseif(!isset($_POST["times"]) || empty($_POST["times"])){}
	elseif(!isset($_POST["upload"]) || empty($_POST["upload"])){}
	elseif(!isset($_POST["download"]) || empty($_POST["download"])){}
	elseif(!isset($_POST["upload_bytes"]) || empty($_POST["upload_bytes"])){}
	elseif(!isset($_POST["download_bytes"]) || empty($_POST["download_bytes"])){}
	else{
		$name = $_POST["name"];
		$price = $_POST["price"];
		$sales_price = $_POST["sales_price"];
		$validity = $_POST["validity"];
		$times = $_POST["times"];
		$upload = $_POST["upload"];
		$download = $_POST["download"];
		$upload_bytes = $_POST["upload_bytes"];
		$download_bytes = $_POST["download_bytes"];

		$interval = 0;
		$rate_limit = "$upload$upload_bytes/$download$download_bytes";

		if($times=="h"){$interval = ($validity * 60) * 60;}
		if($times=="w"){$interval = ($validity * 60) * 60 * 24 * 7;}
		if($times=="m"){$interval = ($validity * 60) * 60 * 24 * 30;}

		if($price<1){}
		elseif($sales_price<1){}
		elseif($validity<1){}
		else{

			$script = file_get_contents("view/hotspot_script.txt");
			$set_validity = str_replace('%validity%', $interval, $script);
			$set_price = str_replace('%price%', $price, $set_validity);
			$set_sales = str_replace('%sales%', $sales_price, $set_price);

			$save = $api->comm("/ip/hotspot/user/profile/add", array(
				"name" 			=> "$name~$sales_price",
				"rate-limit" 	=> $rate_limit,
				"session-timeout" => $interval,
				"idle-timeout" => "00:15:00",
				"on-login" 		=> $set_sales
			));
			if($save){ ?>
				<script type="text/javascript">
					window.location.href = "?view=hotspot_profiles";
				</script>
			<?php }
		}
	}
?>
<form action="" method="POST">
	<div class="form-group">
		<label>Name</label>
		<input type="text" class="form-control" name="name" placeholder="Profile Name" required>
	</div>

	<div class="form-group">
		<label>Price</label>
		<input type="number" class="form-control" name="price" placeholder="0" required>
	</div>

	<div class="form-group">
		<label>Sales Price</label>
		<input type="number" class="form-control" name="sales_price" placeholder="0" required>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label>Validity</label>
				<input type="number" class="form-control" name="validity" placeholder="0" required>
			</div>
			<div class="col-md-6">
				<label>.</label>
				<select name="times" class="form-control" required>
					<option value="h">Hours</option>
					<option value="w">Week</option>
					<option value="m">Month</option>
				</select>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label>Upload</label>
				<input type="number" class="form-control" name="upload" placeholder="0" required>
			</div>
			<div class="col-md-6">
				<label>.</label>
				<select name="upload_bytes" class="form-control" required>
					<option value="k">KB/s</option>
					<option value="M">MB/s</option>
					<option value="G">GB/s</option>
				</select>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<label>Download</label>
				<input type="number" class="form-control" name="download" placeholder="0" required>
			</div>
			<div class="col-md-6">
				<label>.</label>
				<select name="download_bytes" class="form-control" required>
					<option value="k">KB/s</option>
					<option value="M">MB/s</option>
					<option value="G">GB/s</option>
				</select>
			</div>
		</div>
	</div>
	<button class="btn btn-success">Save Profile</button>
</div>
</form>