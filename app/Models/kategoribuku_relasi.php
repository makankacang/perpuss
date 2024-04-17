<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoribuku_relasi extends Model
{
    use HasFactory;

    protected $table = 'kategoribuku_relasi'; // Specify the table name if it's different from the plural of the class name

    protected $primaryKey = 'KategoribukuID'; // Specify the primary key column
    public $timestamps = false;
    protected $guarded = ['created_at', 'updated_at'];

    protected $fillable = ['BukuID', 'KategoriID']; // Specify the columns that are mass assignable

    public function bukus()
    {
        return $this->belongsTo(Buku::class, 'BukuID');
    }
}
