<?php

require_once "config.php";


$username = $password = $confirm_password = "";
$username_error = $password_error = $confirm_password_error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_error = "Unesite korisničko ime.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) { 
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $username_error = "Korisničko ime je već zauzeto!";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo '<script type="text/javascript">alert("Došlo je do greške prilikom registracije."); 
                window.location.href = "http://localhost/iteh-domaci/register.php";</script>';
            }

            $stmt->close();
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_error = "Unesite šifru.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_error = "Šifra mora imati 8 karaktera.";
    } else {
        $password = trim($_POST["password"]);
    }


    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_error = "Potvrdite vašu šifru.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_error) && ($password != $confirm_password)) {
            $confirm_password_error = "Šifre se ne poklapaju.";
        }
    }
    if (empty($username_error) && empty($password_error) && empty($confirm_password_error)) { 
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if ($stmt = $conn->prepare($sql)) { 
            $stmt->bind_param("ss", $param_username, $param_password); 
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            if ($stmt->execute()) {
                header("location: login.php");
            } else {
                echo '<script type="text/javascript">alert("Došlo je do greške prilikom registracije korisnika."); 
            window.location.href = "http://localhost/itehdomaci1/register.php";</script>';
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
    <title>Registracija</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon-01.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="css/register.css">
</head>

<body>
    <div class="w3-row">
        <div class="w3-third w3-container">
        </div>
        <div class="w3-third w3-container">
            <div id="formContent">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h1 style="text-align:center">Registruj se</h1>                   
                    <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>" style="margin-left:10%; margin-right:-40%">
                        <label style="color:black">Korisničko ime</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_error; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>" style="margin-left:10%; margin-right:-40%">
                        <label style="color:black">Šifra</label>
                        <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                        <span class="help-block"><?php echo $password_error; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_error)) ? 'has-error' : ''; ?>" style="margin-left:10%; margin-right:-40%">
                        <label style="color:black">Potvrdi šifru</label>
                        <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                        <span class="help-block"><?php echo $confirm_password_error; ?></span>
                    </div>
                    <div class="form-group" style="margin-left:37%;">
                        <input type="submit" class="w3-button w3-round-large w3-hover-blue w3-black" value="Pošalji">
                        <input type="reset" class="w3-button w3-round-large w3-hover-red w3-black" value="Očisti">
                    </div>
                    <p style="text-align:center; color:black">Već imaš nalog?<a href="login.php">Prijavi se ovde!</a>.</p>
                </form>
            </div>
        </div>
        <div class="w3-third w3-container">
        </div>
    </div>



</body>

</html>