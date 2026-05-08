<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Display a listing of the agenda.
     */
    public function index()
    {
        // Mengambil semua agenda yang ada, diurutkan dari tanggal terdekat
        $agendas = Agenda::orderBy('event_date', 'asc')->paginate(12);
        
        return view('agenda.index', compact('agendas'));
    }
}
