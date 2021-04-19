<?php
// Demonstrate eBay Item Specifics.
$PageTitle="Item Specifics";
// Add tags for page header section
function customPageHeader(){?>
<?php }
include_once(PROJECT_ROOT . '/application/views/_templates/header.php');
include_once(PROJECT_ROOT . '/application/views/specificsModal.php'); 
?>
<!-- Start of page body ----------------------------------------->
<h1>eBay Item Specifics</h1>
    <!-- main content output -->
    <div>
    <p>Demo of API call get_item_aspects_for_category.<br><a 
     href='https://developer.ebay.com/api-docs/commerce/taxonomy/resources/methods' 
     target="_blank" rel="noopener noreferrer">Documentation</a>
    </p>
    </div>

    <div>
    <label for="CategoryID">Recent Categories:</label>
    <div class="input-group">
    <select class="form-control custom-select" id="CategoryID" name="CategoryID">
    <?php
    if (is_null($item->CategoryID) || $item->CategoryID <= 0)
    {
        echo "<option value='0' selected disabled>You must select a category</option>";
    }
    foreach ($categories as $category)
    {   
        $name = preg_replace('/[\x00-\x1F\x7F]/', '', $category['Name']);
        $catid = preg_replace('/[\x00-\x1F\x7F]/', '', $category['CategoryID']);
        if ($item->CategoryID == $catid) {
            echo "<option value=" . $catid . " selected>" . $name . "</option>";
        }
        else {
            echo "<option value=" . $catid . ">" . $name . "</option>";
        }
    }
    ?>
    </select>
    <span class=input-group-btn>
    <button type="button" class="btn btn-md btn-primary mx-2" data-toggle="modal" data-target="#itemSpecifics">Get Specifics</button>
    </span>
    </div>
    <p class="m-2">Recent categories come from the previous page. Choose a category then click Get Specifics. 
    Item aspects change depending on the category selected. Not all eBay categories have item aspects.
    </div>
<!-- End of page body ------------------------------------------>
<?php
// Add tags for page footer 
function customPageFooter() { ?>
<!-- Custom JavaScript for this site -->
<script>
$(document).ready(function() {
    // Item specifics modal is opening
    $('#itemSpecifics').on('show.bs.modal', function (e) {
        var category = $('#CategoryID');
        var item = $('#RID');
        $('#itemSpecifics .modal-body').load('/process/loadSpecifics/' + item.val() + '/' + category.val(), function() {
            $('#specMaster').trigger('change');
        });
    });
});
</script>
<?php }
include_once(PROJECT_ROOT . '/application/views/_templates/footer.php');
?>