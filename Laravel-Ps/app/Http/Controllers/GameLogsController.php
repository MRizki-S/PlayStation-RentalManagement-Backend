<?php

namespace App\Http\Controllers;

use App\Models\GameLogs;
use App\Models\PlayStation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;

class GameLogsController extends Controller
{
    public function index() {
        $gameLogs = GameLogs::with(['playStation'])
                        ->where("status_permainan", "berakhir")->get();

        return response()->json(
            $gameLogs
        );
    }
    public function store(Request $request) {
        $request->validate([
            'ps_id' => ['required'],
            'start_time' => ['required'],
            'status_permainan' => ['required']
        ]);

        // mendapatkan price dari ps yang dimainkan
        $psDiMainkan = PlayStation::findOrFail($request->ps_id);

        // jika ada waktu berakhirnya
        if($request->has('time_ends')) {
            // dd('ada waktu berakhirnya');
            $startTimePlay = Carbon::parse($request->start_time);
            $timeEndPlay = Carbon::parse($request->time_ends);

            $selisihDurasi = $startTimePlay->diff($timeEndPlay);
            // dd($selisihDurasi);

            // jika selisih durasinya ada jamnya, maka
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
            // dd($request['total_price']);
            $gameLogsStore = GameLogs::create($request->all());
        }else {
            $gameLogsStore = GameLogs::create($request->all());
        }

        // jika berhasil ditambahkan
        if($gameLogsStore) {
            return response()->json([
                'addData' => $gameLogsStore,
                'message' => 'Data berhasil ditambahkan'
            ], 200);
        }

    }
}
