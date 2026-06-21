<?php
session_start();
include("includes/db.php");

$error = "";

/* 📌 SIGNUP LOGIC */
if(isset($_POST['signup'])){

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    /* ❗ BASIC VALIDATION */
    if(empty($username) || empty($email) || empty($password)){
        $error = "All fields are required";
    } else {

        /* 🔐 HASH PASSWORD */
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        /* 📌 CHECK IF USER EXISTS */
        $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $error = "User already exists";
        } else {

            /* 📌 INSERT USER */
            $stmt = $conn->prepare("
                INSERT INTO users (username, email, password, role)
                VALUES (?, ?, ?, 'user')
            ");

            $stmt->bind_param("sss", $username, $email, $hashedPassword);
            $stmt->execute();

            /* 🔥 AUTO LOGIN */
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['role'] = 'user';
            $_SESSION['username'] = $username;

            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="login-page">

<div class="login-wrapper">

    <!-- LEFT SIDE -->
    <div class="login-left">
        <div class="left-content">
            <h1>TechStore</h1>
            <p>
                Create your account and enjoy access to the latest tech products,
                secure orders, and exclusive offers.
            </p>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="login-right">

        <div class="login-box">

            <div class="form-header">
                <h2>Create Account</h2>
                <p>Fill in your details to get started</p>
            </div>

            <?php if($error != ""): ?>
                <div class="error-box">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <input
                    type="text"
                    name="username"
                    placeholder="Full Name"
                    required
                >

                <input
                    type="email"
                    name="email"
                    placeholder="Email Address"
                    required
                >

                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                >

                <button type="submit" name="signup">
                    Create Account
                </button>

            </form>

            <p class="small-text">
                Already have an account?
                <a href="login.php">Sign In</a>
            </p>

        </div>

    </div>

</div>
<?php include("includes/footer.php"); ?>
</body>
</html>