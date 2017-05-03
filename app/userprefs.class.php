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

   private function DoCommonFields(){ 
      $s .= R0 . $this->u->DoField(1, '', 'tendo1'       , FTHIDDEN  , USERPREFS, 20, 20, 1, TRUE) . S0 ;
      $s .= R0 . $this->u->DoField(1, '', 'tendo2'       , FTHIDDEN  , 2, 20, 20, 1, TRUE) . S0 ;  
      return $s;
   }//DoCommonFields

   private function ShowUserManager() {
      $sql = "SELECT * from userauth";
      $result = $this->Conn->query($sql);
      // get all the posted values
      $userid = $this->u->getPostedValue('userid');
      $name = $this->u->getPostedValue('name');
      $email = $this->u->getPostedValue('email');
      $userlevel = $this->u->getPostedValue('userlevel');
      $active = $this->u->getPostedValue('active');
      $username = $this->u->getPostedValue('username');
      $edit = $this->u->getPostedValue("edit");
      $disable = $this->u->getPostedValue("disable");

      $divLeft = '
         <table style="float: left;width: 40%;border: 1px #e9e9e9 solid;min-height:300px;font-size:13px;">
      ';
 
      $divLeft .= '<form method="post" action="appcheck.php">';
      $divLeft .= R0 . $this->u->DoField(1, '', 'Name', FTTEXT    , $name, 30, 20, 1, TRUE) . S0 ; 
      // $divLeft .= R0 . $this->u->DoField(1, '', 'Email'   , FTTEXT    , $email, 20, 20, 1, TRUE) . S0 ;
      // $divLeft .= R0 . $this->u->DoField(1, '', 'userid'       , FTHIDDEN  , $userid, 20, 20, 1, TRUE) . S0 ;
      // $divLeft .= R0 . $this->u->DoField(1, '', 'Publisher', FTTEXT    , $username, 10, 20, 1, TRUE) . S0 ; 
      // $divLeft .= R0 . $this->u->DoField(1, '', 'Password'     , FTTEXT    , "", 10, 20, 1, TRUE) . S0 ;
      // $divLeft .= R0 . $this->u->DoField(1, '', 'Confirm Password'     , FTTEXT    , "", 10, 20, 1, TRUE) . S0 ; 
      $divLeft .= $this->DoCommonFields();
      $divLeft .= '</form>';

      $divRight = '
      <table style="float: left;width: 56%;margin-left: 3%;border: 1px #e9e9e9 solid;font-size:13px;">
      ';
      $s = '
      <div class="select" style="width: 100%;">
          <select style="float:right;margin: 12px;">
               
            <option>Active Users</option>
                <option>Non-Active</option>
                <option>Disabled Users</option>
                <option selected="selected">All Users</option>
          
          </select>
      </div>
      <br/>
      ';
      $s .= '
      <thead><tr>
      <th>User Id</th>
      <th>Name</th>
      <th>Username</th>
      <th>Email</th>
      <th>Active</th>
      <th></th>
      </thead></tr>
      ';
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $s .= R0 . '<td>' . $row['userid'] . '</td>' ; 
            $s .= R0 . '<td>' . $row['name'   ] . '</td>' ; 
            $s .= R0 . '<td>' . $row['username'] . '</td>' ; 
            $s .= R0 . '<td>' . $row['email'] . '</td>' ;
            $s .= R0 . '<td>' . $row['userlevel'] . '</td>' ;
            $s .= R0 . '<td>' . $row['active'] . '</td>' ;
            $s .= R0 . '<td><form action="appcheck.php" method="post">';
            $s .= R0 . '<input type="submit" name="edit" class="green" value="edit">' ;
            $s .= R0 . '<input type="submit" name="disable" class="red" value="Disable">' ;
            $s .= R0 . $this->u->DoField(1, '', 'userid'       , FTHIDDEN  , $row['userid'], 20, 20, 1, TRUE) . S0 ;
            $s .= $this->DoCommonFields() ;
            $s .= R0 . $this->u->DoField(1, '', 'name'       , FTHIDDEN  , $row['name'], 20, 20, 1, TRUE) . S0 ;
            $s .= R0 . $this->u->DoField(1, '', 'email'       , FTHIDDEN  , $row['username'], 20, 20, 1, TRUE) . S0 ;
            $s .= R0 . $this->u->DoField(1, '', 'userlevel'       , FTHIDDEN  , $row['email'], 20, 20, 1, TRUE) . S0 ;
            $s .= R0 . $this->u->DoField(1, '', 'active'       , FTHIDDEN  , $row['active'], 20, 20, 1, TRUE) . S0 ;
            $s .= '</td></form>';
         }
      }
      $divRight .= $s;
      $divRight .= '</table>';
      $divLeft .= '</table>';
      return $divLeft . $divRight;
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
         case 2: $s .= $this->ShowUserManager(); break;
         default:
            break;
      } 
      return $s;
   }
   
}

?>