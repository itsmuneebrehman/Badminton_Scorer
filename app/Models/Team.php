<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'name',
        'side'
    ];

    public function match()
    {
        return $this->belongsTo(MatchModel::class, 'match_id');
    }

    public function players()
    {
        return $this->hasMany(Player::class, 'team_id');
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'team_id');
    }
}
