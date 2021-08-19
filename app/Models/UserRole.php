<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRole extends Model
{
    use HasFactory;
    protected $table = 'user_roles';
    protected $fillable = [
        'role_id', 'user_id',
    ];

    public function getRolesUser($user_id){
        $role = DB::table('user_roles')->select('role_id')->where('user_id', $user_id)->get();
        return $role;
    }
}
