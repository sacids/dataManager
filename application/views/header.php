<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url('favicon.png'); ?>" />

    <title>AfyaData - <?= (!empty($title)) ? $title : config_item("site_name"); ?></title>
    <meta name="description" content="description ici">
    <meta name="keywords" content="mots-clés,ici">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/htmx.org@1.8.5"></script>

    <!-- Polices Google - celles que vous voulez utiliser - (les autres peuvent être supprimées) -->
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,600,700' rel='stylesheet' type='text/css'>

    <!-- Font awesome css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    
    <!--./jquery -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <!-- CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="<?= base_url('assets/css/table.css'); ?>" type="text/css">

    <!-- JS DataTables -->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

    <!-- Sélecteur JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Cartes Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>

    <!--./marker -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.0/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>

    <!--js -->
    <script type="text/javascript" src="<?= base_url('assets/js/afyadata.js'); ?>"></script>
</head>

<body class="h-screen leading-normal tracking-normal overflow-hidden">
    <!-- Begin page -->
    <header class="w-full h-36 z-50">
        <nav class="bg-white border-b">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-14 items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="<?= site_url('dashboard') ?>">
                            <img class="block h-8 w-auto lg:hidden" src="<?= base_url('assets/img/logo_C.png') ?>" alt="Afyadata">
                            <img class="hidden h-8 w-auto lg:block" src="<?= base_url('assets/img/logo_C.png') ?>" alt="Afyadata">
                        </a>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="<?= site_url('projects/lists'); ?>" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">Projets</a>

                            <a href="<?= site_url('ohkr/diseases')?>" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">OHKR</a>

                            <a href="#" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">Rapports</a>

                            <a href="<?= site_url('projects/add_new'); ?>" class="text-white bg-red-900 hover:bg-red-800 px-3 py-2 rounded-sm text-sm font-medium">
                                + Créer un projet
                            </a>
                        </div>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <a href="<?= site_url('auth/users/lists')?>" class="rounded-none text-slate-800 p-1 hover:bg-slate-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 mr-2">
                            <i class="fa-solid fa-users-viewfinder"></i>
                        </a>

                        <a href="#" class="rounded-none text-red-800 p-1 hover:bg-red-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 mr-2">
                            <i class="fa-solid fa-bell"></i>
                        </a>

                        <!-- Menu déroulant du profil -->
                        <div x-data="{dropdownMenu: false}" class="relative ml-3">
                            <div>
                                <button @click="dropdownMenu = ! dropdownMenu" type="button" class="flex items-center focus:outline-none mr-3" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <img class="w-8 h-8 rounded-full mr-4" src="<?= base_url('favicon.png') ?>" alt="<?php show_first_name(); ?>">
                                    <span class="hidden md:inline-block text-sm">Bonjour, <?php show_first_name(); ?></span>
                                    <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                        <g>
                                            <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" />
                                        </g>
                                    </svg>
                                </button>
                            </div>

                            <!-- Menu déroulant, afficher/masquer en fonction de l'état du menu. -->
                            <div x-show="dropdownMenu" @click.outside="dropdownMenu = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <!-- Actif : "bg-gray-100", Pas actif : "" -->
                                <a href="<?= site_url('auth/profile') ?>" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Mon profil</a>

                                <a href="<?= site_url('auth/change_password') ?>" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Changer le mot de passe</a>

                                <a href="<?= site_url('auth/logout') ?>" class="block px-4 py-2 text-sm text-gray-700" role-="menuitem" tabindex="-1" id="user-menu-item-2">Déconnexion</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <!-- Bouton de menu mobile -->
                    <button type="button" class="inline-flex items-center justify-center rounded-md bg-red-800 p-2 text-white hover-bg-red-900 hover-text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Ouvrir le menu principal</span>
                        <!-- Nom du Heroicon : outline/bars-3 -->
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!-- Nom du Heroicon : outline/x-mark -->
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        </nav>
