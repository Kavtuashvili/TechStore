<?php
session_start();
include("includes/db.php");
include("includes/navbar.php");

$error = "";

/* 📌 LOGIN LOGIC */
if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(empty($email) || empty($password)){
        $error = "All fields are required";
    } else {

        /* 📌 FIND USER */
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = $result->fetch_assoc();

        /* ❌ USER NOT FOUND */
        if(!$user){
            $error = "Invalid email or password";
        } 
        /* 🔐 CHECK PASSWORD */
        else if(!password_verify($password, $user['password'])){
            $error = "Invalid email or password";
        } 
        /* ✅ LOGIN SUCCESS */
        else {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            /* 🔥 REDIRECT BASED ON ROLE */
            if($user['role'] == 'admin'){
                header("Location: admin/orders.php");
            } else {
                header("Location: index.php");
            }
            exit();
        }
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="login-page">

<div class="login-wrapper">

    <!-- LEFT SIDE -->
    <div class="login-left">
        <div class="left-content">
            <h1>TechStore</h1>
            <p>
                Sign in to view your orders, manage your cart, and get the best tech deals in one place.
            </p>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="login-right">

        <div class="login-box">

            <div class="form-header">
                <h2>Welcome Back</h2>
                <p>Continue your shopping experience</p>
            </div>

            <?php if(!empty($error)): ?>
                <div class="error-box"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">

                <input type="email" name="email" placeholder="Email address" required>

                <input type="password" name="password" placeholder="Password" required>

                <button type="submit" name="login">Continue</button>

            </form>

            <p class="small-text">
                New here? <a href="signup.php">Create account</a>
            </p>

        </div>

    </div>

</div>
<?php include("includes/footer.php"); ?>
</body>
</html>