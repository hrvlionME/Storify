<script setup>
import AuthenticatedLayout from '@/Layouts/AnonyLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps,  ref, computed  } from 'vue';

const props = defineProps({
    stories: {
        type: Array,
        required: true
    },
    users: {
        type: Array,
        required: true
    }
});

function findUser(userId) {
    return Object.values(props.users).find(user => user.id === userId);
}


// Define a reactive ref for storing the selected type
const selectedType = ref('');

// Method to filter stories by type
function filterStories(type) {
    selectedType.value = type;
}

// Computed property to filter stories by selected type
const filteredStories = computed(() => {
    if (!selectedType.value) {
        return props.stories;
    }
    return props.stories.filter(story => story.type === selectedType.value);
});

console.log(props.stories[6].thumbnail);
</script>

<template>
    <Head title="Stories" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Homepage</h2>
                <div>
                    <a href="/" @click.prevent="filterStories('')">All</a>
                    |
                    <a href="/" @click.prevent="filterStories('short')">Short</a>
                    |
                    <a href="/" @click.prevent="filterStories('long')">Long</a>
                </div>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Success! </strong>
                    <span class="block sm:inline">{{ $page.props.flash.success }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(story, index) in filteredStories" :key="index">
                                <td class="px-6 py-4 whitespace-nowrap"><img :src="story.image"></td>
                                <td class="px-6 py-4 whitespace-nowrap"><a :href="'/dashboard/stories/'+ story.slug">{{ story.title }}</a></td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ story.type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ findUser(story.user_id).name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
