<?php
	$api->write("/ip/hotspot/user/profile/print");
	$profiles = $api->read();

	if(!isset($_GET["action"]) || empty($_GET["action"])){}
	else{
		if($_GET["action"] == "delete"){
			$profile_id = $_GET["id"];
			$delete = $api->comm("/ip/hotspot/user/profile/remove", array(".id"=> $profile_id));
			if($profile_id){ ?>
				<script type="text/javascript">
					window.location.href = "?view=hotspot_profiles";
				</script>
			<?php }
		}
	}
?>

<div class="input-group">
	<a href="?view=hotspot_add_profiles" class="btn btn-success">Add New</a>
</div>
<div class="table-responsive">
	<table class="table table-sm table-hover text-nowrap table-striped mt-4">
		<thead>
			<tr class="bg-green">
				<th>#</th>
				<th>Name</th>
				<th>Price</th>
				<th>Sales price</th>
				<th>Rate Limit</th>
				<th>Validity</th>
				<th>Shared Users</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$num = 0;
				foreach($profiles as $key => $value){
					$num++;
					if(!isset($value["on-login"]) || empty($value["on-login"])){ 
						if(!isset($value["rate-limit"]) || empty($value["rate-limit"])){$rate_limit = "-"; }
						else{$rate_limit = $value["rate-limit"];}
						?>
						<tr>
							<td><?=$num;?> <a href="?view=hotspot_profiles&action=delete&id=<?=$value['.id'];?>">Delete</a></td>
							<td><?=$value["name"];?></td>	
							<td>0</td>
							<td>0</td>
							<td><?=$rate_limit;?></td>
							<td>-</td>
							<td><?=$value["shared-users"];?></td>
							<td><a href="?view=hotspot_edit_profiles&id=<?=$value['.id'];?>&name=<?=$value["name"];?>&price=0&sales_price=0>">Edit</a></td>
						</tr>
					<?php }
					else{
						$exp1 = explode(";", $value["on-login"]);
						if(count($exp1) == 4){
							$name = $value["name"];
							$price = explode(" ", $exp1[1])[3];
							$sales_price = explode(" ", $exp1[2])[3];
							if(!isset($value["rate-limit"]) || empty($value["rate-limit"])){
								$rate_limit = 0;
							}else{
								$rate_limit = $value["rate-limit"];
							}
							$validity = explode(" ", $exp1[0])[2];
							if(!isset($value["shared-users"]) || empty($value["shared-users"])){
								$shared_users = 0; 
							}else{
								$shared_users = $value["shared-users"];
							}
							?>
							<tr>
								<td><?=$num;?> <a href="?view=hotspot_profiles&action=delete&id=<?=$value['.id'];?>">Delete</a></td>
								<td><?=$name;?></td>
								<td><?=number_format($price);?></td>
								<td><?=number_format($sales_price);?></td>
								<td><?=$rate_limit;?></td>
								<td><?=convert_seconds($validity);?></td>
								<td><?=number_format($shared_users);?></td>
								<td><a href="?view=hotspot_edit_profiles&id=<?=$value['.id'];?>&name=<?=$name;?>&price=<?=$price;?>&sales_price=<?=$sales_price;?>">Edit</a></td>
							</tr>
						<?php }else{
							$name = $value["name"];
							$price = 0;
							$sales_price = 0;
							if(!isset($value["rate-limit"]) || empty($value["rate-limit"])){
								$rate_limit = 0;
							}else{
								$rate_limit = $value["rate-limit"];
							}
							$validity = 0;
							if(!isset($value["shared-users"]) || empty($value["shared-users"])){
								$shared_users = 0; 
							}else{
								$shared_users = $value["shared-users"];
							}
							?>
							<tr>
								<td><?=$num;?> <a href="?view=hotspot_profiles&action=delete&id=<?=$value['.id'];?>">Delete</a></td>
								<td><?=$name;?></td>
								<td><?=number_format($price);?></td>
								<td><?=number_format($sales_price);?></td>
								<td><?=$rate_limit;?></td>
								<td>-</td>
								<td><?=number_format($shared_users);?></td>
								<td><a href="?view=hotspot_edit_profiles&id=<?=$value['.id'];?>&name=<?=$name;?>&price=<?=$price;?>&sales_price=<?=$sales_price;?>">Edit</a></td>
							</tr>
						<?php }
					}
				}
			?>
		</tbody>
	</table>
</div>

			