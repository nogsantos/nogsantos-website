<?php include("includes/inc.head.php") ?>
<?php include("includes/inc.css.php") ?>
<?php include("includes/inc.scripts.php") ?>
<div id="container">
    <span class="logoMain linkHome" id="linkHome">Fabricio Nogueira</span><br><br>
    <div id="conteudo">
        <?php include("includes/inc.bannerPrincipal.php"); ?>
        <?php include("includes/inc.menuPrincipal.php"); ?>
        <div id="descConteudo">
            <div id="divTitle">Sobre mim</div><br>
            <div style="font-style: italic;line-height:35px">
                <img src="imagens/double_quote.gif" style="float: left;position: relative;margin: 0 10px 1px 0 " alt="">
                Brasileiro, residente em Goi&acirc;nia - Go, graduado em Ciência da Computação,
                quase faixa preta de jiu jitsu, guitarrista sem banda, meditante que não medita,
                concurseiro que não estuda, quase um bolsista de dança de salão mais precisamente forró,
                programador nas horas vagas e nas horas não vagas também, solteiro e ex-integrante do grupo de pagode os xeirosos.
            </div>
        </div>
        <div id="meuTwitter">
            <div id="divTwitter">
                <? include("twitter/twitter.php"); ?>
            </div>
        </div>
    </div>
</div>
<?php include("includes/inc.rodape.php"); ?>
<?php include("includes/inc.googleAnalytics.php") ?>
</body>
</html>