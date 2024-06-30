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
	<link rel="icon" style="border-radius: 50%;" type="image/x=icon" href="assets/images/webicon.png">
    <title>Maria's | Sales Reports</title>
</head>
<body class="body-fixed" onload="myFunction(), loadReceiptData()">
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
			<li>
				<a href="sales.php">
					<i class='bx bx-shopping-bag'></i>
					<span class="text">Sales</span>
				</a>
			</li>
			<li>
				<a href="products.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Products</span>
				</a>
			</li>
			<li class="active">
				<a href="Sales Reports.php">
					<i class='bx bxs-report bx-tada' style='color:orange' ></i>
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
					<h1>Reports</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="Sales Reports.php">Sales Reports</a>
						</li>
					</ul>
				</div>
			</div>
        <!-- CONTENT -->
		<div class="rcontainer">
			 <!-- Print and Delete buttons -->
			 <button onclick="printTable()">Print Table</button>
			 <button onclick="resetTable()">Delete Table</button>
			<table id="receiptTable">
				<thead>
					<tr>
						<th data-label="Transaction ID">Transaction ID</th>
						<th data-label="Transaction Date">Transaction Date</th>
						<th data-label="Customer Name">Customer Name</th>
						<th data-label="Gross Amount">Gross Amount</th>
						<th data-label="Gain">Interest</th>
						<th data-label="Cash Rendered">Cash Rendered</th>
						<th data-label="Amount">Change</th>
						<th data-label="Sold Products">Sold Products</th>
					  </tr>
				</thead>
				<tbody>
					<!-- Receipt data will be inserted here -->
				</tbody>
				<tfoot>

				</tfoot>
			</table>
			<script>
	// Function to check if a transaction ID already exists in the table
function transactionExists(transactionId) {
    const tableBody = document.getElementById('receiptTable').querySelector('tbody');
    const rows = tableBody.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        if (rows[i].cells[0].textContent === transactionId) {
            return true;
        }
    }
    return false;
}
// Function to load receipt data into the table
function loadReceiptData() {
    // Retrieve the existing table data from local storage
    const existingTableData = localStorage.getItem('tableData') || '';
    console.log('Existing Table Data:', existingTableData); // Debugging statement

    // Set the innerHTML of the table body to the existing data
    const tableBody = document.getElementById('receiptTable').querySelector('tbody');
    tableBody.innerHTML = existingTableData;

    // Retrieve receipt data from local storage or other source
    const transactionId = localStorage.getItem('transactionId');
    const currentDateTime = localStorage.getItem('currentDateTime');
    const customerName = localStorage.getItem('customerName');
    const totalAmount = localStorage.getItem('totalAmount');
	const totalProfit = localStorage.getItem('totalProfit');
    const cashRendered = localStorage.getItem('cashRendered');
    const change = localStorage.getItem('change');
    const productsList = localStorage.getItem('productsList');

    console.log('New Transaction Data:', transactionId, currentDateTime, customerName, totalAmount, cashRendered, change, productsList, totalProfit); // Debugging statement

    // Check if the transaction data exists and is not already in the table
    if (transactionId && currentDateTime && customerName && totalAmount && cashRendered && change && productsList && totalProfit && !transactionExists(transactionId)) {
        console.log('Adding new transaction to the table'); // Debugging statement

        // Create a new row with the receipt data
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${transactionId}</td>
            <td>${currentDateTime}</td>
            <td>${customerName}</td>
            <td>${totalAmount}</td>
			<td>${totalProfit}</td>
            <td>${cashRendered}</td>
            <td>${change}</td>
            <td>${productsList}</td>
			
        `;

        // Append the new row to the existing table body
        tableBody.appendChild(newRow);

        // Update the local storage with the new table data
        localStorage.setItem('tableData', tableBody.innerHTML);
    } else {
        console.log('Transaction already exists or data is missing'); // Debugging statement
    }

    // Check if there is data in the table before calculating totals
    if (tableBody.innerHTML.trim() !== '') {
        calculateTotals();
    } else {
        // If there is no data, clear the totals
        clearTotals();
    }
}


// Function to clear totals from the total row
function clearTotals() {
    const tableFoot = document.getElementById('receiptTable').querySelector('tfoot');
    tableFoot.innerHTML = ''; // Clear the total row
}
// Function to calculate and display totals in a new row
function calculateTotals() {
    const tableBody = document.getElementById('receiptTable').querySelector('tbody');
    const tableFoot = document.getElementById('receiptTable').querySelector('tfoot');
    const rows = tableBody.getElementsByTagName('tr');
    let totalAmountSum = 0;
    let cashRenderedSum = 0;
    let changeSum = 0;

    // Regular expression to match numerical values
    const numberPattern = /-?\d+(\.\d+)?/g;

    // Sum up the totals from each row
    for (let i = 0; i < rows.length; i++) {
        // Extract and sum the numerical values for Total Amount
        let totalAmountMatches = rows[i].cells[3].textContent.match(numberPattern);
        if (totalAmountMatches) {
            totalAmountSum += parseFloat(totalAmountMatches.join(''));
        }

        // Extract and sum the numerical values for Cash Rendered
        let cashRenderedMatches = rows[i].cells[4].textContent.match(numberPattern);
        if (cashRenderedMatches) {
            cashRenderedSum += parseFloat(cashRenderedMatches.join(''));
        }

        // Extract and sum the numerical values for Change
        let changeMatches = rows[i].cells[5].textContent.match(numberPattern);
        if (changeMatches) {
            changeSum += parseFloat(changeMatches.join(''));
        }
    }

    // Create a new row for the totals
    const totalRow = document.createElement('tr');
    totalRow.innerHTML = `
        <td colspan="3">Total</td>
        <td><strong>PHP ${totalAmountSum.toFixed(2)}</strong></td>
        <td><strong>PHP ${cashRenderedSum.toFixed(2)}</strong></td>
        <td colspan="3"></td>
    `;

    // Clear any existing total row
    tableFoot.innerHTML = '';
    // Append the total row to the table foot
    tableFoot.appendChild(totalRow);
}

function printTable() {
  const printContents = document.getElementById('receiptTable').outerHTML;
  const originalContents = document.body.innerHTML;
  const printStyle = '<style>@media print { body { -webkit-print-color-adjust: exact; } #receiptTable { page-break-inside: avoid; width: 100%; } }</style>';

  document.body.innerHTML = printStyle + printContents;
  window.print();
  document.body.innerHTML = originalContents;
}


function resetTable() {
	alert("Delete All Transactions History?")
    localStorage.removeItem('tableData');
    localStorage.removeItem('transactionId');
    localStorage.removeItem('currentDateTime');
    localStorage.removeItem('customerName');
    localStorage.removeItem('totalAmount');
    localStorage.removeItem('cashRendered');
    localStorage.removeItem('change');
    localStorage.removeItem('productsList');

    // Clear the table body
    const tableBody = document.getElementById('receiptTable').querySelector('tbody');
    tableBody.innerHTML = '';

    // Clear the totals visually by updating the total row
    const tableFoot = document.getElementById('receiptTable').querySelector('tfoot');
    tableFoot.innerHTML = `
        <tr>
            <td colspan="3">Total</td>
            <td>0.00</td>
            <td>0.00</td>
            <td>0.00</td>
            <td></td> <!-- Empty cell for the product list column -->
        </tr>
    `;
}


	</script>
		</div>
        
		</main>
	</section>

</div>
	
	<script src="assets/js/script.js"></script>
	<script src="assets/js/main.js"></script>

	<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>