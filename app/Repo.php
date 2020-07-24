<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repo extends Model
{
    protected $timestamp = false;

    protected $fillable = [
        'id',
        'name',
        'url',
        'user_id',
    ];
}