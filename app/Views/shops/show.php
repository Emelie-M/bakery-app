<?php

use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = $data['page_title'] ?? '';
ViewHelper::loadHeader($page_title);
$cafe = $data["cafe"] ?? [];
?>
<h1><?= $cafe['name'] ?></h1>
<p><?= $cafe['address'] ?></p>
<p><?= $cafe['description'] ?></p>





<?php

?>
<!-- TODO: dynamically render the list of the cafes passed to this view from the ShopsController using a list of Bootstrap cards! -->



<?php

ViewHelper::loadJsScripts();
ViewHelper::loadFooter();
?>
