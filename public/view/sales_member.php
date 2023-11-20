<?php
	$date = $month_array1[date("m")-1].date("/d/Y");
	$api->write("/system/script/print");
	$script = $api->read();

	$sales = array();
	$report = array();
	$today_report = array();

	array_push($sales, array(
		"id"=>"none",
		"phone"=>"default",
		"name"=>"Default"
	));
	foreach($script as $skey => $sval){
		if(!isset($sval["source"]) || empty($sval["source"])){}
		else{
			$exp1 = explode("/", $sval["source"]);
			if(count($exp1)==2){
				array_push($sales, array(
					"id"=>$sval[".id"],
					"phone"=>$exp1[0],
					"name"=>$exp1[1]
				));
			}
		}
	}
	
	foreach($sales as $sales_key => $sales_val){
		$sales_id = $sales_val["id"];
		$sales_phone = $sales_val["phone"];
		$sales_name = $sales_val["name"];
		$sales_total = 0;
		$sales_paid = 0;
		$sales_billing = 0;

		foreach($script as $script_key => $script_val){
			if(!isset($script_val["source"]) || empty($script_val["source"])){}
			else{
				// get sales report
				$exp1 = explode("/", $script_val["name"]);
				if(count($exp1)==3){
					$exp2 = explode("\r\n", $script_val["source"]);
					foreach($exp2 as $exp2_val){
						$exp3 = explode("/", $exp2_val);
						if($exp3[7] == $sales_phone){
							$sales_total = ($sales_total + $exp3[1]);
						}
					}
				}

				// get has paid
				$exp4 = explode("/", $script_val["source"]);
				if(count($exp4)==7){
					$exp5 = explode("/", $script_val["source"]);
					if($exp5[0]==$sales_phone){
						$sales_paid = ($sales_paid + $exp5[2]);
					}
				}
				
				// today report
				if($script_val["name"] == $date){
					$exp6 = explode("\r\n", $script_val["source"]);
					foreach($exp6 as $exp6_key => $exp6_val){
						$exp7 = explode("/", $exp6_val);
						if($exp7[3]."/".$exp7[4]."/".$exp7[5] == $date && $exp7[7] == $sales_phone){
							array_push($today_report, array(
								$sales_name,
								$exp7[0],
								$exp7[1],
								$exp7[2],
								$exp7[3]."/".$exp7[4]."/".$exp7[5],
								$exp7[6],
								$exp7[7]
							));
						}
					}
				}
			}
		}
		$sales_billing = ($sales_total - $sales_paid);
		array_push($report, array(
			"sales_id"=>$sales_id,
			"sales_phone"=> $sales_phone,
			"sales_name"=> $sales_name,
			"sales_total"=>$sales_total,
			"sales_paid"=>$sales_paid,
			"sales_billing"=>$sales_billing
		));
	}
	//echo json_encode($report);

	if(!isset($_GET["action"]) || empty($_GET["action"])){}
	else{
		if($_GET["action"] == "delete"){
			if(!isset($_GET["id"]) || empty($_GET["id"])){}
			else{
				$delete = $api->comm("/system/script/remove", array(".id"=>$_GET["id"]));
				if($delete != ""){?>
					<script type="text/javascript">
						window.location.href = "?view=sales_member";
					</script>
				<?php }
			}
		}
	}
?>

<div class="table-responsive">
	<table class="table table-sm table-hover text-nowrap table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Total</th>
				<th>Has Paid</th>
				<th>Billing</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total_income = 0;
			$total_paid = 0;
			$total_billing = 0;

			// SORTING SALES TOTAL
			$sales_total = array();
			foreach($report as $arrkey => $arrvalue){
				$sales_total[$arrkey] = $arrvalue["sales_total"];
			}
			array_multisort($sales_total, SORT_DESC, $report);
			// --------------

			foreach($report as $report_key => $report_val){ 
				$total_income = ($total_income + $report_val["sales_total"]);
				$total_paid = ($total_paid + $report_val["sales_paid"]);
				$total_billing = ($total_billing + $report_val["sales_billing"]);
				?>
				<tr>
					<td><a href="?view=sales_member&action=delete&id=<?=$report_val["sales_id"];?>" class="badge badge-danger"><i class="fas fa-times"></i></a> <i class="fas fa-users text-success"></i><?=$report_val["sales_name"];?></td>
					<td><?=number_format($report_val["sales_total"]);?></td>
					<td><?=number_format($report_val["sales_paid"]);?></td>
					<td><?=number_format($report_val["sales_billing"]);?></td>
					<td align="right">
						<a href="?view=sales_detail&date=<?=$date;?>&sales_phone=<?=$report_val["sales_phone"];?>&sales_name=<?=$report_val["sales_name"];?>" class="badge badge-success"><i class="fas fa-file"></i> Details</a>
						<a href="?view=sales_payment&sales_phone=<?=$report_val["sales_phone"];?>&sales_name=<?=$report_val["sales_name"];?>&sales_billing=<?=$report_val["sales_billing"];?>" class="badge badge-primary"><i class="fas fa-arrow-right"></i> Payments</a>
					</td>
				</tr>
			<?php }
			$total_id = $api->comm("/system/script/print", array("?name"=>"total"));
			if(!isset($total_id[0][".id"])){}
			else{
				$api->comm("/system/script/set", array(".id"=>$total_id[0][".id"], "source"=>$total_income));
			}
			?>
		</tbody>
	</table>
</div>

<div class="row mt-4">
	<div class="col-md-3 col-sm-6 col-12">
		<div class="info-box">
			<span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Members</span>
				<span class="info-box-number"><?=count($report);?></span>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-12">
		<div class="info-box">
			<span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Total Income</span>
				<span class="info-box-number"><?=number_format($total_income);?></span>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-12">
		<div class="info-box">
			<span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Has Paid</span>
				<span class="info-box-number"><?=number_format($total_paid);?></span>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-12">
		<div class="info-box">
			<span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Total Billing</span>
				<span class="info-box-number"><?=number_format($total_billing);?></span>
			</div>
		</div>
	</div>
</div>



<h3 class="mt-4">Today Sales</h3>

<div class="table-responsive">
	<table class="table table-sm table-hover text-nowrap table-striped">
		<tr class="bg-success">
			<th>#</th>
			<th>Sales Name</th>
			<th>Code</th>
			<th>Price</th>
			<th>Sales Price</th>
			<th>Date</th>
			<th>Time</th>
			<th>Total</th>
		</tr>
		<?php
			$num = 0;
			$today_total = 0;
			foreach($today_report as $report){ 
				$num++; 
				$today_total = ($today_total + $report[2]);
				?>
				<tr>
					<td><?=$num;?></td>
					<td><i class="fas fa-print text-success"></i> <?=$report[0];?></td>
					<td><?=$report[1];?></td>
					<td><?=number_format($report[2]);?></td>
					<td><?=number_format($report[3]);?></td>
					<td><?=$report[4];?></td>
					<td><?=$report[5];?></td>
					<td><?=number_format($today_total);?></td>
				</tr>
			<?php }
		?>
	</table>
</div>
