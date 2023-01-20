<script lang="ts" setup>
import AppLayout from "@/Layouts/AppLayout.vue"
import DeleteTeamForm from "@/Pages/Teams/Partials/DeleteTeamForm.vue"
import SectionBorder from "@/Components/SectionBorder.vue"
import TeamMemberManager from "@/Pages/Teams/Partials/TeamMemberManager.vue"
import UpdateTeamNameForm from "@/Pages/Teams/Partials/UpdateTeamNameForm.vue"
import { PropType } from "vue"
import { RoleData, TeamData, TeamPermissionsData } from "@/types/models"

defineProps({
    team: {
        type: Object as PropType<TeamData>,
        required: true,
    },
    availableRoles: {
        type: Array as PropType<RoleData[]>,
        default: () => [],
    },
    permissions: {
        type: Object as PropType<TeamPermissionsData>,
        required: true,
    },
})
</script>

<template>
    <AppLayout title="Team Settings">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Team Settings</h2>
        </template>

        <div>
            <div class="mx-auto max-w-7xl py-10 sm:px-6 lg:px-8">
                <UpdateTeamNameForm
                    :team="team"
                    :permissions="permissions" />

                <TeamMemberManager
                    class="mt-10 sm:mt-0"
                    :team="team"
                    :available-roles="availableRoles"
                    :user-permissions="permissions" />

                <template v-if="permissions.canDeleteTeam && !team.personal_team">
                    <SectionBorder />

                    <DeleteTeamForm
                        class="mt-10 sm:mt-0"
                        :team="team" />
                </template>
            </div>
        </div>
    </AppLayout>
</template>
