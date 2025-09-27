<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'event_type',
        'description',
    ];

    public function match()
    {
        return $this->belongsTo(MatchModel::class, 'match_id');
    }
}
