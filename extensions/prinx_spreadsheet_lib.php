<?php
// Include the PhpSpreadsheet library
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadme'])) {
    // Get the uploaded file details
    $uploadedFile = $_FILES['uploadme']['tmp_name'];

    try {
        // Load the Excel file
        $spreadsheet = IOFactory::load($uploadedFile);

        // Select the first worksheet
        $worksheet = $spreadsheet->getActiveSheet();

        // Get the highest row and column indices
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();

        // Iterate through the rows and store the data
        for ($row = 1; $row <= $highestRow; $row++) {
            $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
            // Store the row data
            $data[] = $rowData[0];
        }
    } catch (Exception | InvalidArgumentException $exception) {
        //echo "An error occurred while loading the spreadsheet: " . $exception->getMessage();
        if ($exception instanceof PhpOffice\PhpSpreadsheet\Reader\Exception\ReaderException) {
            
        } elseif ($exception instanceof PhpOffice\PhpSpreadsheet\Exception) {
            //$_SESSION['error'] = '<p class="bg-danger text-white xlsx">You are trying to load nothing. Choose an Excel file and load'.' '.'<i class="fa-solid fa-comments text-white"></i></p>';
            //$_SESSION['error'] = '<p class="text-white xlsx">The file you choose to load is not an Excel file. Please load only Excel'.' '.'<i class="fa-solid fa-comments text-white"></i></p>';
        } else {
           // $_SESSION['error'] = '';
        }
        
    }
}
?>
