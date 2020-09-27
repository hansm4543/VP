<?php
  // var_dump($_POST);
  require ("../../../config.php");
  $database = "if20_hans_li_1";
  //kui on idee sisestatud ja nuppu vajutatud, salvestame selle andmebaasi
  
  if(isset($_POST["ideasubmit"]) and !empty($_POST["ideainput"])){
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  //statement valmistan ette sql käsu
  $stmt = $conn->prepare("INSERT INTO myideas(idea) VALUES(?)");
  echo $conn->error;
  //seome käsuga päris andmed
  // i- integer, d - decimal, s - string
  $stmt->bind_param("s", $_POST["ideainput"]);
  $stmt->execute();
  echo $stmt->error;
  $stmt->close();
  $conn->close();
  }

  //loen lehele kõik olemas olevad mõtteid
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  $stmt = $conn->prepare("SELECT idea FROM myideas");
  echo $conn->error;
  //seome tulemuse muutujaga
  $stmt->bind_result($ideafromdb);
  $stmt->execute();
  
  $ideahtml = "";
  while($stmt->fetch()){
	  $ideahtml .= "<p>" .$ideafromdb ."</p>";
  }
  $stmt->close();
  $conn->close();



  $username = "Hansm4543";
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
	
  require("header.php");
?>

  <ul>
    <li><a href="home.php">Avaleht</a></li>
	<li><a href="motted.php">Mõtted</a></li>
	<li><a href="sisestamine.php">Mõttete sisestamine</a></li>
	<li><a href="listfilm.php">Filmid</a></li>
	<li><a href="addfilms.php">Filmide lisamine</a></li>
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
  <p>Vajuta sõnale <a href="sisestamine.php">sisestamine</a>, et sisestada mõtteid.</p>
  <p>Vajuta sõnale <a href="motted.php">mõtted</a>, et lugeda mõtteid.</p>
  <hr>
  <?php echo $imghtml; ?>
  
</body>
</html>