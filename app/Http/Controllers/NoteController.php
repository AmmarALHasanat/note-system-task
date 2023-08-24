<?php

namespace App\Http\Controllers;

use App\Policies\NotePolicy;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NoteCollection;
use Shamaseen\Repository\Utility\Controller as Controller;
/**
 * Class NoteController.
 *
 * @property NoteRepository $repository
 */
class NoteController extends Controller
{

    public string $routeIndex = 'notes.index';

    public string $pageTitle = 'Note';
    public string $createRoute = 'notes.create';

    public string $viewIndex = 'notes.index';
    public string $viewCreate = 'notes.create';
    public string $viewEdit = 'notes.edit';
    public string $viewShow = 'notes.show';
    
	public ?string $resourceClass = NoteResource::class;

	public ?string $collectionClass = NoteCollection::class;
 
	public ?string $policyClass = NotePolicy::class;
 
	public string $requestClass = NoteRequest::class;


    /**
     * NoteController constructor.
     *
     * @param NoteRepository $repository
     */
    public function __construct(NoteRepository $repository)
    {
        parent::__construct($repository);
    }

    public function indexApi(){
        try{
            $user = Auth::user();
            $notes = $this->repository->getNotesToUser($user);
        }catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 400);
        }
        return NoteCollection::make($notes);
    }
    public function showApi(string $id){
        try {
            $user = Auth::user();
            $note = $this->repository->show($id);
            //$note = $this->repository->findOrFail($id);
            if (!$user->can('view', $note)) {
                throw new \Exception("You don't have permission to view this note", 512);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 400);
        }
        return NoteResource::make($note);
    }
    public function createApi(){
        try{
            $user = Auth::user();
            $this->request['user_id']= $user->id;
            $this->store();
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 400);
        }
        return response()->json([
            'message' => 'Cratered note successfully',
            'success' => true,
        ], 201);
    }

    public function updateApi(string $id)
    {
        try {
            $user = Auth::user();
            $this->request['user_id'] = $user->id;
            $note=$this->repository->show($id);
            if (!$user->can('update', $note)) {
                throw new \Exception("You don't have permission to view this note", 512);
            }
            if (empty($this->request['title']) || empty($this->request['discrption'])) {
                throw new \Exception("Both title and discrption are required.", 400);
            }
            $this->update($id);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 400);
        }
        return response()->json([
            'message' => 'Updated note successfully',
            'success' => true,
        ], 200);
    }
    public function destroyApi($id)
    {
        try {
            $user = Auth::user();
            $this->request['user_id'] = $user->id;
            $note = $this->repository->show($id);
            if (!$user->can('delete', $note)) {
                throw new \Exception("You don't have permission to view this note", 512);
            }
            $this->destroy($id);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false
            ], 400);
        }
        return response()->json([
            'message' => 'Deleted note successfully',
            'success' => true,
        ], 200);
    }

}
