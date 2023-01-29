<script lang="ts" setup>
import { computed, PropType } from "vue"

const props = defineProps({
    checked: {
        type: [Array, Boolean] as PropType<string[] | boolean | null>,
        default: false,
    },
    value: {
        type: String as PropType<string>,
        default: null,
    },
})

const emit = defineEmits(["update:checked"])

const proxyChecked = computed({
    get(): string[] | boolean {
        return props.checked!
    },

    set(val: string[] | boolean) {
        emit("update:checked", val)
    },
})
</script>

<template>
    <input
        v-model="proxyChecked"
        type="checkbox"
        :value="value"
        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
</template>
