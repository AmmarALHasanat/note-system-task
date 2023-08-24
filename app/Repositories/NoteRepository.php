<?php
namespace App\Repositories;

use App\Models\Note;
use App\Http\Resources\NoteResource;
use App\Models\User;
use Shamaseen\Repository\Utility\AbstractRepository as AbstractRepository;
/**
 * Class NoteRepository.
 *
 * @extends AbstractRepository<Note>
 */
class NoteRepository extends AbstractRepository
{
    // if you use ORM 
    public array $with = ['user'];

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return Note::class;
    }

    public function getNotesToUser(User $user){
        try {
            $notes = $user->notes()->get(); // use Lazy Loading
            // $notes = User::with('notes')->find($user->id); // use Eager Loading
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 400);
        }
        return $notes;
    }
    public function show(string $id){
        try {
            $note = Note::findorFail($id);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 400);
        }
        return $note;
    }
}
