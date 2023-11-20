<?php
	if (!function_exists('array_group_by')) {
		function array_group_by(array $array, $key)
		{
			if (!is_string($key) && !is_int($key) && !is_float($key) && !is_callable($key) ) {
				trigger_error('array_group_by(): The key should be a string, an integer, or a callback', E_USER_ERROR);
				return null;
			}

			$func = (!is_string($key) && is_callable($key) ? $key : null);
			$_key = $key;

			// Load the new array, splitting by the target key
			$grouped = [];
			foreach ($array as $value) {
				$key = null;

				if (is_callable($func)) {
					$key = call_user_func($func, $value);
				} elseif (is_object($value) && property_exists($value, $_key)) {
					$key = $value->{$_key};
				} elseif (isset($value[$_key])) {
					$key = $value[$_key];
				}

				if ($key === null) {
					continue;
				}

				$grouped[$key][] = $value;
			}

			// Recursively build a nested grouping if more parameters are supplied
			// Each grouped array value is grouped according to the next sequential key
			if (func_num_args() > 2) {
				$args = func_get_args();

				foreach ($grouped as $key => $value) {
					$params = array_merge([ $value ], array_slice($args, 2, func_num_args()));
					$grouped[$key] = call_user_func_array('array_group_by', $params);
				}
			}

			return $grouped;
		}
	}

	$api->write("/ip/hotspot/user/getall");
	$users = $api->read();


	$api->write("/ip/hotspot/user/profile/print");
	$profile = $api->read();

	$users_array = array();
	$comment_array = array();
	foreach($users as $users_key => $users_val){
		if(!isset($users_val["profile"]) || empty($users_val["profile"])){}
		elseif(!isset($users_val["password"]) || empty($users_val["password"])){}
		else{
			if(!isset($_GET["profile"]) || empty($_GET["profile"])){
				array_push($users_array, array(
					"id" => $users_val[".id"],
					"name" => $users_val["name"],
					"password" => $users_val["password"],
					"profile" => $users_val["profile"],
					"uptime" => $users_val["uptime"],
					"useage" => ($users_val["bytes-in"] + $users_val["bytes-out"])
				));
			}else{
				if(!isset($users_val["comment"])){}
				else{
					array_push($comment_array, array("comment"=>"Comment"));
					if($users_val["profile"] == $_GET["profile"]){
						array_push($comment_array, array("comment"=>$users_val["comment"]));
					}
				}
				if(!isset($_GET["comment"]) || empty($_GET["comment"])){
					if($_GET["profile"] == $users_val["profile"]){
						array_push($users_array, array(
							"id" => $users_val[".id"],
							"name" => $users_val["name"],
							"password" => $users_val["password"],
							"profile" => $users_val["profile"],
							"uptime" => $users_val["uptime"],
							"useage" => ($users_val["bytes-in"] + $users_val["bytes-out"])
						));
					}
				}else{
					if(!isset($users_val["comment"])){}
					else{
						if($_GET["profile"] == $users_val["profile"] && $users_val["comment"] == $_GET["comment"]){
							array_push($users_array, array(
								"id" => $users_val[".id"],
								"name" => $users_val["name"],
								"password" => $users_val["password"],
								"profile" => $users_val["profile"],
								"uptime" => $users_val["uptime"],
								"useage" => ($users_val["bytes-in"] + $users_val["bytes-out"])
							));
						}
					}
				}
			}
		}
	}
?>

<div class="table-responsive">
	<select id="profile" class="form-control mb-2">
			<?php

				if(!isset($_GET["profile"])){
					foreach($profile as $profile_key => $profile_val){ ?>
						<option><?=$profile_val["name"];?></option>
					<?php }
				}else{ ?>
					<option><?=$_GET["profile"];?></option>
				<?php 
					foreach($profile as $profile_key => $profile_val){ ?>
						<option><?=$profile_val["name"];?></option>
					<?php }
				}
			?>
		</select>
		<?php
			if(!isset($_GET["profile"])){}
			else{ 
				$comment_group = array_group_by($comment_array,"comment");
				if(!isset($_GET["comment"])){ ?>
					<select id="comment" class="form-control mb-2">
						<?php
							foreach($comment_group as $comment_key => $comment_val){ ?>
								<option><?=$comment_key;?></option>
							<?php }
						?>
					</select>
				<?php }else{ ?>
					<input type="text" value="<?=$_GET['comment'];?>" class="form-control mb-2" disabled>
					<form action="process.php" method="POST">
						<?php
							$data = "";
							foreach($users_array as $users_key => $users_val){
								$id = $users_val["id"];
								$name = $users_val["name"];
								$password = $users_val["password"];
								$profile = $users_val["profile"];
								$data .= "$id/$name/$password/$profile|";
							}
						?>
						<input type="hidden"  name="data" value="<?=$data;?>">
						<div class="row"> 
							<div class="col-md-6">
								<input type="submit" name="process" value="Remove" class="btn btn-danger btn-block mb-2">
							</div>
							<div class="col-md-6">
								<input type="submit" name="process" value="Print" class="btn btn-success btn-block mb-2">
							</div>
						</div>
					</form>
				<?php }
			}
		?>
	<script type="text/javascript">
		$("#profile").change(function(){
			window.location.href = "?view=hotspot_users&profile=" + this.value;
		});
		$("#comment").change(function(){
			window.location.href = "?view=hotspot_users&profile=" + $("#profile").val() + "&comment=" + this.value;
		});

		$("#btn_remove").click(function(){
			alert("remove");
		});
		$("#btn_print").click(function(){
			alert("print");
		});
	</script>
	<div class="table-responsive">
		<table class="table table-sm table-hover text-nowrap table-striped mt-4">
			<thead>
				<tr class="bg-success">
					<th>#</th>
					<th>Username</th>
					<th>Password</th>
					<th>Profile</th>
					<th>Useage</th>
					<th>Uptime</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$num = 0;

				$download = array();
				foreach($users_array as $key => $value){ 
					$download[$key] = $value["useage"];
				}
				array_multisort($download, SORT_DESC, $users_array);

				foreach($users_array as $users_array_key => $users_array_value){ $num++; ?>
					<tr>
						<td><?=number_format($num);?></td>
						<td><i class="far fa-user text-success"></i> <?=$users_array_value["name"];?></td>
						<td><?=$users_array_value["password"];?></td>
						<td><?=$users_array_value["profile"];?></td>
						<td><?=format_bytes($users_array_value["useage"]);?></td>
						<td><?=$users_array_value["uptime"];?></td>
					</tr>
				<?php }
				?>
			</tbody>
		</table>
	</div>
</div>