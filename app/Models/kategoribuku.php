<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoribuku extends Model
{
    use HasFactory;

    protected $table = 'kategoribuku'; // Specify the table name if it's different from the plural of the class name

    protected $primaryKey = 'KategoriID'; // Specify the primary key column
    public $timestamps = false;
    protected $guarded = ['created_at', 'updated_at'];

    protected $fillable = ['NamaKategori']; // Specify the columns that are mass assignable

    public function bukus()
{
    return $this->belongsToMany(Buku::class, 'kategoribuku_relasi', 'KategoriID', 'BukuID');
}

}
