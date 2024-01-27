<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head,Link} from '@inertiajs/vue3';
import {Post} from "@/types";
import PrimaryLink from "@/Components/PrimaryLink.vue";

defineProps<{
    posts?: Array<Post>;
}>();
</script>

<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-1">Posts</h2>
                    <PrimaryLink :href="route('post.edit')">Write a new post</PrimaryLink>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <ul role="list" class="divide-y divide-gray-100" v-if="posts">
                    <li v-for="post in posts" :key="post.id" class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="text-md font-semibold leading-6 text-gray-900">{{ post.title }}</p>
                                <p class="mt-1 truncate text-sm leading-5 text-gray-500">
                                    <b>Author:</b> {{ post.user.name }}
                                    <b>Type:</b> {{ post.type }}
                                </p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <Link :href="route('post.edit',{id:post.id})">Edit</Link>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
