<script lang="ts" setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import AuthenticationCard from "@/Components/AuthenticationCard.vue"
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue"
import Checkbox from "@/Components/Inputs/Checkbox.vue"
import InputError from "@/Components/Inputs/InputError.vue"
import InputLabel from "@/Components/Inputs/InputLabel.vue"
import PrimaryButton from "@/Components/Buttons/ButtonPrimary.vue"
import TextInput from "@/Components/Inputs/TextInput.vue"
import { route } from "momentum-trail"
import { PropType } from "vue"
import { UserData, UserPasswordData } from "@/types/models"

defineProps({
    canResetPassword: Boolean as PropType<boolean>,
    status: {
        type: String as PropType<string>,
        default: "",
    },
})

const form = useForm<{
    email: UserData["email"]
    password: UserPasswordData["password"]
    remember: UserData["remember"]
}>({
    email: "",
    password: "",
    remember: false,
})

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    })
}
</script>

<template>
    <Head title="Log in" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

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
                    autocomplete="on"
                    required
                    autofocus />
                <InputError
                    class="mt-2"
                    :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password"
                    value="Password" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password" />
                <InputError
                    class="mt-2"
                    :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox
                        v-model:checked="form.remember"
                        name="remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-gray-600 underline hover:text-gray-900">
                    Forgot your password?
                </Link>

                <PrimaryButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
