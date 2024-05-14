<?php

namespace App\Http\Controllers;

use App\Models\ManajemenDataBk;
use App\Models\Siswa;
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
            $data = ManajemenDataBk::whereBetween('tgl_bk', [$from, $to])->latest()->get();
            $filter = true;
            $from = $request->from;
            $to = $request->to;
        }

        return view('pages.laporan.laporan-periode', compact("title", "data", "filter", "from", "to"));
    }

    public function laporanSiswa(Request $request)
    {
        $title = "Laporan Siswa";
        $filter = false;
        $from = null;
        $to = null;
        $siswa = Siswa::get();

        $data = array();
        if ($request->isMethod('post')) {
            $from = date('Y-m-d', strtotime($request->from));
            $to = date('Y-m-d', strtotime($request->to));
            $data = ManajemenDataBk::where('siswa_id', $request->siswa_id)
            ->whereBetween('tgl_bk', [$from, $to])
            ->latest()
            ->get();

            $filter = true;
            $from = $request->from;
            $to = $request->to;
        }

        return view('pages.laporan.laporan-siswa', compact("title", "data", "filter", "from", "to", "siswa"));
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
            ->whereBetween('tgl_bk', [$from, $to])
            ->latest()
            ->get();

            $filter = true;
            $from = $request->from;
            $to = $request->to;
        }

        return view('pages.laporan.laporan-jenis', compact("title", "data", "filter", "from", "to", "jenis"));
    }

}
