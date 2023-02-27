<?php

namespace App\Console\Commands;

use Api\V1_0_0\Models\Permission;
use Illuminate\Console\Command;

class CreatePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var Permission
     */
    private Permission $permission;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Permission  $permission)
    {
        parent::__construct();
        $this->permission = $permission;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $roles = ["super_admin","staff","company","admin"];
        $permissions = config('constants.users.permissions');
        foreach ($roles as $pk => $pv){
           foreach ($permissions as $ck => $cv){
               $this->permission->create(array_merge($cv,["role" => $pv]));
           }
        }
        return 0;
    }
}
