<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { defineProps, reactive } from 'vue';


const props = defineProps({
    story: {
        type: Object,
        required: true
    }
});
const form = reactive({
  title: props.story.title,
  body: props.story.body,
  type: props.story.type,
  status: props.story.status,
})
const errors = reactive({});

function handleImageChange(event) {
    form.image = event.target.files[0];
}

function submit() {

    errors.title = !form.title ? 'Title is required' : null;
    errors.body = !form.body ? 'Body is required' : null;
    errors.type = !form.type ? 'Type is required' : null;
    errors.status = !form.status ? 'Status is required' : null;

    if (!Object.values(errors).some(error => error)) {
        const formData = new FormData();
        formData.append('title', form.title);
        formData.append('body', form.body);
        formData.append('type', form.type);
        formData.append('status', form.status);
        if (form.image !== null) {
            formData.append('image', form.image);
        }
        router.put('/stories/' + props.story.id, formData);
    }
}



</script>

<template>
    <Head title="Stories" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Story</h2>
                <a href="/stories" class="bg-gray-700 px-4 py-2 rounded text-gray-200">Back</a>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="max-w-md mx-auto">
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input v-model="form.title" type="text" id="title" class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <span v-if="errors.title" class="text-red-500">{{ errors.title }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                            <textarea v-model="form.body" id="body" rows="4" class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            <span v-if="errors.body" class="text-red-500">{{ errors.title }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select v-model="form.type" id="type" class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">--Select--</option>
                                <option value="short">Short</option>
                                <option value="long">Long</option>
                            </select>
                            <span v-if="errors.type" class="text-red-500">{{ errors.type }}</span>
                        </div>
                        <div class="mb-4">
                            <legend class="block text-sm font-medium text-gray-700">Status</legend>
                            <div class="mt-2">
                                <input v-model="form.status" type="radio" name="status" id="active" value="1" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="active" class="ml-2 text-sm text-gray-900">Yes</label>
                            </div>
                            <div class="mt-2">
                                <input v-model="form.status" type="radio" name="status" id="inactive" value="0" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                <label for="inactive" class="ml-2 text-sm text-gray-900">No</label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                            <input @change="handleImageChange" type="file" id="image" class="mt-1 p-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <span v-if="errors.image" class="text-red-500">{{ errors.image }}</span>
                
                        </div>
                        <span v-if="errors.status" class="block text-red-500">{{ errors.status }}</span>
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>