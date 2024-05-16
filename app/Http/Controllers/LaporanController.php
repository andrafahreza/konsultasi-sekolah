<?php

namespace App\Http\Controllers;

use App\Models\KepalaSekolah;
use App\Models\ManajemenDataBk;
use App\Models\Siswa;
use PDF;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanPeriode(Request $request)
    {
        $title = "Laporan Periode";
        $filter = false;
        $from = null;
        $to = null;

        $data = array();
        if ($request->isMethod('post')) {
            $from = date('Y-m-d', strtotime($request->from));
            $to = date('Y-m-d', strtotime($request->to));
            $data = ManajemenDataBk::whereBetween('tgl_bk', [$from, $to." 23:59"])->latest()->get();
            $filter = true;
            $from = $request->from;
            $to = $request->to;
        }

        return view('pages.laporan.laporan-periode', compact("title", "data", "filter", "from", "to"));
    }

    public function laporanPeriodeCetak($from = null, $to = null)
    {
        if ($from == null || $to == null) {
            abort(404);
        }

        $data = ManajemenDataBk::whereBetween('tgl_bk', [$from, $to." 23:59"])->latest()->get();
        $kepsek = KepalaSekolah::first();

        $pdf = PDF::loadView('pages.laporan.pdf.laporan', [
            'data' => $data,
            'from' => $from,
            'to' => $to,
            'kepsek' => $kepsek
        ])
        ->setPaper('a4', 'landscape')
        ->setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
        return $pdf->stream('laporan.pdf');
    }

    public function laporanSiswa(Request $request)
    {
        $title = "Laporan Siswa";
        $filter = false;
        $from = null;
        $to = null;
        $siswa = Siswa::get();
        $siswaId = null;

        $data = array();
        if ($request->isMethod('post')) {
            $from = date('Y-m-d', strtotime($request->from));
            $to = date('Y-m-d', strtotime($request->to));
            $data = ManajemenDataBk::where('siswa_id', $request->siswa_id)
            ->whereBetween('tgl_bk', [$from, $to." 23:59"])
            ->latest()
            ->get();

            $filter = true;
            $from = $request->from;
            $to = $request->to;
            $siswaId = $request->siswa_id;
        }

        return view('pages.laporan.laporan-siswa', compact("title", "data", "filter", "from", "to", "siswa", "siswaId"));
    }

    public function laporanSiswaCetak($from = null, $to = null, $siswa_id = null)
    {
        if ($from == null || $to == null || $siswa_id == null) {
            abort(404);
        }

        $data = ManajemenDataBk::whereBetween('tgl_bk', [$from, $to." 23:59"])
        ->where('siswa_id', $siswa_id)
        ->latest()
        ->get();
        $kepsek = KepalaSekolah::first();

        $pdf = PDF::loadView('pages.laporan.pdf.laporan', [
            'data' => $data,
            'from' => $from,
            'to' => $to,
            'kepsek' => $kepsek
        ])
        ->setPaper('a4', 'landscape')
        ->setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
        return $pdf->stream('laporan.pdf');
    }

    public function laporanJenis(Request $request)
    {
        $title = "Laporan Jenis";
        $filter = false;
        $from = null;
        $to = null;
        $jenis = $request->jenis;

        $data = array();
        if ($request->isMethod('post')) {
            $from = date('Y-m-d', strtotime($request->from));
            $to = date('Y-m-d', strtotime($request->to));
            $data = ManajemenDataBk::where('jenis', $request->jenis)
            ->whereBetween('tgl_bk', [$from, $to." 23:59"])
            ->latest()
            ->get();

            $filter = true;
            $from = $request->from;
            $to = $request->to;
        }

        return view('pages.laporan.laporan-jenis', compact("title", "data", "filter", "from", "to", "jenis"));
    }

    public function laporanJenisCetak($from = null, $to = null, $jenis = null)
    {
        if ($from == null || $to == null || $jenis == null) {
            abort(404);
        }

        $data = ManajemenDataBk::whereBetween('tgl_bk', [$from, $to." 23:59"])
        ->where('jenis', $jenis)
        ->latest()
        ->get();
        $kepsek = KepalaSekolah::first();

        $pdf = PDF::loadView('pages.laporan.pdf.laporan', [
            'data' => $data,
            'from' => $from,
            'to' => $to,
            'kepsek' => $kepsek
        ])
        ->setPaper('a4', 'landscape')
        ->setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
        return $pdf->stream('laporan.pdf');
    }

}
