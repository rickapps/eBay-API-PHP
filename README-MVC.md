To implement MVC on your server, you will need to modify .htaccess or web.config to rewrite urls. A sample .htaccess is included. You also need to modify DemoConstants.php to specify the locations of these folders and the location of your curl program.

Create two folders on your webserver:
+ **public_html** - Folder contains files that can be served from your web server.  The folder should either be your web root folder, or be a sub folder within your web root folder. 
+ **application** - Folder contains files that should not be publicly available and cannot be served by your webserver. This demo assumes the folder is at the same level as public_html.

Files to implement the MVC pattern are:
+ **application/libs/application.php** - implements the MVC style of urls
+ **application/libs/controller.php** - base class for all controllers. It is never instantiated directly.
+ **.htaccess** - Needed to make MVC work. For IIS, you will need to modify web.config instead. You can import .htaccess into IIS and it will convert it to web.config for you. 

The demo uses two controllers - home and process
+ home.php - controller for normal page navigation
+ process.php - controller to perform actions such as interactions with the eBay website.  This is where you will find most of the code that implements the eBay API calls.

Most eBay apps will require a database to store data. There is a skeleton *webstorerepository.php* to hold all your data access functions.  The eBay API calls can be found in *eBayRepository.php*.  This holds all the functions that pull and push information to and from eBay.  The file *unitofwork.php* manages the instances of all repository classes and the corresponding datastore connections.
