<script lang="ts" setup>
import { useForm } from "@inertiajs/vue3"
import ActionMessage from "@/Components/ActionMessage.vue"
import FormSection from "@/Components/FormSection.vue"
import InputError from "@/Components/Inputs/InputError.vue"
import InputLabel from "@/Components/Inputs/InputLabel.vue"
import PrimaryButton from "@/Components/Buttons/ButtonPrimary.vue"
import TextInput from "@/Components/Inputs/TextInput.vue"
import { PropType } from "vue"
import { route } from "momentum-trail"
import { TeamData, TeamUpdateData } from "@/types/models"
import { can } from "momentum-lock"

const props = defineProps({
    team: {
        type: Object as PropType<TeamData>,
        required: true,
    },
})

const form = useForm<{
    name: TeamUpdateData["name"]
}>({
    name: props.team.name,
})

const updateTeamName = () => {
    form.put(route("teams.update", props.team), {
        errorBag: "updateTeamName",
        preserveScroll: true,
    })
}
</script>

<template>
    <FormSection @submitted="updateTeamName">
        <template #title> Team Name </template>

        <template #description> The team's name and owner information. </template>

        <template #form>
            <!-- Team Owner Information -->
            <div class="col-span-6">
                <InputLabel value="Team Owner" />

                <div class="mt-2 flex items-center">
                    <img
                        class="h-12 w-12 rounded-full object-cover"
                        :src="team.owner.profile_photo_url"
                        :alt="team.owner.name" />

                    <div class="ml-4 leading-tight">
                        <div>{{ team.owner.name }}</div>
                        <div class="text-sm text-gray-700">
                            {{ team.owner.email }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="name"
                    value="Team Name" />

                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    :disabled="!can(team, 'update')" />

                <InputError
                    :message="form.errors.name"
                    class="mt-2" />
            </div>
        </template>

        <template
            v-if="can(team, 'update')"
            #actions>
            <ActionMessage
                :on="form.recentlySuccessful"
                class="mr-3">
                Saved.
            </ActionMessage>

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </FormSection>
</template>
