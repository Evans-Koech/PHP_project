<?php
require('fpdf.php');

class Kapdf extends FPDF {

   function Header() {// Page header
      //$this->Image('logo.png',10,6,30);   // Logo
      $this->SetFont('Arial','B',15);   // Arial bold 15
      $this->Cell(80);   // Move to the right
      $this->Cell(30,10,'Title',1,0,'C');   // Title
      $this->Ln(20);   // Line break
   }

   // Page footer
   function Footer() {
      $this->SetY(-15);   // Position at 1.5 cm from bottom
      $this->SetFont('Arial','I',8);   // Arial italic 8
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');   // Page number
   }

   public function fanya($param) {
      // Instanciation of inherited class
      $this->AliasNbPages();
      $this->AddPage();
      $this->SetFont('Times','',12);
      for($i=1;$i<=40;$i++){
         $this->Cell(0,10,'Printing line number '.$i,0,1);
      }
      $this->Output();
   }
}

?>