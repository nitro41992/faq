<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnsweredQuestions extends Model
{
    protected $primaryKey = 'editor_id';

    public function user() {

        return $this->hasMany('App\User');

    }

    public function answer() {

        return $this->hasMany('App\Answer');

    }
}
