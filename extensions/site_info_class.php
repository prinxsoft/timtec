<?php

class Site {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getSiteInfo($fields = []) {
        $validFields = ['name', 'session', 'current_semester', 'institution', 'dead_date_comp','contact1', 'contact2', 'update_by'];
        
        // Check if any specific fields are requested
        if (!empty($fields)) {
            // Filter out invalid fields
            $requestedFields = array_intersect($validFields, $fields);
            
            // Construct the SELECT statement with requested fields
            $selectFields = implode(', ', $requestedFields);
            $sql = "SELECT $selectFields FROM site";
        } else {
            // Select all fields if no specific fields are requested
            $sql = "SELECT * FROM site";
        }
        
        // Execute the query
        $result = $this->conn->query($sql);
        
        // Check if the query was successful
        if ($result === false) {
            // Handle the error if necessary
            return null;
        }
        
        // Fetch the data from the result
        $data = $result->fetch_assoc();
        
        // Return the data
        return $data;
    }
}
?>