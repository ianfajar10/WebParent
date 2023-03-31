<?php
namespace App\Http\Controllers;

use PDF;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interface\KritikRepositoryInterface;

class PDFController extends Controller
{
    public function __construct(KritikRepositoryInterface $KritikRepositoryInterface)
    {
        $this->kritik = $KritikRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdfKritikSaran($periode)
    {
        $kritik = DB::table('critics')->where('created_at', '>=', DB::raw('(NOW() - INTERVAL '.$periode.' MONTH)'))->get();
        $date = [
            'date' => date('d/m/Y')
        ];
        $periode = [
            'month' => $periode
        ];
        $pdf = PDF::loadView('reportKritikSaran', compact('kritik', 'date', 'periode'));
        return $pdf->download('Laporan Kritik dan Saran'.'('.date('d/m/Y').')'.'.pdf');
    }

    public function pdfInformasi($periode)
    {
        $informasi = DB::table('informations')->where('created_at', '>=', DB::raw('(NOW() - INTERVAL '.$periode.' MONTH)'))->get();
        $date = [
            'date' => date('d/m/Y')
        ];
        $periode = [
            'month' => $periode
        ];
        $pdf = PDF::loadView('reportInformasi', compact('informasi', 'date', 'periode'));
        return $pdf->download('Laporan Informasi'.'('.date('d/m/Y').')'.'.pdf');
    }

    public function pdfNilai($semester, $kelas, $nisn)
    {
        $nama = DB::table('users')
        ->select('name')
        ->where('nisn', '=', $nisn)
        ->get();

        $name = $nama[0]->name;

        $nilai = DB::table('nilais')
        ->select('subjects.name', 'nilais.tugas', 'nilais.uts', 'nilais.uas')
        ->leftJoin('subjects', 'subjects.id', '=', 'nilais.id_subject')
        ->where('nisn', '=', $nisn)
        ->where('id_class', '=', $kelas)
        ->where('semester', '=', $semester)
        ->get();

        $date = [
            'date' => date('d/m/Y')
        ];

        $kelas = [
            'kelas' => $kelas
        ];

        $periode = [
            'month' => $semester
        ];

        $name = [
            'name' => $name
        ];

        $pdf = PDF::loadView('reportNilai', compact('nilai', 'date', 'kelas', 'periode', 'name'));
        return $pdf->download('Laporan Nilai'.'('.date('d/m/Y').')'.'.pdf');
    }
}
