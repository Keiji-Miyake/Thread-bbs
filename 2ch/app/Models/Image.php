<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    protected $fillable = [
        'message_id', 's3_file_path'
    ];
}
