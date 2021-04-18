# eBay-API-PHP
This small php application should get you started using the eBay Developer's API. The API calls demonstrated only require Application access tokens. The calls return
general eBay information, not information specific to a user's account. To do that you need to add User application tokens. It should be easy to extend the code included here for that.

There are three methods demonstrated. You will find them in the file eBayrepository.php.

1) getAppToken() - gets a new token only when the current token has expired. This minimizes the number of eBay token requests and speeds the API calls by eliminating unneeded requests.

2) searchCategories($term) - search eBay for categories suggested by your search terms

3) getItemAspects($catID) - get item specifics for a given eBay category

Information is transferred to eBay using the curl program. You will need a copy of it on your server.

The demo app uses the MVC pattern. You can use it or scrap, the three methods will work regardless. Files to implement the pattern are:
application/libs/application.php - implements the MVC style of urls
application/libs/controller.php - base class for all controllers. It is never instantiated directly.
.htaccess - Needed to make MVC work. For IIS, you will need to modify web.config instead. You can import .htaccess into IIS and it will convert it to web.config for you. 

The demo uses two controllers - home and process
home.php - controller for normal page navigation
process.php - controller to perform actions such as interactions with the eBay website.  This is where you will find most of the code that implements the eBay API calls.

