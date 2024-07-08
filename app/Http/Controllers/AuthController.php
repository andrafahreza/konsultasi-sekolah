<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        try {
            $credentials = $request->validate([
                "username" => 'required',
                "password" => 'required'
            ]);

            if (Auth::attempt($credentials)) {
                if (!auth()->user()->status) {
                    throw new \Exception("Akun anda masih dinonaktifkan, silahkan hubungi administrator untuk mengaktifkan akun anda");
                }

                $request->session()->regenerate();
                return redirect()->intended("home");
            }

            throw new \Exception("Username atau password salah");

        } catch (\Throwable $th) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->back()->withErrors(['message' => $th->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function daftar()
    {
        return view('daftar');
    }

    public function prosesDaftar(Request $request)
    {
        DB::beginTransaction();

        try {
            $cekNik = User::where('username', $request->nik)->first();
            if (!empty($cekNik)) {
                throw new \Exception("Siswa dengan nik $request->nik sudah pernah terdaftar");
            }

            if ($request->password != $request->confirm_password) {
                throw new \Exception("Password dan konfirmasi password harus sama");
            }

            $dataUser = [
                "username" => $request->nik,
                "password" => Hash::make($request->password),
                "status" => 0,
                "tipe" => "siswa"
            ];

            $dataSiswa = [
                "nik" => $request->nik,
                "nama_lengkap" => $request->nama_lengkap,
                // "tempat_lahir" => $request->tempat_lahir,
                // "tgl_lahir" => $request->tgl_lahir,
                // "agama" => $request->agama,
                // "golongan_darah" => $request->golongan_darah,
                // "alamat" => $request->alamat,
                // "telepon" => $request->telepon,
                // "sekolah_asal" => $request->sekolah_asal,
                // "diterima_sebagai" => "siswa",
                // "tahun_terima" => $request->tahun_terima,
                // "hobi" => $request->hobi,
                // "nama_ayah" => $request->nama_ayah,
                // "tempat_lahir_ayah" => $request->tempat_lahir_ayah,
                // "tgl_lahir_ayah" => $request->tgl_lahir_ayah,
                // "pekerjaan_ayah" => $request->pekerjaan_ayah,
                // "agama_ayah" => $request->agama_ayah,
                // "nama_ibu" => $request->nama_ibu,
                // "tempat_lahir_ibu" => $request->tempat_lahir_ibu,
                // "tgl_lahir_ibu" => $request->tgl_lahir_ibu,
                // "pekerjaan_ibu" => $request->pekerjaan_ibu,
                // "agama_ibu" => $request->agama_ibu,
                // "alamat_ortu" => $request->alamat_ortu,
                // "telepon_ortu" => $request->telepon_ortu,
            ];

            $user = User::create($dataUser);
            if (!$user->save()) {
                throw new \Exception("Gagal menambahkan user");
            }

            $dataSiswa["pengguna_id"] = $user->id;
            $siswa = Siswa::create($dataSiswa);
            if (!$siswa->save()) {
                throw new \Exception("Terjadi kesalahan saat mendaftarkan siswa");
            }

            DB::commit();

            return redirect()->route('login')->with("success", "Berhasil mendaftar, silahkan tunggu administrator untuk memverifikasi akun anda");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $th->getMessage()]);
        }
    }
}
