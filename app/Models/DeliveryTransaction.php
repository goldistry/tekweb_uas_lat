<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class DeliveryTransaction extends Model
{
    use HasUuids, HasFactory;
    protected $fillable = ['nomor_resi', 'tanggal_resi'];
    public static function validationRules()
    {
        return [
            'nomor_resi' => 'required|string|max:255',
            'tanggal_resi' => 'required|date',
        ];
    }

    public static function validationMessages()
    {
        return [
            'nomor_resi.required' => 'Nomor Resi is required',
            'tanggal_resi.required' => 'Tanggal Resi is required',
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

    public function relations()
    {
        return ['deliveryLog'];
    }
    public function deliveryLog()
    {
        return $this->hasMany(DeliveryLog::class, 'nomor_resi', 'nomor_resi');
    }
}
