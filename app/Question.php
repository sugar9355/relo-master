<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['item_id', 'title'];
    
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}
