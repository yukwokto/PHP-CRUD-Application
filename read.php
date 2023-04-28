<?php
// Include employeeDAO file
require_once('./dao/animalDAO.php');
$animalDAO = new animalDAO(); 

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id = trim($_GET["id"]);
    $animal = $animalDAO->getAnimal($id);
            
    if($animal){
        // Retrieve individual field value
        $speciesName = $animal->getSpeciesName();
        $age = $animal->getAge();
        $importDate = $animal->getImportDate();
        
        $imageFileName = $animal->getImageFileName();
        $image_path = "images/" . $imageFileName;

    } else{
        // URL doesn't contain valid id. Redirect to error page
        header("location: error.php");
        exit();
    }
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
} 

// Close connection
$animalDAO->getMysqli()->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Animal Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<!-- $speciesName = $age = $importDate = $imageFileName  -->
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Animal Record</h1>
                    
                    <!-- display animal image -->
                    <div class="form-group">
                        <label>Species Image</label>
                        <p><b><?php echo "<img src='$image_path' alt='Example Image' width='300'>"; ?></b></p>
                    </div>

                    <!-- display species name -->
                    <div class="form-group">
                        <label>Species Name</label>
                        <p><b><?php echo $speciesName; ?></b></p>
                    </div>

                    <!-- display species age -->
                    <div class="form-group">
                        <label>Animal Age</label>
                        <p><b><?php echo $age; ?></b></p>
                    </div>

                    <!-- display import date -->
                    <div class="form-group">
                        <label>Import Date</label>
                        <p><b><?php echo $importDate; ?></b></p>
                    </div>


                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>