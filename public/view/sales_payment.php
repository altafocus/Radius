<?php
	$api->write("/system/script/print");
	$script = $api->read();

	$data = array();
	foreach($script as $script_key => $script_val){
		if(!isset($script_val["source"]) || empty($script_val["source"])){}
		else{
			$exp1 = explode("/", $script_val["source"]);
			if(count($exp1)==7){
				array_push($data, array(
					"sales_phone" => $exp1[0],
					"sales_name" => $exp1[1],
					"amount" => $exp1[2],
					"years" => $exp1[3],
					"month" => $exp1[4],
					"day" => $exp1[5],
					"time" => $exp1[6]
				));
			}
		}
	}

	function redirect(){?>
		<script type="text/javascript">
			window.location.href = "?view=sales_member";
		</script>
	<?php }

	if(!isset($_GET["sales_phone"]) || empty($_GET["sales_phone"])){ redirect(); }
	elseif(!isset($_GET["sales_name"]) || empty($_GET["sales_name"])){ redirect(); }
	elseif(!isset($_GET["sales_billing"]) || empty($_GET["sales_billing"])){ redirect(); }
	else{ ?>
		<div class="row">
		<div class="col-md-4">
			<div class="card card-success card-outline">
				<div class="card-body">
					<form action="" method="POST">
						<?php 
							if(!isset($_POST["sales_name"]) || empty($_POST["sales_name"])){}
							elseif(!isset($_POST["sales_phone"]) || empty($_POST["sales_phone"])){}
							elseif(!isset($_POST["sales_billing"]) || empty($_POST["sales_billing"])){}
							else{
								$years = date("Y");
								$month = date("m");
								$days = date("d");
								$time = date("h:i:s A");
								$code = generateRandomString(5);
								$save = $api->comm("/system/script/add", array(
									"name"=>"PM".$_POST["sales_phone"].$code,
									"source"=>$_POST["sales_phone"]."/".$_POST["sales_name"]."/".$_POST["sales_billing"]."/".$years."/".$month."/".$days."/".$time
								));
								if($save != ""){ ?>
									<script type="text/javascript">
										window.location.href = "?view=sales_member";
									</script>
								<?php }
							}
						?>
						<div class="form-group">
							<label>Sales Name</label>
							<input class="form-control" name="sales_name" value="<?=$_GET["sales_name"];?>" readonly> 
						</div>
						<div class="form-group">
							<label>Sales Phone</label>
							<input class="form-control" name="sales_phone" value="<?=$_GET["sales_phone"];?>" readonly> 
						</div>
						<div class="form-group">
							<label>Total Billing</label>
							<input type="number" class="form-control" name="sales_billing" value="<?=$_GET["sales_billing"];?>"> 
						</div>

						<button class="btn btn-block btn-success">Save</button>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-success card-outline">
				<div class="card-body">
					<table class="table table-sm table-hover text-nowrap table-striped">
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Time</th>
							<th>Name</th>
							<th>Amount</th>
						</tr>
						<?php
							$num = 0;
							foreach($data as $data_key => $data_value){
								if($data_value["sales_phone"] == $_GET["sales_phone"]){ $num++; ?>
									<tr>
										<td>[<?=$num;?>]</td>
										<td><?=$data_value["years"];?>/<?=$data_value["month"];?>/<?=$data_value["day"];?></td>
										<td><?=$data_value["time"];?></td>
										<td><?=$data_value["sales_name"];?></td>
										<td><span class="badge badge-warning"><?=number_format($data_value["amount"]);?></span></td>
									</tr>
								<?php }
							}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php }
?>