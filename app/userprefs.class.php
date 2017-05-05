<?php

class userprefs{
   private $Conn;
   private $u;
   private $user;
   private $validate;
   private $filter;
   private $form;

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
     $s = '';
      $s .= R0 . $this->u->DoField(1, '', 'tendo1'       , FTHIDDEN  , USERPREFS, 20, 20, 1, TRUE) . S0 ;
      $s .= R0 . $this->u->DoField(1, '', 'tendo2'       , FTHIDDEN  , 2, 20, 20, 1, TRUE) . S0 ;  
      return $s;
   }//DoCommonFields

   private function saveUser ($saving = true) {
      $_POST = $this->filter->process($_POST);
      
      if($this->validate->username($_POST['user']) && $saving) {
        if($this->user->checkExisting('user', $_POST['user'])) {
          $this->form->setError('user',' * Username already taken!');
          $this->form->setValue('user', $_POST['user']);
        }
      }
      if( $saving && $this->validate->password($_POST['pass']) && $this->validate->password($_POST['repass'],'repass') ) {
        if($_POST['pass'] !== $_POST['repass']) {
          $this->form->setError('repass',' * Passwords do not match!');
        }
      }
      
      if($this->validate->email($_POST['email']) && $saving) {
        if($this->user->checkExisting('email', $_POST['email'])) {
          $this->form->setError('email',' * Email already in use!');
          $this->form->setValue('email', $_POST['email']);
        }
      }
      
      // If no validation errors, proceed to add user
      if($this->form->numErrors == 0) {
        /* Some magic to automatically add all fields that are sent through the form so that
          you need not struggle with adding custom fields YOU MUST VALIDATE CUSTOM FIELDS */
        $fields = unserialize(TABLE_FIELDS);
        $data = array();
        foreach($fields as $k => $v) {
          $data[$k] = isset($_POST[$k]) ? $_POST[$k] : '';
        }

        // If the password has not been sent hashed by javascript, find the sha1 hash now
        if(!isset($_POST['hashed']) || $_POST['hashed'] != 1 && $saving)
          $data['pass'] = sha1($data['pass']);
        if ($saving) {
          $data['id'] = 0;
          $data['time'] = date("Y-m-d H:i:s");
          $this->user->insertUser($data);
          }
        else {
          $this->user->updatePropertyArray(array(
            "username" => $_POST['user'],
            "email" => $_POST['email'],
            "name" => $_POST["name"],
          ), $_POST['userid']);
        }
      }

      else {
        $_SESSION['valueArray'] = $_POST;
          $_SESSION['errorArray'] = $this->form->getErrorArray();
      }
   }

   private function processJavascript() {
      $s = '
        <script type="text/javascript">
          function processForm() {
            span = document.getElementsByTagName("span");
            for(i=0;i<span.length;i++)
              span[i].innerHTML = "";

            user = document.getElementById("user").value;
            pass = document.getElementById("pass").value;
            repass = document.getElementById("repas").value;
            email = document.getElementById("email").value;
                  
            if(username(user) && password(pass,"passError") && password(repass,"repassError") && checkpass(pass, repass) && mail(email) ) {
              hash = hex_sha1(pass);
              document.signupForm.pass.value = hash;
              hash = hex_sha1(pass);
              document.signupForm.repass.value = hash;
              return true;
            }
            return false;
          }
        </script>
      ';

      return $s;
   }


  private function ShowUserManager() {
      $sql = "SELECT * from userauth";
      $result = $this->Conn->query($sql);
      // get all the posted values
      $userid = $this->u->getPostedValue('userid');
      $name = $this->u->getPostedValue('name');
      $email = $this->u->getPostedValue('email');
      $userlevel = $this->u->getPostedValue('userlevel');
      $active = $this->u->getPostedValue('active');
      $username = $this->u->getPostedValue('user');
      $edit = $this->u->getPostedValue("edit");
      $disable = $this->u->getPostedValue("disable");

      if ( $this->u->getPostedValue("save") ) {
         $this->saveUser(true);
      } else if  ( $this->u->getPostedValue("update") ) {
        $this->saveUser(false);
      }

      $divLeft = '
         <table style="float: left;width: 40%;border: 1px #e9e9e9 solid;font-size:13px;">
      ';

      $divLeft .= $this->processJavascript();
 
      $divLeft .= '<form method="post" action="appcheck.php">';
      $divLeft .= R1 . $this->u->DoField(1, 'Username', 'user', FTTEXT    , $username, 40, 20, 1, TRUE) . S1 ;
      $divLeft .= R1 . $this->u->DoField(1, '', '', FTNOTFIELD    , $this->form->error("username") , 40, 20, 1, TRUE) . S1 ; 
      if (!$edit) {
         $divLeft .= R1 . $this->u->DoField(1, 'Password', 'pass'     , FTTEXT    , "", 40, 20, 1, TRUE) . S1 ;
         $divLeft .= R1 . $this->u->DoField(1, '', '', FTNOTFIELD    , $this->form->error("pass") , 40, 20, 1, TRUE) . S1 ; 
         $divLeft .= R1 . $this->u->DoField(1, 'Confirm Password', 'repass'     , FTTEXT    , "", 40, 20, 1, TRUE) . S1 ; 
         $divLeft .= R1 . $this->u->DoField(1, '', '', FTNOTFIELD    , $this->form->error("repass") , 40, 20, 1, TRUE) . S1 ; 
      }
       $divLeft .= R1 . $this->u->DoField(1, 'Email', 'email'   , FTTEXT    , $email, 40, 20, 1, TRUE) . S1 ;
      $divLeft .= R1 . $this->u->DoField(1, '', '', FTNOTFIELD    , $this->form->error("email") , 40, 20, 1, TRUE) . S1 ; 
      $divLeft .= R1 . $this->u->DoField(1, 'Name', 'name', FTTEXT    , $name, 40, 20, 1, TRUE) . S1 ; 
      $divLeft .= R0 . $this->u->DoField(1, '', 'userid'       , FTHIDDEN  , $userid, 20, 20, 1, TRUE) . S0 ;
      $divLeft .= $this->DoCommonFields();
      $divLeft .= '<script type="text/javascript">document.write(\'<input type="hidden" name="hashed" value="1" />\');</script>';
      $divLeft .= R1 . '<td><input type="submit" name="' . ($userid ? 'update' : 'save') . '" class="red" value="Save Details" onclick="return processForm();"></td>' . S1 ;
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
           $s .= R1;
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
            $s .= R0 . $this->u->DoField(1, '', 'user'       , FTHIDDEN  , $row['username'], 20, 20, 1, TRUE) . S0 ;
            $s .= R0 . $this->u->DoField(1, '', 'email'       , FTHIDDEN  , $row['email'], 20, 20, 1, TRUE) . S0 ;
            $s .= R0 . $this->u->DoField(1, '', 'userlevel'       , FTHIDDEN  , $row['userlevel'], 20, 20, 1, TRUE) . S0 ;
            $s .= R0 . $this->u->DoField(1, '', 'active'       , FTHIDDEN  , $row['active'], 20, 20, 1, TRUE) . S0 ;
            $s .= '</td></form>';
            $s .= S1;
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
      $this->user = new UserAuth;
      $this->form = new Form;
      $this->validate = new Validate;
      $this->filter = new InputFilter;
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