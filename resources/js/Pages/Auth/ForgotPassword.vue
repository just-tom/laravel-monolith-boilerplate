<script lang="ts" setup>
import { Head, useForm } from "@inertiajs/vue3"
import AuthenticationCard from "@/Components/AuthenticationCard.vue"
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue"
import InputError from "@/Components/Inputs/InputError.vue"
import InputLabel from "@/Components/Inputs/InputLabel.vue"
import PrimaryButton from "@/Components/Buttons/ButtonPrimary.vue"
import TextInput from "@/Components/Inputs/TextInput.vue"
import { route } from "momentum-trail"
import { PropType } from "vue"
import { UserData } from "@/types/models"

defineProps({
    status: {
        type: String as PropType<string | null>,
        default: null,
    },
})

const form = useForm<{
    email: UserData["email"]
}>({
    email: "",
})

const submit = () => {
    form.post(route("password.email"))
}
</script>

<template>
    <Head title="Forgot Password" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </div>

        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel
                    for="email"
                    value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus />
                <InputError
                    class="mt-2"
                    :message="form.errors.email" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Email Password Reset Link
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
