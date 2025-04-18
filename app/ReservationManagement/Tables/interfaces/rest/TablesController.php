<?php

namespace App\ReservationManagement\Tables\interfaces\rest;

use App\Http\Controllers\Controller;
use App\ReservationManagement\Tables\application\internal\commandservices\TablesCommandServiceImpl;
use App\ReservationManagement\Tables\application\internal\queryservices\TablesQueryServiceImpl;
use App\ReservationManagement\Tables\domain\model\commands\TablesCommand;
use App\ReservationManagement\Tables\domain\model\queries\GetAllTablesQuery;
use App\ReservationManagement\Tables\interfaces\rest\resources\TablesResource;
use App\ReservationManagement\Tables\domain\model\aggregates\Tables;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(name="Tables", description="API Endpoints for Table Management")
 */
class TablesController extends Controller
{
    private TablesCommandServiceImpl $commandService;
    private TablesQueryServiceImpl $queryService;

    public function __construct(
        TablesCommandServiceImpl $commandService,
        TablesQueryServiceImpl $queryService
    ) {
        $this->commandService = $commandService;
        $this->queryService   = $queryService;
    }

    /**
     * @OA\Get(
     *     path="/api/tables",
     *     summary="Get all tables",
     *     tags={"Tables"},
     *     @OA\Response(
     *         response=200,
     *         description="List of tables",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Table"))
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        $tables = $this->queryService->execute(new GetAllTablesQuery());
        return TablesResource::collection($tables);
    }

    /**
     * @OA\Get(
     *     path="/api/tables/{table}",
     *     summary="Get a table by ID",
     *     tags={"Tables"},
     *     @OA\Parameter(name="table", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Table details", @OA\JsonContent(ref="#/components/schemas/Table")),
     *     @OA\Response(response=404, description="Table not found")
     * )
     */
    public function show(Tables $table): TablesResource
    {
        return new TablesResource($table);
    }

    /**
     * @OA\Post(
     *     path="/api/tables",
     *     summary="Create a new table",
     *     tags={"Tables"},
     *     @OA\RequestBody(required=true, @OA\JsonContent(
     *         required={"numero_mesa","capacidad","ubicacion"},
     *         @OA\Property(property="numero_mesa", type="string", example="A-12"),
     *         @OA\Property(property="capacidad", type="integer", example=4),
     *         @OA\Property(property="ubicacion", type="string", example="Terraza Norte")
     *     )),
     *     @OA\Response(response=201, description="Table created successfully", @OA\JsonContent(ref="#/components/schemas/Table")),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'numero_mesa' => 'required|string',
            'capacidad'   => 'required|integer',
            'ubicacion'   => 'required|string',
        ]);

        $command = new TablesCommand(
            null,
            $validated['numero_mesa'],
            $validated['capacidad'],
            $validated['ubicacion']
        );

        $table = $this->commandService->handle($command);
        return (new TablesResource($table))->response()->setStatusCode(201);
    }

    /**
     * @OA\Put(
     *     path="/api/tables/{table}",
     *     summary="Update a table",
     *     tags={"Tables"},
     *     @OA\Parameter(name="table", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(
     *         @OA\Property(property="numero_mesa", type="string", example="A-14"),
     *         @OA\Property(property="capacidad", type="integer", example=6),
     *         @OA\Property(property="ubicacion", type="string", example="Terraza Este")
     *     )),
     *     @OA\Response(response=200, description="Table updated successfully", @OA\JsonContent(ref="#/components/schemas/Table")),
     *     @OA\Response(response=404, description="Table not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(Request $request, Tables $table): TablesResource
    {
        $validated = $request->validate([
            'numero_mesa' => 'sometimes|required|string',
            'capacidad'   => 'sometimes|required|integer',
            'ubicacion'   => 'sometimes|required|string',
        ]);

        $command = new TablesCommand(
            $table->id,
            $validated['numero_mesa'] ?? $table->numero_mesa,
            $validated['capacidad']   ?? $table->capacidad,
            $validated['ubicacion']   ?? $table->ubicacion
        );

        $updated = $this->commandService->handle($command);
        return new TablesResource($updated);
    }

    /**
     * @OA\Delete(
     *     path="/api/tables/{table}",
     *     summary="Delete a table",
     *     tags={"Tables"},
     *     @OA\Parameter(name="table", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Table deleted successfully"),
     *     @OA\Response(response=404, description="Table not found")
     * )
     */
    public function destroy(Tables $table): JsonResponse
    {
        $this->commandService->delete($table->id);
        return response()->json(['message' => 'Table deleted successfully'], 200);
    }
}
