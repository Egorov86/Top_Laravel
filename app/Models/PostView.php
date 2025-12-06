<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $ip
 * @property integer $user_id
 * @property integer $post_id
 */
class PostView extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'ip'
    ];
}
