<?php
        session_start();
	    include_once('extensions/prinx_spreadsheet_lib.php');
        //<script src="js/js/jquery.js" type="text/javascript"></script>
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Using my spreadsheet library</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="css/fontawesome-free-6.4.0-web/css/all.css">
        <link rel="stylesheet" type="text/css" href="cssroaster.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <script src="js/jquery-3.6.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        
        <script src="js/bootstrap.js"></script>
        <script src="js/jquery.dataTables.js"></script>
        <script src="js/DT_bootstrap.js"></script>


        <style>
            .xlsx{
                width:80%;
                margin-left:auto;
                margin-right:auto;
            }
            #prinx_table tr{
                display: none;
            }
            #prvfile{
                position: relative;
            }
            #uploader{
                margin-left:auto;
                margin-right:auto;
                width:80%;
            }
        </style>
        
        <script>
            $(document).ready(function() {
                $('#prvfile').hide();
                $('#prv').fadeIn(2000);
                $('#prvfile').delay(1000)
                .slideDown(2000)
                .animate({left:'+=150px'},2000)
                .delay(400)
                .animate({left:'+=50px'},2000);

  $('#prinx_table tr').each(function(index) {
    $(this).delay(1000 * index).fadeIn(500);
  });

  $('#search').on('keyup', function() {
    var value = $(this).val().toLowerCase();
    $('#prinx_table tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
  
});


document.addEventListener('DOMContentLoaded', function() {
  var fileInput = document.getElementById('uploadme');
  var form = document.getElementById('myForm');

  form.addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent form submission

    // Store the file input value in localStorage
    localStorage.setItem('fileValue', fileInput.value);

    // Submit the form programmatically
    form.submit();
  });

  // Restore the file input value from localStorage
  var storedValue = localStorage.getItem('fileValue');
  if (storedValue) {
    fileInput.value = storedValue;
  }
});


        </script>

    </head>
    <body>
    <?php
//banner's module
	    include_once('extensions/banner.php');
    ?>
    <div class=="container">
        <div class="row">
            <h3 class="bg-primary text-white xlsx">TIMTEC -Upload your Excel Document</h3>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                Logged-In: <?= $_SESSION['spnumber'] ?>
            </div>
            <div class="col-sm-4">
                
            </div>
            <div class="col-sm-4">
                TIMTEC
            </div>
        </div>
    </div><br />    

        <form id="uploader" name="uploader" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <input type="file" name="uploadme" id="uploadme" value="<?= $_SESSION['file'] ?>">
            <input type="submit" id="submit" name="submit" value="Preview Document" class="btn btn-outline-primary btn-sm">
            <button class="btn btn-outline-success btn-sm" type="submit" formtarget="_blank" formaction="uploader.php">Upload Now</button>
        <?php //$_SESSION['error'] ?>
        </form>
<div class="container mt-5">
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadme'])) {
    echo '<h6><span class="bg-danger text-white" id="prv">You are previewing...</span><span id="prvfile">' . $_FILES['uploadme']['name'] . '(' . $_FILES['uploadme']['size'] . 'kb)</span></h6>';

    if (empty($data)) {
        echo '<p>No data found in the uploaded Excel file.</p>';
    } else {
        echo '<div class="table-responsive">
                <div class="row">
                    <div class="col-sm-6">
                        <input type="search" name="search" id="search" placeholder="Search...">
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <!-- some content here -->
                    </div>
                </div><br />
                <table class="table table-dark table-hover" id="prinx_table">
                    <thead>
                        <tr>';
        foreach ($data[0] as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>
                    </thead>
                    <tbody>';
        for ($i = 1; $i < count($data); $i++) {
            echo '<tr>';
            foreach ($data[$i] as $value) {
                echo '<td>' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>
            </table>
            </div>';
    }
}
?>

</div>

    <?php
//footer module
	    include_once('extensions/footer.php');
    ?>


    </body>
</html>