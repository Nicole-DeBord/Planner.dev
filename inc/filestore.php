<?php


class Filestore
{

    public $filename;

    function __construct($input) {
        $this->filename = $input;
    }

     /**
      * Returns array of lines in $this->filename
      */
    function addFromFile() {
        $contentsArray = []; 
        if(filesize($this->filename) > 0) {   
            $handle = fopen($this->filename, 'r');
            $contents = trim(fread($handle, filesize($this->filename)));
            $contentsArray = explode("\n", $contents);
            fclose($handle);
        }
        return $contentsArray;
    }

     /**
      * Writes each element in $array to a new line in $this->filename
      */
    function overwriteFile($items) {
        $handle = fopen($this->filename, 'w');
        foreach($items as $item) {
            fwrite($handle, $item . PHP_EOL);
        }
    fclose($handle);
    }

     /**
      * Reads contents of csv $this->filename, returns an array
      */
    public function openCSV() {
        $handle = fopen($this->filename, 'r');
        $array = [];
        while(!feof($handle)) {
            $row = fgetcsv($handle);

            if(!empty($row)) {
            $array[] = $row;
          }
        }
        fclose($handle);
        return $array;
      }

     /**
      * Writes contents of $array to csv $this->filename
      */
  public function saveCSV ($array) {
    $handle = fopen($this->filename, 'w');
    foreach ($array as $row) {
      fputcsv($handle, $row);
      }
    fclose($handle);
  }
}
