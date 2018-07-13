<?php
$ds          = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = 'uploads';   //2
 echo $_POST["titulo"];
 echo $_POST["descripcion"]; 

for($i=0; $i<count($_FILES['upload']['name']); $i++) {
    
    $extension=pathinfo($_FILES['upload']['name'][$i],PATHINFO_EXTENSION);

	$_FILES['upload']['name'][$i]=rand(100000000,999999999);
                   
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
    $targetFile =  $targetPath. $_FILES['upload']['name'][$i].".". $extension;  //5


 
    move_uploaded_file($_FILES['upload']['tmp_name'][$i],$targetFile); //6





  }



?>  