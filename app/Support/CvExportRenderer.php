<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;
use ZipArchive;

class CvExportRenderer
{
    public static function renderHtml(string $templateSlug, array $data, string $documentTitle): string
    {
        $templatePath = resource_path('views/cv/templates/' . $templateSlug);
        $templateBladePath = $templatePath . '/template.blade.php';

        if (!File::exists($templateBladePath)) {
            abort(404, 'Template file not found');
        }

        $html = view('cv.templates.' . $templateSlug . '.template', [
            'data' => $data,
        ])->render();

        $cssPath = $templatePath . '/style.css';
        $cssContent = File::exists($cssPath) ? File::get($cssPath) : '';

        $fonts = '';
        if ($cssContent !== '' && preg_match_all('/@import\s+url\([^)]+\);/', $cssContent, $fontMatches)) {
            $fonts = '<style>' . implode("\n    ", $fontMatches[0]) . '</style>';
            $cssContent = preg_replace('/@import\s+url\([^)]+\);\s*/', '', $cssContent);
        }

        $css = '<style>' . $cssContent . '</style>';
        $printStyles = '<style>' . self::exportPrintStyles() . '</style>';
        $safeTitle = htmlspecialchars($documentTitle !== '' ? $documentTitle : 'My resume', ENT_QUOTES, 'UTF-8');

        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume - ' . $safeTitle . '</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    ' . $fonts . '
    ' . $css . '
    ' . $printStyles . '
</head>
<body style="margin: 0; padding: 0; background: white; overflow: visible;">
    <div style="width: 210mm; margin: 0 auto; position: relative;">
    ' . $html . '
    </div>
</body>
</html>';
    }

    public static function generatePdfBytes(string $fullHtml): string
    {
        @set_time_limit(180);

        $lastError = null;
        for ($attempt = 1; $attempt <= 2; $attempt++) {
            try {
                return self::makeBrowsershot($fullHtml)->pdf();
            } catch (\Throwable $e) {
                $lastError = $e;
                if ($attempt < 2) {
                    usleep(750000);
                }
            }
        }

        throw $lastError;
    }

    /**
     * @return array{0: string, 1: string, 2: string} [body, contentType, filename]
     */
    public static function buildPngDownload(string $fullHtml, string $baseName): array
    {
        $pdfBytes = self::generatePdfBytes($fullHtml);
        $pngPages = self::convertPdfBytesToPngPages($pdfBytes, $fullHtml);
        $datedBase = self::datedExportBaseName($baseName);

        if (count($pngPages) === 1) {
            return [$pngPages[0], 'image/png', $datedBase . '.png'];
        }

        $zipBytes = self::zipPngPages($pngPages);
        if ($zipBytes === null) {
            abort(500, 'Unable to create ZIP archive.');
        }

        return [$zipBytes, 'application/zip', $datedBase . '.zip'];
    }

    public static function sanitizeExportFilename(string $name, string $extension): string
    {
        $filename = self::datedExportBaseName($name) . '.' . ltrim($extension, '.');
        $filename = preg_replace('/[^A-Za-z0-9_.-]/', '', $filename);

        return $filename !== '' ? $filename : ('resume_' . date('Y-m-d') . '.' . ltrim($extension, '.'));
    }

    private static function datedExportBaseName(string $name): string
    {
        $base = str_replace(' ', '_', $name !== '' ? $name : 'My_resume');
        $base = preg_replace('/[^A-Za-z0-9_.-]/', '', $base);

        return ($base !== '' ? $base : 'My_resume') . '_' . date('Y-m-d');
    }

    private static function makeBrowsershot(string $fullHtml): Browsershot
    {
        $shot = Browsershot::html($fullHtml)
            ->format('A4')
            ->margins(0, 0, 0, 0, 'mm')
            ->showBackground()
            ->setOption('waitUntil', 'load')
            ->timeout(120)
            ->protocolTimeout(120)
            ->delay(1500)
            ->noSandbox()
            ->setNodeModulePath(base_path())
            ->addChromiumArguments([
                'disable-dev-shm-usage',
                'disable-gpu',
                'no-first-run',
            ])
            ->setOption('viewport', [
                'width' => 794,
                'height' => 1123,
            ])
            ->setOption('preferCSSPageSize', false)
            ->setOption('printBackground', true);

        $nodeBinary = self::resolveNodeBinary();
        if ($nodeBinary !== null) {
            $shot->setNodeBinary($nodeBinary);
        }

        $chromePath = self::resolveChromePath();
        if ($chromePath !== null) {
            $shot->setChromePath($chromePath);
        }

        return $shot;
    }

