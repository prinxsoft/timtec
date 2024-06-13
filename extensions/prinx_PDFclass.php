<?php
include_once('../libraries/fpdf185/fpdf.php'); // Include the FPDF library

class PDFGenerator extends FPDF
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $logoPath;
    private $topHeading;
    private $footer;

    public function __construct($servername, $username, $password, $dbname, $logoPath, $topHeading, $footer)
    {
        parent::__construct();
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->logoPath = $logoPath;
        $this->topHeading = $topHeading;
        $this->footer = $footer;
    }

    public function generatePDF($tableName, $outputFile)
    {
        $this->AddPage();

        // Output the logo
        if ($this->logoPath !== '') {
            $this->Image($this->logoPath, 10, 10, 30, 30); // Adjust the position and size as needed
        }

        // Output the top heading
        $this->SetFont('Arial', 'B', 14);
        $this->MultiCell(0, 10, $this->topHeading, 0, 'C');
        $this->Ln(15); // Adjust the line break as needed

        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM " . $tableName;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $this->outputTableHeaders($result);
            $this->outputTableData($result);
        } else {
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, 'No records found', 1, 1, 'C');
        }

        $conn->close();

        $this->AliasNbPages();
        $this->Output($outputFile, 'F');
    }

    private function outputTableHeaders($result)
    {
        $headerRow = $result->fetch_assoc();
        foreach ($headerRow as $header) {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(40, 10, $header, 1);
        }
        $this->Ln();
    }

    private function outputTableData($result)
    {
        $this->SetFont('Arial', '', 12);
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $value) {
                $this->Cell(40, 10, $value, 1);
            }
            $this->Ln();
        }
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, $this->footer, 0, 0, 'C');
    }
}
?>
