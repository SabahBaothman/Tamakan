<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon icon-->
	<link rel="shortcut icon" type="images/x-icon" href="../images/blueLogo.ico" />
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="login-nav">
        <img id="logo" src="../images/logo.png" alt="Logo" width="80">
    </nav>

    <main class="login-page">
        <section class="login-form">
            <h1>تسجيل دخول جامعة</h1>
            <form method="post" action="../backend/loginBackend.php">
                <!-- ID -->
                <label for="id">Your ID</label>
                <input type="text" id="id" name="id" placeholder="236975" required>

                <!-- Password -->
                <label for="password">Your password</label>
                <input type="password" id="password" name="password" placeholder="********" required>

                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>

                <button class="submit" type="submit">Log in</button>
            </form>

            

            <!-- Forget Password Link -->
            <a id="pass-link" href="#"><u>Forget your password?</u></a>
            <hr id="brown-line">

            <!-- Don't have an account? -->
            <!-- <p>Don't have an account? <a href="#"><u>Sign up</u></a> </p> -->
        </section>
    </main>
</body>
</html>
