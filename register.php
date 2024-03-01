<?php
session_start();

$servername = "localhost";
$username = "u117947056_ngcourse";
$password = "Ngcourse@2024";
$database = "u117947056_ngcourse";

$conn = new mysqli($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $referred_by = isset($_POST['referred_by']) ? $_POST['referred_by'] : '';


    $check_query = "SELECT * FROM users WHERE mobile='$mobile'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Mobile number is already registered. Please use a different mobile number.');</script>";
    } else {
        $sql_query = "INSERT INTO users (name, email, mobile, location, password, referred_by) 
                      VALUES ('$name','$email', '$mobile', '$location', '$password', '$referred_by')";
        
        if ($conn->query($sql_query) === TRUE) {
            $user_id = $conn->insert_id;

            $refer_code = '';
            if (empty($referred_by)) {
                $refer_code = 'MAIN_REFER' . $user_id; 
            } else {
                $admincode = substr($referred_by, 0, -5); 
                $sql = "SELECT refer_code FROM admin WHERE refer_code='$admincode'";
                $result = $conn->query($sql);
                $num = $result->num_rows;
                if ($num >= 1) {
                    $refer_code = $admincode . $user_id;
                } else {
                    $refer_code = 'CMDS' . $user_id;
                }
            }

            $sql_query_refer = "UPDATE users SET refer_code='$refer_code' WHERE id = $user_id";
            $conn->query($sql_query_refer);

            echo "<script>alert('New record created successfully');</script>";
            echo "<script>window.location.href='login.php';</script>";
            exit();
        } else {
            echo "Error: " . $sql_query . "<br>" . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <style>
         input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(
        to right,
        #6f5de5,
        #7497f3,
        #62d2e8
    );
        }
        .container {
            background: rgb(255, 255, 255);
            max-width: 400px; 
            margin: 0 auto;
            padding: 40px;
            border: 2px solid #9de45f;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
        .container h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #40e95c;
            border-radius: 10px;
        }
        .btn {
            width: 50%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 15px;
            color: #fff;
            cursor: pointer;
            margin-top: 20px; 

        }
        .btn:hover {
            background-color: #0056b3;
        }

        .register-btn {
            width: 48%; 
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 15px;
            color: #fff;
            cursor: pointer;
            margin-top:-35px;
            float: right; 
        }
        p{
            width: 48%; 
            padding: 10px;
            margin-top:-70px;
            float: right; 
            font-size: 12px;
            position: relative;
            left:40px;
            white-space: nowrap;
        }
        @media (max-width: 768px) {

            p{
            width: 48%; 
            padding: 10px;
            margin-top:-70px;
            float: right; 
            font-size: 10px;
            position: relative;
            left:25px;
            white-space: nowrap;
        }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="post" action="#" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="email" required>
            </div>
            <div class="form-group">
                <label for="mobile">Phone Number:</label>
                <input type="number" id="mobile" name="mobile" placeholder="Phone Number" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" placeholder="Location" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="password" required>
            </div>
            <div class="form-group">
                <label for="referred_by"> Referred By</label>
                <input type="text" id="referred_by" name="referred_by" placeholder="Referred By" required>
            </div>
            <button class="btn signin" name="btnAdd">Register</button>
            <p>Already have an account</p>
            <a href="login.php" ><button type="button"  class="btn register-btn">Login</button></a>
        </form>
    </div>
</body>
</html>
