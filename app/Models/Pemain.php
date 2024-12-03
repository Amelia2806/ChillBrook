<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemain extends Model
{
    use HasFactory;

    protected $table = 'pemain'; // Pastikan ini sesuai dengan nama tabel di database
    
    protected $fillable = [
        'nama_pemain',
        'no_punggung',
        'posisi',
    ];
}