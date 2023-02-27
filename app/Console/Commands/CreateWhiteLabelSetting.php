<?php

namespace App\Console\Commands;

use Api\V1_0_0\Models\User;
use Api\V1_0_0\Models\UserSetting;
use Illuminate\Console\Command;

class CreateWhiteLabelSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setting:create {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $userSetting;
    private $user;
    public function __construct(UserSetting $userSetting, User $user)
    {
        $this->userSetting = $userSetting;
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $id = $this->argument('id');

        $pages = [
            [
                'path' => 'reservations.index',
                'name' => 'Reservation and Booking',
                'icon' => 'fa fa-calendar-days',
                'status' => false
            ],
            [
                'path' => 'repairs.index',
                'name' => 'Schedule a Repair',
                'icon' => 'fa fa-screwdriver-wrench',
                'status' => false
            ],
            [
                'path' => 'bills-utilities.index',
                'name' => 'Bills',
                'icon' => 'fas fa-file-invoice',
                'status' => false
            ],
            [
                'path' => NULL,
                'name' => 'Rent / Admin Fees',
                'icon' => 'fa fa-house',
                'status' => false
            ],
            [
                'path' => 'announcements.index',
                'name' => 'Events / Announcements',
                'icon' => 'fa fa-scroll',
                'status' => false
            ],
            [
                'path' => 'events.index',
                'name' => 'Calendar Events',
                'icon' => 'fa fa-calendar-day',
                'status' => false
            ],
            [
                'path' => "inquiry.index",
                'name' => 'Messages',
                'icon' => 'fa fa-message',
                'status' => false
            ],
            [
                'path' => 'logbooks.index',
                'name' => 'Visitor Logbook',
                'icon' => 'fa fa-users',
                'status' => false
            ],
            [
                'path' => 'documents.index',
                'name' => 'Request of Documents',
                'icon' => 'fa fa-file-lines',
                'status' => false
            ],
            [
                'path' => 'surveys.index',
                'name' => 'Survey',
                'icon' => 'fa fa-file-lines',
                'status' => false
            ],
        ];

        $logo = ["full_url" => "https://placeholder.pics/svg/150x50/888888/EEE/Logo"];


        $hbPages = [
          "dashboard","reservations","repairs","logbooks","inquiry","events","documents","bills-utilities","announcements","surveys"
        ];

        if ($id) {
            $lg = [
                "user_id" => $id,
                "key" => "logo",
                "value" => $logo
            ];

            $this->userSetting->create($lg);

            foreach ($hbPages as $key => $value){
                $hb = [
                    "user_id" => $id,
                    "key" => "banner",
                    "value" =>  ["full_url" => null, "page" => $value, "status" => false]
                ];
                $this->userSetting->create($hb);
            }




            foreach ($pages  as $key => $page) {

                $input = [
                    "user_id" => $id,
                    "key" => "page",
                    "value" => $page
                ];

                $this->userSetting->create($input);
            }
        } else {

            $userId = $this->user->whereIn('role', ['super_admin', 'company'])->get()->pluck('id');

            foreach ($userId as $id) {



                $lg = [
                    "user_id" => $id,
                    "key" => "logo",
                    "value" => $logo
                ];

                $existLogo = $this->userSetting
                    ->whereUserId($id)
                    ->where("key","logo")
                    ->first();
                if(!$existLogo){
                    $this->userSetting->create($lg);
                }


                foreach ($hbPages as $key => $value){
                    $existPage = $this->userSetting
                        ->whereUserId($id)
                        ->where("key","banner")
                        ->where("value->page",$value)
                        ->first();



                    if(!$existPage){
                        $hb = [
                            "user_id" => $id,
                            "key" => "banner",
                            "value" =>  ["full_url" => null, "page" => $value, "status" => false]
                        ];
                        $this->userSetting->create($hb);
                    }


                }


                foreach ($pages  as $key => $page) {


                    $existPage = $this->userSetting
                        ->whereUserId($id)
                        ->where("key","page")
                        ->where("value->path",$page["path"])
                        ->first();

                    if(!$existPage){
                        $input = [
                            "user_id" => $id,
                            "key" => "page",
                            "value" => $page
                        ];

                        $this->userSetting->create($input);
                    }


                }
            }
        }

        return 0;
    }
}
