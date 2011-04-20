<?php
    /**
    * o------------------------------------------------------------------------------o
    * | This package is licensed under the Phpguru license. A quick summary is       |
    * | that for commercial use, there is a small one-time licensing fee to pay. For |
    * | registered charities and educational institutes there is a reduced license   |
    * | fee available. You can read more  at:                                        |
    * |                                                                              |
    * |                  http://www.phpguru.org/static/license.html                  |
    * o------------------------------------------------------------------------------o
    *
    * © Copyright 2008,2009 Richard Heyes
    */

    /**
    * Defaults
    */
    $smtp_server    = !empty($_GET['server']) ? $_GET['server'] : 'localhost';
    $smtp_port      = !empty($_GET['port']) ? $_GET['port'] : '25';
    $smtp_helo      = !empty($_GET['helo']) ? $_GET['helo'] : 'localhost';
    $smtp_from      = !empty($_GET['from']) ? $_GET['from'] : 'root@localhost';
    $message        = !empty($_GET['body']) ? $_GET['body'] : "\n\nThis is the body...";
    $smtp_recipient = !empty($_GET['recipient']) ? $_GET['recipient'] : 'root@localhost';
    $smtp_auth      = !empty($_GET['auth']) ? $_GET['auth'] : 0;
    $smtp_user      = !empty($_GET['user']) ? $_GET['user'] : '';
    $smtp_pass      = !empty($_GET['pass']) ? $_GET['pass'] : '';
?>

<html>
<head>
    <title>SMTP Test utility</title>
    
    <style type="text/css">
    <!--
        body {
            font-family: Arial, Verdana;
        }
    // -->
    </style>
</head>
<body>

<h1>SMTP test utility</h1>

<form action="example.php">
<table border="0">
    <tr>
        <td align="right">Server</td>
        <td><input type="text" name="server" value="<?=htmlspecialchars($smtp_server)?>" /></td>
    </tr>

    <tr>
        <td align="right">Port</td>
        <td><input type="text" name="port" value="<?=htmlspecialchars($smtp_port)?>" size="2" /></td>
    </tr>

    <tr>
        <td align="right">HELO</td>
        <td><input type="text" name="helo" value="<?=htmlspecialchars($smtp_helo)?>" /></td>
    </tr>

    <tr>
        <td align="right">From</td>
        <td><input type="text" name="from" value="<?=htmlspecialchars($smtp_from)?>" /></td>
    </tr>

    <tr>
        <td align="right">Recipient</td>
        <td><input type="text" name="recipient" value="<?=htmlspecialchars($smtp_recipient)?>" /></td>
    </tr>

    <tr>
        <td align="right" valign="top">Body</td>
        <td>
            <textarea name="body" cols="80" rows="5"><?=htmlspecialchars($message)?></textarea>
        </td>
    </tr>

    <tr>
        <td align="right">Use authentication?</td>
        <td><input type="checkbox" name="auth" value="1" <?=($smtp_auth ? 'checked' : '')?> /></td>
    </tr>

    <tr>
        <td align="right">Auth user</td>
        <td><input type="text" name="user" value="<?=htmlspecialchars($smtp_user)?>" /></td>
    </tr>

    <tr>
        <td align="right">Auth pass</td>
        <td><input type="password" name="pass" value="<?=htmlspecialchars($smtp_pass)?>" /></td>
    </tr>

    <tr>
        <td align="right" colspan="2">
            <input type="submit" value="Go &raquo;&raquo;" />
        </td>
    </tr>
</table>
    
</form>

<div style="border: 2px inset white">
    <pre style="padding-top: 0; margin-top: 0"><?php

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        require_once('smtp.php');
        
        ###############################################
        try {
            $smtp = new SMTP($smtp_server, $smtp_port, $smtp_helo, $smtp_auth, $smtp_user, $smtp_pass);
            $smtp->dbug = true;
            $smtp->Connect();
            $smtp->Send(array($smtp_recipient),                                     // Array of recipient addresses
                        $smtp_from,                                                 // SMTP From address
                        array('Subject' => 'The subject',
                              'To'      => $smtp_recipient,
                              'From'    => $smtp_from), // The emails headers
                        $message);                                                // The emails body (phwoar...)
        
        } catch (SMTPException $e) {
            echo $e->GetMessage();
        }
        ###############################################
    ?>
    </pre>
</div>

</body>
</html>