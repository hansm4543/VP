<?php
  
  require("usersession.php");
  
  //klassi testimine
  //require ("classes/First_class.php");
  //$myclassobject = new First(10);
  //echo "Avalik arv on: " .$myclassobject->everybodysbusiness;
  //echo "Salajane arv on: " .$myclassobject->mybusiness; Tuleb fatal error kuna ei saa priv näidata
  //$myclassobject->tellMe();
  //unset($myclassobject);
  //echo "Avalik arv on: " .$myclassobject->everybodysbusiness;
  
  //tegelen küpsistega
  //setcookie see funktsioon peab olema enne <html elementi>
  //küpsise nimi, väärtus, aegumiseaeg, failitee(domeeni piires), domeen, https kasutamine
  setcookie("vpvisitorname", $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"], time() + (86400 * 8), "/~hanslii/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
  $lastvisitor = null;
  if(isset($_COOKIE["vpvisitorname"])){
	  $lastvisitor = "<p>Viimati külastas lehte: " .$_COOKIE["vpvisitorname"] .".</p> \n";
  }else{
	  $lastvisitor = "<p>Küpsiseid ei leitud, viimane külastaja pole teada.</p> \n";
  }
  //küpsiste kustutamine
  //kustutamiseks tuleb sama küpsis kirjutada minevikus aegumistähtajaga, näiteks time() - 3600
  
  
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



  //$username = "Hansm4543";
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

<body>
  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus</p>
  <p>See konkreetne leht on loodud veebiprogrameerimise kursusel aastal 2020 sügissemestril <a href="https://www.tlu.ee"> Tallinna Ülikooli  </a> Digitehnoloogiate instituudis</p>
  <p style="background-color:DodgerBlue;"> OLEN LAHE SININE RIBA</p>
  <p>Lehe avamise hetk: <?php echo $weekdaynameset[$weekdaynow -1].", " .$daynow .". " .$monthnameset[$monthnow -1] ." " .$yearnow .", kell " .$clocknow; ?>.</p>
  <p><?php echo "Praegu on " .$partofday ."."; ?></p>
  <p><?php echo $semesterinfo; ?></p>
  
  
  <ul>
	<li><a href="?logout=1">Logi välja</a>!</li>
    <li><a href="page.php">Algleht</a></li>
	<li><a href="listideas.php">Mõtted</a></li>
	<li><a href="addideas.php">Mõttete sisestamine</a></li>
	<li><a href="listfilm.php">Filmid</a></li>
	<li><a href="addfilms.php">Filmide lisamine</a></li>
	<li><a href="userprofile.php">Minu kasutaja profiil</a></li>
	<li><a href="addfilmrelationgenre.php">Filmide zanri ühendamine</a></li>
	<li><a href="addfilmrelations.php">Filmide ühendamine</a></li>
	<li><a href="listfilmpersons.php">Filmide tegelased</a></li>
	<li><a href="listquote.php">Filmide tegelased koos quotega</a></li>
	<li><a href="punktkaks_jan.php">iseseisevtöö jan osa</a></li>
	<li><a href="addgenre.php">Filmide zanrite lisamine</a></li>
	<li><a href="addcompany.php">Filmide companite lisamine</a></li>
	<li><a href="photoupload.php">Galeriipiltide üleslaadimine</a></li>
	<li><a href="photogallery_public.php">Avalike fotode galerii</a></li>
  </ul>
  
  <hr>
	<h3>Viimane külastaja sellest arvutist</h3>
		<?php
			if(count($_COOKIE) > 0){
			echo "<p>Küpsised on lubatud! Leiti: " .count($_COOKIE) ." küpsist.</p> \n";
			}
			echo $lastvisitor;
		?>
  
  <hr>
  <?php echo $imghtml; ?>
  
</body>
</html>