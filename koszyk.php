<!DOCTYPE html>
<html>
<head>
    <script>

          
    
            
          function SetAddVisibility($setDiv)
                 {
                    
                   // Console.console.log($setDiv);
                    var x = document.getElementById($setDiv);
                if(x.style.display=="none")
                    x.style.display="block";
                else
                x.style.display="none"

                 }

                 //deletes a row in table "Order"
                 function deleteRow( $ill)
                 {
                    var x = document.getElementById("Order");
                    $ill.closest('tr').remove();

                    //updates the value in session
                        sessionStorage.setItem('basketresult',x.innerHTML);
                 }

                 //adds an item into "Order" table
                 function AddToOrder($pizzaID)
                 {

                    var bttn = document.getElementById($pizzaID);
                    var x = document.getElementById("Order");
                    var newRow = x.insertRow();
                    var newCell1 = newRow.insertCell();
                    var newText = document.createTextNode($pizzaID);
                    newCell1.appendChild(newText);
                    newCell1 = newRow.insertCell();
                    newCell1.innerHTML = bttn.value;
                    newCell1 = newRow.insertCell();
                    newCell1.innerHTML = "<button>edycja</button>";
                    newCell1 = newRow.insertCell();
                    newCell1.innerHTML = '<button onclick="deleteRow(this)">klik</button>';

                    //updates the value in session
                        sessionStorage.setItem('basketresult',x.innerHTML);
                 }

                 //adds a column into table with 2 types of buttons
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
                        var hh="leftPanel";
                         var a = '<button id="ed'+i+'" onclick="SetAddVisibility(\'leftPanel\')">edycja</button>';
                        td.innerHTML = a;
                      //  var str= ' echo <<< HTML <button id="e".i onclick="SetAddVisibility("leftPanel")"> <p>edycja</p> </button> </div> HTML ';
                        //td.innerHTML = str;
                       }
                       else
                       {
                        td.innerHTML = '<button onclick="deleteRow(this)">klik</button>';
                       }
                        rows[i].appendChild(td);    
                    }
                 }

                 //loads data into table after you open this page
                 function LoadSavedData()
                 {
                   var sentData=sessionStorage.getItem('basketresult');
                   var tableid = document.getElementById("Order");
                   tableid.innerHTML=sentData;


                   if(tableid.rows[0].cells.length!=3)
                   {
                   AddColumn(1,tableid);
                   AddColumn(2,tableid);
                   }

                    
                    
                 }

    </script>






    <title>Nazwa strony</title>
    <link href="koszyk.css" rel="stylesheet" type="text/css">
</head>
<body onload="LoadSavedData();">
    <div id="container">
        <div id="leftPanel">
            <?php
                $conn =  mysqli_connect("localhost", "root", "", "galakpizza");


                if(mysqli_connect_errno())
                {
                    echo "connection failed";
                    exit();
                }
            
                $wynik = $conn->query("select * from ingredients");
      
                while($wiersz = $wynik->fetch_assoc())
                {
                    $rowId=$wiersz['Id'];
                    $rowName=$wiersz['Ingredient'];
                    $checkboxId="checkbox".$rowId;

                    echo <<<HTML
                        <div class="leftPanelEdit" >
                            <!--naprawić value-->
                        <input class="leftPanelEditCheckbox" type="checkbox" id=$checkboxId value="$rowName">
                        <label class="leftPanelEditLabel" for="vehicle1">{$rowName}</label><br>
                        </div>
                        HTML;
                }
            ?>
        </div>

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
                                    if($number+1==strlen($ingredientString))
                                    {
                                        $tempHelp .= $ingredientString[$number];
                                    }
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
                            <button id= $thisid onclick="AddToOrder(id)" value="$fullIngredients">
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
            <button  id="addToOrderCancel" onclick="SetAddVisibility('addToOrder')">
                anuluj
            </button>
            
            </div>
            <button  id="addToOrderbuton" onclick="SetAddVisibility('addToOrder')">
                dodaj do zamówienia
            </button>
        </main>

            


        <footer>
            <!-- zawartość stopki strony -->
        </footer>

        </div>
    <div>
</body>
</html>
