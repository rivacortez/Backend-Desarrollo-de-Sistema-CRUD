<?php

namespace Tests\Unit;

use App\ReservationManagement\Reservations\domain\exeptions\ReservationCreationException;
use App\ReservationManagement\Reservations\domain\exeptions\ReservationDeletionException;
use App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException;
use App\ReservationManagement\Reservations\domain\exeptions\ReservationUpdateException;
use App\ReservationManagement\Shared\Infrastructure\Exceptions\ReservationExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ReservationExceptionHandlerTest extends TestCase
{
    private ReservationExceptionHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new ReservationExceptionHandler();
    }

    public function test_handles_reservation_not_found_exception(): void
    {
        $exception = new ReservationNotFoundException("Reservation not found");
        $response = $this->handler->handleException($exception);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['error' => 'Reservation not found'], json_decode($response->getContent(), true));
    }

    public function test_handles_reservation_creation_exception(): void
    {
        $exception = new ReservationCreationException("Failed to create reservation");
        $response = $this->handler->handleException($exception);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals(['error' => 'Failed to create reservation'], json_decode($response->getContent(), true));
    }

    public function test_handles_reservation_update_exception(): void
    {
        $exception = new ReservationUpdateException("Failed to update reservation");
        $response = $this->handler->handleException($exception);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals(['error' => 'Failed to update reservation'], json_decode($response->getContent(), true));
    }

    public function test_handles_reservation_deletion_exception(): void
    {
        $exception = new ReservationDeletionException("Failed to delete reservation");
        $response = $this->handler->handleException($exception);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals(['error' => 'Failed to delete reservation'], json_decode($response->getContent(), true));
    }

    public function test_handles_validation_exception(): void
    {
        $errors = ['date' => ['The date field is required']];
        $exception = $this->createValidationException($errors);

        $response = $this->handler->handleException($exception);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals(['errors' => $errors], json_decode($response->getContent(), true));
    }

    public function test_handles_model_not_found_exception(): void
    {
        $exception = new ModelNotFoundException();
        $response = $this->handler->handleException($exception);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['error' => 'Resource not found'], json_decode($response->getContent(), true));
    }

    public function test_handles_generic_exception(): void
    {
        $exception = new \Exception("Unexpected error");
        $response = $this->handler->handleException($exception);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals(['error' => 'An unexpected error occurred'], json_decode($response->getContent(), true));
    }

    private function createValidationException(array $errors)
    {
        return ValidationException::withMessages($errors);
    }
}
