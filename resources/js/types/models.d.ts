export type AgentData = {
    browser: string
    is_desktop: boolean
    platform: string
}
export type ApiTokenData = {
    id?: number
    name?: string
    abilities: Array<string> | null
    permissions: Array<string> | null
    last_used_ago: string | null
    last_used_at: string | null
    tokenable_id: number | null
    tokenable_type: string | null
}
export type NotificationData = {
    type: any
    body: string
}
export type RoleData = {
    key: string
    name: string
    permissions: Array<string>
    description: string
}
export type SessionData = {
    ip_address: string
    is_current_device: boolean
    last_active: string
    agent: AgentData
}
export type SharedData = {
    user: UserData
    notification: NotificationData | null
}
export type TeamCreateData = {
    name: string
}
export type TeamData = {
    id?: number
    name: string
    personal_team: boolean
    owner: UserData
    users: Array<UserData>
    team_invitations: Array<TeamInvitationData>
    permissions: {
        viewAny: boolean
        view: boolean
        create: boolean
        update: boolean
        addTeamMember: boolean
        updateTeamMember: boolean
        removeTeamMember: boolean
        delete: boolean
        denyWithStatus: boolean
        denyAsNotFound: boolean
    }
}
export type TeamInvitationData = {
    id?: number
    team_id: number | null
    email: string
    role: string
}
export type TeamMemberData = {
    team_id?: number
    user_id?: number
    role: string
}
export type TeamUpdateData = {
    name: string
}
export type UserCreateData = {
    name: string
    email: string
    password: string
    password_confirmation: string
    terms?: boolean | Array<string>
    remember?: boolean | Array<string>
}
export type UserData = {
    id?: number
    name: string
    email: string
    email_verified_at: string | null
    profile_photo_url?: string
    profile_photo_path?: string
    current_team: TeamData | null
    all_teams: Array<TeamData> | null
    two_factor_enabled: boolean | null
    membership?: TeamMemberData
    remember: boolean | Array<string> | null
    created_at: string | null
    updated_at: string | null
}
export type UserPasswordData = {
    password: string
    current_password: string
    password_confirmation: string
}
export type UserUpdateData = {
    id?: number
    name: string
    email: string
    profile_photo_path: string | null
}
