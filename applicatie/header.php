<header>
    <ul id="NavigatieBalk">

        <li class="header">
            <a href="bestelling.php">Bestelling</a>
        </li>

        <li class="header">
            <a href="privacy.php">Privacy</a>
        </li>
        <li class="header">
            <a id="Menu" href="index.php">Menu</a>

        <li class="header">
            <a href="winkelwagentje.php">Winkelwagentje</a>
        </li>

        <?php
        if (!isset($_SESSION['ingelogged']) || $_SESSION['ingelogged'] == false) {
            echo    '<li class="header">
                        <a href="Login.php">Log in</a>
                    </li>';
        }
        else
        {
            echo '<li class="header">
                        <a href="logout.php">Uitloggen</a>
                </li>
                        <li class="header">
            <a href="profiel.php">Profiel</a>
        </li>';
        }
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Personnel') {
            echo '<li class="header">
                    <a href="personeel.php">Personeel</a>
                 </li>';
        }

        ?>


    </ul>

    <img id="logo" src="fotos/logo.png" alt="foto van een pizza met text: pizzaria het blok">



</header>