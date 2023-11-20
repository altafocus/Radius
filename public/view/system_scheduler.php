<?php
	$api->write("/system/scheduler/print");
	$scheduler = $api->read();
?>

<div class="table-responsive">
	<table class="table table-sm table-hover text-nowrap table-striped">
		<tr class="bg-success">
			<th>#</th>
			<th>Name</th>
			<th>Start Date</th>
			<th>Start Time</th>
			<th>Interval</th>
			<th>Run Count</th>
			<th>Next Run</th>
		</tr>
		<?php
		$num = 0;
		foreach($scheduler as $key => $row){ 
			$num++; 
			if(!isset($row["next-run"])){$next_run="-";}else{$next_run=$row["next-run"];}
			?>
			<tr>
				<td><?=$num;?></td>
				<td><i class="fa fa-clock text-success"></i> <?=$row["name"];?></td>
				<td><?=$row["start-date"];?></td>
				<td><?=$row["start-time"];?></td>
				<td><?=$row["interval"];?></td>
				<td><?=$row["run-count"];?></td>
				<td><?=$next_run;?></td>
			</tr>
		<?php }
		?>
	</table>
</div>