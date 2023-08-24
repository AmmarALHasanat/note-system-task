<?php

namespace App\Http\Requests;

use Shamaseen\Repository\Utility\Request as Request;

/**
 * Class NoteRequest.
 */
class NoteRequest extends Request
{
    /**
     * Define all the global rules for this request here.
     *
     * @var array
     */
    protected array $rules = [
        'title' => ['string',],
    ];

    // Write your methods using {Controller Method Name}Rules, or {HTTP Method}MethodRules syntax.
    // For example, when index method in the controller is called a method called indexRules will be triggered here if it is exists.
}
