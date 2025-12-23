<template>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-2xl font-bold mb-4">Add Team Member</h2>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Name</label>
                <input
                    type="text"
                    v-model="form.name"
                    class="w-full border rounded p-2"
                />
                <span v-if="form.errors.name" class="text-red-500">
                    {{ form.errors.name }}
                </span>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Email</label>
                <input
                    type="email"
                    v-model="form.email"
                    class="w-full border rounded p-2"
                />
                <span v-if="form.errors.email" class="text-red-500">
                    {{ form.errors.email }}
                </span>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Role</label>
                <select v-model="form.role" class="w-full border rounded p-2">
                    <option value="manager">Manager</option>
                    <option value="employee">Employee</option>
                </select>
                <span v-if="form.errors.role" class="text-red-500">
                    {{ form.errors.role }}
                </span>
            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded"
                :disabled="form.processing"
            >
                Add Member
            </button>
        </form>
    </div>
</template>

<script setup>
import { useForm, router } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    role: "employee",
});

function submit() {
    form.post("/team/add-member", {
        preserveScroll: true,
        onSuccess: () => {
            form.reset(); // clears values
            alert("Team member added successfully");
        },
    });
}
</script>
