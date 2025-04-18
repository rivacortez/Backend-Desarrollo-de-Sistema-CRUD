<?php

namespace App\ReservationManagement\Tables\interfaces\rest;

use App\ReservationManagement\Tables\application\internal\commandservices\TablesCommandServiceImpl;
use App\ReservationManagement\Tables\application\internal\queryservices\TablesQueryServiceImpl;
use App\ReservationManagement\Tables\domain\model\commands\TablesCommand;
use App\ReservationManagement\Tables\domain\model\queries\GetAllTablesByIdQuery;
use App\ReservationManagement\Tables\domain\model\queries\GetAllTablesQuery;
use App\ReservationManagement\Tables\interfaces\rest\resources\TablesResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(name="Tables", description="API Endpoints for Tables")
 */
class TablesController extends Controller
{
    private $commandService;
    private $queryService;

    public function __construct(
        TablesCommandServiceImpl $commandService,
        TablesQueryServiceImpl $queryService
    ) {
        $this->commandService = $commandService;
        $this->queryService = $queryService;
    }

    /**
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
     *             @OA\Property(property="ubicacion", type="string", example="Terraza Sur")
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
