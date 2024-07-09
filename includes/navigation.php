<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
    <div class="container">
        <a class="navbar-brand" href="./">Formation PHP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo pageActive('index.php') ?> " href="./">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo pageActive('superglobales.php') ?> " href="./superglobales.php">Superglobales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo pageActive('fonctions.php') ?> " href="./fonctions.php">Les Fonctions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo pageActive('fichiers.php') ?> " href="./fichiers.php">Les Fichiers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo pageActive('mysql.php') ?> " href="./mysql.php">MySql</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo pageActive('miniwiki.php') ?> " href="./miniwiki.php">Mini Wiki</a>
                </li>
                <!-- 
                <li class="nav-item">
                    <a class="nav-link <?php echo pageActive('/mediatheque/index.php') ?> " href="./mediatheque/">Mediatheque</a>
                </li>
                -->
            </ul>
        </div>
    </div>
</nav>