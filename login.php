<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Login</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <h1 class="h3 mb-4">
                        Student Login
                    </h1>

                    <form method="post">

                        <div class="mb-3">

                            <label class="form-label">
                                User ID
                            </label>

                            <input
                                class="form-control"
                                name="user_id"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                class="form-control"
                                name="password"
                                type="password"
                                required>

                        </div>

                        <button
                            class="btn btn-primary w-100"
                            type="submit">

                            Login

                        </button>

                    </form>

                    <p class="text-center mt-3">

                        Need an account?

                        <a href="register.php">
                            Register Here
                        </a>

                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>