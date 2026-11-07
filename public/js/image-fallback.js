(() => {
    const base = document.currentScript.dataset.placeholderBase;

    function replaceMissingImage(image) {
        if (!(image instanceof HTMLImageElement)) return;
        const original = image.currentSrc || image.src;
        // A failed fallback must never trigger an endless retry loop.
        if (original.startsWith(base)) return;
        const hint = `${original} ${image.className}`;
        let category = 'gallery';
        if (/official|member|photo|avatar|profile/i.test(hint)) category = 'profile';
        else if (/touris|wisata|background/i.test(hint)) category = 'village';
        else if (/umkm|product|produk/i.test(hint)) category = 'business';
        else if (/post|berita|agenda|news/i.test(hint)) category = 'news';
        else if (/logo|favicon/i.test(hint)) category = 'identity';

        const fallback = `${base}/${category}.svg`;
        image.removeAttribute('srcset');
        image.closest('picture')?.querySelectorAll('source').forEach(source => source.removeAttribute('srcset'));
        image.src = fallback;
        image.title = 'Ilustrasi demo — gambar asli belum tersedia';

        // Keep image lightboxes usable when their original upload is missing.
        const link = image.closest('a');
        if (link && link.href === original) link.href = fallback;
    }

    document.addEventListener('error', event => replaceMissingImage(event.target), true);
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('img').forEach(image => {
            if (image.complete && image.naturalWidth === 0 && image.getAttribute('src')) {
                replaceMissingImage(image);
            }
        });
    });
})();
