<?php
	$database = "if20_hans_li_1";
	
	function storenewsdata($title, $content){
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		//statement valmistan ette sql käsu
		$stmt = $conn->prepare("INSERT INTO vpnews (userid, title, content) VALUES(?,?,?,?)");
		//seome käsuga päris andmed
		// i- integer, d - decimal, s - string
		echo $conn->error;
		$stmt->bind_param("iss", $_SESSION["userid"], $title, $content);
		$stmt->execute();
		$stmt->close();
		$conn->close();
	}