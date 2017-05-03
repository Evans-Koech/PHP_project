<?php

class pubactions{
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
   private function DoPassMsg(){
      $s = 'Please contact your sys admin to allocate you a new password';
      return $s;
   }


   //_______________________________________________________________________________________________________________________________________
   public function ShowContentPubActions($param) {
      $this->u = new utilities;
      $s = '';
      switch ($param) {
         case 1: $s .= $this->DoPassMsg();            break;

         default:
            break;
      } 
      return $s;
   }
   
}

?>