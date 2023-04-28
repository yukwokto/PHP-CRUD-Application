<?php
require_once('abstractDAO.php');
require_once('./model/animal.php');

class animalDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getAnimal($animalId){
        $query = 'SELECT * FROM animals WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $animalId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $animal = new Animal($temp['id'],$temp['speciesName'], $temp['age'], $temp['importDate'], $temp['imageFileName']);
            $result->free();
            return $animal;
        }
        $result->free();
        return false;
    }


    public function getAnimals(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM animals');
        $animals = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new animal object, and add it to the array.
                $animal = new Animal($row['id'], $row['speciesName'], $row['age'], $row['importDate'], $row['imageFileName']);
                $animals[] = $animal;
            }
            $result->free();
            return $animals;
        }
        $result->free();
        return false;
    }   
    


    public function addAnimal($animal){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
			$query = 'INSERT INTO animals (speciesName, age, importDate, imageFileName) VALUES (?,?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $speciesName = $animal->getSpeciesName();
			        $age = $animal->getAge();
			        $importDate = $animal->getImportDate();
			        $imageFileName = $animal->getImageFileName();
                  
			        $stmt->bind_param('siss', // string, int, string, string
                        $speciesName,
				        $age,
				        $importDate,
                        $imageFileName
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $animal->getSpeciesName(). ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   


    public function updateAnimal($animal){
        
        if(!$this->mysqli->connect_errno){

            $query = "UPDATE animals SET speciesName=?, age=?, importDate=?, imageFileName=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $animal->getId();
                    $speciesName = $animal->getSpeciesName();
			        $age = $animal->getAge();
			        $importDate = $animal->getImportDate();
			        $imageFileName = $animal->getImageFileName();
                  
			        $stmt->bind_param('sissi', 
                        $speciesName,
				        $age,
				        $importDate,
                        $imageFileName,
                        $id
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $animal->getSpeciesName().' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deleteAnimal($animalId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM animals WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $animalId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>