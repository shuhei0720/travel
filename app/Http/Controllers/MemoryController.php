<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemoryController extends Controller
{
    public function index()
    {
        $memories = Memory::all();
        return view('memories.index', compact('memories'));
    }

    public function create()
    {
        return view('memories.create');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'nullable|string|max:255',
            'nights' => 'nullable|integer|min:0|max:10',
            'days' => 'required|integer|min:1|max:10',
            'departure_time' => 'nullable|string',
            'departure_location' => 'nullable|string|max:255',
            'schedule' => 'nullable|string',
            'thoughts' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // バリデーション後のデータを確認

        // 画像の保存
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('images', 'public');
            }
        }

        // データの保存
        $memory = new Memory($validated);
        $memory->images = json_encode($images);
        $memory->save();

        return redirect()->route('memories.index')->with('success', 'Memory created successfully.');
    }

    public function edit(Memory $memory)
    {
        return view('memories.edit', compact('memory'));
    }

    public function update(Request $request, Memory $memory)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'nullable|string|max:255',
            'nights' => 'required|integer|min:0|max:10',
            'days' => 'required|integer|min:1|max:10',
            'departure_time' => 'required|date_format:H:i',
            'departure_location' => 'nullable|string|max:255',
            'schedule' => 'nullable|string',
            'thoughts' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'nullable|string',
        ]);

        $memory->title = $validated['title'];
        $memory->destination = $validated['destination'];
        $memory->nights = $validated['nights'];
        $memory->days = $validated['days'];
        $memory->departure_time = $validated['departure_time'];
        $memory->departure_location = $validated['departure_location'];
        $memory->schedule = $validated['schedule'];
        $memory->thoughts = $validated['thoughts'];

        // 既存の画像
        $existingImages = json_decode($memory->images, true) ?: [];

        // 削除する画像
        $imagesToDelete = $request->input('delete_images', []);

        // 削除されない画像を保持
        $imagesToKeep = array_diff($existingImages, $imagesToDelete);

        // 新しい画像が追加された場合
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $imagesToKeep[] = $path;
            }
        }

        // メモリの画像情報を更新
        $memory->images = json_encode(array_values($imagesToKeep));

        // 削除する画像の実ファイルを削除
        foreach ($imagesToDelete as $image) {
            Storage::disk('public')->delete($image);
        }

        $memory->save();

        return redirect()->route('memories.index')->with('success', '旅行の思い出が更新されました。');
    }

    public function destroy(Memory $memory)
    {
        foreach (json_decode($memory->images) as $image) {
            \Storage::disk('public')->delete($image);
        }

        $memory->delete();

        return redirect()->route('memories.index')->with('success', 'Memory deleted successfully.');
    }

    public function deleteImage(Request $request, Memory $memory)
    {
        $image = $request->input('image');
        $existingImages = json_decode($memory->images, true) ?: [];

        if (($key = array_search($image, $existingImages)) !== false) {
            unset($existingImages[$key]);
            Storage::disk('public')->delete($image);
        }

        $memory->images = json_encode(array_values($existingImages));
        $memory->save();

        return response()->json(['success' => true]);
    }
}