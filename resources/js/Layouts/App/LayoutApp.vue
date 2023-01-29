<script lang="ts" setup>
import { PropType } from "vue"
import { Head } from "@inertiajs/vue3"
import Banner from "@/Components/Banner.vue"
import NavBar from "@/Layouts/App/Partials/NavBar.vue"

defineProps({
    title: {
        type: String as PropType<string>,
        default: "",
    },
})
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <NavBar />

            <!-- Page Heading -->
            <header
                v-if="$slots.header"
                class="bg-white shadow">
                <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
