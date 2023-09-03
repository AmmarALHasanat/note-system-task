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
    ];

    // Write your methods using {Controller Method Name}Rules, or {HTTP Method}MethodRules syntax.
    // For example, when index method in the controller is called a method called indexRules will be triggered here if it is exists.
    protected function storeRules(){
        return [
            'title' => ['required', 'string', 'min:3'],
            'discrption' => ['required', 'string', 'min:3']
        ];
    }

    protected function updateRules(){
        return [
            'title' => ['required', 'string', 'min:3'],
            'discrption' => ['required', 'string', 'min:3']
        ];
    }
}



