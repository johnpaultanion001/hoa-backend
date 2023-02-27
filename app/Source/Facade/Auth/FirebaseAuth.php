<?php

namespace Api\Facade\Auth;

use Api\Facade\Auth\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirebaseAuth {

    private $auth;
    private User $user;

    /**
     * FirebaseAuth constructor.
     * @param \Kreait\Firebase\Auth $auth
     * @param User $user
     */
    public function __construct(\Kreait\Firebase\Auth $auth, User $user) {

        $this->auth = $auth;
        $this->user = $user;
    }


    public function user($token) {
        $payload = $this->auth->verifyIdToken($token);
        $uid = $payload->claims()->get('sub');
        $user = $this->auth->getUser($uid);

        return $user;
    }

    public function guard() {
        Auth::viaRequest('firebase', function (Request $request) {
            try {

                $user = $this->user($request->bearerToken());
                $filter = ['email' => $user->email, 'uid' => $user->uid];

                return (object) $filter;

            } catch (\Exception $e) {
                return null;
            }
        });
    }

    public function authorized($data) {
        $auth = request()->user();

        $user = $this->user->whereIn('role', $data)
            ->whereDisabled(false)
            ->whereEmail($auth->email)
            ->first();

        return $user ? true : false;
    }

    public function profile() {
        $user = $this->user(request()->bearerToken());
        $filter = ['email' => $user->email ];

        $inputs = array_merge($filter, [
            "last_login_at"  => $user->metadata->lastLoginAt,
            "name"           => $user->displayName,
            "photo_url"      => $user->photoUrl,
            "phone_number"   => $user->phoneNumber,
            "email_verified" => $user->emailVerified,
            'uid' => $user->uid
        ]);

        $result = $this->user->updateOrCreate($filter, $inputs);

        return $result;
    }

    public function delete($id){

        try {
            $this->auth->deleteUser($id);

        }
        catch (\Exception $e) {

        }



    }

    public function updateOrCreate($data) {

        $update = false;
        try {

            $user = $this->auth->getUserByEmail($data['email']);
            $update = true;

        } catch (\Exception $e) {
            $update = false;

        }

        try {
            $result = [];
            if ($update) {
                $user = $this->auth->updateUser($user->uid, $data);
            } else {
                $user = $this->auth->createUser($data);
            }

            return [
                "success" => true,
                "data"    => $user,
            ];
        } catch (\Exception $e) {

            return [
                "success" => false,
                "message" => $e->getMessage(),
            ];
        }


    }
}
