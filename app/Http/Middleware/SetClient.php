<?php

namespace App\Http\Middleware;

use Api\V1_0_0\Models\User;
use Api\V1_0_0\Models\UserDetail;
use Api\V1_0_0\Models\UserSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SetClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $data = $request->all();

        $company = $request->header('company');
        if (!empty($company)) {
            $uid = $request->user()->uid;

            $user = User::where('uid',$uid)->first();


            $input = ["company_id" =>$data['company_id'], "user_id" => $user->id];

            UserDetail::updateOrCreate($input,$input);

            return $next($request);
        }

        return response()->json([
            "code" => Response::HTTP_UNAUTHORIZED,
            "success" => false,
            "message" => "Unauthenticated"
        ]);
    }
}
