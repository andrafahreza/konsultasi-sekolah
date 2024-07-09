<?php

namespace App\Http\Controllers;

use App\Models\Konselor;
use App\Models\ManajemenDataBk;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManajemenDataBkController extends Controller
{
    public function dataBk()
    {
        $title = "Data Bk";
        $data = ManajemenDataBk::whereNull('isi')
        ->whereNull('tindakan')
        ->where('batas_waktu', '>=', date('Y-m-d H:i:s'))
        ->latest()
        ->get();
        $siswa = Siswa::get();
        $konselor = Konselor::get();

        return view('pages.data-bk', compact('title', 'data', 'siswa', 'konselor'));
    }

    public function simpanBk(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $cekBk = ManajemenDataBk::where('siswa_id', $request->siswa_id)
            ->whereDate('tgl_bk', '=', $request->tgl_bk)
            ->first();
            if (!empty($cekBk)) {
                throw new \Exception("Siswa tersebut sudah mempunyai jadwal pada tanggal". date('d-m-Y', strtotime($request->tgl_bk)));
            }

            $data = [
                "siswa_id" => $request->siswa_id,
                "konselor_id" => $request->konselor_id,
                "tgl_bk" => $request->tgl_bk,
                "batas_waktu" => $request->batas_waktu,
                "jenis" => $request->jenis,
            ];

            if ($id != null) {
                $bk = ManajemenDataBk::find($id);
                if (empty($bk)) {
                    throw new \Exception("Data Bk tidak ditemukan");
                }

                if (!$bk->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data bk");
                }
            } else {
                $bk = ManajemenDataBk::create($data);
                if (!$bk->save()) {
                    throw new \Exception("Gagal menambahkan data bk");
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data bk");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function showBk($id = null)
    {
        $data = ManajemenDataBk::find($id);
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

    public function hapusBk(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = ManajemenDataBk::find($request->id);

            if (!$data->delete()) {
                throw new \Exception("Gagal menghapus data bk");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data bk");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // History
    public function historyBk()
    {
        $title = "History Bk";

        $user = Auth::user();
        $data = ManajemenDataBk::where('batas_waktu', '<=', date('Y-m-d H:i:s'))
        ->where(function ($query) use ($user) {
            if ($user->tipe == "orangtua") {
                $query->where('siswa_id', $user->orangtua->siswa_id);
            } else if ($user->tipe == "siswa") {
                $query->where('siswa_id', $user->siswa->id);
            } else if ($user->tipe == "konselor") {
                $query->where('konselor_id', $user->konselor->id);
            }
        })
        ->latest()
        ->get();

        return view('pages.history-bk', compact('title', 'data'));
    }
}
