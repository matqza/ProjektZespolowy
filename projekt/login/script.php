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

    // Zabezpieczenie przed atakiem SQL Injection
    $login = mysqli_real_escape_string($conn, $login);

    // Zapytanie do bazy danych w celu weryfikacji danych logowania
    $query = "SELECT * FROM Uzytkownicy WHERE nazwa_uzytkownika = '$login'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["haslo"];

        // Sprawdzenie poprawności hasła
        if (password_verify($password, $hashedPassword)) {
            // Poprawne logowanie, ustawienie sesji
            $_SESSION["login"] = $login;
            $_SESSION["user_id"] = $row["id"]; // Przykład zapisania id użytkownika w sesji

            // Przekierowanie do strony po zalogowaniu
            header("Location: http://localhost/projekt/main/menu.html");
            exit();
        } else {
            echo "Nieprawidłowe hasło.";
        }
    } else {
        echo "Nieprawidłowy login.";
    }
}

$conn->close();
?>
