<?php

return [


    "firebase" => [
        "user_key" => [
            ["from" => "displayName", "to" => "name"],
            ["from" => "photoURL", "to" => "photo_url"],
            ["from" => "email", "to" => "email"],
//            ["from" => "phoneNumber", "to" => "phone_number"],
            ["from" => "password", "to" => "password"],
            ["from" => "disabled", "to" => "disabled"],
            ["from" => "uid", "to" => "uid"],
        ],
    ],
    "booking_types" => [
        "maintenance_service" => "maintenance_service",
        "reservation_booking" => "reservation_booking",
    ],
    "days" => [
      "1"=> "monday",
      "2"=> "tuesday",
      "3"=> "wednesday",
      "4"=> "thursday",
      "5"=> "friday",
      "6"=> "saturday",
      "7"=> "sunday",
    ],
    "users" => [
        "permissions" => [
            [
                "name" => "Dashboard",
                "key" => "dashboard",
                "actions" => ["view"]
            ],
            [
                "key" => "user",
                "name" => "Users",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "reservation-and-booking",
                "name" => "Reservation and Bookings",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "maintenance-and-service",
                "name" => "Maintenance and Service",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "ads",
                "name" => "ADS",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "visitor-logbook",
                "name" => "Visitor Logbook",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "event-and-announcement",
                "name" => "Event and Announcements",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "messaging",
                "name" => "Messaging",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "web-builder",
                "name" => "Website Builder",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "payment",
                "name" => "Bills and Payments",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "documents",
                "name" => "Request for documents",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "answers",
                "name" => "Answers",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "options",
                "name" => "Options",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "questions",
                "name" => "Questions",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "responses",
                "name" => "Respones",
                "actions" => ["view","edit","create","delete"]
            ],
            [
                "key" => "surveys",
                "name" => "Surveys",
                "actions" => ["view","edit","create","delete"]
            ]
        ]
    ]
];

