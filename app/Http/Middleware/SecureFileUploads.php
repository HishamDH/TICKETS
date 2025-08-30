<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SecureFileUploads
{
    public function handle(Request $request, Closure $next)
    {
        foreach ($request->allFiles() as $file) {
            if ($file instanceof UploadedFile) {

                if ($file->getSize() > 10 * 1024 * 1024) {
                    abort(413, 'الملف كبير جدًا.');
                }

                $allowed = [
                    'image/jpeg',
                    'image/png',
                    'image/jpg',
                    'image/gif',
                    //'image/svg+xml',
                    'image/webp',      
                    'image/bmp',       
                    'image/tiff',       
                    'image/x-icon',    
                    'image/heif',     
                    'image/heic',       
                    'video/mp4',
                    'video/quicktime'
                ];
                

                if (!in_array($file->getMimeType(), $allowed)) {
                    abort(415, 'نوع الملف غير مسموح.');
                }
            }
        }

        return $next($request);
    }
}
