<?php
  // var_dump($_POST);
  require ("../../../config.php");
  $database = "if20_hans_li_1";
  require("fnc_common.php");
  require("fnc_user.php");
  //kui on idee sisestatud ja nuppu vajutatud, salvestame selle andmebaasi

  //errorid
  $emailerror = "";
  $passworderror = "";
/*  
  	$firstname= "";
	    $lastname = "";
		$gender = "";
		$birthdate = null;
		$birthday = null;
		$birthmonth = null;
		$birthyear = null;
		$email = "";
  */
  
  //Sisestuste jäädvustamine errori korral
  $email="";
  $notice = "";

  $username = "";
  $fulltimenow = date("d.m.Y H:i:s");
  $daynow = date("d");
  $yearnow = date("Y");
  $clocknow = date("H:i:s");
  $hournow = date("H");
  $partofday ="lihtsalt aeg";
  
  $weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
 
 // echo weekdaynameset;
 //var_dump($weekdaynameset)
  $weekdaynow = date("N");
  $monthnow = date ("m");
 // echo $weekdaynow; prindib 0,1,2 jne tuleb lahutada üks
  
  
  if($hournow < 6){
	  $partofday = "uneaeg";
  } //enne 6
  if($hournow >= 8 and $hournow <= 18){
	  $partofday = "õppimise aeg";
  }//peale 8-18, kasutatud suuremvõrdne märki
  if($hournow > 18 and $hournow <= 20){
	  $partofday = "trenniaeg";
  }
  if($hournow > 6 and $hournow <= 7){
	  $partofday = "ärkamiseaeg";
  }
  if($hournow > 20 and $hournow <= 22){
	  $partofday = "teleka vaatamise aeg";
  }
  
  
   //jälgime semestri kulgu
  $semesterstart = new DateTime("2020-8-31");
  $semesterend = new DateTime("2020-12-13");
  $semesterduration = $semesterstart->diff($semesterend);
  $semesterdurationdays = $semesterduration->format("%r%a");
  $today = new DateTime("now");
  $fromsemesterstart = $semesterstart->diff($today);
  //saime aja erinevuse objektina, seda niisama näidata ei saa
  $fromsemesterstartdays = $fromsemesterstart->format("%r%a");
  $semesterpercentage = 0;
  
  
  
  $semesterinfo = "Semester kulgeb vastavalt akadeemilisele kalendrile.";
  if($semesterstart > $today){
	  $semesterinfo = "Semester pole veel peale hakanud!";
  }
  if($fromsemesterstartdays === 0){
	  $semesterinfo = "Semester algab täna!";
  }
  if($fromsemesterstartdays > 0 and $fromsemesterstartdays < $semesterdurationdays){
	  $semesterpercentage = ($fromsemesterstartdays / $semesterdurationdays) * 100;
	  $semesterinfo = "Semester on täies hoos, kestab juba " .$fromsemesterstartdays ." päeva, läbitud on " .$semesterpercentage ."%.";
  }
  if($fromsemesterstartdays == $semesterdurationdays){
	  $semesterinfo = "Semester lõppeb täna!";
  }
  if($fromsemesterstartdays > $semesterdurationdays){
	  $semesterinfo = "Semester on läbi saanud!";
  }
 
 //annan ennete lubatud pildivormingute loendi
  $picfiletypes = ["image/jpeg", "image/png"];
 
// loeme piltide kataloogi sisu ja näitame pilte

  $allfiles = array_slice(scandir("../vp_pics/"), 2);
  // $allfiles = scandir("../vp_pics/");
  // var_dump($allfiles);
  $picfiles = [];
  // $picfiles = array_slice($allfiles, 2);
  // var_dump($picfiles);
  
  foreach($allfiles as $thing) {
	  $fileinfo = getImagesize("../vp_pics/" .$thing);
	  // var_dump($fileinfo);
	  if(in_array($fileinfo["mime"],$picfiletypes) == true){
		  array_push($picfiles, $thing);
	  }
  }
  
  //rand(0, 3)
  
  
  //paneme kõik pildid ekraanile
  
  $piccount = count($picfiles);
  $picnum = mt_rand(0, ($piccount - 1));
  // $i = $i + 1;
  // $i ++;
  // $i += 2;
  $imghtml = "";
  
   // for($i = 0; $i < $piccount; $i ++){
	// $imghtml .= '<img src="../vp_pics/' .$picfiles[$i] .'" ';
	// $imghtml .= 'alt="Tallinna Ülikool">';
  // }
  
  $imghtml .= '<img src="../vp_pics/' .$picfiles[$picnum] .'" ';
  $imghtml .= 'alt="Tallinna Ülikool">';
  
  
    if(isset($_POST["loginsubmit"])){
	  
	  if (empty($_POST["passwordinput"])){
		$passworderror .= "Parool on sisestamata!"; 
	  } else {
		  if (strlen($_POST["passwordinput"]) < 8){
			  $passworderror .= "Parool on liiga lühike!";
	     }
	  }
	  
	  if (!empty($_POST["emailinput"])){
		  $email .= test_input($_POST["emailinput"]);
	  } else {
		  $emailerror .= "Email on sisestamata!"; 
	  }
	  
	  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		  $email = test_input ($_POST["emailinput"]);
		  $emailerror = " Vale emaili formaat! ";
	  }
	  
		  
	  if(empty($emailerror) and empty ($passworderror)){
		$result = signin($email, $_POST["passwordinput"]);
		if($result == "ok"){
			$notice = "Kõik korras, olete sisselogitud!";
			$email = "";
		} else {
			$notice = "Tekkis tehniline tõrge: " .$result;
		}
  
      }
	  
   }
	
/* $password $_POST["passwordinput"]
*/	


  require("header.php");
?>

  <ul>
	<li><a href="account.php">Kasutajate lisamine</a></li>
  </ul>


  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $username; ?></h1>
  <p>See veebileht on loodud õppetöö käigus</p>
  <p>See konkreetne leht on loodud veebiprogrameerimise kursusel aastal 2020 sügissemestril <a href="https://www.tlu.ee"> Tallinna Ülikooli  </a> Digitehnoloogiate instituudis</p>
  <p style="background-color:DodgerBlue;"> OLEN LAHE SININE RIBA</p>
  <p>Lehe avamise hetk: <?php echo $weekdaynameset[$weekdaynow -1].", " .$daynow .". " .$monthnameset[$monthnow -1] ." " .$yearnow .", kell " .$clocknow; ?>.</p>
  <p><?php echo "Praegu on " .$partofday ."."; ?></p>
  <p><?php echo $semesterinfo; ?></p>
  <hr>
  
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	 
	
	<label for="emailinput">Email:</label> 
	<input type="email" name="emailinput" id="emailinput" placeholder="Email" value="<?php echo $email; ?>">
	<span><?php echo $emailerror; ?></span>
	<br>
	<label for="passwordinput">Parool:</label> 
	<input type="password" name="passwordinput" id="passwordinput" placeholder="Parool">
	<span><?php echo $passworderror; ?></span>
	<br>
	<input type="submit" name="loginsubmit" value="Logi Sisse"><span><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></span>
	</form>
 
 

  
  <hr>
  <?php echo $imghtml; ?>
  
</body>
</html>