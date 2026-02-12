<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

       // The "Company Owner" / HR Head
        Jetstream::role('hr-admin', 'HR Administrator', [
            'user:create',     // Added: Permission to add employees
            'user:manage',     // Added: Permission to edit/delete
            'leave:approve',
            'claim:approve',
            'leave:manage',
            'report:view',
        ])->description('Full access to company HR tools and employee management.');

    
         Jetstream::role('manager', 'Manager', [
            'leave:approve',
            'claim:approve',
            'leave:manage',
        ])->description('Managers can approve leave and claims for their team members.');

         Jetstream::role('team-lead', 'Team Lead', [
            'leave:approve',
            'claim:approve',
            'leave:manage',
        ])->description('Team leads can approve leave and claims for their team members.');

        Jetstream::role('employee', 'Employee', [
            'leave:apply',
            'claim:submit',
        ])->description('Employees can apply for leave and submit claims.');
    }
}
