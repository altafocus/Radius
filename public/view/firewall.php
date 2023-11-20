<?php
	$block_connection_sharing = $api->comm("/ip/firewall/mangle/print", array("?comment"=>"Block Connection Sharing"));
	if(count($block_connection_sharing)>0){
		$bcs_id = $block_connection_sharing[0][".id"];
		$out_interface = $block_connection_sharing[0]["out-interface"];
		$new_ttl = $block_connection_sharing[0]["new-ttl"];
	}

	if(!isset($_POST["set_bcs"]) || empty($_POST["set_bcs"])){}
	else{
		if($_POST["set_bcs"] == "enable"){
			$enable = $api->comm("/ip/firewall/mangle/add", array(
				"chain" => "postrouting",
				"out-interface" => $_POST["out_interface"],
				"action" => "change-ttl",
				"new-ttl" => "set:".$_POST["ttl"],
				"passthrough" => "no",
				"comment" => "Block Connection Sharing"
			));

			if($enable){ ?>
				<script type="text/javascript">
					window.location.href="?view=firewall";
				</script>
			<?php }
		}
		if($_POST["set_bcs"] == "disable"){
			if(!isset($_POST["bcs_id"]) || empty($_POST["bcs_id"])){}
			else{
				$disable = $api->comm("/ip/firewall/mangle/remove", array(".id"=>$_POST["bcs_id"]));
				if($_POST["bcs_id"]){ ?>
					<script type="text/javascript">
						window.location.href="?view=firewall";
					</script>
				<?php }
			}
		}
	}
?>

<div class="row">
	<div class="col-md-6">
		<div class="card card-outline card-success">
			<div class="card-header">Block Connection Sharing</div>
			<div class="card-body">
				<form action="?view=firewall" method="POST">
					Out Interface
					<select class="form-control mb-2" name="out_interface">
						<?php
							if(!isset($bcs_id) || empty($bcs_id)){
								$api->write("/interface/print");
								$interface = $api->read();

								foreach($interface as $key => $row){ ?>
									<option value="<?=$row['name'];?>"><?=$row["name"];?></option>
								<?php }
							}else{ ?>
								<option><?=$out_interface;?></option>
							<?php }
						?>
					</select>

					<?php
						if(!isset($bcs_id) || empty($bcs_id)){ ?>
							Change TTL
							<input type="number" name="ttl" class="form-control mb-2" placeholder="New TTL">
							<button type="submit" name="set_bcs" value="enable" class="btn btn-success btn-block mt-2">Enable</button>
						<?php }else{ ?>
							<input type="hidden" name="bcs_id" value="<?=$bcs_id;?>">
							<button type="submit" name="set_bcs" value="disable" class="btn btn-danger btn-block mt-2">Disable</button>
						<?php }
					?>
					
				</form>
			</div>
		</div>
	</div>
</div>