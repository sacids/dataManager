<header class="bg-gray-100">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl font-medium tracking-tight text-gray-900">My Profile</h1>
    </div>
</header>

<header class="bg-gray-100">
    <div class="mx-auto py-0 px-4 sm:px-6">
        <div class="text-sm text-center text-gray-900">
            <ul class="flex flex-wrap">
                <li class="border-b-4 border-red-900">
                    <a href="<?= site_url('auth/profile'); ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        My Profile
                    </a>
                </li>

                <li class="">
                    <a href="<?= site_url('auth/change_password'); ?>" class="inline-block border-b-2 p-2 border-transparent rounded-t-lg hover:text-gray-600  dark:hover:text-gray-900">
                        Change Password
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
                    <?php if ($this->session->flashdata('message') != "") { ?>
                        <div class="bg-teal-100 rounded-b text-teal-900 px-4 py-3 mb-4" role="alert">
                            <div class="flex">
                                <div>
                                    <p class="text-sm font-normal"><?= $this->session->flashdata('message'); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <table class="w-1/3 text-sm text-left">
                        <tr class="bg-white border-b">
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Name</td>
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php echo $fname; ?></td>
                        </tr>

                        <tr class="bg-white border-b">
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Username</td>
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php echo $username; ?></td>
                        </tr>

                        <tr class="bg-white border-b">
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Phone</td>
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php echo $phone; ?></td>
                        </tr>
                        <tr class="bg-white border-b">
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Email</td>
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php echo $email; ?></td>
                        </tr>
                        <tr class="bg-white border-b">
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Phone</td>
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php echo $phone; ?></td>
                        </tr>
                        <tr class="bg-white border-b">
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Status</td>
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php
                                if ($status == '1') {
                                    echo 'Active';
                                } else {
                                    echo 'Inactive';
                                }
                                ?></td>
                        </tr>
                        <tr class="bg-white border-b">
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Created on</td>
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php echo $created; ?></td>
                        </tr>
                        <tr class="bg-white border-b">
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap">Last Login</td>
                            <td class="px-0 py-2 text-left font-normal text-sm text-gray-600 whitespace-nowrap"><?php echo $last_login; ?></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</main>