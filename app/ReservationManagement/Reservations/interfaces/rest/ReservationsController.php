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

    public function index()
    {
        $reservations = $this->queryService->execute(new GetAllReservationsQuery());
        return ReservationsResource::collection($reservations);
    }

    public function show($id)
    {
        $reservation = $this->queryService->executeById(new GetAllReservationsByIdQuery($id));
        return new ReservationsResource($reservation);
    }

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

    public function destroy($id)
    {
        $this->commandService->delete($id);
        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}
