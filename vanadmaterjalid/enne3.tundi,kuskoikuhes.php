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
  $hournow = date("H");
  $partofday ="lihtsalt aeg";
  
  $weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
 
 // echo weekdaynameset;
 //var_dump($weekdaynameset)
  $weekdaynow = date("N");
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
  
  
  
  //paneme kõik pildid ekraanile
  
  $piccount = count($picfiles);
  // $i = $i + 1;
  // $i ++;
  // $i += 2;
  $imghtml = "";
  
  for($i = 0; $i < $piccount; $i ++){
	$imghtml .= '<img src="../vp_pics/' .$picfiles[$i] .'" ';
	$imghtml .= 'alt="Tallinna Ülikool">';
  }
  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $username; ?></h1>
  <p>See veebileht on loodud õppetöö käigus</p>
  <p>See konkreetne leht on loodud veebiprogrameerimise kursusel aastal 2020 sügissemestril <a href="https://www.tlu.ee"> Tallinna Ülikooli  </a> Digitehnoloogiate instituudis</p>
  <p style="background-color:DodgerBlue;"> KODUS KIRJUTATUD TEXT :P</p>
  <p>Lehe avamise hetk: <?php echo $weekdaynameset[$weekdaynow -1].", " .$fulltimenow; ?>.</p>
  <p><?php echo "Praegu on " .$partofday ."."; ?></p>
  <p><?php echo $semesterinfo; ?></p>
  <hr>
  <?php echo $imghtml; ?>
  <hr>
  <form method="POST">
    <label>Sisesta oma pähe tulnud mõte! </label>
    <input type ="text" name="ideainput" placeholder="Kirjuta siia mõte!">
	<input type="submit" name="ideasubmit" value="Saada mõte ära!">
  
  </form>
  <hr>
  <?php echo $ideahtml; ?>
  
</body>
</html>