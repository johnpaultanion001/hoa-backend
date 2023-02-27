<?php

namespace Api\V1_0_0\Services\Auth;

use Api\Facade\Auth\FirebaseAuth;

class AuthService {


    private FirebaseAuth $firebaseAuth;

    public function __construct(FirebaseAuth $firebaseAuth) {

        $this->firebaseAuth = $firebaseAuth;
    }

    public function authorized($data) {

        $result = $this->firebaseAuth->authorized($data);

        return $result;
    }

    public function profile(){
        $result = $this->firebaseAuth->profile();

        return $result;
    }

    public function delete($id){

        $this->firebaseAuth->delete($id);
    }
    public function updateOrCreate($data){

        $inputs = [];

        $result = [];
        foreach ($data as $key => $value){
            if(!empty($value)){
                $userKey = collect(config('constants.firebase.user_key'))
                    ->where('to',$key)
                    ->first();
                if($userKey){
                    $inputs[$userKey['from']] = $value;
                }
            }

        }
        $user = $this->firebaseAuth->updateOrCreate($inputs);


        foreach ($user['data'] as $key => $value){
            $userKey = collect(config('constants.firebase.user_key'))
                ->where('from',$key)
                ->first();
            if($userKey){
                $result[$userKey['to']] = $value;
            }
        }
        return $result;
    }
}
