        <?include("includes/inc.head.php")?>
        <?include("includes/inc.css.php")?>
        <?include("includes/inc.scripts.php")?>
        <!--twitter-->
        <link rel="stylesheet" type="text/css" href="twitter/demo.css" />
        <!--        <link rel="stylesheet" type="text/css" href="twitter/jScrollPane/jScrollPane.css" />-->
        <!--        <script type="text/javascript" src="twitter/jScrollPane/jquery.mousewheel.js"></script>-->
        <!--        <script type="text/javascript" src="twitter/jScrollPane/jScrollPane-1.2.3.min.js"></script>-->
        <script type="text/javascript" src="twitter/script.js"></script>
        <!--[if lt IE 7]>
        <style type="text/css">
        div.tweet {
            background:none;
            border:none;
        }
        div#twitIcon{
            filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=img/twitter_64.png, sizingMethod=crop);
        }
        div#twitIcon img{
            display:none;
        }
        </style>
        <![endif]-->
        <div id="container">
            <div id="conteudo">
                <span class="logoMain" id="linkHome">Fabricio Nogueira</span><br /><br />
                <?include("includes/inc.bannerPrincipal.php")?>
                <?include("includes/inc.menuPrincipal.php")?>
                <div id="descConteudo">
                    <div id="divTitle">Sobre mim</div><br />
                    <div style="font-style: italic;line-height:35px">
                        <img src="imagens/double_quote.gif" style="float: left;position: relative;margin: 0 10px 1px 0 " />
                        Brasileiro, residente em Goi&acirc;nia - Go, graduado em Ciência da Computação,
                        quase faixa preta de jiu jitsu, guitarrista sem banda, meditante que não medita,
                        concurseiro que não estuda, quase um bolsista de dança de salão mais precisamente forró,
                        programador nas horas vagas e nas horas não vagas também, solteiro e ex-integrante do grupo de pagode os xeirosos.
                    </div>
                </div>
                <div id="meuTwitter">
<!--                    <div id="divLikedin">
                     AddThis Button BEGIN 
                    <div class="addthis_toolbox addthis_default_style ">
                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                        <a class="addthis_counter addthis_pill_style"></a>
                    </div>
                    <script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
                    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4d9883d77466843b"></script>
                    </div>-->
<!--                    <div id="divTwitter">
                        <aa?include("twitter/twitter.php");?>
                    </div>-->
                    <!-- AddThis Button END -->
<!--                    <div class="corner1" style="position: relative;float:right;padding: 20px 0 20px 20px;">
                        <script src="http://connect.facebook.net/pt_BR/all.js#xfbml=1"></script><fb:like href="http://www.nogsantos.com.br/" show_faces="true" width="300" font="verdana"></fb:like>
                    </div>-->
                </div>                
            </div>
        </div>
    <?include("includes/inc.rodape.php");?>
    </body>
</html>
<?include("includes/inc.googleAnalytics.php")?>
