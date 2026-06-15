<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\Application;

class MessageController extends Controller
{
    // Menampilkan semua pesan (untuk admin)
    public function index()
{
    return view('admin.messages.index', [
        'app' => Application::all(),
        'title' => 'Data Kritik & Saran',
        'messages' => Message::latest()->paginate(10), // Pagination agar tidak terlalu berat
    ]);
}
public function indextambah()
{
    return view('admin.messages.create', [
        'app' => Application::all(),
        'title' => 'Kritik & Saran',
        'messages' => Message::latest()->paginate(10), // Pagination agar tidak terlalu berat
    ]);
}


    // Menyimpan pesan dari form
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending',
            'admin_feedback' => '-',
        ]);

        return redirect()->back()->with('tambahkritik', 'Pesan berhasil dikirim!');
    }

    // Menampilkan halaman edit status
    public function edit($id)
    {
        $message = Message::findOrFail($id);
        return view('admin.messages.edit', compact('message'));
    }

    // Mengupdate status dan feedback admin
    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $message->update([
            'status' => $request->status,
            'admin_feedback' => $request->admin_feedback,
        ]);

        return redirect()->route('messages.index')->with('success', 'Status pesan diperbarui!');
    }

    // Menghapus pesan
    public function destroy($id)
    {
        Message::findOrFail($id)->delete();
        return redirect()->route('messages.index')->with('success', 'Pesan berhasil dihapus!');
    }
}
