<?php
session_start();

// Połączenie z bazą danych
$servername = "localhost";
$username_db = "root";
$password_db = ""; 
$dbname = "pizzadatabase";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Sprawdzenie połączenia z bazą danych
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];

    // Zapytanie do bazy danych w celu weryfikacji danych logowania
    $query = "SELECT * FROM Uzytkownicy WHERE nazwa_uzytkownika = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["haslo"];

        // Sprawdzenie poprawności hasła
        if (password_verify($password, $hashedPassword)) {
            // Poprawne logowanie, ustawienie sesji
            $_SESSION["login"] = $login;
            $_SESSION["user_id"] = $row["id"]; // Przykład zapisania id użytkownika w sesji

            // Przekierowanie do strony po zalogowaniu w zależności od typu konta
            $redirectUrl = ($row["typ_konta"] == "admin") ? "http://localhost/projekt/admin/admin.php" : "http://localhost/projekt/main/menu.html";
            header("Location: $redirectUrl");
            exit();
        } else {
            $errorMessage = "Nieprawidłowe hasło.";
        }
    } else {
        $errorMessage = "Nieprawidłowy login.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logowanie</title>
</head>
<body>
    <?php if (isset($errorMessage)) { ?>
        <p><?php echo $errorMessage; ?></p>
    <?php } ?>
    <form method="post" action="">
        <input type="text" name="login" placeholder="Login" required><br>
        <input type="password" name="password" placeholder="Hasło" required><br>
        <input type="submit" value="Zaloguj">
    </form>
</body>
</html>
