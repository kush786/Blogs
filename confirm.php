<?php
//var_dump($_POST);
 require_once "config.php";
$query="select*from `user`";
$result=$connection->query($query);
//var_dump($_POST);
$userElements=$result->fetch_all(MYSQLI_ASSOC);
//var_dump($userElements);
if(isset($_FILES)) {/*This is for file upload ------------------------------------------------------------------------------------*/
    if ($_FILES['fileToUpload']['tmp_name'] != "")
    {
        $target_dir = "uploads/";
        $imageFileType = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
        $target_file = $target_dir . time() . '.' . $imageFileType;
        $uploadOk = 1;
//var_dump($imageFileType);
// Check if image file is a actual image or fake image
        if (isset($_POST["submit"]))
        {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false)
            {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            }
            else
            {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        if ($_FILES['fileToUpload']['name'] != "") {
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file) or
            die("Could not copy file!");
        }
        /* --------------------------------------------------------------------------------------------------- */
    }
}
foreach ($userElements as $eMail)
{
   // var_dump($eMail);
    //var_dump($_POST);
      $one=$eMail['e-mail'];
    $two=$_POST['email'];
     if($one==$two)
        {
          $emailError = 1;
           $emailRedirect="signUp.php?emailerror=".$emailError;
            header("Location: $emailRedirect");
        }
}
if($_POST['fullName']=='')
{
    $emailError = 4;
    $emailRedirect="signUp.php?emailerror=".$emailError;
    header("Location: $emailRedirect");
}
if($_POST['sec_ans']=='')
{
    $emailError = 5;
    $emailRedirect="signUp.php?emailerror=".$emailError;
    header("Location: $emailRedirect");
}
if($_POST['sec_ques']=='-----Choose a question------')
{
    $emailError = 6;
    $emailRedirect="signUp.php?emailerror=".$emailError;
    header("Location: $emailRedirect");
}

if($_POST['password']=='')
{
    $emailError = 2;
$emailRedirect="signUp.php?emailerror=".$emailError;
header("Location: $emailRedirect");
}
if($_POST['email']=='')
{
    $emailError=3;
    $emailRedirect="signUp.php?emailerror=".$emailError;
    header("Location: $emailRedirect");

}
$hash=md5($_POST['password']);
    if(isset($_FILES)&&($_FILES['fileToUpload']['tmp_name'] != ""))
    {
        //if ($_FILES['fileToUpload']['tmp_name'] != "")
        {

        $query1 = " insert into `user` ( `user_name`, `e-mail` , `password`, `security_ques`, `security_ans`,`media` ) values ('{$_POST['fullName']}','{$_POST['email']}','{$hash}','{$_POST['sec_ques']}','{$_POST['sec_ans']}','{$target_file}')";
    }
}
   else
       $query1=" insert into `user` ( `user_name`, `e-mail` , `password`, `security_ques`, `security_ans` ) values ('{$_POST['fullName']}','{$_POST['email']}','{$hash}','{$_POST['sec_ques']}','{$_POST['sec_ans']}')";

$result1=$connection->query($query1);


$location="login.php";
    // header("Location: $location");
//var_dump($_FILES);
?>
<!DOCTYPE html>
<html>
<link type="text/css" rel="stylesheet" href="bootstrap.css" />
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body class="bg-danger">
<h4 class="text-center">SignUp Successful</h4>
<a href="login.php" class="text-center">To login click here</a>
</body>
</html>


