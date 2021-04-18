# eBay-API-PHP
This small php application should get you started using the **eBay Developer's API**. The API calls demonstrated only require Application access tokens. The calls return
general eBay information, not information specific to a user's account. To do that you need to add User application tokens. It should be easy to extend the code included here for that.

There are three methods demonstrated. You will find them in the file **eBayrepository.php**.

1. ***getAppToken()*** - gets a new token only when the current token has expired. This minimizes the number of eBay token requests and speeds the API calls by eliminating unneeded requests.
2. ***searchCategories($term)*** - search eBay for categories suggested by your search terms
3. ***getItemAspects($catID)*** - get item specifics for a given eBay category

Information is transferred to and from eBay using the [curl](https://curl.se/) program. You will need a copy of it on your server.

The demo app uses the MVC pattern. You can use it or scrap, the three methods will work regardless. But to view this demo as a working site, you will need to follow the instructions in README-MVC.md.