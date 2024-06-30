<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <form>
                <!-- ID -->
                <label for="id">Your ID</label>
                <input type="text" id="id" placeholder="236975">
                
                <!-- Password -->
                <label for="password">Your password</label>
                <input type="password" id="password" placeholder="********">
                
                <button type="submit">Log in</button>
            </form>

            <!-- Forget Password Link -->
            <a id="pass-link" href="#"><u>Forget your password?</u></a>
            <hr id="brown-line">

            <!-- Don't have an account? -->
            <p>Don't have an account? <a href="#"><u>Sign up</u></a> </p> 
        </section>
    </main>
</body>
</html>
