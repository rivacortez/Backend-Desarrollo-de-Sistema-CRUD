<?php

namespace App\ReservationManagement\Reservations\domain\model\aggregates;

use App\ReservationManagement\Customers\domain\model\aggregates\Customers;
use App\ReservationManagement\Tables\domain\model\aggregates\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Reservations Aggregate Root Entity
 *
 * This class represents the Reservation aggregate root within the Reservation Management bounded context.
 * It encapsulates all reservation-related business rules and attributes, acting as the primary entity
 * for table reservation operations within the restaurant system.
 *
 * As an aggregate root, this entity enforces invariants and business rules for the reservation process,
 * maintains consistency for reservation state, and provides a cohesive model for restaurant bookings
 * that connects customers with dining tables.
 *
 * The class handles:
 * - Core reservation data (date, time, party size)
 * - Relationships to customer and table entities
 * - Validation rules to maintain data integrity
 * - Persistence mapping to the database layer
 *
 * This aggregate is a central component in the domain model, representing a complete
 * reservation transaction with all its business rules and constraints.
 *
 * @property int $id Unique identifier for the reservation
 * @property string $fecha The date of the reservation
 * @property string $hora The time of the reservation
 * @property int $numero_de_personas Number of people in the reservation party
 * @property int $comensal_id Foreign key to the customer making the reservation
 * @property int $mesa_id Foreign key to the table being reserved
 * @property \DateTime $created_at Timestamp of record creation
 * @property \DateTime $updated_at Timestamp of last record update
 */
class Reservations extends Model
{
    use HasFactory;

    /**
     * The database table associated with the model
     *
     * @var string
     */
    protected $table = 'reservations';

    /**
     * The attributes that are mass assignable
     *
     * Defines which fields can be filled through mass assignment operations,
     * protecting other attributes from unintended modification.
     *
     * @var array<string>
     */
    protected $fillable = ['fecha', 'hora', 'numero_de_personas', 'comensal_id', 'mesa_id'];

    /**
     * Get validation rules for reservation attributes
     *
     * Defines the validation constraints that ensure reservation data integrity.
     * These rules enforce:
     * - Required date and time values
     * - Minimum party size of 1 person
     * - Valid references to existing customers and tables
     *
     * @return array<string, string> The validation rules for reservation attributes
     */
    public function rules()
    {
        return [
            'fecha' => 'required|date',
            'hora' => 'required',
            'numero_de_personas' => 'required|integer|min:1',
            'comensal_id' => 'required|exists:customers,id',
            'mesa_id' => 'required|exists:tables,id',
        ];
    }

    /**
     * Define relationship to the customer making the reservation
     *
     * Creates a belongs-to relationship connecting the reservation to its associated customer.
     * This enables easy access to customer information from reservation instances.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo The relationship to the customer
     */
    public function comensal()
    {
        return $this->belongsTo(Customers::class, 'comensal_id');
    }

    /**
     * Define relationship to the table being reserved
     *
     * Creates a belongs-to relationship connecting the reservation to its associated table.
     * This enables easy access to table information from reservation instances.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo The relationship to the table
     */
    public function mesa()
    {
        return $this->belongsTo(Tables::class, 'mesa_id');
    }
}
