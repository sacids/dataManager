<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url('favicon.png'); ?>" />

    <title>AfyaData - <?= (!empty($title)) ? $title : config_item("site_name"); ?></title>
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Google fonts - witch you want to use - (rest you can just remove) -->
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,600,700' rel='stylesheet' type='text/css'>

    <!-- Leaflet, marker cluster js and css -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js"></script>

    <!--./marker -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.0/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>
</head>

<body class="h-screen bg-gray-100 leading-normal tracking-normal">
    <!-- Begin page -->
    <div class="min-h-full">
        <nav class="bg-white">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-14 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="block h-8 w-auto lg:hidden" src="<?= base_url('assets/img/logo_C.png')?>" alt="Afyadata">
                            <img class="hidden h-8 w-auto lg:block" src="<?= base_url('assets/img/logo_C.png')?>" alt="Afyadata">
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                <a href="<?= site_url('projects/lists');?>" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">Projects</a>

                                <a href="#" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">OHKR</a>

                                <a href="#" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 px-3 py-2 rounded-md text-sm font-medium">Reports</a>

                                <a href="<?= site_url('projects/add_new');?>" class="text-white bg-red-900 hover:bg-red-800 px-3 py-2 rounded-sm text-sm font-medium">
                                    + Create Project
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <button type="button" class="rounded-full bg-red-800 p-1 text-white hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="sr-only">View notifications</span>
                                <!-- Heroicon name: outline/bell -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                            </button>

                            <!-- Profile dropdown -->
                            <div x-data="{dropdownMenu: false}" class="relative ml-3">
                                <div>
                                    <button @click="dropdownMenu = ! dropdownMenu" type="button" class="flex items-center focus:outline-none mr-3" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <img class="w-8 h-8 rounded-full mr-4" src="http://i.pravatar.cc/300" alt="Avatar of User"> 
                                        <span class="hidden md:inline-block text-sm">Hi, <?php display_full_name(); ?>
                                        </span>
                                        <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                            <g>
                                                <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" />
                                            </g>
                                        </svg>
                                    </button>
                                </div>

                                <!--
                      Dropdown menu, show/hide based on menu state.
      
                      Entering: "transition ease-out duration-100"
                        From: "transform opacity-0 scale-95"
                        To: "transform opacity-100 scale-100"
                      Leaving: "transition ease-in duration-75"
                        From: "transform opacity-100 scale-100"
                        To: "transform opacity-0 scale-95"
                    -->
                                <div x-show="dropdownMenu" @click.outside="dropdownMenu = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <!-- Active: "bg-gray-100", Not Active: "" -->
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">MyProfile</a>

                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Change Password</a>

                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" class="inline-flex items-center justify-center rounded-md bg-red-800 p-2 text-white hover:bg-red-900 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!--
                    Heroicon name: outline/bars-3
      
                    Menu open: "hidden", Menu closed: "block"
                  -->
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!--
                    Heroicon name: outline/x-mark
      
                    Menu open: "block", Menu closed: "hidden"
                  -->
                            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a href="#" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 block px-3 py-2 rounded-md text-sm" aria-current="page">Dashboard</a>

                    <a href="#" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 block px-3 py-2 rounded-md text-sm">Projects</a>

                    <a href="#" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 block px-3 py-2 rounded-md text-sm">OHKR</a>

                    <a href="#" class="text-neutral-900 hover:bg-red-100 hover:rounded-md hover:text-slate-900 block px-3 py-2 rounded-md text-sm">Create
                        Project</a>
                </div>
                <div class="border-t border-gray-100 pt-4 pb-3">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium leading-none text-gray-800">Tom Cook</div>
                            <div class="text-sm font-medium leading-none pt-2 text-gray-400">tom@example.com</div>
                        </div>
                        <button type="button" class="ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="sr-only">View notifications</span>
                            <!-- Heroicon name: outline/bell -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <a href="#" class="block rounded-md px-3 py-2 text-sm text-gray-600 hover:bg-gray-700 hover:text-white">
                            My Profile
                        </a>

                        <a href="#" class="block rounded-md px-3 py-2 text-sm text-gray-600 hover:bg-gray-700 hover:text-white">
                            Change Password
                        </a>

                        <a href="#" class="block rounded-md px-3 py-2 text-sm text-gray-600 hover:bg-gray-700 hover:text-white">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </nav>