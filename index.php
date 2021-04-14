<?php
$mysql_host='localhost';
$mysql_user='root';
$mysql_password='';
$mysql_db='image';
$conn= mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db) or die("Error " . mysqli_error($conn));
error_reporting(0);
if(isset($_REQUEST['submit']))
{
  $msg="";
  $files =$_FILES['img'];

  $filename = $files['name'];
  $filesize = $files['size'];
  $fileloc = $files['tmp_name'];
  $fileerror  = $files['error'];

  //allowed only jpg, png and jpeg files

  $f = explode('.',$filename);
  $fileextension = strtolower($f[1]);

  $allowextension = array('jpeg','jpg','png');
  if(in_array($fileextension,$allowextension))
  {
     if($filesize < 2000000){
       $fileNewname = uniqid('atechseva',false);
       $dest='upload/'.$fileNewname.'.'.$fileextension;
     move_uploaded_file($fileloc,$dest);
     $query="insert into image(`img`) values('$fileNewname')";
     $result = mysqli_query($conn, $query);
     if($result){
       $msg="File Uploaded Successfully";
     }
     else{
       $msg="Failed to Upload";
     }
     }
     else{
       echo "File Size is Not Valid";
     }
       }
       else{
         echo "File type not suported";
       }
     }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Validation Functionality</title>
</head>

<body>

  <form action="" method="post" enctype="multipart/form-data" style="text-align: center; margin-top: 50px;">
    <label for="">Image</label>
    <input type="file" name="img" id="">
    <input type="submit" value="Submit" name="submit">
  </form>
  <p style="background:rgb(53, 248, 53);">
    <?php echo $msg; ?>
  </p>
</body>

</html>