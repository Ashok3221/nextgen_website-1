<?php
session_start();

$servername = "localhost";
$username = "u117947056_ngcourse";
$password = "Ngcourse@2024";
$database = "u117947056_ngcourse";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT name, mobile, balance, referred_by FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $mobile = $row['mobile'];
        $balance = $row['balance'];
        $referred_by = $row['referred_by'];

        // Fetch referring user details
        $referring_user_sql = "SELECT name, mobile FROM users WHERE refer_code='$referred_by'";
        $referring_user_result = $conn->query($referring_user_sql);

        if ($referring_user_result->num_rows > 0) {
            $referring_user_row = $referring_user_result->fetch_assoc();
            $referring_user_name = $referring_user_row['name'];
            $referring_user_mobile = $referring_user_row['mobile'];
        }
    }
} else {
    header("Location: login.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
         /* Hide the spinner */
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
        .container  {
            background:white;
            max-width: 600px;
            height: auto;
            margin: 0 auto;
            padding:55px;
            border: 2px solid #9de45f;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top:120px;
        }
        .container h4 {
            text-align: center;
            color:black;
            font-size:20px;
            font-weight: bold;
            margin-left:120px;
            white-space: nowrap;
            padding:20px;
        }
        @media (max-width: 768px) {

            .container h4 {
            text-align: center;
            color:black;
            font-size:17px;
            font-weight: bold;
            margin-left:10px;
            white-space: nowrap;
            padding:20px;
        }
}
    </style>
</head>
<body>
<div class="container">
    <h4 style="background:blue; color: white; height: 60px; width: 250px; border-radius: 50px; border: none;">Your Friends Details </h4>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            <table class="table table-borderless">
                <thead>
                    <tr>
                       <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($referring_user_name) && isset($referring_user_mobile)): ?>
                        <tr>
                        <td>1</td>
                            <td><?php echo $referring_user_name; ?></td>
                            <td><?php echo $referring_user_mobile; ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <br>
</div>

</body>
</html>


