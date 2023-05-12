<!DOCTYPE html>
<html>
<head>
    <script>

          
    
            
          function SetAddVisibility()
                 {
                    var x = document.getElementById("addToOrder");
                if(x.style.display=="none")
                    x.style.display="block";
                else
                x.style.display="none"

                 }

                 function deleteRow( $ill)
                 {
                    var x = document.getElementById("Order");
                    $ill.closest('tr').remove();
                 }


                 function AddToOrder($pizzaID)
                 {
                    var x = document.getElementById("Order");
                    var newRow = x.insertRow();
                    var newCell1 = newRow.insertCell();
                    var newText = document.createTextNode($pizzaID);
                    newCell1.appendChild(newText);
                    newCell1 = newRow.insertCell();
                    newCell1.innerHTML = "<button>edycja</button>";
                    newCell1 = newRow.insertCell();
                    newCell1.innerHTML = '<button onclick="deleteRow(this)">klik</button>';
                 }

                 function AddColumn( $buttonType,  $table)
                 {
                   // var table = document.getElementById("tableTest");
                    var rows = $table.rows;
                    //console.log("rows", rows);

                    for (var i = 0; i < rows.length; ++i) {                
                        var td = document.createElement("td");
                       // td.innerText = $buttonType;
                       if($buttonType==1)
                       {
                       td.innerHTML = "<button>edycja</button>";
                       }
                       else
                       {
                        td.innerHTML = '<button onclick="deleteRow(this)">klik</button>';
                       }
                        rows[i].appendChild(td);    
                    }
                 }

                 function LoadSavedData()
                 {
                    /*
                    var myArray = sessionStorage.getItem('myArray');
                    var sentData=localStorage.getItem("basketresult");
                    var x = document.getElementById("Order");
                    var newRow = x.insertRow();
                    var newCell1 = newRow.insertCell();
                    var newText = document.createTextNode(sentData[1][1]);
                    newCell1.appendChild(newText);
                    */
                  
                   var sentData=sessionStorage.getItem('basketresult');
                   var tableid = document.getElementById("Order");
                   tableid.innerHTML=sentData;

                   //var rowsNumber = tebleid.rows.length;

                   AddColumn(1,tableid);
                   AddColumn(2,tableid);

                    
                 }

    </script>






    <title>Nazwa strony</title>
    <link href="koszyk.css" rel="stylesheet" type="text/css">
</head>
<body onload="LoadSavedData();">


    <header >
  
    </header>

    <nav>
        <!-- zawartość menu nawigacyjnego strony -->
    </nav>

    <main>

        <table id="Order">
        </table>
                
                    
                


        <div id="addToOrder">
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
                        $thisid = $wiersz["Name"];
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
                    

                            $thisid = $thisid;
                        echo <<<HTML
                    <div class="menu_cell" >
                        <button id= $thisid onclick="AddToOrder(id)">
                            <p class="menuName"></p>
                        <p class="menuIngrediants">{$fullIngredients}</p>
                        </button>
                    </div>
                    HTML;
//AddToBasket($wiersz["Id"] , $fullIngredients,$wiersz["Cost_S"] , $wiersz["Cost_L"] )


                    //AddToBasket($pizzaID,$pizzaIng,$pizzaCostS,$pizzaCostL)

                 
                 }
                
              
           }

    ?>   
        <button  id="addToOrderCancel" onclick="SetAddVisibility()">
            anuluj
        </button>
        </div>
        <button  id="addToOrderbuton" onclick="SetAddVisibility()">
            dodaj do zamówienia
        </button>
     </main>

    <footer>
        <!-- zawartość stopki strony -->
    </footer>
    <div>
</body>
</html>
