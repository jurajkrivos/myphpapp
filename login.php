<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">



<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                header("Location: index.php");
                exit();
            } else {
                $message = "Zlé heslo.";
            }
        } else {
            $message = "Používateľ neexistuje.";
        }
    } else {
        $message = "Vyplň všetky polia.";
    }
}
?>





    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="mb-4 text-center">Prihlásenie</h2>

                        <?php if ($message != "") { ?>
                            <div class="alert alert-danger"><?php echo $message; ?></div>
                        <?php } ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Heslo</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-success w-100">Prihlásiť sa</button>
                        </form>

                        <p class="mt-3 text-center mb-0">Nemáš účet? <a href="register.php">Zaregistruj sa</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
