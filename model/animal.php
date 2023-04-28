<?php
    class Animal{
        //fields
        private $id;
        private $speciesName;
        private $age;
        private $importDate;
        private $imageFileName;

        
        //constructor
        function __construct($id, $speciesName, $age, $importDate, $imageFileName){
            $this->setId($id);
            $this->setSpeciesName($speciesName);
            $this->setAge($age);
            $this->setImportDate($importDate);
            $this->setImageFileName($imageFileName);
        }

        //getters
        public function getId(){
			return $this->id;
		}

        public function getSpeciesName(){
			return $this->speciesName;
		}

        public function getAge(){
			return $this->age;
		}

        public function getImportDate(){
			return $this->importDate;
		}

        public function getImageFileName(){
			return $this->imageFileName;
		}

        //setters
        public function setId($id){
			$this->id = $id;
		}

        public function setSpeciesName($speciesName){
			$this->speciesName = $speciesName;
		}

        public function setAge($age){
			$this->age = $age;
		}

        public function setImportDate($importDate){
			$this->importDate = $importDate;
		}

        public function setImageFileName($imageFileName){
			$this->imageFileName = $imageFileName;
		}

    }
?>