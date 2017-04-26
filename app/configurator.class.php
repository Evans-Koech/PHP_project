<?php

class configurator {//7633185745 elkana
   private $Conn;
   private $CurAction;
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
   private function EditStandartList($tbl, $fld){
      $this->SaveStandartList($tbl, $fld);
      $sql = "SELECT * FROM $tbl order by $fld";
     // echo $sql;
      $s = '<tableborder=1><tr><td></td><td>' . $fld . '</td></tr>';
      $result = $this->Conn->query($sql);
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $s .= R0 . '<form action="appcheck.php" method="post"><td>'. $row['ID'      ] . '</td>' ; 
            $s .= R0 . $this->u->DoField(1, 'ID', 'ID', FTHIDDEN  , $row['ID'], 20, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, ''  , $fld, FTTEXT    , $row[$fld], 20, 20, 1, TRUE) . S0 ;
            $s .= $this->u->DoCommonFields(CONFIGURATE, $this->CurAction); 
         }
      }
      $s .= R1 . '<form action="appcheck.php" method="post"><td></td>' ; 
      $s .= R0 . $this->u->DoField(1, '', $fld, FTTEXT    , '', 20, 20, 1, TRUE) . S0 ;
      $s .= $this->u->DoCommonFields(CONFIGURATE, $this->CurAction); 
      return $s;
	}

   //_______________________________________________________________________________________________________________________________________
   private function ManageBookPrices(){
      $this->SaveBookPrices();
      $sql = "SELECT * FROM booklist";// where ID = ".$this->IssueID;
      $result = $this->Conn->query($sql);
      $s = '<table id="booklist" border=1><tr><td>BookTitle</td><td>Author</td><td>Publisher</td><td>UnitCost</td><td>SellingPrice</td><td></td></tr>';
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $s .= '<form action="appcheck.php" method="post">';
            $s .= R0 . '<td>' . $row['BookTitle'] . '</td>' ; 
            $s .= R0 . '<td>' . $row['Author'   ] . '</td>' ; 
            $s .= R0 . '<td>' . $row['Publisher'] . '</td>' ; 
            $s .= R0 . $this->u->DoField(1, '', 'UnitCost'    , FTTEXT    , $row['UnitCost'    ], 10, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'SellingPrice', FTTEXT    , $row['SellingPrice'], 10, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'ID'          , FTHIDDEN  , $row['ID'          ], 10, 20, 1, TRUE) . S0 ;
            $s .= $this->u->DoCommonFields(CONFIGURATE, $this->CurAction); 
         }
      }
      $s .= '</table>';
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function SaveBookPrices() {
      if (isset($_POST['siit'])){
         if ($_POST['siit'] == 1){
            $UnitCost = $_POST['UnitCost'];
            $SellingPrice = $_POST['SellingPrice'   ];
            $sql = " 
            UnitCost = $UnitCost,
            SellingPrice    = $SellingPrice "; 
            $id = $_POST['ID'];
            $qry = "update booklist set $sql Where ID = " . $id;
            $result = $this->Conn->query($qry);
            //echo $qry;
         }
      }
   }

   //_______________________________________________________________________________________________________________________________________
   private function SaveStandartList($tbl, $fld) {
      if (isset($_POST['siit'])){
         if ($_POST['siit'] == 1){
            $fldVal = $_POST[$fld];
            $sql = " $fld = '$fldVal' "; 
            if (isset($_POST['ID'])){
               $id = $_POST['ID'];
               $qry = "update $tbl set $sql Where ID = " . $id;
            }
            else {
               $qry = "insert into $tbl set $sql ; ";
            }
           // echo $qry;
            $result = $this->Conn->query($qry);
         }
      }
   }

   //_______________________________________________________________________________________________________________________________________
   public function ShowContentConfigurator($param) {
      $this->CurAction = $param;
      $this->u = new utilities;
      $s = '';
      switch ($param) {
         case 1: $s .= $this->EditStandartList('otheritems', 'ItemType');   break;
         case 2: $s .= $this->EditStandartList('units'     , 'Unit')    ;   break;
         case 3: $s .= $this->ManageBookPrices()                        ;   break;
         case 4: $s .= $this->EditStandartList('subjects'  , 'Subject') ;   break;
         case 5: $s .= $this->EditStandartList('classyears', 'ClassYear') ;   break;
         default:
            break;
      } 
      return $s;
   }
   
}

?>