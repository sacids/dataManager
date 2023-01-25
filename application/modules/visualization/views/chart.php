<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            <?= isset($project) ? $project->title : '' ?> > <?= $form->title ?>
        </h1>
    </div>
</header>

<header class="bg-gray-100">
    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-center text-gray-900">
            <ul class="flex flex-wrap">
                <li class="">
                    <a href="#" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Overview
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("xform/form_data/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Table
                    </a>
                </li>

                <li class="border-b-4 border-red-900">
                    <a href="<?= site_url("visualization/visualization/chart/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Charts
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url("visualization/visualization/map/" . $project->id . '/' . $form->id) ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Map
                    </a>
                </li>

                <li class="">
                    <a href="#" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Mapping Fields
                    </a>
                </li>

                <li class="">
                    <a href="#" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Permission
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

<main class="bg-white h-full">
    <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-row flex-wrap mt-2">
            <div class="w-full">
                <div class="relative overflow-x-auto">
                
                </div>
            </div>
        </div>
        <!-- /End replace -->
    </div>
</main>


<script type="text/javascript">

</script>