<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:create-admin {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data['name'] = $this->argument('email');
        $data['email'] = $this->argument('email');
        $data['password'] = $this->argument('password');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole('administrator');

        $this->info("Account: ".$data['email']." has been created");
    }
}
