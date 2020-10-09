<?php

/**
 * Classe para a exibicao de imagem
 *@author gedal
 */
class HTMLImage extends HTMLElement {
	/**
	 * instancia o objet HTMLImage;
	 *
	 * @param string $src = localizacao da imagem;
	 */
    public function __construct($src) {

        parent::__construct("img");
        $this->src = $src ;
        $this->border='0' ;

    }
}
?>