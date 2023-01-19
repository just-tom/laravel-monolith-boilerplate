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
    export interface Props extends PageProps {
        user: Models.Domain.User & {
            all_teams?: Array<Models.Jetstream.Team> | null
            current_team?: Models.Jetstream.Team
            two_factor_enabled: boolean
            membership?: Models.Jetstream.TeamMember
        }
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
