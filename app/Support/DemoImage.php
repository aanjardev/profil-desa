<?php

namespace App\Support;

class DemoImage
{
    /** Resolve local image assets without changing the stored upload paths. */
    public static function asset(?string $path, ?bool $secure = null): string
    {
        $path = $path ?? '';

        if (preg_match('~^(?:https?:)?//|^data:~i', $path)) {
            return asset($path, $secure);
        }

        $localPath = ltrim(parse_url($path, PHP_URL_PATH) ?: '', '/');
        $extension = strtolower(pathinfo($localPath, PATHINFO_EXTENSION));

        // Documents, scripts and styles must retain their original URLs.
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'avif', 'bmp', 'ico'], true)) {
            return asset($path, $secure);
        }

        if (is_file(public_path($localPath))) {
            return asset($path, $secure);
        }

        $category = match (true) {
            (bool) preg_match('/official|member|photo|avatar|pengurus|perangkat/i', $localPath) => 'profile',
            (bool) preg_match('/touris|wisata|background|auth-bg/i', $localPath) => 'village',
            (bool) preg_match('/umkm|product|produk/i', $localPath) => 'business',
            (bool) preg_match('/post|berita|agenda|news/i', $localPath) => 'news',
            (bool) preg_match('/logo|favicon|icon-tab/i', $localPath) => 'identity',
            default => 'gallery',
        };

        return asset('images/placeholders/'.$category.'.svg', $secure);
    }

    public static function storage(?string $path): string
    {
        if (empty($path)) {
            return asset('images/placeholders/gallery.svg');
        }

        if (preg_match('~^(?:https?:)?//|^data:~i', $path ?? '')) {
            return $path;
        }

        return self::asset('storage/'.ltrim($path ?? '', '/'));
    }
}
