<div class="input-group">
	<a href="?view=ppp_add_secret" class="btn bg-green">Add Secret</a>
</div>
<div class="table-responsive">
	<table class="table table-sm table-hover text-nowrap table-striped mt-4">
		<thead>
			<tr class="bg-green">
				<th>#</th>
				<th>Name</th>
				<th>Password</th>
				<th>Profile</th>
				<th>Logged Out</th>
				<th>Caller ID</th>
				<th>Disconnect Reason</th>
				<th>Download</th>
				<th>Upload</th>
				<th>Expire</th>
				<th></th>
			</tr>
		</thead>
		<?php
			$api->write("/interface/print");
			$interface = $api->read();

			$api->write("/ppp/secret/print");
			$secret = $api->read();

			$api->write("/ppp/active/print");
			$active = $api->read();

			$api->write("/system/scheduler/print");
			$scheduler = $api->read();

			if(!isset($_GET["action"])){}
			else{
				if(!isset($_GET["remove_id"]) || empty($_GET["remove_id"])){}
				else{
					$remove_id = $_GET["remove_id"];
					$api->comm("/ppp/secret/remove", array(".id"=>"$remove_id"));
					if($remove_id){ ?>
						<script type="text/javascript">
							window.location.href = "?view=ppp_secret";
						</script>
					<?php }
				}
			}

			$num = 0;
			foreach($secret as $secretkey => $secretrow){
					$num++; 
					$expire = "-";
					if(!isset($secretrow["last-caller-id"])){ $last_caller_id = "-"; }else{ $last_caller_id = $secretrow["last-caller-id"];}
					if(!isset($secretrow["last-disconnect-reason"])){ $last_disconnect_reason = "-";} else {$last_disconnect_reason = $secretrow["last-disconnect-reason"];}
					foreach($active as $activekey => $activerow){
						if($secretrow["name"] == $activerow["name"]){
							$status = "Online";
							$color = "text-green";
						}else{
							$status = "Offline";
							$color = "text-white";
						}
					}
					$download = 0;
					$upload = 0;
					$expire = "";
					foreach($interface as $interfacekey => $interfacerow){
						if(!isset($interfacerow["name"])){}
						else{
							$str1 = $interfacerow["name"];
							$str2 = str_replace("<", "", $str1);
							$str3 = str_replace(">", "", $str2);
							$str4 = str_replace("pppoe-", "", $str3);
							if($str4 == $secretrow["name"]){
								$download = ($download + $interfacerow["tx-byte"]);
								$upload = ($upload + $interfacerow["rx-byte"]);
							}
						}
					}
					foreach($scheduler as $schedulerkey => $schedulerrow){
						if($schedulerrow["name"] == $secretrow["name"]){
							$expire = $schedulerrow["next-run"];
						}
					}
				?>
				<tr class="<?=$color;?>">
					<td><?=$num;?></td>
					<td><i class="fa fa-user <?=$color;?>"></i> <?=$secretrow["name"];?></td>
					<td><?=$secretrow["password"];?></td>
					<td><?=$secretrow["profile"];?></td>
					<td><?=$secretrow["last-logged-out"];?></td>
					<td><?=$last_caller_id;?></td>
					<td><?=$last_disconnect_reason;?></td>
					<td><?=convert_filesize($download);?></td>
					<td><?=convert_filesize($upload);?></td>
					<td><?=$expire;?></td>
					<td>
						<a href="?view=ppp_secret&action=remove&remove_id=<?=$secretrow['.id'];?>">Remove</a>
					</td>
				</tr>
			<?php }
		?>
	</table>
</div>