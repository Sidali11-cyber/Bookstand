<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    use HasFactory;

    protected $fillable = [
        'reader_name',
        'reader_email',
        'image',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Many-to-many relationship with books
    public function books()
    {
        return $this->belongsToMany(Book::class, 'downloaded_books');
    }
}
