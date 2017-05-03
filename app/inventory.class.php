<?php
//require('kapdf.class.php');

class inventory {//7633185745 elkana
   private $Conn;//isaya miyienda 0711154670
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
   private function AddBookToOrderList() {
      if (isset($_POST['siit'])){
         if ($_POST['siit'] == 201){
            $id = $_POST['ID'];
            $qry = "insert into orderlist set InventoryType=1, ItemID = $id; ";
            $result = $this->Conn->query($qry);
            //echo $qry;TRUNCATE orderlist
         }
      }
   }

   //_______________________________________________________________________________________________________________________________________
   private function DeleteBookFromOrderList() {
      if (isset($_POST['siit'])){
         if ($_POST['siit'] == 202){
            $id = $_POST['ID'];
            $qry = "delete from orderlist where (InventoryType=1) and (ItemID = $id); ";
            $result = $this->Conn->query($qry);
            //echo $qry;TRUNCATE orderlist
         }
      }
   }

   //_______________________________________________________________________________________________________________________________________
   private function SaveBookQuantity() {
      if (isset($_POST['siit'])){
         if ($_POST['siit'] == 203){
            $id = $_POST['ID'];
            $Quantity = $_POST['Quantity'];
            $qry = "update orderlist set Quantity = $Quantity where (InventoryType=1) and (ItemID = $id); ";
            $result = $this->Conn->query($qry);
            //echo $qry;TRUNCATE orderlist
         }
      }
   }

