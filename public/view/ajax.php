<?php
	session_start();
	include("../lib/routeros.php");
	$api = new RouterosAPI();
	$api->debug = false;

	$conn = $api->connect($_SESSION['login']['address'], $_SESSION['login']['username'], $_SESSION['login']['password']);
	if($conn == 1){
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

		echo json_encode($data);
	}
?>