<script lang="ts" setup>
import { onMounted, PropType, ref } from "vue"

defineProps({
    modelValue: {
        type: String as PropType<string>,
        required: true,
    },
    autocomplete: {
        type: String as PropType<string>,
        default: "off",
    },
})

const emit = defineEmits(["update:modelValue"])

const input = ref<HTMLInputElement | null>(null)

onMounted(() => {
    if (input.value?.hasAttribute("autofocus")) {
        input.value?.focus()
    }
})

const updateValue = (e: Event) => {
    emit("update:modelValue", (e.target as HTMLInputElement).value)
}

defineExpose({ focus: () => input.value?.focus() })
</script>

<template>
    <input
        ref="input"
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        :value="modelValue"
        :autocomplete="autocomplete"
        @input="updateValue" />
</template>
