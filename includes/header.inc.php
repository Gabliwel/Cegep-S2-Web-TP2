<?php 
    //permet d'adapter le header selon l'info de session
    $estConnecteHeader = lire_session("estConnecte");
    if($estConnecteHeader != false)
    {
        $clientHeader = obtenirClientEnSession($db, $estConnecteHeader);
        $clientPrenom = $clientHeader["prenom"];
    }
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark fw-bold">
        <div class="container-fluid">
            <a class="navbar-brand" href="accueil"><h1>漫画</h1></a><p class="text-white">LA BOUTIQUE</p>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <!-- Bouton dans la barre de nav pour voir les liens-->
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <!-- Liens dans la barre de nav -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produits">Nos produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="connexion"><?php echo (!$estConnecteHeader)?"Se connecter":"$clientPrenom"; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panier">Panier</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</header>