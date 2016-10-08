<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function posts()
    {
        return $this->belongsToMany('App\Post', 'post_tag');  // Лара по дефаулту задает  название таблице
        //алфавитном порядке . второй параметр для наглядности примера

    }
}
