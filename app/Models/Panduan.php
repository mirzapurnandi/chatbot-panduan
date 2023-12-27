<?php

namespace App\Models;

use Faker\Provider\ar_JO\Text;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_seo',
        'gambar'

    ];

    public function panduan_detail(){
        return $this->hasMany(PanduanDetail::class);
    }

}
