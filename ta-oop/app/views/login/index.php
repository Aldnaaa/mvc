<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <script src="../public/assets/js/color-modes.js"></script>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors"/>
    <meta name="generator" content="Hugo 0.118.2"/>
    <title>simacan</title>
    <link rel="icon" href="../public/assets/img/favicons/favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3"/>

    <link href="../public/assets/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="../public/assets/style/sign-in.css" rel="stylesheet"/>
</head>
<body class="d-flex align-items-center justify-content-center bc-navy">
<main class="form-signin">
    <form class="wrap py-4 px-5 rounded-4" style="width: 30rem" action ="<?= BASEURL; ?>/login/signIn" method="post">
        <div class="d-flex justify-content-center align-items-center mb-4">
            <img src="../public/assets/image/logo.png" alt="logo" class="img-fluid me-0 mt-2" style="height: 60px"/>
            <h4 class="h3 mt-3 color-dongker c-navy"><b>Login Simacan</b></h4>
        </div>
            <div class="form-floating mb-2">
                <input type="text" name="username" class="form-control" id="floatingInput" placeholder="name@example.com"
                       required/>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password"
                       required/>
                <label for="floatingPassword">Password</label>
            </div>
        <button class="btn bc-navy w-100 py-2 text-white mb-3" type="submit" name="btn-login">SIGN IN</button>
    </form>
</main>
<script src="../public/assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
