<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'relative flex items-center p-3 text-primary-600 bg-primary-50/50 transition group'
        : 'relative flex items-center p-3 text-secondary-600 hover:bg-secondary-50 hover:text-secondary-900 transition group';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <div 
            v-if="active" 
            class="absolute left-0 top-2 bottom-2 w-1.5 bg-primary-400 rounded-r-full"
        ></div>
        <slot />
    </Link>
</template>
