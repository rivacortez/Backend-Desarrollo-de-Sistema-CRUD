<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Restaurant Reservation API",
 *      description="API para gestionar reservas de restaurante",
 *      @OA\Contact(
 *          email="admin@example.com",
 *          name="API Support"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API Server"
 * )
 *
 * @OA\Schema(
 *     schema="CommensalResource",
 *     type="object",
 *     title="Commensal Resource",
 *     properties={
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="email", type="string"),
 *         @OA\Property(property="phone", type="string")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="CreateCommensalRequest",
 *     type="object",
 *     title="Create Commensal Request",
 *     required={"name", "email", "phone"},
 *     properties={
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="email", type="string"),
 *         @OA\Property(property="phone", type="string")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="TableResource",
 *     type="object",
 *     title="Table Resource",
 *     properties={
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="number", type="integer"),
 *         @OA\Property(property="capacity", type="integer"),
 *         @OA\Property(property="status", type="string")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="CreateTableRequest",
 *     type="object",
 *     title="Create Table Request",
 *     required={"number", "capacity", "status"},
 *     properties={
 *         @OA\Property(property="number", type="integer"),
 *         @OA\Property(property="capacity", type="integer"),
 *         @OA\Property(property="status", type="string")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="ReservationResource",
 *     type="object",
 *     title="Reservation Resource",
 *     properties={
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="commensal_id", type="integer"),
 *         @OA\Property(property="table_id", type="integer"),
 *         @OA\Property(property="date", type="string", format="date-time"),
 *         @OA\Property(property="status", type="string")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="CreateReservationRequest",
 *     type="object",
 *     title="Create Reservation Request",
 *     required={"commensal_id", "table_id", "date", "status"},
 *     properties={
 *         @OA\Property(property="commensal_id", type="integer"),
 *         @OA\Property(property="table_id", type="integer"),
 *         @OA\Property(property="date", type="string", format="date-time"),
 *         @OA\Property(property="status", type="string")
 *     }
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}