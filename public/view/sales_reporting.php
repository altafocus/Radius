
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
  	$(function(){
  		$("#datepicker_from" ).datepicker({
  			dateFormat: "yy-mm-dd"
  		});

  		$("#datepicker_to" ).datepicker({
  			dateFormat: "yy-mm-dd"
  		});
  	});
  </script>
  	<?php
		$api->write("/system/script/print");
		$script = $api->read();
	?>
<form action="" method="POST" autocomplete="off" class="no-print">
	<div class="row">
		<div class="col-md-3">
			Sales
			<div class="input-group date">
		  		<select name="sales_phone" class="form-control">
		  			<option value="all">All</option>
		  			<option value="default">Default</option>
		  			<?php
		  				foreach($script as $key => $row){
		  					if(!isset($row["source"]) || empty($row["source"])){}
		  					else{
		  						$exp1 = explode("/", $row["source"]);
		  						if(count($exp1) == 2){
		  							$sales_name = $exp1[1];
		  							$sales_phone = $exp1[0];
		  							?>
		  							<option value="<?=$sales_phone;?>"><?=$sales_name;?></option>
		  						<?php }
		  					}
		  				}
		  			?>
		  		</select>
		  		<div class="input-group-append">
		  			<div class="input-group-text"><i class="fa fa-shopping-cart"></i></div>
		  		</div>
		  	</div>
		</div>
		<div class="col-md-3">
			From
			<div class="input-group date">
		  		<input type="text" class="form-control datetimepicker-input" name="from" id="datepicker_from" placeholder="yy-mm-dd">
		  		<div class="input-group-append">
		  			<div class="input-group-text"><i class="fa fa-calendar"></i></div>
		  		</div>
		  	</div>
		</div>
		<div class="col-md-3">
			To
			<div class="input-group date">
			  	<input type="text" class="form-control datetimepicker-input" name="to" id="datepicker_to" placeholder="yy-mm-dd">
			  		<div class="input-group-append">
			  			<div class="input-group-text"><i class="fa fa-calendar"></i></div>
			  		</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="row">
				<div class="col-sm-6">
					<button type="submit" class="btn btn-block btn-success mt-4">Show</button>
				</div>
				<div class="col-sm-6">
					<button type="button" id="btn_print" class="btn btn-block btn-primary mt-4">Print</button>
				</div>
			</div>
		</div>
	</div>
</form>

<?php
	if(!isset($_POST["from"]) || empty($_POST["from"])){}
	elseif(!isset($_POST["to"]) || empty($_POST["to"])){}
	else{ ?>
		<table class="mt-4" width="320">
			<tr><td colspan="2"><h3>Sales Reporting Details</h3></td></tr>
			<tr><td><b>Period</b></td><td>: <?=$_POST["from"];?> -> <?=$_POST["to"];?></td></tr>
		</table>
	<?php }
?>

<div class="table-responsive">
	<table class="table table-sm table-hover text-nowrap table-striped mt-4">
		<tr class="bg-success">
			<th>#</th>
			<th>Code</th>
			<th>Price</th>
			<th>Sales Price</th>
			<th>Date</th>
			<th>Time</th>
			<!--<th>Sales</th>-->
			<th>Total</th>
		</tr>
		<?php
			$total = 0;
			$num = 0;
			if(!isset($_POST["from"]) || empty($_POST["from"])){}
			elseif(!isset($_POST["to"]) || empty($_POST["to"])){}
			else{
				$sales_phone = $_POST["sales_phone"];
				$from_date = $_POST["from"];
				$to_date = $_POST["to"];
				
				$origin = new DateTime($from_date);
				$target = new DateTime($to_date);
				$interval = $origin->diff($target);
				$days = str_replace("+", "", $interval->format('%R%a'));
				
				for($x = 0; $x<$days+1; $x++){
					$date = date('Y-m-d', strtotime($from_date. ' + '.$x.' days'));
					foreach($script as $key => $value){
						$date_exp = explode("-", $date);
						$new_date = $month_array1[$date_exp[1]-1]."/".$date_exp[2]."/".$date_exp[0];
						//echo $new_date."<br>";
						if($value["name"] == $new_date){
							if(!isset($value["source"])){}
							else{
								$exp1 = explode("\r\n", $value["source"]);
								foreach($exp1 as $exp1key => $exp1row){
									$exp2 = explode("/", $exp1row);
									if($sales_phone == "all"){
										$total = ($total + $exp2[1]);
										$num++
										?>
											<tr>
												<td><?=$num;?></td>
												<td><?=$exp2[0];?></td>
												<td><?=number_format($exp2[1]);?></td>
												<td><?=number_format($exp2[2]);?></td>
												<td><?=$exp2[3]."/".$exp2[4]."/".$exp2[5];?></td>
												<td><?=$exp2[6];?></td>
												<!--<td><?=$exp2[5];?></td>-->
												<td><?=number_format($total);?></td>
											</tr>
									<?php }
									else{
										if($exp2[7] == $sales_phone){
											$total = ($total + $exp2[1]);
											$num++;
											?>
												<tr>
													<td><?=$num;?></td>
													<td><?=$exp2[0];?></td>
													<td><?=number_format($exp2[1]);?></td>
													<td><?=number_format($exp2[2]);?></td>
													<td><?=$exp2[3]."/".$exp2[4]."/".$exp2[5];?></td>
													<td><?=$exp2[6];?></td>
													<!--<td><?=$exp2[5];?></td>-->
													<td><?=number_format($total);?></td>
												</tr>
										<?php }
									}
								}
							}
						}
					}
				}
			}
		?>
	</table>
</div>

<script type="text/javascript">
	$("#document").ready(function(){
		$("#btn_print").click(function(){
			$("body").removeClass("dark-mode");
			window.print();
		});
	});
</script>