    private static function resolveNodeBinary(): ?string
    {
        $configured = env('BROWSERSHOT_NODE_BINARY');
        if (is_string($configured) && $configured !== '' && is_file($configured)) {
            return $configured;
        }

        if (PHP_OS_FAMILY === 'Windows') {
            $candidates = [
                'C:\\Program Files\\nodejs\\node.exe',
                getenv('PROGRAMFILES') . '\\nodejs\\node.exe',
            ];
            foreach ($candidates as $path) {
                if (is_string($path) && $path !== '' && is_file($path)) {
                    return $path;
                }
            }
        }

        return null;
    }

    private static function resolveChromePath(): ?string
    {
        $configured = env('BROWSERSHOT_CHROME_PATH');
        if (is_string($configured) && $configured !== '' && is_file($configured)) {
            return $configured;
        }

        if (PHP_OS_FAMILY === 'Windows') {
            $candidates = [
                'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
                'C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe',
            ];
            foreach ($candidates as $path) {
                if (is_file($path)) {
                    return $path;
                }
            }
        }

        return null;
    }

    /**
     * @return list<string>
     */
    private static function convertPdfBytesToPngPages(string $pdfBytes, string $fullHtml): array
    {
        $pdfPath = self::writeTempFile($pdfBytes, 'pdf');

        try {
            if (class_exists(\Imagick::class)) {
                return self::convertPdfViaImagick($pdfPath);
            }

            $viaPoppler = self::convertPdfViaPdftoppm($pdfPath);
            if ($viaPoppler !== null) {
                return $viaPoppler;
            }

            return self::convertHtmlViaBrowsershotClips($fullHtml, self::countPdfPages($pdfBytes));
        } finally {
            @unlink($pdfPath);
        }
    }

    /**
     * @return list<string>
     */
    private static function convertPdfViaImagick(string $pdfPath): array
    {
        $imagick = new \Imagick();
        $imagick->setResolution(150, 150);
        $imagick->readImage($pdfPath);
        $imagick->setImageBackgroundColor('white');
        $imagick->setImageAlphaChannel(\Imagick::ALPHACHANNEL_REMOVE);

        $pages = [];
        foreach ($imagick as $frame) {
            $frame->setImageFormat('png');
            $frame->setImageCompressionQuality(92);
            $pages[] = $frame->getImageBlob();
        }

        $imagick->clear();
        $imagick->destroy();

        if ($pages === []) {
            abort(500, 'PNG generation produced no pages.');
        }

        return $pages;
    }

    /**
     * @return list<string>|null
     */
    private static function convertPdfViaPdftoppm(string $pdfPath): ?array
    {
        $outDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'cv_png_' . uniqid('', true);
        if (!@mkdir($outDir) && !is_dir($outDir)) {
            return null;
        }

        $prefix = $outDir . DIRECTORY_SEPARATOR . 'page';
        $cmd = 'pdftoppm -png -r 150 ' . escapeshellarg($pdfPath) . ' ' . escapeshellarg($prefix);
        @exec($cmd, $output, $code);

        $files = glob($prefix . '-*.png') ?: [];
        natsort($files);

        $pages = [];
        foreach ($files as $file) {
            $bytes = @file_get_contents($file);
            if ($bytes !== false) {
                $pages[] = $bytes;
            }
        }

        foreach ($files as $file) {
            @unlink($file);
        }
        @rmdir($outDir);

        if ($code !== 0 || $pages === []) {
            return null;
        }

        return $pages;
    }

