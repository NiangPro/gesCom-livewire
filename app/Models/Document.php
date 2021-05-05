<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = "documents";

    protected $fillable=[
        'titre',
        'fichier',
        'employed_id'
    ];

    public function employed()
    {
        return $this->belongsTo(Employed::class,"employed_id");
    }
}
