<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;
use Auth;
use DB;
use App\User;
use Mail;
use App\Mail\SendMailPassword;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MainController extends Controller
{
    function checklogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:3'
        ]);

        $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
        );

        if(Auth::attempt($user_data))
        {
            return redirect('/home');
        }
        else
        {
            return back()->with('error', 'Email ou senha incorretos.');
        }

    }

    function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    function recuperarSenha(Request $request){
        $user = DB::table('nb_users')->where('user_email', '=', $request->email)->first();
        if($user == NULL){
            return back()->with('error', 'Usuário não encontrado!');
        }
        $token = DB::table('password_resets')->where('email', $request->email)->first();
        if($token == NULL){
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => Str::random(60),
                'created_at' => Carbon::now()
            ]);
            $token = DB::table('password_resets')->where('email', $request->email)->first();
            //return response()->json($url);
            Mail::to($request->email)->send(new SendMailPassword($request->email, $token->token));
            return redirect('/login')->with('error', 'Uma solicitação de nova senha foi enviada, verifique seu email.');
        }else{
            return back()->with('error', 'Um email com a solicitação de uma nova senha já foi enviado!');
        }
    }

    function novaSenha($token, Request $request){
        //list($part1, $part2) = explode('?email=', $url);
        //return response()->json($request->email);
        $novaSenha = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $token)
        ->first();
        if($novaSenha == NULL){
            return back()->with('error', 'URL expirada! Solicite uma nova.');
        }else{
            $data = [
                'token' => $token,
                'email' => $request->email
            ];
            return view('admin.novaSenha', $data);
        }
    }

    function validarSenha($token, Request $request){
        if($request->password != $request->password_confirmation){
            return back()->with('error', 'A senha de confirmação está incorreta.');
        }else{
            $novaSenha = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $token)
            ->first();
            if($novaSenha == NULL){
                return back()->with('error', 'URL expirada! Solicite uma nova.');
            }else{
                $user = DB::table('nb_users')->where('user_email', '=', $request->email)->first();
                //return response()->json($user);
                $update_user = User::find($user->user_id);
                $update_user->user_password = Hash::make($request->password);
                if($update_user->save()){
                    DB::table('password_resets')
                        ->where('email', $request->email)
                        ->where('token', $token)
                    ->delete();
                    return redirect('/login')->with('error', 'Nova senha foi salva com sucesso.');
                }else{
                    return back()->with('error', 'Não foi possível salvar a nova senha.');
                }
            }
        }
    }
}
