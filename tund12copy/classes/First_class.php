<?php
	class First{
		//muutujad klassis omadused(properties)
		private $mybusiness;
		public $everybodysbusiness;
		
		function __construct($limit){
			$this->mybusiness = mt_rand(0, $limit);
			$this->everybodysbusiness = mt_rand(0, 100);
			echo "Arvude korrutis on: " .$this->mybusiness * $this->everybodysbusiness;
			$this->tellSecret();
			
		}//construct lõppeb
		
		function _destruct(){
			echo "Nägite hulka mõttetut infot!";
		}
		
		
		//funktsioon klassis meetodid(methods)
		public function tellSecret(){
			echo "Salajane võib ka välja rääkida: ";
		}
		
		public function tellMe(){
			echo "Salajane arv on: " .$this->mybusiness;
		}
		
		
		
	}//class lõppeb

