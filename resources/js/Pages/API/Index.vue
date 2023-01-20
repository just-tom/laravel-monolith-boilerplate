<script lang="ts" setup>
import ApiTokenManager from "@/Pages/API/Partials/ApiTokenManager.vue"
import AppLayout from "@/Layouts/AppLayout.vue"
import { PropType } from "vue"
import { ApiTokenData } from "@/types/models"

defineProps({
    tokens: {
        type: Array as PropType<ApiTokenData[]>,
        required: true,
    },
    availablePermissions: {
        type: Array as PropType<string[]>,
        required: true,
    },
    defaultPermissions: {
        type: Array as PropType<string[]>,
        default: () => [],
    },
})
</script>

<template>
    <AppLayout title="API Tokens">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">API Tokens</h2>
        </template>

        <div>
            <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
                <ApiTokenManager
                    :tokens="tokens"
                    :available-permissions="availablePermissions"
                    :default-permissions="defaultPermissions" />
            </div>
        </div>
    </AppLayout>
</template>
