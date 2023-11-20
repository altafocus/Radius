			<?php
				$get_expire = $api->comm("/ppp/profile/print", array("?name"=>"expire"));
				$api->write("/ip/pool/print");
				$pool = $api->read();
										
				if(count($get_expire)==0){
					$api->comm("/ip/pool/add", array(
						"name" => "ppp_expire",
						"ranges" => "172.2.0.2-172.2.0.254"
					));

					$api->comm("/ppp/profile/add", array(
						"name" => "expire",
						"local-address" => "172.2.0.1",
						"remote-address" => "ppp_expire"
					));

					$check_firewall = $api->comm("/ip/firewall/nat/print", array("?comment"=>"Redirect PPP Expire"));
					if(count($check_firewall) == 0){
						$api->comm("/ip/firewall/nat/add", array(
							"chain" => "dstnat",
							"src-address" => "172.2.0.0/24",
							"protocol" => "tcp",
							"action" => "redirect",
							"to-ports" => "8080",
							"comment" => "Redirect PPP Expire"
						));
						$api->comm("/ip/firewall/nat/add", array(
							"chain" => "dstnat",
							"src-address" => "172.2.0.0/24",
							"protocol" => "udp",
							"action" => "redirect",
							"to-ports" => "8080",
							"comment" => "Redirect PPP Expire"
						));
					}
				}

				if(!isset($_POST['name']) || empty($_POST['name'])){}
				elseif(!isset($_POST['validity']) || empty($_POST['validity'])){}
				else{
					$name = $_POST["name"];
					$validity = $_POST["validity"];
					$address_pool = $_POST["pool"];
					$times = $_POST["times"];
					$upload = $_POST["upload"];
					$download = $_POST["download"];
					$upload_bytes = $_POST["upload_bytes"];
					$download_bytes = $_POST["download_bytes"];

					$expires = $_POST["expires"];

					$interval = 0;
					$rate_limit = "$upload$upload_bytes/$download$download_bytes";

					if($times=="h"){$interval = ($validity * 60) * 60;}
					if($times=="w"){$interval = ($validity * 60) * 60 * 24 * 7;}
					if($times=="m"){$interval = ($validity * 60) * 60 * 24 * 30;}

						$script = file_get_contents("view/ppp_script.txt");

						if($expires == "redirect"){
							$set_validity = str_replace('%validity%', $interval, $script);
							$set_expires = str_replace('%expires%', "set profile=expire", $set_validity);
						}
						if($expires == "disable"){
							$set_validity = str_replace('%validity%', $interval, $script);
							$set_expires = str_replace('%expires%', "disable", $set_validity);
						}

						$save = $api->comm("/ppp/profile/add", array(
							"name" 			=> "$name",
							"local-address" => $address_pool,
							"remote-address" => $address_pool,
							"rate-limit" 	=> $rate_limit,
							"on-up" 		=> $set_expires
						));
						if($save){ ?>
							<script type="text/javascript">
								window.location.href = "?view=ppp_profiles";
							</script>
						<?php }
				}

				if(!isset($_GET["action"])){}
				else{
					$remove_id = $_GET["id"];
					$api->comm("/ppp/profile/remove", array(".id"=>"$remove_id"));
					if($remove_id){ ?>
						<script type="text/javascript">
							window.location.href = "?view=ppp_profiles";
						</script>
					<?php }
				}
			?>
			<div class="row">	
				<div class="col-md-4">
					<form action="?view=ppp_profiles" method="POST">
								<div class="form-group">
									<label>Name</label>
									<input type="text" class="form-control" name="name" placeholder="Profile Name" required>
								</div>

								<div class="form-group">
									<label>Address Pool</label>
									<select class="form-control" name="pool">
										<?php
											foreach($pool as $poolkey => $poolrow){
												if($poolrow["name"]=="ppp_expire"){}
												else{ ?>
													<option value="<?=$poolrow['name'];?>"><?=$poolrow["name"];?></option>
												<?php }
											}
										?>
									</select>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Validity</label>
											<input type="number" class="form-control" name="validity" placeholder="0" required>
										</div>
										<div class="col-md-6">
											<label>.</label>
											<select name="times" class="form-control" required>
												<option value="h">Hours</option>
												<option value="w">Week</option>
												<option value="m">Month</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Upload</label>
											<input type="number" class="form-control" name="upload" placeholder="0" required>
										</div>
										<div class="col-md-6">
											<label>.</label>
											<select name="upload_bytes" class="form-control" required>
												<option value="k">KB/s</option>
												<option value="M">MB/s</option>
												<option value="G">GB/s</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label>Download</label>
											<input type="number" class="form-control" name="download" placeholder="0" required>
										</div>
										<div class="col-md-6">
											<label>.</label>
											<select name="download_bytes" class="form-control" required>
												<option value="k">KB/s</option>
												<option value="M">MB/s</option>
												<option value="G">GB/s</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Expire Mode</label>
									<select class="form-control" name="expires">
										<option value="disable">Disable</option>
										<option value="redirect">Redirect</option>
									</select>
								</div>
								<button type="submit" class="btn btn-success btn-block">Save</button>
					</form>
				</div>
				<div class="col-md-8">
					<div class="table-responsive mt-4">
								<table class="table table-sm table-hover text-nowrap table-striped">
									<tr class="bg-success">
										<th>#</th>
										<th>Name</th>
										<th>Validity</th>
										<th>Rate Limit</th>
										<th></th>
									</tr>
									<?php
										$api->write("/ppp/profile/getall");
										$profile = $api->read();

										$num = 0;
										foreach($profile as $key => $val){
											$num++;
											$id = $val[".id"];
											$name = $val["name"];
											if(!isset($val["rate-limit"]) || empty($val["rate-limit"])){$rate_limit = "-";}
											else{$rate_limit = $val["rate-limit"];}

											if(!isset($val["on-up"])){
												$validity = "-";
											}else{
												$exp1 = explode(";", $val["on-up"]);
												if(count($exp1) == 2){
													$exp2 = explode(" ", $exp1[0]);
													$validity = convert_seconds($exp2[2]);
												}else{
													$validity = "-";
												}
											}

											?>
											<tr>
												<td><?=$num;?></td>
												<td><i class="fa fa-globe text-success"></i> <?=$name;?></td>
												<td><?=$validity;?></td>
												<td><?=$rate_limit;?></td>
												<td>
													<a href="?view=ppp_profiles&action=remove&id=<?=$id;?>">Remove</a>
												</td>
											</tr>
										<?php }
									?>
								</table>
							</div>
				</div>
			</div>