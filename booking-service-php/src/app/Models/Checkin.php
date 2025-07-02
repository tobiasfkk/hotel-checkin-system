<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    protected $table        = 'checkins';
    protected $primaryKey   = 'reserva_id';
    public    $incrementing = false;

    protected $fillable = [
        'reserva_id',
        'dataHoraEntrada',
        'garagem',
    ];

    public $timestamps = false;

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function checkout()
    {
        return $this->hasOne(Checkout::class);
    }
}
