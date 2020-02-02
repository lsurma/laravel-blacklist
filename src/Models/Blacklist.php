<?php

namespace LSurma\LaravelBlacklist\Models;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $fillable = ['type', 'value'];
}