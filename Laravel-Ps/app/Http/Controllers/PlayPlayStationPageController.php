<?php

namespace App\Http\Controllers;

use App\Models\GameLogs;
use App\Models\PlayStation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;

class PlayPlayStationPageController extends Controller
{
    public function index () {
        $PlayPs = GameLogs::with(['playStation'])
                        ->where("status_permainan", "bermain")->get();

        $PlayStationData = PlayStation::where("status", "inactive")->get();
        return response()->json([
            'DataGameLogs' => $PlayPs,
            'DataPlayStation' => $PlayStationData
        ]);
    }
    public function EndGame($id) {
        $ChangeStatusGameLogs = GameLogs::findOrFail($id);

        if($ChangeStatusGameLogs->time_ends && $ChangeStatusGameLogs->total_price ) {
            $ChangeStatusPlayStation = PlayStation::findOrFail($ChangeStatusGameLogs->ps_id);
            // dd($ChangeStatusPlayStation);
            $ChangeStatusPlayStation->status = 'inactive';
            $SaveChangePlayStation = $ChangeStatusPlayStation->save();

            $ChangeStatusGameLogs->status_permainan = 'berakhir';
            $SaveChangeGameLogs = $ChangeStatusGameLogs->save();
            if($SaveChangePlayStation &&  $SaveChangeGameLogs){
                return response()->json([
                    "message" => "Status permainan Berhasil Diubah!",
                ], 200);
            }
        }else {
            return response()->json([
                'message' => "Data tidak lengkap untuk mengubah status permainan!",
            ], 422);
        }

        // if(Auth::attempt($data)) {
        //     if(Auth::user()->email == 'admin@admin.com') {
        //         dd('email anda admin, test doang ini');
        //     }
        // }

    }
    public function store(Request $request) {
        $request->validate([
            'ps_id' => ['required'],
            'start_time' => ['required'],
        ]);

        // mendapatkan price dari ps yang dimainkan
        $psDiMainkan = PlayStation::findOrFail($request->ps_id);

        if($psDiMainkan->status == 'active') {
            return response()->json([
                'errotStatusPs' => 'Status Ps masih Active, tidak dapat bermain!'
            ]);
        }

        // jika ada waktu berakhirnya
        if($request->has('time_ends') && $request->time_ends !== null)  {
            // dd('ada waktu berakhirnya');
            $startTimePlay = Carbon::parse($request->start_time);
            $timeEndPlay = Carbon::parse($request->time_ends);

            $selisihDurasi = $startTimePlay->diff($timeEndPlay);
            // dd($selisihDurasi);

            // jika selisih durasinya ada jamnya, maka
            $priceDenganJam = 0;
            $priceDenganMenit = 0;
            if($selisihDurasi->h) {
                $priceDenganJam = $selisihDurasi->h * $psDiMainkan->price_perjam;
            }
            // jika selisih durasinya ada menitnya, maka
            if($selisihDurasi->i) {
                $hargaPerMenit = $psDiMainkan->price_perjam / 60;
                // dd($hargaPerMenit);

                // $priceDenganMenit = rtrim(round(320.1));
                // $priceDenganMenit = intval($priceDenganMenit);

                // membulatkan keterdekat
                $priceDenganMenit =round( $selisihDurasi->i * $hargaPerMenit);
                $priceDenganMenit = rtrim($priceDenganMenit);
                $priceDenganMenit = intval($priceDenganMenit);
            }
            $totalPrice = $priceDenganJam + $priceDenganMenit ;
            $request['total_price'] = $totalPrice;
            $request['status_permainan'] = 'bermain';
            // dd($request['total_price']);
            $gameLogsStore = GameLogs::create($request->all());
            $psDiMainkan->status = "active";
            $psDiMainkan->save();
        }else {
            $request['status_permainan'] = 'bermain';
            $gameLogsStore = GameLogs::create($request->all());

            $psDiMainkan->status = "active";
            $psDiMainkan->save();
        }

        // jika berhasil ditambahkan
        if($gameLogsStore) {
            return response()->json([
                'addData' => $gameLogsStore,
                'message' => 'Data berhasil ditambahkan'
            ], 200);
        }

    }

    public function update(Request $request, $id) {
        $request->validate([
            'start_time' => ['required']
        ]);

        $psDiMainkan = PlayStation::findOrFail($request->ps_id);

        if($request->has('time_ends') && $request->time_ends !== null)  {
            // dd('ada waktu berakhirnya');
            $startTimePlay = Carbon::parse($request->start_time);
            $timeEndPlay = Carbon::parse($request->time_ends);

            $selisihDurasi = $startTimePlay->diff($timeEndPlay);

            $priceDenganJam = 0;
            $priceDenganMenit = 0;
            // jika selisih durasinya ada jamnya, maka
            if($selisihDurasi->h) {
                $priceDenganJam = $selisihDurasi->h * $psDiMainkan->price_perjam;
            }
            // jika selisih durasinya ada menitnya, maka
            if($selisihDurasi->i) {
                $hargaPerMenit = $psDiMainkan->price_perjam / 60;

                // membulatkan keterdekat
                $priceDenganMenit =round( $selisihDurasi->i * $hargaPerMenit);
                $priceDenganMenit = rtrim($priceDenganMenit);
                $priceDenganMenit = intval($priceDenganMenit);
            }
            $totalPrice = $priceDenganJam + $priceDenganMenit ;
            $request['total_price'] = $totalPrice;
            // dd($request['total_price']);
            $GameLogsUpdate = GameLogs::findOrFail($id);
            $GameLogsUpdate->update($request->all());
        }else {
            $GameLogsUpdate = GameLogs::findOrFail($id);
            $GameLogsUpdate->update($request->all());
        }

        // jika berhasil ditambahkan
        if($GameLogsUpdate) {
            return response()->json([
                'updateData' => $GameLogsUpdate,
                'message' => 'Data berhasil diUbah!'
            ], 200);
        }
    }

    public function delete($id) {
        $gameLogsDelete = GameLogs::findOrFail($id);
        if($gameLogsDelete) {
            $psDimainkanStatus = PlayStation::findOrFail($gameLogsDelete->ps_id);
            // dd($psDimainkanStatus);
            $psDimainkanStatus->status = 'inactive';
            $psDimainkanStatus->save();

            $aksiDelete = $gameLogsDelete->delete();

            if($aksiDelete) {
                return response()->json([
                    'updateData' => $aksiDelete,
                    'message' => 'Data berhasil diHapus!'
                ], 200);
            }
        }
    }
}
