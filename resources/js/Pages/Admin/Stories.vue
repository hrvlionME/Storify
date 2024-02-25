<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import {  defineProps  } from 'vue';

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

function restoreStory(storyId) {

    router.put('/admin/stories/restore/' +storyId )
}

function deleteStory(storyId) {
    const confirmed = confirm("Are you sure you want to delete this story?");
    if (!confirmed) return;

    router.delete('/admin/stories/delete/' +storyId )
}


function findUser(userId) {
    return Object.values(props.users).find(user => user.id === userId);
}





</script>

<template>
    <Head title="Deleted Stories" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Deleted Stories</h2>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(story, index) in props.stories" :key="index">
                                <td class="px-6 py-4 whitespace-nowrap">{{ story.title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ story.type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ findUser(story.user_id).name  }}</td>
                                <td><a :href="'/stories/' + story.id" class="bg-gray-200 rounded px-4 py-2 mx-1 text-indigo-600 hover:text-indigo-900" @click.prevent="restoreStory(story.id)">Restore </a>
                                <a :href="'/stories/' + story.id + '/edit'" class="bg-gray-200 rounded px-4 py-2 mx-1 text-indigo-600 hover:text-indigo-900" @click.prevent="deleteStory(story.id)"> Delete</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
