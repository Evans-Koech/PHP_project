<?php

class pointofsale {
   private $Conn;
   private $CurAction;
   private $CurReceiptNo;
   private $u;

   //_______________________________________________________________________________________________________________________________________
	public function __construct($dbc=null) {
		// If no database object is passed, create a new db connection
		if( !is_object($dbc) ) {
			$this->Conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if ( mysqli_connect_errno() ) {
			  return $this->error("DB Connection Error: ". mysqli_connect_error());
			}
		}
		// else assign the connection object to the passed connection
		else {
			$this->Conn = $dbc;
		}
		// If the session is not started yet
		if( !isset($_SESSION) ) {
			session_start();
		}
	}

   //_______________________________________________________________________________________________________________________________________
   private function DoSaleItems() {
      //$this->SaveItemList();
      $s = $this->GetReceiptHeader();
      $sql = "SELECT * FROM receipts";// where ID = ".$this->IssueID;
      $result = $this->Conn->query($sql);
      $s = '<table width="300" id="positems">';
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $s .= '<form action="appcheck.php" method="post">';
            $s .= R1 . '<td width="200">' . $row['BookTitle'] . '</td>' ; 
            $s .= R0 . '<td>' . $row['Quantity' ] . '</td>' ; 
            $s .= R0 . '<th>' . $row['Amount'   ] . '</th>' ; 
            $s .= R0 . $this->u->DoCommonFields(CASHREGISTER, $this->CurAction, 'Save', 158, 1707) + S1; 
         }
      }
      $s .= '<tr><td width="200">  <input list="BookTitles" name="BookTitle"><datalist id="BookTitles">';
      $sql = "SELECT * FROM booklist order by BookTitle";
      $result = $this->Conn->query($sql);
      while($row = $result->fetch_assoc()) {
         $s .= '<option value="' . $row['BookTitle'] . '">';
      }
      $s .= '</datalist></td>';
      $s .= '<td><input type="number" name="quantity" min="1" max="5"></td>';
      //$s .= $this->u->DoField(1, '', 'BookTitle', FTTEXT    , $row['BookTitle'], 30, 20, 1, TRUE) . S0 ; 
      $s .= '<td></td></tr>';
//      $s .= '<tr><td>Book 1</td><th>200</td></tr>';
//      $s .= '<tr><td>Book 2</td><th>200</td></tr>';
//      $s .= '<tr><td>Book 3</td><td>200</td></tr>';
//      $s .= '<tr><td>Book 4</td><td>200</td></tr>';
      $s .= '</table>';
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function DoSearchItems() {
      $s = '';
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function GetReceiptHeader() {
      if ('' == $this->CurReceiptNo){
         $s = '';
         
      }
      else {
         $sql = "SELECT * FROM receipts where ID = ".$this->CurReceiptNo . " limit 1";
         $s = '<table><tr>';
         while($row = $result->fetch_assoc()) {
            $s .= R1 . '<td>Date:' . $row['ReceiptDate'  ] . '</td>' ; 
            //$s .= R0 . '<td>' . $row['TotalAmount'  ] . '</td>' ; 
            //$s .= R0 . '<td>' . $row['NumOfItems'   ] . '</td>' ; 
            $s .= R0 . '<td>' . $row['ReceiptStatus'] . '</td>' ; 
            $s .= R0 . '<td>' . $row['UserID'       ] . '</td>' ; 
         }
         $s .= '</tr></table>';
      }
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   public function ShowContentPointOfSale($param){
      $this->CurAction = $param;
      $this->u = new utilities;
      $s = '<table><tr>';
      $s .= '<td>' . $this->DoSaleItems() . '</td><td>' . $this->DoSearchItems() . '</td>';
      $s .= '</tr></table>';
      return $s;
   }

}

?>