<?php


/** @var TYPE_NAME $router */
$router->resources([
    "samples" => "SampleController",
    "files" => "FileController",
    "users" => "UserController",
    "bookings" => "BookingController",
    "services" => "ServiceController",
    "visitor-logs" => "VisitorLogController",
    "event-announcements" => "EventAnnouncementController",
    "documents" => "DocumentController",
    "advertisements" => "AdvertisementController",
    "user-settings" => "UserSettingController",
    "user-details" => "UserDetailController",
    "inquiries" => "InquiryController",
    "permissions" => "PermissionController",
    "answers" => "AnswerController",
    "options" => "OptionController",
    "questions" => "QuestionController",
    "responses" => "ResponseController",
    "surveys" => "SurveyController",
]);

$router->get('services/date-availabilities/{id}', 'ServiceController@dateAvailabilities');
$router->get('permissions/look-up/get', 'PermissionController@permissions');
$router->get('event-announcements/get/tags', 'EventAnnouncementController@tags');
$router->post('inquiries/reply/{id}', 'InquiryController@reply');

$router->group(['prefix' => "files"], function ($router) {

    $router->post('upload', 'FileController@upload');
});


$router->group(['prefix' => "analytics"], function ($router) {
    $router->get('dashboard', 'AnalyticController@dashboard');
});
