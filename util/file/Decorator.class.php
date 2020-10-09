<?php
/**
*  Decorator
*  Abstract decorator for FileList
*/
class Decorator extends FileList {
    /**
    * An instance FileList (or child)
    * 
    * @var  object
    */
   protected $fileList;
 
    /**
    * Decorator constructor
    *
    * @param object fileList (an instance of FileList)
    */
    public function Decorator(& $fileList) {
        $this->fileList=& $fileList;
    }
 
    /**
    * Decorator::read()
    * Passes on request to parent
    *
    * @return void
    */
   public  function read () {
        $this->fileList->read();
    }
 
    /**
    * Decorator::getNext()
    * Passes on request to parent
    *
    * @return string
    */
    public function getNext () {
        return $this->fileList->getNext();
    }
 
    /**
    * Decorator::close()
    * Passes on request to parent
    *
    * @return void
    */
    public function close () {
        $this->fileList->close();
    }
}
 
?>