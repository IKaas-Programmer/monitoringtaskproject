<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    /**
     * Menyimpan komentar baru pada suatu Task
     */
    public function store(Request $request, Task $task)
    {
        // 1. Validasi input: Body wajib diisi, attachment opsional
        $request->validate([
            'body' => 'required|string|min:2',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,zip|max:5120', // Maks 5MB
        ]);

        // 2. Handle upload file jika ada
        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }

        // 3. Simpan komentar ke database
        Comment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(), // ID user yang login
            'body'    => $request->body,
            'attachment' => $path,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }

    /**
     * Menghapus komentar (Hanya pemilik komentar)
     */
    public function destroy(Comment $comment)
    {
        // Pastikan hanya pengirim yang bisa menghapus komentarnya sendiri
        if (Auth::id() !== $comment->user_id) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        // Hapus file dari storage jika ada
        if ($comment->attachment) {
            Storage::disk('public')->delete($comment->attachment);
        }

        $comment->delete();

        return back()->with('success', 'Komentar dihapus.');
    }
}