<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //ATTENZIONE: importare questo per attivare softDelete

class Project extends Model
{
    use HasFactory;
    use SoftDeletes; //ATTENZIONE: importare questo per attivare softDelete

    public $table = 'projects';

    protected $fillable = [
        'title',
        'description',
        'website_link',
        'source_code_link',
        'proj_category',
        'client',
        'client_category',
        'type_id',
        'tech'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
}
