<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // Manual login using plain-text password (no hashing)
        $user = User::where('username', $credentials['username'])->first();
        if ($user && $user->password === $credentials['password']) {
            Auth::login($user, $request->remember ?? false);
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function dashboard()
    {
        $this->checkAuth();

        $totalTransaksi = Order::count(); 
        $totalMenu = Menu::count();
        $pendapatanHariIni = Order::whereDate('created_at', today())->sum('total_price') ?? 0;
        
        // Get sales statistics for the current week (Monday to Sunday) in Indonesian
        \Carbon\Carbon::setLocale('id');
        $startOfWeek = today()->startOfWeek();

        $salesStats = collect(range(0, 6))->map(function($daysFromMonday) use ($startOfWeek) {
            $date = $startOfWeek->copy()->addDays($daysFromMonday);
            $totalSales = Order::whereDate('created_at', $date)->sum('total_price') ?? 0;
            return [
                'label' => $date->isoFormat('dddd'),
                'value' => (int)$totalSales
            ];
        });

        $chartLabels = $salesStats->pluck('label')->toArray();
        $chartData = $salesStats->pluck('value')->toArray();

        return view('admin.dashboard', compact('totalTransaksi', 'totalMenu', 'pendapatanHariIni', 'chartLabels', 'chartData'));
    }

    public function profile()
    {
        $this->checkAuth();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function profileEdit()
    {
        $this->checkAuth();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('admin.profile_edit', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $filename);
            
            // Delete old image if exists
            if ($user->profile_image && file_exists(public_path('uploads/profile/' . $user->profile_image))) {
                unlink(public_path('uploads/profile/' . $user->profile_image));
            }
            
            $data['profile_image'] = $filename;
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
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

    public function menuStore(Request $request)
    {
        $this->checkAuth();
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required|in:makanan,minuman',
            'status' => 'required|in:tersedia,habis',
            'price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imageName = 'logo.jpeg'; 
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status,
            'price' => 'Rp. ' . number_format($request->price, 0, ',', '.'),
            'price_numeric' => $request->price,
            'image' => $imageName
        ]);

        return redirect()->route('admin.menu')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function menuEdit($id)
    {
        $this->checkAuth();
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    public function menuUpdate(Request $request, $id)
    {
        $this->checkAuth();
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required|in:makanan,minuman',
            'status' => 'required|in:tersedia,habis',
            'price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $menu = Menu::findOrFail($id);
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status,
            'price' => 'Rp. ' . number_format($request->price, 0, ',', '.'),
            'price_numeric' => $request->price,
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $menu->update($data);

        return redirect()->route('admin.menu')->with('success', 'Menu berhasil diupdate.');
    }

    public function menuDestroy($id)
    {
        $this->checkAuth();
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menu')->with('success', 'Menu berhasil dihapus.');
    }

    public function transaksi()
    {
        $this->checkAuth();
        $transactions = Order::orderBy('created_at', 'desc')->get();
        return view('admin.transaksi.index', compact('transactions'));
    }

    public function transaksiCreate()
    {
        $this->checkAuth();
        $menus = Menu::where('status', 'tersedia')->get();
        return view('admin.transaksi.create', compact('menus'));
    }

    public function transaksiStore(Request $request)
    {
        $this->checkAuth();
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'whatsapp' => 'required|string',
            'address' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $orderDate = $request->order_date ? $request->order_date . ' ' . date('H:i:s') : now();

        DB::beginTransaction();
        try {
            $totalPrice = 0;
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'whatsapp' => $request->whatsapp,
                'address' => $request->address,
                'note' => $request->note ?? '-',
                'total_price' => 0, 
                'status' => 'pending',
                'created_at' => $orderDate,
                'updated_at' => $orderDate
            ]);

            foreach ($request->items as $itemData) {
                $menu = Menu::findOrFail($itemData['menu_id']);
                $subtotal = $menu->price_numeric * $itemData['quantity'];
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => $itemData['quantity'],
                    'price' => $menu->price_numeric,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate
                ]);
                
                $totalPrice += $subtotal;
            }

            $order->update(['total_price' => $totalPrice]);
            
            DB::commit();
            return redirect()->route('admin.transaksi')->with('success', 'Pesanan manual berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    public function transaksiUpdateStatus(Request $request)
    {
        $this->checkAuth();
        $request->validate([
            'order_id' => 'required',
            'status' => 'required'
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function transaksiItemDestroy($id)
    {
        // Removed deletion logic as requested by user. 
        // The button was intended for UI interaction only.
        return response()->json(['success' => true]);
    }

    public function transaksiDetails($id)
    {
        $this->checkAuth();
        $order = Order::with('orderItems.menu')->findOrFail($id);
        
        $details = $order->orderItems->map(function($item) {
            return [
                'id' => $item->id,
                'order_id' => $item->order_id,
                'nama_menu' => $item->menu->name ?? 'Unknown',
                'quantity' => $item->quantity,
                'subtotal' => number_format($item->price * $item->quantity, 0, ',', '.')
            ];
        });

        return response()->json($details);
    }

    public function transaksiDestroy($id)
    {
        $this->checkAuth();
        $order = Order::findOrFail($id);
        // Delete associated items first (optional if using cascade, but safe)
        $order->orderItems()->delete();
        $order->delete();

        return redirect()->route('admin.transaksi')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function riwayat()
    {
        $this->checkAuth();
        $history = OrderItem::with(['order', 'menu'])->latest()->get();
        return view('admin.riwayat', compact('history'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
