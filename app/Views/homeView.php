<?php

use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = 'Home';
ViewHelper::loadHeader($page_title);
?>
<nav class="navbar md:navbar-expand bg-1 filter">
    <div class="container-fluid">

        <dialog class="drawer drawer-end" tabindex="-1" id="navbarDarkDrawer" aria-labelledby="navbarDarkDrawerLabel">
            <div class="drawer-header">
                <h5 class="drawer-title" id="navbarDarkDrawerLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="drawer" aria-label="Close"></button>
            </div>
            <div class="drawer-body mb-2 md:mb-0">
                <ul class="nav nav-underline">
                    <li class="nav-item">
                        <button class="btn-solid theme-secondary" data-bs-toggle="menu" aria-expanded="false">
                            Events
                        </button>
                        <div class="menu">
                            <a class="menu-item" href="#">Action</a>
                            <a class="menu-item" href="#">Another action</a>
                            <a class="menu-item" href="#">Something else here</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button class="btn-solid theme-secondary" data-bs-toggle="menu" aria-expanded="false">
                            Boutique
                        </button>
                        <div class="menu">
                            <a class="menu-item" href="#">Action</a>
                            <a class="menu-item" href="#">Another action</a>
                            <a class="menu-item" href="#">Something else here</a>
                        </div>
                    </li>
                </ul>
                <form class="d-flex ms-auto" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn-outline theme-success" type="submit">Search</button>
                </form>
            </div>
        </dialog>
    </div>
</nav>
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