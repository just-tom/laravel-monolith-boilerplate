<script lang="ts" setup>
import { Head } from "@inertiajs/vue3"
import NavBar from "@/Layouts/Marketing/Partials/NavBar.vue"
</script>

<template>
    <Head title="Welcome" />

    <div
        class="items-top relative flex min-h-screen justify-center bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <NavBar />

        <main class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            <slot />
        </main>
    </div>
</template>
