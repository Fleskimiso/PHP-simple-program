<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css files/css.css">
    <title> Simple login</title>
</head>
<body>
    <div class="Hello">Hello world</div>
   

        <form action="<?php echo "./php scripts/index.php"?>" method="post"
        enctype="multipart/form-data" >
         
         <div > 
            <label for="email"> email</label>
        <input type="email" name="email" id="email" >
    </div>
         
           
        
        <div >
            <label for="password"> password</label>
            <input type="password" name='password'  id="password">
        </div>
        
      
      <div > <input type="file" name="file" id="fileid"></div>
      
     
     <div ><input type="submit" value="submit"></div>
     
        
        </form>
  


</body>
</html>