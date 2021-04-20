<?php

// Controller to display and copy items from the website to items
// that can be uploaded to File Exchange.
class Home extends Controller
{
    function __construct(UnitOfWork $unitOfWork)
    {
        parent::__construct($unitOfWork);
    }

    // Display the items in the web store that can be transferred to FExchange 
    // to be listed on eBay
    public function index()
    {
        //$items = $this->uow->WebStoreRep()->findAll();
        require PROJECT_ROOT . '/application/views/home/index.php';
    }

    // Display the items in the web store that can be transferred to FExchange 
    // to be listed on eBay
    public function tokens()
    {
        //$items = $this->uow->WebStoreRep()->findAll();
        require PROJECT_ROOT . '/application/views/home/tokens.php';
    }

    // Display the items in the web store that can be transferred to FExchange 
    // to be listed on eBay
    public function categories()
    {
        //$items = $this->uow->WebStoreRep()->findAll();
        require PROJECT_ROOT . '/application/views/home/categories.php';
    }

    // Display the items in the web store that can be transferred to FExchange 
    // to be listed on eBay
    public function specifics()
    {
        $categories = $this->uow->eBayRep()->searchCategories("calculators");
        require PROJECT_ROOT . '/application/views/home/specifics.php';
    }

}
