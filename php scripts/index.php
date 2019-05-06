<?php   
    
     define("DB_SERVER", '127.10.10.10');
     define("DB_NAME" , 'walidacja');
     define("DB_USERNAME", "root");
     define("DB_PASSWORD", "");
     $pdo;
 
     try {
         
     $pdo = new PDO("mysql:host=127.10.10.10;dbname=walidacja",'root','');
 
     $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
     }
     catch(PDOException $e){
         echo "Connection failed: ". $e->getMessage();
     }

     function modify($string){
         $string = trim($string);
         $string = stripslashes($string);
         $string = htmlspecialchars($string);
         return $string;
     }

     function upload_file_and_get_the_path () {
         //here is the file upload code;
         $target_dir = "uploads/";
         $target_file = $target_dir . basename($_FILES["file"]["name"]);
         $upload = 1; //ok

       //  $check  = filesize($target_file);
         if( file_exists($target_file)){
             echo "<br>  File exists ";
             $upload = 0;
         }
         else{
             $upload = 1;
         }
         if($_FILES["file"]["size"]  > 100 ){
             echo "<br> size is bigger than 100 bytes";
             $upload = 1;
         }
         
         if($upload === 0 ){
             echo "<br> Could not upload file";
             return false;
         }
         else{
             if(move_uploaded_file($_FILES["file"]["tmp_name"],$target_file)){
                 echo " <br>  Your file ". basename($_FILES["file"]["name"]) . " has been uploaded";
                 return $target_file;
             }
             else{
                 echo "<br> There was an error while uploading your file";
                 return false;
             }
         }
       
     }

    if($_SERVER['REQUEST_METHOD'] == 'POST')    {
            $email = $password = "";
            $file = null;
            
            $execute= false;
            if(empty(trim($_POST['email'])) && empty(trim($_POST['password'])) ){
                echo "mail and password is required";
                $execute = false;
            }
            else{
                $email = modify($_POST['email']);
                $password = modify($_POST['password']);
            
                # $sql = "INSERT INTO `clients` (`email`,`password`) VALUES (\"GElfds@com.com\", \"test1234\" )";
               


               $statement = $pdo->prepare("INSERT INTO clients (email, password, file)
                VALUES (:email, :password, :file ) ");
                $statement->bindParam(":email", $email);
                $statement->bindParam(":password", $password);
                $statement->bindParam(":file", $file);
                $path = upload_file_and_get_the_path();
                if($path === false){
                        echo "<br> The file will not be uploaded because there is some error";
                }
                else{
                    $file_opened = fopen($path, "r");
                    $data = file_get_contents($path);
                    rewind($file_opened);
                    $uploadFileExtension = strtolower(pathinfo($path,PATHINFO_EXTENSION));
                    if($uploadFileExtension === "txt"){
                        echo "<table style=\" align: center; border: 1px black solid; \" >";
                    while( !feof($file_opened)){
                        $line = fgets($file_opened);
                        echo "<tr><td>$line </td></tr>";
                    }
                    echo "</table>";
                    }
                    $file = $data;
                }

                try {
                    $statement->execute() or
                    die(print_r($pdo->errorInfo(), true));
                    echo " Statemnt executed ";
                } catch (PDOException $e ) {
                    echo $e->getMessage();
                }
                

                echo "<br> $email <br> $password";
            }

       echo "<a href=\"../index.php\" >  To the main site</a>";
    }

?>