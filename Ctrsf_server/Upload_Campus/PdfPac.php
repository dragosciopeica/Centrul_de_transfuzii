
<?php


$CNP = $_REQUEST["username"];
$CNP_pdf = '';
$CNP_pdf = $CNP . '.pdf';






require_once "phpconPac.php";

$username_err = $password_err = "";


 $sql = "SELECT file_name, uploaded_on FROM pacienti WHERE file_name = ?";
 	if($stmt = mysqli_prepare($link, $sql)){
 		mysqli_stmt_bind_param($stmt,"s",$param_username);

 		$param_username = $CNP_pdf;

 		if(mysqli_stmt_execute($stmt)){
 			mysqli_stmt_store_result($stmt);

 			if(mysqli_stmt_num_rows($stmt)==1){

 				mysqli_stmt_bind_result($stmt,$CNP_pdf,$date);
 				if(mysqli_stmt_fetch($stmt)){ 					

 				}
 			} else{

 				$username_err ="Niciun fisier cu numele acesta!";
 			}
 		}else{
                echo "Oops! Something went wrong. Execute";
             }
 	}

 // Close statement
    mysqli_stmt_close($stmt);



?>




   

<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylePacDown.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Centrul de transfuzii</title>
	
<body>	
	<div class="logoCentru">
		<img src="logoCTSF.png">
	</div>
		<div class = "PDF_box">
				<h1>Descarca documentul</h1>	

		</div>
	<div class="infobox">

		<p> Donatorul cu CNP = '<?php  echo $CNP;?>' s-a logat cu succes!
			<BR>
			Analize efectuate la data: <?php  echo $date;?>

		</p>
	</div>

	<div class="PDF_logo">		
		  <a href="https://cts.studupt.xyz/uploads/<?php echo $CNP_pdf ?>" download>					
		  <img src="Pdf.png" alt="PDF_file">
		</a>
	</div>




</body>
</head>
</html>