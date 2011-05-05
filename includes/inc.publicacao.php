<?php
/**
 * Descriчуo: Publicaчѕes
 */
switch ($_GET["secao"]){
    case "contato":
        include("inc.contato.php");
    break;
    default: include("inc.naoLocalizado.php");;break;
}