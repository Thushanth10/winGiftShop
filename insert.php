<?php
// Include the database connection file
include 'db.php'; // Ensure this file has your database connection code

$successMessage = ""; // Initialize a variable to hold success message
$errorMessage = ""; // Initialize a variable to hold error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $address = trim($_POST['address']);
    $tel_num = trim($_POST['tel_num']);

    // Validate input
    if (!empty($first_name) && !empty($last_name) && !empty($address) && !empty($tel_num)) {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO deliveries (first_name, last_name, address, tel_num) VALUES (?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ssss", $first_name, $last_name, $address, $tel_num);

            // Execute the statement
            if ($stmt->execute()) {
                $successMessage = "Your order has been placed successfully.";
            } else {
                $errorMessage = "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            $errorMessage = "Error preparing statement: " . $conn->error;
        }
    } else {
        $errorMessage = "Please fill in all fields.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <h2>Order Confirmation</h2>
        <!-- Display success or error message -->
        <?php if (!empty($successMessage)): ?>
            <div style="color: green; margin-top: 20px;"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <div style="color: red; margin-top: 20px;"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

       
    </center>
</body>
</html>
