<div class="col-sm-9">
<?php
//require_once('add_record.php');
?>


<div id='tabs'>
                <ul>
                    <li><a href='#new'>New Users</a></li>
                    <li><a href='#update'>Update Users</a></li>
                    <?php
                    if ($_SESSION['super_admin'] ==1){
		                    include_once('activity_link.php');
	                    }
                      ?>
                </ul>
                
                <div id='new'>
                    <?php 
                        if(isset($_GET['mess'])){
                            echo empty_val($_GET['mess']);
                            //echo 'You have a message';
                        }
                    ?>
                    <?= textColor('Register Admin/TIMTEC Users')?>
                    <form method="post" action="add_record.php">
        <div class="container">
            <p class="text-danger">Please fill in this form to create a new users account.</p>
            <hr>
            <div class="mb-3">
                <label for="staffid"><b>Staff ID</b></label>
                <input type="text" placeholder="SP0000" name="staffid" id="staffid" <?= set_right() ?> required>
            </div>
            <div class="mb-3">
                <label for="email"><b>Official Email</b></label>
                <input type="email" placeholder="johndoe@funaab.edu.ng" name="email" id="email" <?= set_right() ?> required>
            </div>
            <div class="mb-3">
                <label for="email"><b>Is Super Admin:</b></label>
                <select name="super_admin" class="bg-info text-white" <?= set_right() ?>>
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                </select>
            </div>
            <hr>

            <p class="text-danger">By creating this account you agree to our <a href="#">Terms & Privacy</a>.</p>
            <button type="submit" name="subadmin" class="registerbtn" <?= set_right() ?>>Register</button>
        </div> 
    </form>
                    
</div>
                        <div id="activities">
                          <?php
                            if ($_SESSION['super_admin'] ==1){
		                              include_once('all_user_activity.php');
	                            }else{
                                textColor('No right to view user\'s Activities');
                              }
                          ?>
                        </div>
                <div id = "update">
                        
                        <?php 
                            if (isset($_GET['message'])){
                                echo empty_val($_GET['message']);
                            }
                            if (isset($message)){
                              echo empty_val($message);
                          }  
                        ?>
                        <?= textColor('Delete/Modify Users')?>
                    <div class="row">
                        <div class="col-sm-4">
                              <span class="">
                                  <a href='prinx_PDF_classuser.php'>Download PDF</a> <i class="fas fa-file-pdf text-danger"></i>
                              </span>
                        </div>
                        <div class="col-sm-8">
                              <?php
                                  if (isset($_GET['pdf'])){
                                    echo empty_val($_GET['pdf']);
                                }
                              ?>
                        </div>
                        
                    </div>
                    
                    <br />
                    <div class="row">
                      <div class="col-sm-6">
                          <div>
                            <input type="text" id="search" placeholder="Enter search term">
                          </div>
                      </div>
                      <div class="col-sm-6">
                        
                      </div>
                    </div>
                    <?php
                        //require_once('dbcon/dbcon.php');

                        //$sql = 'select * from timtec';
                        //$result = $conn->query($sql);

                        
                        $sql = 'SELECT COUNT(*) as total FROM timtec'; // Get the total number of rows
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $totalRows = $row['total'];
                        
                        $rowsPerPage = 5; // Number of rows to display per page
                        $totalPages = ceil($totalRows / $rowsPerPage); // Calculate the total number of pages
                        
                        // Check if a page number is specified in the URL, otherwise default to the first page
                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $currentRow = ($currentPage - 1) * $rowsPerPage;
                        
                        // Retrieve the rows for the current page
                        $sql = "SELECT * FROM timtec LIMIT $currentRow, $rowsPerPage";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            echo "<table class='table table-dark table-hover table-responsive' id='tablesearch'>";
                            echo "<tr><th>SN</th><th>SP Number</th><th>Email</th><th>Actions</th></tr>";
                            $sn = $currentRow + 1; // Start numbering from the current row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $sn . "</td>";
                                echo "<td><input class='bg-dark text-white textbox row" . $row["tim_id"] . "' type='text' value='" . $row["staff_id"] . "' disabled></td>";
                                echo "<td><input class='bg-dark text-white textbox row" . $row["tim_id"] . "' type='text' value='" . $row["off_email"] . "' disabled></td>";
                                echo "<td>";
                                echo "<button class='edit-button' rowId='" . $row["tim_id"] . "' onclick=\"enableEditRow(" . $row["tim_id"] . ")\" " . set_button_right() . ">Edit</button>";
                                echo "<button class='cancel-button' rowId='" . $row["tim_id"] . "' onclick=\"cancelEditRow(" . $row["tim_id"] . ")\" " . set_button_right() . ">Cancel</button>";
                                echo "<button class='delete-button' onclick=\"deleteRow(" . $row["tim_id"] . ")\" " . set_button_right() . ">Delete</button>";
                                echo "</td>";
                                echo "</tr>";
                                $sn++;
                            }
                            echo "</table>";
                        
                            // Display pagination links
                            
                            echo "<div class='pagination'><ul class='pagination'>";
                            for ($page = 1; $page <= $totalPages; $page++) {
                                echo "<li class='page-item'><a href='?page=" . $page . "' class='page-link'>" . $page . "</a></li> ";
                            }
                            echo "</ul></div>";
                            
                        }
                         else {
    $message = "No results found.";
}

