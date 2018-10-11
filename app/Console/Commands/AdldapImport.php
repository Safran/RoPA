<?php

namespace App\Console\Commands;

use Adldap\Laravel\Commands\Console\Import;
use App\Models\User;
use App\Notifications\WarnAdminAboutPendingLdapUsers;
use Illuminate\Support\Facades\Schema;

class AdldapImport extends Import
{

    protected $ldapusers;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Schema::hasColumn('users', 'type'))
        {
            $this->ldapusers = User::where('type', 'ldap')->get();
        }
        else
        {
            $this->ldapusers = collect();
        }

        $this->ldapusers->each(function ($user) {
            $user->type = 'ldap_pending';
            $user->save();
        });

        parent::__construct();
    }


    /**
     * @throws \Adldap\Models\ModelNotFoundException
     */
    public function handle()
    {
        $this->info("Currently " . $this->ldapusers->count() . " ldap users set to [pending]");

        $users = $this->getUsers();
        $count = count($users);
        if ($count === 1)
        {
            $this->info("Found user '{$users[0]->getCommonName()}'.");
        }
        else
        {
            $this->info("Found {$count} user(s).");
        }
        if ($this->confirm('Would you like to display the user(s) to be imported / synchronized?', $default = false))
        {
            $this->display($users);
        }
        if ($this->confirm('Would you like these users to be imported / synchronized?', $default = true))
        {
            $imported = $this->import($users);
            $this->info("Successfully imported / synchronized {$imported} user(s).");
        }
        else
        {
            $this->info("Okay, no users were imported / synchronized.");
        }

        $pendings = User::where('type', 'ldap_pending')->get();

        $this->info("Found {$pendings->count()} pending user(s).");
        $this->info("Sending notification to admins.");

        if ($pendings->count() > 0)
        {
            User::where('role', 'admin')->each(function ($user) use ($pendings) {
                $user->notify(new WarnAdminAboutPendingLdapUsers($pendings));
            });
        }
    }
}
