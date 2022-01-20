<?php

namespace App\Http\Controllers;

use App\Models\InformacionPersona;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name1 = strtolower(str_replace(' ', '', $request->name));
        $percent = $request->percent;
        $informaciones_personas = InformacionPersona::where('nombre', 'like', '%meifer%')->get();
        $data = [];
        foreach ($informaciones_personas as $persona) {
            $name2 = strtolower(str_replace(' ', '', $persona->nombre));
            similar_text($name1, $name2, $similar_percent);
            $method_lev = levenshtein($name1, $name2);
            $names_len = (strlen($name1) + strlen($name2));
            $lev_result = (((($names_len) - $method_lev) * 100) / $names_len);
            $result_percent = ($similar_percent + $lev_result) / 2;
            if ($percent >= $result_percent) {
                $persona->percent = $result_percent;
                $data[] = $persona;
            } else {
                continue;
            }
        }
        return $data;
    }
    // public function index()
    // {
    //     return view('index');
    // }
    public function exerciseJSON(Request $request)
    {
        return InformacionPersona::limit(100)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
