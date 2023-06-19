

<?php
$request_body = file_get_contents('php://input');
$params = json_decode($request_body, true);

$name = $params['name'];
$age = $params['age'];

// Wykonanie operacji w oparciu o przekazane parametry
// ...

// Zwrócenie odpowiedzi z funkcji PHP
$response = "Witaj, $name! Twój wiek to $age.";
echo $response;
/*
$name = $_POST['query'];

$conn =  mysqli_connect("localhost", "root", "", "galakpizza");


                if(mysqli_connect_errno())
                {
                    echo "connection failed";
                    exit();
                }
            
                $wynik = $conn->query("insert into orders values(null, 1)");


$response = "$name";
echo $response;
*/
?>