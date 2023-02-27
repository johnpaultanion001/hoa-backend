<?php

namespace App\Http\Middleware;

use Api\V1_0_0\Models\User;
use Api\V1_0_0\Models\UserSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SetCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $authUser = $request->user();

        if (isset($authUser->email)) {
            $user = User::whereEmail($authUser->email)->first();

            if ($user && $user->role === 'super_admin') return $next($request);
        }

        $data = $request->all();

        if (empty($data['company_id'])) {

            $company = $request->header('company');
            if (!empty($company)) {

                $setting = UserSetting::where('value->admin', $company)
                    ->orWhere('value->client', $company)
                    ->first();

                if (!$setting) {
                    return response()->json([
                        "code" => Response::HTTP_UNAUTHORIZED,
                        "success" => false,
                        "message" => "Unauthenticated"
                    ]);
                }
                $request->request->add(['company_id' => $setting->user_id]);
            }
        }

        return $next($request);
    }
}
