<?php
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('auth.registo');
});

Route::post('/register', function (Request $request) {
     
    //echo $request->input('email');
    $data = $request->validate([
        'email'=>'required|email|',
        'name'=>'required|string|min:8|max:20',
        'password'=>['required',Password::defaults()],
        'last_name'=>'required|string|min:8|max:20',
        'profile'=>['required',Rule::in(['admin','student','instructor'])],
        'nif'=>'required|digits:9',
    ]);
    print_r($data) ;
    $slug =Str::slug($request->name.$request->last_name);
    $data['username']=$slug ;
    User::create($data); 


    
        
        
        
      
   
        
});

