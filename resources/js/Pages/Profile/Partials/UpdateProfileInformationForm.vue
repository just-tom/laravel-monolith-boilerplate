<script lang="ts" setup>
import { PropType, ref } from "vue"
import { Link, router, useForm } from "@inertiajs/vue3"
import ActionMessage from "@/Components/ActionMessage.vue"
import FormSection from "@/Components/FormSection.vue"
import InputError from "@/Components/Inputs/InputError.vue"
import InputLabel from "@/Components/Inputs/InputLabel.vue"
import PrimaryButton from "@/Components/Buttons/ButtonPrimary.vue"
import SecondaryButton from "@/Components/Buttons/ButtonSecondary.vue"
import TextInput from "@/Components/Inputs/TextInput.vue"
import { route } from "momentum-trail"
import { Method } from "@inertiajs/core"
import { UserData, UserUpdateData } from "@/types/models"

const props = defineProps({
    user: {
        type: Object as PropType<UserData>,
        required: true,
    },
})

const form = useForm<{
    _method: Method.PUT
    name: UserUpdateData["name"]
    email: UserUpdateData["email"]
    photo: File | null
}>({
    _method: Method.PUT,
    name: props.user.name,
    email: props.user.email,
    photo: null,
})

const verificationLinkSent = ref<boolean>(false)
const photoPreview = ref<string | null>(null)
const photoInput = ref<HTMLInputElement | null>(null)

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files![0]
    }

    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    })
}

const sendEmailVerification = () => {
    verificationLinkSent.value = true
}

const selectNewPhoto = () => {
    photoInput.value?.click()
}

const updatePhotoPreview = () => {
    const photo = photoInput.value?.files![0]

    if (!photo) return

    const reader: FileReader = new FileReader()

    reader.onload = (e: any) => {
        photoPreview.value = e.target.result
    }

    reader.readAsDataURL(photo)
}

const deletePhoto = () => {
    router.delete(route("current-user-photo.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null
            clearPhotoFileInput()
        },
    })
}

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        // TODO - check this - originally null but changed to '' for typscript
        photoInput.value.value = ""
    }
}
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title> Profile Information </template>

        <template #description> Update your account's profile information and email address. </template>

        <template #form>
            <!-- Profile Photo -->
            <div
                v-if="$page.props.jetstream.managesProfilePhotos"
                class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input
                    ref="photoInput"
                    type="file"
                    class="hidden"
                    @change="updatePhotoPreview" />

                <InputLabel
                    for="photo"
                    value="Photo" />

                <!-- Current Profile Photo -->
                <div
                    v-show="!photoPreview"
                    class="mt-2">
                    <img
                        :src="user.profile_photo_url"
                        :alt="user.name"
                        class="h-20 w-20 rounded-full object-cover" />
                </div>

                <!-- New Profile Photo Preview -->
                <div
                    v-show="photoPreview"
                    class="mt-2">
                    <span
                        class="block h-20 w-20 rounded-full bg-cover bg-center bg-no-repeat"
                        :style="'background-image: url(\'' + photoPreview + '\');'" />
                </div>

                <SecondaryButton
                    class="mt-2 mr-2"
                    type="button"
                    @click.prevent="selectNewPhoto">
                    Select A New Photo
                </SecondaryButton>

                <SecondaryButton
                    v-if="user.profile_photo_path"
                    type="button"
                    class="mt-2"
                    @click.prevent="deletePhoto">
                    Remove Photo
                </SecondaryButton>

                <InputError
                    :message="form.errors.photo"
                    class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="name"
                    value="Name" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="name" />
                <InputError
                    :message="form.errors.name"
                    class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel
                    for="email"
                    value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full" />
                <InputError
                    :message="form.errors.email"
                    class="mt-2" />

                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="mt-2 text-sm">
                        Your email address is unverified.

                        <Link
                            :href="route('verification.send')"
                            :method="Method.POST"
                            as="button"
                            class="text-gray-600 underline hover:text-gray-900"
                            @click.prevent="sendEmailVerification">
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div
                        v-show="verificationLinkSent"
                        class="mt-2 text-sm font-medium text-green-600">
                        A new verification link has been sent to your email address.
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
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
