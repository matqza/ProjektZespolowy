<?php
// Połączenie z bazą danych
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "GALAKPIZZA";

$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie, czy udało się połączyć z bazą danych
if ($conn->connect_error) {
  die("Nie udało się połączyć z bazą danych: " . $conn->connect_error);
}

// Pobranie loginu i hasła z formularza
$login = $_POST['login'];
$password = $_POST['password'];

// Zabezpieczenie przed atakami SQL injection
$login = mysqli_real_escape_string($conn, $login);
$password = mysqli_real_escape_string($conn, $password);

// Zapytanie SQL sprawdzające, czy istnieje użytkownik o podanym loginie i haśle
$sql = "SELECT * FROM USERS WHERE Login='$login' AND Password='$password'";
$result = $conn->query($sql);

// Sprawdzenie, czy znaleziono użytkownika
if ($result->num_rows > 0) {
  // Zalogowanie użytkownika i przekierowanie na stronę główną
  session_start();
  $row = $result->fetch_assoc();
  $_SESSION['user_id'] = $row['Id'];
  $_SESSION['user_type'] = $row['Type'];
  header("Location: index.php");
} else {
  // Wyświetlenie komunikatu o błędnych danych logowania
  echo "Nieprawidłowy login lub hasło.";
}

$conn->close();
?>
