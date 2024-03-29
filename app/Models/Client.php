<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = ['name_client', 'phone_client', 'email_client', 'company_client' ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
