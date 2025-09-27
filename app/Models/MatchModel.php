<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    use HasFactory;

    protected $table = 'matches'; // explicitly set

    protected $fillable = [
        'name',
        'location',
        'type',
        'start_time',
        'date',
        'status',
        'shuttles_used',
        'created_by',
    ];

    public function teams()
    {
        return $this->hasMany(Team::class, 'match_id');
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'match_id');
    }

    public function events()
    {
        return $this->hasMany(MatchEvent::class, 'match_id');
    }
}
