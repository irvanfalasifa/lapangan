<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
// use Auth;
use Illuminate\Support\Facades\Auth;
class LapanganController extends Controller
{
    public function lapangan() {
        $data = "Data Lapangan";
        return response()->json($data, 200);
    }
    public function lapanganAuth() {
        $data = "Selamat Datang " . Auth::user()->name;
        return response()->json($data, 200);
    }
}