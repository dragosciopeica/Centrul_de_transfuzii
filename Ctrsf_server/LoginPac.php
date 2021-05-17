<?php


require_once "phpconPac.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Introduceți contul!";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduceți parola!";
    } else{
        $password = trim($_POST["password"]);
    }


  if(empty($username_err) && empty($password_err)){

 	// Prepare a select statement
        $sql = "SELECT cnp, pass FROM pacienti WHERE cnp = ?";
        
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
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $passwordM);
                    if(mysqli_stmt_fetch($stmt)){
                        if($password === $passwordM){
                            // Password is correct, so start a new session
                             $url ="https://cts.studupt.xyz/PdfPac.php?username=" . $username;
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
    <link rel="stylesheet" type="text/css" href="stylePac.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centrul de transfuzii</title>
    
<body>
    <div class="loginbox">
    <img src="Login2.png" class="avatar">   
        <h1>Logați-vă aici</h1>
        
        <form name="loginform" id="logFORM" method="post" action="<?php echo $url; ?>" onSubmit="died(alert($username_err))" >
            <label>CNP<span></span></label>
            <input type="text" id="CNP" name="username" placeholder="Inserati CNP-ul" value="<?php echo $username; ?>" >

            <label>COD DONATOR<span></span></label>
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

    <div class="infobox">

        <p> Acest site permite descarcarea analizelor efectuate ca urmare a donarii sangelui. Accesul se face pe baza CNP-ului donatorului si pe baza codului de donator, format din xxx cifre, primit la plecarea din centru.</p>
    </div>




</body>
</head>
</html>