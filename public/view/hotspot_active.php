<div class="table-responsive">
	<?php
		if(!isset($_POST["id"]) || empty($_POST["id"])){}
		else{
			$id= $_POST["id"];
			$user = $_POST["user"];

			for($xid = 0; $xid<count($id); $xid++){
				$api->comm("/ip/hotspot/active/remove", array(".id"=> $id[$xid]));
			}
			for($xuser = 0; $xuser<count($user); $xuser++){
				$api->comm("/ip/hotspot/cookie/remove", array("?user"=>$user[$xuser]));
			}
		}

		if(!isset($_GET["action"]) || empty($_GET["action"])){}
		else{
			$id = $_GET["id"];
			$api->comm("/ip/hotspot/active/remove", array(".id"=>$id));

		}
	?>
	<form action="" method="post">
	<table class="table table-sm table-hover text-nowrap table-striped">
		<tr class="bg-success">
			<th><input type="checkbox" id="select"></th>
			<th>#</th>
			<th>User</th>
			<th>Uptime</th>
			<th>Download</th>
			<th>Upload</th>
			<th>Address</th>
			<th>MAC Address</th>
			<th>Device</th>
			<th>Expire</th>
			<th style="text-align: center;"><button class="btn btn-sm btn-danger align-right">Disconnect</button></th>
		</tr>
		<?php
			
			$api->write("/ip/hotspot/active/print");
			$active = $api->read();

			$api->write("/ip/hotspot/user/print");
			$user = $api->read();

			$api->write("/ip/dhcp-server/lease/print");
			$dhcp = $api->read();

			$api->write("/system/scheduler/print");
			$scheduler = $api->read();

			$data = array();
			foreach($active as $actkey => $actval){
				$device = "-";
				$expire = "-";
				$color = "text-warning";
				foreach($user as $userkey => $userval){
					if($actval["user"] == $userval["name"]){
						$useage_down = ($actval["bytes-out"] + $userval["bytes-out"]);
						$useage_up = ($actval["bytes-in"] + $userval["bytes-in"]);
					}
				}
				
				foreach($dhcp as $dhcpkey => $dhcprow){
					if($actval["mac-address"] == $dhcprow["mac-address"]){
						if(!isset($dhcprow["host-name"])){
							$device = "-";
						}else{
							$device = $dhcprow["host-name"];
						}
					}
				}

				foreach($scheduler as $schedulerkey => $schedulerrow){
					if($actval["user"] == $schedulerrow["name"]){
						if(!isset($schedulerrow["next-run"])){
							$expire = "-";
							$color = "text-warning";
						}else{
							$expire = $schedulerrow["next-run"];
							$color = "text-green";
						}
					}
				}

				array_push($data, array(
					"id" => $actval[".id"],
					"user" => $actval["user"],
					"uptime" => $actval["uptime"],
					"download" => $useage_down,
					"upload" => $useage_up,
					"address" => $actval["address"],
					"mac" => $actval["mac-address"],
					"device" => $device,
					"expire" => $expire,
					"color" => $color
				));
			}
			$download = array();
			foreach($data as $key => $value){ 
				$download[$key] = $value["download"];
			}
			array_multisort($download, SORT_DESC, $data);

			$num = 0;
			foreach($data as $key => $row){ $num++; ?>
				<tr>
					<td>
						<input type="checkbox" name="id[]" value="<?=$row["id"];?>" class="users">
						<input type="hidden" name="user[]" value="<?=$row["user"];?>">
					</td>
					<td><?=$num;?></td>
					<td><i class="fa fa-wifi <?=$row['color'];?>"></i> <?=$row["user"];?></td>
					<td><?=$row["uptime"];?></td>
					<td><?=convert_filesize($row["download"]);?></td>
					<td><?=convert_filesize($row["upload"]);?></td>
					<td><?=$row["address"];?></td>
					<td><?=$row["mac"];?></td>
					<td><?=$row["device"];?>
					<td><?=$row["expire"];?>
					<td align="center"><a href="?view=hotspot_active&action=disconnect&id=<?=$row['id'];?>" class="text-danger"><i class="fa fa-times"></i></a></td>
				</tr>
			<?php }
		?>
	</table>
	</form>
	<script type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#select").click(function(){
				var users = document.getElementsByClassName("users");
				if(this.checked == true){
					for(x = 0; x < users.length; x++){
						users[x].checked = true;
					}
				}else{
					for(x = 0; x < users.length; x++){
						users[x].checked = false;
					}
				}
			});
		});
	</script>
</div>