<?php
require 'db_connection.php';  // Make sure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (empty($username)) {
        $error = "Username cannot be empty.";
    } else {
        // Check if email already exists
        $stmt = $connection->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already exists.";
        } else {
            // Hash the password before storing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $stmt = $connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            $stmt->execute();

            // Redirect to login page
            header("Location: login.php");
            exit();
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="css/my_bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <style>
        body {
            background-size: cover;
            margin: 0;
            height: 100vh;
            width: 100vw;
            color: rgb(0, 0, 0);
            font-family: 'Roboto', sans-serif;
        }
        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
        }
        .form-control, .btn-primary {
            background-color: #292929;
            color: #ffffff;
        }
        .form-control {
            background-color: rgb(162, 162, 162);
            color: #ffffff;
            margin-left: -2px;
        }
        .form-control:focus {
            background-color: rgb(119, 119, 119);
            color: #ffffff;
            border-color: #007bff;
            box-shadow: none;
        }
        .btn-primary {
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="header finisher-header" style="width: 100%; height: 100%;">
        <div class="d-flex vh-100 align-items-center justify-content-center">
            <div class="card p-4 shadow-lg" style="width: 400px; ">
                <h2 class="text-center mb-4;" style="color:rgb(0, 0, 0);">Sign Up</h2>
                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                <form action="signup.php" method="post">
                    <div class="mb-3">
                        <label style="color:black" for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label style="color:black" for="email" class="form-label">Email</label>
                        <input type="text" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label style="color:black" for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-50">Sign Up</button>
                    <p class="text-center mt-3" style="color:rgb(0, 0, 0);">Already have an account? <a href="login.php" style="color: #007bff;">Log In</a></p>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="finisher-header.es5.min.js" type="text/javascript"></script>
<script type="text/javascript">
new FinisherHeader({
    "count": 11,
    "size": {
        "min": 1200,
        "max": 1426,
        "pulse": 1
    },
    "speed": {
        "x": {
            "min": 0,
            "max": 0.2
        },
        "y": {
            "min": 0,
            "max": 0.2
        }
    },
    "colors": {
        "background": "#c9a0f0",
        "particles": [
            "#e01f29",
            "#681332",
            "#bf38bf"
        ]
    },
    "blending": "lighten",
    "opacity": {
        "center": 0.8,
        "edge": 0.2
    },
    "skew": 0,
    "shapes": [
        "t",
        "s"
    ]
});
</script>

</html>
