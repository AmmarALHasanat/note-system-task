<template>
    <div class="container bg-dark text-white p-4 m-5">
        <h2>Edit Note</h2>
        <p class="text-danger"  v-for="error in this.errors" :key="error">
            <span v-for="err in error" :key="err">{{ err }}</span>
        </p>
        <form @submit.prevent="updateNote" class="mt-3">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input v-model="note.title" id="title" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea v-model="note.discrption" id="description" class="form-control" rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-light">Save</button>
        </form>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    
    data() {
        return {
            note: {
                title: '',
                discrption: ''
            },
            errors:''
        };
    },
    
    async created() {
        const noteId = this.$route.params.id;
        try {
            const response = await axios.get(`/api/auth/notes/${noteId}`);
            this.note = {
                'title':response.data.data.title,
                'discrption':response.data.data.discrption
            };
        } catch (error) {
            console.error(error);
        }
    },
    methods: {
        async updateNote() {
            const noteId = this.$route.params.id;
            await axios.put(`/api/auth/notes/${noteId}/edit`, this.note).then(res => {
                // console.log(res.data.status)
                if (res.data.success) {
                    this.notes = res.data.data;
                    location.reload();
                 }
            }).catch(e => {
                this.errors = e.response.data.errors
            })
        }
    }
};
</script>
