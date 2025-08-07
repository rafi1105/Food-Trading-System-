<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

// Ensure $message is initialized as an array before appending values
if (!isset($message) || !is_array($message)) {
   $message = [];
}

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $shop_name = $_POST['shop_name'];
   $shop_name = filter_var($shop_name, FILTER_SANITIZE_STRING);
   $shop_location = $_POST['shop_location'];
   $shop_location = filter_var($shop_location, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $bad_service = isset($_POST['BadService']) ? 1 : 0;
   $high_price = isset($_POST['HighPrice']) ? 1 : 0;
   $quantity_less = isset($_POST['QuantityLess']) ? 1 : 0;

   $bill_info = isset($_POST['bill_info']) ? $_POST['bill_info'] : 'no';
   $bill_info = filter_var($bill_info, FILTER_SANITIZE_STRING);

   $bill_original_name = null;
   $bill_stored_name = null;
   $bill_path = null;
   $bill_uploaded_at = null;

   if ($bill_info === 'yes' && isset($_FILES['bill_file']) && $_FILES['bill_file']['error'] === UPLOAD_ERR_OK) {
      $uploadDir = 'uploads/';
      if (!is_dir($uploadDir)) {
         mkdir($uploadDir, 0777, true);
      }

      $fileTmpPath = $_FILES['bill_file']['tmp_name'];
      $fileName = $_FILES['bill_file']['name'];
      $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
      $newFileName = uniqid('bill_', true) . '.' . $fileExtension;

      $destPath = $uploadDir . $newFileName;

      if (move_uploaded_file($fileTmpPath, $destPath)) {
         $bill_original_name = $fileName;
         $bill_stored_name = $newFileName;
         $bill_path = $destPath;
         $bill_uploaded_at = date('Y-m-d H:i:s');
      } else {
         $message[] = 'Failed to move uploaded file.';
      }
   }

   $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, shop_name, shop_location, message, bad_service, high_price, quantity_less, bill_info, bill_original_name, bill_stored_name, bill_path, bill_uploaded_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $shop_name, $shop_location, $msg, $bad_service, $high_price, $quantity_less, $bill_info, $bill_original_name, $bill_stored_name, $bill_path, $bill_uploaded_at]);

      $message[] = 'sent message successfully!';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact Form</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/components.css">
<style>
   body {
      background: url('https://img.freepik.com/free-photo/studio-background-concept-abstract-empty-light-gradient-purple-studio-room-background-product_1258-71866.jpg') no-repeat center center/cover;
   }
 
   .contact .title {
      text-align: center;
      margin-bottom: 20px;
      font-size: 5rem;
   }
   form {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: none;
      background: #fff;
      color: #000;
      opacity: 0.85;
   }
.btn1{
   width: 100%;
}
.checkbox-group {
   display: flex;
   justify-content: space-between;
   margin-bottom: 10px;
   padding: 10px;
   font-size: 1.6rem;
}
.checkbox-group:hover {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  transition: box-shadow 0.3s ease-in-out;
}
input[type="checkbox"] {
   margin-right: 1rem;
   cursor: pointer;
   width: 2rem;
   height: 2rem;
   accent-color: var(--voilet); /* Change the color of the checkbox */
}
input[type="radio"] {
   margin-right: 1rem;
   cursor: pointer;
   width: 2rem;
   height: 2rem;
   accent-color: var(--voilet); /* Change the color of the checkbox */
}
.radio-group {
   display: flex;
   justify-content:  space-between;
   margin-bottom: 20px;
   margin-top: 20px;
   padding: 10px;
   font-size: 1.6rem;
}
.radio-group:hover {
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  transition: box-shadow 0.3s ease-in-out;
}
.bill{
   font-size: 1.8rem;
   color: #000;

 
}
</style>
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="contact">

   <h1 class="title">Complain Box</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <input type="text" name="name" class="box" required placeholder="enter your name">
      <input type="email" name="email" class="box" required placeholder="enter your email">
      <input type="number" name="number" min="0" class="box" required placeholder="enter your number">
      <input type="text" name="shop_name" class="box" required placeholder="enter shop name">
      <input type="text" name="shop_location" class="box" required placeholder="enter shop location">
      <textarea name="msg" class="box" required placeholder="enter your message" cols="30" rows="10"></textarea>
      
      <div class="checkbox-group">
         <label><input type="checkbox" name="BadService" value="BadService"> Bad Service</label>
         <label><input type="checkbox" name="HighPrice" value="HighPrice">High Price </label>
         <label><input type="checkbox" name="QuantityLess" value="QuantityLess">Quantity Less</label>
      </div>
     
      <div class="radio-group">
      <p class="bill" >Upload Bill:</p>
         <label><input type="radio" name="bill_info" value="yes" id="bill_yes"> Yes</label>
         <label><input type="radio" name="bill_info" value="no" id="bill_no"> No</label>
      </div>
      
      <div id="file-upload" style="display: none;">
  
         <input type="file" name="bill_file" id="bill_file" class="box">
      </div>

   <?php
   if (isset($_FILES['bill_file']) && $_FILES['bill_file']['error'] === UPLOAD_ERR_OK) {
      $uploadDir = 'uploads/';
      if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
      }

      $fileTmpPath = $_FILES['bill_file']['tmp_name'];
      $fileName = $_FILES['bill_file']['name'];
      $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
      $newFileName = uniqid('bill_', true) . '.' . $fileExtension;

      $destPath = $uploadDir . $newFileName;

      if (move_uploaded_file($fileTmpPath, $destPath)) {
      $fileData = [
         'original_name' => $fileName,
         'stored_name' => $newFileName,
         'path' => $destPath,
         'uploaded_at' => date('Y-m-d H:i:s')
      ];

      $jsonFilePath = $uploadDir . 'file_data.json';
      $existingData = file_exists($jsonFilePath) ? json_decode(file_get_contents($jsonFilePath), true) : [];
      $existingData[] = $fileData;

      file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));
      $message[] = 'File uploaded and data saved successfully!';
      } else {
      $message[] = 'Failed to move uploaded file.';
      }
   }
   ?>
      
      <input type="submit" value="send message" class="btn1" name="send">

      <script>
         const billYes = document.getElementById('bill_yes');
         const billNo = document.getElementById('bill_no');
         const fileUpload = document.getElementById('file-upload');

         billYes.addEventListener('change', () => {
         if (billYes.checked) {
            fileUpload.style.display = 'block';
         }
         });

         billNo.addEventListener('change', () => {
         if (billNo.checked) {
            fileUpload.style.display = 'none';
         }
         });
      </script>
   </form>

</section>



<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>