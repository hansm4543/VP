<?php

  //käivitan sessiooni
  session_start();
  //kas on sisselogitud
  if(!isset($_SESSION["userid"])){
	  // jõuga suunatakse sisselogimise lehele
	  header("Location: page.php");
	  exit();
  } 
  
  //logime välja
  if(isset($_GET["logout"])){
	  // lõpetame sessiooni
	  session_destroy();
	  header("Location: page.php");
	  exit();
	  
  }