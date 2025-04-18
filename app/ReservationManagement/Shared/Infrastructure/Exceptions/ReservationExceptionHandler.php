<?php

namespace App\ReservationManagement\Shared\Infrastructure\Exceptions;

use App\ReservationManagement\Customers\domain\exeptions\CustomerException;
use App\ReservationManagement\Reservations\domain\exeptions\ReservationsException;
use App\ReservationManagement\Tables\domain\exeptions\TablesException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class ReservationExceptionHandler
{
    public function handleException(Throwable $exception): JsonResponse
    {
        if ($exception instanceof ReservationsException ||
            $exception instanceof CustomerException ||
            $exception instanceof TablesException
        ) {
            return $this->handleDomainException($exception);
        }

        if ($exception instanceof ValidationException) {
            return response()->json([
                'errors' => $exception->errors()
            ], 422);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Resource not found'
            ], 404);
        }

        return response()->json([
            'error' => 'An unexpected error occurred'
        ], 500);
    }

    private function handleDomainException($exception): JsonResponse
    {
        return response()->json([
            'error' => $exception->getMessage()
        ], $exception->getHttpCode());
    }
}
