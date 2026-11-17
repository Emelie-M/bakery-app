<?php

use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = 'Home';
ViewHelper::loadHeader($page_title);
?>

<div class="card" style="width: 18rem;">
    <div class="card-body">
        <img src="..." class="card-img" alt="...">
        <h5 class="mt-2 mb-0">Image within the body</h5>
        <p class="card-text fg-2">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
        <small class="fg-3">Last updated 3 mins ago</small>
    </div>
</div>

<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
