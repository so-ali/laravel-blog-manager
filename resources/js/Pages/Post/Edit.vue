<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, Link} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Post, User} from "@/types";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Textarea from "@/Components/Textarea.vue";
import PrimaryLink from "@/Components/PrimaryLink.vue";
import {watch} from "vue";

const props = defineProps<{
    site_url: string;
    id?: number;
    post?: Post
}>();


const form = useForm({
    id: null,
    slug: '',
    type: '',
    title: '',
    content: '',
    excerpt: '',
    category: '',
});

if (typeof props.post !== 'undefined') {
    form.id = props.post.id;
    form.slug = props.post.slug.replaceAll(' ', '-').toLowerCase();
    form.type = props.post.type;
    form.title = props.post.title;
    form.content = props.post.content;
    form.excerpt = props.post.excerpt;
}

const slugBuilder = (title: string) => {
    return title.toLowerCase()
        .replace(/ /g, "-")
        .replace(/[^\w-]+/g, "");
}


watch(form,(val,val2)=>{
    form.slug = slugBuilder(val.title);
});
</script>

<template>
    <Head title="Edit Post"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-1" v-if="post">Edit
                    "{{ post.title }}"</h2>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex-1" v-else>Write a new post</h2>
                <Link :href="route('post.index')" class="me-5">Back</Link>
                <PrimaryLink :href="route('post.index')">Preview</PrimaryLink>
            </div>
        </template>

        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-4 gap-6">
                <div class="col-span-3">
                    <form @submit.prevent="form.patch(route('post.update'))" class="mt-3 space-y-6">
                        <div>
                            <InputLabel for="title" value="Title"/>

                            <TextInput
                                id="title"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.title"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.title"/>
                        </div>
                        <div class="flex">
                            <b>URL:</b>
                            {{ site_url }}/ <input v-model="form.slug" type="text" class="flex-1"
                                                   style="border: none; padding: 0; background: transparent">

                            <a href="#">Open Preview</a>
                        </div>
                        <div><br></div>
                        <div>
                            <InputLabel for="content" value="Content"/>

                            <Textarea
                                id="content"
                                class="mt-1 block w-full"
                                v-model="form.content"
                                required
                                placeholder="Write some things..."
                                rows="8"
                            />

                            <InputError class="mt-2" :message="form.errors.content"/>
                        </div>
                        <div>
                            <InputLabel for="excerpt" value="Excerpt"/>
                            <Textarea
                                id="excerpt"
                                class="mt-1 block w-full"
                                v-model="form.excerpt"
                                placeholder="Write some things..."
                                rows="5"
                            />

                            <InputError class="mt-2" :message="form.errors.excerpt"/>
                        </div>


                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">
                                <template v-if="post">Update</template>
                                <template v-else>Create</template>
                            </PrimaryButton>

                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                            </Transition>
                        </div>
                    </form>
                </div>
                <div>
                    <div>
                        <InputLabel for="category" value="Categories"/>

                        <TextInput
                            id="category"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.category"
                        />

                        <InputError class="mt-2" :message="form.errors.category"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
