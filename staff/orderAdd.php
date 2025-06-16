<?php
include("../dbconnect.php");

// Initialize variables
$name = $email = $contact = $address = $product_id = $quantity = '';
$order_success = false;
$errors = [];

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
    // Validate and sanitize inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    // Validation
    if (empty($name)) $errors[] = "Name is required";
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
        // Calculate total
        $total = $selected_product['price'] * $quantity;
        
        // Insert order into database
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, email, contact, address, product_id, quantity, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiid", $name, $email, $contact, $address, $product_id, $quantity, $total);
        
        if ($stmt->execute()) {
            // Update product stock
            $new_stock = $selected_product['stock'] - $quantity;
            $conn->query("UPDATE products SET stock = $new_stock WHERE id = $product_id");
            
            $order_success = true;
            $order_id = $stmt->insert_id;
            
            // Reset form fields
            $name = $email = $contact = $address = $product_id = $quantity = '';

            echo '<script>alert("Order Successful"); window.location.href = "orderRead.php";</script>';
        exit();
        } else {
            $errors[] = "Error processing order: " . $conn->error;
        }
    }
}
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
    <div class="container">
        <h1>Product Order Form</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="contact">Contact Number:</label>
                 <input type="tel" pattern="^\d{11}$" name="contact" class="form-control" placeholder="09#########" required oninput="validateNumber(this)" />
            </div>
            
            <div class="form-group">
                <label for="address">Shipping Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="product_id">Select Product:</label>
                <select id="product_id" name="product_id" required>
                    <option value="">-- Select a Product --</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?php echo $product['id']; ?>" 
                            <?php if ($product_id == $product['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($product['name']); ?> - 
                            $<?php echo number_format($product['price'], 2); ?> 
                            (<?php echo $product['stock']; ?> in stock)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" value="<?php echo $quantity ? htmlspecialchars($quantity) : '1'; ?>" required>
            </div>
            
            <button type="submit">Place Order</button>
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
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>