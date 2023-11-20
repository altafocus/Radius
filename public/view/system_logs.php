<select id="select" multiple="" class="form-control" style="min-height: 80vh; overflow: scroll;">
	<?php
		$api->write("/log/print");
		$logs = $api->read();

		foreach($logs as $key => $row){ ?>
			<option><?=$row["time"];?> - <?=$row["topics"];?> - <?=$row["message"];?></option>
		<?php }
	?>
</select>
<script type="text/javascript">
	select.scrollTop = select.scrollHeight;
</script>