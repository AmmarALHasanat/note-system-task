<template>
    <div class="container bg-dark text-white p-4 m-5">
        <h2>Create Note</h2>
        <p class="text-danger" v-for="error in this.errors" :key="error">
            <span v-for="err in error" :key="err">{{ err }}</span>
        </p>
        <form @submit.prevent="createNote" class="mt-3">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input v-model="form.title" id="title" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea v-model="form.discrption" id="description" class="form-control" rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-light">Save</button>
        </form>
    </div>
</template>

<script>
import { reactive, ref } from 'vue';
import { useRouter } from "vue-router";

export default {
    setup() {
        let form = reactive({
            title: '',
            discrption: '',
        });
        
        let errors = ref([]);

        const router = useRouter();
        
        async function createNote() {
            try {
                const response = await axios.post('/api/auth/notes/create', form);
                if (response.status === 201) {
                    // Successfully created note, redirect to dashboard or wherever needed
                    router.push({ name: 'Dashboard' });
                }
            } catch (error) {
                // Handle validation errors or other API errors
                if (error.response && error.response.data && error.response.data.errors) {
                    errors.value = Object.values(error.response.data.errors);
                } else {
                    errors.value = ['An error occurred while creating the note.'];
                }
            }
        }
         return {
            form,
            errors,
            createNote
        };

    }
}
</script>
