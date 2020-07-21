<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function getPlayersRangeAttribute()
    {
        if ($this->players_min) {
            if ($this->players_max && $this->players_min !== $this->players_max) {
                return $this->players_min . '-' . $this->players_max;
            }
            return $this->players_min;
        }
        return '';
    }

    public function getPlaytimeRangeAttribute()
    {
        if ($this->playtime_min) {
            if ($this->playtime_max && $this->playtime_min !== $this->playtime_max) {
                return $this->playtime_min . '-' . $this->playtime_max;
            }
            return $this->playtime_min;
        }
        return '';
    }
}
