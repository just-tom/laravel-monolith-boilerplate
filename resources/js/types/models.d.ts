export type AgentData = {
    browser: string
    is_desktop: boolean
    platform: string
}
export type ApiTokenData = {
    id?: number
    name: string
    abilities: Array<string>
    last_used_ago: string | null
    last_used_at: string | null
    tokenable_id: number
    tokenable_type: string
    created_at: string | null
    updated_at: string | null
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
export type TeamData = {
    id?: number
    owner: UserData
    name: string
    personal_team: boolean
    users: Array<UserData>
    team_invitations: Array<TeamInvitationData>
    created_at: string | null
    updated_at: string | null
}
export type TeamInvitationData = {
    id?: number
    team_id: number | null
    email: string
    role: string
    created_at: string | null
    updated_at: string | null
}
export type TeamMemberData = {
    team_id: number
    user_id: number
    role: string
    created_at: string
    updated_at: string
}
export type TeamPermissionsData = {
    canAddTeamMembers: boolean
    canDeleteTeam: boolean
    canRemoveTeamMembers: boolean
    canUpdateTeam: boolean
}
export type UserData = {
    id?: number
    name: string
    email: string
    email_verified_at: string | null
    password: string
    profile_photo_url: string
    profile_photo_path: string
    password_confirmation: string
    current_password: string
    current_team: TeamData | null
    all_teams: Array<TeamData> | null
    two_factor_enabled: boolean | null
    terms: boolean | Array<string>
    remember: boolean | Array<string>
    membership?: TeamMemberData
    created_at: string | null
    updated_at: string | null
}
