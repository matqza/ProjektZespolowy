<?php
// Pobranie zapytania z parametru POST
$query = $_POST['query'];

// Połączenie z bazą danych
$conn = mysqli_connect("localhost", "root", "", "galakpizza");

// Sprawdzenie połączenia
if (mysqli_connect_errno()) {
  echo "Błąd połączenia z bazą danych: " . mysqli_connect_error();
  exit();
}

// Wykonanie zapytania
$result = mysqli_query($conn, $query);

// Sprawdzenie czy zapytanie zostało wykonane poprawnie
if ($result) {
  $rows = array();

  // Przetworzenie wyników do tablicy
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  // Zamknięcie połączenia
  mysqli_close($conn);

  // Zwrócenie wyników jako JSON
  echo json_encode($rows);
} else {
  echo "Błąd wykonania zapytania: " . mysqli_error($conn);
}

?>
