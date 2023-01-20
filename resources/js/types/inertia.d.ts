import { PageProps, Page } from "@inertiajs/vue3"

export {}

declare module "@inertiajs/vue3" {
    export function usePage<T>(): Page<T>
}

declare module "@vue/runtime-core" {
    interface ComponentCustomProperties {
        $page: Page
    }
}

declare global {
    import User = Models.Jetstream.User

    export interface Props extends PageProps {
        jetstream: {
            canCreateTeams: boolean
            canManageTwoFactorAuthentication: boolean
            canUpdatePassword: boolean
            canUpdateProfileInformation: boolean
            hasEmailVerification: boolean
            flash: {
                bannerStyle?: "success" | "danger"
                banner?: string
                token?: string
            }
            hasAccountDeletionFeatures: boolean
            hasApiFeatures: boolean
            hasTeamFeatures: boolean
            hasTermsAndPrivacyPolicyFeature: boolean
            managesProfilePhotos: boolean
        }
        errorBags: unknown
        errors: unknown
    }
}
