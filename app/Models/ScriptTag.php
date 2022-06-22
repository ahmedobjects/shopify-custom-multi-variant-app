<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScriptTag extends Model
{
    use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'script_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'script_tag_id',
        'src',
        'event',
        'cache',
        'display_scope',
    ];
}
