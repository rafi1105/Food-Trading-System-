<?php
@include 'config.php';

session_start();

$user_id= $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

// Corrected the query to filter feedback by the logged-in user's name
$select_feedback = $conn->prepare("SELECT m.*, f.feedback, f.created_at AS feedback_created_at FROM `message` m LEFT JOIN `feedback` f ON m.id = f.message_id WHERE f.feedback IS NOT NULL AND f.feedback != '' AND m.name = ? GROUP BY m.id");
$select_feedback->execute([$_SESSION['user_name']]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Feedback</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/components.css">
<style>
   body{
      background-color: #f0f0f0;
      font-family: Arial, sans-serif;
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
#feed{
   background-color: #fff;
   padding: 4rem;
   border-radius: 10px;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
   margin-bottom: 20px;
   width: 50vh;
   font-size: 2rem;
   border: var(--border1);
   text-transform: capitalize;
   line-hight: 1.5;
   margin-bottom: 20px;
}
#feed p{
   margin: 5px 0;
   font-weight: 500;
   
}
#feed span{
   color: var(--purple);
   font-weight: 500;
}
#feed:hover{
   box-shadow: var(--box-shadow4);
   transition: .3s;
   transform: scale(1.02);
}
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

</style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="messages">

   <h1 class="title">Feedback</h1>

   <div class="box-container">

   <?php
      if($select_feedback->rowCount() > 0){
         while($fetch_feedback = $select_feedback->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div id="feed" >
      <h4>Shop Name: <span style="color:white"><?= $fetch_feedback['shop_name']; ?></span> </h4>
      <p> Complain id : <span><?= $fetch_feedback['id']; ?></span> </p>
      <p> name : <span><?= $fetch_feedback['name']; ?></span> </p>
      <p> email : <span><?= $fetch_feedback['email']; ?></span> </p>
      <p> number : <span><?= $fetch_feedback['number']; ?></span> </p>
      <p> shop name : <span><?= $fetch_feedback['shop_name']; ?></span> </p>
      <p> shop location : <span><?= $fetch_feedback['shop_location']; ?></span> </p>
      <p> message : <span><?= $fetch_feedback['message']; ?></span> </p>
      <p> feedback : <span><?= $fetch_feedback['feedback']; ?></span> </p>
      <p> feedback submitted at : <span><?= $fetch_feedback['feedback_created_at']; ?></span> </p>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No feedback available!</p>';
      }
   ?>

   </div>

</section>

<section class="graph-section">
   <h1 class="title">Complaints by Shop Name</h1>
   <canvas id="complaintGraph" width="100%"></canvas>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   // Fetch data for the graph
   const shopNames = [];
   const complaintCounts = [];

   <?php
      $graphData = $conn->prepare("SELECT shop_name, COUNT(*) as count FROM message GROUP BY shop_name");
      $graphData->execute();
      while($row = $graphData->fetch(PDO::FETCH_ASSOC)){
   ?>
      shopNames.push("<?= $row['shop_name']; ?>");
      complaintCounts.push(<?= $row['count']; ?>);
   <?php
      }
   ?>

   Chart.defaults.font.size = 20;
   // Render the graph using Chart.js
   const ctx = document.getElementById('complaintGraph').getContext('2d');
   new Chart(ctx, {
      type: 'bar',
      data: {
         labels: shopNames,
         datasets: [{
            label: 'Number of Complaints',
            data: complaintCounts,
            backgroundColor: 'rgba(116, 9, 255, 0.34)',
            borderColor: 'rgba(55, 0, 255, 0.18)',
            opacity: 0.9,
            borderRadius: 20,
            borderWidth: 1
         }]
      },
      options: {
         responsive: true,
         plugins: {
            legend: {
               position: 'top',
            },
            title: {
               display: true,
               text: 'Complaints by Shop Name'
            }
         },
         scales: {
            y: {
               beginAtZero: true
            }
         }
      }
   });
</script>
<script src="js/script.js"></script>

</body>
</html>