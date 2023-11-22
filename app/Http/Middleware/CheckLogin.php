<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    public $key = "csm_key";

    public function handle($request, Closure $next)
    {
        try {
            $header = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $header);

            if (!$token) {
                return response()->json([
                    'code' => '401',
                    'status' => false,
                    'message' => 'Token Not Found',
                    'data' => [],
                ], 401);
            }

            $payload = JWT::decode($token, $this->key, ['HS256']);

            $request->login_id = $payload->aud;
            $request->login_by = $payload->lun;

        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json([
                'code' => '401',
                'status' => false,
                'message' => 'Token is expire',
                'data' => [],
            ], 401);
        }
        catch (Exception $e) {
            return response()->json([
                'code' => '401',
                'status' => false,
                'message' => 'Can not verify identity',
                'data' => [],
            ], 401);
        }

        return $next($request);
    }
}
