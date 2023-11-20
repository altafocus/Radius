<?php
	$api->write("/ip/hotspot/ip-binding/print");
	$bind = $api->read();
?>
<div class="row">
	<div class="col-md-6">
		<form action="" method="POST">
			<?php
				if(!isset($_POST["save"])){}
				else{
					if(!isset($_POST["add_mac"])){$add_mac = "";}else{$add_mac=$_POST["add_mac"]; }
					if(!isset($_POST["add_address"])){$add_address = "";}else{$add_address=$_POST["add_address"]; }
					if(!isset($_POST["add_type"])){$add_type = "blocked";}else{$add_type=$_POST["add_type"]; }
					if(!isset($_POST["add_comment"])){$add_comment = "";}else{$add_comment=$_POST["add_comment"]; }
					$save = $api->comm("/ip/hotspot/ip-binding/add", array(
						"mac-address" => $add_mac
					));

					if($save){
						$new_list = $api->comm("/ip/hotspot/ip-binding/print", array("?mac-address"=>$add_mac));
						if(!isset($new_list[0][".id"])){}
						else{
							$api->comm("/ip/hotspot/ip-binding/set", array(".id" => $new_list[0][".id"],"to-address" => $add_address));
							$api->comm("/ip/hotspot/ip-binding/set", array(".id" => $new_list[0][".id"],"type" => $add_type));
							$api->comm("/ip/hotspot/ip-binding/set", array(".id" => $new_list[0][".id"],"comment" => $add_comment));
						}
					}
					if($save !==""){ ?>
						<script type="text/javascript">
							window.location.href = "?view=hotspot_ip_bindings";
						</script>
					<?php }
				}

				if(!isset($_GET["action"]) || empty($_GET["action"])){}
				else{
					if(!isset($_GET["id"]) || empty($_GET["id"])){}
					else{
						$remove_id = $_GET["id"];
						$remove = $api->comm("/ip/hotspot/ip-binding/remove", array(".id"=>$remove_id));
						if($_GET["action"]){ ?>
							<script type="text/javascript">
								window.location.href = "?view=hotspot_ip_bindings";
							</script>
						<?php }
					}
				}
			?>
			<input name="add_mac" class="form-control" placeholder="MAC Address" required>
			<input name="add_address" class="form-control mt-4" placeholder="To Address" required>
			<select name="add_type" class="form-control mt-4">
				<option value="blocked">Blocked</option>
				<option value="bypassed">Bypassed</option>
				<option value="regular">Regular</option>
			</select>
			<input name="add_comment" class="form-control mt-4" placeholder="Comment" required>
			<button name="save" class="btn btn-success btn-block mt-4">Save</button>
		</form>
	</div>
	<div class="col-md-6">
		<div class="table-responsive">
			<table class="table table-sm table-hover text-nowrap table-striped">
				<tr class="bg-success">
					<th>#</th>
					<th>MAC Address</th>
					<th>To Address</th>
					<th>Type</th>
					<th>Comment</th>
				</tr>
				<?php
					$num = 0;
					foreach($bind as $key => $row){ 
						$num++;
						if(!isset($row["mac-address"])){$mac_address = "-";}else{$mac_address=$row["mac-address"];}
						if(!isset($row["to-address"])){$to_address = "-";}else{$to_address=$row["to-address"];}
						if(!isset($row["type"]) || $row["type"]=="regular"){$type = "Regular";}else{$type=$row["type"];}
						if(!isset($row["comment"])){$comment = "-";}else{$comment=$row["comment"];}
						?>
						<tr>
							<td><a href="?view=hotspot_ip_bindings&action=remove&id=<?=$row['.id'];?>"><i class="fa fa-times text-danger"></i></a> <?=$num;?></td>
							<td><?=$mac_address;?></td>
							<td><?=$to_address;?></td>
							<td><?=$type;?></td>
							<td><?=$comment;?></td>
						</tr>
					<?php }
				?>	
			</table>
		</div>
	</div>
</div>