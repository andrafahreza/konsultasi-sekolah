<?php

namespace App\Http\Controllers;

use App\Models\KepalaSekolah;
use App\Models\Konselor;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function pengguna()
    {
        $title = "Pengguna";
        $data = User::latest()->get();

        return view("pages.pengguna", compact("title", "data"));
    }

    public function ubahStatus(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = User::find($request->id);
            if (empty($data)) {
                throw new \Exception("Pengguna tidak ditemukan");
            }

            $data->status = $data->status == 1 ? 0 : 1;

            if (!$data->update()) {
                throw new \Exception("Terjadi kesalahan dalam memperbarui data");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil memperbarui data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // Siswa
    public function siswa()
    {
        $title = "Siswa";
        $data = User::where('tipe', 'siswa')
        ->where('status', 1)
        ->latest()
        ->get();

        return view('pages.siswa', compact("title", "data"));
    }

    public function simpanSiswa(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $dataUser = [
                "username" => $request->nik,
                "tipe" => "siswa"
            ];

            $dataSiswa = [
                "nik" => $request->nik,
                "nama_lengkap" => $request->nama_lengkap,
                "tempat_lahir" => $request->tempat_lahir,
                "tgl_lahir" => $request->tgl_lahir,
                "agama" => $request->agama,
                "golongan_darah" => $request->golongan_darah,
                "alamat" => $request->alamat,
                "telepon" => $request->telepon,
                "sekolah_asal" => $request->sekolah_asal,
                "diterima_sebagai" => $request->diterima_sebagai,
                "tahun_terima" => $request->tahun_terima,
                "hobi" => $request->hobi,
                "nama_ayah" => $request->nama_ayah,
                "tempat_lahir_ayah" => $request->tempat_lahir_ayah,
                "tgl_lahir_ayah" => $request->tgl_lahir_ayah,
                "pekerjaan_ayah" => $request->pekerjaan_ayah,
                "agama_ayah" => $request->agama_ayah,
                "nama_ibu" => $request->nama_ibu,
                "tempat_lahir_ibu" => $request->tempat_lahir_ibu,
                "tgl_lahir_ibu" => $request->tgl_lahir_ibu,
                "pekerjaan_ibu" => $request->pekerjaan_ibu,
                "agama_ibu" => $request->agama_ibu,
                "alamat_ortu" => $request->alamat_ortu,
                "telepon_ortu" => $request->telepon_ortu,
            ];

            if ($id != null) {
                $user = User::find($id);
                if (empty($user)) {
                    throw new \Exception("User tidak ditemukan");
                }

                if (!$user->update($dataUser)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui user");
                }

                $siswa = Siswa::where('pengguna_id', $user->id)->first();
                if (empty($siswa)) {
                    throw new \Exception("Siswa tidak ditemukan");
                }

                $dataSiswa["pengguna_id"] = $user->id;
                if (!$siswa->update($dataSiswa)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui siswa");
                }
            } else {
                $cekNik = User::where('username', $request->nik)->first();
                if (!empty($cekNik)) {
                    throw new \Exception("Siswa dengan nik $request->nik sudah pernah terdaftar");
                }

                $dataUser['password'] = Hash::make($request->nik);
                $dataUser['status'] = 1;

                $user = User::create($dataUser);
                if (!$user->save()) {
                    throw new \Exception("Gagal menambahkan user");
                }

                $dataSiswa["pengguna_id"] = $user->id;
                $siswa = Siswa::create($dataSiswa);
                if (!$siswa->save()) {
                    throw new \Exception("Terjadi kesalahan saat mendaftarkan siswa");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan siswa");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function showSiswa($id = null)
    {
        $data = User::with('siswa')->find($id);
        if ($data == null || $id == null) {
            abort(404);
        }

        try {
            return response()->json([
                'alert' => 1,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json([
                'alert' => 0,
                'message' => "Terjadi kesalahan: $message"
            ]);
        }
    }

    // Orang Tua
    public function orangTua($id = null)
    {
        try {
            $title = "Siswa";
            $user = User::find($id);
            if (empty($user)) {
                throw new \Exception("Siswa tidak ditemukan");
            }

            $getId = OrangTua::select('pengguna_id')
            ->where('siswa_id', $user->siswa->id)
            ->latest()
            ->get();

            $data = User::whereIn('id', $getId)->get();

            return view('pages.orang-tua', compact("title", "data", "user"));

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function simpanOrangTua(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $cekUsername = User::where('username', $request->username)
            ->where(function($query) use($id) {
                if ($id) {
                    $query->whereNot('id', $id);
                }
            })
            ->first();
            if (!empty($cekUsername)) {
                throw new \Exception("User dengan username $request->username sudah pernah terdaftar");
            }

            $dataUser = [
                "username" => $request->username,
                "password" => Hash::make($request->password),
                "status" => 1,
                "tipe" => "orangtua"
            ];

            $dataOrangTua = [
                "siswa_id" => $request->siswa_id,
                "nama" => $request->nama,
                "agama" => $request->agama,
                "alamat" => $request->alamat,
                "telepon" => $request->telepon,
            ];

            if ($id != null) {
                $user = User::find($id);
                if (empty($user)) {
                    throw new \Exception("User tidak ditemukan");
                }

                if (!$user->update($dataUser)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui user");
                }

                $orangTua = OrangTua::where('pengguna_id', $user->id)->first();
                if (empty($orangTua)) {
                    throw new \Exception("Data orang tua tidak ditemukan");
                }

                $dataOrangTua["pengguna_id"] = $user->id;
                if (!$orangTua->update($dataOrangTua)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data orang tua");
                }
            } else {
                $user = User::create($dataUser);
                if (!$user->save()) {
                    throw new \Exception("Gagal menambahkan user");
                }

                $dataOrangTua["pengguna_id"] = $user->id;
                $orangTua = OrangTua::create($dataOrangTua);
                if (!$orangTua->save()) {
                    throw new \Exception("Terjadi kesalahan saat mendaftarkan orang tua");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan orang tua");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function showOrangTua($id = null)
    {
        $data = User::with('orangtua')->find($id);
        if ($data == null || $id == null) {
            abort(404);
        }

        try {
            return response()->json([
                'alert' => 1,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json([
                'alert' => 0,
                'message' => "Terjadi kesalahan: $message"
            ]);
        }
    }

    public function hapusOrangTua(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = User::find($request->id);

            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // Kepala Sekolah
    public function kepalaSekolah()
    {
        $title = "Kepala Sekolah";
        $data = KepalaSekolah::first();
        $agama = null;
        $alamat = null;
        $telepon = null;

        if (!empty($data)) {
            $agama = $data->agama;
            $alamat = $data->alamat;
            $telepon = $data->telepon;
        }

        return view('pages.kepala-sekolah', compact("title", "data", "agama", "alamat", "telepon"));
    }

    public function simpanKepalaSekolah(Request $request)
    {
        DB::beginTransaction();

        try {
            $dataUser = [
                "username" => $request->username,
                "status" => 1,
                "tipe" => "kepala_sekolah"
            ];

            if ($request->password != null) {
                $dataUser['password'] = Hash::make($request->password);
            }

            $dataKepalaSekolah = [
                "nip" => $request->nip,
                "nama" => $request->nama,
                "agama" => $request->agama,
                "alamat" => $request->alamat,
                "telepon" => $request->telepon,
            ];

            $kepalaSekolah = KepalaSekolah::first();
            if (!empty($kepalaSekolah)) {
                $user = User::find($kepalaSekolah->pengguna_id);
                if (empty($user)) {
                    throw new \Exception("User tidak ditemukan");
                }

                $cekUsername = User::where('username', $request->username)->where('id', '!=', $kepalaSekolah->pengguna_id)->first();
                if (!empty($cekUsername)) {
                    throw new \Exception("User dengan username $request->username sudah pernah terdaftar");
                }

                if (!$user->update($dataUser)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui user");
                }

                $dataKepalaSekolah["pengguna_id"] = $user->id;
                if (!$kepalaSekolah->update($dataKepalaSekolah)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data kepala sekolah");
                }
            } else {
                $user = User::create($dataUser);
                if (!$user->save()) {
                    throw new \Exception("Gagal menambahkan user");
                }

                $dataKepalaSekolah["pengguna_id"] = $user->id;
                $kepalaSekolah = KepalaSekolah::create($dataKepalaSekolah);
                if (!$kepalaSekolah->save()) {
                    throw new \Exception("Terjadi kesalahan saat mendaftarkan kepala sekolah");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan kepala sekolah");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // Konselor
    public function konselor()
    {
        $title = "Konselor";
        $data = User::where('tipe', 'konselor')->latest()->get();

        return view('pages.konselor', compact("title", "data"));
    }

    public function simpanKonselor(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $cekNip = User::where('username', $request->nip)->first();
            if (!empty($cekNip)) {
                throw new \Exception("Konselor dengan nip $request->nip sudah pernah terdaftar");
            }

            $dataUser = [
                "username" => $request->nip,
                "password" => Hash::make($request->nip),
                "status" => 1,
                "tipe" => "konselor"
            ];

            $dataKonselor = [
                "nip" => $request->nip,
                "nama_konselor" => $request->nama_konselor,
                "agama_konselor" => $request->agama_konselor,
                "alamat_konselor" => $request->alamat_konselor,
                "telepon_konselor" => $request->telepon_konselor,
            ];

            if ($id != null) {
                $user = User::find($id);
                if (empty($user)) {
                    throw new \Exception("User tidak ditemukan");
                }

                if (!$user->update($dataUser)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui user");
                }

                $konselor = Konselor::where('pengguna_id', $user->id)->first();
                if (empty($konselor)) {
                    throw new \Exception("Konselor tidak ditemukan");
                }

                $dataKonselor["pengguna_id"] = $user->id;
                if (!$konselor->update($dataKonselor)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui konselor");
                }
            } else {
                $user = User::create($dataUser);
                if (!$user->save()) {
                    throw new \Exception("Gagal menambahkan user");
                }

                $dataKonselor["pengguna_id"] = $user->id;
                $konselor = Konselor::create($dataKonselor);
                if (!$konselor->save()) {
                    throw new \Exception("Terjadi kesalahan saat mendaftarkan konselor");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan konselor");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function showKonselor($id = null)
    {
        $data = User::with('konselor')->find($id);
        if ($data == null || $id == null) {
            abort(404);
        }

        try {
            return response()->json([
                'alert' => 1,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json([
                'alert' => 0,
                'message' => "Terjadi kesalahan: $message"
            ]);
        }
    }

    // PROFILE
    public function profile()
    {
        $title = "Profile";
        $nama = "Administrator";
        $agama = null;
        $alamat = null;
        $telepon = null;

        if (Auth::user()->tipe == "siswa") {
            $nama = Auth::user()->siswa->nama_lengkap;
            $agama = Auth::user()->siswa->agama;
            $alamat = Auth::user()->siswa->alamat;
            $telepon = Auth::user()->siswa->telepon;
        } else if (Auth::user()->tipe == "konselor") {
            $nama = Auth::user()->konselor->nama_konselor;
            $agama = Auth::user()->konselor->agama_konselor;
            $alamat = Auth::user()->konselor->alamat_konselor;
            $telepon = Auth::user()->konselor->telepon_konselor;
        } else if (Auth::user()->tipe == "orangtua") {
            $nama = Auth::user()->orangTua->nama;
            $agama = Auth::user()->orangTua->agama;
            $alamat = Auth::user()->orangTua->alamat;
            $telepon = Auth::user()->orangTua->telepon;
        }

        return view('pages.profile', compact("title", "nama", "agama", "alamat", "telepon"));
    }

    public function simpanProfile(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Auth::user();
            if ($data->tipe == "siswa") {
                $siswa = Siswa::where('pengguna_id', $data->id)->first();

                if (empty($siswa)) {
                    throw new \Exception("Data siswa tidak ditemukan");
                }

                $siswa->nama_lengkap = $request->nama;
                $siswa->agama = $request->agama;
                $siswa->alamat = $request->alamat;
                $siswa->telepon = $request->telepon;

                if (!$siswa->update()) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data siswa");
                }
            } else  if ($data->tipe == "konselor") {
                $konselor = Konselor::where('pengguna_id', $data->id)->first();

                if (empty($konselor)) {
                    throw new \Exception("Data konselor tidak ditemukan");
                }

                $konselor->nama_konselor = $request->nama;
                $konselor->agama_konselor = $request->agama;
                $konselor->alamat_konselor = $request->alamat;
                $konselor->telepon_konselor = $request->telepon;

                if (!$konselor->update()) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data konselor");
                }
            } else if ($data->tipe == "orangtua") {
                $orangTua = OrangTua::where('pengguna_id', $data->id)->first();

                if (empty($orangTua)) {
                    throw new \Exception("Data orang tua tidak ditemukan");
                }

                $orangTua->nama = $request->nama;
                $orangTua->agama = $request->agama;
                $orangTua->alamat = $request->alamat;
                $orangTua->telepon = $request->telepon;

                if (!$orangTua->update()) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data orang tua");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil memperbarui data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function gantiPassword(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $checkOldPassword = Hash::check($request->old_password, $user->password);
            if (!$checkOldPassword) {
                throw new \Exception("Password lama salah");
            }

            if ($request->new_password != $request->konfirmasi_password) {
                throw new \Exception("Password baru dan konfirmasi password harus sama");
            }

            $user->password = Hash::make($request->new_password);

            if (!$user->update()) {
                throw new \Exception("Terjadi kesalahan saat memperbarui password");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil memperbarui password");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function gantiPhoto(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $imageName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('/'), $imageName);

            $data = Auth::user();
            $data->photo = "/$imageName";

            if (!$data->update()) {
                throw new \Exception("Terjadi kesalahan saat memperbarui photo");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data jadwal");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // Verifikasi Siswa
    public function verifikasi()
    {
        $title = "Verifikasi Siswa";
        $data = User::where('tipe', 'siswa')
        ->where('status', 0)
        ->latest()
        ->get();

        return view('pages.verifikasi-siswa', compact('title', 'data'));
    }

    public function verifikasiSiswa(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = User::find($request->id);
            if (empty($user)) {
                throw new \Exception("User tidak ditemukan");
            }

            $user->status = true;
            if (!$user->update()) {
                throw new \Exception("Terjadi kesalahan saat memperbarui user");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil memverifikasi siswa");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
