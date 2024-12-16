<?php

namespace App\Http\Controllers;

use App\Models\DeliveryLog;
use App\Utils\HttpResponseCode;
use Illuminate\Http\Request;

class DeliveryLogController extends BaseController
{
    public function __construct(DeliveryLog $deliveryLog)
    {
        parent::__construct($deliveryLog);
    }

    public function save(Request $request)
    {
        // Validasi input lainnya
        $request->validate([
            'nomor_resi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kota' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
        ]);

        // Ambil data terakhir berdasarkan nomor resi
        $lastLog = DeliveryLog::where('nomor_resi', $request->input('nomor_resi'))->latest()->first();

        // Jika ada data terakhir, cek apakah tanggal yang ingin disimpan lebih besar atau sama dengan tanggal terakhir diupdate
        if ($lastLog && $request->input('tanggal') < $lastLog->tanggal) {
            // Menggunakan $this->error untuk mengembalikan response error
            return $this->error('Tanggal yang ingin disimpan harus lebih besar atau sama dengan tanggal terakhir yang disimpan.', 422);
        }

        // Pastikan tanggal yang ingin disimpan tidak lebih besar dari tanggal saat ini
        if ($request->input('tanggal') > now()->toDateString()) {
            // Menggunakan $this->error untuk mengembalikan response error
            return $this->error('Tanggal tidak boleh lebih besar dari tanggal saat ini.', 422);
        }
        // Simpan data jika validasi berhasil
        $entryLog = new DeliveryLog();
        $entryLog->nomor_resi = $request->input('nomor_resi');
        $entryLog->tanggal = $request->input('tanggal');
        $entryLog->kota = $request->input('kota');
        $entryLog->keterangan = $request->input('keterangan');
        $entryLog->save();

        return $this->success('Data berhasil disimpan.', $entryLog);
    }

    public function getByNomorResi($nomor_resi)
    {
        $logs = $this->model->with($this->model->relations())->where('nomor_resi', $nomor_resi)->get();
        if ($logs->isEmpty()) {
            return $this->error('Data not found', HttpResponseCode::HTTP_NOT_FOUND);
        }
        return $this->success('Successfully retrieved data', $logs);
    }
}
