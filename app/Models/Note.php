<?php

namespace App\Models;

use Shamaseen\Repository\Utility\Model as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class Note.
 */
class Note extends Model
{
    /*
    * Fill in your fillables here
    */
    use HasFactory;

    protected $fillable = ['title', 'discrption', 'user_id'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
