<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url('favicon.png'); ?>" />

    <title>AfyaData - <?= (!empty($title)) ? $title : config_item("site_name"); ?></title>
    <meta name="description" content="Afyadata">
    <meta name="keywords" content="Afyadata,One Health, Surveillance">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>

    <!-- Google fonts - witch you want to use - (rest you can just remove) -->
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,600,700' rel='stylesheet' type='text/css'>
</head>

<body class="h-screen leading-normal tracking-normal">
    <!-- This example requires Tailwind CSS v3.0+ -->
    <div class="isolate bg-white">

        <section class="h-full gradient-form bg-gray-200 md:h-screen">
            <div class="h-full lg:flex lg:flex-wrap g-0">
                <div class="lg:w-3/5 flex items-center bg-red-900">
                    <div class="text-white px-4 py-6 md:p-12 md:mx-6">
                        <h4 class="text-xl font-medium mb-6">What is Afyadata?</h4>
                        <p class="text-sm">
                            Afyadata is a tool that analyzes all the data collected from the field and intelligently sends feedback to the data collector and sends an alert to higher authority officials if any abnormal pattern is discovered in the data collected, this tool provides a graphical user interface for involved health stakeholders to analyze and visualizing data collected via Afyadata mobile app for android.
                        </p>
                    </div>
                </div>

                <div class="lg:w-2/5 px-4 md:px-0">
                    <div class="md:p-12 md:mx-6">
                        <div class="text-center mb-8">
                            <img class="mx-auto block h-24 w-auto lg:hidden" src="<?= base_url('assets/img/logo_V.png') ?>" alt="Afyadata">
                            <img class="hidden mx-auto h-24 w-auto lg:block" src="<?= base_url('assets/img/logo_V.png') ?>" alt="Afyadata">
                            <!-- <h4 class="text-xl font-semibold mt-1 mb-12 pb-1"></h4> -->
                        </div>

                        <?= form_open('auth/login', 'class="form-horizontal"') ?>

                        <p class="mb-4 text-center">Please login to your account</p>
                        <div class="mb-4">
                            <input type="username" class="form-control block w-full px-3 py-3 text-sm font-normal text-gray-900 placeholder-gray-500 bg-white bg-clip-padding border border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="id_username" name="identity" placeholder="Write email/username ..." />
                        </div>
                        <div class="mb-4">
                            <input type="password" class="form-control block w-full px-3 py-3 text-sm font-normal text-gray-900 placeholder-gray-500 bg-white bg-clip-padding border border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="id_password" name="password" placeholder="Password..." />
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                            </div>

                            <div class="text-sm">
                                <a href="#" class="font-normal text-sm text-blue-800 hover:text-blue-900">Forgot your password?</a>
                            </div>
                        </div>

                        <div class="text-center pt-1 mb-8 pb-1">
                            <button class="inline-block py-2.5 px-4 text-white font-medium text-sm leading-tight rounded shadow-md hover:bg-red-900 hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out w-full mb-3 bg-red-800" type="submit">
                                Log in
                            </button>
                        </div>

                        <div class="flex items-center justify-between pb-6">
                            <p class="mb-0 mr-2 text-sm text-gray-700">Don't have an account?</p>
                            <a href="/" class="inline-block px-6 py-2 border-2 border-blue-800 text-blue-800 font-medium text-xs leading-tight rounded hover:text-white hover:bg-blue-800 focus:outline-none focus:ring-0 transition duration-150 ease-in-out" data-mdb-ripple="true" data-mdb-ripple-color="light">
                                Return Home <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </section>