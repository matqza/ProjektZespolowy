<!DOCTYPE html>
<html>
<head>
  <title>Strona z panelem admina</title>
  <link rel="stylesheet" type="text/css" href="AdminPanel.css">
  <style>
    .selected {
      background-color: yellow;
    }
  </style>
</head>
<body>
  <?php
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

    // Pobranie danych użytkowników z bazy danych
    $query = "SELECT * FROM uzytkownicy";
    $result = $conn->query($query);
    $users = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    // Obsługa dodawania nowego użytkownika
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addUser"])) {
        // Pobierz dane z formularza
        $imie = $_POST["imie"];
        $nazwisko = $_POST["nazwisko"];
        $numer_telefonu = $_POST["numer_telefonu"];
        $adres_zamieszkania = $_POST["adres_zamieszkania"];
        $nazwa_uzytkownika = $_POST["nazwa_uzytkownika"];
        $email = $_POST["email"];
        $haslo = password_hash($_POST["haslo"], PASSWORD_DEFAULT);
        $typ_konta = $_POST["typ_konta"];

        // Dodaj nowego użytkownika do bazy danych
        $query = "INSERT INTO uzytkownicy (imie, nazwisko, numer_telefonu, adres_zamieszkania, nazwa_uzytkownika, email, haslo, typ_konta) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssss", $imie, $nazwisko, $numer_telefonu, $adres_zamieszkania, $nazwa_uzytkownika, $email, $haslo, $typ_konta);
        $stmt->execute();

        // Przekieruj na tę samą stronę, aby odświeżyć listę użytkowników
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }

