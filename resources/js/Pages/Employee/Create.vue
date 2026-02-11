<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import FormSection from '@/Components/FormSection.vue';

const props = defineProps({
    departments: Array, // Passed from the Controller
});

const form = useForm({
    name: '',
    email: '',
    department_id: '',
    designation: '', // Job Title
});

const submit = () => {
    form.post(route('team.add-member.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AppLayout title="Add Employee">
        <div class="bg-gray-50 min-h-screen py-12">
            <div class="max-w-2xl mx-auto">
                <div class="mb-6 text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">Onboard New Employee</h2>
                    <p class="text-gray-600 mt-2">Set up their profile and send an invitation link.</p>
                </div>

                <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
                    <form @submit.prevent="submit" class="p-8 space-y-6">
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <InputLabel for="name" class="text-xs font-bold uppercase tracking-wider text-gray-500" value="Full Name" />
                                <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full border-gray-200 bg-gray-50 focus:bg-white transition" placeholder="John Doe" required />
                            </div>

                            <div>
                                <InputLabel for="email" class="text-xs font-bold uppercase tracking-wider text-gray-500" value="Work Email" />
                                <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full border-gray-200 bg-gray-50 focus:bg-white transition" placeholder="john@company.com" required />
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="department" class="text-xs font-bold uppercase tracking-wider text-gray-500" value="Department" />
                                <select id="department" v-model="form.department_id" class="mt-1 block w-full border-gray-200 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    <option value="">Select Dept</option>
                                    <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
                                </select>
                            </div>

                            <div>
                                <InputLabel for="designation" class="text-xs font-bold uppercase tracking-wider text-gray-500" value="Position" />
                                <TextInput id="designation" v-model="form.designation" type="text" class="mt-1 block w-full border-gray-200 bg-gray-50 focus:bg-white transition" placeholder="Senior Developer" />
                            </div>
                        </div>

                        <div class="pt-4">
                            <PrimaryButton class="w-full justify-center py-3 text-lg rounded-xl shadow-lg shadow-indigo-200 hover:scale-[1.02] active:scale-[0.98] transition-all" :disabled="form.processing">
                                Create Employee Record
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>