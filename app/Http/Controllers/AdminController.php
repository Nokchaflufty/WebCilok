<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function checkAuth()
    {
        if (!Auth::check()) {
            redirect()->route('admin.login')->send();
            exit;
        }
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Attempt to log in using 'username' instead of 'email'
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function dashboard()
    {
        $this->checkAuth();

        // Mock data or real data from DB
        $totalTransaksi = Order::count(); 
        $totalMenu = Menu::count();
        $pendapatanHariIni = Order::whereDate('created_at', today())->sum('total_price') ?? 0;
        
        // Real recent transactions from DB
        $recentTransactions = Order::orderBy('created_at', 'desc')->take(5)->get()->map(function($order) {
            return [
                'nama' => $order->customer_name,
                'total' => $order->total_price,
                'waktu' => $order->created_at->isoFormat('dddd, D MMM - HH:mm'),
                'status' => $order->status ?? 'proses'
            ];
        });

        return view('admin.dashboard', compact('totalTransaksi', 'totalMenu', 'pendapatanHariIni', 'recentTransactions'));
    }

    public function profile()
    {
        $this->checkAuth();

        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function profileEdit()
    {
        $this->checkAuth();
        $user = Auth::user();
        return view('admin.profile_edit', compact('user'));
    }

    public function menu()
    {
        $this->checkAuth(); 
        $menus = Menu::all();
        return view('admin.menu.index', compact('menus'));
    }

    public function menuCreate()
    {
        $this->checkAuth();
        return view('admin.menu.create');
    }

    public function transaksi()
    {
        $this->checkAuth();
        // Mocking transactions for the UI
        $transactions = []; 
        return view('admin.transaksi.index', compact('transactions'));
    }

    public function riwayat()
    {
        $this->checkAuth();
        // Mocking history for the UI
        $history = [];
        return view('admin.riwayat', compact('history'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
