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
 * Reservations REST Controller
 *
 * This controller implements the REST interface for the Reservations bounded context,
 * serving as the primary entry point for reservation management operations through the API.
 * It follows CQRS (Command Query Responsibility Segregation) principles by utilizing separate
 * command and query services for write and read operations respectively.
 *
 * As part of the Hexagonal Architecture, this controller belongs to the interface layer
 * and translates HTTP requests into domain operations, then transforms domain responses
 * back into HTTP responses using resource classes.
 *
 * The controller supports standard CRUD operations:
 * - Listing all reservations
 * - Retrieving a specific reservation by ID
 * - Creating new reservations
 * - Updating existing reservations
 * - Deleting reservations
 *
 * Each endpoint is documented with OpenAPI annotations to facilitate API discovery and testing.
 *
 * @OA\Tag(name="Reservations", description="API Endpoints for Reservations")
 */
class ReservationsController extends Controller
{
    /**
     * Command service for handling write operations on reservations
     *
     * @var ReservationsCommandServiceImpl
     */
    private $commandService;

    /**
     * Query service for handling read operations on reservations
     *
     * @var ReservationsQueryServiceImpl
     */
    private $queryService;

    /**
     * Constructor with dependency injection for required services
     *
     * Initializes the controller with its dependencies following the Dependency Inversion Principle.
     * Services are injected through Laravel's service container, decoupling the controller
     * from concrete implementations.
     *
     * @param ReservationsCommandServiceImpl $commandService Service for handling write operations
     * @param ReservationsQueryServiceImpl $queryService Service for handling read operations
     */
    public function __construct(
        ReservationsCommandServiceImpl $commandService,
        ReservationsQueryServiceImpl $queryService
    ) {
        $this->commandService = $commandService;
        $this->queryService = $queryService;
    }

    /**
     * Retrieve all reservations from the system
     *
     * Creates a query object and delegates to the query service to fetch
     * all reservation records. The result is transformed into a standardized
     * API response using the resource collection transformer.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Collection of reservation resources
     *
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
     * Retrieve a specific reservation by its unique identifier
     *
     * Creates a query object with the provided ID and delegates to the query service
     * to fetch the specific reservation. The result is transformed into a standardized
     * API response using the resource transformer.
     *
     * @param int $id The unique identifier of the reservation to retrieve
     * @return ReservationsResource The reservation resource
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException When no reservation exists with the provided ID
     *
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
     * Create a new reservation in the system
     *
     * Extracts reservation data from the request, creates a command object,
     * and delegates to the command service for processing. The newly created
     * reservation is then transformed into a standardized API response.
     *
     * @param Request $request The HTTP request containing reservation data
     * @return ReservationsResource The newly created reservation resource
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationCreationException When validation fails or errors occur during creation
     *
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
     * Update an existing reservation in the system
     *
     * Extracts reservation data from the request, creates a command object with the
     * specified ID, and delegates to the command service for processing. The updated
     * reservation is then transformed into a standardized API response.
     *
     * @param Request $request The HTTP request containing updated reservation data
     * @param int $id The unique identifier of the reservation to update
     * @return ReservationsResource The updated reservation resource
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException When the specified reservation doesn't exist
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationUpdateException When validation fails or errors occur during update
     *
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
     * Delete a reservation from the system
     *
     * Delegates to the command service to remove the specified reservation.
     * Returns a success message upon completion.
     *
     * @param int $id The unique identifier of the reservation to delete
     * @return \Illuminate\Http\JsonResponse Response with success message
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException When the specified reservation doesn't exist
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationDeletionException When database errors prevent deletion
     *
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
