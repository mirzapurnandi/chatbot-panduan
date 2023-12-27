<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanduanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'panduan_id',
        'name',
        'description',
        'image',
        'urutan'
    ];

    public function panduan(){
        return $this->belongsTo(Panduan::class);
    }
}
