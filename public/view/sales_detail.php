<?php
	if(!isset($_GET["sales_phone"]) || empty($_GET["sales_phone"])){ ?>
		<script type="text/javascript">
			window.location.href = "?view=sales_member";
		</script>
	<?php }else{
		if(!isset($_GET["date"]) || empty($_GET["date"])){
			$date = date("Y-m-d");
		}else{
			$date = $_GET["date"];
		}

		$sales_phone = $_GET["sales_phone"];
		$sales_name = $_GET["sales_name"];
		$api->write("/system/script/print");
		$script = $api->read();

		$reporting_list = array();
		foreach($script as $key => $row){
			$exp1 = explode("/", $row["name"]);
			if(count($exp1) == 3){
				array_push($reporting_list, array("date"=>$row["name"]));
			}
		}
		//echo json_encode($script);
		//2023-11-02
		
	}
?>

<div class="input-group no-print">
	<div class="input-group-prepend">
		<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
	</div>
	<input type="hidden" id="sales_phone" name="sales_phone" value="<?=$sales_phone;?>">
	<input type="hidden" id="sales_name" name="sales_name" value="<?=$sales_name;?>">
	<select id="date" name="date" class="form-control">
		<option><?=$date;?></option>
		<?php
			foreach($reporting_list as $rkey => $rval){ ?>
				<option><?=$rval["date"];?></option>
			<?php }
		?>
	</select>
	<input type="button" class="btn btn-success ml-2" value="Show" onclick="filter()">
	<input type="button" class="btn btn-info ml-2" value="Print" onclick="print_detail()">
</div>

<table class="table table-sm mt-4">
	<tr>
		<td colspan="4" align="center"><b style="font-size: 24px;">Sales Details</b></td>
	</tr>
	<tr>
		<td width="100">Sales ID</td><td>: <?=$sales_phone;?></td>
		<td></td><td align="right">Date : <?=$date;?></td>
		
	</tr>
	<tr>
		<td>Name</td><td>: <?=$sales_name;?></td>
		<td></td>
		<td></td>
	</tr>
</table>

<div class="table-responsive">
	<table class="table table-sm table-hover text-nowrap table-striped">
		<tr class="bg-success">
			<th>#</th>
			<th>Code</th>
			<th>Price</th>
			<th>Sales Price</th>
			<th>Date</th>
			<th>Time</th>
			<th>Total</th>
		</tr>
	<?php
		foreach($script as $scrkey => $scrval){
			if($scrval["name"] == $_GET["date"]){
				$exp1 = explode("\r\n", $scrval["source"]);
				$num = 0;
				$today_total = 0; 
				foreach($exp1 as $string){
					$exp2 = explode("/", $string);
					if($exp2[7] == $sales_phone){ 
						$num++; 
						$today_total = ($today_total + $exp2[1]);
						?>
						<tr>
							<td><?=$num;?></td>
							<td><i class="far fa-user nav-icon text-success no-print"></i> <?=$exp2[0];?></td>
							<td><?=number_format($exp2[1]);?></td>
							<td><?=number_format($exp2[2]);?></td>
							<td><?=$exp2[3]."/".$exp2[4]."/".$exp2[5];?></td>
							<td><?=$exp2[6];?></td>
							<td><?=number_format($today_total);?></td>
						</tr>
					<?php }
				}
			}
		}
	?>
	</table>
</div>

<script type="text/javascript">
	function filter(){
		var n = $("#sales_name").val();
		var p = $("#sales_phone").val();
		var d = $("#date").val();

		window.location.href = "?view=sales_detail&sales_phone="+p+"&sales_name="+n+"&date=" + d;
	}
	function print_detail(){
		$("body").removeClass("dark-mode");
		document.title = "<?=$sales_phone." ~ ".$date;?>";
		window.print();
	}
</script>