<header>
    <ul id="NavigatieBalk">
        <li>
            <a href="profiel.php">Profiel</a>
        </li>
        <li>
            <a href="bestelling.php">Bestelling</a>
        </li>

        <li>
            <a href="privacy.php">Privacy</a>
        </li>
        <li>
            <a id="Menu" href="index.php">Menu</a>

        <li>
            <a href="winkelwagentje.php">Winkelwagentje</a>
        </li>

        <?php
        if (!isset($_SESSION['ingelogged']) || $_SESSION['ingelogged'] == false) {
            echo    '<li >
                        <a href="Login.php">Log in</a>
                    </li>';
        }
        else
        {
            echo '<li>
                        <a href="logout.php">Uitloggen</a>
                </li>';
        }
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'personnel') {
            echo '<li>
                    <a href="personeel.php">Personeel</a>
                 </li>';
        }

        ?>


    </ul>

    <img id="logo" src="fotos/logo.png" alt="foto van een pizza met text: pizzaria het blok">



</header>