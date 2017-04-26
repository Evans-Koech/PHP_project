<?php

define("MAXSIZE", 100);
define("R0", ''     );
define("R1", '<tr>' );
define("S0", ''     );
define("S1", '</tr>');
define("FTCHECKBOX" ,  1); //   "checkbox",
define("FTLIST"     ,  2); //   "list" ,
define("FTPASSWORD" ,  3); //   "password", 
define("FTTEXT"     ,  4); //   "text" ,
define("FTHIDDEN"   ,  5); //   "hidden",
define("FTTEXTAREA" ,  6); //   "textarea"
define("FTDBLIST"   ,  7); //   "DB list" ,
define("FTFILE"     ,  8); //   "File" ,
define("FTYESNORGP" ,  9); //   "File" ,
define("FTLISTNOYS" , 10); //   "list" ,
define("FTDATE"     , 11); //   "date" ,
define("FTNOTFIELD" , 12); //   "not a field

define("BLANK",  0); //   
define("CASHREGISTER",  1); //   
define("INVENTORY"   ,  2); //   
define("CONFIGURATE" ,  3); //   
define("REPORTING"   ,  4); //   
define("PAYABLES"    ,  5); //   
define("USERPREFS"   ,  6); //   
define("PUBACTIONS"  , 21); //   

class utilities {
   private $Conn;

