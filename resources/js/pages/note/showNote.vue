<template>
    <div class="container">
        <div class="card bg-dark text-white row mt-4">
            <div class="card-header">
                <h2 class="card-title">{{ note.title }}</h2>
            </div>
            <div class="card-body">
                <h3 class="card-subtitle mb-2">Description</h3>
                <p class="card-text">{{ note.discrption }}</p>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from "axios";
    export default {
        data() {
            return {
                note: {},
            };
        },
        async created() {
            const noteId = this.$route.params.id;
            try {
                const response = await axios.get(`/api/auth/notes/${noteId}`);
                this.note = response.data.data;
                console.log(this.note);
            } catch (error) {
                console.error(error);
            }
        },
    };
</script>
