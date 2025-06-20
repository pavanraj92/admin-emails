<?php

namespace admin\emails\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'subject',
        'description',
        'status'
    ];

    public function scopeFilter($query, $title)
    {
        if ($title) {
            return $query->where('title', 'like', '%' . $title . '%');
        }
        return $query;
    }
    /**
     * filter by status
     */
    public function scopeFilterByStatus($query, $status)
    {
        if (!is_null($status)) {
            return $query->where('status', $status);
        }

        return $query;
    }
}
