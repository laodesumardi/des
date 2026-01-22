<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        // Get current settings
        $settings = [
            // Informasi Umum
            'nama_desa' => Content::getContent('settings', 'general', 'nama_desa', 'Pemerintah Desa'),
            'nama_lengkap_desa' => Content::getContent('settings', 'general', 'nama_lengkap_desa', 'Desa Contoh'),
            'kecamatan' => Content::getContent('settings', 'general', 'kecamatan', ''),
            'kabupaten' => Content::getContent('settings', 'general', 'kabupaten', ''),
            'provinsi' => Content::getContent('settings', 'general', 'provinsi', ''),
            'kode_pos' => Content::getContent('settings', 'general', 'kode_pos', ''),
            'tagline' => Content::getContent('settings', 'general', 'tagline', 'Website Resmi Informasi Desa'),
            
            // Kontak
            'telepon' => Content::getContent('settings', 'contact', 'telepon', ''),
            'email' => Content::getContent('settings', 'contact', 'email', ''),
            'whatsapp' => Content::getContent('settings', 'contact', 'whatsapp', ''),
            'alamat' => Content::getContent('settings', 'contact', 'alamat', ''),
            
            // Jam Operasional
            'jam_buka' => Content::getContent('settings', 'hours', 'jam_buka', '08:00'),
            'jam_tutup' => Content::getContent('settings', 'hours', 'jam_tutup', '15:00'),
            'hari_kerja' => Content::getContent('settings', 'hours', 'hari_kerja', 'Senin - Jumat'),
            
            // Social Media
            'facebook' => Content::getContent('settings', 'social', 'facebook', ''),
            'instagram' => Content::getContent('settings', 'social', 'instagram', ''),
            'youtube' => Content::getContent('settings', 'social', 'youtube', ''),
            'twitter' => Content::getContent('settings', 'social', 'twitter', ''),
            
            // SEO
            'meta_description' => Content::getContent('settings', 'seo', 'meta_description', ''),
            'meta_keywords' => Content::getContent('settings', 'seo', 'meta_keywords', ''),
            
            // Footer
            'footer_text' => Content::getContent('settings', 'footer', 'footer_text', 'Dikelola oleh Tim IT Pemerintah Desa'),
        ];

        // Check for logo and favicon
        $logoPath = $this->findImage('logo');
        $faviconPath = $this->findImage('favicon');

        return view('admin.settings.index', compact('settings', 'logoPath', 'faviconPath'));
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'nama_desa' => 'required|string|max:255',
            'nama_lengkap_desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'tagline' => 'nullable|string|max:255',
        ]);

        $fields = ['nama_desa', 'nama_lengkap_desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'tagline'];
        
        foreach ($fields as $field) {
            $this->saveSetting('general', $field, $request->input($field, ''));
        }

        // Also update beranda header for compatibility
        $this->saveSetting('header_website', 'nama_desa', $request->nama_desa, 'beranda');
        $this->saveSetting('header_website', 'subtitle', $request->tagline ?? 'Website Resmi Informasi Desa', 'beranda');

        return redirect()->route('admin.settings.index')->with('success', 'Informasi umum berhasil diperbarui.');
    }

    /**
     * Update contact settings
     */
    public function updateContact(Request $request)
    {
        $request->validate([
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'whatsapp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:500',
        ]);

        $fields = ['telepon', 'email', 'whatsapp', 'alamat'];
        
        foreach ($fields as $field) {
            $this->saveSetting('contact', $field, $request->input($field, ''));
        }

        // Also update kontak page for compatibility
        Content::updateOrCreate(
            ['page' => 'kontak', 'section' => 'telepon', 'key' => 'telepon'],
            ['content' => $request->telepon ?? '']
        );
        Content::updateOrCreate(
            ['page' => 'kontak', 'section' => 'telepon', 'key' => 'email'],
            ['content' => $request->email ?? '']
        );
        Content::updateOrCreate(
            ['page' => 'kontak', 'section' => 'alamat', 'key' => 'alamat_lengkap'],
            ['content' => $request->alamat ?? '']
        );

        return redirect()->route('admin.settings.index')->with('success', 'Informasi kontak berhasil diperbarui.');
    }

    /**
     * Update operational hours
     */
    public function updateHours(Request $request)
    {
        $request->validate([
            'jam_buka' => 'nullable|string|max:10',
            'jam_tutup' => 'nullable|string|max:10',
            'hari_kerja' => 'nullable|string|max:100',
        ]);

        $fields = ['jam_buka', 'jam_tutup', 'hari_kerja'];
        
        foreach ($fields as $field) {
            $this->saveSetting('hours', $field, $request->input($field, ''));
        }

        return redirect()->route('admin.settings.index')->with('success', 'Jam operasional berhasil diperbarui.');
    }

    /**
     * Update social media links
     */
    public function updateSocial(Request $request)
    {
        $request->validate([
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
        ]);

        $fields = ['facebook', 'instagram', 'youtube', 'twitter'];
        
        foreach ($fields as $field) {
            $this->saveSetting('social', $field, $request->input($field, ''));
        }

        return redirect()->route('admin.settings.index')->with('success', 'Media sosial berhasil diperbarui.');
    }

    /**
     * Update SEO settings
     */
    public function updateSeo(Request $request)
    {
        $request->validate([
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'footer_text' => 'nullable|string|max:255',
        ]);

        $this->saveSetting('seo', 'meta_description', $request->meta_description ?? '');
        $this->saveSetting('seo', 'meta_keywords', $request->meta_keywords ?? '');
        $this->saveSetting('footer', 'footer_text', $request->footer_text ?? '');

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan SEO berhasil diperbarui.');
    }

    /**
     * Upload logo
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ]);

        try {
            // Delete old logo files
            $this->deleteOldImages('logo');

            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = 'logo-' . time() . '.' . $extension;
            
            $uploadPath = public_path('images');
            $file->move($uploadPath, $filename);

            return redirect()->route('admin.settings.index')->with('success', 'Logo berhasil diupload.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')->with('error', 'Gagal mengupload logo: ' . $e->getMessage());
        }
    }

    /**
     * Upload favicon
     */
    public function uploadFavicon(Request $request)
    {
        $request->validate([
            'favicon' => 'required|image|mimes:png,ico,jpg,jpeg|max:1024',
        ]);

        try {
            // Delete old favicon files
            $this->deleteOldImages('favicon');

            $file = $request->file('favicon');
            $extension = $file->getClientOriginalExtension();
            $filename = 'favicon-' . time() . '.' . $extension;
            
            $uploadPath = public_path('images');
            $file->move($uploadPath, $filename);

            // Also copy to public root as favicon.ico for browser compatibility
            if ($extension !== 'ico') {
                copy(public_path('images/' . $filename), public_path('favicon.ico'));
            } else {
                copy(public_path('images/' . $filename), public_path('favicon.ico'));
            }

            return redirect()->route('admin.settings.index')->with('success', 'Favicon berhasil diupload.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')->with('error', 'Gagal mengupload favicon: ' . $e->getMessage());
        }
    }

    /**
     * Delete logo
     */
    public function deleteLogo()
    {
        $this->deleteOldImages('logo');
        return redirect()->route('admin.settings.index')->with('success', 'Logo berhasil dihapus.');
    }

    /**
     * Delete favicon
     */
    public function deleteFavicon()
    {
        $this->deleteOldImages('favicon');
        return redirect()->route('admin.settings.index')->with('success', 'Favicon berhasil dihapus.');
    }

    /**
     * Helper to save setting
     */
    private function saveSetting($section, $key, $value, $page = 'settings')
    {
        Content::updateOrCreate(
            ['page' => $page, 'section' => $section, 'key' => $key],
            ['content' => $value]
        );
    }

    /**
     * Find image by prefix
     */
    private function findImage($prefix)
    {
        $extensions = ['png', 'jpg', 'jpeg', 'svg', 'webp', 'ico'];
        $basePath = public_path('images');

        foreach (glob($basePath . '/' . $prefix . '-*') as $file) {
            return basename($file);
        }

        foreach (glob($basePath . '/' . $prefix . '.*') as $file) {
            return basename($file);
        }

        return null;
    }

    /**
     * Delete old images by prefix
     */
    private function deleteOldImages($prefix)
    {
        $basePath = public_path('images');

        foreach (glob($basePath . '/' . $prefix . '-*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        foreach (glob($basePath . '/' . $prefix . '.*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
