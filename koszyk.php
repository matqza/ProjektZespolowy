<!DOCTYPE html>
<html>
<head>

<script>

    function sendQueryToDatabase($myQuery) {
        const params = {
            query: $myQuery

        };

        fetch('loadData.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(params)
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Błąd podczas wywoływania funkcji PHP:', error);
        });
    }

    function sendQueryToGetValue($myQuery, $row, $table, $action) 
    {
                const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
            const response = xhr.responseText;
            const parsedResponse = JSON.parse(response);
            console.log(response);
            console.log(parsedResponse);
                if($action==1)
                {
                    const costValue = parsedResponse[0].Cost_S;
                    var totalcost = document.getElementById("total-price");
                    let toint =totalcost.innerHTML;
                    totalcost.innerHTML = Number(toint)+Number(costValue);
                    $table.rows[$row].cells[2].innerHTML = costValue;
                }
                else
                {
                     costValue = parsedResponse[0].Cost;
                    var totalcost = document.getElementById("total-price");
                    let toint =totalcost.innerHTML;
                    if($action == 3)
                    {
                        totalcost.innerHTML = Number(toint)-Number(costValue);
                    $table.rows[$row].cells[2].innerHTML =   Number($table.rows[$row].cells[2].innerHTML) - Number(costValue);
                    }
                    else
                    {
                    totalcost.innerHTML = Number(toint)+Number(costValue);
                    $table.rows[$row].cells[2].innerHTML = Number(costValue) + Number($table.rows[$row].cells[2].innerHTML) ;
                    }
                }
            } else {
            console.error('Błąd podczas wywoływania funkcji PHP:', xhr.status);
            }
        }
        };

        xhr.open('POST', 'getValue.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`query=${encodeURIComponent($myQuery)}`);
    }




    function AddToDatabase()
    {
        var x = document.getElementById("Order");
         sendQueryToDatabase("insert into orders values(null, 1)");
        
        var rowCount = x.rows.length;
        for(var i=0;i<rowCount;i++)
        {

            $pizzaName = '"' + x.rows[i].cells[0].innerHTML + '"';
            $pizzaIng = '"' +  x.rows[i].cells[1].innerHTML + '"';
            $pizzaCost = x.rows[i].cells[2].innerHTML;
            

        sendQueryToDatabase("insert into orderdetails values(null, (select max(Id) from orders),"+ $pizzaName + "," + $pizzaIng + "," + $pizzaCost+")");
        }
        
    }

    function CheckboxChange($checkbox) 
    {
        var orderTable = document.getElementById("Order");
        var x = document.getElementById("leftPanel");
        var newtext = orderTable.rows[x.value].cells[1].innerHTML;
        if($checkbox.checked)
        {
        
            newtext=newtext+$checkbox.value;   
            console.log("on");
            console.log(newtext);
            orderTable.rows[x.value].cells[1].innerHTML = newtext;
            sendQueryToGetValue("select Cost from ingredients where Ingredient like \""+ $checkbox.value.slice(0,-1) +"\"", x.value, orderTable, 2);
            return 0;
        }
            newtext =newtext.replace($checkbox.value, "");
            orderTable.rows[x.value].cells[1].innerHTML = newtext;
            console.log("off");
            console.log(newtext);
            sendQueryToGetValue("select Cost from ingredients where Ingredient like \""+ $checkbox.value.slice(0,-1) +"\"", x.value, orderTable, 3);
        
        
    }


    //zaznacza checkboxy (jeśli checkox ma jeden ze składników to zostaje zaznaczony)
    function MarkCheckboxes($ingredientText)
    {
        var table = document.getElementById("Order");
        var newtext = table.rows[$ingredientText].cells[1].innerHTML;
        console.log(newtext);
        console.log($ingredientText);
    
        var checkboxes = document.getElementsByClassName("leftPanelEditCheckbox");
        for (var i = 0; i < checkboxes.length; i++) 
        {
            if(newtext.includes(checkboxes.item(i).value))
            {
                checkboxes.item(i).checked=true;
            }
            else
            {
                checkboxes.item(i).checked=false;
            }
        }

    }
    
    function GetWords($ingString) {
    var words = $ingString.split(" ");
    console.log(words);
    return words;
    }

    //funkcja wywoływana przez naciśnięcie huzika edit
    function EditItem($button)
    {
        var x = document.getElementById("leftPanel");
        x.value=$button;
            if(x.style.display=="none")
            {
                x.style.display="block";
                MarkCheckboxes($button);
            }
            else
            x.style.display="none"
    }

        //pokazuje lub ukrywa diva
    function SetAddVisibility($setDiv)
            {
                
            // Console.console.log($setDiv);
                var x = document.getElementById($setDiv);
                if(x.style.display=="none")
                x.style.display="block";
                else
                x.style.display="none"

            }


            function UpdateCost($table)
            {

                var totalcost = document.getElementById("total-price");
                totalcost.innerHTML="";
                var rows = $table.rows;
                //console.log("rows", rows);

                for (var i = 0; i < rows.length; ++i) {
                let toint =totalcost.innerHTML;
                let costValue = $table.rows[i].cells[2].innerHTML;

                totalcost.innerHTML = Number(toint)+Number(costValue);
                }
            }

            //deletes a row in table "Order"
            function deleteRow( $ill)
            {
                var x = document.getElementById("Order");
                $ill.closest('tr').remove();
                sessionStorage.setItem('basketresult',x.innerHTML);
                UpdateCost(x);
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
                newCell1.innerHTML = bttn.value + " ";
                newCell1 = newRow.insertCell();
                var rowsCount=x.rows.length-1;
                var queryToSend = "select Cost_S from pizza where Name like \"" + $pizzaID + "%\";";
                    sendQueryToGetValue(queryToSend, rowsCount, x, 1);

                    newCell1 = newRow.insertCell();
                newCell1.innerHTML = '<button id="ed'+rowsCount+'" onclick="EditItem('+rowsCount+')" class="basketButtons">edycja</button>';
                newCell1 = newRow.insertCell();
                newCell1.innerHTML = '<button onclick="deleteRow(this)">usuń</button>';

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
                    var a = '<button id="ed'+i+'" onclick="EditItem('+i+')" class="basketButtons">edycja</button>';
                    td.innerHTML = a;
                }
                else
                {
                    td.innerHTML = '<button onclick="deleteRow(this)" class="basketButtons">usuń</button>';
                }
                    rows[i].appendChild(td);    
                }
            }

            function FixingString($orderTable)
            {
                var rowCount = $orderTable.rows.length;
                for(var i=0;i<rowCount;i++)
                {
                    $orderTable.rows[i].cells[1].innerHTML += " ";
                }

            }

      

            function AddValueColumn($table)
            {
                var rows = $table.rows;
                
                var totalcost = document.getElementById("total-price");
                totalcost.innerHTML = "";
                
                //console.log("rows", rows);

                for (var i = 0; i < rows.length; ++i) 
                {                
                    var td = document.createElement("td");
                    rows[i].appendChild(td); 
                    var queryToSend = "select Cost_S from pizza where Name like \"" + $table.rows[i].cells[0].innerHTML + "%\";";
                    sendQueryToGetValue(queryToSend, i, $table, 1);
                }
            }

            //loads data into table after you open this page
            function LoadSavedData()
            {
            var sentData=sessionStorage.getItem('basketresult');
            var tableid = document.getElementById("Order");
            tableid.innerHTML=sentData;


            if(tableid.rows[0].cells.length!=5)
            {
                AddValueColumn(tableid);
            AddColumn(1,tableid);
            AddColumn(2,tableid);
            }
            FixingString(tableid);
                
                
            }

