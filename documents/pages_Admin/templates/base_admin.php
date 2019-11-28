<!doctype html>

<html lang="fr">

<head>
  <meta charset="utf-8">

  <title>Interface Administrateur</title>

  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
<script src="js/main.js"></script>
</head>

<body>

  <div class="main-grid">

    <!-- NAVIGATION ADMIN -->
    <div class="navbar-admin">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navTop">
        <div class="container1" onclick="myFunction(this)">
          <div class="bar1"></div>
          <div class="bar2"></div>
          <div class="bar3"></div>
        </div>
        <a class="navbar-brand" href="#">Le Labernois</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav w-100">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  Fichier
                </a>
                <div class="dropdown-menu fade" aria-labelledby="navbarDropdown dropdownMenuOffset">
                  <a class="dropdown-item" href="#">Enregistrer un brouillon</a>
                  <a class="dropdown-item" href="#">Enregistrer le circuit</a>
                  <a class="dropdown-item" href="#">Charger la version précédente</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Partager</a>
                  <a class="dropdown-item" href="#">Exporter</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Modifier
                  </a>
                  <div class="dropdown-menu fade" aria-labelledby="navbarDropdown dropdownMenuOffset">
                    <a class="dropdown-item" href="#">Annuler</a>
                    <a class="dropdown-item" href="#">Rétablir</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Réinitialiser</a>
                    <a class="dropdown-item" href="#">Déplacer</a>
                  </div>
                </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Tarification</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Disponibilités</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">Mon compte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Se déconnecter</a>
                  </li>
          </ul>
        </div>
      </nav>
    </div>

    <!-- MENU VERTICAL ADMIN -->

    <div class="menu-vertical-admin" id="myGroup">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a classs="nav-link" href="#collapseComptes" data-toggle="collapse" aria-expanded="false"
            aria-controls="collapseComptes"><img src="img/people-24px.svg"></a>
          <div class="collapse" id="collapseComptes" data-parent="#myGroup">
            <p>Comptes employés</p>
            <p>Comptes clients</p>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#collapseCircuit" data-toggle="collapse" aria-expanded="false"
            aria-controls="collapseCircuit"><img src="img/all_inclusive-24px.svg"></a>
          <div class="collapse" id="collapseCircuit" data-parent="#myGroup">
            <p>Gestion des circuits</p>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#collapseFinances" data-toggle="collapse" aria-expanded="false"
            aria-controls="collapseFinances"><img src="img/trending_up-24px.svg"></a>
          <div class="collapse" id="collapseFinances" data-parent="#myGroup">
            <p>Rapports financiers</p>
            <p>Paiements</p>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#collapseAffichage" data-toggle="collapse" aria-expanded="false"
            aria-controls="collapseAffichage"><img src="img/style-24px.svg"></a>
          <div class="collapse" id="collapseAffichage" data-parent="#myGroup">
            <p>Affichage accueil</p>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#collapseObjets" data-toggle="collapse" aria-expanded="false"
            aria-controls="collapseObjets"><img src="img/library_add-24px.svg"></a>
          <div class="collapse" id="collapseObjets" data-parent="#myGroup">
            <p>Hébergement</p>
            <p>Restauration</p>
            <p>Activités</p>
          </div>
        </li>
      </ul>
    </div>

    <!-- CONTENU -->
    <div class="interface-content">
        <?php startblock('content'); ?>
        <?php endblock(); ?>
    </div>
  </div>


</body>

</html>
