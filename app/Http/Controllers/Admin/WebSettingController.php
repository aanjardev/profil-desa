<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Http\Request;

class WebSettingController extends Controller
{
    public function show()
    {
        $webSetting = WebSetting::firstOrCreate(
            ['id' => 1],
            [
                'village_name' => 'Nama Desa',
                'subdistrict' => 'Kecamatan',
                'city' => 'Kabupaten',
                'province' => 'Provinsi'
            ]
        );
        $statistics = \App\Models\VillageStatistic::all()->keyBy('key');
        return view('admin.web-settings.show', compact('webSetting', 'statistics'));
    }

    public function edit()
    {
        $webSetting = WebSetting::firstOrCreate(
            ['id' => 1],
            [
                'village_name' => 'Nama Desa',
                'subdistrict' => 'Kecamatan',
                'city' => 'Kabupaten',
                'province' => 'Provinsi'
            ]
        );
        $statistics = \App\Models\VillageStatistic::all()->keyBy('key');
        return view('admin.web-settings.edit', compact('webSetting', 'statistics'));
    }

    public function update(Request $request)
    {
        $webSetting = WebSetting::firstOrCreate(['id' => 1]);
        
        $validated = $request->validate([
            'village_name' => 'required|string|max:255',
            'subdistrict' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'maps_embed' => 'nullable|string',
            'maps_link' => 'nullable|url|max:255',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'youtube_video_url' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            // statistics
            'stat_luas_wilayah' => 'nullable|string|max:255',
            'stat_jumlah_penduduk' => 'nullable|string|max:255',
            'stat_jumlah_rt_rw' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('logo_file')) {
            if ($webSetting->logo_path && \Storage::disk('public')->exists($webSetting->logo_path)) {
                \Storage::disk('public')->delete($webSetting->logo_path);
            }
            $validated['logo_path'] = $request->file('logo_file')->store('logo', 'public');
        }

        if ($request->hasFile('favicon_file')) {
            if ($webSetting->favicon_path && \Storage::disk('public')->exists($webSetting->favicon_path)) {
                \Storage::disk('public')->delete($webSetting->favicon_path);
            }
            $validated['favicon_path'] = $request->file('favicon_file')->store('logo', 'public');
        }

        $webSetting->update($validated);

        // Update statistics
        if (isset($validated['stat_luas_wilayah'])) {
            \App\Models\VillageStatistic::updateOrCreate(['key' => 'luas_wilayah'], ['value' => $validated['stat_luas_wilayah']]);
        }
        if (isset($validated['stat_jumlah_penduduk'])) {
            \App\Models\VillageStatistic::updateOrCreate(['key' => 'jumlah_penduduk'], ['value' => $validated['stat_jumlah_penduduk']]);
        }
        if (isset($validated['stat_jumlah_rt_rw'])) {
            \App\Models\VillageStatistic::updateOrCreate(['key' => 'jumlah_rt_rw'], ['value' => $validated['stat_jumlah_rt_rw']]);
        }

        return redirect()->route('admin.web-settings.show')->with('success', 'Info Web berhasil diperbarui!');
    }
}
