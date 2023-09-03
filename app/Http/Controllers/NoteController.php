<?php

namespace App\Http\Controllers;

use App\Policies\NotePolicy;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\NoteRequest;
use Illuminate\Contracts\View\View;
use App\Http\Resources\NoteResource;
use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NoteCollection;
use Illuminate\Http\RedirectResponse;
use Shamaseen\Repository\Utility\Controller as Controller;
/**
 * Class NoteController.
 *
 * @property NoteRepository $repository
 */
class NoteController extends Controller
{


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
    public function index(): View|JsonResponse
    {
        $user= Auth::user();
        $notes = $this->repository->scope(fn ($builder) => $builder->where('user_id',$user->id) )->paginate();
        return $this->responseDispatcher->index($notes);
    }
    // public function show(int|string $entityId): View|JsonResponse
    // {
    //     $user=Auth::user();
    //     // return parent::show($entityId);
    //     $note = $this->repository->show($entityId);
    //     $this->authorize('view', $note);
    //     return $this->responseDispatcher->show($note);
    // }
    public function store(): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $this->request['user_id'] = $user->id;
        return parent::store();
    }

    public function update(int|string $entityId): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $this->request['user_id'] = $user->id;
        return parent::update($entityId);
    }
}
