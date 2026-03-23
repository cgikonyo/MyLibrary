<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    // relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // statuses
    public const STATUS_PENDING = 'pending';
    public const STATUS_STARTED = 'started';
    public const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'title',
        'author',
        'cover_i',
        'user_id',
        'status',
    ];
}
