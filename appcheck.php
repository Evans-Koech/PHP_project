<?php
require_once('lib/userauth.class.php');
require_once('app/configurator.class.php');
require_once('app/inventory.class.php');
require_once('app/payables.class.php');
require_once('app/pointofsale.class.php');
require_once('app/pubactions.class.php');
require_once('app/reports.class.php');
require_once('app/userprefs.class.php');
require_once('app/utilities.class.php');

// Logout
if(isset($_GET['do']) && $_GET['do'] == 'logout') {
	$user->logout('You logged out successfully!');
}
$user->is();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<title> 309 Books </title>
   <link rel="stylesheet" type="text/css" href="inc/style1.css" />
</head>
<body>
<?php

class WorkPage extends Reporter{
   private $Conn;
   private $tendo1;
   private $tendo2;

   //_______________________________________________________________________________________________________________________________________
   function ConnectToDB() {
      $servername = "localhost";
      $username = "root";
      $password = "9570";
      $dbname = "three09books";
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      return $conn;
   }

   //_______________________________________________________________________________________________________________________________________
   private function getPostedValue($fieldName){
      if (isset($_POST[$fieldName])){
         $s = $_POST[$fieldName];
      }
      else {
         $s = 0;
      }
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function ShowPageContent(){
      $this->tendo1 = $this->getPostedValue('tendo1');
      $this->tendo2 = $this->getPostedValue('tendo2');
      $s = '<table><tr>';
      switch ($this->tendo1) {
         case BLANK       : $s .= '';            break;
         case CASHREGISTER: $pos = new pointofsale ; $s .= $pos->ShowContentPointOfSale($this->tendo2); break;
         case INVENTORY   : $inv = new inventory   ; $s .= $inv->ShowContentInventory($this->tendo2);   break;
         case CONFIGURATE : $cfg = new configurator; $s .= $cfg->ShowContentConfigurator($this->tendo2);break;
         case PAYABLES    : $pay = new payables    ; $s .= $pay->ShowContentPayables($this->tendo2) ;   break;
         case REPORTING   : $rpt = new reporter    ; $s .= $rpt->ShowContentReporting($this->tendo2);   break;
         case USERPREFS   : $upf = new userprefs   ; $s .= $upf->ShowContentUserPrefs($this->tendo2);   break;
         case PUBACTIONS  : $pac = new pubactions  ; $s .= $upf->ShowContentPubActions($this->tendo2);  break;
         default :            break;
      }
      $s .= '</table><tr>';
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function ShowPageFooter(){
      $s = "<br /> You can log out by clicking <a href='appcheck.php?do=logout'>here</a>";
      return '<div class="footer">three09 Books</div>';
   }

   //_______________________________________________________________________________________________________________________________________
   private function ShowSubMenuItem($mnu, $option){
      $ar = explode ('^', $mnu);
      $max = sizeof($ar);
      $s ='';
      for ($i=0; $i<$max; $i++) {
         $s .= '<form action="appcheck.php" method="post">
         <input type="hidden" name="tendo1" value="' . $option . '">
         <input type="hidden" name="tendo2" value="' . (1+$i) . '">
         <input type="submit" value="' . $ar[$i] . '" id="menuitem">
         </form><br>';//<p>      
      }
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function ShowMenuItem($lbl, $option, $menu2){
      $s = '<div class="dropdown">
  <span>' . $lbl . '</span>
  <div class="dropdown-content">' .
    $this->ShowSubMenuItem($menu2, $option).
  '</div>
</div>';
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   private function ShowPageHeader(){
      $s = '<table><tr>';
      $s .= $this->ShowMenuItem('Cash Register', CASHREGISTER, 'New Sale');
      $s .= $this->ShowMenuItem('Inventory'    , INVENTORY   , 'Book List^Books Recieving^Inventory Items^Inventory Levels^Order List');
      $s .= $this->ShowMenuItem('Configuration', CONFIGURATE , 'Item Types^Units^Book Prices^Subjects^Class Year');
      $s .= $this->ShowMenuItem('Reports'      , REPORTING   , 'Reports');
      $s .= $this->ShowMenuItem('Payables'     , PAYABLES    , 'Accounts Payables');
      $s .= $this->ShowMenuItem('User Prefs'   , USERPREFS   , 'User Preferences' );
      $s .= '</tr></table>';
      return $s;
   }

   //_______________________________________________________________________________________________________________________________________
   public function showPage(){
      $s = '<table>';
      $s .= '<tr><td>' . $this->ShowPageHeader()  .'</td></tr>';
      $s .= '<tr><td>' . $this->ShowPageContent() .'</td></tr>';
      $s .= '<tr><td>' . $this->ShowPageFooter()  .'</td></tr>';
      $s .= '</table>';
      echo $s;
   }
}
$p = new WorkPage;
$p->showPage();

?>
</body>
</html>
