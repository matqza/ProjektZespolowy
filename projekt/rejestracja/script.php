<?php
// Pobranie danych z formularza
$firstName = $_POST['firstName'];
$surname = $_POST['surname'];
$phoneNumber = $_POST['number'];
$address = $_POST['adress'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

// Sprawdzenie czy dane nie są puste
if (empty($firstName) || empty($surname) || empty($phoneNumber) || empty($address) || empty($username) || empty($email) || empty($password) || empty($password2)) {
    echo "Wszystkie pola formularza są wymagane.";
    exit();
}




// Sprawdzenie czy hasła są takie same
if ($password !== $password2) {
    echo "Podane hasła nie są identyczne.";
    exit();
}


// Haszowanie hasła
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Ustalenie typu konta
$accountType = 'user';

// Połączenie z bazą danych
$servername = "localhost";
$username_db = "root";
$password_db = ""; 
$dbname = "pizzadatabase";

$conn = new mysqli($servername, $username_db, $password_db , $dbname);



// Sprawdzenie połączenia z bazą danych
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Wstawienie danych do tabeli Uzytkownicy
$sql = "INSERT INTO Uzytkownicy (imie, nazwisko, numer_telefonu, adres_zamieszkania, nazwa_uzytkownika, email, haslo, typ_konta)
        VALUES ('$firstName', '$surname', '$phoneNumber', '$address', '$username', '$email', '$hashedPassword', '$accountType')";

if ($conn->query($sql) === TRUE) {
        // Przekierowanie na stronę login.html
    header("Location: http://localhost/projekt/login/login.html");
} else {
    echo "Błąd podczas rejestracji: " . $conn->error;
}

$conn->close();
?>
