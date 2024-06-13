<!doctype html>
    <html lang="en">
    <head>
        <title>uploader</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" type="text/css" href="cssroaster.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <script src="js/jquery-3.6.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#replaced').hide();
                $('#exists').fadeOut(5000);

                $('#replaced').delay(5008)
                .fadeIn(3000);

            });
        </script>    

    </head>
    <body>
<?php
$fileExtension = strtolower(pathinfo($_FILES['uploadme']['name'],PATHINFO_EXTENSION));
$allowedExtensions = array('xlsx','csv');
if (!empty($_FILES['uploadme']['tmp_name']) && in_array($fileExtension, $allowedExtensions)) {
    // File is of allowed format and has been uploaded, continue with processing
    // Your code to move the uploaded file and process it using PhpOffice\PhpSpreadsheet

    // Example code to move the uploaded file to a directory
    $destination = 'documents/' . $_FILES['uploadme']['name'];
    if (file_exists($destination)){
        exists($_FILES['uploadme']['name']);
        unlink($destination);
        move_uploaded_file($_FILES['uploadme']['tmp_name'], $destination);
        replaced($_FILES['uploadme']['name']);
    }else{
    move_uploaded_file($_FILES['uploadme']['tmp_name'], $destination);

    // Load the file using PhpOffice\PhpSpreadsheet
    //$spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load($destination);
    echo '<p class="bg-danger text-white">The file '.$_FILES['uploadme']['name']. ' has been uploaded successfully. Click <a href="timtec_upload.php">here</a> to go back to page</p>';
    // Continue with your code to display the preview table and process the data
} }else {
    echo '<p class="bg-danger text-white">Invalid file format. Please upload an XLSX or CSV file.<br />You can return <a href="timtec_upload.php">back</a> to the page</p>';
}

function exists($value){
    echo '<p id="exists" class="bg-info">'.$value.' already exist and would be replaced. Please wait...</p>';
}
function replaced($value){
    echo'<p id="replaced" class="bg-info">'.$value.' has been successfully replaced. You can now go <a href="timtec_upload.php">back</a> to the page</p>';
}
?>
</body>
</html>