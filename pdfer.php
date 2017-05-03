<?php
require('app/fpdf.php');
require_once('app/utilities.class.php');
require_once('app/configurator.class.php');

class PDFer extends FPDF {
   public $rptTitle;
   private $Conn;
   //_______________________________________________________________________________________________________________________________________
   function connectDB() {
      $this->Conn = new mysqli('localhost', 'root', 'Borabu12', 'labooks');
   //			$this->Conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      if ( mysqli_connect_errno() ) {
         return $this->error("DB Connection Error: ". mysqli_connect_error());
      }
   }

   //_______________________________________________________________________________________________________________________________________
// Page header
   function Header() {
      //$this->Image('logo.png',10,6,30);    // Logo
      $this->SetFont('Arial','B',15);    // Arial bold 15
      $this->Cell(80);    // Move to the right
      $this->Cell(30, 10, 'three09 Books', 0, 2, 'C');    // Title
      $this->Cell(30, 10, $this->rptTitle   , 0, 0, 'C');    // Title
      $this->Ln(20);    // Line break
   }

   //_______________________________________________________________________________________________________________________________________
   // Page footer
   function Footer() {
      $this->SetY(-15);    // Position at 1.5 cm from bottom
      $this->SetFont('Arial','I',8);    // Arial italic 8
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');    // Page number
   }

   //_______________________________________________________________________________________________________________________________________
   public function PrintOrderList() {
      $this->SetTitle('Book Order List');
      $this->rptTitle = 'Book Order List';
      $this->AliasNbPages();
      $this->AddPage();
      $this->SetFont('Times','',12);
      $sql = "SELECT BookTitle, Quantity, booklist.ID FROM orderlist INNER JOIN booklist on orderlist.ItemID = booklist.ID where orderlist.InventoryType =1" ;// where ID = ".$this->IssueID;
      $result = $this->Conn->query($sql);
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $this->Cell(0,10,$row['BookTitle'], 0, 0);
            $this->Cell(0,10,$row['Quantity' ], 0, 1);
//            $s .= R0 . $this->u->DoField(1, '', 'ID'       , FTHIDDEN  , $row['ID'], 20, 20, 1, TRUE) . S0 ;
         }
      }
      //for($i=1;$i<=40;$i++)
         //$this->Cell(0,10,'Printing line number '.$i, 0, 1);
   }

   //_______________________________________________________________________________________________________________________________________
   public function SelectReport($rptNum) {
      $this->connectDB();
      $this->PrintOrderList();
      $this->Output();
   }

}

// Instanciation of inherited class
      if (isset($_POST['ripota'])){
         $s = $_POST['ripota'];
         if ($s == 77){
            $ReportNum = $_POST['siit'];
            $pdf = new PDFer();
            $pdf->SelectReport($ReportNum);
         } 
      }
      else {
         $s = 0;
      }
?>