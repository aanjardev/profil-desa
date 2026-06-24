<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMenuGroups(): array
    {
        return [
            [
                'title' => 'Menu Utama',
                'items' => [
                    [
                        'name' => 'Dashboard',
                        'path' => '/admin',
                        'icon' => 'dashboard',
                    ],
                ]
            ],
            [
                'title' => 'Konten Web',
                'items' => [
                    [
                        'name' => 'Pengaturan Web',
                        'icon' => 'settings',
                        'subItems' => [
                            ['name' => 'Info Web', 'path' => '/admin/web-settings'],
                            ['name' => 'Profil / Identitas Desa', 'path' => '/admin/village-identities'],
                        ]
                    ],
                    [
                        'name' => 'Informasi & Publikasi',
                        'icon' => 'newspaper',
                        'subItems' => [
                            ['name' => 'Berita / Artikel', 'path' => '/admin/posts'],
                            ['name' => 'Galeri', 'path' => '/admin/galleries'],
                            ['name' => 'FAQ', 'path' => '/admin/faqs'],
                        ]
                    ],
                    [
                        'name' => 'Potensi Desa',
                        'icon' => 'star',
                        'subItems' => [
                            ['name' => 'Wisata', 'path' => '/admin/tourisms'],
                            ['name' => 'UMKM', 'path' => '/admin/umkms'],
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Pemerintahan',
                'items' => [
                    [
                        'name' => 'SOTK & Lembaga',
                        'icon' => 'users',
                        'subItems' => [
                            ['name' => 'Perangkat Desa', 'path' => '/admin/village-officials'],
                            ['name' => 'Lembaga Desa', 'path' => '/admin/institutions'],
                        ]
                    ],
                    [
                        'name' => 'Pelayanan Publik',
                        'icon' => 'briefcase',
                        'subItems' => [
                            ['name' => 'Layanan Surat', 'path' => '/admin/service-letters'],
                            ['name' => 'Pengaduan', 'path' => '/admin/complaints'],
                            ['name' => 'Dokumen PPID', 'path' => '/admin/ppid-documents'],
                        ]
                    ]
                ]
            ],
            [
                'title' => 'Sistem',
                'items' => [
                    [
                        'name' => 'Manajemen User',
                        'path' => '/admin/users',
                        'icon' => 'shield',
                    ],
                ]
            ]
        ];
    }

    public static function getIconSvg(string $name): string
    {
        // Menyediakan ikon dasar berbasis Feather Icons atau Heroicons
        $icons = [
            'dashboard' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>',
            'settings' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
            'newspaper' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-.586-1.414l-4.5-4.5A2 2 0 0012.586 3H12"></path></svg>',
            'star' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>',
            'users' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
            'briefcase' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
            'shield' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
        ];

        return $icons[$name] ?? $icons['dashboard'];
    }
}
