//For the categories
function mouseOver(nomId){ document.getElementById(nomId).style.display= "inline"; }
function mouseOut(nomId){ document.getElementById(nomId).style.display= "none"; }  
/**********************************************************************************/
//For the paiement
/*function afficheFormCB(){ 
    document.getElementById("formPP").style.display="none";
    document.getElementById("formPL").style.display="none";
    document.getElementById("formCB").style.display="block";
}*/

function afficheFormPP(){ 
    document.getElementById("formPL").style.display="none";
    document.getElementById("formCB").style.display="none";
    document.getElementById("formPP").style.display="block"; 
}
function afficheFormPL(){ 
    document.getElementById("formCB").style.display="none";
    document.getElementById("formPP").style.display="none";
    document.getElementById("formPL").style.display="block"; 
}

