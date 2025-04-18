<?php

namespace App\ReservationManagement\Reservations\interfaces\rest;

use App\Http\Controllers\Controller;
use App\ReservationManagement\Reservations\application\internal\commandservices\ReservationsCommandServiceImpl;
use App\ReservationManagement\Reservations\application\internal\queryservices\ReservationsQueryServiceImpl;
use App\ReservationManagement\Reservations\domain\model\commands\ReservationsCommand;
use App\ReservationManagement\Reservations\domain\model\queries\GetAllReservationsByIdQuery;
use App\ReservationManagement\Reservations\domain\model\queries\GetAllReservationsQuery;
use App\ReservationManagement\Reservations\interfaces\rest\resources\ReservationsResource;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Reservations", description="API Endpoints for Reservations")
 */
class ReservationsController extends Controller
{
    private $commandService;
    private $queryService;

    public function __construct(
        ReservationsCommandServiceImpl $commandService,
        ReservationsQueryServiceImpl $queryService
    ) {
        $this->commandService = $commandService;
        $this->queryService = $queryService;
    }

    /**
     * @OA\Get(
     *     path="/api/reservations",
     *     summary="Get all reservations",
     *     tags={"Reservations"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all reservations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Reservation")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $reservations = $this->queryService->execute(new GetAllReservationsQuery());
        return ReservationsResource::collection($reservations);
    }

    /**
     * @OA\Get(
     *     path="/api/reservations/{id}",
     *     summary="Get a reservation by ID",
     *     tags={"Reservations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the reservation",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation details",
     *         @OA\JsonContent(ref="#/components/schemas/Reservation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reservation not found"
     *     )
     * )
     */
    public function show($id)
    {
        $reservation = $this->queryService->executeById(new GetAllReservationsByIdQuery($id));
        return new ReservationsResource($reservation);
    }

    /**
     * @OA\Post(
     *     path="/api/reservations",
     *     summary="Create a new reservation",
     *     tags={"Reservations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="fecha", type="string", format="date", example="2023-06-15"),
     *             @OA\Property(property="hora", type="string", format="time", example="19:30:00"),
     *             @OA\Property(property="numero_de_personas", type="integer", example=4),
     *             @OA\Property(property="comensal_id", type="integer", example=1),
     *             @OA\Property(property="mesa_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reservation created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Reservation")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $command = new ReservationsCommand(
            null,
            $request->fecha,
            $request->hora,
            $request->numero_de_personas,
            $request->comensal_id,
            $request->mesa_id
        );

        $reservation = $this->commandService->handle($command);
        return new ReservationsResource($reservation);
    }

    /**
     * @OA\Put(
     *     path="/api/reservations/{id}",
     *     summary="Update a reservation",
     *     tags={"Reservations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the reservation to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="fecha", type="string", format="date", example="2023-06-16"),
     *             @OA\Property(property="hora", type="string", format="time", example="20:00:00"),
     *             @OA\Property(property="numero_de_personas", type="integer", example=6),
     *             @OA\Property(property="comensal_id", type="integer", example=1),
     *             @OA\Property(property="mesa_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Reservation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reservation not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $command = new ReservationsCommand(
            $id,
            $request->fecha,
            $request->hora,
            $request->numero_de_personas,
            $request->comensal_id,
            $request->mesa_id
        );

        $reservation = $this->commandService->handle($command);
        return new ReservationsResource($reservation);
    }

    /**
     * @OA\Delete(
     *     path="/api/reservations/{id}",
     *     summary="Delete a reservation",
     *     tags={"Reservations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the reservation to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reservation not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->commandService->delete($id);
        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
