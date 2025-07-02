<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $table        = 'checkouts';
    protected $primaryKey   = 'checkin_id';
    public    $incrementing = false;

    protected $fillable = [
        'checkin_id',
        'dataHoraSaida',
        'valor',
    ];

    public $timestamps = false;

    public function checkin()
    {
        return $this->belongsTo(Checkin::class, 'checkin_id', 'reserva_id');
    }
}
