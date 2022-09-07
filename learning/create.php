<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $MI = $address = $salary = $sex = $birthdate = "";
$name_err = $MI_err = $address_err = $salary_err = $sex_err = $birthdate_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

    $input_MI = trim($_POST["MI"]);
    if(empty($input_MI)){
        $MI_err = "Please enter a Middle name.";
    } elseif(!filter_var($input_MI, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $MI_err = "Please enter a valid Middle name.";
    } else{
        $MI = $input_MI;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }

    $input_sex = trim($_POST["sex"]);
    if(empty($input_sex)){
        $sex_err = "Please enter your sex.";     
    } else{
        $sex = $input_sex;
    }

    $input_birthdate = trim($_POST["birthdate"]);
    if(empty($input_birthdate)){
        $birthdate_err = "Please enter your birthdate.";     
    } else{
        $birthdate = $input_birthdate;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($MI_err) && empty($address_err) && empty($salary_err) && empty($sex_err) && empty($birthdate_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, MI, address, salary, sex, birthdate) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_MI, $param_address, $param_salary,$param_sex,$param_birthdate);
            
            // Set parameters
            $param_name = $name;
            $param_MI = $MI;
            $param_address = $address;
            $param_salary = $salary;
            $param_sex = $sex;
            $param_birthdate = $birthdate;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
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
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" name="MI" class="form-control <?php echo (!empty($MI_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $MI; ?>">
                            <span class="invalid-feedback"><?php echo $MI_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Sex</label>
                            <input type="text" name="sex" class="form-control <?php echo (!empty($sex_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sex; ?>">
                            <span class="invalid-feedback"><?php echo $sex_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Birthdate</label>
                            <input type="text" name="birthdate" class="form-control <?php echo (!empty($birthdate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $birthdate; ?>">
                            <span class="invalid-feedback"><?php echo $birthdate_err;?></span>
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