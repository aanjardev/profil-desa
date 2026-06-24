<div>
    <x-panel::page-header :title="\App\Panel\Pages\WebSettingPage::label()" />

    <div class="panel-card p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-panel-heading">Informasi Web Saat Ini</h2>
            <a href="/admin/resources/web-setting/1/edit" wire:navigate class="panel-btn panel-btn-primary">
                <x-icon name="edit" class="w-4 h-4 mr-2" />
                Edit Data
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-panel-muted mb-1">Nama Desa</p>
                <p class="text-base font-medium">{{ $webSetting->village_name ?: '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-panel-muted mb-1">Nomor Telepon</p>
                <p class="text-base font-medium">{{ $webSetting->phone ?: '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-panel-muted mb-1">Email Desa</p>
                <p class="text-base font-medium">{{ $webSetting->email ?: '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-panel-muted mb-1">Wilayah</p>
                <p class="text-base font-medium">Kec. {{ $webSetting->subdistrict ?: '-' }}, {{ $webSetting->city ?: '-' }}, {{ $webSetting->province ?: '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-panel-muted mb-1">Alamat Lengkap</p>
                <p class="text-base font-medium">{{ $webSetting->address ?: '-' }}</p>
            </div>
        </div>
    </div>
</div>