<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ReferHistory;
use App\Models\Trnx;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'country' => ['required'],
        ]);

        $referCode = 'REN' . strtoupper(Str::random(4));
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'refer_code' => $referCode,
        ]);

        event(new Registered($user));

        // refereral user transaction
        $referrer = User::where('refer_code', $request->refer_code)->first();
        if ($request->refer_code) {
            $timestamps1 = 'RFID' . 'REGISTER' . $user->id;
            $hash1 = ' New User Is Register With Your Referal ID, Username is : ' . $user->name;

            $trnx1 = new Trnx();
            $trnx1->user_id = $user->id;
            $trnx1->tx_id = $timestamps1;
            $trnx1->type = "register_withref";
            $trnx1->amount = 0;
            $trnx1->hash = $hash1;
            $trnx1->date_time = now();
            $trnx1->save();

            // 5% refer amount calculate
            $referAmount = ($user->total_usdt * 5) / 100;

            // Refer history save
            $refer = new ReferHistory();
            $refer->user_id = $user->id;
            $refer->refer_user_id = $referrer->id; // referrer
            $refer->refer_amount = $referrer->total_usdt + $referAmount;
            $refer->save();

            // Referrer user ko amount add karo
            // $referrer->total_usdt = $referrer->total_usdt + $referAmount;
            // $referrer->save();
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
