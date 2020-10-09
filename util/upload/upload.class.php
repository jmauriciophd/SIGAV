<?php
        /*
         *      @copyright                 :    Edimilson Sousa Quelipe
         *      @autor                     :    Edimilson Sousa Quelipe
         *      @data cria��o              :    14/07/2010
         *      @site                      :    www.quelipe.com.br
         *      @contato                   :    quelipe_@hotmail.com     
         */

        class upload {
        
                var $pasta;     // caminho de destino da imagem
                var $nome;      // nome da imagem
                var $lrgura;    // largura limite desejada
                var $altura;    // altura limite desejada
                var $tmp_name;  // nome tempor�rio da imagem
                var $img_marca; // caminho completo para a imagem da marca d'agua
                
                //m�todo para subir o arquivo para o servidor
                public function uploadArquivo() {
                        // http://br3.php.net/manual/pt_BR/function.end.php
                        // http://br3.php.net/manual/pt_BR/function.explode.php
                        $this->nome = $this->nomeRandomico().".".end(explode(".",$this->nome));
                        echo $this->nome;
                        // http://br3.php.net/manual/pt_BR/function.move-uploaded-file.php
                        if(move_uploaded_file($this->tmp_name, $this->pasta."/".$this->nome)) {
                        	echo "<br/>moveu";
                                $this->marcaDagua();
                                $this->redimensiona();
                        }
                }
                
                //m�todo para redimensionar a imagem
                private function redimensiona() {
                                                
                        $img = $this->pasta."/".$this->nome; 
                        // recupera tamanho da imagem e tipo
                        // http://br3.php.net/manual/pt_BR/function.getimagesize.php
                        list($larguraOriginal, $alturaOriginal, $type) = getimagesize($img);
                        // faz checagem se a redimens�o ser� via largura ou altura
                        if ($this->largura && ($larguraOriginal < $alturaOriginal)) {
                                $this->largura = ($this->altura / $alturaOriginal) * $larguraOriginal;
                        } else {
                                $this->altura = ($this->largura / $larguraOriginal) * $alturaOriginal;
                        }
                        // cria imagem com as dimensoes especificadas por parametro
                        // http://www.php.net/manual/pt_BR/function.imagecreatetruecolor.php
                        $novaImagem = imagecreatetruecolor($this->largura, $this->altura);
                        // cria imagem JPEG
                        // http://br3.php.net/manual/pt_BR/function.imagecreatefromjpeg.php
                        $image = imagecreatefromjpeg($img);
                        // http://br3.php.net/manual/pt_BR/function.imagecopyresampled.php
                        imagecopyresampled($novaImagem, $image, 0, 0, 0, 0, $this->largura, $this->altura, $larguraOriginal, $alturaOriginal);
                        // http://br3.php.net/manual/pt_BR/function.imagejpeg.php
                        imagejpeg($novaImagem, $img, 100);
                }
                
                //m�todo para colocar a marca d'agua na imagem
                private function marcaDagua() {

                        // Obt�m o cabe�alho de ambas as imagens
                        // http://br3.php.net/manual/pt_BR/function.imagecreatefrompng.php
                        $cab_marca  = imagecreatefrompng($this->img_marca);
                        // http://br3.php.net/manual/pt_BR/function.imagecreatefromjpeg.php
                        $cab_imagem = imagecreatefromjpeg($this->pasta."/".$this->nome);
                        // Obt�m os tamanhos de ambas as imagens
                        // http://br3.php.net/manual/pt_BR/function.getimagesize.php
                        $tam_imagem    = getimagesize($this->pasta."/".$this->nome);
                        $tam_marca     = getimagesize($this->img_marca);
                        $largura_img   = $tam_imagem[0];
                        $altura_img    = $tam_imagem[1];
                        $largura_marca = $tam_marca[0];
                        $altura_marca  = $tam_marca[1];
                        // Aqui, defini-se a posi��o onde a marca deve aparecer na foto: Rodap� Direito
                        $eixo_x = ($largura_img - $largura_marca) - 5;
                        $eixo_y = ($altura_img - $altura_marca) - 5;
                        // http://br3.php.net/manual/pt_BR/function.imagecolortransparent.php
                        // http://br3.php.net/manual/pt_BR/function.imagecolorallocate.php
                        imagecolortransparent($cab_marca, imagecolorallocate($cab_marca, 4, 137, 193));
                        // A fun��o principal: misturar as duas imagens
                        imageCopyMerge($cab_imagem, $cab_marca, $eixo_x, $eixo_y, 0, 0, $largura_marca, $altura_marca, 50);
                        // Cria a imagem com a marca da agua
                        // http://br3.php.net/manual/pt_BR/function.getimagesize.php
                        imagejpeg($cab_imagem, $this->pasta."/".$this->nome, 90);

                }
                
                //m�todo para gerar um nome randomico para o arquivo
                public function nomeRandomico() {
                        $novoNome = "";
                        for($i=0; $i<20; $i++) {
                                // http://br3.php.net/manual/pt_BR/function.rand.php
                                $novoNome .= rand(0,9); 
                        }
                        return $novoNome;
                }
        }
?>