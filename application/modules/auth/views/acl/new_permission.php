<div class="bg-gray-100">
    <div class="mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">
            Create New Access Control
        </h1>
    </div>

    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-left text-gray-900">
            <?php
            foreach ($links as $key => $link) {
                echo $link;
            }
            ?>
        </div>
    </div>
</div>
</header>


<main class="bg-white h-full">
    <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-row flex-wrap mt-2">
            <div class="flex w-1/2 flex-col">
                <div class="relative overflow-x-auto">
                    <?php if ($this->session->flashdata('message') != "") { ?>
                        <div class="bg-teal-100 rounded-b text-teal-900 px-4 py-3 mb-4" role="alert">
                            <div class="flex">
                                <div>
                                    <p class="text-sm font-normal"><?= $this->session->flashdata('message'); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php echo form_open('auth/accesscontrol/new_permission', 'role="form"'); ?>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            ACL name <span class="text-red-500">*</span>
                        </label>
                        <?php echo form_input($name); ?>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Description 
                        </label>
                        <?php echo form_textarea($description); ?>
                    </div>

                    <div class="flex items-start">
                        <button type="submit" class="text-white bg-slate-800 hover:bg-red-900 focus:ring-4 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
                    </div>
                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
        <!-- /End replace -->
    </div>
</main>