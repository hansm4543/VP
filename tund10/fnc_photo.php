<?php
	$database = "if20_hans_li_1";
	require("../../../config_photo.php");
	
	
	

	function storePhotoData($filename, $alttext, $privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("issi", $_SESSION["userid"], $filename, $alttext, $privacy);
		if($stmt->execute()){
			$notice = 1;
		} else {
			//echo $stmt->error;
			$notice = 0;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	
	function readPublicPhotoThumbs($privacy){
		$photohtml = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER by vpphotos_id DESC");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($filenameformdb, $alttextfromdb);
		$stmt->execute();
		$temphtml = null;
		while($stmt->fetch()){
			//<img src="failinimi.laiend" alt="alternatiivtekst">
			$temphtml .= '<img src="' .$GLOBALS["photouploaddir_thumb"] .$filenameformdb .'" alt="' .$alttextfromdb .'">' ."\n";
		}
		if(!empty($temphtml)){
			$photohtml = "<div> \n" .$temphtml ."\n </div> \n";
		}else{
			$photohtml ="<p>Kahjuks galeriipilte ei leitud!</p> \n";
		}
		
		$stmt->close();
		$conn->close();
		return $photohtml;
	}
	
	function readPublicPhotoThumbsPage($privacy, $limit, $page = 1){
		$photohtml = null;
		$skip = ($page - 1) * $limit;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		//$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER by vpphotos_id DESC LIMIT ?");
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER by vpphotos_id DESC LIMIT ?,?");
		echo $conn->error;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($filenameformdb, $alttextfromdb);
		$stmt->execute();
		$temphtml = null;
		while($stmt->fetch()){
			//<div class="thumbgallery">
			//<img src="failinimi.laiend" alt="alternatiivtekst" class="thumbs">
			//</div>
			$temphtml .= '<div class="thumbgallery">' ."\n";
			$temphtml .= '<img src="' .$GLOBALS["photouploaddir_thumb"] .$filenameformdb .'" alt="' .$alttextfromdb .'" class="thumbs">' ."\n";
			$temphtml .= "</div> \n";
		}
		if(!empty($temphtml)){
			$photohtml = '<div class="galleryarea">' ."\n" .$temphtml ."\n </div> \n";
		}else{
			$photohtml ="<p>Kahjuks galeriipilte ei leitud!</p> \n";
		}
		
		$stmt->close();
		$conn->close();
		return $photohtml;
	}
	
		function countPublicPhotos($privacy){
		$photocount = 0;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		//$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER by vpphotos_id DESC LIMIT ?");
		$stmt = $conn->prepare("SELECT (vpphotos_id) FROM vpphotos WHERE privacy >= ? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($result);
		$stmt->execute();
		while($stmt->fetch()){
			$photocount = $result;
		}
		
		$stmt->close();
		$conn->close();
		return $photocount;
	}
	
	