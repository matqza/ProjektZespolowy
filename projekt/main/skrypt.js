// Pobranie danych z serwera
fetch('script.php')
  .then(response => response.text())
  .then(data => {
    // Parsowanie danych JSON
    const { imie, nazwisko, telefon, adres } = JSON.parse(data);

    // Wyświetlenie danych na stronie
    document.getElementById('username').textContent = `${imie} ${nazwisko}`;
    document.getElementById('phone').textContent = `Numer telefonu: ${telefon}`;
    document.getElementById('address').textContent = `Adres: ${adres}`;
  })
  .catch(error => console.log(error));