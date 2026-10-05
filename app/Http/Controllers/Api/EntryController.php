<?php

namespace App\Http\Controllers\Api;

use App\Entry;
use App\Order;
use App\Term;
use App\User;
use App\Http\Resources\EntryResource;
use App\Qrcode;
use App\UserPlan;
use App\UserTerm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntryController extends Controller
{

    const START_TIME = '07:00:00'; // Pocetak radnog vremena
    const START_TIME2 = '08:00:00'; // Pocetak radnog vremena subotom
    const END_TIME = '22:00:00';  // Kraj radnog vremena
    const END_TIME2 = '20:00:00'; // Kraj radnog vremena subotom
    const END_TIME3 = '16:00:00'; // Za teretanu i vezbace do 16:00

    public function index()
    {
        return EntryResource::collection(Entry::all());
    }

    public function checkEntry(Request $request)
    {
        $now = Carbon::now();
        $now2 = Carbon::now();
        $start = Carbon::createFromTimeString(self::START_TIME);
        $start2 = Carbon::createFromTimeString(self::START_TIME2);
        $end = Carbon::createFromTimeString(self::END_TIME);
        $end2 = Carbon::createFromTimeString(self::END_TIME2);
        $end3 = Carbon::createFromTimeString(self::END_TIME3);

        // JSON bodies are not visible to request()->get(); input() reads JSON, form, and query.
        $token = $request->input('token');

        // Gledamo da li postoji taj korisnik s tim tokenom ?
        $qcode = Qrcode::whereToken($token)->with('user')->first();

        if($qcode == null){
            return response()->json([
                'entry' => false,
                'active' => false,
                'payment' => false,
                'expired_time' => null,
                'user'=>null,
                'message' => 'NESIPRAVAN Qr Code.'
            ]);
        }

        // Da li je trener/admin
        if($qcode->user->hasRole('admin') || $qcode->user->hasRole('trener')){
            Entry::create([
                'user_id' => $qcode->user->id,
                'entry_time' => Carbon::now(),
                'type' => $qcode->user->hasRole('admin') || $qcode->user->hasRole('trener') ? 1 : 0,
                'message' => 'Admin/Trener je ušao.'
            ]);
              return response()->json([
                  'entry' => true,
                  'active' =>true,
                  'payment' => true,
                  'expired_time' => null,
                  'user' => $qcode->user,
                  'message' => 'Admin/Trener je ušao.'
              ]);
        }

        // Radno vreme teretane ?
        // RADNI DANI
        if(!$now->between($start, $end)  && $now->isSunday()){
              return response()->json([
                  'entry' => false,
                  'active' =>false,
                  'payment' => false,
                  'expired_time' => null,
                  'user' => $qcode->user,
                  'message' => 'Vreme je van radnog vremena radnim danima.'
              ]);
        }
        // SUBOTA
        if(!$now->between($start2, $end2) && $now->isSaturday()){
              return response()->json([
                  'entry' => false,
                  'active' =>false,
                  'payment' => false,
                  'expired_time' => null,
                  'user' => $qcode->user,
                  'message' => 'Vreme je van radnog vremena subotom.'
              ]);
        }

        // Da li mu je istekao paket i da li je na pauzi ?
        $userplan = UserPlan::where('user_id', $qcode->user->id)
            ->where('expired_time', '>=', $now)
            ->whereApproved(1)
            ->whereActive(1)
            ->where('pause_flag', 0)->latest()->get();

        // Ako nemamo aktivan plan?
        if(count($userplan) == 0) {
                Entry::create([
                    'user_id' => $qcode->user->id,
                    'entry_time' => Carbon::now(),
                    'type' => $qcode->user->hasRole('admin') || $qcode->user->hasRole('trener') ? 1 : 0,
                    'plan_status' => 1,
                    'payment_status' => count($userplan) > 0 && $userplan[0]->paid == 1 ? 0 : 1,
                    'message' => 'Nema aktivan plan.'
                ]);
              return response()->json([
                  'entry' => false,
                  'active' =>false,
                  'payment' => count($userplan) > 0 && $userplan[0]->paid == 1 ? true : false,
                  'expired_time' => null,
                  'user' => $qcode->user, 'message' => 'Nema aktivan plan.'
              ]);
        }

        // Ako ima samo teretanu do 16:00
        if(count($userplan) == 1 && $userplan->contains('plan_id', 55)) {
            $userplanLimit = $userplan->first(function($item) {
                return $item->plan_id == 55;
            });
            if( isset($userplanLimit) && !$now2->between($start, $end3) ){
                    Entry::create([
                        'user_id' => $qcode->user->id,
                        'entry_time' => Carbon::now(),
                        'type' => $qcode->user->hasRole('admin') || $qcode->user->hasRole('trener') ? 1 : 0,
                        'plan_status' => 0,
                        'payment_status' => count($userplan) > 0 && $userplan[0]->paid == 1 ? 0 : 1,
                        'message' => 'Vreme za teretanu je do 16:00.'
                    ]);
                  return response()->json([
                      'entry' => false,
                      'active' =>true,
                      'payment' => count($userplan) > 0 && $userplan[0]->paid == 1 ? true : false ,
                      'expired_time' => $userplan[0]->expired_time !== null ? $userplan[0]->expired_time->format('d.m.Y.') : null,
                      'user' => $qcode->user, 'message' => 'Vreme za teretanu je do 16:00.'
                  ]);
            }
        }

        // Ako ima neki drugi plan a da nije teretana i ako ima zakazano taj dan
        if(!$userplan->contains('plan_id', 55) && !$userplan->contains('plan_id', 56) && count($userplan) >= 1  ) {

            $terms = Term::whereBetween('start_datetime', [$now, $now2->endOfDay()])->with(['userTerms' => function($q) use ($qcode){
                $q->where('user_id',  $qcode->user->id)
                    ->where('user_delayed', 0);
            }])->get()->pluck('userTerms')->flatten();


            if(!count($terms) > 0){

                Entry::create([
                    'user_id' => $qcode->user->id,
                    'entry_time' => Carbon::now(),
                    'type' => $qcode->user->hasRole('admin') || $qcode->user->hasRole('trener') ? 1 : 0,
                    'payment_status' => count($userplan) > 0 && $userplan[0]->paid == 1 ? 0 : 1,
                    'message' => 'Nema zakazan termin za taj dan.'
                ]);

                  return response()->json([
                      'entry' => false,
                      'active' => true,
                      'payment' => count($userplan) > 0 && $userplan[0]->paid == 1 ? true : false,
                      'expired_time' => $userplan[0]->expired_time !== null ? $userplan[0]->expired_time->format('d.m.Y.') : null,
                      'user' => $qcode->user, 'message' => 'Nema zakazan termin za taj dan.']);
            }

        }

        // Da li je vec bio taj dan ?
        if(Entry::where('user_id', $qcode->user->id)->where('entry_time', '>=', $now->startOfDay())->exists()){

            Entry::create([
                'user_id' => $qcode->user->id,
                'entry_time' => Carbon::now(),
                'type' => $qcode->user->hasRole('admin') || $qcode->user->hasRole('trener') ? 1 : 0,
                'payment_status' => count($userplan) > 0 && $userplan[0]->paid == 1 ? 0 : 1,
                'message' => 'Već je bio taj dan.'
            ]);

            return response()->json([
                'entry' => false,
                'active' => true,
                'payment' => count($userplan) > 0 && $userplan[0]->paid == 1 ? true : false,
                'expired_time' => null,
                'user' => $qcode->user,
                'message' => 'Već je bio taj dan.'
            ]);
        }

        Entry::create([
            'user_id' => $qcode->user->id,
            'entry_time' => Carbon::now(),
            'type' => $qcode->user->hasRole('admin') || $qcode->user->hasRole('trener') ? 1 : 0,
            'payment_status' => count($userplan) > 0 && $userplan[0]->paid == 1 ? 0 : 1,
            'message' => 'Ulaz odobren.'
        ]);


          return response()->json([
              'entry' => true,
              'active' =>true,
              'payment' => count($userplan) > 0 && $userplan[0]->paid == 1 ? true : false,
              'expired_time' => $userplan[0]->expired_time !== null ? $userplan[0]->expired_time->format('d.m.Y.') : null,
              'user' => $qcode->user,
              'message' => 'Ulaz odobren.'
          ]);

    }

    public function postEntry(Request $request)
    {
        $qcode = Qrcode::whereToken($request->input('token'))->with('user')->first();

        if($qcode == null){
            return response()->json(['entry' => false]);
        }

        Entry::create([
            'user_id' => $qcode->user->id,
            'entry_time' => Carbon::now(),
            'type' => $qcode->user->hasRole('admin') || $qcode->user->hasRole('trener') ? 1 : 0,
        ]);

          return response()->json(['post_entry' => true, 'user' => $qcode->user, 'message' => 'Ulaz upisan.']);
    }

    public function postOrder(Request $request)
    {
        $qcode = Qrcode::whereToken($request->input('token'))->with('user')->first();

        if($qcode == null){
            return response()->json(['post_order' => false]);
        }

        $order = Order::where('user_id', $qcode->user->id)->latest()->first();
        $order->status = 1;
        $order->save();


        return response()->json(['post_order' => true, 'user' => $qcode->user, 'message' => 'Porudzbenica: '.$order->id]);
    }
}
