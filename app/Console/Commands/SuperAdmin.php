<?php

namespace App\Console\Commands;

use Api\Facade\Auth\Models\User;
use Illuminate\Console\Command;

class SuperAdmin extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'super_admin:create {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    private User $user;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user) {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $email = $this->argument('email');
         $this->user->updateOrCreate(["email" => $email], ["email" => $email, "role" => "super_admin"]);

        $this->info("Email: {$email} successfully created/updated as super admin!");

        return 0;
    }
}
