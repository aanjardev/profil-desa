<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageOfficial;
use App\Models\SotkLine;
use Illuminate\Http\Request;

class SotkBuilderController extends Controller
{
    public function index()
    {
        $officials = VillageOfficial::aktif()->get();
        $lines = SotkLine::all();
        $settings = \App\Models\WebSetting::first() ?? new \App\Models\WebSetting();
        
        return view('admin.village-officials.builder', compact('officials', 'lines', 'settings'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'nodes' => 'required|array',
            'nodes.*.id' => 'required|exists:village_officials,id',
            'nodes.*.pos_x' => 'required|numeric',
            'nodes.*.pos_y' => 'required|numeric',
            'lines' => 'nullable|array',
            'lines.*.source_id' => 'required|exists:village_officials,id',
            'lines.*.target_id' => 'required|exists:village_officials,id',
            'lines.*.line_type' => 'required|string',
        ]);

        // Update positions
        foreach ($request->nodes as $nodeData) {
            VillageOfficial::where('id', $nodeData['id'])->update([
                'pos_x' => $nodeData['pos_x'],
                'pos_y' => $nodeData['pos_y'],
            ]);
        }

        // Recreate lines
        SotkLine::truncate();
        
        if (!empty($request->lines)) {
            foreach ($request->lines as $lineData) {
                SotkLine::create([
                    'source_id' => $lineData['source_id'],
                    'target_id' => $lineData['target_id'],
                    'line_type' => $lineData['line_type'],
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Desain SOTK berhasil disimpan.']);
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'sotk_type' => 'required|in:builder,image',
            'sotk_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $settings = \App\Models\WebSetting::first() ?? new \App\Models\WebSetting();
        $settings->sotk_type = $request->sotk_type;

        if ($request->hasFile('sotk_image')) {
            // Hapus gambar lama jika ada
            if ($settings->sotk_image_path && \Storage::disk('public')->exists($settings->sotk_image_path)) {
                \Storage::disk('public')->delete($settings->sotk_image_path);
            }
            $path = $request->file('sotk_image')->store('sotk', 'public');
            $settings->sotk_image_path = $path;
        }

        $settings->save();

        return redirect()->back()->with('success', 'Pengaturan SOTK berhasil diperbarui.');
    }
}
