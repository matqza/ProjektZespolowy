<!DOCTYPE html>
<html>
<head>
    
    <title>Nazwa strony</title>
   <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
    <link href="menu.css" rel="stylesheet" type="text/css">
</head>
<body>
   <div id="container">
    <!--div z koszykiem-->
    <div id="Basket" >
        <table id="BasketTable">
        </table>
        
            <button  id="BasketClear" onclick="ClearBasket()">
                wyczyść
            </button>
            <form action="koszyk.php">
            <button type="submit" id="BasketSubmit" onclick="SubmitBasket()" >
                Do Koszyka
            </button>
        </form>
    </div>

    <header >
    <button onclick="SetVisibility()" id="BasketButton">
    Koszyk
    </button>
    </header>

    <nav>
        <!-- zawartość menu nawigacyjnego strony -->
    </nav>

    <main>
        <!--ączenie z dazą danych oraz dynamiczne tworzenie guzików-->
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
                        $thisName = $wiersz["Name"];
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
                    

                            $thisName = "m".$thisName;
                            echo <<<HTML
                        <div class="menu_cell" >
                            <button id= $thisName onclick="AddToBasket(id)">
                                <p class="menuName"></p>
                            <p class="menuIngrediants">{$fullIngredients}</p>
                            </button>
                        </div>
                        HTML;
                    //AddToBasket($wiersz["Id"] , $fullIngredients,$wiersz["Cost_S"] , $wiersz["Cost_L"] )


                    //AddToBasket($pizzaID,$pizzaIng,$pizzaCostS,$pizzaCostL)

                 
             }
                
              
        }

        function GetNameByID($pizzaId)
        {
            $conn =  mysqli_connect("localhost", "root", "", "galakpizza");


        if(mysqli_connect_errno())
        {
            echo "connection failed";
            exit();
        }
     



           $wynik = $conn->query("select Name from pizza where Id=$pizzaId");
           return $wynik;

        }

    ?>   

                <script>
                    function SetVisibility()
                    {
                        var x = document.getElementById("Basket");
                    if(x.style.display=="none")
                        x.style.display="block";
                    else
                    x.style.display="none"

                    }



                    function AddToBasket($pizzaID)
                    {
                        $pizzaID = $pizzaID.substring(1);
                        var x = document.getElementById("BasketTable");
                        var newRow = x.insertRow();
                        var newCell1 = newRow.insertCell();
                        var newText = document.createTextNode($pizzaID);
                        newCell1.appendChild(newText);


                    
                        
                    }



                    //czyszczenie koszyka
                    function ClearBasket()
                    {
                        var x = document.getElementById("BasketTable");
                        x.innerHTML = '';
                    }
                
                    //dodaje zawartość koszyka do sesji
                    function SubmitBasket()
                    {
                        var x = document.getElementById("BasketTable");
                        sessionStorage.setItem('basketresult',x.innerHTML);
                    }



                </script>
     </main>

    <footer>
        <!-- zawartość stopki strony -->
    </footer>
    <div>
</body>
</html>