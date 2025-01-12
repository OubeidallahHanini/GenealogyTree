<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropositionResponse extends Model
{
    use HasFactory;
    protected $fillable = ['proposition_id', 'user_id', 'response'];

}
