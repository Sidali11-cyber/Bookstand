<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'genre',
        'publication_date',
        'image',
        'author_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    // Many-to-many relationship with readers
    public function readers()
    {
        return $this->belongsToMany(Reader::class, 'downloaded_books');
    }
}
