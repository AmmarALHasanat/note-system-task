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
        return $user->id === $note->user_id;
    }

    public function show(User $user)
    {
        $note=Note::findOrFail(request()->id);
        return $user->id === $note->user_id;
    }

    public function update(User $user)
    {
        $note=Note::findOrFail(request()->id);
        return $user->id === $note->user_id;
    }

    public function destroy(User $user)
    {
        $note=Note::findOrFail(request()->id);
        return $user->id === $note->user_id;;
    }

}
