<?php


class Filestore
{

    public $filename;

    protected $isCSV = false;
    protected $isTXT = false;

    function __construct($filename) {
        $this->filename = $filename;

        if (!file_exists($filename)) {
          touch($filename);
        }

        if (substr($filename, -3) == 'csv') {
          $this->isCSV = true;
        }

        if (substr($filename, -3) == 'txt') {
          $this->isTXT = true;
        }

    }

     /**
      * Returns array of lines in $this->filename
      */
    protected function readLines() {
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
    protected function writeLines($items) {
        $handle = fopen($this->filename, 'w');
        foreach($items as $item) {
            fwrite($handle, $item . PHP_EOL);
        }
    fclose($handle);
    }

     /**
      * Reads contents of csv $this->filename, returns an array
      */
    protected function readCSV() {
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
  protected function writeCSV ($array) {
    $handle = fopen($this->filename, 'w');
    foreach ($array as $row) {
      fputcsv($handle, $row);
      }
    fclose($handle);
  }


    public function read() {
      if($this->isCSV == true) {
        return $this->readCSV();
      }

      if($this->isTXT == true) {
        return $this->readLines();
      }
    }


    public function write($array) {
      if($this->isCSV == true) {
        return $this->writeCSV($array);
      }

      elseif($this->isTXT == true) {
        return $this->writeLines($array);
      }
    }


}
