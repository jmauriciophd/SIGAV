<?php
/**
*  FileListSortByType
*  Adds sorting by filetype to the file listing
*/
class FileListSortByType extends Decorator {
    /**
    * TypeSortDecorator constructor
    *
    * @param object fileList (an instance of FileList)
    */
    public function FileListSortByType (& $fileList) {
        parent::Decorator($fileList);
    }
 
    /**
    * FileListSortByType::read()
    *
    * @return void
    */
    public  function read () {
        $this->fileList->read();
        $sizes=array();
        foreach ( $this->fileList->ls as $row ) {
            $types[]=$row['type'];
        }
        array_multisort($types,SORT_ASC,SORT_STRING,$this->fileList->ls);
    }
	
	
    /**
    * FileListSortByType::read()
    *
    * @return void
    */
    public  function readReverse () {
        $this->fileList->read();
        $sizes=array();
        foreach ( $this->fileList->ls as $row ) {
            $types[]=$row['type'];
        }
        array_multisort($types,SORT_DESC,SORT_STRING,$this->fileList->ls);
    }
}


?>