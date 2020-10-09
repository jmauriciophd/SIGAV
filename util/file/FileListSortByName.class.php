<?php

/**
*  NameSortDecorator
*  Adds sorting by filename to the file listing
*/
class FileListSortByName extends Decorator {
    /**
    * NameSortDecorator constructor
    *
    * @param object fileList (an instance of FileList)
    */
   public function FileListSortByName (& $fileList) {
        parent::Decorator($fileList);
    }
 
    /**
    * FileListSortByName::read()
    *
    * @return void
    */
    public function read () {
        $this->fileList->read();
        $sizes=array();
        foreach ( $this->fileList->ls as $row ) {
            $names[]=$row['name'];
        }
        array_multisort($names,SORT_ASC,SORT_NUMERIC,$this->fileList->ls);
    }
}

?>
