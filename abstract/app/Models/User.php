<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $files
 * @property string $zipFiles
 */
class User extends Model
{
    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'password',
        'email',
        'fails',
        'zipFiles',
    ];
}
