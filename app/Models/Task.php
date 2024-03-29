<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'date_end', 'client_id', 'responsable', 'admin', 'task_status'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function adminUser()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
