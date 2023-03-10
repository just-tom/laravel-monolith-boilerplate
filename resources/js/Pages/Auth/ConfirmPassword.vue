<script lang="ts" setup>
import { ref } from "vue"
import { Head, useForm } from "@inertiajs/vue3"
import AuthenticationCard from "@/Components/AuthenticationCard.vue"
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue"
import InputError from "@/Components/Inputs/InputError.vue"
import InputLabel from "@/Components/Inputs/InputLabel.vue"
import PrimaryButton from "@/Components/Buttons/ButtonPrimary.vue"
import TextInput from "@/Components/Inputs/TextInput.vue"
import { route } from "momentum-trail"
import { UserPasswordData } from "@/types/models"

const form = useForm<{
    password: UserPasswordData["password"]
}>({
    password: "",
})

const passwordInput = ref<HTMLInputElement | null>(null)

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => {
            form.reset()

            passwordInput.value?.focus()
        },
    })
}
</script>

<template>
    <Head title="Secure Area" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel
                    for="password"
                    value="Password" />
                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                    autofocus />
                <InputError
                    class="mt-2"
                    :message="form.errors.password" />
            </div>

            <div class="mt-4 flex justify-end">
                <PrimaryButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Confirm
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
