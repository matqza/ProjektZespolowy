<!DOCTYPE html>
<html>
<head>
    
    <title>Nazwa strony</title>
   <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
    <link href="menu.css" rel="stylesheet" type="text/css">
</head>
<body>

    <!--jacek-->
        <!-- option section -->
        <!-- option section -->
        <header>
            <div class="logo-container">
            <a href="#" class="logo"><img src="logo.jpg" width="90px" height="90px"></a>
            <h1 class="logo-text animated bounce">Pizzerro</h1>
            </div>
            <ul class="options">
            <li><a href="#menu" class="nav-link">Menu</a></li>
            <li><a href="#about" class="nav-link">O nas</a></li>
            <li><a href="#profile" class="nav-link">Mój profil</a></li>
            <li><a href="#promo" class="nav-link">Promocje</a></li>
            </ul>

           <!-- <div class="icons">
                <a href="#"><i class='bx bx-cart cart-icon'></i></a>
                <span class="cart-text">Mój Koszyk</span>
            </div>-->
            <button onclick="SetVisibility()" id="BasketButton" class ="icons">
        Koszyk
        </button>
        </header>
        <!-- end option section -->


        <!-- section "o nas"-->
        <section class="about" id="about">
            <div class="about-text">
                <p>Moja pizzeria Jacka Ciszewskiego ma już 500 lat i od pokoleń jest przekazywana z pokolenia na pokolenie. Jeśli szukaj dobrej pizzeri i drogiej to dobrze trafiłeś. Czeka na Ciebie ogromna ilość pizzy do wyboru. <br> <br> 
                    <div class="about-image">
                        <img src="R.jpg" alt="Obrazek" style="max-width: 700px;">
                    </div>
                    <br> 
                    <br> 
                    <h2 class="animated fadeIn">
                        <i class="fas fa-chart-bar"></i> Nasze Statystyki
                    </h2>
                    <p>Ilość zamówień w naszej pizzerii: <span id="orderCount" class="animated fadeIn">293</span></p>
                    <p>Ilość klientów: <span id="customerCount" class="animated fadeIn">108</span></p>
                    <p>Średni czas oczekiwania: <span id="averageWaitTime" class="animated fadeIn">30 minut</span></p>
                </p>
            </div>
        </section>
        <!-- end section "o nas"-->
    <!--jacek-->



        <!--div z koszykiem-->
        <div id="Basket"  >
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
        <section class="menu" id="menu">
		<div class="menu-text">
		<h2>Menu</h2>
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
                        $pizzaCost = $wiersz["Cost_S"];
                        $ingredientString = $wiersz["Ingredients"];
                        $fullIngredients ="";
                        $tempHelp="";
                        $showString = $thisName . " " . $pizzaCost;
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
                                $tempHelp .= $ingredientString[$number];
                            }
                        }
                        
                    $thisName = "m".$thisName;
                    echo <<<HTML
                    <div class="menu_cell" >
                        <button id= $thisName onclick="AddToBasket(id)" value="$fullIngredients">
                        {$showString}
                        </button>
                    </div>
                    HTML;
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
                var menuButton = document.getElementById($pizzaID);
                var pizzaIng = menuButton.value;
                $pizzaID = $pizzaID.substring(1);
                var x = document.getElementById("BasketTable");
                var newRow = x.insertRow();
                var newCell1 = newRow.insertCell();
                var newText = document.createTextNode($pizzaID);
                var newCell2 = newRow.insertCell();
                var newText2 = document.createTextNode(pizzaIng);
                newCell1.appendChild(newText);
                newCell2.appendChild(newText2);
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
		</div>
	    </section>

        
        



<!--jacek-->       
	<!-- section "profile"-->
	<section class="profile" id="profile">
		<div class="profile-text">
		  <h2>Mój profil</h2>
		  <div class="profile-info">
			<i class="fas fa-user profile-icon"></i>
			<span class="info-label">John Doe</span>
		  </div>
		  
		  <div class="profile-info">
			<i class="far fa-calendar-alt info-icon"></i>
			<span class="info-label">Data rejestracji: 01-01-2023</span>
		  </div>
		  
		  <div class="profile-info">
			<i class="fas fa-clock info-icon"></i>
			<span class="info-label">Ostatnie logowanie: 05-24-2023, 15:30</span>
		  </div>
		  
		  <div class="profile-info">
			<i class="fas fa-phone info-icon"></i>
			<span class="info-label">Numer telefonu: 123-456-789</span>
		  </div>
		  
		  <div class="profile-info">
			<i class="fas fa-clipboard-list info-icon"></i>
			<span class="info-label">Ilość zamówień: 10</span>
		  </div>
		  
		  <div class="profile-info">
			<i class="fas fa-map-marker-alt info-icon"></i>
			<span class="info-label">Adres: ul. Przykładowa 1, 00-001 Warszawa</span>
		  </div>
		</div>
	  </section>
	<!-- end section "profile"-->
	<br>
	<br>
	<br>

	<!-- section "promo"-->
	<section class="promo" id="promo">
		<div class="promo-text">
		<h2>Promocje</h2>
		<div class="promo-info">
			<p>Środowe promocje oraz soboty w maju!</p>
			<p>Każda duża pizza -20 % taniej w każdą środę i sobotę!</p>
			<p>
				<i class="bx bxs-x-circle" style="color: red;"></i>
				Poniedziałek: Brak promocji
			</p>
			<p>
				<i class="bx bxs-x-circle" style="color: red;"></i>
				Wtorek: Brak promocji
			</p>
			<p>
				<i class="bx bxs-check-circle" style="color: green;"></i>
				Środa: Obowiązuje promocja
			</p>
			<p>
				<i class="bx bxs-x-circle" style="color: red;"></i>
				Czwartek: Brak promocji
			</p>
			<p>
				<i class="bx bxs-x-circle" style="color: red;"></i>
				Piątek: Brak promocji
			</p>
			<p>
				<i class="bx bxs-check-circle" style="color: green;"></i>
				Sobota: Obowiązuje promocja
			</p>
			<p>
				<i class="bx bxs-x-circle" style="color: red;"></i>
				Niedziela: Brak promocji
			</p>
		</div>
		</div>
	</section>
	<!-- end section "promo"-->

	<br>
	<br>
	<br>
	<br>
	<br>

	<footer>
		<div class="social-media">
			<p>Odwiedź nas na : </p>
			<a href="https://www.facebook.com/strona"><i class='bx bxl-facebook-square'></i></a>
			<a href="https://www.instagram.com/strona"><i class='bx bxl-instagram-alt'></i></a>
			<a href="https://www.tiktok.com/@strona"><i class='bx bxl-tiktok'></i></a>
		</div>
		<p>Stronę wykonał <strong>Jacek Ciszewski & Wojciech Miśtalski</strong></p>
		<p><strong>Wszelkie prawa zastrzeżone !</strong></p>
	</footer>
<!--jacek-->
</body>
</html>