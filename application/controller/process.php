<?php
require PROJECT_ROOT . '/application/models/itemSpecific.php';
// Class Process
// Controller to perform all action requests 
// and database updates
class Process extends Controller
{
    function __construct(UnitOfWork $unitOfWork)
    {
        parent::__construct($unitOfWork);
    }

    // ACTION: Change the status of all selected items to 'Selected'
    public function addSelection()
    {
        // Do we have post data?
        if (!isset($_POST['submitSelection'])) {
            header('location: ' . SITE_URL . 'home/index');
            return;
        }

        // Get rid of the last selection
        $this->uow->FExchangeRep()->clearUploadSelection();
        // Gather up our data
        foreach ($_POST['itemSelected'] as $selected) {
            // Add the rid to the 
            $this->uow->FExchangeRep()->setItemStatus($selected, 'Selected');
        }
        // Redirect the user to display our results
        header('location: ' . SITE_URL . 'fexchange/prepare');
    }

    // Return array of ItemSpecifics
    public function getItemSpecifics(int $itemRID, int $catID)
    {
        $itemSpec = [];
        $itemAspect = $this->uow->eBayRep()->getItemAspects($catID);
        $specValues = $this->uow->FExchangeRep()->getSpecificValues($itemRID, $catID);
        if (count($itemAspect->aspects) > 0)
        {
            foreach($itemAspect->aspects as $aspect)
            {
                // Get the user value for the current aspect
                $key = $aspect->localizedAspectName;
                $value = NULL;
                foreach($specValues as $spec)
                {
                    if ($spec['SpecKey'] == key)
                    {
                        $value = $spec['SpecValue'];
                        break;
                    }
                }
                $itemSpec[] = new ItemSpecific($itemRID, $catID, $aspect, $value);
            }
        }
        return $itemSpec;
    }

    // Return array of key, display, and value.
    // spec is an array of ItemSpecific objects;
    public function getDisplaySpecifics(int $itemRID, int $catID, $spec = NULL)
    {
        $display = [];
        $itemSpecifics = is_null($spec) ? $this->getItemSpecifics($itemRID, $catID) : $spec;
        $count = 0;
        foreach ($itemSpecifics as $specific)
        {
            $display[] = array('key' => $specific->specificKey, 'display'=>$specific->displayKey, 'value'=>$specific->specificValue);
            $count+=1;
        }
        //Print out the array in a JSON format.
        header('Content-Type: application/json');
        echo json_encode($display);        
    }

    public function loadSpecifics(int $item, int $category)
    {
        $itemRID = $item;
        $catID = $category;
        $itemSpecifics = $this->getItemSpecifics($itemRID, $catID);
        require PROJECT_ROOT . '/application/views/fexchange/specificsBody.php';
    }

    public function updateSpecifics()
    {
        if (isset($_POST['specSize']))
        {
            for ($x=0; $x<$_POST['specSize']; $x++)
            {
                $key = "key-" . $x;
                $val = "value-" . $x;
                $fieldName = $_POST[$key];
                $fieldValue = $_POST[$val];
            }
        }   
    }

