<?php
// Include employeeDAO file
require_once('./dao/animalDAO.php');

// Define variables and initialize with empty values
$speciesName = $age = $importDate = $imageFileName = "";
$speciesName_err = $age_err = $importDate_err = $imageFileName_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate species name
    $input_speciesName = trim($_POST["speciesName"]);
    if (empty($input_speciesName)) {
        $speciesName_err = "Please enter species name.";
    } elseif (!filter_var($input_speciesName, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $speciesName_err = "Species name can only contain letters and spaces.";
    } else {
        $speciesName = $input_speciesName;
    }

    //validate species age
    $input_age = trim($_POST["age"]);
    if (empty($input_age)) {
        $age_err = "Please enter the age of this species.";
    } elseif (intval($input_age) < 0 || intval($input_age) > 150) {
        $age_err = "Please ensure animal age ranges from 0 to 150";
    } else {
        $age = $input_age;
    }

    //validate import date
    $input_importDate = $_POST['importDate'];
    if (empty($input_importDate)) {
        $importDate_err = "Please enter an import date";
    } else {
        $importDate = new DateTime($input_importDate);
        $minDate = new DateTime('2000-01-01');
        if ($importDate < $minDate) {
            $importDate_err = "Import date must be after 2000-01-01.";
            $importDate = null; // new
        } else {
            $importDate = $input_importDate;
        }
    }

    //validate uploaded image file and upload the file to the directory "images"
    if (isset($_FILES['image'])) {
        // $errors = array();
        $imageFileName = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];

        if ($_FILES['image']['size'] > 10097152) {
            $imageFileName_err = 'Faild to upload: File size must be less than 10 MB';
        }
        //file upload
        if (empty($imageFileName_err) == true && isset($_FILES['image']) && empty($speciesName_err) && empty($age_err) && empty($importDate_err) && empty($imageFileName_err)) {
            move_uploaded_file($file_tmp, "images/" . $_FILES['image']['name']);
        }
    }

    // Check input errors before inserting in database
    if (empty($speciesName_err) && empty($age_err) && empty($importDate_err) && empty($imageFileName_err)) {
        $animalDAO = new animalDAO();
        $animal = new Animal(0, $speciesName, $age, $importDate, $imageFileName);
        $addResult = $animalDAO->addAnimal($animal);
        header("refresh:2; url=index.php");
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';
        // Close connection
        $animalDAO->getMysqli()->close();
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add animal record to the database.</p>

                    <!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                        enctype="multipart/form-data">
                        
                        <!-- Input for species name -->
                        <div class="form-group">
                            <label>Species Name</label>
                            <input type="text" name="speciesName"
                                class="form-control <?php echo (!empty($speciesName_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $speciesName; ?>">
                            <span class="invalid-feedback">
                                <?php echo $speciesName_err; ?>
                            </span>
                        </div>

                        <!-- Input for age -->
                        <div class="form-group">
                            <label>Species Age</label>
                            <input type="number" name="age"
                                class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $age; ?>">
                            <span class="invalid-feedback">
                                <?php echo $age_err; ?>
                            </span>
                        </div>

                        <!-- Input for import date -->
                        <div class="form-group">
                            <label>Import Date</label>
                            <input type="date" name="importDate"
                                class="form-control <?php echo (!empty($importDate_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $importDate; ?>">
                            <span class="invalid-feedback">
                                <?php echo $importDate_err; ?>
                            </span>
                        </div>

                        <!-- image file upload -->
                        <div class="form-group">
                            <label>Upload Animal Picture</label>
                            <input type="file" name="image" accept="image/*"
                                class="form-control <?php echo (!empty($imageFileName_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $imageFileName; ?>" />
                            <span class="invalid-feedback">
                                <?php echo $imageFileName_err; ?>
                            </span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>