// Obsługa aktualizacji danych użytkownika
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateUser"])) {
    // Pobierz dane z formularza
    $id = $_POST["id"];
    $imie = $_POST["imie"];
    $nazwisko = $_POST["nazwisko"];
    $numer_telefonu = $_POST["numer_telefonu"];
    $adres_zamieszkania = $_POST["adres_zamieszkania"];
    $nazwa_uzytkownika = $_POST["nazwa_uzytkownika"];
    $email = $_POST["email"];
    $typ_konta = $_POST["typ_konta"];

    if (!empty($_POST["haslo"])) {
        // Jeśli hasło zostało zmienione, zaktualizuj je w bazie danych
        $haslo = password_hash($_POST["haslo"], PASSWORD_DEFAULT);
        // Zaktualizuj dane użytkownika w bazie danych (z hasłem)
        $query = "UPDATE uzytkownicy SET imie = ?, nazwisko = ?, numer_telefonu = ?, adres_zamieszkania = ?, nazwa_uzytkownika = ?, email = ?, haslo = ?, typ_konta = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssssi", $imie, $nazwisko, $numer_telefonu, $adres_zamieszkania, $nazwa_uzytkownika, $email, $haslo, $typ_konta, $id);
        if ($stmt->execute()) {
            echo "<script>alert('Dane użytkownika zostały zaktualizowane pomyślnie');</script>";
        } else {
            echo "<script>alert('Wystąpił błąd podczas aktualizacji danych użytkownika');</script>";
        }
    } else {
        // Zaktualizuj dane użytkownika w bazie danych (bez hasła)
        $query = "UPDATE uzytkownicy SET imie = ?, nazwisko = ?, numer_telefonu = ?, adres_zamieszkania = ?, nazwa_uzytkownika = ?, email = ?, typ_konta = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssi", $imie, $nazwisko, $numer_telefonu, $adres_zamieszkania, $nazwa_uzytkownika, $email, $typ_konta, $id);
        if ($stmt->execute()) {
            echo "<script>alert('Dane użytkownika zostały zaktualizowane pomyślnie');</script>";
        } else {
            echo "<script>alert('Wystąpił błąd podczas aktualizacji danych użytkownika');</script>";
        }
    }

    // Przekieruj na tę samą stronę, aby odświeżyć listę użytkowników
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$conn->close();

  ?>
  <header>
    <h1>Panel Admina</h1>
  </header>
  <nav class="tabs">
    <ul class="tab-links">
      <li><a href="#item1">Strona główna</a></li>
      <li><a href="#item2">Użytkownicy</a></li>
      <li><a href="#item3">Zamówienia</a></li>
      <li><a href="http://localhost/projekt/login/login.html">Wyloguj się</a></li>
      <li><a href="#default">wyczyść</a></li>
    </ul>
  </nav>
  <div class="items">
    <p id="item1">Strona główna</p>
    <p id="item2">
      <form method="post" action="">
        <input type="hidden" name="id">
        <input placeholder="Imię" type="text" name="imie"><br>
        <input placeholder="Nazwisko" type="text" name="nazwisko"><br>
        <input placeholder="Numer telefonu" type="number" name="numer_telefonu"><br>
        <input placeholder="Adres zamieszkania" type="text" name="adres_zamieszkania"><br>
        <input placeholder="Nazwa Użytkownika" type="text" name="nazwa_uzytkownika"><br>
        <input placeholder="Email" type="text" name="email"><br>
        <input placeholder="Hasło" type="password" name="haslo"><br>
        <input placeholder="Typ konta" type="text" name="typ_konta"><br>

        <!-- Przycisk do dodawania nowego użytkownika -->
        <button type="submit" name="addUser">Dodaj nowego użytkownika</button><br>

        <!-- Przycisk do zatwierdzania zmian -->
        <button type="submit" name="updateUser">Zatwierdź zmiany</button><br>

        <!-- Tabela z użytkownikami -->
        <table id="userTable">
          <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Numer telefonu</th>
            <th>Adres zamieszkania</th>
            <th>Nazwa użytkownika</th>
            <th>Email</th>
            <th>Typ konta</th>
          </tr>
          <?php foreach ($users as &$user) { ?>
          <tr data-id="<?php echo htmlspecialchars($user['id']); ?>">
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['imie']); ?></td>
            <td><?php echo htmlspecialchars($user['nazwisko']); ?></td>
            <td><?php echo htmlspecialchars($user['numer_telefonu']); ?></td>
            <td><?php echo htmlspecialchars($user['adres_zamieszkania']); ?></td>
            <td><?php echo htmlspecialchars($user['nazwa_uzytkownika']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['typ_konta']); ?></td> 
          </tr> 
          <?php } ?>
        </table>

      </form>
    </p>
    <p id="item3">Zamówienia</p>
    <p id="item4">Wyloguj się</p>
    <p id="default"><!-- domyślnie nie jest wyświetlany żaden tekst --></p>
  </div>

  <!-- Skrypt JavaScript -->
  <script>
    var addUserButton = document.querySelector('button[name="addUser"]');
    var updateUserButton = document.querySelector('button[name="updateUser"]');
    var userTable = document.getElementById('userTable');

    addUserButton.addEventListener('click', function() {
      userTable.style.display = 'block';
    });

    // Funkcja do ukrywania tabeli z użytkownikami
    function hideUserTable() {
      userTable.style.display = 'none';
    }

    // Początkowo ukryj tabelę z użytkownikami
    hideUserTable();

    // Obsługa zmiany zakładki
    window.addEventListener('hashchange', function() {
      var currentHash = window.location.hash;
      if (currentHash !== '#item2') {
        hideUserTable();
      } else {
        userTable.style.display = 'block';
      }
    });

   // Pobierz dane użytkowników z PHP
    var users = <?php echo json_encode($users); ?>;

    // Dodaj obsługę kliknięcia wiersza tabeli
    var rows = userTable.getElementsByTagName('tr');
    for (var i = 1; i < rows.length; i++) {
        rows[i].addEventListener('click', (function(row) {
            return function() {
                // Pobierz ID użytkownika z atrybutu 'data-id'
                var userId = row.getAttribute('data-id');

                // Znajdź użytkownika o danym ID
                var user;
                for (var j = 0; j < users.length; j++) {
                    if (users[j].id == userId) {
                        user = users[j];
                        break;
                    }
                }

                // Wypełnij pola formularza danymi wybranego użytkownika
                document.querySelector('input[name="id"]').value = user.id;
                document.querySelector('input[name="imie"]').value = user.imie;
                document.querySelector('input[name="nazwisko"]').value = user.nazwisko;
                document.querySelector('input[name="numer_telefonu"]').value = user.numer_telefonu;
                document.querySelector('input[name="adres_zamieszkania"]').value = user.adres_zamieszkania;
                document.querySelector('input[name="nazwa_uzytkownika"]').value = user.nazwa_uzytkownika;
                document.querySelector('input[name="email"]').value = user.email;
                document.querySelector('input[name="haslo"]').value = '';
                document.querySelector('input[name="typ_konta"]').value = user.typ_konta;
            };
        })(rows[i]));
    }
  </script>
  <script src="tabs.js"></script>
</body>
</html>
