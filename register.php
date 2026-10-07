<?php

require_once "Database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = trim($_POST["user_id"] ?? "");
    $fullName = trim($_POST["full_name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if (
        $userId === "" ||
        $fullName === "" ||
        $phone === "" ||
        $email === "" ||
        $password === ""
    ) {

        $message = "All fields are required.";

    } elseif (!filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    )) {

        $message = "Enter a valid email address.";

    } elseif ($password !== $confirmPassword) {

        $message = "Passwords do not match.";

    } else {

        $db = (new Database())->connect();

        $check = $db->prepare(
            "SELECT id FROM users
             WHERE user_id = ? OR email = ?"
        );

        $check->bind_param(
            "ss",
            $userId,
            $email
        );

        $check->execute();

        $check->store_result();

        if ($check->num_rows > 0) {

            $message =
                "User ID or email already exists.";

        } else {

            $passwordHash =
                password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

            $stmt = $db->prepare(
                "INSERT INTO users
                (user_id,
                 full_name,
                 phone,
                 email,
                 password_hash)
                 VALUES (?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "sssss",
                $userId,
                $fullName,
                $phone,
                $email,
                $passwordHash
            );

            if ($stmt->execute()) {

                $message =
                    "Registration successful.";

            } else {

                $message =
                    "Registration failed.";

            }

            $stmt->close();
        }

        $check->close();

        $db->close();
    }
}

?>

<!doctype html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width,
                   initial-scale=1">

    <title>Student Registration</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-md-7 col-lg-6">

<div class="card shadow-sm">

<div class="card-body p-4">

<h1 class="h3 mb-4">
    Student Registration
</h1>

<?php if ($message !== ""): ?>

<div class="alert alert-info">

    <?= htmlspecialchars($message) ?>

</div>

<?php endif; ?>

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
    Full Name
</label>

<input
    class="form-control"
    name="full_name"
    required>

</div>


<div class="mb-3">

<label class="form-label">
    Phone Number
</label>

<input
    class="form-control"
    name="phone"
    type="tel"
    required>

</div>


<div class="mb-3">

<label class="form-label">
    Email Address
</label>

<input
    class="form-control"
    name="email"
    type="email"
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


<div class="mb-3">

<label class="form-label">
    Confirm Password
</label>

<input
    class="form-control"
    name="confirm_password"
    type="password"
    required>

</div>


<button
    class="btn btn-primary w-100"
    type="submit">

    Register

</button>

</form>


<p class="text-center mt-3">

Already registered?

<a href="login.php">
    Login
</a>

</p>

</div>
</div>
</div>
</div>
</div>

</body>

</html>