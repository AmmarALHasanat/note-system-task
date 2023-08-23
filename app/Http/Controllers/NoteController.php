<?php

namespace App\Http\Controllers;

use App\Policies\NotePolicy;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Repositories\NoteRepository;
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
        
        return $this->repository->all();
    }
    public function showApi(string $id){
        return $this->repository->show($id);
    }
}
