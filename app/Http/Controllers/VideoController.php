<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $videos = Video::latest()->get();
            
            return response()->json([
                'success' => true,
                'data' => $videos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading videos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'published_date' => 'required|date',
            'link' => 'required|string|max:500' // Hanya validasi sebagai string biasa
        ], [
            'title.required' => 'Judul video wajib diisi.',
            'title.max' => 'Judul video maksimal 255 karakter.',
            'source.required' => 'Sumber video wajib diisi.',
            'source.max' => 'Sumber video maksimal 255 karakter.',
            'published_date.required' => 'Tanggal publikasi wajib diisi.',
            'published_date.date' => 'Format tanggal publikasi tidak valid.',
            'link.required' => 'Link video wajib diisi.',
            'link.max' => 'Link video maksimal 500 karakter.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $video = Video::create([
                'title' => $request->title,
                'source' => $request->source,
                'published_date' => $request->published_date,
                'link' => $request->link // Disimpan apa adanya tanpa modifikasi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Video berhasil ditambahkan!',
                'data' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving video: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return response()->json([
            'success' => true,
            'data' => $video
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading video: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'published_date' => 'required|date',
            'link' => 'required|string|max:500' // Hanya validasi sebagai string biasa
        ], [
            'title.required' => 'Judul video wajib diisi.',
            'title.max' => 'Judul video maksimal 255 karakter.',
            'source.required' => 'Sumber video wajib diisi.',
            'source.max' => 'Sumber video maksimal 255 karakter.',
            'published_date.required' => 'Tanggal publikasi wajib diisi.',
            'published_date.date' => 'Format tanggal publikasi tidak valid.',
            'link.required' => 'Link video wajib diisi.',
            'link.max' => 'Link video maksimal 500 karakter.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $video->update([
                'title' => $request->title,
                'source' => $request->source,
                'published_date' => $request->published_date,
                'link' => $request->link // Disimpan apa adanya tanpa modifikasi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Video berhasil diupdate!',
                'data' => $video
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating video: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        try {
            $video->delete();

            return response()->json([
                'success' => true,
                'message' => 'Video berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting video: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get public videos for frontend display
     */
    public function getPublicVideos()
    {
        try {
            $videos = Video::orderBy('published_date', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'data' => $videos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching videos'
            ], 500);
        }
    }
}