<?php


require_once "phpconPac.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
$UpCase = 0;

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))) {
        $username_err = "Introduceți contul!";
    } else{
        $username = trim($_POST["username"]);
    }

   if (!ctype_lower($username)) { 
        $UpCase = 1; 
    } 
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduceți parola!";
    } else{
        $password = trim($_POST["password"]);
    }


  if(empty($username_err) && empty($password_err)){

    // Prepare a select statement
        $sql = "SELECT admin, pass FROM admin WHERE admin = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username; // 
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1 && $UpCase == 0){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                         if(password_verify($password,$hashed_password)){
                            // Password is correct, so start a new session
                             $url ="https://cts.studupt.xyz/PdfAdm.php?username=" . $username;
                             header('Location: ' . $url);  // M-AI SALVAT!!!!
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "Parola introdusa este gresita!";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "Niciun cont cu numele acesta!";
                }
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


<!--  Aici era partea de <DOCTYPE, trebuia scoasa, altfel nu-mi mergea css-ul... -->
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styleAdmin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centrul de transfuzii</title>
    
<body>
    <div class="loginbox">
    <img src="Login2.png" class="avatar">   
        <h1>Logați-vă aici</h1>
        
        <form name="loginform" id="logFORM" method="post" action="<?php echo $url; ?>" onSubmit="died(alert($username_err))" >
            <label>Admin<span></span></label>
            <input type="text" id="CNP" name="username" placeholder="Inserati CNP-ul" value="<?php echo $username; ?>" >

            <label>Parola<span></span></label>
            <input type="password" id="PASS" name="password" placeholder="Inserati codul primit" value="" >
            <input type="submit"  value="Login">
            <span class="mesaje">
                <?php echo $username_err?>
                <BR>
                <?php echo $password_err?>
            </span>
        
        </form>
    </div>

    <div class="logoCentru">
        <img src="logoCTSF.png">
    </div>

   




</body>
</head>
</html>