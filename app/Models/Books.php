<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected static function boot()
    {
        parent::boot();

        // auto-assign book_number when adding a new book in the list
        static::creating(function ($model) {
            if (!$model->book_number && $model->user_id) {
                $maxBookNumber = Books::where('user_id', $model->user_id)->max('book_number');
                $model->book_number = ($maxBookNumber ?? 0) + 1;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public $table = 'books';

    // task statuses used throughout the app
    public const STATUS_PENDING = 'pending';
    public const STATUS_STARTED = 'started';
    public const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'description',
        'user_id',
        'status',
        'book_number',
    ];
}

