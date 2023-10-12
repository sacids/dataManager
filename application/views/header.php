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

    <!-- Polices Google - celles que vous voulez utiliser - (les autres peuvent être supprimées) -->
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,600,700' rel='stylesheet' type='text/css'>

    <!--./fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
</head>

<body class="h-full leading-normal tracking-normal">
    <!-- Commencer la page -->
    <header class="sticky top-0 z-50">
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
                                <!-- Actuel: "bg-gray-900 text-white", Par défaut: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                <a href="<?= site_url('projects/lists'); ?>" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">Projets</a>

                                <a href="#" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">OHKR</a>

                                <a href="#" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">Rapports</a>

                                <a href="<?= site_url('projects/add_new'); ?>" class="text-white bg-red-900 hover:bg-red-800 px-3 py-2 rounded-sm text-sm font-medium">
                                    + Créer un projet
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">

                            <a href="<?= site_url('auth/users/lists')?>" class="rounded-full bg-slate-800 p-1 text-white hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372+.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                            </a>

                            <button type="button" class="rounded-full bg-red-800 p-1 text-white hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="sr-only">Voir les notifications</span>
                                <!-- Heroicon name: outline/bell -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                            </button>

                            <!-- Menu déroulant du profil -->
                            <div x-data="{dropdownMenu: false}" class="relative ml-3">
                                <div>
                                    <button @click="dropdownMenu = ! dropdownMenu" type="button" class="flex items-center focus:outline-none mr-3" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <img class="w-8 h-8 rounded-full mr-4" src="<?= base_url('favicon.png') ?>" alt="<?php show_first_name(); ?>">
                                        <span class="hidden md:inline-block text-sm">Bonjour, <?php show_first_name(); ?>
                                        </span>
                                        <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                            <g>
                                                <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" />
                                            </g>
                                        </svg>
                                    </button>
                                </div>

                                <!--
                      Menu déroulant, afficher/masquer en fonction de l'état du menu.
      
                      Entrée : "transition ease-out duration-100"
                        De : "transform opacity-0 scale-95"
                        À : "transform opacity-100 scale-100"
                      Sortie : "transition ease-in duration-75"
                        De : "transform opacity-100 scale-100"
                        À : "transform opacity-0 scale-95"
                    -->
                                <div x-show="dropdownMenu" @click.outside="dropdownMenu = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <!-- Actif : "bg-gray-100", Pas actif : "" -->
                                    <a href="<?= site_url('auth/profile') ?>" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Mon profil</a>

                                    <a href="<?= site_url('auth/change_password') ?>" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Changer le mot de passe</a>

                                    <a href="<?= site_url('auth/logout') ?>" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Déconnexion</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Bouton de menu mobile -->
                        <button type="button" class="inline-flex items-center justify-center rounded-md bg-red-800 p-2 text-white hover:bg-red-900 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Ouvrir le menu principal</span>
                            <!--
                    Nom du Heroicon : outline/bars-3
      
                    Menu ouvert : "caché", Menu fermé : "visible"
                  -->
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!--
                    Nom du Heroicon : outline/x-mark
      
                    Menu ouvert : "visible", Menu fermé : "caché"
                  -->
                            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
