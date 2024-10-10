var id = document.getElementById("id").value;
var mdp = document.getElementById("mdp").value;
var faux = document.getElementById("faux");
var url = 'file:///C:/Users/dahir/OneDrive%20-%20OGEC%20Sainte-Famille/Documents/SFTP/page1.html';
var url2 = 'file:///C:/Users/dahir/OneDrive%20-%20OGEC%20Sainte-Famille/Documents/SFTP/Padstefa/log.html';

function connected(){
    if (id == "pierre" && mdp =="je"){
        document.location.replace(url);
    } else if (id != "pierre"){
        faux.innerHTML = "L'identifiant est incorrect.";
    } else if (mdp != "je"){
        faux.innerHTML = "Le mot de passe est incorrect.";
    }
}

function page1(){
    document.location.replace(url2);
}

function log(){
    document.location.replace(url);
}