<?php
/**
 * Descrição: Inclusão dos scripts
 */
?>
<script type="text/javascript" src="js/interface/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/interface/js/jquery-ui-1.8.9.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript" src="js/jqtransformplugin/jquery.jqtransform.js"></script>
<script type="text/javascript" src="js/jq-corner.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery.colorbox.js"></script>
<script type="text/javascript">
    jQuery(function(){
        $(window).load(function(){
            $("#container").fadeIn(3333);
            $("#rodape").fadeIn(2222);
            $('#slider').nivoSlider();
            $("#home" ).button().click(function(){
                window.open("home.php",'_parent');
            });
            $("#curriculo" ).button().click(function(){
                window.open("site.php?secao=curriculo",'_parent');
            });
            $("#contato" ).button().click(function(){
                window.open("site.php?secao=contato",'_parent');
            });
            $("#pessoal" ).button().click(function(){
                window.open("site.php?secao=pessoal",'_parent');
            });
        });
        $(document).ready(function(){           
           var fonte = 1.2;
           var line = 1.4;
           $("#aumenta_fonte").click(function(){
                if (fonte<10){
                    fonte = fonte+0.1;
                    line = line+0.02;
                    $("#descConteudo").css({"font-size" : fonte+"em","line-height" : line+"em"});
                }
            });
            $("#reduz_fonte").click(function(){
                if (fonte>1.2){
                    fonte = fonte-0.1;
                    line = line-0.02;
                    $("#descConteudo").css({"font-size" : fonte+"em","line-height" : line+"em"});
                }
            });
        });
        /**
         * Definindo o estilo dos formulários
         **/
        $('form').jqTransform({imgPath:'js/jqtransformplugin/img/'});
        /**
         * Descrição: Chamada para o colorbox
         */
         $("a[rel='galeria']").colorbox({transition:"none",slideshow:true});
         /**
          * Descrição: Link para home
          *
          **/
         $("#linkHome").click(function(){
             window.open("home.php",'_self');
         });
    });//(jQuery)
    /**
     *
     * Descrição: Imprimir conteúdo da div
     *
     */
    function PrintElementID(id , pg) {
        var oPrint, oJan;
        oPrint  = window.document.getElementById(id).innerHTML;
        oJan    = window.open(pg);
        oJan.document.write(oPrint);
        oJan.history.go();
        oJan.window.print();
    }
    /**
     *
     * Descrição: Adicionar página aos favoritos
     *
     */
    function addFav(){
        if(confirm("Deseja adicionar meu site ao seus favoritos?\n")){
            var url      = "http://www.nogsantos.com.br";
            var title    = "Fabricio Nogueira";
            if (window.sidebar) {
                window.sidebar.addPanel(title, url,"");
            }else if(window.opera && window.print){
                var mbm = document.createElement('a');
                mbm.setAttribute('rel','sidebar');
                mbm.setAttribute('href',url);
                mbm.setAttribute('title',title);
                mbm.click();
            }else if(document.all){
                window.external.AddFavorite(url, title);
            }
        }
    }
</script>
</head>
    <body>