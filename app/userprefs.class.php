<?php

class userprefs{
   private $Conn;
   private $u;

   //_______________________________________________________________________________________________________________________________________
	public function __construct($dbc=null) {
		if( !is_object($dbc) ) {
			$this->Conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if ( mysqli_connect_errno() ) {
			  return $this->error("DB Connection Error: ". mysqli_connect_error());
			}
		}
		else {
			$this->Conn = $dbc;
		}
		// If the session is not started yet
		if( !isset($_SESSION) ) {
			session_start();
		}
	}

   //_______________________________________________________________________________________________________________________________________
   private function DoUserPrefs(){
      $this->SaveUserPrefs();
      $sql = "SELECT * FROM userprefs";// where ID = ".$this->IssueID;
      $result = $this->Conn->query($sql);

         while($row = $result->fetch_assoc()) {
         //$row = $result->fetch_assoc();
         $s  = R0 . $u->DoField(1, 'ID'             , 'ID'             , FTTEXT    , $row['ID'             ], 20, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $u->DoField(1, 'TransactionType', 'TransactionType', FTTEXT    , $row['TransactionType'], 20, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $u->DoField(1, 'Account'        , 'Account'        , FTTEXT    , $row['Account'        ], 20, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $u->DoField(1, 'ItemDescription', 'ItemDescription', FTTEXT    , $row['ItemDescription'], 20, 20, 1, TRUE) . S0 ;
         return $s;
      //if ($result->num_rows > 0) {
      }
   }

   //_______________________________________________________________________________________________________________________________________
   private function SaveUserPrefs() {
   }

   //_______________________________________________________________________________________________________________________________________
   public function ShowContentUserPrefs($param) {
      $this->u = new utilities;
      $s = '';
      switch ($param) {
         case 1: $s .= $this->DoUserPrefs();            break;

         default:
            break;
      } 
      return $s;
   }
   
}

?>