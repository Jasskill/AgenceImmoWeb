<?php
class vue{
    public function entete(){
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <title>Document</title>
        </head>
        <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Agence Immo Web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=afficherPageAccueil">Annonces</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=afficherPageCommentaires">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=afficherPageArticle&id=1">Inscription</a>
                    </li>
                </ul>
                <div class="alig-end">
                <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
                </div>';
    }

    public function enteteLocataireCo(){
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <title>Document</title>
        </head>
        <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Agence Immo Web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=afficherPageAccueil">Annonces</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=afficherPageCommentaires">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=afficherPageArticle&id=1">Inscription</a>
                    </li>
                </ul>';
    }
    }
    public function fin(){
        echo "
        </body>
        </html>"
    }


?>