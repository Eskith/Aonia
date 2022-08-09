<?php


class ProcesaArchivos 
{
    public static function ProcesaCSV($file):array
    {
        $arr = array_map('str_getcsv', is_string($file) ?  file($file) : $file);
        $headers = array_shift($arr);
        array_walk($arr, function(&$a) use ($headers) {$a = array_combine($headers, $a);});
        return $arr;
    }
}
