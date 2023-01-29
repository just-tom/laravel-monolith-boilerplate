<script lang="ts" setup>
import { PropType } from "vue"

defineProps({
    value: {
        type: String as PropType<string | boolean>,
        default: "",
    },
})
</script>

<template>
    <label class="block text-sm font-medium text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
