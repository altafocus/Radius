<form action="" method="POST">
	Check Status
	<div class="input-group mb-4">
		<input class="form-control" name="username" placeholder="Username" autocomplete="off">
		<button class="btn btn-success">Check</button>
	</div>

	<?php
		error_reporting(0);
		if(!isset($_POST["username"]) || empty($_POST["username"])){}
		else{
			$username = $_POST["username"];

			$user = $api->comm("/ip/hotspot/user/print", array("?name"=>$username));
			$active = $api->comm("/ip/hotspot/active/print", array("?user"=>$username));
			$scheduler = $api->comm("/system/scheduler/print", array("?name"=>$username));
			$api->write("/system/script/print");
			$script = $api->read();
			if(count($user)==1){
				if(count($scheduler)==1 && count($active)==1){ 
						$name = $user[0]["name"];
						$profile = $user[0]["profile"];
						$start_date = $scheduler[0]["start-date"];
						$start_time = $scheduler[0]["start-time"];
						$interval = $scheduler[0]["interval"];
						$download = ($user[0]["bytes-out"] + $active[0]["bytes-out"]);
						$upload = ($user[0]["bytes-in"] + $active[0]["bytes-in"]);
						$expire = $scheduler[0]["next-run"];
					?>
					<h3 class="text-success">User Data</h3>
					<table class="table table-sm">
						<tr><td>Name</td><td>: <?=$name;?></td></tr>
						<tr><td>Profile</td><td>: <?=$profile;?></td></tr>
						<tr><td>Start Date</td><td>: <?=$start_date;?></td></tr>
						<tr><td>Start Time</td><td>: <?=$start_time;?></td></tr>
						<tr><td>Interval</td><td>: <?=$interval;?></td></tr>
						<tr><td>Download</td><td>: <?=convert_filesize($download);?></td></tr>
						<tr><td>Upload</td><td>: <?=convert_filesize($upload);?></td></tr>
						<tr><td>Expire</td><td>: <?=$expire;?></td></tr>
						<tr><td>Status</td><td><b class="text-success">: Online</b></td></tr>
					</table>
				<?php }
				elseif(count($scheduler)==1 && count($active)==0){ 
						$name = $user[0]["name"];
						$profile = $user[0]["profile"];
						$start_date = $scheduler[0]["start-date"];
						$start_time = $scheduler[0]["start-time"];
						$interval = $scheduler[0]["interval"];
						$download = ($user[0]["bytes-out"]);
						$upload = ($user[0]["bytes-in"]);
						$expire = $scheduler[0]["next-run"];
					?>
					<h3 class="text-success">User Data</h3>
					<table class="table table-sm">
						<tr><td>Name</td><td>: <?=$name;?></td></tr>
						<tr><td>Profile</td><td>: <?=$profile;?></td></tr>
						<tr><td>Start Date</td><td>: <?=$start_date;?></td></tr>
						<tr><td>Start Time</td><td>: <?=$start_time;?></td></tr>
						<tr><td>Interval</td><td>: <?=$interval;?></td></tr>
						<tr><td>Download</td><td>: <?=convert_filesize($download);?></td></tr>
						<tr><td>Upload</td><td>: <?=convert_filesize($upload);?></td></tr>
						<tr><td>Expire</td><td>: <?=$expire;?></td></tr>
						<tr><td>Status</td><td><b class="text-danger">: Offline</b></td></tr>
					</table>
				<?php }
				elseif(count($scheduler)==0 && count($active)==0 && $user[0]["bytes-out"]==0){ 
					$name = $user[0]["name"];
					$profile = $user[0]["profile"];
					$download = ($user[0]["bytes-out"]);
					$upload = ($user[0]["bytes-in"]);
					?>
					<h3 class="text-success">User Data</h3>
					<table class="table table-sm">
						<tr><td>Name</td><td>: <?=$name;?></td></tr>
						<tr><td>Profile</td><td>: <?=$profile;?></td></tr>
						<tr><td>Download</td><td>: <?=convert_filesize($download);?></td></tr>
						<tr><td>Upload</td><td>: <?=convert_filesize($upload);?></td></tr>
						<tr><td>Status</td><td><b class="text-green">: Unused</b></td></tr>
					</table>
				<?php }
				else{ 
					$name = $user[0]["name"];
					$profile = $user[0]["profile"];
					$download = ($user[0]["bytes-out"] + $active[0]["bytes-out"]);
					$upload = ($user[0]["bytes-in"] + $active[0]["bytes-in"]);
					?>
					<h3 class="text-success">User Data</h3>
					<table class="table table-sm">
						<tr><td>Name</td><td>: <?=$name;?></td></tr>
						<tr><td>Profile</td><td>: <?=$profile;?></td></tr>
						<tr><td>Download</td><td>: <?=convert_filesize($download);?></td></tr>
						<tr><td>Upload</td><td>: <?=convert_filesize($upload);?></td></tr>
						<tr><td>Status</td><td><b class="text-warning">: Without usage restrictions.</b></td></tr>
					</table>
				<?php }
			}else{
				$found = 0;
				$data = "";
				foreach($script as $key => $row){
					$exp1 = explode("/", $row["name"]);
					if(count($exp1)==3){
						$exp2 = explode("\r\n", $row["source"]);
						foreach($exp2 as $exp2_key => $exp2_row){
							$exp3 = explode("/", $exp2_row);
							if($exp3[0] == $username){
								$found = 1;
								$data = $exp3;
							}
						}
					}
				}

				if($found == 0){ ?>
					<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h5><i class="icon fas fa-ban"></i> Alert!</h5>
					Username <b><?=htmlspecialchars($username);?></b> Not Found!
					</div>
				<?php }else{ ?>
					<h3 class="text-success">User Data</h3>
					<table class="table table-sm">
						<tr><td>Sales</td><td>: <?=$data[7];?></td></tr>
						<tr><td>Name</td><td>: <?=$data[0];?></td></tr>
						<tr><td>Price</td><td>: <?=number_format($data[1]);?></td></tr>
						<tr><td>Sales Price</td><td>: <?=number_format($data[2]);?></td></tr>
						<tr><td>Used Time</td><td>: <?=$data[3]."/".$data[4]."/".$data[5]." - ".$data[6];?></td></tr>
						<tr><td>Status</td><td><b class="text-danger">: Expired</b></td></tr>
					</table>
				<?php }
			}
		}
	?>
</form>