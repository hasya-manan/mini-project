<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';

defineProps({
    title: String,
});

const logout = () => {
    router.post(route('logout'));
};

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};
</script>

<template>
    <div>
        <Head :title="title" />

        <div class="flex min-h-screen bg-slate-50">
           <aside class="w-64 bg-white border-r border-slate-200 fixed h-full z-20 flex flex-col">
                <div class="h-16 flex items-center px-6 border-b border-slate-100 shrink-0">
                    <Link :href="route('dashboard')" class="flex items-center gap-2">
                        <ApplicationMark class="block h-8 w-auto fill-primary-500 text-primary-500"></ApplicationMark>
                            <span class="text-xl font-bold text-slate-800 tracking-tight">K<span class="text-primary-500">.</span></span>
                    </Link>
                </div>

                <nav class="flex-1 overflow-y-auto p-4 space-y-6">
                     <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-4 mb-2">Main Menu</div>
            
                            <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="bottom" width="60">
                                <template #trigger>
                                    <button class="flex items-center w-full p-2 mb-4 text-xs font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:border-primary-300 transition shadow-sm">
                                        <span class="truncate flex-1 text-left">{{ $page.props.auth.user.current_team.name }}</span>
                                            <svg class="ms-2 size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                            </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <div class="block px-4 py-2 text-xs text-gray-400">Manage Company</div>
                                        <DropdownLink v-if="$page.props.auth.user.user_level >= 0" :href="route('teams.show', $page.props.auth.user.current_team)">Company Settings</DropdownLink>
                                        <DropdownLink v-if="$page.props.auth.user.user_level >= 2 && $page.props.jetstream.canCreateTeams" :href="route('teams.create')">Create New Company</DropdownLink>
                                        <template v-if="$page.props.auth.user.user_level >= 2 && $page.props.auth.user.all_teams.length > 1">
                                            <div class="border-t border-gray-200"></div>
                                            <div class="block px-4 py-2 text-xs text-gray-400">Switch Teams</div>
                                                <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <DropdownLink as="button">
                                                            <div class="flex items-center">
                                                                <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 size-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                                    {{ team.name }}
                                                                </div>
                                                        </DropdownLink>
                                                    </form>
                                                </template>
                                                </template>
                                </template>
                            </Dropdown>

                            <div class="space-y-1">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</NavLink>
                                <NavLink :href="route('team.add-member.create')" :active="route().current('team.add-member.create')">Add Employee</NavLink>
                                    </div>
                                    </div>
                </nav>

                    <div class="p-4 border-t border-slate-100 bg-slate-50/80">
                        <div class="space-y-1">
                            <div class="px-4 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Account</div>
            
            <Link :href="route('profile.show')" 
                  class="flex items-center gap-3 w-full p-2 rounded-xl hover:bg-white transition group border border-transparent hover:border-slate-200">
                <img class="size-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                <div class="truncate flex-1">
                    <p class="text-xs font-bold text-slate-700 truncate">{{ $page.props.auth.user.name }}</p>
                    <p class="text-[10px] text-primary-600 font-medium">Settings</p>
                </div>
            </Link>

            <form @submit.prevent="logout" class="mt-2">
                <button type="submit" class="flex items-center gap-3 w-full p-2 text-xs font-medium text-rose-600 hover:bg-rose-50 rounded-lg transition group">
                    <svg class="size-4 text-rose-400 group-hover:text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Log Out
                </button>
            </form>
        </div>
    </div>
</aside>

            <div class="flex-1 ml-64">
                <header v-if="$slots.header" class="h-16 bg-white border-b border-slate-200 flex items-center px-8 sticky top-0 z-10">
                    <div class="flex-1">
                        <slot name="header"></slot>
                    </div>
                </header>

                <main class="p-8 max-w-7xl mx-auto">
                    <slot></slot>
                </main>
            </div>
        </div>
    </div>
</template>