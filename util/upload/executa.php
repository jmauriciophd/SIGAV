<?php
        /*
         *      @copyright                 :    Edimilson Sousa Quelipe
         *      @autor                     :    Edimilson Sousa Quelipe
         *      @data cria��o              :    14/07/2010
         *      @site                      :    www.quelipe.com.br
         *      @contato                   :    quelipe_@hotmail.com     
         */

        include "upload.class.php";                 // inclus�o da classe
        $up = new upload();                         // inst�ncia do objeto
        $up->pasta     = "C:/wamp/www/sigav/testes";                   // pasta de destino 
        $up->nome      = $_FILES['file']['name'];   // nome da imagem enviada do form
        $up->tmp_name  = "C:/wamp/www/sigav/temp/";            // arquivo tempor�rio
        $up->img_marca = "teste.png";                // caminho da imagem que ser� marca d'agua (.png)
        $up->largura   = "450";                      // m�xima largura para a nova foto
        $up->altura    = "450";                      // m�xima altura para a nova foto
        $up->uploadArquivo();                        // execu��o do m�todo
        
        //echo "<script>history.back();</script>";
?>