<script lang="ts" setup>
import { PropType } from "vue"
import { ButtonHTMLAttributes } from "vue"

defineProps({
    type: {
        type: String as PropType<ButtonHTMLAttributes["type"]>,
        default: "submit",
    },
})
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-red-500 focus:border-red-700 focus:outline-none focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25">
        <slot />
    </button>
</template>
