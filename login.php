<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obsługa żądania POST
} else {
    // Obsługa innych metod żądania (np. GET)
}

// Połączenie z bazą danych
$db_host = 'localhost';
$db_user = 'nazwa_uzytkownika';
$db_password = 'haslo_uzytkownika';
$db_name = 'nazwa_bazy_danych';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
  die('Błąd połączenia z bazą danych: ' . $conn->connect_error);
}

// Pobranie danych z formularza
$login = $_POST['login'];
$haslo = $_POST['haslo'];

// Zapytanie sprawdzające dane logowania
$query = "SELECT * FROM Uzytkownicy WHERE login = '$login' AND haslo = '$haslo'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  // Poprawne dane logowania
  // Wyświetlanie ekranu slidera
  echo '<script>document.getElementById("login-form").style.display = "none";</script>';
  echo '<script>document.getElementById("slider-screen").style.display = "block";</script>';
} else {
  // Błędne dane logowania
  // Sprawdzenie, czy użytkownik o podanym ID istnieje
  $id = $_POST['id'];
  $checkQuery = "SELECT * FROM Uzytkownicy WHERE id = '$id'";
  $checkResult = $conn->query($checkQuery);

  if ($checkResult->num_rows > 0) {
    // Użytkownik o podanym ID istnieje
    echo '<script>alert("Błędne dane logowania!");</script>';
    echo '<script>window.location.href = "index.html";</script>';
  } else {
    // Rejestracja nowego użytkownika
    $registerQuery = "INSERT INTO Uzytkownicy (id, login, haslo) VALUES ('$id', '$login', '$haslo')";
    if ($conn->query($registerQuery) === TRUE) {
      // Wyświetlanie ekranu slidera dla nowo zarejestrowanego użytkownika
      echo '<script>document.getElementById("login-form").style.display = "none";</script>';
      echo '<script>document.getElementById("slider-screen").style.display = "block";</script>';
    } else {
      echo "Błąd podczas rejestracji użytkownika: " . $conn->error;
    }
  }
}

$conn->close();
?>
