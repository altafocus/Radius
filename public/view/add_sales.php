<form action="" method="POST">
	<?php
		if(!isset($_POST["first_name"]) || empty($_POST["first_name"])){}
		elseif(!isset($_POST["last_name"]) || empty($_POST["last_name"])){}
		elseif(!isset($_POST["phone_number"]) || empty($_POST["phone_number"])){}
		else{
			$save = $api->comm("/system/script/add", array(
				"name"=>"SL".$_POST["phone_number"],
				"source"=>$_POST["phone_number"]."/".$_POST["first_name"]." ".$_POST["last_name"]
			));
			if($save){ ?>
				<script type="text/javascript">
					window.location.href = "?view=sales_member";
				</script>
			<?php }
		}
	?>
	<div class="row">
		<div class="col-md-6">
			<div class="card card-success card-outline">
				<div class="card-body">
					<div class="form-group">
						<label>First Name</label>
						<input class="form-control" id="first_name" name="first_name" required>
					</div>
					<div class="form-group">
						<label>Last Name</label>
						<input class="form-control" id="last_name" name="last_name" required>
					</div>
					<div class="form-group">
						<label>Phone Number</label>
						<input type="number" class="form-control" id="phone_number" name="phone_number" required>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card card-success card-outline">
				<div class="card-body box-profile">
					<div class="text-center">
						<img id="view_photo" class="profile-user-img img-fluid img-circle" src="images/profile.jpg" alt="User profile picture" style="width:100px; height: 100px;">
					</div>
					<h3 class="profile-username text-center"><span id="view_name">Sales Name</span></h3>
					<p class="text-muted text-center"><span id="view_phone">081617849221</span></p>
					<ul class="list-group list-group-unbordered mb-3">
						<li class="list-group-item">
							<b>Total</b> <a class="float-right">0</a>
						</li>
						<li class="list-group-item">
							<b>Has Paid</b> <a class="float-right">0</a>
						</li>
						<li class="list-group-item">
							<b>Billing</b> <a class="float-right">0</a>
						</li>
					</ul>
					<button type="submit" class="btn btn-success btn-block">Save</button>
				</div>

			</div>
		</div>
	</div>
</form>
<script type="text/javascript" src="themes/v3/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
	function set_name(){
		var first_name = $("#first_name").val();
		var last_name = $("#last_name").val();
		var name = first_name + " " + last_name;
		$("#view_name").html(name);
	}

	function set_phone(){
		var phone_number = $("#phone_number").val();
		$("#view_phone").html(phone_number);
	}

	$(document).ready(function(){
		$("#first_name").keyup(function(){set_name();});
		$("#last_name").keyup(function(){set_name();});
		$("#phone_number").keyup(function(){set_phone();});
	});
</script>