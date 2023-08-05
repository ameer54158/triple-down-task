<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description'
    ];
    public $timestamps = true;

    //Get users for the notifications
    public function users(){
        return $this->belongsToMany(User::class, 'user_notifications','notification_id','user_id');
    }
}
