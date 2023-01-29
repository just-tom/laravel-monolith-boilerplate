<script lang="ts" setup>
import { ref } from "vue"
import { router, Link } from "@inertiajs/vue3"
import { route, current } from "momentum-trail"
import { TeamData } from "@/types/models"
import ApplicationMark from "@/Components/ApplicationMark.vue"
import LinkNav from "@/Components/Links/LinkNav.vue"
import Dropdown from "@/Components/Dropdown.vue"
import LinkDropdown from "@/Components/Links/LinkDropdown.vue"
import LinkResponsiveNav from "@/Components/Links/LinkResponsiveNav.vue"

const showingNavigationDropdown = ref(false)

const switchToTeam = (team: TeamData) => {
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    )
}

const logout = () => {
    router.post(route("logout"))
}
</script>
<template>
    <nav class="border-b border-gray-100 bg-white">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex shrink-0 items-center">
                        <Link :href="route('dashboard')">
                            <ApplicationMark class="block h-9 w-auto" />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <LinkNav
                            :href="route('dashboard')"
                            :active="current('dashboard')">
                            Dashboard
                        </LinkNav>
                    </div>
                </div>

                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div class="relative ml-3">
                        <!-- Teams Dropdown -->
                        <Dropdown
                            v-if="$page.props.jetstream.hasTeamFeatures"
                            align="right"
                            width="60">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition hover:bg-gray-50 hover:text-gray-700 focus:bg-gray-50 focus:outline-none active:bg-gray-50">
                                        {{ $page.props.user.current_team.name }}

                                        <svg
                                            class="ml-2 -mr-0.5 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <template v-if="$page.props.jetstream.hasTeamFeatures">
                                        <div class="block px-4 py-2 text-xs text-gray-400">Manage Team</div>

                                        <!-- Team Settings -->
                                        <LinkDropdown :href="route('teams.show', $page.props.user.current_team)">
                                            Team Settings
                                        </LinkDropdown>

                                        <LinkDropdown
                                            v-if="$page.props.jetstream.canCreateTeams"
                                            :href="route('teams.create')">
                                            Create New Team
                                        </LinkDropdown>

                                        <div class="border-t border-gray-100" />

                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">Switch Teams</div>

                                        <template
                                            v-for="team in $page.props.user.all_teams"
                                            :key="team.id">
                                            <form @submit.prevent="switchToTeam(team)">
                                                <LinkDropdown as="button">
                                                    <div class="flex items-center">
                                                        <svg
                                                            v-if="team.id == $page.props.user.current_team_id"
                                                            class="mr-2 h-5 w-5 text-green-400"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>

                                                        <div>{{ team.name }}</div>
                                                    </div>
                                                </LinkDropdown>
                                            </form>
                                        </template>
                                    </template>
                                </div>
                            </template>
                        </Dropdown>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="relative ml-3">
                        <Dropdown
                            align="right"
                            width="48">
                            <template #trigger>
                                <button
                                    v-if="$page.props.jetstream.managesProfilePhotos"
                                    class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-none">
                                    <img
                                        class="h-8 w-8 rounded-full object-cover"
                                        :src="$page.props.user.profile_photo_url"
                                        :alt="$page.props.user.name" />
                                </button>

                                <span
                                    v-else
                                    class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition hover:text-gray-700 focus:bg-gray-50 focus:outline-none active:bg-gray-50">
                                        {{ $page.props.user.name }}

                                        <svg
                                            class="ml-2 -mr-0.5 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>

                                <LinkDropdown :href="route('profile.show')"> Profile</LinkDropdown>

                                <LinkDropdown
                                    v-if="$page.props.jetstream.hasApiFeatures"
                                    :href="route('api-tokens.index')">
                                    API Tokens
                                </LinkDropdown>

                                <div class="border-t border-gray-100" />

                                <!-- Authentication -->
                                <form @submit.prevent="logout">
                                    <LinkDropdown as="button"> Log Out</LinkDropdown>
                                </form>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                        @click="showingNavigationDropdown = !showingNavigationDropdown">
                        <svg
                            class="h-6 w-6"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24">
                            <path
                                :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path
                                :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
            :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
            class="sm:hidden">
            <div class="space-y-1 pt-2 pb-3">
                <LinkResponsiveNav
                    :href="route('dashboard')"
                    :active="current('dashboard')">
                    Dashboard
                </LinkResponsiveNav>
            </div>

            <!-- Responsive Settings Options -->
            <div class="border-t border-gray-200 pt-4 pb-1">
                <div class="flex items-center px-4">
                    <div
                        v-if="$page.props.jetstream.managesProfilePhotos"
                        class="mr-3 shrink-0">
                        <img
                            class="h-10 w-10 rounded-full object-cover"
                            :src="$page.props.user.profile_photo_url"
                            :alt="$page.props.user.name" />
                    </div>

                    <div>
                        <div class="text-base font-medium text-gray-800">
                            {{ $page.props.user.name }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">
                            {{ $page.props.user.email }}
                        </div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <LinkResponsiveNav
                        :href="route('profile.show')"
                        :active="current('profile.show')">
                        Profile
                    </LinkResponsiveNav>

                    <LinkResponsiveNav
                        v-if="$page.props.jetstream.hasApiFeatures"
                        :href="route('api-tokens.index')"
                        :active="current('api-tokens.index')">
                        API Tokens
                    </LinkResponsiveNav>

                    <!-- Authentication -->
                    <form
                        method="POST"
                        @submit.prevent="logout">
                        <LinkResponsiveNav as="button"> Log Out</LinkResponsiveNav>
                    </form>

                    <!-- Team Management -->
                    <template v-if="$page.props.jetstream.hasTeamFeatures">
                        <div class="border-t border-gray-200" />

                        <div class="block px-4 py-2 text-xs text-gray-400">Manage Team</div>

                        <!-- Team Settings -->
                        <LinkResponsiveNav
                            :href="route('teams.show', $page.props.user.current_team)"
                            :active="current('teams.show')">
                            Team Settings
                        </LinkResponsiveNav>

                        <LinkResponsiveNav
                            v-if="$page.props.jetstream.canCreateTeams"
                            :href="route('teams.create')"
                            :active="current('teams.create')">
                            Create New Team
                        </LinkResponsiveNav>

                        <div class="border-t border-gray-200" />

                        <!-- Team Switcher -->
                        <div class="block px-4 py-2 text-xs text-gray-400">Switch Teams</div>

                        <template
                            v-for="team in $page.props.user.all_teams"
                            :key="team.id">
                            <form @submit.prevent="switchToTeam(team)">
                                <LinkResponsiveNav as="button">
                                    <div class="flex items-center">
                                        <svg
                                            v-if="team.id == $page.props.user.current_team_id"
                                            class="mr-2 h-5 w-5 text-green-400"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>{{ team.name }}</div>
                                    </div>
                                </LinkResponsiveNav>
                            </form>
                        </template>
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>
