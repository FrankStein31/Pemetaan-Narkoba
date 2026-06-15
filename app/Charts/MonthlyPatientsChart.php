<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use App\Models\Patient;

class MonthlyPatientsChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
{
    $tahun = date('Y');
    $bulan = date('m');

    $dataBulan = [];
    $totalPasienLakiLaki = [];
    $totalPasienPerempuan = [];

    for ($i = 1; $i <= $bulan; $i++) {
        $totalPasien = Patient::whereYear('created_at', $tahun)
                               ->whereMonth('created_at', $i)
                               ->get();
        $dataBulan[] = Carbon::create()->month($i)->locale('id')->isoFormat('MMMM');
        $totalPasienLakiLaki[] = $totalPasien->where('gender', 'Laki-Laki')->count();
        $totalPasienPerempuan[] = $totalPasien->where('gender', 'Perempuan')->count();
    }

    return (new LarapexChart)->lineChart()
        ->setTitle('Data Pasien')
        ->setSubtitle('Total pasien yang sudah diperiksa tahun ' . $tahun)
        ->addData('Laki-Laki', $totalPasienLakiLaki)
        ->addData('Perempuan', $totalPasienPerempuan)
        ->setXAxis($dataBulan);
}

}
