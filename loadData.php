

<?php
$request_body = file_get_contents('php://input');
$params = json_decode($request_body, true);

$query = $params['query'];

$conn =  mysqli_connect("localhost", "root", "", "galakpizza");


                if(mysqli_connect_errno())
                {
                    echo "connection failed";
                    exit();
                }
            
                $wynik = $conn->query($query);


$response = "$query";
echo $response;

?>