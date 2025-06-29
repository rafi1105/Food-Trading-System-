<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>
<h1 class="glow">About Us</h1>
<section class="about">

   <div class="row">

      <div class="box">
         <img src="images/about-img-1.png" alt="">
         <h3>why choose us?</h3>
         <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam, a quod, quis alias eius dignissimos pariatur laborum dolorem ad ullam iure, consequatur autem animi illo odit! Atque quia minima voluptatibus.</p>
         <a href="contact.php" class="btn4" style=" width: 50%;">Contact us</a>
      </div>

      <div class="box">
         <img src="images/about-img-2.png" alt="">
         <h3>what we provide?</h3>
         <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quisquam, a quod, quis alias eius dignissimos pariatur laborum dolorem ad ullam iure, consequatur autem animi illo odit! Atque quia minima voluptatibus.</p>
         <a href="shop.php" class="btn4" style="  width: 50%;">Our shop</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">clients reivews</h1>

   <div class="box-container">

      <div class="box">
         <img src="https://scontent.fdac138-1.fna.fbcdn.net/v/t39.30808-6/448436555_2231356890551018_7278396730505754291_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=AEZPXVZidnQQ7kNvwEVCNiP&_nc_oc=Adli0d6NvnxWF3PzHtMYSfNjX4zNi28ULWZPjbaXg7uXDtfxQf87-AocuLsv8gLO8gE&_nc_zt=23&_nc_ht=scontent.fdac138-1.fna&_nc_gid=EAasM0M8e7FddeKURQSfrg&oh=00_AfEfWChZ7V1ZjDQNTJ9Yx2jrONrcSwMnWYjqVjhrwfQF5A&oe=681972C0" alt="">
         <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et voluptates sit earum, neque non cupiditate amet deserunt aperiam quas ex.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Shoaib</h3>
      </div>

      <div class="box">
         <img src="https://scontent.fdac138-1.fna.fbcdn.net/v/t39.30808-6/487812109_4056909144592403_7583157759155060812_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=M04DM5OA31cQ7kNvwFWaYph&_nc_oc=Admx4uPPbEkS7IZsbdCT3_tiT9Bh3bOPZAxgDDrmcoSZlTTZUgm9ZpULR_uwyBoGDhw&_nc_zt=23&_nc_ht=scontent.fdac138-1.fna&_nc_gid=I739i85CBl-3SaegkEqmlA&oh=00_AfG1cx2Jqf7UrT5QkawXlEVN6IiFUgapofgEhbsGMuJENg&oe=681971DC" alt="">
         <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et voluptates sit earum, neque non cupiditate amet deserunt aperiam quas ex.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Lihan</h3>
      </div>

      <div class="box">
         <img src="https://scontent.fdac138-1.fna.fbcdn.net/v/t39.30808-6/487446453_2762807907237351_7268365411163292186_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=x02wIAnSur4Q7kNvwGHx8Ma&_nc_oc=AdnJSIBvkq5cyT-tyLfGqIncevfBf2Y-11f2WRkL8WF-sgbusnsjdlLfaRe1D3jwBQs&_nc_zt=23&_nc_ht=scontent.fdac138-1.fna&_nc_gid=dpqQpJAj_TS9Dw1lEIws-A&oh=00_AfFc3mogckZauwoI3Ynrr2juskQrRV-LxOy3FIEgVxLVPw&oe=68197660" alt="">
         <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et voluptates sit earum, neque non cupiditate amet deserunt aperiam quas ex.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Mostofa</h3>
      </div>

      <div class="box">
         <img src="https://scontent.fdac138-1.fna.fbcdn.net/v/t39.30808-6/480505329_1154970469622460_5421535207584103247_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=a5f93a&_nc_ohc=eT2Z5oPF1jAQ7kNvwGICIli&_nc_oc=AdnwHVZaSeX3CszGM7ai8B9-PFbZ9_l4tcOgN6qZ4WHcllF-ODNeEwYrMzsQvRAby1c&_nc_zt=23&_nc_ht=scontent.fdac138-1.fna&_nc_gid=ieGqFd5xB9-Tannn11ctng&oh=00_AfH9SPg0ehw9rrrUHUZIGDeSfCUL1aEyUYEzOcI7nC-JEA&oe=681956DC" alt="">
         <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et voluptates sit earum, neque non cupiditate amet deserunt aperiam quas ex.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Munna</h3>
      </div>

      <div class="box">
         <img src="https://scontent.fdac138-2.fna.fbcdn.net/v/t39.30808-6/480582718_1606023326701245_1572665521751790943_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=qbr15YSQkG4Q7kNvwFRG4ux&_nc_oc=Adk6oTEaohxQBAjCojpu776CKRKMbsEn12ZMbETH82nq-H6pwQWeiT-lDMQedbCp5ig&_nc_zt=23&_nc_ht=scontent.fdac138-2.fna&_nc_gid=L_C-Bvrjqo8TX2V0lAAisQ&oh=00_AfH7bAFsyXRDjr6-OewfiXyr8SE2endEHj6hQRv3hw9XkA&oe=6819567C" alt="">
         <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et voluptates sit earum, neque non cupiditate amet deserunt aperiam quas ex.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Shohail</h3>
      </div>

      <div class="box">
         <img src="https://scontent.fdac138-1.fna.fbcdn.net/v/t39.30808-6/337227169_6243756515677073_6544719826179329343_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=ZMgz9NMQPWIQ7kNvwErqG_v&_nc_oc=Admq3Lv4KVFrke9lf03W1PIz9wKI3tHJzorBDzwDAOTraq1UJNkQ2ZkghDJFSluVdw4&_nc_zt=23&_nc_ht=scontent.fdac138-1.fna&_nc_gid=Esfudu_E8y0VQOlvY8YfzA&oh=00_AfGrv1c4uLbaS_x_JkTc6G3s2wt9dklXVn_Iof8sy4X-fQ&oe=68196232" alt="">
         <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et voluptates sit earum, neque non cupiditate amet deserunt aperiam quas ex.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Bissojit</h3>
      </div>

   </div>

</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>