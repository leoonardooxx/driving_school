<?php

use App\Http\Controllers\DashboardController;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['guest'])->group(function () {
    Route::get('/register', function () {
        return view('auth.registo');
    });

    Route::get('/login', function () {
        return view('auth.login');
    });


    Route::post('/login', function (LoginRequest $request) {

        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email ou password inválidos.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    })->name('auth.login');

    Route::post('/register', function (Request $request) {

        //echo $request->input('email');
        $data = $request->validate([
            'email' => 'required|email|',
            'name' => 'required|string|min:8|max:20',
            'password' => ['required', Password::defaults()],
            'last_name' => 'required|string|min:8|max:20',
            'profile' => ['required', Rule::in(['admin', 'student', 'instructor'])],
            'nif' => 'required|digits:9',
        ]);
        print_r($data);
        $slug = Str::slug($request->name . $request->last_name);
        $data['username'] = $slug;
        User::create($data);
    })->name('auth.register');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
