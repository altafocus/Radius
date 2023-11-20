<?php
	$api->write("/ip/dhcp-server/lease/print");
	$lease = $api->read();
	//echo json_encode($lease);
?>
<div class="table-responsive">
	<table class="table table-sm table-hover text-nowrap table-striped">
		<tr class="bg-success">
			<th>#</th>
			<th>Address</th>
			<th>MAC Address</th>
			<th>Expires</th>
			<th>Host Name</th>
		</tr>
		<?php
			$num = 0;
			foreach($lease as $key => $row){ 
				$num++;
				if(!isset($row["host-name"]) || empty($row["host-name"])){$host = "-";}else{$host=$row["host-name"];}
				?>
				<tr>
					<td><?=$num;?></td>
					<td><i class="fa fa-sitemap text-success"></i> <?=$row["address"];?></td>
					<td><?=$row["mac-address"];?></td>
					<td><?=$row["expires-after"];?></td>
					<td><?=$host;?></td>
				</tr>
			<?php }
		?>
	</table>
</div>