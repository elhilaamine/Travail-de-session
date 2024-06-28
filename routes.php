<?php

require_once __DIR__.'/router.php';


//les routes statiques
get ('/index.php', 'index.php');
get ('/','index.php');
get('/login.php','login.php');
post('/login.php','login.php');
any('/nouveau_compte.php','/nouveau_compte.php');
get ('/recette.php', 'recette.php');


//les routes dynamiques
get('/api/recettes','/api/listeRecettes.php');
get('/api/recettes/$id' ,'/api/id.php');
get('/api/recettes/type_plat/$id', '/api/obtenirTypePlat.php');
post('/api/recettes','/api/nouvelleRecettes.php');
put('/api/recettes/$id','/api/modificationRecette.php');


//cree
get('/api/postit','/api/creePostit.php');



any('/404','views/404.php');
