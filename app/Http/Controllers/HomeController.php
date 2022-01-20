<?php

namespace App\Http\Controllers;

use App\Models\InformacionPersona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exerciseJSON(Request $request)
    {
        // Cache::flush();
        $name1 = strtolower(str_replace(' ', '', $request->name));
        $percent = $request->percent;
        $cache = Cache::get($name1 . $percent);
        if (!$cache) {
            $informaciones_personas = InformacionPersona::all();
        } else {
            return $cache;
        }
        $data = [];
        foreach ($informaciones_personas as $persona) {
            $name2 = strtolower(str_replace(' ', '', $persona->nombre));
            similar_text($name1, $name2, $similar_percent);
            $method_lev = levenshtein($name1, $name2);
            $names_len = (strlen($name1) + strlen($name2));
            $lev_result = (((($names_len) - $method_lev) * 100) / $names_len);
            $result_percent = ($similar_percent + $lev_result) / 2;
            if ($result_percent >= $percent) {
                $persona->percent = number_format($result_percent, '2', ',', '.');
                $data[] = $persona;
            } else {
                continue;
            }
        }
        Cache::delete($name1);
        $temp = [];
        foreach ($data as $key => $row) {
            $temp[$key] = $row['percent'];
        }
        array_multisort($temp, SORT_DESC, $data);
        Cache::put($name1 . $percent, $data, now()->addMinutes(5));
        return $data;
    }
    public function index()
    {
        return view('index');
    }
    // public function exerciseJSON(Request $request)
    // {
    //     return InformacionPersona::limit(100)->get();
    // }

    /**
     * Store a newly created resource in storpercent.
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
     * Update the specified resource in storpercent.
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
     * Remove the specified resource from storpercent.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
