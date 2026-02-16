<?php

namespace App\Models;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeDetail extends Model
{
    use HasFactory;

    // If your table name is exactly 'employee_details', Laravel finds it automatically.
   
    protected $table = 'employee_details';

    protected $fillable = [
        'user_id',
        'department_id',
        'supervisor_id',
        'position',
        'address',
        'nok_name',
        'nok_phone',
        'joined_date',
    ];

    /**
     * Link back to the User (Account/Login info)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Link to the Department
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Link to the Supervisor (who is also a User)
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}