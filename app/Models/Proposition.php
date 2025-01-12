<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposition extends Model
{
    use HasFactory;
    protected $fillable = ['person_id', 'proposed_by', 'description', 'data', 'approvals', 'rejections', 'is_approved'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function proposer()
    {
        return $this->belongsTo(User::class, 'proposed_by');
    }
}
