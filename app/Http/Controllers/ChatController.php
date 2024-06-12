<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\IsiChat;
use App\Models\ManajemenDataBk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ChatController extends Controller
{
    public function list()
    {
        $user = Auth::user();
        $bkId = ManajemenDataBk::select('id')
        ->where(function($query) use($user) {
            if ($user->tipe == "konselor") {
                $query->where('konselor_id', $user->konselor->id);
            } else if ($user->tipe == "siswa") {
                $query->where('siswa_id', $user->siswa->id);
            } else if ($user->tipe == "orangtua") {
                $query->where('siswa_id', $user->orangtua->siswa_id);
            }
        })
        ->get();

        $data = Chat::whereIn('manajemen_data_bk_id', $bkId)->latest()->get();
        $title = "Chat";

        return view('pages.list-chat', compact("title", "data"));
    }

    public function history($id = null)
    {
        $chat = Chat::find($id);
        if (empty($chat)) {
            abort(404);
        }

        $bk = ManajemenDataBk::find($chat->manajemen_data_bk_id);
        $title = "History Chat";
        $photo = null;

        if (Auth::user()->tipe == "konselor" || Auth::user()->tipe == "admin" || Auth::user()->tipe == "orangtua" || Auth::user()->tipe == "kepala_sekolah") {
            $nama = $bk->siswa->nama_lengkap;
            $photo = $bk->siswa->pengguna->photo;
        } else if (Auth::user()->tipe == "siswa") {
            $nama = $bk->konselor->nama_konselor;
            $photo = $bk->konselor->pengguna->photo;
        }

        return view('pages.history-chat', compact("chat", "title", "nama", "photo"));
    }

    public function start($id = null)
    {
        $bk = ManajemenDataBk::find($id);
        if (empty($bk)) {
            abort(404);
        }

        $chat = Chat::where('manajemen_data_bk_id', $id)->first();
        if (empty($chat)) {
            $chat = Chat::create([
                "id" => Uuid::uuid4()->getHex(),
                "manajemen_data_bk_id" => $id,
                "status_chat" => "active"
            ]);
        }

        if ($chat->status_chat == "nonactive") {
            return redirect()->route('list-chat');
        }

        $title = "Chat";
        $photo = null;

        if (Auth::user()->tipe == "konselor") {
            $nama = $bk->siswa->nama_lengkap;
            $photo = $bk->siswa->pengguna->photo;
        } else if (Auth::user()->tipe == "siswa") {
            $nama = $bk->konselor->nama_konselor;
            $photo = $bk->konselor->pengguna->photo;
        }

        return view('pages.start-chat', compact("title", "chat", "nama", "photo"));
    }

    public function get($id = null)
    {
        $data = Chat::find($id);
        if ($data == null || $id == null) {
            abort(404);
        }

        try {
            $isi = "";
            $isiChat = IsiChat::where('chat_id', $id)->orderBy('created_at')->get();
            foreach ($isiChat as $key => $value) {
                if (Auth::user()->tipe != "admin") {
                    if ($value->pengguna_id == Auth::user()->id) {
                        $isi .= '<li class="chat-list right" id="chat-list-'.$key.'">
                            <div class="conversation-list">
                                <div class="user-chat-content">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <p class="mb-0 ctext-content">'.$value->isi_chat.'</p>
                                        </div>
                                    </div>
                                    <div class="conversation-name">
                                        <small class="text-muted time">'.date('H:i', strtotime($value->created_at)).'</small>
                                        <span class="text-success check-message-icon">
                                            <i class="bx bx-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>';
                    } else {
                        $isi .= '<li class="chat-list left" id="chat-list-'.$key.'">
                            <div class="conversation-list">
                                <div class="user-chat-content">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <p class="mb-0 ctext-content">'.$value->isi_chat.'</p>
                                        </div>
                                    </div>
                                    <div class="conversation-name">
                                        <small class="text-muted time">'.date('H:i', strtotime($value->created_at)).'</small>
                                        <span class="text-success check-message-icon">
                                            <i class="bx bx-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>';
                    }
                } else {
                    if ($value->user->tipe == "konselor") {
                        $isi .= '<li class="chat-list right" id="chat-list-'.$key.'">
                            <div class="conversation-list">
                                <div class="user-chat-content">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <p class="mb-0 ctext-content">'.$value->isi_chat.'</p>
                                        </div>
                                    </div>
                                    <div class="conversation-name">
                                        <small class="text-muted time">'.date('H:i', strtotime($value->created_at)).'</small>
                                        <span class="text-success check-message-icon">
                                            <i class="bx bx-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>';
                    } else {
                        $isi .= '<li class="chat-list left" id="chat-list-'.$key.'">
                            <div class="conversation-list">
                                <div class="user-chat-content">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <p class="mb-0 ctext-content">'.$value->isi_chat.'</p>
                                        </div>
                                    </div>
                                    <div class="conversation-name">
                                        <small class="text-muted time">'.date('H:i', strtotime($value->created_at)).'</small>
                                        <span class="text-success check-message-icon">
                                            <i class="bx bx-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>';
                    }
                }
            }

            return response()->json([
                'alert' => 1,
                'data' => $isi
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'alert' => 0
            ]);
        }
    }

    public function send(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Chat::find($request->id);
            if (empty($data)) {
                abort(404);
            }

            if ($data->status_chat == "nonactive") {
                throw new \Exception("Sesi telah berakhir");
            }

            $isiChat = IsiChat::create([
                "id" => Uuid::uuid4()->getHex(),
                "chat_id" => $request->id,
                "pengguna_id" => Auth::user()->id,
                "isi_chat" => $request->isi_chat
            ]);

            if (!$isiChat->save()) {
                throw new \Exception("Gagal");
            }

            DB::commit();

            return response()->json([
                'alert' => 1,
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'alert' => 0,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function end(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = ManajemenDataBk::find($request->id);
            $data->isi = $request->isi;
            $data->tindakan = $request->tindakan;

            if (!$data->update()) {
                throw new \Exception("Terjadi kesalahan");
            }

            $chat = Chat::where('manajemen_data_bk_id', $request->id)->first();
            $chat->status_chat = "nonactive";

            if (!$data->update()) {
                throw new \Exception("Terjadi kesalahan");
            }

            DB::commit();

            return redirect()->route('list-chat')->with("success", "Berhasil mengakhiri konsultasi");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('list-chat')->withErrors($th->getMessage());
        }
    }
}
