<?php
	$api->write("/interface/print");
	$traffic = $api->read();

	$users = $api->comm("/ip/hotspot/user/print", array("count-only"=>""));
	$profiles = $api->comm("/ip/hotspot/user/profile/print", array("count-only"=>""));
	$active = $api->comm("/ip/hotspot/active/print", array("count-only"=>""));
	$dhcp = $api->comm("/ip/dhcp-server/lease/print", array("count-only"=>""));
	$bindings = $api->comm("/ip/hotspot/ip-binding/print", array("count-only"=>""));
	$scheduler = $api->comm("/system/scheduler/print", array("count-only"=>""));
	$resource = $api->comm("/system/resource/print");
	$total_income = $api->comm("/system/script/print", array("?name"=>"total"));

	if(!isset($total_income[0]["source"])){$total = 0; }else{$total = $total_income[0]["source"]; }

	$data = array(
		"traffic" => $traffic,
		"users" => $users,
		"profiles" => $profiles,
		"active" => $active,
		"dhcp" => $dhcp,
		"bindings" => $bindings,
		"scheduler" => $scheduler,
		"resource" => $resource,
		"total" => $total
	);
?>

CPU Load
<div class="progress mb-4 border border-danger">
	<div id="progress_cpu" class="progress-bar bg-danger progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?=$data["resource"][0]["cpu-load"];?>%">
		<span class="sr-only"></span>
	</div>
</div>

<div class="row">
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cog"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Board</span>
				<span class="info-box-number">
					<?=$data["resource"][0]["board-name"];?>
				</span>
			</div>
		</div>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cog"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">CPU Load</span>
				<span class="info-box-number" id="cpu">
					<?=$data["resource"][0]["cpu-load"];?>%
				</span>
			</div>
		</div>
	</div>

	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cog"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Free RAM</span>
				<span class="info-box-number" id="progress_memory">
					<?=convert_filesize($data["resource"][0]["free-memory"]);?>
				</span>
			</div>
		</div>
	</div>

	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cog"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Free HDD</span>
				<span class="info-box-number" id="progress_disk">
					<?=convert_filesize($data["resource"][0]["free-hdd-space"]);?>
				</span>
			</div>
		</div>
	</div>
	
	<div class="col-12 col-sm-6 col-md-3">
		<a href="?view=hotspot_users">
		<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Users</span>
				<span class="info-box-number" id="users">
					<?=number_format($data["users"]);?>
				</span>
			</div>
		</div>
		</a>
	</div>

	<div class="col-12 col-sm-6 col-md-3">
		<a href="?view=hotspot_profiles">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-indigo elevation-1"><i class="fas fa-chart-pie"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Profiles</span>
				<span class="info-box-number" id="profiles"><?=number_format($data["profiles"]);?></span>
			</div>
		</div>
		</a>
	</div>

	<div class="col-12 col-sm-6 col-md-3">
		<a href="?view=hotspot_active">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-success elevation-1"><i class="fa fa-wifi"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Active</span>
				<span class="info-box-number" id="active"><?=number_format($data["active"]);?></span>
			</div>
		</div>
		</a>
	</div>

	<div class="col-12 col-sm-6 col-md-3">
		<a href="?view=system_scheduler">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-primary elevation-1"><i class="fa fa-clock"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Scheduler</span>
				<span class="info-box-number" id="scheduler"><?=number_format($data["scheduler"]);?></span>
			</div>
		</div>
		</a>
	</div>

	<div class="col-12 col-sm-6 col-md-3">
		<a href="?view=dhcp_leases">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-maroon elevation-1"><i class="fa fa-sitemap"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">DHCP Leases</span>
				<span class="info-box-number" id="dhcp"><?=number_format($data["dhcp"]);?></span>
			</div>
		</div>
		</a>
	</div>

	<div class="col-12 col-sm-6 col-md-3">
		<a href="?view=hotspot_ip_bindings">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-teal elevation-1"><i class="fa fa-cogs"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">IP Bindings</span>
				<span class="info-box-number" id="bindings"><?=number_format($data["bindings"]);?></span>
			</div>
		</div>
		</a>
	</div>

	<div class="col-12 col-sm-6 col-md-3">
		<a href="?view=sales_member">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-warning text-white elevation-1"><i class="fas fa-shopping-cart"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Total Income</span>
				<span class="info-box-number" id="total"><?=number_format($data["total"]);?></span>
			</div>
		</div>
		</a>
	</div>

</div>

<div class="table-responsive">
	<table class="table table-sm table-hover text-nowrap table-striped">
		<thead>
			<tr class="bg-success">
				<th>Interface</th>
				<th>Upload</th>
				<th>Download</th>
			</tr>
		</thead>
		<tbody id="interface">
			<?php
				foreach($data["traffic"] as $key => $row){
					if($row["type"] == "ether" || $row["type"] == "wlan"){ 
						$color = "text-muted";
						if($row["running"] == "true"){$color = "text-success"; }
						?>
						<tr>
							<td><i class="fa fa-sitemap <?=$color;?>"></i> <?=$row["name"];?></td>
							<td><?=convert_filesize($row["tx-byte"]);?></td>
							<td><?=convert_filesize($row["rx-byte"]);?></td>
						</tr>
					<?php }
				}
			?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	function formatBytes(bytes,decimals) {
	   if(bytes == 0) return '0 Bytes';
	   var k = 1024,
	       dm = decimals || 2,
	       sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
	       i = Math.floor(Math.log(bytes) / Math.log(k));
	   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
	}
	function numberFormat(x) {
	    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	function update_dashboard(){
		$.ajax({ 
		    type: 'GET', 
		    url: 'view/ajax.php', 
		    dataType: 'json',
		    success: function (data) { 
		    	$("#interface").html("");

		        $("#cpu").html(data.resource[0]['cpu-load'] + '%');
		        var cpu = data.resource[0]['cpu-load']+'%';
		        var disk = formatBytes(data.resource[0]['free-hdd-space']);
		        var memory = formatBytes(data.resource[0]['free-memory']);
		        $("#progress_cpu").css({"width":cpu});
		        $("#progress_disk").html(disk);
		        $("#progress_memory").html(memory);

		        $("#users").html(numberFormat(data.users));
		        $("#profiles").html(numberFormat(data.profiles));
		        $("#active").html(numberFormat(data.active));
		        $("#scheduler").html(numberFormat(data.scheduler));
		        $("#dhcp").html(numberFormat(data.dhcp));
		        $("#bindings").html(numberFormat(data.bindings));
		        $("#total").html(numberFormat(data.total));

		        data.traffic.forEach(function(f){
		        	if(f.type == "ether" || f.type == "wlan"){
		        		var color = "text-muted";
		        		if(f.running == "true"){ color = "text-success"; }
		        		$("#interface").append(
		        			`<tr><td><i class="fa fa-sitemap `+color+`"></i> `+f.name+`</td><
		        			<td>`+formatBytes(f['tx-byte'])+`</td>
		        			<td>`+formatBytes(f['rx-byte'])+`</td></tr>`
		        		);
		        	}
		        });
		    }
		});
	}

	setInterval(function(){
		update_dashboard();
	},3000);
</script>