 <?php
 textColor('View All User\'s Activities');
                        //require_once('../dbcon/dbcon.php');

                        //$sql = 'select * from timtec';
                        //$result = $conn->query($sql);

                        /*
                        $sql = 'SELECT COUNT(*) as total FROM monitor'; // Get the total number of rows
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $totalRows = $row['total'];
                        
                        $rowsPerPage = 5; // Number of rows to display per page
                        $totalPages = ceil($totalRows / $rowsPerPage); // Calculate the total number of pages
                        
                        // Check if a page number is specified in the URL, otherwise default to the first page
                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $currentRow = ($currentPage - 1) * $rowsPerPage;
                        
                        // Retrieve the rows for the current page
                        $sql = "SELECT * FROM monitor LIMIT $rowsPerPage OFFSET $currentRow ORDER BY time_ref";

                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            echo "<table class='table table-dark table-hover table-responsive' id='tablesearch'>";
                            echo "<tr><th>Staff ID</th><th>Activities</th><th>Date/Time</th></tr>";
                            $sn = $currentRow + 1; // Start numbering from the current row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>". $row["staff_id"] ."</td>";
                                echo "<td>". $row["activity"] ."</td>";
                                echo "<td>". $row["time_ref"] ."</td>";
                                echo "<td>";
                                //echo "<button class='edit-button' rowId='" . $row["tim_id"] . "' onclick=\"enableEditRow(" . $row["tim_id"] . ")\" " . set_button_right() . ">Edit</button>";
                                //echo "<button class='cancel-button' rowId='" . $row["tim_id"] . "' onclick=\"cancelEditRow(" . $row["tim_id"] . ")\" " . set_button_right() . ">Cancel</button>";
                                //echo "<button class='delete-button' onclick=\"deleteRow(" . $row["tim_id"] . ")\" " . set_button_right() . ">Delete</button>";
                                //echo "</td>";
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
*/
$sql = "SELECT * FROM monitor ORDER BY time_ref DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table class='table table-dark table-hover table-responsive' id='tablesearch'>";
    echo "<tr><th>Staff ID</th><th>Activities</th><th>Date/Time</th></tr>";
    //$sn = $currentRow + 1; // Start numbering from the current row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>". $row["staff_id"] ."</td>";
        echo "<td>". $row["activity"] ."</td>";
        echo "<td>". $row["time_ref"] ."</td>";
        echo "<td>";
        //echo "<button class='edit-button' rowId='" . $row["tim_id"] . "' onclick=\"enableEditRow(" . $row["tim_id"] . ")\" " . set_button_right() . ">Edit</button>";
        //echo "<button class='cancel-button' rowId='" . $row["tim_id"] . "' onclick=\"cancelEditRow(" . $row["tim_id"] . ")\" " . set_button_right() . ">Cancel</button>";
        //echo "<button class='delete-button' onclick=\"deleteRow(" . $row["tim_id"] . ")\" " . set_button_right() . ">Delete</button>";
        //echo "</td>";
        echo "</tr>";
        //$sn++;
    }
    echo "</table>";
}

?>