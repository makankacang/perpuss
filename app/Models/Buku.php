<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'BukuID';
    public $timestamps = false;
    protected $guarded = ['created_at', 'updated_at'];

    protected $fillable = ['Judul', 'Penulis', 'Penerbit', 'TahunTerbit', 'image'];

    public function kategoris()
    {
        return $this->belongsToMany(Kategoribuku::class, 'kategoribuku_relasi', 'BukuID', 'KategoriID');
    }

    public function peminjaman()
    {
        return $this->hasOne(Peminjaman::class, 'BukuID', 'BukuID');
    }

    public function koleksi()
    {
        return $this->hasMany(KoleksiPribadi::class, 'BukuID');
    }

    public function ulasanBuku()
    {
        return $this->hasMany(UlasanBuku::class, 'BukuID');
    }
}

