<?php

namespace App\ReservationManagement\Reservations\interfaces\rest;

use App\Http\Controllers\Controller;
use App\ReservationManagement\Reservations\application\internal\commandservices\ReservationsCommandServiceImpl;
use App\ReservationManagement\Reservations\application\internal\queryservices\ReservationsQueryServiceImpl;
use App\ReservationManagement\Reservations\domain\model\commands\ReservationsCommand;
use App\ReservationManagement\Reservations\domain\model\queries\GetAllReservationsQuery;
use App\ReservationManagement\Reservations\interfaces\rest\resources\ReservationsResource;
use App\ReservationManagement\Reservations\domain\model\aggregates\Reservations;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(name="Reservations", description="API Endpoints for Reservation Management")
 */
class ReservationsController extends Controller
{
    private ReservationsCommandServiceImpl $commandService;
    private ReservationsQueryServiceImpl $queryService;

    public function __construct(
        ReservationsCommandServiceImpl $commandService,
        ReservationsQueryServiceImpl $queryService
    ) {
        $this->commandService = $commandService;
        $this->queryService   = $queryService;
    }

    /**
     * @OA\Get(
     *     path="/api/reservations",
     *     summary="Get all reservations",
     *     tags={"Reservations"},
     *     @OA\Response(
     *         response=200,
     *         description="List of reservations",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Reservation"))
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        $reservations = $this->queryService->execute(new GetAllReservationsQuery());
        return ReservationsResource::collection($reservations);
    }

    /**
     * @OA\Get(
     *     path="/api/reservations/{reservation}",
     *     summary="Get a reservation by ID",
     *     tags={"Reservations"},
     *     @OA\Parameter(name="reservation", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Reservation details", @OA\JsonContent(ref="#/components/schemas/Reservation")),
     *     @OA\Response(response=404, description="Reservation not found")
     * )
     */
    public function show(Reservations $reservation): ReservationsResource
    {
        return new ReservationsResource($reservation);
    }

    /**
     * @OA\Post(
     *     path="/api/reservations",
     *     summary="Create a new reservation",
     *     tags={"Reservations"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(
     *         required={"fecha","hora","numero_de_personas","comensal_id","mesa_id"},
     *         @OA\Property(property="fecha", type="string", format="date", example="2025-05-01"),
     *         @OA\Property(property="hora", type="string", format="time", example="19:30:00"),
     *         @OA\Property(property="numero_de_personas", type="integer", example=4),
     *         @OA\Property(property="comensal_id", type="integer", example=1),
     *         @OA\Property(property="mesa_id", type="integer", example=1)
     *     )),
     *     @OA\Response(response=201, description="Reservation created successfully", @OA\JsonContent(ref="#/components/schemas/Reservation")),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'fecha'               => 'required|date',
            'hora'                => 'required|date_format:H:i:s',
            'numero_de_personas'  => 'required|integer',
            'comensal_id'         => 'required|exists:customers,id',
            'mesa_id'             => 'required|exists:tables,id',
        ]);

        $command = new ReservationsCommand(
            null,
            $validated['fecha'],
            $validated['hora'],
            $validated['numero_de_personas'],
            $validated['comensal_id'],
            $validated['mesa_id']
        );

        $reservation = $this->commandService->handle($command);
        return (new ReservationsResource($reservation))->response()->setStatusCode(201);
    }

    /**
     * @OA\Put(
     *     path="/api/reservations/{reservation}",
     *     summary="Update a reservation",
     *     tags={"Reservations"},
     *     @OA\Parameter(name="reservation", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(
     *         @OA\Property(property="fecha", type="string", format="date", example="2025-06-01"),
     *         @OA\Property(property="hora", type="string", format="time", example="20:00:00"),
     *         @OA\Property(property="numero_de_personas", type="integer", example=6),
     *         @OA\Property(property="comensal_id", type="integer", example=1),
     *         @OA\Property(property="mesa_id", type="integer", example=2)
     *     )),
     *     @OA\Response(response=200, description="Reservation updated successfully", @OA\JsonContent(ref="#/components/schemas/Reservation")),
     *     @OA\Response(response=404, description="Reservation not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, Reservations $reservation): ReservationsResource
    {
        $validated = $request->validate([
            'fecha'               => 'sometimes|required|date',
            'hora'                => 'sometimes|required|date_format:H:i:s',
            'numero_de_personas'  => 'sometimes|required|integer',
            'comensal_id'         => 'sometimes|required|exists:customers,id',
            'mesa_id'             => 'sometimes|required|exists:tables,id',
        ]);

        $command = new ReservationsCommand(
            $reservation->id,
            $validated['fecha']               ?? $reservation->fecha,
            $validated['hora']                ?? $reservation->hora,
            $validated['numero_de_personas']  ?? $reservation->numero_de_personas,
            $validated['comensal_id']         ?? $reservation->comensal_id,
            $validated['mesa_id']             ?? $reservation->mesa_id
        );

        $updated = $this->commandService->handle($command);
        return new ReservationsResource($updated);
    }

    /**
     * @OA\Delete(
     *     path="/api/reservations/{reservation}",
     *     summary="Delete a reservation",
     *     tags={"Reservations"},
     *     @OA\Parameter(name="reservation", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Reservation deleted successfully"),
     *     @OA\Response(response=404, description="Reservation not found")
     * )
     */
    public function destroy(Reservations $reservation): JsonResponse
    {
        $this->commandService->delete($reservation->id);
        return response()->json(['message' => 'Reservation deleted successfully'], 200);
    }
}
