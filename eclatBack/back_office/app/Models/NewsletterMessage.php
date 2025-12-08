<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class NewsletterMessage extends Model
{
    protected $fillable = [
        'subject',
        'body',
        'sent_by_admin_id',
        'sent_at',
        'recipient_count'
    ];
    
    protected $casts = [
        'sent_at' => 'datetime',
    ];
    
    public function sentByAdmin()
    {
        return $this->belongsTo(Admin::class, 'sent_by_admin_id');
    }
}