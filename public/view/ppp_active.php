<?php
	$api->write("/ppp/active/print");
	$active = $api->read();

	$api->write("/interface/print");
	$interface = $api->read();

	$api->write("/system/scheduler/print");
	$scheduler = $api->read();
?>

<div class="table-responsive">
	<table class="table table-sm table-hover text-nowrap table-striped mt-4">
		<thead>
			<tr class="bg-green">
				<th>#</th>
				<th>Name</th>
				<th>Address</th>
				<th>Service</th>
				<th>Caller ID</th>
				
				<th>Uptime</th>
				<th>Upload</th>
				<th>Download</th>
				<th>Expire</th>
			</tr>
			<?php
				$num = 0;
				foreach($active as $activekey => $activerow){ 
						$num++; 
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
								if($str4 == $activerow["name"]){
									$download = ($download + $interfacerow["tx-byte"]);
									$upload = ($upload + $interfacerow["rx-byte"]);
								}
							}
						}
						foreach($scheduler as $schedulerkey => $schedulerrow){
							if($schedulerrow["name"] == $activerow["name"]){
								$expire = $schedulerrow["next-run"];
							}
						}
					?>
					<tr>
						<td><?=$num;?></td>
						<td><i class="fa fa-signal text-green"></i> <?=$activerow["name"];?></td>
						<td><a href="http://<?=$activerow['address'];?>" target="_blank"><?=$activerow["address"];?></a></td>
						<td><?=$activerow["service"];?></td>
						<td><?=$activerow["caller-id"];?></td>
						
						<td><?=$activerow["uptime"];?></td>
						<td><?=convert_filesize($upload);?></td>
						<td><?=convert_filesize($download);?></td>
						<td><?=$expire;?></td>
					</tr>
				<?php }
			?>
		</thead>
	</table>
</div>