<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:admin_contacts.php');

}

// Added feedback input box and submission logic
if(isset($_POST['submit_feedback'])){
   $message_id = $_POST['message_id'];
   $feedback = $_POST['feedback'];
   $feedback = filter_var($feedback, FILTER_SANITIZE_STRING);

   $insert_feedback = $conn->prepare("INSERT INTO `feedback` (message_id, feedback) VALUES (?, ?)");
   $insert_feedback->execute([$message_id, $feedback]);

   $message[] = 'Feedback submitted successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
<style>
   h4{
   font-size: 2.5rem;
   color: var(--purple);
   margin-bottom: 10px;
   border: var(--border1);
   padding: 1rem;
   border-radius: 10rem;
   text-align: center;
   margin: auto;
   width: 100%;
   background: var(--purple);
   color: #fff;
   margin-bottom: 20px;
}
.messages .box-container{
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        justify-content: center;
        align-items: center;
        padding: 2rem 0;
        margin-top: 2rem;
     }
     .messages .box-container .box
    {
        height: 95%;
        width: 80%;
        position: relative;
        display: block;
        overflow: hidden;   
        
     }
</style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title">Complain Box</h1>

   <div class="box-container">

   <?php
      $select_message = $conn->prepare("SELECT * FROM `message`");
      $select_message->execute();
      if($select_message->rowCount() > 0){
         while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
   <h4>Shop Name: <span style="color:white"><?= $fetch_message['shop_name']; ?></span> </h4>
   
   <p> Complaint id : <span><?= $fetch_message['id']; ?></span> </p>
      <p> name : <span><?= $fetch_message['name']; ?></span> </p>
      <p> email : <span><?= $fetch_message['email']; ?></span> </p>
      <p> number : <span><?= $fetch_message['number']; ?></span> </p>
      <p> shop name : <span><?= $fetch_message['shop_name']; ?></span> </p>
      <p> shop location : <span><?= $fetch_message['shop_location']; ?></span> </p>
      <p> bad service : <span><?= $fetch_message['bad_service'] ? 'Yes' : 'No'; ?></span> </p>
      <p> high price : <span><?= $fetch_message['high_price'] ? 'Yes' : 'No'; ?></span> </p>
      <p> quantity less : <span><?= $fetch_message['quantity_less'] ? 'Yes' : 'No'; ?></span> </p>
      <p> bill info : <span><?= $fetch_message['bill_info']; ?></span> </p>
     
      <p> bill uploaded at : <span>
          <?php if ($fetch_message['bill_info'] === 'yes' && !empty($fetch_message['bill_path'])): ?>
            <a href="<?= $fetch_message['bill_path']; ?>" target="_blank" style="color: blue;">view document</a>
         <?php else: ?>
            <?= $fetch_message['bill_uploaded_at']; ?>
         <?php endif; ?>
      </span> </p>
      <p> message : <span><?= $fetch_message['message']; ?></span> </p>
      <p> created at : <span><?= $fetch_message['created_at']; ?></span> </p>
      
      <form action="" method="POST">
         <input type="hidden" name="message_id" value="<?= $fetch_message['id']; ?>">
         <textarea name="feedback" class="box" required placeholder="Enter your feedback"></textarea>
         <a href="admin_contacts.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>

         <input type="submit" value="Submit Feedback" class="btn" name="submit_feedback">
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">you have no messages!</p>';
      }
   ?>

   </div>

</section>













<script src="js/script.js"></script>

</body>
</html>