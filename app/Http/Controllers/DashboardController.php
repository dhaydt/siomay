<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['active'] = 'dashboard';

        return view('dashboard.pages.dashboard', $data);
    }

    public function config()
    {
        $data['title'] = 'Pengaturan Website';
        $data['active'] = 'Pengaturan Website';

        return view('dashboard.pages.config', $data);
    }
}
