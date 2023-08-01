<?php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $order = $_POST['order'];
    $additionalFood = $_POST['additionalFood'];
    $quantity = $_POST['quantity'];
    $dateAndTime = $_POST['dateAndTime'];
    $address = $_POST['address'];
    $message = $_POST['message'];

    // Read existing orders data from orders.json
    $ordersData = file_get_contents('data/orders.json');
    $ordersArray = json_decode($ordersData, true);

    // Add the new order to the array
    $newOrder = array(
        'name' => $name,
        'email' => $email,
        'order' => $order,
        'additionalFood' => $additionalFood,
        'quantity' => $quantity,
        'dateAndTime' => $dateAndTime,
        'address' => $address,
        'message' => $message
    );

    $ordersArray[] = $newOrder;

    // Convert the array back to JSON
    $newOrdersData = json_encode($ordersArray, JSON_PRETTY_PRINT);

    // Save the updated data to orders.json
    file_put_contents('orders.json', $newOrdersData);

    // Send email confirmation
    $to = 'mahfuztamim1907@gmail.com'; 
    $subject = 'Order Confirmation';
    $message = "
        <h1>Thank you for your order!</h1>
        <p>Your order has been received and is being processed. We will deliver it to the provided address soon.</p>
        <p>Order details:</p>
        <p>Name: $name</p>
        <p>Order: $order</p>
        <p>Additional Food: $additionalFood</p>
        <p>Quantity: $quantity</p>
        <p>Date and Time: $dateAndTime</p>
        <p>Address: $address</p>
        <p>Message: $message</p>
    ";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: mahfuztamim1907@gmail.com"; 
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Order received successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error sending email.']);
    }
}
