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
    supervisors: Array,
    roles: Array,
});

const form = useForm({
    name: '',
    email: '',
    department_id: '',
     supervisor_id: '',
     role: '',
    position: '', // Job Title
    joined_date: new Date().toISOString().split('T')[0],
});



const submit = () => {
    form.post(route('team.add-member.store'), {
        onSuccess: () => {
            // Optional: Show a success alert
            alert('Success! The invitation has been sent.');
        },
        onError: (errors) => {
            console.log('Form failed!', errors);
            alert('Wait! Please check the form for errors.');
           
        },
        onFinish: () => form.reset('password'),
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
                        <!--users-->
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <InputLabel for="name"  value="Full Name" />
                                <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full border-gray-200 bg-gray-50 focus:bg-white transition" placeholder="John Doe" required />
                            </div>

                            <div>
                                <InputLabel for="email"  value="Work Email" />
                                <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full border-gray-200 bg-gray-50 focus:bg-white transition" placeholder="john@company.com" required />
                                  <InputError :message="form.errors.email" class="mt-2" />
                            </div>
                            
                        </div>

                        <hr class="border-gray-100">

                        <div class="grid grid-cols-2 gap-6">
                            <!--employee details -->
                            <div>
                                <InputLabel for="department"  value="Department" />
                                <select id="department" v-model="form.department_id"
                                    class="mt-1 block w-full border-gray-200 rounded-lg bg-gray-50 focus:border-primary-300 focus:ring-primary-300 shadow-sm">
                                    <option value="">Select Dept</option>
                                    <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <InputLabel for="supervisor"  value="Supervisor" />
                                <select id="supervisor" v-model="form.supervisor_id"
                                    class="mt-1 block w-full border-gray-200 rounded-lg bg-gray-50 focus:border-primary-300 focus:ring-primary-300 shadow-sm">
                                    <option value="">Select Supervisor/Team Lead</option>
                                    <option v-for="supers in supervisors" :key="supers.id" :value="supers.id">{{
                                        supers.name }}</option>
                                </select>
                            </div>

                            <div>
                                <InputLabel for="role" value="Role" />
                                <select id="role" v-model="form.role"
                                    class="mt-1 block w-full border-gray-200 rounded-lg bg-gray-50 focus:border-primary-300 focus:ring-primary-300 shadow-sm">
                                    <option value="">Select Role</option>
                                    <option v-for="role in roles" :key="role.key" :value="role.key">
                                        {{ role.name }} - {{ role.description }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <InputLabel for="position"  value="Position" />
                                <TextInput id="position" v-model="form.position" type="text" class="mt-1 block w-full border-gray-200 bg-gray-50 focus:bg-white transition" placeholder="Senior Developer" />
                            </div>
                            <div>
                                <InputLabel for="joined_date" value="Joining Date" />
                                <TextInput id="joined_date" v-model="form.joined_date" type="date"
                                    class="mt-1 block w-full" required />
                                <InputError :message="form.errors.joined_date" class="mt-2" />
                            </div>
                            
                        </div>

                        <div class="pt-4">
                            <PrimaryButton
                                class="w-full justify-center py-3 text-lg rounded-xl shadow-lg shadow-indigo-200 hover:scale-[1.02] active:scale-[0.98] transition-all"
                                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                                :disabled="form.processing">
                                <template v-if="form.processing">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Checking...
                                </template>

                                <template v-else>
                                    Create Employee Record
                                </template>
                            </PrimaryButton>
   
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>