<?php

  //käivitan sessiooni
  //session_start();
  require("classes/SessionManager.class.php");
  SessionManager::sessionStart("vp", 0 , "/~hanslii/", "greeny.cs.tlu.ee");
  
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