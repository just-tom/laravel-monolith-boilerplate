<script lang="ts" setup>
import { ref, reactive, nextTick, PropType } from "vue"
import DialogModal from "./ModalDialog.vue"
import InputError from "../Inputs/InputError.vue"
import PrimaryButton from "../Buttons/ButtonPrimary.vue"
import SecondaryButton from "../Buttons/ButtonSecondary.vue"
import TextInput from "../Inputs/TextInput.vue"
import { route } from "momentum-trail"
import axios from "@/utilities/axios"
import { UserPasswordData } from "@/types/models"

defineProps({
    title: {
        type: String as PropType<string>,
        default: "Confirm Password",
    },
    content: {
        type: String as PropType<string>,
        default: "For your security, please confirm your password to continue.",
    },
    button: {
        type: String as PropType<string>,
        default: "Confirm",
    },
})

const emit = defineEmits(["confirmed"])

const confirmingPassword = ref<boolean>(false)

const form = reactive<{
    password: UserPasswordData["password"]
    error: string
    processing: boolean
}>({
    password: "",
    error: "",
    processing: false,
})

const passwordInput = ref<HTMLInputElement | null>(null)

const startConfirmingPassword = () => {
    axios.get(route("password.confirmation")).then((response) => {
        if (response.data.confirmed) {
            emit("confirmed")
        } else {
            confirmingPassword.value = true

            setTimeout(() => passwordInput.value?.focus(), 250)
        }
    })
}

const confirmPassword = () => {
    form.processing = true

    axios
        .post(route("password.confirm"), {
            password: form.password,
        })
        .then(() => {
            form.processing = false

            closeModal()
            nextTick().then(() => emit("confirmed"))
        })
        .catch((error) => {
            form.processing = false
            form.error = error.response.data.errors.password[0]
            passwordInput.value?.focus()
        })
}

const closeModal = () => {
    confirmingPassword.value = false
    form.password = ""
    form.error = ""
}
</script>

<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot />
        </span>

        <DialogModal
            :show="confirmingPassword"
            @close="closeModal">
            <template #title>
                {{ title }}
            </template>

            <template #content>
                {{ content }}

                <div class="mt-4">
                    <TextInput
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        @keyup.enter="confirmPassword" />

                    <InputError
                        :message="form.error"
                        class="mt-2" />
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="confirmPassword">
                    {{ button }}
                </PrimaryButton>
            </template>
        </DialogModal>
    </span>
</template>
