<?php

namespace App\Http\Utils;

use Illuminate\Http\JsonResponse;

class ResponseHandler
{
    /**
     * Respuesta de éxito con código 200 (OK).
     *
     * @param mixed $data Datos a incluir en la respuesta.
     * @param string $message Mensaje de éxito opcional.
     * @return JsonResponse
     */
    public static function success($data = null, $message = 'Request successful', $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Respuesta de error con código 400 (Bad Request) o 500 (Internal Server Error).
     *
     * @param string $message Mensaje de error.
     * @param int $status Código de estado HTTP.
     * @return JsonResponse
     */
    public static function error($message = 'An error occurred', $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $status === 400 ? 'Bad Request' : 'Internal Server Error',
        ], $status);
    }

    /**
     * Respuesta para recurso no encontrado con código 404 (Not Found).
     *
     * @param string $message Mensaje de recurso no encontrado.
     * @return JsonResponse
     */
    public static function notFound($message = 'Resource not found'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => 'Not Found',
        ], 404);
    }
}

