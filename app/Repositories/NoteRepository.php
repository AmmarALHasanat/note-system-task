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