    /**
     * Fallback when Imagick/poppler are unavailable: slice the HTML export into A4 clips.
     *
     * @return list<string>
     */
    private static function convertHtmlViaBrowsershotClips(string $fullHtml, int $pageCount): array
    {
        $pageCount = max(1, $pageCount);
        $pageWidth = 794;
        $pageHeight = 1123;
        $pages = [];

        for ($i = 0; $i < $pageCount; $i++) {
            $clipY = $i * $pageHeight;
            $pages[] = self::makeBrowsershot($fullHtml)
                ->clip(0, $clipY, $pageWidth, $pageHeight)
                ->deviceScaleFactor(2)
                ->screenshot();
        }

        return $pages;
    }

    private static function countPdfPages(string $pdfBytes): int
    {
        if (preg_match_all('/\/Type\s*\/Page([^s]|$)/', $pdfBytes, $matches)) {
            $count = count($matches[0]);
            if ($count > 0) {
                return $count;
            }
        }

        return 1;
    }

    /**
     * @param list<string> $pngPages
     */
    private static function zipPngPages(array $pngPages): ?string
    {
        $zipPath = tempnam(sys_get_temp_dir(), 'cv_zip_');
        if ($zipPath === false) {
            return null;
        }

        $zipFile = $zipPath . '.zip';
        @unlink($zipPath);

        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return null;
        }

        foreach ($pngPages as $index => $pngBytes) {
            $zip->addFromString(($index + 1) . '.png', $pngBytes);
        }

        $zip->close();
        $bytes = @file_get_contents($zipFile);
        @unlink($zipFile);

        return $bytes === false ? null : $bytes;
    }

    private static function writeTempFile(string $bytes, string $extension): string
    {
        $tmp = tempnam(sys_get_temp_dir(), 'cv_export_');
        if ($tmp === false) {
            abort(500, 'Unable to create temporary file.');
        }

        $path = $tmp . '.' . ltrim($extension, '.');
        rename($tmp, $path);
        file_put_contents($path, $bytes);

        return $path;
    }

    private static function exportPrintStyles(): string
    {
        return <<<'CSS'
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
            box-sizing: border-box !important;
        }
        @page {
            margin: 0 !important;
            margin-top: 10mm !important;
        }
        @page :first {
            margin-top: 0 !important;
        }
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 210mm !important;
            background: white !important;
            overflow: visible !important;
        }
        .cv-template.modern .cv-page {
            display: grid !important;
            grid-template-rows: auto 1fr !important;
            grid-template-areas:
                "top-bar"
                "main" !important;
        }
        .cv-template.modern .top-green {
            display: grid !important;
            grid-template-columns: 57.2mm 0.3mm 1fr !important;
            grid-template-areas: "photo-container gap top-content-area" !important;
        }
        .cv-template.modern .main-content {
            display: grid !important;
            grid-template-columns: 57.2mm 6.3mm 1fr !important;
            grid-template-areas: "left-green gap right-content" !important;
        }
        .cv-template.modern section {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .cv-template.modern .section-content {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .cv-template.modern section.experience,
        .cv-template.modern section.education {
            page-break-inside: auto !important;
            break-inside: auto !important;
        }
        .cv-template.modern section.experience .section-content,
        .cv-template.modern section.education .section-content {
            page-break-inside: auto !important;
            break-inside: auto !important;
        }
        .cv-template.modern .experience-item,
        .cv-template.modern .education-item,
        .cv-template.modern .certification-item,
        .cv-template.modern .skill-item,
        .cv-template.modern .language-item,
        .cv-template.modern .reference-item {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .cv-template.modern .name {
            margin: 0 !important;
            margin-bottom: 0 !important;
            line-height: 1.1 !important;
        }
        .cv-template.modern .subtitle {
            margin: 0 !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        img {
            max-width: 100% !important;
            height: auto !important;
        }
        .cv-pages-wrapper,
        .cv-page-container {
            display: block !important;
            width: 100% !important;
            min-height: auto !important;
            max-height: none !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background: transparent !important;
            overflow: visible !important;
            page-break-after: auto !important;
            break-after: auto !important;
        }
        .cv-page-container .cv-template {
            width: 100% !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
        }
CSS;
    }
}
