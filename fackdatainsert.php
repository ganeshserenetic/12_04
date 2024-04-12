<?php

// Function to generate a random string
function generateRandomString($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

// Function to generate fake data and insert into the database
function generateFakeData($numRows) {
    $servername = "localhost";
    $username = "root"; // Your MySQL username
    $password = ""; // Your MySQL password
    $dbname = "structure_task_project"; // Your MySQL database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Generate and insert fake data
    for ($i = 0; $i < $numRows; $i++) {
        $firstname = generateRandomString(8);
        $lastname = generateRandomString(8);
        $email = $firstname . "@example.com";
        $password = password_hash("password123", PASSWORD_DEFAULT); // You should hash passwords for security
        $gender = rand(0, 1) ? 'Male' : 'Female';
        $phonenumber = '1234567890';
        $tems = generateRandomString(5);
        $date_created = date('Y-m-d H:i:s');
        $is_deleted = rand(0, 1);

        $sql = "INSERT INTO users (firstname, lastname, email, password, gender, phonenumber, tems, date_created, is_deleted) 
                VALUES ('$firstname', '$lastname', '$email', '$password', '$gender', '$phonenumber', '$tems', '$date_created', $is_deleted)";

        if ($conn->query($sql) === TRUE) {
            echo "Record inserted successfully<br>";
        } else {
            echo "Error inserting record: " . $conn->error . "<br>";
        }
    }

    // Close connection
    $conn->close();
}

// Generate 10 fake records
generateFakeData(10);
?>
