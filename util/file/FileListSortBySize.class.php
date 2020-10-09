<?php
/**
*  SizeSortDecorator
*  Adds sorting by filesize to the file listing
*/
class FileListSortBySize extends Decorator {
    /**
    * SizeSortDecorator constructor
    *
    * @param object fileList (an instance of FileList)
    */
    public function FileListSortBySize($fileList) {
        Decorator::Decorator($fileList);
    }
 
    /**
    * FileListSortBySize::read()
    *
    * @return void
    */
    public function read () {
        $this->fileList->read();
        $sizes=array();
        foreach ( $this->fileList->ls as $row ) {
            $sizes[]=$row['size'];
        }
        array_multisort($sizes,SORT_DESC,SORT_NUMERIC,$this->fileList->ls);
    }
}

?>
	