$conn->close();

?>                 

<script>
$(document).ready(function() {
  // Event listener for search input keyup
  $('#search').on('keyup', function() {
    var value = $(this).val().toLowerCase();
    var rows = $('#tablesearch tbody tr').slice(1); // Exclude the first row

    rows.filter(function() {
      var rowText = $(this).text().toLowerCase();
      var inputValues = $(this).find('input[type="text"]').map(function() {
        return $(this).val().toLowerCase();
      }).get().join(' ');
      var searchContent = rowText + ' ' + inputValues;
      $(this).toggle(searchContent.indexOf(value) > -1);
    });
  });
});


function enableEditRow(rowId) {
  // Find the edit button with the specific rowId
  var editButton = $('.edit-button[rowId="' + rowId + '"]');

  // Find the parent row of the edit button
  var row = editButton.closest('tr');

  // Enable the textboxes within the row
  row.find('.textbox.row' + rowId).prop('disabled', false);

  // Change the button text to 'Update'
  editButton.text('Update');

  // Change the onclick event of the edit button to 'updateRow'
  editButton.attr('onclick', 'updateRow(' + rowId + ')');
}

function cancelEditRow(rowId) {
  // Find the edit button with the specific rowId
  var editButton = $('.edit-button[rowId="' + rowId + '"]');

  // Find the parent row of the edit button
  var row = editButton.closest('tr');

  // Disable the textboxes within the row
  row.find('.textbox.row' + rowId).prop('disabled', true);

  // Change the button text back to 'Edit'
  editButton.text('Edit');
  editButton.attr('onclick', 'enableEditRow(' + rowId + ')');
}

function updateRow(rowId) {
  // Find the row with the specific rowId
  var row = $('.edit-button[rowId="' + rowId + '"]').closest('tr');

  // Retrieve the values from the textboxes within the row
  var staffId = row.find('.textbox.row' + rowId + ':eq(0)').val();
  var offEmail = row.find('.textbox.row' + rowId + ':eq(1)').val();

  // Prepare the data to be sent via AJAX
  var data = {
    rowId: rowId,
    staffId: staffId,
    offEmail: offEmail
  };

  // Send the AJAX request to update_row.php
  $.ajax({
    url: '../update_row.php',
    type: 'POST',
    data: JSON.stringify(data),
    contentType: 'application/json',
    success: function(response) {
      // Parse the JSON response
      var jsonResponse = JSON.parse(response);

      // Access the status and message from the response
      var status = jsonResponse.status;
      var message = jsonResponse.message;

      // Handle the response accordingly
      if (status === 'success') {
        // Display a success message or perform any additional actions
        alert(message);
      } else {
        // Display an error message or handle the error case
        alert('Error: ' + message);
      }
    },
    error: function(xhr, status, error) {
      // Handle the error case
      alert('AJAX Error: ' + error);
    }
  });
}

function deleteRow(rowId) {
  // Find the edit button with the specific rowId
  var editButton = $('.edit-button[rowId="' + rowId + '"]');

  // Find the parent row of the edit button
  var row = editButton.closest('tr');

  // Enable the textboxes within the row
  // row.find('.textbox.row' + rowId).prop('disabled', false);

  // Change the button text to 'Update'
  editButton.text('Update');

  var staffId = row.find('.textbox.row' + rowId + ':eq(0)').val();

  // Prompt the user for confirmation
  var confirmDelete = confirm('Are you sure you want to delete this row?');
  
  if (confirmDelete) {
    // Prepare the data to be sent via AJAX
    var data = {
      staffId: staffId
    };

    $.ajax({
      url: 'delete_row.php',
      type: 'POST',
      data: data,
      dataType: 'json', // Expect JSON response from the server
      success: function(response) {
        // Handle the response from the server
        if (response.status === 'success') {
          // Display a success message or perform any additional actions
          alert(response.message);
          // Remove the deleted row from the table
          row.remove();
        } else {
          // Display an error message or handle the error case
          alert('Error: ' + response.message);
        }
      },
      error: function(xhr, status, error) {
        // Handle the error case
        alert('AJAX Error: ' + error);
      }
    });
  }
}

</script>
    </div>
</div>
<?php
function textColor($value){
    return '<h5 class="text-success">'.$value.'</h5><br />';
}
function empty_val($value){
    return '<p><span class="text-danger">'.$value.'</span> <i class="fa-solid fa-circle-exclamation text-info"></i></p>';
}
function validator($value){
    include("dbcon/dbcon.php");
$value = stripslashes($value);
$value = mysqli_real_escape_string($conn,$value);
$value = preg_replace('/\s+/', '', $value);
$value = strtoupper($value);
return $value;
}
?>