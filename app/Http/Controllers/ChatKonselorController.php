<?php

namespace App\Http\Controllers;

use App\Models\ChatKonselor;
use App\Models\IsiChatKonselor;
use App\Models\Konselor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ChatKonselorController extends Controller
{
    public function list()
    {
        $title = "Chat Konselor";
        $user = Auth::user();
        $data = ChatKonselor::where(function($query) use($user) {
            if ($user->tipe == "orangtua") {
                $query->where('orangtua_id', $user->id);
            } else {
                $query->where('konselor_id', $user->id);
            }
        })
        ->get();

        $konselor = Konselor::get();

        return view('pages.list-chat-konselor', compact('title', 'data', 'konselor'));
    }

    public function add(Request $request)
    {
        DB::beginTransaction();

        try {
            $konselor = Konselor::find($request->konselor_id);
            if (!$konselor) {
                throw new \Exception("Konselor tidak ditemukan");
            }

            $checkData = ChatKonselor::where('orangtua_id', Auth::user()->id)
            ->where('konselor_id', $konselor->pengguna->id)
            ->first();
            if ($checkData) {
                throw new \Exception("Anda sudah pernah membuat chat dengan konselor $konselor->nama_konselor");
            }

            $data = ChatKonselor::create([
                "id" => Uuid::uuid4()->getHex(),
                "orangtua_id" => Auth::user()->id,
                "konselor_id" => $konselor->pengguna->id
            ]);

            if (!$data->save()) {
                throw new \Exception("Terjadi kesalahan saat menyimpan data");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data chat");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function chat($id = null)
    {
        $title = "Chat Konselor";
        $chat = ChatKonselor::find($id);
        if (empty($chat)) {
            abort(404);
        }

        if (Auth::user()->tipe == "konselor") {
            $nama = $chat->orangtua->orangtua->nama;
        } else if (Auth::user()->tipe == "orangtua") {
            $nama = $chat->konselor->konselor->nama_konselor;
        }

        return view('pages.start-chat-konselor', compact('title', 'chat', 'nama'));
    }

    public function get($id = null)
    {
        $data = ChatKonselor::find($id);
        if ($data == null || $id == null) {
            abort(404);
        }

        try {
            $isi = "";
            $isiChat = IsiChatKonselor::where('chat_konselor_id', $id)->orderBy('created_at')->get();
            foreach ($isiChat as $key => $value) {
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
            $data = ChatKonselor::find($request->id);
            if (empty($data)) {
                abort(404);
            }

            $isiChat = IsiChatKonselor::create([
                "id" => Uuid::uuid4()->getHex(),
                "chat_konselor_id" => $request->id,
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
}
