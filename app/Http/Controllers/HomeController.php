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

        return view('pages.home', compact("title", "siswa", "konselor", "bk"));
    }
}
