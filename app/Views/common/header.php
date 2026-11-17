<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <!-- TODO: include your CSS files here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= asset_url('/css/header.css') ?>">
    <link rel="stylesheet" href="<?= asset_url('/css/homeView.css') ?>">
    <link rel="stylesheet" href="<?= asset_url('/css/login.css') ?>">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Molle:ital@1&display=swap');
    </style>
</head>

<body>
    <nav class="navbar bg-1 fg-2 header">
        <div class="container-fluid">
            <a class="navbar-brand name" href="/bakery-app">
                <img src="/bakery-app/assets/images/logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                Coeur Sucré
            </a>
            <ul class="nav justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-envelope-heart-fill"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-cart"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_BASE_URL ?>/login"><i class="bi bi-person-circle"></i></a>
                </li>

            </ul>
        </div>
    </nav>
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
                                <a class="menu-item" href="#">Birthday</a>
                                <a class="menu-item" href="#">Marriage</a>
                                <a class="menu-item" href="#">Baby Shower</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <button class="btn-solid theme-secondary" data-bs-toggle="menu" aria-expanded="false">
                                Boutique
                            </button>
                            <div class="menu">
                                <a class="menu-item" href="#">Cakes</a>
                                <a class="menu-item" href="#">Cookies</a>
                                <a class="menu-item" href="#">Breads</a>
                                <a class="menu-item" href="#">Pies</a>
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
    <br>
    <!-- Flash Messages -->
    <?php if (App\Helpers\FlashMessage::has()): ?>
        <div class="mb-4">
            <?= App\Helpers\FlashMessage::render() ?>
        </div>
    <?php endif; ?>
