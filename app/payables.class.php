<?php

class payables{
   private $Conn;

   //_______________________________________________________________________________________________________________________________________
	public function __construct($dbc=null) {
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
   private function DoPayablesList(){
      return '';
	}

   //_______________________________________________________________________________________________________________________________________
   private function DoPayables(){
      $s = '<table><tr>';
      $s .= '<td>' . $this->DoPayablesList() . '</td><td>' . /*$this->DoPayableDetails() .*/ '</td>' ;
      $s .= '</tr></table>';
      return $s;
	}

   //_______________________________________________________________________________________________________________________________________
   private function DoPayableDetails(){
      $this->SavePayableDetails();
      $sql = "SELECT * FROM genledger";// where ID = ".$this->IssueID;
      $result = $this->Conn->query($sql);

      if ($result->num_rows > 0) {
         //ALTER TABLE `genledger` ADD FULLTEXT( `ID`, `TransactionType`, `Account`, `ItemName`, `Quantity`, `AmounPaid`, `TransactionDate`, `DateRecCreated`, `ItemDescription`);
         $u = new utilities;
         $s .= R0 . $u->DoField(1, 'ID'             , 'ID'             , FTTEXT    , $row['ID'             ], 20, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $u->DoField(1, 'TransactionType', 'TransactionType', FTTEXT    , $row['TransactionType'], 20, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $u->DoField(1, 'Account'        , 'Account'        , FTTEXT    , $row['Account'        ], 20, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $u->DoField(1, 'ItemName'       , 'ItemName'       , FTTEXT    , $row['ItemName'       ], 20, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $u->DoField(1, 'Quantity'       , 'Quantity'       , FTTEXT    , $row['Quantity'       ], 20, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $u->DoField(1, 'AmounPaid'      , 'AmounPaid'      , FTTEXT    , $row['AmounPaid'      ], 20, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $u->DoField(1, 'TransactionDate', 'TransactionDate', FTTEXT    , $row['TransactionDate'], 20, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $u->DoField(1, 'ItemDescription', 'ItemDescription', FTTEXT    , $row['ItemDescription'], 20, 20, 1, TRUE) . S0 ;
         return $s;
      }
   }

   //_______________________________________________________________________________________________________________________________________
   private function SavePayableDetails() {
   }

   //_______________________________________________________________________________________________________________________________________
   public function ShowContentPayables($param) {
      $s = '';
      switch ($param) {
         case 1: $s .= $this->DoPayables();            break;

         default:
            break;
      } 
      return $s;
   }
   
}

?>