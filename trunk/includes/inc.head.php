<?php
/**
 * Descrição: Head
 */

/**
 * Descrição: Verifica se o navegado do visitante é IE
 */
$browser_cliente = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    if(strpos($browser_cliente, 'MSIE') !== false)  {
        $_BROWSER = "IE";
    }else{
        $_BROWSER = "";
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>Fabricio Nogueira</title>
