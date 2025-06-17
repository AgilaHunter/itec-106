<?php
include("../dbconnect.php");

// Initialize variables
$customer_name = $email = $contact = $address = $product_id = $quantity = '';
$order_success = false;
$errors = [];
$cid = ''; // Ensure $cid is initialized

// Fetch products from database
$products = [];
$sql = "SELECT id, name, price, stock FROM products WHERE stock > 0";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name']);
    $name = $customer_name; 
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Validation
    if (empty($customer_name)) $errors[] = "Name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($contact)) $errors[] = "Contact number is required";
    if (empty($address)) $errors[] = "Address is required";
    if ($product_id <= 0) $errors[] = "Please select a product";
    if ($quantity <= 0) $errors[] = "Quantity must be at least 1";

    // Check product availability
    $product_available = false;
    foreach ($products as $product) {
        if ($product['id'] == $product_id && $product['stock'] >= $quantity) {
            $product_available = true;
            $selected_product = $product;
            break;
        }
    }
    if (!$product_available) $errors[] = "Selected product is not available in the requested quantity";

    // If no errors, process order
    if (empty($errors)) {
        $total = $selected_product['price'] * $quantity;

        // Check if customer exists
        $stmt = $conn->prepare("SELECT c_id FROM customer WHERE c_fullname = ? AND c_email = ?");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $customer = $result->fetch_assoc();
            $cid = $customer['c_id'];
        } else {
            // Insert new customer
            $stmt = $conn->prepare("INSERT INTO customer (c_fullname, c_email, c_contact, c_address) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $customer_name, $email, $contact, $address);
            $stmt->execute();
            $cid = $stmt->insert_id;
        }

        // Insert order
        $stmt = $conn->prepare("INSERT INTO orders (cid, customer_name, email, contact, address, product_id, quantity, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssiid", $cid, $customer_name, $email, $contact, $address, $product_id, $quantity, $total);

        if ($stmt->execute()) {
            // Update stock
            $new_stock = $selected_product['stock'] - $quantity;
            $conn->query("UPDATE products SET stock = $new_stock WHERE id = $product_id");

            echo '<script>alert("Order Successful"); window.location.href = "orderRead.php";</script>';
            exit();
        } else {
            $errors[] = "Error processing order: " . $conn->error;
        }
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="../bootstrap-5.0.2-dist\css\bootstrap.min.css">
    <script type="text/javascript" src="../bootstrap-5.0.2-dist\js\bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../assets/forms.css">
    <title>Product Ordering System</title>
</head>
<body>
    <div class="dashboard-wrapper p-2">
        <div class="card shadow">
            <div class="container p-3">
                <span class="rounded-circle p-1 d-inline-flex justify-content-center align-items-center bg-transparent shadow-sm" style="background-color: #493D9E; width: 50px; height: 50px;">
                    <a href="orderRead.php"><i class="fa fa-arrow-left" aria-hidden="true"></a></i> 
                </span>
                <div class="container p-3 mt-5 mb-5" style="background-color: #f7f3ff; border-radius: 5px;">
                    <h5>Add Order</h5>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="error">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="#" method="POST">


                    <h5 class="divider">Details</h5>

                    <!-- Customer No. -->
                    <label>Customer ID</label>
                    <input type="text" id="cid1" class="form-control mb-3" disabled>
                    <input type="hidden" id="cid" value="<?php echo htmlspecialchars($cid); ?>" name="cid">

                    <!-- Fullname -->
                    <label for="customer_name">Full Name</label>
                    <input type="text" id="customer_name" name="customer_name" class="form-control mb-3" value="<?php echo htmlspecialchars($customer_name); ?>" required>
                    
                    <!-- Email -->
                    <label>Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required><br>

                    <!-- Contact -->
                    <label>Contact Number</label>
                    <input type="tel" pattern="^\d{11}$" name="contact" class="form-control" placeholder="09#########" required oninput="validateNumber(this)" /><br>

                    <!-- address -->
                    <label for="address">Shipping Address:</label>
                    <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($address); ?>" required>
                    <br>

                    <!-- product -->
                    <label for="product_id">Select Product:</label>
                    <select id="product_id" name="product_id" class="form-control" required>
                        <option value="">-- Select a Product --</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?php echo $product['id']; ?>" 
                                <?php if ($product_id == $product['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($product['name']); ?> - 
                                ₱<?php echo number_format($product['price'], 2); ?> 
                                (<?php echo $product['stock']; ?> in stock)
                            </option>
                        <?php endforeach; ?>
                    </select><br>

                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" class="form-control" value="<?php echo $quantity ? htmlspecialchars($quantity) : '1'; ?>" required><br>

                    <!-- Submit -->
                    <input type="submit" id="placeorder" name="placeorder" value="Place Order" class="btn btn btn col-12">
                </form>   

                <?php if (!empty($selected_product) && !$order_success): ?>
                    <div class="product-info">
                        <h3>Order Summary</h3>
                        <p>Product: <?php echo htmlspecialchars($selected_product['name']); ?></p>
                        <p>Price: $<?php echo number_format($selected_product['price'], 2); ?></p>
                        <p>Quantity: <?php echo $quantity; ?></p>
                        <p><strong>Total: $<?php echo number_format($selected_product['price'] * $quantity, 2); ?></strong></p>
                    </div>
                <?php endif; ?>

    <!-- Fontawesome Bundle -->
    <script src="https://kit.fontawesome.com/0b5cc4708b.js" crossorigin="anonymous"></script>

</body>
</html>

