<template>
    <div class="h-screen w-full flex flex-col">
        <div class="w-full px-4 sm:px-6 lg:px-8 border-b">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <div class="flex shrink-0 items-center">
                        <img
                            class="block h-8 w-auto lg:hidden"
                            src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                            alt="Your Company"
                        />
                        <img
                            class="hidden h-8 w-auto lg:block"
                            src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                            alt="Your Company"
                        />
                    </div>
                    <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                        <NuxtLink
                            to="/"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium"
                            >Calendar</NuxtLink
                        >
                        <NuxtLink
                            to="/cart"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium"
                            >Cart</NuxtLink
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-grow">
            <NuxtLayout>
                <NuxtPage :page-key="(route) => route.fullPath" />
            </NuxtLayout>
        </div>

        <Toaster />
    </div>
</template>
