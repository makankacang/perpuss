<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class koleksipribadi extends Model
{
    use HasFactory;
    protected $table = 'koleksipribadi'; // Specify the table name if it's different from the plural of the class name

    protected $primaryKey = 'KoleksiID'; // Specify the primary key column
    public $timestamps = false;
    protected $guarded = ['created_at', 'updated_at'];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}
