<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Price History</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/components.css">
   <style>
        .price-history .box-container .box 
     {
        height: 95%;
        width: 90%;
      
     }
        .show-products .box-container .box 
     {
        height: 95%;
        width: 90%;
        font-size: 2rem;
        margin: 5rem auto;
     }
        .drop-down {
            margin: 6rem auto;
            padding: 1.5rem;
            font-size: 16px;
            border-radius: 5rem;
            border: var(--border1);
            box-shadow: var(--box-shadow4);
        }
        .drop-down:focus {
            outline: none;
            border-color: var(--border1);
        }
    
        canvas {
            max-width: 100%;
            height: auto;
            font-size: 2rem;
        }
   </style>


   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="price-history">
   <h1 class="glow">Product Price History</h1>
   <select id="productSelector" class="drop-down">
      <option value="" selected disabled>Select a product</option>
      <?php
         $select_products = $conn->prepare("SELECT id, name FROM `products`");
         $select_products->execute();
         while($product = $select_products->fetch(PDO::FETCH_ASSOC)){
            echo '<option value="'.$product['id'].'">'.$product['name'].'</option>';
         }
      ?>
   </select>
   <canvas id="priceHistoryChart"></canvas>
</section>

<section class="show-products">
<div class="box-container">
   <div id="productDetails" class="box-container" style="display: none;">
      <div class="box">
         <img id="productImage" src="" alt="Product Image">
         <div class="name" id="productName"></div>
         <div class="price" id="productPrice"></div>
         <div class="category" id="productCategory"></div>
         <div class="details" id="productDetailsText"></div>
      </div>
   </div></div>
</section>

<script>
   const productSelector = document.getElementById('productSelector');
   const ctx = document.getElementById('priceHistoryChart').getContext('2d');
   let chart;

   productSelector.addEventListener('change', () => {
      const productId = productSelector.value;

      fetch(`fetch_price_history.php?product_id=${productId}`)
         .then(response => response.json())
         .then(data => {
            if (chart) {
               chart.destroy();
            }

            const labels = data.map(entry => entry.timestamp);
            const prices = data.map(entry => entry.price);

            // Fetch the current price of the product
            fetch(`fetch_product_details.php?product_id=${productId}`)
               .then(response => response.json())
               .then(product => {
                  const currentPrice = product.price;
                  Chart.defaults.font.size = 14;
                    Chart.defaults.font.family = 'Arial, sans-serif';
                    Chart.defaults.color = '#000'; // Set the default font color


                  chart = new Chart(ctx, {
                     type: 'line',
                     data: {
                        labels: labels,
                        datasets: [
                           {
                              label: 'Price History',
                              data: prices,
                              borderColor: 'rgb(118, 17, 250)',
                              borderWidth: 4,
                              fill: false
                           },
                           {
                              label: 'Current Price',
                              data: Array(labels.length).fill(currentPrice),
                              borderColor: 'rgba(255, 99, 132, 1)',
                              borderWidth: 4,
                              borderDash: [5, 5],
                              fill: false
                           }
                        ]
                     },
                     options: {
                        responsive: true,
                        plugins: {
                           legend: {
                              display: true
                           }
                        },
                        scales: {
                           x: {
                              title: {
                                 display: true,
                                 text: 'Timestamp'
                              }
                           },
                           y: {
                              title: {
                                 display: true,
                                 text: 'Price'
                              }
                           }
                        }
                     }
                  });
               });
         });

      // Fetch product details
      fetch(`fetch_product_details.php?product_id=${productId}`)
         .then(response => response.json())
         .then(product => {
            document.getElementById('productDetails').style.display = 'block';
            document.getElementById('productImage').src = `uploaded_img/${product.image}`;
            document.getElementById('productName').textContent = product.name;
            document.getElementById('productPrice').textContent = `$${product.price}`;
            document.getElementById('productCategory').textContent = `Category: ${product.category}`;
            document.getElementById('productDetailsText').textContent = product.details;
         });
   });
</script>

<script src="js/script.js"></script>

</body>
</html>