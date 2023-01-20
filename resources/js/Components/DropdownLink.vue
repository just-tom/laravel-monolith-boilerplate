<script lang="ts" setup>
import { Link } from "@inertiajs/vue3"
import { PropType } from "vue"

defineProps({
    href: {
        type: String as PropType<string>,
        default: "",
    },
    as: {
        type: String as PropType<string | null>,
        default: null,
    },
})
</script>

<template>
    <div>
        <button
            v-if="as == 'button'"
            type="submit"
            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 transition hover:bg-gray-100 focus:bg-gray-100 focus:outline-none">
            <slot />
        </button>

        <a
            v-else-if="as == 'a'"
            :href="href"
            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition hover:bg-gray-100 focus:bg-gray-100 focus:outline-none">
            <slot />
        </a>

        <Link
            v-else
            :href="href"
            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition hover:bg-gray-100 focus:bg-gray-100 focus:outline-none">
            <slot />
        </Link>
    </div>
</template>
