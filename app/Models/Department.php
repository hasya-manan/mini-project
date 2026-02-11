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
     * Get the Employees (Users) assigned to this department.
     * (Note: Ensure you have 'department_id' in your users table)
     */
    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'department_id');
    }
}