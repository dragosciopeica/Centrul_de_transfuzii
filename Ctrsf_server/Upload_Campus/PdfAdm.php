<?php
// Include the database configuration file
include 'phpconPac.php';
$statusMsg = '';
$hashPas='';
$data='';
$data_trim ='';
$cnp_last_nr = '';


// File upload path
if(isset($_POST['submit'])){
// MERGE!
if (isset($_POST['data']))
	{	$data= $_POST['data']; }


$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

$randomPass = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);

if(!empty($_FILES["file"]["name"]) &&  !empty($_POST['data'])){
    // Allow certain file formats
    $allowTypes = array('pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert pdf file name into database
            $fileName_trim = trim($fileName, ".pdf");
            $cnp_last_nr = substr($fileName_trim, -3);
            $data_trim  = (str_replace('-','',$data));

            $pass = $data_trim . $cnp_last_nr;
            //$randomPass = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);          
            $link -> query("DELETE from pacienti WHERE uploaded_on < (CURDATE() - INTERVAL 30 DAY);");
            // Check if files exists
            $check_file = $link->query("SELECT cnp FROM pacienti WHERE cnp = '".$fileName_trim."'");
            $row = mysqli_num_rows($check_file);
                if ($row < 1){                

            $insert = $link->query("INSERT into pacienti (cnp, pass, file_name, uploaded_on) VALUES ('".$fileName_trim."','$pass','".$fileName."', '$data')");
             
            if($insert){
                $statusMsg = "\n"."Fisierul ".$fileName. " s-a incarcat cu succes!";
            }else{
                $statusMsg = "Incarcarea fisierului a esuat!";
                 }
            }else {
                $statusMsg ="ATENTIE! Fisierul exista deja!"; 
            } 
        }else{
            $statusMsg = "A aparut o eroare in incarcarea fisierului";
             }
    }else{
        $statusMsg = 'Doar fisiere PDF trebuie incarcate!';
         }
}else{
    $statusMsg = 'Selectati un fisier si o data pentru incarcare!';
     }

}


function delete_older_than($dir, $max_age) {
  $list = array(); // lista cu fisiere stearsa, NU o folosesc!
  
  $limit = time() - $max_age;
  
  $dir = realpath($dir);
  
  if (!is_dir($dir)) {
    return;
  }
  
  $dh = opendir($dir);
  if ($dh === false) {
    return;
  }
  
  while (($file = readdir($dh)) !== false) {
    $file = $dir . '/' . $file;
    if (!is_file($file)) {
      continue;
    }
    
    if (filemtime($file) < $limit) {
      $list[] = $file;
      unlink($file);
    }
    
  }
  closedir($dh);
  return $list;
}

$dir = "uploads/";


delete_older_than($dir, 2592000);


?>




<html>
<head>
	<link rel="stylesheet" type="text/css" href="styleAdminUp.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin CentruTrasnfuzii</title>
</head>
		<body >
			<div class="loginbox">
				<form  action="" method="post" enctype="multipart/form-data"  onSubmit="died(alert($statusMsg))" >
   				<h1>Alegeti fisierul pe care il incarcati</h1>
   				 <input type="file" name="file" class="inputfile" />
   				 <input type="date" name="data" class="inputdate" />
   				 

    			<input type="submit" name="submit" value="Upload">
				</form>

			<div class="AfisareMsg">

				<?php echo $statusMsg; ?>

			</div>
			</div>

			<div class="logoCentru">
				<img src="logoCTSF.png">
			</div>




		</body>
</html>