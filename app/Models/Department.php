<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'name',
        'code',
        'manager_id',
    ];

    /**
     * The "booted" method of the model.
     * * This automatically filters all queries by the user's current team.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('team', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('team_id', auth()->user()->current_team_id);
            }
        });
    }

    /**
     * Get the Company (Team) that owns this department.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the User who manages this department.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

  /**
 * Get all employees in this department.
 */
    public function employees(): HasMany
    {
        // This looks for users who have a record in employee_details 
        // where the department_id matches this department.
        return $this->hasMany(EmployeeDetail::class, 'department_id');
    }
}
