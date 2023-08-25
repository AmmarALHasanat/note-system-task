<template>
    <div class="container">
        <h2>Dashboard:</h2>
        <div v-if="notes.length">
            <h3>Your Notes:</h3>
            <ul>
                <li v-for="note in notes" :key="note.id">
                    <h4>{{ note.title }}</h4>
                    <p>{{ note.description }}</p>
                    <button @click="editNote(note.id)">Edit</button>
                    <button @click="deleteNote(note.id)">Delete</button>
                </li>
            </ul>
        </div>
        <div v-else>
            <p>No notes found.</p>
        </div>
    </div>
</template>

<script>
import {ref } from 'vue'
import { useRouter } from "vue-router"
export default {
    setup() {
        let notes = ref([]);
        axios.get('/api/auth/notes/').then(res => {
            notes.value = res.data.data;
        });
        console.log(notes)
        const router = useRouter();

        function editNote(noteId) {
            // Navigate to the edit note route using router.push()
            router.push({ name: 'EditNote', params: { id: noteId } });
        }

        function deleteNote(noteId) {
            // Send a DELETE request to your API to delete the note
            axios.delete(`/api/auth/notes/${noteId}/delete`)
                .then(response => {
                    // Refresh the list of notes after successful deletion
                    axios.get('/api/auth/notes/')
                        .then(res => {
                            notes = res.data.data;
                            location.reload();
                        });
                })
                .catch(error => {
                    console.error('Error deleting note:', error);
                });
        }

        return {
            notes,
            editNote,
            deleteNote
        }
    }
}
</script>