   //_______________________________________________________________________________________________________________________________________
   private function DoBookList(){
      $this->AddBookToOrderList();
      $sql = "SELECT * FROM booklist";// where ID = ".$this->IssueID;
      $result = $this->Conn->query($sql);
      $s = '<table id="booklist"><tr><td>BookTitle</td><td>Author</td><td>Publisher</td><td>ISBN</td></tr>';
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $s .= '<form action="appcheck.php" method="post">';
            $s .= R0 . '<td>' . $row['BookTitle'] . '</td>' ; 
            $s .= R0 . '<td>' . $row['Author'   ] . '</td>' ; 
            $s .= R0 . '<td>' . $row['Publisher'] . '</td>' ; 
            $s .= R0 . '<td>' . $row['Stock'    ] . '</td>' ; 
            $s .= R0 . $this->u->DoField(1, '', 'ID'       , FTHIDDEN  , $row['ID'       ], 20, 20, 1, TRUE) . S0 ;
            $s .= $this->u->DoCommonFieldsb(INVENTORY, $this->CurAction, 'Order', 201, 0); 
         }
      }
      $s .= '</table>';
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function DoBookListOrdered(){
      $this->DeleteBookFromOrderList();
      $this->SaveBookQuantity();
      $sql = "SELECT BookTitle, Quantity, booklist.ID FROM orderlist INNER JOIN booklist on orderlist.ItemID = booklist.ID where orderlist.InventoryType =1" ;// where ID = ".$this->IssueID;
      $result = $this->Conn->query($sql);
      $s = '<table id="booklist"><tr><td>BookTitle</td></tr>';
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $s .= '<form action="appcheck.php" method="post">';
            $s .= R0 . '<td>' . $row['BookTitle'] . '</td>' ; 
            $s .= R0 . $this->u->DoField(1, '', 'Quantity' , FTTEXT    , $row['Quantity'], 5, 10, 1, TRUE) . S0 ;
            $s .= R0 . $this->u->DoField(1, '', 'ID'       , FTHIDDEN  , $row['ID'], 20, 20, 1, TRUE) . S0 ;
            $s .= $this->u->DoCommonFieldsc(INVENTORY, $this->CurAction, 'Save'  , 'Remove', 203, 202, $row['ID'], 0); 
         }
      }
      $s .= '</table>';
      return $s;
	}

   //_______________________________________________________________________________________________________________________________________
   private function DoBookOrderList(){
      //$this->PrintBookOrderList();
      $s = '<table border=0><tr valign="top">';
      $s .= '<td bgcolor="#70e9b0">' . $this->DoBookList() . '</td><td>&nbsp;</td><td bgcolor="70b0e9">' . $this->DoBookListOrdered() . '</td>' ;
      $s .= '</tr><tr><td></td><td></td><td><form action="pdfer.php" method="post" target="_blank">' .$this->u->DoCommonFieldsb(INVENTORY, $this->CurAction, 'Print', 258, 77) . '</td></tr></table>';
      return $s;
	}

   //_______________________________________________________________________________________________________________________________________
   private function DoInventoryLevels(){
      $s = '<table><tr>';
      $s .= '<td>DoInventoryLevels</td>' ;
      $s .= '</tr></table>';
      return $s;
	}

   //_______________________________________________________________________________________________________________________________________
   private function EditBookList(){
      $this->SaveBookItem();
      $sql = "SELECT * FROM booklist";// where ID = ".$this->IssueID;
      $result = $this->Conn->query($sql);
      $s = '<table><tr><td></td><td>BookTitle</td><td>Author</td><td>Publisher</td><td>ISBN</td></tr>';
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $s .= '<form action="appcheck.php" method="post">';
            $s .= R1 . '<td>' . $row['ID'       ] . '</td>' ; 
            $s .= R0 . $this->u->DoField(1, '', 'BookTitle', FTTEXT    , $row['BookTitle'], 30, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'Author'   , FTTEXT    , $row['Author'   ], 20, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'Publisher', FTTEXT    , $row['Publisher'], 10, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'ISBN'     , FTTEXT    , $row['ISBN'     ], 10, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'ClassYear', FTDBLIST  , $row['ClassYear'], 10, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'Subject'  , FTDBLIST  , $row['Subject'  ], 10, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'ID'       , FTHIDDEN  , $row['ID'       ], 20, 20, 1, TRUE) . S0 . $this->DoCommonFields(); 
         }
         $s .= R1 . '<form action="appcheck.php" method="post"><td></td>' ; 
         $s .= R0 . $this->u->DoField(1, '', 'BookTitle', FTTEXT    , '', 30, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $this->u->DoField(1, '', 'Author'   , FTTEXT    , '', 20, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $this->u->DoField(1, '', 'Publisher', FTTEXT    , '', 10, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $this->u->DoField(1, '', 'ISBN'     , FTTEXT    , '', 10, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $this->u->DoField(1, '', 'ClassYear', FTDBLIST  , '', 10, 20, 1, TRUE) . S0 ; 
         $s .= R0 . $this->u->DoField(1, '', 'Subject'  , FTDBLIST  , '', 10, 20, 1, TRUE) . S0 . $this->DoCommonFields(); 
      }
      $s .= '</table>';
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function EditItemList(){
      $this->SaveItemList();
      $sql = "SELECT * FROM itemlist";// where ID = ".$this->IssueID;
      $result = $this->Conn->query($sql);
//CREATE TABLE `labooks`. ( `ID` INT NOT NULL , `ItemType` , `ItemName` , `ItemBrand` VARCHAR(70) NULL , PRIMARY KEY (`ID`));
      $s = '<tableborder=1><tr><td></td><td>ItemType</td><td>ItemName</td><td>ItemBrand</td><td>Size</td><td>Units</td></tr>';
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $s .= '<form action="appcheck.php" method="post">';
            $s .= R1 . '<td>' . $row['ID'       ] . '</td>' ; 
            $s .= R0 . $this->u->DoField(1, '', 'ItemType' , FTDBLIST  , $row['ItemType' ], 20, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'ItemName' , FTTEXT    , $row['ItemName' ], 20, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'ItemBrand', FTTEXT    , $row['ItemBrand'], 20, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'ItemSize' , FTTEXT    , $row['ItemSize' ], 20, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'Unit'     , FTDBLIST  , $row['Unit'     ], 20, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'ID'       , FTHIDDEN  , $row['ID'       ], 20, 20, 1, TRUE) . S0 . $this->DoCommonFields(); 
         }
      }
      $s .= R1 . '<form action="appcheck.php" method="post"><td></td>' ; 
      $s .= R0 . $this->u->DoField(1, '', 'ItemType' , FTDBLIST  , '', 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->u->DoField(1, '', 'ItemName' , FTTEXT    , '', 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->u->DoField(1, '', 'ItemBrand', FTTEXT    , '', 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->u->DoField(1, '', 'ItemSize' , FTTEXT    , '', 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->u->DoField(1, '', 'Unit'     , FTDBLIST  , '', 20, 20, 1, TRUE) . S0 . $this->DoCommonFields(); 
      $s .= '</table>';
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function DoCommonFields(){
      $s  = R0 . $this->u->DoField(1, '', 'siit'     , FTHIDDEN  , 1                , 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->u->DoField(1, '', 'tendo1'   , FTHIDDEN  , INVENTORY        , 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->u->DoField(1, '', 'tendo2'   , FTHIDDEN  , $this->CurAction , 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . '<td><button class="button button2">Save</button></td></form>' . S1 ; 
      return $s;
   }//DoCommonFields

   //_______________________________________________________________________________________________________________________________________
   private function ReceiveBooks(){
      $this->SaveReceiveBooks();
      $sql = "SELECT * FROM booklist";// where ID = ".$this->IssueID;A to Z Children Dictionary
      $result = $this->Conn->query($sql);
      $s = '<table border=0 id="booklist><tr><td></td><td>BookTitle</td><td>Author</td><td>Publisher</td><td>ISBN</td><td>Stock</td><td>Received</td></tr>';
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $s .= '<form action="appcheck.php" method="post">';
            $s .= R1 . '<td>' . $row['ID'       ] . '</td>' ; 
            $s .= R0 . '<td>' . $row['BookTitle'] . '</td>' ; 
            $s .= R0 . '<td>' . $row['Author'   ] . '</td>' ; 
            $s .= R0 . '<td>' . $row['Publisher'] . '</td>' ; 
            $s .= R0 . '<td>' . $row['ISBN'     ] . '</td>' ; 
            $s .= R0 . '<td>' . $row['Stock'    ] . '</td>' ; 
            $s .= R0 . $this->u->DoField(1, '', 'Received' , FTTEXT    , '', 20, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'ID'       , FTHIDDEN, $row['ID'       ], 20, 20, 1, TRUE) . S0 ;
            $s .= R0 . $this->u->DoField(1, '', 'BookTitle', FTHIDDEN, $row['BookTitle'], 20, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'Stock'    , FTHIDDEN, $row['Stock'    ], 20, 20, 1, TRUE) . S0 . $this->DoCommonFields(); 
         }
      }
      $s .= '</table>';
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function ReceivingInventory(){
      $this->SaveInventoryReceived();
      $sql = "SELECT * FROM itemlist";// where ID = ".$this->IssueID;A to Z Children Dictionary
      $result = $this->Conn->query($sql);
      $s = '<table border=0 id="booklist><tr><td>ItemType</td><td>ItemName</td><td>ItemBrand</td><td>Stock</td></tr>';
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $s .= '<form action="appcheck.php" method="post">';
            $s .= R1 ;//. '<td>' . $row['ID'       ] . '</td>' ; 
            $s .= R0 . '<td>' . $row['ItemType' ] . '</td>'  ; 
            $s .= R0 . '<td>' . $row['ItemName' ] . '</td>'  ; 
            $s .= R0 . '<td>' . $row['ItemBrand'] . '</td>'  ; 
            $s .= R0 . '<td>' . $row['Stock'    ] . '</td>'  ; 
            $s .= R0 . $this->u->DoField(1, '', 'Received', FTTEXT    , '', 20, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'Stock'   , FTHIDDEN, $row['Stock'], 20, 20, 1, TRUE) . S0 ; 
            $s .= R0 . $this->u->DoField(1, '', 'ID'      , FTHIDDEN, $row['ID'   ], 20, 20, 1, TRUE) . S0 . $this->DoCommonFields(); 
         }
      }
      $s .= '</table>';
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function SaveBookItem() {
      if (isset($_POST['siit'])){
         if ($_POST['siit'] == 1){
            $BookTitle = $_POST['BookTitle'];
            $Author    = $_POST['Author'   ];
            $Publisher = $_POST['Publisher'];
            $ISBN      = $_POST['ISBN'     ];
            $ClassYear = $_POST['ClassYear']; 
            $Subject   = $_POST['Subject'  ]; 
            $sql = " 
            BookTitle = '$BookTitle',
            Author    = '$Author',  
            Publisher = '$Publisher',
            ISBN      = '$ISBN',  
            ClassYear = $ClassYear, 
            Subject   = $Subject ";
            if (isset($_POST['ID'])){
               $id = $_POST['ID'];
               $qry = "update booklist set $sql Where ID = " . $id;
            }
            else {
               $qry = "insert into booklist set $sql ; ";
            }
            $result = $this->Conn->query($qry);
            //echo $qry;
         }
      }
   }

   //_______________________________________________________________________________________________________________________________________
   private function SaveItemList() {
      if (isset($_POST['siit'])){
         if ($_POST['siit'] == 1){
            $ItemType = $_POST['ItemType'];
            $ItemName = $_POST['ItemName'];
            $ItemSize = $_POST['ItemSize'];
            $ItemBrand = $_POST['ItemBrand'];
            $Unit      = $_POST['Unit'     ];
            $sql = " 
            ItemType = $ItemType,
            ItemName = '$ItemName',  
            ItemSize = $ItemSize,  
            Unit     = $Unit,  
            ItemBrand = '$ItemBrand'"; 
            if (isset($_POST['ID'])){
               $id = $_POST['ID'];
               $qry = "update itemlist set $sql Where ID = " . $id;
            }
            else {
               $qry = "insert into itemlist set $sql ; ";
            }
            $result = $this->Conn->query($qry);
            //echo $qry;
         }
      }
   }

   //_______________________________________________________________________________________________________________________________________
   private function SaveInventoryReceived() {
      if (isset($_POST['siit'])){
         if ($_POST['siit'] == 1){
            $Stock    = $_POST['Stock'    ];
            $Received = $_POST['Received' ];
            $id       = $_POST['ID'];
            $qry = "update itemlist set Stock = ($Stock + $Received) Where ID = " . $id;
            $result = $this->Conn->query($qry);
            //echo $qry;
         }
      }
   }

   //_______________________________________________________________________________________________________________________________________
   private function SaveReceiveBooks() {
      if (isset($_POST['siit'])){
         if ($_POST['siit'] == 1){
            $Stock    = $_POST['Stock'    ];
            $Received = $_POST['Received' ];
            $id       = $_POST['ID'];
            $qry = "update booklist set Stock = ($Stock + $Received) Where ID = " . $id;
            $result = $this->Conn->query($qry);
            //echo $qry;
         }
      }
   }

   //_______________________________________________________________________________________________________________________________________
   public function ShowContentInventory($param) {
      $s = '';
      $this->CurAction = $param;
      $this->u = new utilities;
      switch ($param) {
         case 1 : $s .= $this->EditBookList()      ;   break;
         case 2 : $s .= $this->ReceiveBooks()      ;   break;
         case 3 : $s .= $this->EditItemList();         break;
         case 4 : $s .= $this->ReceivingInventory();   break;
         //case 5 : $s .= $this->DoInventoryLevels();    break;
         case 5 : $s .= $this->DoBookOrderList();      break;
         default:            break;
      } 
      $s .= "    <script type='text/javascript'>\n" .
"function KeyPress(e) {\n" .
"      var evtobj = window.event? event : e\n" .
"      if (evtobj.keyCode == 89 && evtobj.ctrlKey) alert(\"" . $param . "\");\n" .
"}\n" .
"document.onkeydown = KeyPress;" .
"    </script>" ;
      return $s;
   }
   
}

?>