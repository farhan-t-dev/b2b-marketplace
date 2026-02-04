<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use HasFactory;

    protected $table = 'admin_logs';
    protected $fillable = ['actor_id', 'action', 'target_type', 'target_id', 'changes'];
    protected $casts = ['changes' => 'json'];
    public $timestamps = true;

    public function actor()
    {
        return $this->belongsTo(User::class);
    }
}
