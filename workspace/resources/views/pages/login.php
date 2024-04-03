<!DOCTYPE html>
<html lang="vi">

<head>
    <?php partial("head.php", compact("seo")) ?>

    <style>
        .login-form {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            width: 520px;
            max-width: 100vw;
            box-shadow: var(--bs-box-shadow);
            padding: 40px 24px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <form method="post" class="login-form">
        <div class="form-container">
            <div class="mb-4">
                <h1 class="text-center">Welcome Back</h1>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label required">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="name@example.com">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label required">Password</label>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password here">
                    <button class="btn btn-outline-secondary" type="button" id="toggle-show-password" data-show-icon="bi bi-eye-fill" data-hide-icon="bi bi-eye-slash-fill">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <button name="login" type="button" class="btn btn-primary w-100">Login</button>
            </div>
        </div>
    </form>

    <?php partial("scripts.php") ?>
</body>

</html>