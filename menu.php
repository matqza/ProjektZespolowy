<!DOCTYPE html>
phpinfo();
<html>
<head>
    
    <title>Nazwa strony</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="menu.css" rel="stylesheet" type="text/css">
</head>
<body>
   <div id="container">


    <header >
        <!-- zawartość nagłówka strony -->
    </header>

    <nav>
        <!-- zawartość menu nawigacyjnego strony -->
    </nav>

    <main>
    <?php
      $conn =  mysqli_connect("localhost", "root", "", "galakpizza");


        if(mysqli_connect_errno())
        {
            echo "connection failed";
            exit();
        }
     



           $wynik = $conn->query("select * from pizza");

             if($wynik->num_rows>0)
             {


                 while($wiersz = $wynik->fetch_assoc())
                {
                    $thisid = $wiersz["Id"];
                    $ingredientString = $wiersz["Ingredients"];
                    $fullIngredients ="";
                    $tempHelp="";




                    for($number=0;$number<strlen($ingredientString);$number++)
                    {
                        if($ingredientString[$number]==","  || $number+1==strlen($ingredientString))
                        {
                            $thisIngrediant = $conn->query("select * from ingredients where id=$tempHelp");
                         
                                $mytemprow = $thisIngrediant->fetch_row();
                              
                                if($number+1==strlen($ingredientString))
                                {
                                    $fullIngredients .=$mytemprow[1];
                                    break;
                                }
                                $fullIngredients .=$mytemprow[1] . ", ";
                            $tempHelp="";
                        }
                        else
                        {
                            //$tempHelp+=$ingredientString[$number];
                            $tempHelp .= $ingredientString[$number];
                        }
                    }
                  

                        $thisid = "menu".$thisid;
                    echo <<<HTML
              <div class="menu_cell" >
                   <button id= $thisid>
                    <p class="menuName"></p>
                   <p class="menuIngrediants">{$fullIngredients}</p>
                </button>
              </div>
            HTML;


                 
                 }
           }

        


    ?>   
    </main>

    <footer>
        <!-- zawartość stopki strony -->
    </footer>
    <div>
</body>
</html>