    public function updateDetail()
    {
        if (isset($_POST['RID']))
        {
            $RID = $_POST['RID'];
            // Get the item record 
            $item = $this->uow->FExchangeRep()->getFEItem($RID);
            if (is_null($item)) {
                header('location: ' . SITE_URL . 'home/index/');
            }
        }
        // See how we arrived at this view. Did the user 
        // press the next or back button?
        $nextRID = -1;
        if (isset($_POST['itemBack'])) {
            $nextRID = 0;
        }
        if (isset($_POST['itemNext'])) {
            $nextRID = $this->uow->FExchangeRep()->getNextItem($RID);
        }
        // Do we have post data?
        if ($nextRID >= 0) {
            $item->Title = isset($_POST['Title']) ? $_POST['Title'] : NULL;
            $item->ItemDesc = isset($_POST['ItemDesc']) ? $_POST['ItemDesc'] : NULL;
            $item->CategoryID = isset($_POST['CategoryID']) ? $_POST['CategoryID'] : NULL;
            $item->StartPrice = isset($_POST['StartPrice']) ? $_POST['StartPrice'] : NULL;
            $item->Format = isset($_POST['Format']) ? $_POST['Format'] : NULL;
            $item->Duration = isset($_POST['Duration']) ? $_POST['Duration'] : NULL;
            $item->ConditionID = isset($_POST['ConditionID']) ? $_POST['ConditionID'] : NULL;
            $item->ConditionDescription = isset($_POST['Note']) ? $_POST['Note'] : NULL;
            $item->ShippingType = isset($_POST['ShippingType']) ? $_POST['ShippingType'] : NULL;
            $item->PackageType = isset($_POST['PackageType']) ? $_POST['PackageType'] : NULL;
            $item->WeightMajor = isset($_POST['WeightMajor']) ? $_POST['WeightMajor'] : NULL;
            $item->WeightMinor = isset($_POST['WeightMinor']) ? $_POST['WeightMinor'] : NULL;
            $item->ShippingService1Option = isset($_POST['Shipping1Option']) ? $_POST['Shipping1Option'] : '';
            $item->ShippingService1Cost = isset($_POST['Shipping1Cost']) ? $_POST['Shipping1Cost'] : NULL;
            $item->ShippingService1FreeShipping = isset($_POST['ShippingService1FreeShipping']) ? $_POST['ShippingService1FreeShipping'] : false;
            $item->DispatchTimeMax = isset($_POST['DispatchTimeMax']) ? $_POST['DispatchTimeMax'] : NULL;
            $item->PackageLength = isset($_POST['PackageLength']) ? $_POST['PackageLength'] : NULL;
            $item->PackageWidth = isset($_POST['PackageWidth']) ? $_POST['PackageWidth'] : NULL;
            $item->PackageDepth = isset($_POST['PackageDepth']) ? $_POST['PackageDepth'] : NULL;
            if ($item->isValid())
            {
                $item->Status = 'Ready';
            }
            else
            {
                $item->Status = 'Selected';
            }
            // save our item to the database
            $this->uow->FExchangeRep()->updateItem($item);
            if (isset($item->CategoryID))
            {
                $this->uow->FExchangeRep()->addRecentCategory($item->CategoryID);
            }
            if ($nextRID == 0) {
                header('location: ' . SITE_URL . 'fexchange/prepare');
            }
            else {
                header('location: ' . SITE_URL . 'fexchange/detail/' . $nextRID);
            }
            return;
        }
        header('location: ' . SITE_URL . 'home/index/');
    }

    // ACTION: Runs python script to create csv file. If success,
    // the file is uploaded to eBay using cURL program.
    public function uploadItems()
    {
        // Do we have post data?
        if (!isset($_POST['uploadItems'])) {
            header('location: ' . SITE_URL . 'fexchange/upload');
            return;
        }

        // Call python script to create the upload file
        // For windows, you have to specify python in the command. Windows does 
        // not support the #! line at the top of the python script. 
        $out = [];
        $command = 'python3 ' . PROJECT_ROOT . '/application/scripts/createCSV.py ';
        exec($command . escapeshellarg(PROJECT_ROOT) . " 2>&1", $out, $status);
        if ($status > 0) {
            print_r($out);
            print("Status: " . $status);
            return;
        }

        // Use cURL program to upload the file to eBay
        unset($out);
        $fmtOptions = " -k -F\"token=%s\" -F\"file=@%s\" %s";
        $token = $this->uow->FExchangeRep()->getUserToken(SELLER_ID);
        // We cannot use exportFile directly. The forward slashes do not work with exec() on Windows.
        $exportFile = OUT_FOLDER . OUT_FILE;
        if (WINDOWS)
        {
            $cmdOptions = sprintf($fmtOptions, $token, str_replace('/', '\\', $exportFile), UPLOAD_URL);
        }
        else
        {
            $cmdOptions = sprintf($fmtOptions, $token, $exportFile, UPLOAD_URL);
        }
        // Do not use escapeshellarg() here. It really messes up your command line.
        exec(CURL_PGM . $cmdOptions . " 2>&1", $out, $status);

        // Notify our user 
        if ($status == 0) {
            $msg = implode('', $out);
            $pos = stripos($msg, '<html>');
            $htmlPage = substr($msg, $pos);
            // Doctor up the page ebay sends
            $pos = stripos($htmlPage, '<br>');
            $ln1 = '<h2><a href="https://bulksell.ebay.com/ws/eBayISAPI.dll?FileExchangeUploadResults">View upload progress on eBay</a></h2>';
            $ln2 = '<h2><a href="/fexchange/history">View all uploaded items</a></h2>';

            print(substr_replace($htmlPage, $ln1 . $ln2, $pos, 0));
        }
        else {
            print_r($out);
        }
    }

    // ACTION: for ajax to get condition ids for a category
    public function getConditions()
    {
        // Do we have a get request?
        if (!isset($_GET['catID'])) {
            return;
        }
        $catID = $_GET['catID'];
        $json = $this->uow->FExchangeRep()->getConditionsForCat($catID);
        //Print out the array in a JSON format.
        header('Content-Type: application/json');
        echo json_encode($json);        
    }

    // ACTION: for ajax to get all categories that contain term.
    public function searchCategories()
    {
        if (!isset($_GET['term']))
        {
            return;     
        }
        $term = $_GET['term'];
        $response = $this->uow->eBayRep()->searchCategories($term);
        //Print out the array in a JSON format.
        header('Content-Type: application/json');
        echo json_encode($response);        
    }
}
