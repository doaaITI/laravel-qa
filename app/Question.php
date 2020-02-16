<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  protected $fillable=['title','body'];
    public function user(){
        return $this->belongsTo(User::Class);
    }


    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function getStatusAttribute()
    {
        if ($this->answers_count  > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function answers()
    {
         
        return $this->hasMany('App\Answer');
       
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }
}