</script>


  <title>Koszyk zamówień</title>
  <link rel="stylesheet" type="text/css" href="koszyk.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body onload="LoadSavedData();">

<div id="leftPanel">
            <?php
            //towrzy checkboxy w panelu edycji
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
                    $rowName=$wiersz['Ingredient']." ";
                    $checkboxId="checkbox".$rowId;

                    echo <<<HTML
                        <div class="leftPanelEdit" >
                            <!--naprawić value-->
                        <input class="leftPanelEditCheckbox" type="checkbox" id=$checkboxId value="$rowName" onclick="CheckboxChange(this)">
                        <label class="leftPanelEditLabel" for="vehicle1">{$rowName}</label><br>
                        </div>
                        HTML;
                }
            ?>
</div>


  <h1>Koszyk zamówień</h1>
  <div id="cart">
    <table id="Order">
        </table>
    <h3 id="total-price">Łączna cena: 0 zł</h3>
    <input type="text" id="discount-code" placeholder="Wprowadź kod rabatowy">
  </div>

  <div id="addToOrder">
        <?php
        //dynamiczne towrzenie guzików 
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
                            $pizzaCost = $wiersz["Cost_S"];
                            $showString = $thisid . " " . $pizzaCost;


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
                                        $fullIngredients .=$mytemprow[1] . " ";
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
                            <p class="menuIngrediants">{$showString}</p>
                            </button>
                        </div>
                        HTML;
                    }
                    
                
            }

        ?>   
            <button  id="addToOrderCancel" onclick="SetAddVisibility('addToOrder')">
                anuluj
            </button>
        </div>
  <!-- Przycisk do złożenia zamówienia -->
  <button  id="addToOrderbuton" onclick="SetAddVisibility('addToOrder')">
                dodaj do zamówienia
    </button>
  <button id="checkout-btn" onclick="AddToDatabase()">zamów</button>

  <script src="script.js"></script>
</body>
</html>