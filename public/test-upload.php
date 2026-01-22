<?php
/**
 * Script Test Upload & Diagnosa Masalah Gambar
 * 
 * CARA MENGGUNAKAN:
 * 1. Upload file ini ke public_html/test-upload.php
 * 2. Akses via browser: https://yourdomain.com/test-upload.php
 * 3. Test upload gambar
 * 4. Hapus file ini setelah selesai (KEAMANAN!)
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Upload Gambar</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 20px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #1e3a8a; border-bottom: 2px solid #1e3a8a; padding-bottom: 10px; }
        .success { color: #28a745; background: #d4edda; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .error { color: #dc3545; background: #f8d7da; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .info { color: #17a2b8; background: #d1ecf1; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .warning { color: #856404; background: #fff3cd; padding: 10px; margin: 10px 0; border-radius: 5px; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 5px; overflow-x: auto; }
        form { margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 5px; }
        input[type="file"] { margin: 10px 0; }
        button { background: #1e3a8a; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #1e40af; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background: #1e3a8a; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Test Upload & Diagnosa Masalah Gambar</h1>
        
        <?php
        $basePath = __DIR__;
        $imagesPath = $basePath . '/images';
        $errors = [];
        $success = [];
        $warnings = [];
        
        // 1. Cek struktur folder
        echo '<h2>1. Struktur Folder</h2>';
        $folders = ['berita', 'galeri', 'umkm', 'uploads/layanan', 'uploads/pengaduan'];
        
        echo '<table>';
        echo '<tr><th>Folder</th><th>Status</th><th>Writable</th><th>Permission</th></tr>';
        
        foreach ($folders as $folder) {
            $fullPath = $imagesPath . '/' . $folder;
            $exists = is_dir($fullPath);
            $writable = $exists ? is_writable($fullPath) : false;
            $perms = $exists ? substr(sprintf('%o', fileperms($fullPath)), -4) : 'N/A';
            
            $status = $exists ? '<span style="color:green">✅ Ada</span>' : '<span style="color:red">❌ Tidak Ada</span>';
            $writableStatus = $writable ? '<span style="color:green">✅ Ya</span>' : '<span style="color:red">❌ Tidak</span>';
            
            echo '<tr>';
            echo '<td><code>images/' . htmlspecialchars($folder) . '</code></td>';
            echo '<td>' . $status . '</td>';
            echo '<td>' . $writableStatus . '</td>';
            echo '<td>' . $perms . '</td>';
            echo '</tr>';
            
            if (!$exists) {
                $errors[] = "Folder images/$folder tidak ada";
            } elseif (!$writable) {
                $errors[] = "Folder images/$folder tidak writable (permission: $perms)";
            } else {
                $success[] = "Folder images/$folder OK";
            }
        }
        echo '</table>';
        
        // 2. Test Upload
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_image'])) {
            echo '<h2>2. Test Upload</h2>';
            
            $file = $_FILES['test_image'];
            $targetFolder = $_POST['folder'] ?? 'berita';
            $targetPath = $imagesPath . '/' . $targetFolder;
            
            if (!is_dir($targetPath)) {
                echo '<div class="error">❌ Folder images/' . htmlspecialchars($targetFolder) . ' tidak ada!</div>';
            } elseif (!is_writable($targetPath)) {
                echo '<div class="error">❌ Folder images/' . htmlspecialchars($targetFolder) . ' tidak writable!</div>';
                echo '<div class="info">Solusi: <code>chmod 755 ' . htmlspecialchars($targetPath) . '</code></div>';
            } else {
                // Validasi file
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($file['type'], $allowedTypes)) {
                    echo '<div class="error">❌ Tipe file tidak diizinkan: ' . htmlspecialchars($file['type']) . '</div>';
                } elseif ($file['error'] !== UPLOAD_ERR_OK) {
                    echo '<div class="error">❌ Error upload: ' . $file['error'] . '</div>';
                } else {
                    // Generate filename
                    $filename = 'test-' . time() . '-' . uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                    $targetFile = $targetPath . '/' . $filename;
                    
                    // Upload file
                    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                        // Set permission
                        chmod($targetFile, 0644);
                        
                        $fileSize = filesize($targetFile);
                        $filePerms = substr(sprintf('%o', fileperms($targetFile)), -4);
                        $fileUrl = '/images/' . $targetFolder . '/' . $filename;
                        
                        echo '<div class="success">✅ File berhasil di-upload!</div>';
                        echo '<table>';
                        echo '<tr><th>Property</th><th>Value</th></tr>';
                        echo '<tr><td>Filename</td><td><code>' . htmlspecialchars($filename) . '</code></td></tr>';
                        echo '<tr><td>Path</td><td><code>' . htmlspecialchars($targetFile) . '</code></td></tr>';
                        echo '<tr><td>URL</td><td><code>' . htmlspecialchars($fileUrl) . '</code></td></tr>';
                        echo '<tr><td>Size</td><td>' . number_format($fileSize / 1024, 2) . ' KB</td></tr>';
                        echo '<tr><td>Permission</td><td>' . $filePerms . '</td></tr>';
                        echo '<tr><td>Readable</td><td>' . (is_readable($targetFile) ? '✅ Ya' : '❌ Tidak') . '</td></tr>';
                        echo '</table>';
                        
                        // Test URL
                        echo '<h3>Test URL:</h3>';
                        echo '<div class="info">';
                        echo '<p>URL: <a href="' . htmlspecialchars($fileUrl) . '" target="_blank">' . htmlspecialchars($fileUrl) . '</a></p>';
                        echo '<p>Jika gambar muncul, berarti path dan permission benar.</p>';
                        echo '<p>Jika 404, cek:</p>';
                        echo '<ul>';
                        echo '<li>File benar-benar ada di: <code>' . htmlspecialchars($targetFile) . '</code></li>';
                        echo '<li>Permission file: <code>chmod 644 ' . htmlspecialchars($targetFile) . '</code></li>';
                        echo '<li>.htaccess tidak memblokir akses ke images</li>';
                        echo '</ul>';
                        echo '</div>';
                        
                        // Tampilkan gambar
                        echo '<h3>Preview:</h3>';
                        echo '<img src="' . htmlspecialchars($fileUrl) . '" alt="Test Image" style="max-width: 500px; border: 1px solid #ddd; padding: 10px; background: #f8f9fa;">';
                        
                        $success[] = "Upload test berhasil ke images/$targetFolder";
                    } else {
                        echo '<div class="error">❌ Gagal memindahkan file!</div>';
                        echo '<div class="info">';
                        echo '<p>Kemungkinan penyebab:</p>';
                        echo '<ul>';
                        echo '<li>Permission folder tidak writable</li>';
                        echo '<li>Disk space penuh</li>';
                        echo '<li>PHP upload_max_filesize terlalu kecil</li>';
                        echo '</ul>';
                        echo '</div>';
                        $errors[] = "Gagal upload file";
                    }
                }
            }
        } else {
            // Form upload
            echo '<h2>2. Test Upload Gambar</h2>';
            echo '<form method="POST" enctype="multipart/form-data">';
            echo '<div class="info">';
            echo '<p><strong>Pilih folder:</strong></p>';
            echo '<select name="folder" style="padding: 8px; width: 200px; margin: 10px 0;">';
            foreach ($folders as $folder) {
                echo '<option value="' . htmlspecialchars($folder) . '">' . htmlspecialchars($folder) . '</option>';
            }
            echo '</select>';
            echo '</div>';
            echo '<div class="info">';
            echo '<p><strong>Pilih gambar:</strong></p>';
            echo '<input type="file" name="test_image" accept="image/*" required>';
            echo '</div>';
            echo '<button type="submit">Upload Test</button>';
            echo '</form>';
        }
        
        // 3. Cek PHP Settings
        echo '<h2>3. PHP Upload Settings</h2>';
        echo '<table>';
        echo '<tr><th>Setting</th><th>Value</th><th>Status</th></tr>';
        
        $uploadMax = ini_get('upload_max_filesize');
        $postMax = ini_get('post_max_size');
        $maxExec = ini_get('max_execution_time');
        $memoryLimit = ini_get('memory_limit');
        
        echo '<tr><td>upload_max_filesize</td><td>' . $uploadMax . '</td><td>' . ($uploadMax ? '✅' : '❌') . '</td></tr>';
        echo '<tr><td>post_max_size</td><td>' . $postMax . '</td><td>' . ($postMax ? '✅' : '❌') . '</td></tr>';
        echo '<tr><td>max_execution_time</td><td>' . $maxExec . 's</td><td>' . ($maxExec > 30 ? '✅' : '⚠️') . '</td></tr>';
        echo '<tr><td>memory_limit</td><td>' . $memoryLimit . '</td><td>' . ($memoryLimit ? '✅' : '❌') . '</td></tr>';
        echo '</table>';
        
        // 4. Summary
        echo '<h2>4. Ringkasan</h2>';
        
        if (count($success) > 0) {
            echo '<div class="success"><strong>Berhasil (' . count($success) . '):</strong><ul>';
            foreach ($success as $msg) {
                echo '<li>' . htmlspecialchars($msg) . '</li>';
            }
            echo '</ul></div>';
        }
        
        if (count($warnings) > 0) {
            echo '<div class="warning"><strong>Peringatan (' . count($warnings) . '):</strong><ul>';
            foreach ($warnings as $msg) {
                echo '<li>' . htmlspecialchars($msg) . '</li>';
            }
            echo '</ul></div>';
        }
        
        if (count($errors) > 0) {
            echo '<div class="error"><strong>Error (' . count($errors) . '):</strong><ul>';
            foreach ($errors as $msg) {
                echo '<li>' . htmlspecialchars($msg) . '</li>';
            }
            echo '</ul></div>';
            
            echo '<h3>🔧 Solusi:</h3>';
            echo '<div class="info">';
            echo '<pre>';
            echo "cd public_html\n";
            echo "chmod -R 755 images\n";
            echo "find images -type f -exec chmod 644 {} \\;\n";
            echo '</pre>';
            echo '</div>';
        }
        
        echo '<div class="warning" style="margin-top: 30px;">';
        echo '<strong>⚠️ PENTING:</strong> Hapus file test-upload.php setelah selesai untuk keamanan!';
        echo '</div>';
        ?>
    </div>
</body>
</html>
