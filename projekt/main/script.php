<?php
session_start();

// Połączenie z bazą danych
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "MojaBazaDanych";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Sprawdzenie połączenia z bazą danych
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Pobranie danych użytkownika z bazy danych na podstawie sesji
$nazwa_uzytkownika = $_SESSION['nazwa_uzytkownika'];

$sql = "SELECT imie, nazwisko, numer_telefonu, adres_zamieszkania FROM Uzytkownicy WHERE nazwa_uzytkownika = '$nazwa_uzytkownika'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imie = $row["imie"];
    $nazwisko = $row["nazwisko"];
    $telefon = $row["numer_telefonu"];
    $adres = $row["adres_zamieszkania"];

    // Ustawienie wartości zmiennych w sesji
    $_SESSION['imie'] = $imie;
    $_SESSION['nazwisko'] = $nazwisko;
    $_SESSION['telefon'] = $telefon;
    $_SESSION['adres'] = $adres;
} else {
    echo "Brak danych użytkownika.";
}

$conn->close();
?>
