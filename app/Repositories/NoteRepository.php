<?php
namespace App\Repositories;

use App\Models\Note;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NoteCollection;
use Shamaseen\Repository\Utility\AbstractRepository as AbstractRepository;
/**
 * Class NoteRepository.
 *
 * @extends AbstractRepository<Note>
 */
class NoteRepository extends AbstractRepository
{
    public array $with = [];

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return Note::class;
    }

    public function all(){
        try {
            $user = Auth::user();
            $notes = $user->notes()->get();
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 400);
        }
        return NoteCollection::make($notes);
    }
    public function show(string $id){
        try{
            $user= Auth::user();
            // $note= Note::whereId($id);
            $note = Note::findorFail($id);
            if(!$user->can('view', $note)){
                throw new \Exception("You don't have permission to view this note",512 );
            }
            
        }
        catch(\Exception $exception ){
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 400);
        }
        return NoteResource::make($note);
    }
}
