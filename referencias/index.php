<?php
    session_start();
    if($_POST){
        if($_POST["usuario"]==='fabricio'&&$_POST["senha"]=="123456"){
            $_SESSION["USUARIO"] = "fabricio";
            header("Location:app/viewer/index.php");
        }else{
            $_SESSION["USUARIO"] = "";
            echo "<h1>Inválido</h1><br><a href='index.php'>Retornar</a>";
            exit;
        }
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;">
        <title></title>
    </head>
    <body>
        <form name="form" action="index.php" method="post">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        Usuário<br />
                        <input type="text" name="usuario" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Senha<br />
                        <input type="password" name="senha" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Logar">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>