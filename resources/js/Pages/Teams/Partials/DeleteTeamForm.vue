<script lang="ts" setup>
import { PropType, ref } from "vue"
import { useForm } from "@inertiajs/vue3"
import ActionSection from "@/Components/ActionSection.vue"
import ConfirmationModal from "@/Components/Modals/ModalConfirmation.vue"
import DangerButton from "@/Components/Buttons/ButtonDanger.vue"
import SecondaryButton from "@/Components/Buttons/ButtonSecondary.vue"
import { route } from "momentum-trail"
import { TeamData, UserData } from "@/types/models"

const props = defineProps({
    team: {
        type: Object as PropType<TeamData>,
        required: true,
    },
})

const confirmingTeamDeletion = ref<boolean>(false)
const form = useForm<{}>({})

const confirmTeamDeletion = () => {
    confirmingTeamDeletion.value = true
}

const deleteTeam = () => {
    form.delete(route("teams.destroy", props.team), {
        errorBag: "deleteTeam",
    })
}
</script>

<template>
    <ActionSection>
        <template #title> Delete Team </template>

        <template #description> Permanently delete this team. </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this
                team, please download any data or information regarding this team that you wish to retain.
            </div>

            <div class="mt-5">
                <DangerButton @click="confirmTeamDeletion"> Delete Team </DangerButton>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <ConfirmationModal
                :show="confirmingTeamDeletion"
                @close="confirmingTeamDeletion = false">
                <template #title> Delete Team </template>

                <template #content>
                    Are you sure you want to delete this team? Once a team is deleted, all of its resources and data
                    will be permanently deleted.
                </template>

                <template #footer>
                    <SecondaryButton @click="confirmingTeamDeletion = false"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteTeam">
                        Delete Team
                    </DangerButton>
                </template>
            </ConfirmationModal>
        </template>
    </ActionSection>
</template>
