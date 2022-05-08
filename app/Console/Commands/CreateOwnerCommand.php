<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateOwnerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'owner:create {--email=} {--first_name=} {--last_name=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new owner for the webshop';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->option('email') ?? $this->ask("Email");
        $first_name = $this->option('first_name') ?? $this->ask("First Name");
        $last_name = $this->option('last_name') ?? $this->ask("Last Name");
        $password = $this->option('password') ?? $this->secret("Password");

        $password = Hash::make($password);

        $owner = Employee::create(compact('email', 'first_name', 'password', 'last_name'));
        //todo assign owner role

        $this->table(['Field', 'Value'], [
            ['Id', $owner->id],
            ['Email', $owner->email],
            ['First Name', $owner->first_name],
            ['Last Name', $owner->last_name],
        ]);
        return 0;
    }
}
