<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";

// Accept a team invitation via router request

// defineProps({
//     invitations: Array,
// });

// const accept = (id) => {
//     router.post(`/invitations/${id}/accept`);
// };
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />

                    <!-- <div v-if="invitations && invitations.length">
                        <h3 class="font-semibold mt-4">Pending Invitations</h3>

                        <div
                            v-for="invitation in invitations"
                            :key="invitation.id"
                            class="mt-2"
                        >
                            <span>
                                {{ invitation.email }} —
                                {{ invitation.role }}
                            </span>

                            <button
                                class="ml-3 text-green-600"
                                @click="accept(invitation.id)"
                            >
                                Accept
                            </button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </AppLayout>
</template>
