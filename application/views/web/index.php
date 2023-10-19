<main class="">
    <!-- <div class="relative px-6 lg:px-8">
        <div class="mx-auto max-w-2xl pt-12 pb-12 sm:pt-24 lg:pt-28">
            <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                <div class="relative rounded-full py-1 px-3 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                    Taarifa kwa wakati!! <a href="#" class="font-semibold text-blue-800"><span class="absolute inset-0" aria-hidden="true"></span>Explore more <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-4xl">AfyaData for One Health Surveillance.</h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Afyadata is a tool that analyzes all the data collected from the field and intelligently sends feedback to the data collector and sends an alert to higher authority officials if any abnormal pattern is discovered in the data collected.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="<?= site_url('auth/login') ?>" class="rounded-md bg-red-900 px-3.5 py-1.5 text-base font-semibold leading-7 text-white shadow-sm hover:bg-red-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Get started</a>
                    <a href="<?= site_url('about') ?>" class="text-base font-semibold leading-7 text-gray-900">Learn more <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
            <svg class="relative left-[calc(50%+3rem)] h-[21.1875rem] max-w-none -translate-x-1/2 sm:left-[calc(50%+36rem)] sm:h-[42.375rem]" viewBox="0 0 1155 678" xmlns="http://www.w3.org/2000/svg">
                <path fill="url(#ecb5b0c9-546c-4772-8c71-4d3f06d544bc)" fill-opacity=".3" d="M317.219 518.975L203.852 678 0 438.341l317.219 80.634 204.172-286.402c1.307 132.337 45.083 346.658 209.733 145.248C936.936 126.058 882.053-94.234 1031.02 41.331c119.18 108.451 130.68 295.337 121.53 375.223L855 299l21.173 362.054-558.954-142.079z" />
                <defs>
                    <linearGradient id="ecb5b0c9-546c-4772-8c71-4d3f06d544bc" x1="1155.49" x2="-78.208" y1=".177" y2="474.645" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#9089FC"></stop>
                        <stop offset="1" stop-color="#FF80B5"></stop>
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </div> -->

    <div class="bg-white py-4 sm:py-8 container mx-auto">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-lg font-semibold leading-8 tracking-tight text-blue-800">Collecte de données fluide</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Tout ce dont vous avez besoin pour utiliser l'application AfyaData</p>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Pour utiliser AfyaData, vous devez suivre les étapes de la collecte à l'analyse des données.
                </p>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap mb-4 px-12 py-4 container mx-auto">
        <div class="w-full md:w-1/3 xl:w-1/3">
            <img class="h-64" src="<?= base_url('assets/public/images/upload_new_form.png') ?>" width="100%" />
            <h3 class="text-center text-base font-semibold leading-7 text-gray-900">Créer un projet</h3>
            <p class="text-center text-sm leading-8 text-gray-600">
                <a href="<?= site_url('create-project') ?>" class="">
                    En savoir plus <span aria-hidden="true">&rarr;</span>
                </a>
            </p>
        </div>

        <div class="w-full md:w-1/3 xl:w-1/3">
            <img class="h-64" src="<?= base_url('assets/public/images/collect_data.png') ?>" width="100%" />
            <h3 class="text-center text-base font-semibold leading-7 text-gray-900">Collecte de données en ligne/hors ligne</h3>
            <p class="text-center text-sm leading-8 text-gray-600">
                <a href="<?= site_url('collect-data') ?>" class="">
                    En savoir plus <span aria-hidden="true">&rarr;</span>
                </a>
            </p>
        </div>

        <div class="w-full md:w-1/3 xl:w-1/3">
            <img class="h-64" src="<?= base_url('assets/public/images/visualize.png') ?>" width="100%" />
            <h3 class="text-center text-base font-semibold leading-7 text-gray-900">Visualiser et analyser les données</h3>
            <p class="text-center text-sm leading-8 text-gray-600">
                <a href="<?= site_url('analyze-data') ?>" class="">
                    En savoir plus <span aria-hidden="true">&rarr;</span>
                </a>
            </p>
        </div>
    </div>

    <div class="bg-gray-100 py-4 sm:py-8">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-lg font-semibold leading-8 tracking-tight text-blue-800">Plateforme Open Source</h2>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-gray-900 sm:text-2xl">Participer avec AfyaData</p>
                <p class="mt-6 text-lg leading-8 text-gray-600 mb-4">
                    Êtes-vous intéressé par l'utilisation d'AfyaData pour la collecte de données ou pour contribuer au codage ?
                </p>

                <a href="http://142.93.198.244/Afyadata_v1.4.apk" class="rounded-sm border border-transparent bg-red-900 px-4 py-2 text-sm font-medium text-white hover:bg-red-600">
                    <i class="fa fa-android fa-lg"></i> Télécharger l'application</a>&nbsp;&nbsp;

                <a href="https://github.com/sacids/dataManager" class="rounded-sm border border-transparent bg-slate-700 px-4 py-2 text-sm font-medium text-white hover:bg-slate-600">
                    <i class="fa fa-github fa-lg"></i> Dépôt GitHub</a>
            </div>
        </div>
    </div>

</main>