<?php

class reporter{
   private $Conn;
   private $CurReport;

   //_______________________________________________________________________________________________________________________________________
	public function __construct() {
		// If no database object is passed, create a new db connection
			$this->Conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if ( mysqli_connect_errno() ) {
			  return $this->error("DB Connection Error: ". mysqli_connect_error());
			}
		// If the session is not started yet
		if( !isset($_SESSION) ) {
			session_start();
		}
	}

   //_______________________________________________________________________________________________________________________________________
   public function DoReports($param) {
      $s = '';
      switch ($param) {
         case 1: $s .= $this->DoRptSales();            break;
         case 2: $s .= $this->DoRptCurrentStock();     break;
         case 3: $s .= $this->DoRptInventoryLevels();  break;
         case 4: $s .= $this->DoRptBestSeller()     ;  break;
         case 5: $s .= $this->DoRptProfitAndLoss()  ;  break;
         case 6: $s .= $this->DoRptSalesByTime()    ;  break;
         case 7: $s .= $this->DoRptShelfLife()      ;  break;
         default:
            break;
      } 
      return $s;
   }
   
   //_______________________________________________________________________________________________________________________________________
   private function DoRptCurrentStock() {
      return "DoRptCurrentStock";
   }

   //_______________________________________________________________________________________________________________________________________
   private function DoRptInventoryLevels() {
      return "DoRptInventoryLevels";
   }

   //_______________________________________________________________________________________________________________________________________
   private function DoRptSales() {
      return "DoRptSales";
   }

   //_______________________________________________________________________________________________________________________________________
   private function DoRptBestSeller() {
      return "Best Seller Report";
   }

   //_______________________________________________________________________________________________________________________________________
   private function DoRptProfitAndLoss() {
      return "Profit and Loss Report";
   }

   //_______________________________________________________________________________________________________________________________________
   private function DoRptSalesByTime() {
      return "Sales by Time of Day Report";
   }

   //_______________________________________________________________________________________________________________________________________
   private function DoRptShelfLife() {
      return "Shelf Life Report";
   }

   //_______________________________________________________________________________________________________________________________________
   private function ShowReportItem($lbl, $option){
      $s = '<form action="appcheck.php" method="post">
<input type="hidden" name="tendo1" value="' . REPORTING . '">
<input type="hidden" name="tendo2" value="' . $option . '">
<button class="reportitem">' . $lbl . '</button>
</form>'; //<tr><td></td></tr>     
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   public function ShowContentReporting($action){
      $s  = '<div id="contentHeader">Reports  </div>';
      $s .= '<div id="content"></div>';
      $s .= '<div class="reportList">';//Reporter<table border=1>';
      
      $sql = 'select * from reports;';
      $result = $this->Conn->query($sql);
      if ($result) {
         while($row = $result->fetch_assoc()) {
            $s .= $this->ShowReportItem($row['ReportTitle'], $row["ID"] );
         }
      }
      $s .= '</div><div class="reportContent">';
      $s .= $this->DoReports($action);
      $s .= '</div>';
      return $s;
   }


}

?>