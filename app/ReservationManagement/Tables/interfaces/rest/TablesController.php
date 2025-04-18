<?php

namespace App\ReservationManagement\Tables\interfaces\rest;

use App\Http\Controllers\Controller;
use App\ReservationManagement\Tables\application\internal\commandservices\TablesCommandServiceImpl;
use App\ReservationManagement\Tables\application\internal\queryservices\TablesQueryServiceImpl;
use App\ReservationManagement\Tables\domain\model\commands\TablesCommand;
use App\ReservationManagement\Tables\domain\model\queries\GetAllTablesByIdQuery;
use App\ReservationManagement\Tables\domain\model\queries\GetAllTablesQuery;
use App\ReservationManagement\Tables\interfaces\rest\resources\TablesResource;
use Illuminate\Http\Request;

/**
 * Tables REST Controller
 *
 * This controller implements the REST interface for the Tables bounded context,
 * serving as the primary entry point for table management operations through the API.
 * It follows CQRS (Command Query Responsibility Segregation) principles by utilizing separate
 * command and query services for write and read operations respectively.
 *
 * As part of the Hexagonal Architecture, this controller belongs to the interface layer
 * and translates HTTP requests into domain operations, then transforms domain responses
 * back into HTTP responses using resource classes.
 *
 * The controller supports standard CRUD operations:
 * - Listing all tables
 * - Retrieving a specific table by ID
 * - Creating new tables
 * - Updating existing tables
 * - Deleting tables
 *
 * Each endpoint is documented with OpenAPI annotations to facilitate API discovery and testing.
 *
 * @OA\Tag(name="Tables", description="API Endpoints for Tables")
 */
class TablesController extends Controller
{
    /**
     * Command service for handling write operations on tables
     *
     * @var TablesCommandServiceImpl
     */
    private $commandService;

    /**
     * Query service for handling read operations on tables
     *
     * @var TablesQueryServiceImpl
     */
    private $queryService;

    /**
     * Constructor with dependency injection for required services
     *
     * Initializes the controller with its dependencies following the Dependency Inversion Principle.
     * Services are injected through Laravel's service container, decoupling the controller
     * from concrete implementations.
     *
     * @param TablesCommandServiceImpl $commandService Service for handling write operations
     * @param TablesQueryServiceImpl $queryService Service for handling read operations
     */
    public function __construct(
        TablesCommandServiceImpl $commandService,
        TablesQueryServiceImpl $queryService
    ) {
        $this->commandService = $commandService;
        $this->queryService = $queryService;
    }

    /**
     * Retrieve all tables from the system
     *
     * Creates a query object and delegates to the query service to fetch
     * all table records. The result is transformed into a standardized
     * API response using the resource collection transformer.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Collection of table resources
     *
     * @OA\Get(
     *     path="/api/tables",
     *     summary="Get all tables",
     *     tags={"Tables"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all tables",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Table")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $tables = $this->queryService->execute(new GetAllTablesQuery());
        return TablesResource::collection($tables);
    }

    /**
     * Retrieve a specific table by its unique identifier
     *
     * Creates a query object with the provided ID and delegates to the query service
     * to fetch the specific table. The result is transformed into a standardized
     * API response using the resource transformer.
     *
     * @param int $id The unique identifier of the table to retrieve
     * @return TablesResource The table resource
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableNotFoundException When no table exists with the provided ID
     *
     * @OA\Get(
     *     path="/api/tables/{id}",
     *     summary="Get a table by ID",
     *     tags={"Tables"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the table",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Table details",
     *         @OA\JsonContent(ref="#/components/schemas/Table")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Table not found"
     *     )
     * )
     */
    public function show($id)
    {
        $table = $this->queryService->executeById(new GetAllTablesByIdQuery($id));
        return new TablesResource($table);
    }

    /**
     * Create a new table in the system
     *
     * Extracts table data from the request, creates a command object,
     * and delegates to the command service for processing. The newly created
     * table is then transformed into a standardized API response.
     *
     * @param Request $request The HTTP request containing table data
     * @return TablesResource The newly created table resource
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableCreationException When validation fails or errors occur during creation
     *
     * @OA\Post(
     *     path="/api/tables",
     *     summary="Create a new table",
     *     tags={"Tables"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="numero_mesa", type="string", example="A-12"),
     *             @OA\Property(property="capacidad", type="integer", example=4),
     *             @OA\Property(property="ubicacion", type="string", example="Terraza Norte")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Table created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Table")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $command = new TablesCommand(
            null,
            $request->numero_mesa,
            $request->capacidad,
            $request->ubicacion
        );

        $table = $this->commandService->handle($command);
        return new TablesResource($table);
    }

    /**
     * Update an existing table in the system
     *
     * Extracts table data from the request, creates a command object with the
     * specified ID, and delegates to the command service for processing. The updated
     * table is then transformed into a standardized API response.
     *
     * @param Request $request The HTTP request containing updated table data
     * @param int $id The unique identifier of the table to update
     * @return TablesResource The updated table resource
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableNotFoundException When the specified table doesn't exist
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableUpdateException When validation fails or errors occur during update
     *
     * @OA\Put(
     *     path="/api/tables/{id}",
     *     summary="Update a table",
     *     tags={"Tables"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the table to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="numero_mesa", type="string", example="A-14"),
     *             @OA\Property(property="capacidad", type="integer", example=6),
     *             @OA\Property(property="ubicacion", type="string", example="Terraza Este")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Table updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Table")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Table not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $command = new TablesCommand(
            $id,
            $request->numero_mesa,
            $request->capacidad,
            $request->ubicacion
        );

        $table = $this->commandService->handle($command);
        return new TablesResource($table);
    }

    /**
     * Delete a table from the system
     *
     * Delegates to the command service to remove the specified table.
     * Returns a success message upon completion.
     *
     * @param int $id The unique identifier of the table to delete
     * @return \Illuminate\Http\JsonResponse Response with success message
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableNotFoundException When the specified table doesn't exist
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableDeletionException When database errors prevent deletion
     *
     * @OA\Delete(
     *     path="/api/tables/{id}",
     *     summary="Delete a table",
     *     tags={"Tables"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the table to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Table deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Table not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->commandService->delete($id);
        return response()->json(['message' => 'Table deleted successfully']);
    }
}
