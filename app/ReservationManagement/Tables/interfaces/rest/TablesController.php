<?php

namespace App\ReservationManagement\Tables\interfaces\rest;



use App\ReservationManagement\Tables\application\internal\commandservices\TablesCommandServiceImpl;
use App\ReservationManagement\Tables\application\internal\queryservices\TablesQueryServiceImpl;
use App\ReservationManagement\Tables\domain\model\commands\TablesCommand;
use App\ReservationManagement\Tables\domain\model\queries\GetAllTablesByIdQuery;
use App\ReservationManagement\Tables\domain\model\queries\GetAllTablesQuery;
use App\ReservationManagement\Tables\interfaces\rest\resources\TablesResource;
use Illuminate\Routing\Controller;
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
