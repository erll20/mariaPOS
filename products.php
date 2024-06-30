<?php
session_start();
require 'includes/dbh.inc.php';

// Assuming the user's ID is stored in the session
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$firstName = 'Guest';
$lastName = '';

if ($userId) {
    $stmt = $pdo->prepare("SELECT firstname, lastname FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $firstName = $user['firstname'];
        $lastName = $user['lastname'];
    }
}

function fetchProducts($pdo) {
    $stmt = $pdo->query("SELECT * FROM products");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$products = fetchProducts($pdo);
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
    <title>Maria's | Products</title>
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
			<li>
				<a href="sales.php">
					<i class='bx bx-shopping-bag'></i>
					<span class="text">Sales</span>
				</a>
			</li>
			<li class="active">
				<a href="products.php">
					<i class='bx bxs-doughnut-chart bx-spin' style='color:orange' ></i>
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
			<h1>Welcome, <?php echo htmlspecialchars($firstName . ' ' . $lastName); ?>!</h1>
				<div style="font-size: smaller;" class="user-info">
					<span style="border-style: solid; border-top: 10px; border-bottom: 10px; border-color: orange; padding: 6px;"  id="date-time"></span>
				  </div>
        </nav>
		
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Product Management</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="products.php">Products</a>
						</li>
					</ul>
				</div>
			</div>
        <!-- CONTENT -->
		<div class="container">
			<div class="total-products">Total Products: <span id="totalProducts">0</span></div>
			<input type="text" id="searchInput" onkeyup="searchProduct()" placeholder="Search for product name...">
			<table id="productsTable" class="responsive-table">
				<thead>
					<tr>
						<th>Product Name</th>
						<th>Description</th>
						<th>Original Price</th>
						<th>Selling Price</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($products as $product): ?>
                        <tr data-id="<?php echo $product['id']; ?>">
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><?php echo htmlspecialchars($product['original_price']); ?></td>
                            <td><?php echo htmlspecialchars($product['selling_price']); ?></td>
                            <td>
                                <button onclick="editProduct(<?php echo $product['id']; ?>)">Edit</button>
                                <button onclick="deleteProduct(<?php echo $product['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
				</tbody>
			</table>
			<button id="showAddProductFormButton">Add More Products <i id="arrowIcon" class="bx-down-arrow"></i></button>
			<div id="addProductForm">
			<!-- Your form fields for product name, description, selling price, original price -->
			<input type="text" name=name id="productName" placeholder="Product Name">
			<input type="text" name=description id="productDescription" placeholder="Product Description">
			<input type="number" name=ogprice id="productOgprice" placeholder="Original Price">
			<input type="number" name=price id="productPrice" placeholder="Selling Price">
			<button id="addButton" onclick="addProduct()">Save Changes</button>
			</div>

		</main>
	</section>

</div>


    <script src="assets/js/add products.js"></script>
    <script src="assets/js/main.js"></script>
	<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
	<script>
        document.getElementById('showAddProductFormButton').addEventListener('click', () => {
            const form = document.getElementById('addProductForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });

        function addProduct() {
            const name = document.getElementById('productName').value;
            const description = document.getElementById('productDescription').value;
            const originalPrice = document.getElementById('productOgprice').value;
            const sellingPrice = document.getElementById('productPrice').value;

            fetch('products.save.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `name=${name}&description=${description}&ogprice=${originalPrice}&price=${sellingPrice}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Product added successfully');
                    location.reload(); // Reload the page to see the new product
                } else {
                    alert('Error adding product: ' + data.message);
                }
            });
        }

        function editProduct(productId) {
            const row = document.querySelector(`tr[data-id='${productId}']`);
            const name = row.children[0].textContent;
            const description = row.children[1].textContent;
            const originalPrice = row.children[2].textContent;
            const sellingPrice = row.children[3].textContent;

            document.getElementById('productName').value = name;
            document.getElementById('productDescription').value = description;
            document.getElementById('productOgprice').value = originalPrice;
            document.getElementById('productPrice').value = sellingPrice;

            document.getElementById('addButton').onclick = function() {
                updateProduct(productId);
            };

            document.getElementById('addProductForm').style.display = 'block';
        }

        function updateProduct(productId) {
            const name = document.getElementById('productName').value;
            const description = document.getElementById('productDescription').value;
            const originalPrice = document.getElementById('productOgprice').value;
            const sellingPrice = document.getElementById('productPrice').value;

            fetch('products.update.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${productId}&name=${name}&description=${description}&ogprice=${originalPrice}&price=${sellingPrice}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Product updated successfully');
                    location.reload(); // Reload the page to see the updated product
                } else {
                    alert('Error updating product: ' + data.message);
                }
            });
        }

        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch('products.delete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product deleted successfully');
                        location.reload(); // Reload the page to see the changes
                    } else {
                        alert('Error deleting product: ' + data.message);
                    }
                });
            }
        }

		function searchProduct() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const table = document.getElementById('productsTable');
            const rows = table.getElementsByTagName('tr');
            let visibleCount = 0;

            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
                const cells = rows[i].getElementsByTagName('td');
                let match = false;

                for (let j = 0; j < cells.length - 1; j++) { // Skip the last cell (actions)
                    if (cells[j].textContent.toLowerCase().includes(input)) {
                        match = true;
                        break;
                    }
                }

                if (match) {
                    rows[i].style.display = '';
                    visibleCount++;
                } else {
                    rows[i].style.display = 'none';
                }
            }

            document.getElementById('totalProducts').textContent = visibleCount;
        }
    </script>
</body>
</html>