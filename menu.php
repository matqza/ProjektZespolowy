<?php

//13:31 18.04.2023

// ustawienia bazy danych
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// łączenie z bazą danych
$conn = mysqli_connect($servername, $username, $password, $dbname);

// sprawdzenie połączenia z bazą danych
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// obsługa formularza rejestracji
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];

    // walidacja formularza
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($first_name) || empty($last_name)) {
        echo "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // sprawdzenie, czy użytkownik o takim adresie email już istnieje
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo "User with this email already exists.";
        } else {
            // hashowanie hasła przed dodaniem do bazy danych
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // dodanie nowego użytkownika do bazy danych
            $sql = "INSERT INTO users (username, email, password, first_name, last_name) VALUES ('$username', '$email', '$hashed_password', '$first_name', '$last_name')";
            
            if (mysqli_query($conn, $sql)) {
                echo "New user created successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
}
// zamykanie połączenia z bazą danych
mysqli_close($conn);
?>
