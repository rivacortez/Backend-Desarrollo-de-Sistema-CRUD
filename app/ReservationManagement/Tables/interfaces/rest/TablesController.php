<?php

namespace App\ReservationManagement\Tables\interfaces\rest;

use App\Http\Controllers\Controller;
use App\ReservationManagement\Tables\Application\Internal\CommandServices\TablesCommandServiceImpl;
use App\ReservationManagement\Tables\Application\Internal\QueryServices\TablesQueryServiceImpl;
use App\ReservationManagement\Tables\Domain\Model\Commands\TablesCommand;
use App\ReservationManagement\Tables\Domain\Model\Queries\GetAllTablesByIdQuery;
use App\ReservationManagement\Tables\Domain\Model\Queries\GetAllTablesQuery;
use App\ReservationManagement\Tables\Interfaces\Rest\Resources\TablesResource;
use Illuminate\Http\Request;

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

    public function index()
    {
        $tables = $this->queryService->execute(new GetAllTablesQuery());
        return TablesResource::collection($tables);
    }

    public function show($id)
    {
        $table = $this->queryService->executeById(new GetAllTablesByIdQuery($id));
        return new TablesResource($table);
    }

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

    public function destroy($id)
    {
        $this->commandService->delete($id);
        return response()->json(['message' => 'Table deleted successfully']);
    }
}
