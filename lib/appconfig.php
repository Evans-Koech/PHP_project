<?php

/* General site settings */
define("SITE_NAME", "three09");  // Name of the site

// Path to the site with slash at the end  !!!!!!Important!!!!!!!!!!
define("SITE_PATH","http://localhost/three09/");  /* Example: http://www.example.com/application/ */
define("ADMIN_NAME", "admin"); // Name of the administrator
define("ADMIN_EMAIL", "admin@example.com"); // Email of the administrator
/* The following are relative to the SITE_PATH */
define("USER_DIR", "");    /* If you scripts are in the http://example.com/application/user folder, type user as the USER_DIR */
define("LOGIN_REDIRECT", "appcheck.php");   /* If you want the user to go http://www.example.com/application/login_redirect.php */
define("LOGOUT_REDIRECT", "index.php"); // Redirect the user to this page after logout

/* Database Settings */
define("DB_HOST","localhost"); // Hostname
define("DB_NAME","three09books"); // Database
define("DB_USER","root"); // Username
define("DB_PASS","sarahn9347"); // Password
define("TBL_USERS", "userauth"); // Table name

/* User levels. Add more levels here */
define("GUEST", 0);
define("ADMIN", 1);
define("MOD", 2);
define("USER", 3);

/* MAIL SETTINGS */
define("USE_SMTP", FALSE);
define("SMTP_HOST", "");
define("SMTP_PORT", "");
define("SMTP_USER", "");
define("SMTP_PASS", "");
define("USE_SSL", FALSE);

/* Session settings */
define("MULTIPLE_SESSIONS", TRUE); // Can the user have multiple sessions active?
define("SESSION_VARIABLE", "UserAuth"); // Session variable where user info is stored (array)
define("SESSION_TIMEOUT", 60*10); // User timeout in seconds. 0 to disable timeout
define("SESSION_FIELDS",""); // Add table fields that you would like to set in the session variable when a user is loaded (separated by commas)

/* Cookie settings */
define("REMEMBER_USER", TRUE); // Track user using cookie?
define("COOKIE_NAME", "three09cookie"); // Cookie Name
define("COOKIE_EXPIRES", 60*60*24);  // Cookie expiry time in seconds (default 1 day)

/* User activation. If both are false, then admin has to activate account manually */
define("SEND_ACTIVATION_MAIL", TRUE); // Send activation email?
define("AUTO_ACTIVATE", FALSE); // Automatically activate user after registration?

define("DEV_MODE", FALSE);   /* Set the error reporting level */

header( "Expires: Fri, 20 Jan 2017 01:00:00 GMT" );
header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
header( "Cache-Control: no-cache, must-revalidate" );
header( "Pragma: no-cache" );

/* Map table fields here. Don't change the key values. Add new fields ONLY TO THE END of the array */
define("TABLE_FIELDS", serialize(array(
	"id" => "userid",
	"user" => "username",
	"pass" => "password",
	"email" => "email",
	"level" => "userlevel",
	"vercode" => "activationHash",
	"active" => "active",
	"session" => "sessionid",
	"time" => "lastActive",
	"name" => "name"
)));
