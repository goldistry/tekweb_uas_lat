<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DeliveryLog extends Model
{
    use HasUuids, HasFactory;
    protected $fillable = ['nomor_resi', 'tanggal', 'kota', 'keterangan'];
    public static function validationRules()
    {
        return [
            'nomor_resi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kota' => 'required|string',
            'keterangan' => 'required|string',
        ];
    }

    public static function validationMessages()
    {
        return [
            'nomor_resi.required' => 'Nomor Resi is required',
            'tanggal.required' => 'Tanggal Resi is required',
            'kota.required' => 'Kota is required',
            'kota.string' => 'Kota must be a valid string',
            'keterangan.required' => 'Keterangan is required',
            'keterangan.string' => 'Keterangan must be a valid string',
        ];
    } 
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'updated_at',
        'created_at',
    ];
    // Relasi dengan TransaksiResi
    public function relations()
    {
        return ['deliveryTransaction'];
    }
    public function deliveryTransaction()
    {
        return $this->belongsTo(DeliveryTransaction::class, 'nomor_resi', 'nomor_resi');
    }
}
