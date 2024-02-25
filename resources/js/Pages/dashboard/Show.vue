<script setup>
import AnonyLayout from '@/Layouts/AnonyLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, defineProps } from 'vue';

const props = defineProps({
    story: {
        type: Object,
        required: true
    },
    user: {
        type: Object,
        required: true
    }
});

console.log(props.story.title);
console.log(props.user.name);

</script>

<template>
    <Head title="Stories" />

    <AnonyLayout>
        <template #header>
            <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ props.story.title  }} by {{ props.user.name }}</h2>
            <a href="/" class="bg-gray-700 px-4 py-2 rounded text-gray-200">Back</a>
        </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                   {{ props.story.body }}
                   <p class="italic"> {{ props.story.footnote }}</p>
                </div>
            </div>
        </div>
    </AnonyLayout>
</template>
