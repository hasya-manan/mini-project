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
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Company Employees
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>Employee Information</template>
                <template #description>
                    Enter the details for the new hire. They will receive an email to activate their account and set a password.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Full Name" />
                        <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="email" value="Official Email" />
                        <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required />
                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="department" value="Department" />
                        <select id="department" v-model="form.department_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                            <option value="">Select Department</option>
                            <option v-for="dept in departments" :key="dept.id" :value="dept.id">
                                {{ dept.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.department_id" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="designation" value="Job Title (Designation)" />
                        <TextInput id="designation" v-model="form.designation" type="text" class="mt-1 block w-full" />
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Send Invitation
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>