<?php

namespace App\Http\Middleware;

use Api\V1_0_0\Models\User;
use Api\V1_0_0\Models\UserSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerifyCompany {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $data = $request->all();
        $uid = $request->user()->uid;

        if (empty($data['company_id'])) {
            $user = User::with(['userDetail' => function ($query) {
                $query->with(['user' => function ($query) {
                    $query->whereRole('super_admin');
                }]);
            }])->where('uid', $uid)->first();

            if ($user->role == "super_admin") {
                return $next($request);
            } else {
                if ($user->userDetail && ($user->userDetail->user && $user->userDetail->user->role == "super_admin")) {
                    return $next($request);
                }

                return response()->json([
                    "code"    => Response::HTTP_UNAUTHORIZED,
                    "success" => false,
                    "message" => "Unauthenticated",
                ],Response::HTTP_UNAUTHORIZED);
            }

        } else {
            $isSA = User::find($data['company_id']);
            $company = $request->header('company');
            $setting = UserSetting::with(['user'])
                ->whereHas('user', function ($query) use ($uid){
                    $query->whereUid($uid);
                })
                ->where('value->admin', $company)
                ->orWhere('value->client', $company)
                ->first();

            if ($isSA->role == "super_admin") {
                return $next($request);
            }

            if(!$setting){
                return response()->json([
                    "code"    => Response::HTTP_UNAUTHORIZED,
                    "success" => false,
                    "message" => "Unauthenticated",
                ],Response::HTTP_UNAUTHORIZED);
            }

            return $next($request);
        }
    }
}
