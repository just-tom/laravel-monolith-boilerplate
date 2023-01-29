<script lang="ts" setup>
import { PropType } from "vue"

defineProps({
    message: {
        type: String as PropType<string | undefined>,
        default: undefined,
    },
})
</script>

<template>
    <div v-show="message">
        <p class="text-sm text-red-600">
            {{ message }}
        </p>
    </div>
</template>
