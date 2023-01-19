declare namespace Models.Jetstream {
    export interface Team {
        id: number
        user_id: number
        name: string
        personal_team: boolean
        users: User[]
        created_at: string
        updated_at: string
    }

    export interface TeamMember {
        team_id: number
        user_id: number
        role: string
        membership: Membership
        created_at: string
        updated_at: string
    }

    export interface Membership {
        role: Role
    }

    export interface TeamMemberPermission {
        canAddTeamMembers: boolean
        canDeleteTeam: boolean
        canRemoveTeamMembers: boolean
        created_at: string
        canUpdateTeam: boolean
    }


    export interface User {
        id: number
        name: string
        email: string
        email_verified_at: string | null
        current_team_id: number | null
        profile_photo_path: string | null
        created_at: string | null
        updated_at: string | null
        two_factor_confirmed_at: string | null
        profile_photo_url: string
    }

    export interface UserSession {
        agent: {
            browser: string
            is_desktop: boolean
            platform: string
        }
        ip_address: string
        is_current_device: boolean
        last_active: string
    }

    export interface TeamInvitation {
        id: number
        team_id: number
        email: string
        role: string
        created_at: string | null
        updated_at: string | null
    }

    export type CRUDPermissions = ("create" | "read" | "update" | "delete")[]

    export interface Role {
        description: string
        key: string
        name: string
        permissions: CRUDPermissions[]
    }

    export interface ApiToken {
        id: number
        name: string
        abilities: CRUDPermissions
        last_used_ago: string | null
        last_used_at: string | null
        created_at: string | null
        updated_at: string | null
        tokeneable_id: number
        tokeneable_type: string
    }
}
