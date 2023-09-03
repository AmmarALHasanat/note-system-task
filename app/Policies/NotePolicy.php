<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Note $note)
    {
        // Determine if the user is allowed to view the note
        return $user->id === $note->user_id;
    }

    public function show(User $user)
    {
        $currentUrl = explode('/', request()->url());
        $note_id = end($currentUrl);
        $note=Note::findOrFail($note_id);
        return $user->id === $note->user_id;
    }

    public function update(User $user)
    {
        $currentUrl = explode('/', request()->url());
        $note_id = (array_slice($currentUrl, -2)[0]);
        $note = Note::findOrFail($note_id);
        return $user->id === $note->user_id;
    }

    public function destroy(User $user)
    {
        $currentUrl = explode('/', request()->url());
        $note_id = (array_slice($currentUrl, -2)[0]);
        $note = Note::findOrFail($note_id);
        return $user->id === $note->user_id;
    }

}
