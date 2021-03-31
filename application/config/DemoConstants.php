<?php
// This is all your configuration stuff for your project 

// Error reporting. Overrides our php.ini
ini_set("display_errors", 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set to true if your web server is on a Windows machine
define('WINDOWS', false);
// URL used to serve the files that are in the public_html folder of this project
// If served from the root folder, just put /. If served from another folder:
// http://myDomainName.com/eBayDemo, you would put '/eBayDemo/'
define('SITE_URL', '/');

// Put your eBay authorization code here
// For the calls shown, only your developer token is needed
define('AUTHORIZATION', '[Put your hashed developer authorization token here');

// If you are using a database, define your connection info here
define('DBSTORE_USER', 'myUserName');
define('DBSTORE_PASS', 'myPassword');
define('DBSTORE_DSN', 'mysql:host=myDatabaseURI;dbname=nameOfMyDatabase');


