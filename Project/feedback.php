<?php
@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

// Ensure unique complaints are displayed by grouping by message ID
$select_feedback = $conn->prepare("SELECT m.*, f.feedback, f.created_at AS feedback_created_at FROM `message` m LEFT JOIN `feedback` f ON m.id = f.message_id WHERE f.feedback IS NOT NULL AND f.feedback != '' GROUP BY m.id");
$select_feedback->execute();

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
<style>
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

   <h1 class="title">Feedback</h1>

   <div class="box-container">

   <?php
      if($select_feedback->rowCount() > 0){
         while($fetch_feedback = $select_feedback->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Complain id : <span><?= $fetch_feedback['id']; ?></span> </p>
      <p> name : <span><?= $fetch_feedback['name']; ?></span> </p>
      <p> email : <span><?= $fetch_feedback['email']; ?></span> </p>
      <p> number : <span><?= $fetch_feedback['number']; ?></span> </p>
      <p> shop name : <span><?= $fetch_feedback['shop_name']; ?></span> </p>
      <p> shop location : <span><?= $fetch_feedback['shop_location']; ?></span> </p>
      <p> bad service : <span><?= $fetch_feedback['bad_service'] ? 'Yes' : 'No'; ?></span> </p>
      <p> high price : <span><?= $fetch_feedback['high_price'] ? 'Yes' : 'No'; ?></span> </p>
      <p> quantity less : <span><?= $fetch_feedback['quantity_less'] ? 'Yes' : 'No'; ?></span> </p>
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
   <canvas id="complaintGraph" width="400" height="200"></canvas>
</section>

<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
   // Fetch data for the graph
const shopNames = [];
const complaintCounts = [];
const shopDetails = {};

<?php
    $graphData = $conn->prepare("SELECT shop_name, COUNT(*) as count, SUM(bad_service) as bad_service_count, SUM(high_price) as high_price_count, SUM(quantity_less) as quantity_less_count FROM message GROUP BY shop_name");
    $graphData->execute();
    while($row = $graphData->fetch(PDO::FETCH_ASSOC)){
?>
    shopNames.push("<?= $row['shop_name']; ?>");
    complaintCounts.push(<?= $row['count']; ?>);
    shopDetails["<?= $row['shop_name']; ?>"] = {
        bad_service: <?= $row['bad_service_count']; ?>,
        high_price: <?= $row['high_price_count']; ?>,
        quantity_less: <?= $row['quantity_less_count']; ?>
    };
<?php
    }
?>

// Render the main graph using Chart.js
const ctx = document.getElementById('complaintGraph').getContext('2d');
const mainChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: shopNames,
        datasets: [{
            label: 'Number of Complaints',
            data: complaintCounts,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
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
        },
        onClick: (event, elements) => {
            if (elements.length > 0) {
                const index = elements[0].index;
                const shopName = shopNames[index];
                const details = shopDetails[shopName];

                // Render a new graph for the selected shop
                const detailCtx = document.getElementById('complaintGraph').getContext('2d');
                if (mainChart) mainChart.destroy(); // Destroy the previous chart
                new Chart(detailCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Bad Service', 'High Price', 'Quantity Less'],
                        datasets: [{
                            label: `Details for ${shopName}`,
                            data: [details.bad_service, details.high_price, details.quantity_less],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
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
                                text: `Complaint Details for ${shopName}`
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
    }
});
</script>

</body>
</html>