<?php
        /*
         *      @copyright                 :    Edimilson Sousa Quelipe
         *      @autor                     :    Edimilson Sousa Quelipe
         *      @data criação              :    14/07/2010
         *      @site                      :    www.quelipe.com.br
         *      @contato                   :    quelipe_@hotmail.com     
         */

        include "upload.class.php";                 // inclusão da classe
        $up = new upload();                         // instância do objeto
        $up->pasta     = "C:/wamp/www/sigav/testes";                   // pasta de destino 
        $up->nome      = $_FILES['file']['name'];   // nome da imagem enviada do form
        $up->tmp_name  = "C:/wamp/www/sigav/temp/";            // arquivo temporário
        $up->img_marca = "teste.png";                // caminho da imagem que será marca d'agua (.png)
        $up->largura   = "450";                      // máxima largura para a nova foto
        $up->altura    = "450";                      // máxima altura para a nova foto
        $up->uploadArquivo();                        // execução do método
        
        //echo "<script>history.back();</script>";
?>