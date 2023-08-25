<template>
    <div class="container">
        <h2>Dashboard:</h2>
        <div v-if="notes.length">
            <h3>Your Notes: <button @click="creatNote()" class="btn btn-secondary m-2 ">Craete</button> </h3>
            
                <div class="row justify-content-center">
                    <!-- <div class="table-responsive"> -->
                        <table class="table table-dark table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="note in notes" :key="note.id">
                                    <th scope="row">{{ note.id }}</th>
                                    <td class="w-25">{{ note.title }}</td>
                                    <td class="w-50">{{ note.discrption }}</td>
                                    <td class="w-25">
                                        <button @click="showNote(note.id)" class="btn btn-info m-2 ">show</button>
                                        <button @click="editNote(note.id)" class="btn btn-primary m-2">Edit</button>
                                        <button @click="deleteNote(note.id)" class="btn btn-danger m-2 ">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <!-- </div> -->
        </div>
        <div v-else>
            <p>No notes found.</p>
        </div>
    </div>
</template>

<script>
    import {ref} from 'vue'
    import {useRouter} from "vue-router"
    export default {
        setup() {
            let notes = ref([]);
            axios.get('/api/auth/notes/').then(res => {
                notes.value = res.data.data;
            });
            console.log(notes)
            const router = useRouter();
            
            function creatNote(){
            router.push({
                name: 'CreateNote',
            })
            }

            function showNote(noteId) {
            // Navigate to the show note route using router.push()
            router.push({
                name: 'ShowNote',
                params: {
                    id: noteId
                    }
                });
            }

            function editNote(noteId) {
                // Navigate to the edit note route using router.push()
                router.push({
                    name: 'EditNote',
                    params: {
                        id: noteId
                    }
                });
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
                showNote,
                editNote,
                deleteNote,
                creatNote
            }
        }
    }
</script>