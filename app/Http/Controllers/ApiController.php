<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Company;

class ApiController extends Controller
{
    // Obtener las empresas registradas en formato Json
    public function companies($page=1)
    {
        return Company::paginate(2, ['*'], 'page', $page)->toJson();
    }

    // Dar me gusta/no me gusta a una empresa
    public function like(Request $request)
    {   
        if (Auth::check()) {
            $user = Auth::user();
            $company = Company::find($request->company_id);

            // Verifica si la id recibida es la misma del usuario de la sesión
            if($user->id == $request->user_id) {
                // Se obtienen la id de los usuarios que han dado me gusta a la empresa
                $likes_str = $company->likes;

                // Se convierte el string obtenido en un array
                $char_remove = array("[", "]", "{", "}", '"user_id"', ":");
                $id_string = str_replace($char_remove, "", $likes_str);

                $id_array = explode(",", $id_string);

                // Se verifica si el usuario ha dado me gusta o no
                if (in_array($user->id, $id_array)) {
                    $user->liked_companies()->detach($company->id);
                    return response()->json(['status' => 'success', 'action' => 'unlike', 'likes_amount' => $company->likes_amount]);
                } else {
                    $user->liked_companies()->attach($company->id);
                    return response()->json(['status' => 'success', 'action' => 'like', 'likes_amount' => $company->likes_amount]);
                }
            } else {
                return response()->json(['status' => 'error', 'error' => 'security']);
            }
        }

        return response()->json(['status' => 'error', 'error' => 'authentication required']);
    }
}
