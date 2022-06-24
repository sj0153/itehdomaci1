<?php

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}

require_once "config.php";


$username = $password = "";
$username_error = $password_error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_error = "Unesite vaše korisničko ime.";
    } else {
        $username = trim($_POST["username"]);
    }
    if (empty(trim($_POST["password"]))) {
        $password_error = "Unesite vašu šifru.";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty($username_error) && empty($password_error)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = $username;
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            header("location: home.php");
                        } else {
                            $password_error = "Uneli ste neispravnu šifru.";
                        }
                    }
                } else {
                    $username_error = "Ne postoji to korisničko ime.";
                }
            } else {
                echo '<script type="text/javascript">alert("Došlo je do greške!"); 
            window.location.href = "http://localhost/itehdomaci1/login.php";</script>';
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Prijava</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon-01.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
    <div class="w3-row">
        <div class="w3-third w3-container">
        </div>
        <div class="w3-third w3-container">
            <div id="formContent">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h1 style="text-align:center">Prijava</h1>
                    <br>
                    <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>" style="margin-left:10%; margin-right:-40%">
                        <label style="color:black">Korisničko ime</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_error; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>" style="margin-left:10%; margin-right:-40%">
                        <label style="color:black">Šifra</label>
                        <input type="password" name="password" class="form-control">
                        <span class="help-block"><?php echo $password_error; ?></span>
                    </div>
                    <div class="form-group" style="margin-left:43%; margin-right:-40%">
                        <input id="dugme" type="submit" class="w3-button w3-round-large w3-hover-blue w3-black" style="background:#33bca5" value="Prijava">
                    </div>
                    <p style="text-align:center; color:black">Nemaš nalog? <a href="register.php">Registruj se ovde</a>.</p>
                </form>
            </div>
        </div>
        <div class="w3-third w3-container">
        </div>
    </div>
</body>

</html>