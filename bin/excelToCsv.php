#!/usr/bin/php
<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if(!array_key_exists(1, $argv))
{
    echo "Missing File Argument \n";
    exit;
}

$inputFileName = $argv[1];

if(!file_exists($inputFileName))
{
    echo "File does not exists \n";
    exit;
}

$newFile = pathinfo($inputFileName, PATHINFO_DIRNAME) . '/'. pathinfo($inputFileName, PATHINFO_FILENAME) . '.csv';

$inputFileType = IOFactory::identify($inputFileName);

$reader = IOFactory::createReader($inputFileType);
$spreadsheet = $reader->load($inputFileName);

$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

$f = fopen($newFile, 'w');
foreach ($sheetData as $row)
{
    fputcsv($f, $row);
}

fclose($f);

echo "Done \n";
