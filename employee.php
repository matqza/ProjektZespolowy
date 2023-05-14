<!DOCTYPE html>
<html>
<head>
    <title>Nazwa strony</title>
    <link rel="stylesheet" type="text/css" href="employee.css">
</head>
<body>
   <div id="OrderDiv">
        <table id="OrderTable">
            <?php
            
            $conn =  mysqli_connect("localhost", "root", "", "galakpizza");


            if(mysqli_connect_errno())
            {
                echo "connection failed";
                exit();
            }
            $wynik = $conn->query("select * from order");


            while($wiersz = $wynik->fetch_assoc())
                {
                    echo << HTML
                }
            ?>
        </table>
        
    </div>
    

    <header>
        <!-- zawartość nagłówka strony -->
    </header>

    <nav>
        <!-- zawartość menu nawigacyjnego strony -->
    </nav>

    <main>
        <!-- zawartość główna strony -->
    </main>

    <footer>
        <!-- zawartość stopki strony -->
    </footer>
</body>
</html>