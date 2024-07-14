<?php

namespace App\Http\Controllers;

use App\Models\Konselor;
use App\Models\ManajemenDataBk;
use App\Models\Siswa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $siswa = Siswa::get();
        $konselor = Konselor::get();

        return view('index', compact('siswa', 'konselor'));
    }

    public function home()
    {
        $title = "Halaman Utama";
        $siswa = Siswa::get();
        $konselor = Konselor::get();
        $bk = ManajemenDataBk::whereNull('isi')
        ->whereNull('tindakan')
        ->latest()
        ->get();

        $laki = array();
        $perempuan = array();
        for ($i=1; $i <= 12; $i++) {
            $data = ManajemenDataBk::whereMonth('tgl_bk', $i)->get();

            $hitungLaki = 0;
            $hitungPerempuan = 0;
            foreach ($data as $key => $value) {
                if ($value->siswa->jenis_kelamin == "Laki-Laki") {
                    $hitungLaki += 1;
                } else {
                    $hitungPerempuan += 1;
                }
            }

            array_push($laki, $hitungLaki);
            array_push($perempuan, $hitungPerempuan);
        }

        return view('pages.home', compact("title", "siswa", "konselor", "bk", 'laki', 'perempuan'));
    }
}