   //_______________________________________________________________________________________________________________________________________
	public function __construct($dbc=null) {
//		 If no database object is passed, create a new db connection
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
   public function DoCommonFields($tendo1,$tendo2){
      $s  = R0 . $this->DoField(1, '', 'siit'     , FTHIDDEN  , 1      , 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'tendo1'   , FTHIDDEN  , $tendo1, 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'tendo2'   , FTHIDDEN  , $tendo2, 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . '<td><button class="button button2">Save</button></td></form>' . S1 ; 
      return $s;
	}

   //_______________________________________________________________________________________________________________________________________
   public function DoCommonFieldsb($tendo1, $tendo2, $lbl, $siit, $ripota){
      $s  = R0 . $this->DoField(1, '', 'siit'     , FTHIDDEN  , $siit  , 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'tendo1'   , FTHIDDEN  , $tendo1, 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'tendo2'   , FTHIDDEN  , $tendo2, 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'ripota'   , FTHIDDEN  , $ripota, 20, 20, 1, TRUE) . S0 ; 
      $s .= R0 . '<td><button class="button button2">'. $lbl . '</button></td></form>' . S1 ; 
      return $s;
   }//DoCommonFields

   //_______________________________________________________________________________________________________________________________________
   public function DoCommonFieldsc($tendo1, $tendo2, $lbl1, $lbl2, $siit1, $siit2, $id, $ripota){
      $s  = R0 . $this->DoField(1, '', 'siit'     , FTHIDDEN  , $siit1 , 1, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'tendo1'   , FTHIDDEN  , $tendo1, 1, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'tendo2'   , FTHIDDEN  , $tendo2, 1, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'ripota'   , FTHIDDEN  , $ripota, 1, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'ID'       , FTHIDDEN  , $id    , 1, 20, 1, TRUE) . S0 ;
      $s .= R0 . '<td><button class="button button2">'. $lbl1 . '</button></td></form>'  . S0 ; 
      $s .= '<form action="appcheck.php" method="post">';
      $s .= R0 . $this->DoField(1, '', 'siit'     , FTHIDDEN  , $siit2 , 1, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'tendo1'   , FTHIDDEN  , $tendo1, 1, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'tendo2'   , FTHIDDEN  , $tendo2, 1, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'ripota'   , FTHIDDEN  , $ripota, 1, 20, 1, TRUE) . S0 ; 
      $s .= R0 . $this->DoField(1, '', 'ID'       , FTHIDDEN  , $id    , 1, 20, 1, TRUE) . S0 ;
      $s .= R0 . '<td><button class="button button2">'. $lbl2 . '</button></td></form>' . S1 ; 
      return $s;
   }//DoCommonFields

   //_______________________________________________________________________________________________________________________________________
   public function DoField($col, $lbl, $name, $type, $val, $theSize, $tdWidth, $br, $bCell){
      //$size, $size1;
      if ($theSize == 0){
         $size = 30;
         switch (col){
            case 1 : $size = 20;-
               $size1 = 24;
               break;
            case 2 : $size = 70;
               $size1 = 56;
               break;
            case 3 : $size = 107;
               $size1 = 70;
               break;
            default: $size1 = 30;
         }//switch
      }
      else{
         $size  = $theSize;
         $size1 = $theSize;
      }
      if ("" != $lbl){
         if ("1" == $br){
            $br = "<br>";
         }
         if ("2" == $br){
            $br = "</td><td>";
         }
      }
      else{
          $br = "";
      }
      $td1 = "<td id=\"labels\" "; $td2 = ">"; $td3 = "</td>"; $sz = ""; $szWidth = "";
      if ($col == 0){
         $szCol = "";
         $td1 = "";
         $td2 = "";
         $td3 = "";
      }
      else{
         $szCol = "colspan=\"".$col."\"";
      }
      if ($tdWidth == 0){
         $szWidth = "";
      }
      else{
         $szWidth = " width=\"".$tdWidth."\"";
      }
      if ("TRUE" != $bCell){
         $td1 = "";
         $td2 = "";
         $td3 = "";
         $szWidth = "";
         $szCol = "";
      }
      switch($type){
      case FTCHECKBOX :
         $Checker = "";
         if(("1"==$val) || ("TRUE" == $val)) {
            $Checker = "checked";
         }
         //LogError(name, val);
         $sz = $td1.$szWidth . $szCol . $td2 . "<input name=\"". $name ."\" type=\"checkbox\" value=\"1\" " . $Checker . " />". $lbl . $br . $td3;
         break;
      case FTDATE :
         $sz = $td1.$szWidth . $szCol . $td2 . $lbl . $br . "<input type=\"text\" size=\"12\" id=\"". $name ."\"  name=\"". $name ."\" value=\"" . (val) . "\" />".$td3;//GetDisplayDate
         houser.addDateFieldJS(name);
         break;
      case FTDBLIST :
         $sz = $td1.$szWidth . $szCol . $td2. $lbl .  $br . $this->DoListTypeDB($name, $val) . $td3;
         break;
      case FTLIST :
         $sz = $td1.$szWidth . $szCol . $td2. $lbl .  $br . DoListType($name, $val) . $td3;
         break;
      case FTLISTNOYS :
         //String sYes, sNo;
         if ("1" == $val){
            $sYes =  " selected ";
            $sNo  = "";
         }
         else {
            $sYes = "";
            $sNo  = " selected ";
         }
         $sz = $td1.$szWidth . $szCol . $td2. $lbl .  $br . 
                 " <select name=\"". $name ."\"><option value=\"0\" " . sNo . ">No</option> <option value=\"1\" " . sYes . ">Yes</option> </select>" . $td3;
         break;
      case FTPASSWORD :
         $sz = $td1.$szWidth . $szCol . $td2. $lbl .  $br . "<input name=\"". $name ."\" type=\"password\" size=\"".$size."\" value=\"". $val ."\"/>".$td3;
         break;
      case FTFILE :
         $sz = $td1.$szWidth . $szCol . $td2. $lbl .  $br . "<input name=\"". $name ."\" type=\"file\" size=\"".$size."\" value=\"". $val ."\"/>".$td3;
         break;
      case FTNOTFIELD :
         $sz = $td1.$szWidth . $szCol . $td2. $lbl . $br . '<span id="kabold">'. $val . '</span>'.$td3;
         break;
      case FTTEXT :
         $sz = $td1.$szWidth . $szCol . $td2. $lbl . $br . "<input id=\"". $name ."\" name=\"". $name ."\" type=\"text\" size=\"".$size."\" value=\"". $val ."\"/>".$td3;
         break;
//      case FTTEXT2 :
//         $sz = $td1.$szWidth . $szCol . $td2. $lbl . $br . "<input id=\"". $name ."\" name=\"". $name ."\" type=\"text\" size=\"".$size."\" value=\"". $val ."\"/>".$td3;
//         break;
      case FTHIDDEN ://"<td width=\"300\" class=\"labels\"".col.">". $lbl .</td><br>
         $sz = "<input name=\"". $name ."\" type=\"hidden\" size=\"".$size."\" value=\"". $val ."\"/>";
         break;
      case FTTEXTAREA :
         $rows = "rows=\"5\"";
         if ("Finding On Physical Examination<br>"== $lbl){
            $rows = "rows=\"11\"";
         }
         $sz = $td1.$szWidth . $szCol . $td2. $lbl . $br . "<textarea name=\"". $name ."\" cols=\"".$size1."\" " . $rows . " >". $val ."</textarea>".$td3;
         break;
      case FTYESNORGP :
         $szCheck1 = ""; $szCheck2 = "";
         if ("1" == $val){
            $szCheck1 = " checked ";
            $szCheck2 = "";
         }
         if ("2" == $val){
            $szCheck2 = " checked ";
            $szCheck1 = "";
         }
         $sz = "<td id=\"labels\">" . $lbl .  $br . "</td>" .
              "<td><input type=\"radio\" name=\"" . $name . "\" value=\"1\" " . $szCheck1 . " /></td>" .
              "<td><input type=\"radio\" name=\"" . $name . "\" value=\"2\" " . $szCheck2 . " /></td>";
         break;
      }
      return $sz;
   }//DoField   ' height="50"'.

   //_______________________________________________________________________________________________________________________________________
   private function DoListTypeDB($szName, $val){
      $szField = $szName;
      $sql = $this->DoListTypeDBSQL($szName);
      //echo $sql;
      $sz = '<select name="' . $szName. '"><option value="0" ' . $this->GetSelected(" ", $val) . '> </option> ';
      $result = $this->Conn->query($sql);

      if (!$result) {
          $s = "0 results";
      }
      else {
         while($row = $result->fetch_assoc()) {
            $sz .= '<option value="' . $row["ID"] . '" ' . $this->GetSelected($row["ID"], $val) . ">" . $row[$szField] . "</option> ";
         }
      }
      $sz .= "</select>";
      return $sz;
   }//GetListTypeDB

   //_______________________________________________________________________________________________________________________________________
   private function DoListTypeDBSQL($szName){
      $sql = "";
      if ("Country"   == $szName ){ $sql = "Select * from countries "  ;   }
      if ("Status"    == $szName ){ $sql = "Select * from issuestatus" ;   }
      if ("Priority"  == $szName ){ $sql = "Select * from priority"    ;   }
      if ("IssueType" == $szName ){ $sql = "Select * from issuetype"   ;   }
      if ("ItemType"  == $szName ){ $sql = "Select * from otheritems"  ;   }
      if ("Developer" == $szName ){ $sql = "Select * from team"        ;   }
      if ("QA"        == $szName ){ $sql = "Select * from team"        ;   }
      if ("Unit"      == $szName ){ $sql = "Select * from units order by unit";   }
      if ("ClassYear" == $szName ){ $sql = "Select * from classyears order by ID";     }
      if ("Subject"   == $szName ){ $sql = "Select * from subjects order by Subject"; }
      return $sql;
   }//DoListTypeDBSQL

   //_______________________________________________________________________________________________________________________________________
   public function GetLastID($TableName){
      $sql = "Select LastNum from " + DataNamer.DTLastNums + " where (TableName = '" + $TableName + "')";
//      echo "$sql <br>";
      $LastID = GetFieldValueInt(sql, "GetLastID");
      if($LastID != -99){
         $LastID++;
         $sql = "update lastnums set LastNum = " + $LastID + " where (TableName = '" + $TableName + "')";
      }
      else{
         $LastID = 1;
         $sql = "insert into lastnums set LastNum = 1, TableName = '" + $TableName + "'";
      }
//      echo "$sql <br>";
      ExecTheSQL(sql, "GetLastID");
      return LastID;
   }//GetLastID
   
   //_______________________________________________________________________________________________________________________________________
   public function getPostedValue($fieldName){
      if (isset($_POST[$fieldName])){
         $s = $_POST[$fieldName];
      }
      else {
         $s = '';
      }
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function GetSelected($val1, $val2) {
      $sz = "";
      if ($val2 == null){
         $val2 = "";
      }
      if (strtoupper($val1) == strtoupper($val2)){
         $sz = " selected";
      }
      //LogError("sz", sz);
      return $sz;
   }//GetSelected

}