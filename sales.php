<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="assets/pos style.css">
	<link rel="stylesheet" href="assets/receipt.css">
	<link rel="icon" style="border-radius: 50%;" type="image/x=icon" href="assets/images/webicon.png">
    <title>Maria's | Sales</title>
</head>
<body class="body-fixed" onload="myFunction()">
	<div id="loading"></div>



	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxl-magento bx-burst' style='color: var(--dark)' ></i>
			<span class="text">MARIA's POS</span>
		</a>
		<ul class="side-menu top">
			<li class="#">
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="active">
				<a href="sales.php">
					<i class='bx bx-shopping-bag bx-spin' style='color:orange'></i>
					<span class="text">Sales</span>
				</a>
			</li>
			<li>
				<a href="products.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Products</span>
				</a>
			</li>
			<li>
				<a href="Sales Reports.php">
					<i class='bx bxs-report' ></i>
					<span class="text">Sales Reports</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="settings.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="admin.login.php" class="logout" onclick="logout()">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<h1>Welcome!</h1>
				<div style="font-size: smaller;" class="user-info">
					<span style="border-style: solid; border-top: 10px; border-bottom: 10px; border-color: orange; padding: 6px;"  id="date-time"></span>
				  </div>
                
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Sales</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="sales.php">Sales</a>
						</li>
					</ul>
				</div>
			</div>
        <!-- CONTENT -->
		<div class="container">
			<!-- Product selection form -->
			<form id="productForm">
				<label for="productSelect" style="background: var(--light); color: var(--dark)">Select a Product:</label>
				<select id="productSelect">
					<script>
						function getProducts() {
 	  					 return JSON.parse(localStorage.getItem('products')) || [];
					}

					function populateProductSelect() {
  					  const products = getProducts();
 					   const productSelect = document.getElementById('productSelect');

   						 // Create and append the default option
						const defaultOption = document.createElement('option');
						defaultOption.value = '';
						defaultOption.textContent = 'Menu:';
						defaultOption.disabled = true;
						defaultOption.selected = true;
						productSelect.appendChild(defaultOption);

						// Append the rest of the product options
						products.forEach((product, index) => {
							const option = document.createElement('option');
							option.value = index;
							option.textContent = product.name;
							productSelect.appendChild(option);
						});
					}

						populateProductSelect();
						;					
					</script>
				</select>
				<input type="number" id="quantityInput" placeholder="Quantity">
				<button id="addButton" style="padding-bottom: 2px; padding-top: 2px;" onclick="displayProducts()")">Add</button>
			</form>
			<!-- Selected products table -->
			<table id="productTable">
				<thead>
					<tr>
						<th>Product Name</th>
						<th>Description</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total Amount</th>
						<th>Total Profit</th>
						<th>Action</th>
					</tr>

				</thead>
				<tbody>
					
				</tbody>
			</table>
			<!-- Payment button -->
			<center>
			<button style="margin-top: 10px;" id="saveButton">Save</button>
			</center>
			<button id="payButton" style="display: none;">Pay</button>
			
		</div>
<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeButton">x</span>
        <center><h2 style="color: brown" >Cash Payment</h2></center>
		<p style="font-weight: bold;" id="totalAmountDisplay"></p>
		<p style="font-size: x-small;"   id="totalProfitDisplay"></p>
        <label for="customerNameInput">Customer Name:</label>
        <input type="text" id="customerNameInput" placeholder="Name">
        <label for="cashInput">Cash Amount:</label>
        <input type="number" id="cashInput" placeholder="PHP" min="0" step="0.01">
        <center>
            <button id="finishButton">Finish</button>
            <p style="background-color: orange; color: white; margin-top: 10px;" id="changeDisplay"></p><br>
			<button onclick="addSeeReceiptButton()" id="seeReceiptButton">See Receipt</button>
		</center>
		 <!-- Receipt Modal -->
		 <div id="receiptModal" class="modal1">
			<div id="receiptWrapper">
			<div class="modal-content1">
				<span class="close" onclick="closeReceiptModal()">&times;</span>
				<center>
				<h2>Sales Receipt</h2>
				<br>
				<h2 style="font-size:x-small; padding-bottom: 10px; "><i>M A R I A S</i></h2>
				<h2 style="font-size:x-small; padding-bottom: 10px; "><i>Home of Special Pancit & Halo halo</i></center></h2><br><br>
				<div id="receiptContent"></div>
			</div>
			<button onclick="printReceipt()">Print Receipt</button>
			</div>
		</div>

		
    </div>
</div>

		</main>
	</section>

</div>
	<script src="assets/js/main.js"></script>
	<script src="assets/js/add products.js"></script>

	<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>