<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="./style.css" /> 
	<title>Padlet</title>
	<script src="./java.js"></script>
</head>
<body>
    <div id="Modal" class="Modal">
        <a href="javascript:void(0)" class="closeConne" onclick="closeConne()">&times;</a>
        <h1>Identifiant :</h1>
        <input type="text" id="id" class="id">
        <h1>Mot de passe :</h1>
        <input type="password" id="mdp" class="mdp">
        <br>
        <h4 id="faux"></h4>
        <button onclick="connected()" id="connected" class="verif">Connexion</button>
    </div>
