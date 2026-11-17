<?php

use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = $data['page_title'] ?? '';
ViewHelper::loadHeader($page_title);
$cafes = $data["cafes"] ?? [];
//dd($cafes);
foreach ($cafes as $cafe) {
?>
    <div class="card" style="width: 15rem;">
        <!-- <img src="..." class="card-img-top" alt="..."> -->
        <div class="card-body">
            <h5 class="card-title"><?= $cafe['name'] ?></h5>
            <p class="card-text"><?= $cafe['description'] ?></p>
            <a href="shops/<?= $cafe['id'] ?>" class="btn btn-primary">Show Details</a>
        </div>
    </div>
<?php
}
?>
<!-- TODO: dynamically render the list of the cafes passed to this view from the ShopsController using a list of Bootstrap cards! -->



<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
