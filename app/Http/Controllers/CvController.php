<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\CvTemplate;
use App\Models\SiteSetting;
use App\Models\UserCV;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Support\CvExportRenderer;

class CvController extends Controller
{
    private function sanitizeRichText(?string $html): string
    {
        $html = (string) ($html ?? '');
        if (trim($html) === '') return '';

        // Allow a small safe subset used by Quill.
        $clean = strip_tags($html, '<p><br><strong><em><u><ol><ul><li><a><span>');

        // Remove inline event handlers and javascript: URLs.
        $clean = preg_replace('/\son\w+="[^"]*"/i', '', $clean);
        $clean = preg_replace("/\son\w+='[^']*'/i", '', $clean);
        $clean = preg_replace('/href\s*=\s*("|\')\s*javascript:[^"\']*\1/i', 'href="#"', $clean);

        return $clean;
    }

    private function sanitizeCvData($data)
    {
        if (!is_array($data)) return $data;
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $data[$k] = $this->sanitizeCvData($v);
            } else {
                if ($k === 'description' || $k === 'content') {
                    $data[$k] = $this->sanitizeRichText(is_string($v) ? $v : '');
                }
            }
        }
        return $data;
    }
    /**
     * Show CV template gallery
     */
    public function index()
    {
        $templateFolders = $this->buildActiveTemplateFolders();

        return view('cv.index', compact('templateFolders'));
    }

    /**
     * Active templates for gallery + builder template picker (preview, tab, etc.).
     */
    private function buildActiveTemplateFolders(): array
    {
        $dbTemplates = CvTemplate::where('is_active', true)->orderBy('name')->get();

        $templatesPath = resource_path('views/cv/templates');
        $templateFolders = [];

        foreach ($dbTemplates as $dbTemplate) {
            $templateSlug = $dbTemplate->slug;
            $templateFolder = $templatesPath . '/' . $templateSlug;

            $previewPath = null;
            if ($dbTemplate->preview_path) {
                $previewPath = asset($dbTemplate->preview_path);
            } else {
                $previewExtensions = ['webp', 'png', 'jpg', 'jpeg'];
                foreach ($previewExtensions as $ext) {
                    $previewFile = public_path('cv-templates/previews/' . $templateSlug . '-preview.' . $ext);
                    if (File::exists($previewFile)) {
                        $previewPath = asset('cv-templates/previews/' . $templateSlug . '-preview.' . $ext);
                        break;
                    }
                }
            }

            $templateFolders[] = [
                'slug' => $dbTemplate->slug,
                'name' => $dbTemplate->name,
                'description' => $dbTemplate->description ?? 'Professional resume template',
                'preview_path' => $previewPath,
                'folder_exists' => File::exists($templateFolder),
                'tab' => $this->resolveCvTemplateTab($dbTemplate->slug, $dbTemplate->config),
            ];
        }

        return $templateFolders;
    }

    /**
     * Which filter tab a template belongs to: popular | simple | modern | creative.
     * Optional override: config.tab or config.filter in CvTemplate JSON.
     */
    private function resolveCvTemplateTab(string $slug, $config): string
    {
        $config = is_array($config) ? $config : [];
        $fromConfig = $config['tab'] ?? $config['filter'] ?? null;
        if (is_string($fromConfig)) {
            $t = strtolower($fromConfig);
            if (in_array($t, ['popular', 'simple', 'modern', 'creative'], true)) {
                return $t;
            }
        }

        $slug = strtolower($slug);
        if (str_contains($slug, 'modern')) {
            return 'modern';
        }
        if (str_contains($slug, 'creative')) {
            return 'creative';
        }
        if (str_contains($slug, 'popular') || str_contains($slug, 'classic')) {
            return 'popular';
        }

        return 'simple';
    }
    
    /**
     * Show CV builder with selected template
     */
    public function builder($lang, $slug)
    {
        // Load template from database first (admin panel managed)
        $template = CvTemplate::where('slug', $slug)->where('is_active', true)->first();
        
        if (!$template) {
            abort(404, 'Template not found or inactive');
        }
        
        // Try to load config from database first, then fallback to filesystem
        $config = null;
        if ($template->config && is_array($template->config)) {
            $config = $template->config;
        } else {
            // Fallback: Load config from filesystem
            $templatePath = resource_path('views/cv/templates/' . $slug);
            $configPath = $templatePath . '/config.json';
            
            if (File::exists($configPath)) {
                $config = json_decode(File::get($configPath), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $config = null;
                }
            }
        }
        
        // If no config found, create a basic one
        if (!$config) {
            $config = [
                'name' => $template->name,
                'slug' => $template->slug,
                'description' => $template->description ?? 'Resume template',
                'sections' => [
                    'required' => ['header'],
                    'optional' => ['summary', 'experience', 'education', 'skills']
                ],
                'layout' => [
                    'type' => 'single-column'
                ],
                'styling' => [
                    'primary_color' => '#2563eb',
                    'font_family' => 'Arial, sans-serif'
                ]
            ];
        }
        
        // Check if template blade file exists (required for rendering)
        $templatePath = resource_path('views/cv/templates/' . $slug);
        $templateBladePath = $templatePath . '/template.blade.php';
        $templateExists = File::exists($templateBladePath);
        
        $templateFolders = $this->buildActiveTemplateFolders();

        return view('cv.builder', [
            'templateSlug' => $slug,
            'lang' => $lang,
            'config' => $config,
            'template' => $template,
            'templateExists' => $templateExists,
            'data' => [],
            'templateFolders' => $templateFolders,
        ]);
    }
    
    /**
     * Save user's CV data
     * 
     * Now using Laravel Auth - middleware ensures user is authenticated
     */
    public function save(Request $request)
    {
        // Get authenticated user ID using Laravel Auth
        $userId = Auth::id();
        
        // Validate request
        $request->validate([
            'template_slug' => 'required|string',
            'cv_data' => 'required|array',
            'title' => 'nullable|string|max:255',
            'cv_id' => 'nullable|integer',
        ]);
        
        try {
            $title = $request->input('title') ?? 'My resume';
            $cvData = $this->sanitizeCvData($request->input('cv_data'));

            // If cv_id is provided, update that CV (must belong to user). Otherwise create a new CV.
            if ($request->filled('cv_id')) {
                $cv = UserCV::withTrashed()
                    ->where('id', $request->input('cv_id'))
                    ->where('user_id', $userId)
                    ->first();

                if (!$cv) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Resume not found'
                    ], 404);
                }

                if ($cv->trashed()) {
                    $cv->restore();
                }

                $cv->template_slug = $request->input('template_slug');
                $cv->title = $title;
                $cv->cv_data = $cvData;
                $cv->is_active = true;
                $cv->save();
            } else {
                $cv = UserCV::create([
                    'user_id' => $userId,
                    'template_slug' => $request->input('template_slug'),
                    'title' => $title,
                    'cv_data' => $cvData,
                    'is_active' => true,
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Resume saved successfully!',
                'cv_id' => $cv->id,
                'cv' => [
                    'id' => $cv->id,
                    'title' => $cv->title,
                    'template_slug' => $cv->template_slug,
                    'updated_at' => $cv->updated_at,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving resume: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Step 3: Upload a resume file for import (authenticated).
     * Stores the file and returns an import_id for the next processing steps.
     */
    public function importUpload(Request $request, $lang)
    {
        $userId = Auth::id();

        $request->validate([
            'resume' => 'required|file|max:3072|mimes:pdf,docx,jpg,jpeg,png,webp',
        ]);

        try {
            /** @var \Illuminate\Http\UploadedFile $file */
            $file = $request->file('resume');

            $importId = (string) Str::uuid();
            $ext = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'bin');
            $storedName = $importId . '.' . $ext;

            $dir = 'cv-imports/' . $userId;
            $storedPath = $file->storeAs($dir, $storedName);

            // Write a small metadata file so Step 4 can find this upload by import_id.
            $meta = [
                'import_id' => $importId,
                'user_id' => (int) $userId,
                'stored_path' => $storedPath,
                'original_name' => $file->getClientOriginalName(),
                'mime' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'uploaded_at' => now()->toISOString(),
            ];
            Storage::put($dir . '/' . $importId . '.meta.json', json_encode($meta, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            return response()->json([
                'success' => true,
                'import_id' => $importId,
                'original_name' => $file->getClientOriginalName(),
                'mime' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'stored_path' => $storedPath,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Step 4: Extract raw text from an uploaded resume.
     * - DOCX: local extraction
     * - PDF: try local text extraction (pdftotext), fallback to Vision OCR if empty/low
     * - Image: Vision OCR
     */
    public function importExtract(Request $request, $lang, string $importId)
    {
        $userId = Auth::id();

        $dir = 'cv-imports/' . $userId;
        $metaPath = $dir . '/' . $importId . '.meta.json';
        if (!Storage::exists($metaPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Import not found',
            ], 404);
        }

        $meta = json_decode(Storage::get($metaPath), true) ?: [];
        $storedPath = $meta['stored_path'] ?? null;
        if (!is_string($storedPath) || $storedPath === '' || !Storage::exists($storedPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Stored file missing',
            ], 404);
        }

        $abs = Storage::path($storedPath);
        $ext = strtolower(pathinfo($abs, PATHINFO_EXTENSION));

        try {
            $result = $this->extractResumeText($abs, $ext);

            $out = [
                'success' => true,
                'import_id' => $importId,
                'method' => $result['method'] ?? 'unknown',
                'raw_text' => $result['raw_text'] ?? '',
                'warnings' => $result['warnings'] ?? [],
            ];

            // persist extracted text for later steps
            Storage::put($dir . '/' . $importId . '.text.json', json_encode([
                'import_id' => $importId,
                'method' => $out['method'],
                'raw_text' => $out['raw_text'],
                'warnings' => $out['warnings'],
                'extracted_at' => now()->toISOString(),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            return response()->json($out);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Extraction failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Step 5: Parse extracted resume text with Gemini into builder-shaped JSON.
     */
    public function importParse(Request $request, $lang, string $importId)
    {
        $userId = Auth::id();
        $apiKey = (string) (config('services.gemini.api_key') ?: env('GEMINI_API_KEY') ?: '');
        if ($apiKey === '') {
            return response()->json([
                'success' => false,
                'message' => 'Gemini is not configured. Set GEMINI_API_KEY in .env.',
            ], 503);
        }

        $dir = 'cv-imports/' . $userId;
        $textPath = $dir . '/' . $importId . '.text.json';
        if (!Storage::exists($textPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Extracted text not found. Run extract first.',
            ], 404);
        }

        $textPayload = json_decode(Storage::get($textPath), true) ?: [];
        $rawText = isset($textPayload['raw_text']) ? (string) $textPayload['raw_text'] : '';
        if (trim($rawText) === '') {
            return response()->json([
                'success' => false,
                'message' => 'No text to parse.',
            ], 422);
        }

        // Keep prompt size reasonable (2–3 page CVs should be well under this).
        $maxChars = 50000;
        if (mb_strlen($rawText) > $maxChars) {
            $rawText = mb_substr($rawText, 0, $maxChars);
        }

        $model = (string) (config('services.gemini.model') ?: env('GEMINI_MODEL') ?: 'gemini-2.0-flash');
        $url = sprintf(
            'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent',
            rawurlencode($model)
        );

        try {
            $prompt = $this->geminiCvParsePrompt($rawText);

            $httpResp = Http::timeout(120)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url . '?key=' . rawurlencode($apiKey), [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [['text' => $prompt]],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.1,
                        'responseMimeType' => 'application/json',
                    ],
                ]);

            if (!$httpResp->successful()) {
                $err = $httpResp->json('error.message') ?? $httpResp->body();

                return response()->json([
                    'success' => false,
                    'message' => 'Gemini request failed: ' . (is_string($err) ? $err : json_encode($err)),
                ], 502);
            }

            $body = $httpResp->json();
            $jsonText = $body['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if (!is_string($jsonText) || trim($jsonText) === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Gemini returned no parseable JSON.',
                ], 502);
            }

            $parsed = json_decode($this->stripJsonFences($jsonText), true);
            if (!is_array($parsed)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Model output was not valid JSON.',
                ], 502);
            }

            $parsedCv = $this->normalizeParsedCvForBuilder($parsed);

            Storage::put($dir . '/' . $importId . '.parsed.json', json_encode([
                'import_id' => $importId,
                'model' => $model,
                'parsed_cv' => $parsedCv,
                'parsed_at' => now()->toISOString(),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            return response()->json([
                'success' => true,
                'import_id' => $importId,
                'parsed_cv' => $parsedCv,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Parse failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function geminiCvParsePrompt(string $resumeText): string
    {
        return <<<PROMPT
You are a resume parser. Extract structured data from the resume text below.

Rules:
- Output a single JSON object only. No markdown, no commentary.
- Use ONLY these top-level keys (all strings unless noted as arrays):
  name, job_title, email, phone, city, country, address, summary, photo,
  experience (array), education (array), skills (array), certifications (array),
  awards (array), projects (array), languages (array), references (array).
- If a value is unknown, use "" or [] — do not invent email/phone/employers.
- summary: plain text only (no HTML).
- experience items: title, company, start_date, end_date, location, description, period (strings).
  Prefer start_date/end_date as MM/YYYY when possible; use "" if unclear.
  If end is current, end_date may be "" and you may set period like "01/2022 - Present" if dates support it.
- education items: degree, institution, start_date, end_date, location, period (strings). Same date preference.
- skills items: skill (string), level (string). level must be one of: "", "Beginner", "Intermediate", "Advanced", "Expert".
- languages items: language (string), proficiency (string). proficiency must be one of: "", "Native", "Fluent", "Advanced", "Intermediate", "Basic".
- certifications: name, issuer, date, credential_id
- awards: title, organization, date, description
- projects: name, description, technologies, link
- references: name, position, company, email, phone
- photo: always "" (we do not extract photos).
- Keep at most 12 items per array section.

Resume text:
---
{$resumeText}
---
PROMPT;
    }

    private function stripJsonFences(string $text): string
    {
        $t = trim($text);
        if (preg_match('/^```(?:json)?\s*(.*?)\s*```$/is', $t, $m)) {
            return trim($m[1]);
        }

        return $t;
    }

    private function normalizeParsedCvForBuilder(array $in): array
    {
        $out = $this->cvParseContractSkeleton();

        foreach (['name', 'job_title', 'email', 'phone', 'city', 'country', 'address', 'summary', 'photo'] as $k) {
            if (isset($in[$k]) && (is_string($in[$k]) || is_numeric($in[$k]))) {
                $out[$k] = trim((string) $in[$k]);
            }
        }

        $out['summary'] = $this->sanitizeRichText($out['summary']);
        $out['photo'] = '';

        $skillLevels = ['' => true, 'Beginner' => true, 'Intermediate' => true, 'Advanced' => true, 'Expert' => true];
        $langLevels = ['' => true, 'Native' => true, 'Fluent' => true, 'Advanced' => true, 'Intermediate' => true, 'Basic' => true];

        $out['experience'] = $this->normalizeSectionList(
            $in['experience'] ?? [],
            ['title', 'company', 'start_date', 'end_date', 'location', 'description', 'period'],
            12,
            ['description']
        );

        $out['education'] = $this->normalizeSectionList(
            $in['education'] ?? [],
            ['degree', 'institution', 'start_date', 'end_date', 'location', 'period'],
            12,
            []
        );

        $skills = [];
        if (is_array($in['skills'] ?? null)) {
            foreach (array_slice($in['skills'], 0, 12) as $row) {
                if (!is_array($row)) {
                    continue;
                }
                $level = isset($row['level']) ? trim((string) $row['level']) : '';
                if (!isset($skillLevels[$level])) {
                    $level = '';
                }
                $skills[] = [
                    'skill' => isset($row['skill']) ? trim((string) $row['skill']) : '',
                    'level' => $level,
                ];
            }
        }
        $out['skills'] = $skills;

        $out['certifications'] = $this->normalizeSectionList(
            $in['certifications'] ?? [],
            ['name', 'issuer', 'date', 'credential_id'],
            12,
            []
        );

        $out['awards'] = $this->normalizeSectionList(
            $in['awards'] ?? [],
            ['title', 'organization', 'date', 'description'],
            12,
            ['description']
        );

        $out['projects'] = $this->normalizeSectionList(
            $in['projects'] ?? [],
            ['name', 'description', 'technologies', 'link'],
            12,
            ['description']
        );

        $langs = [];
        if (is_array($in['languages'] ?? null)) {
            foreach (array_slice($in['languages'], 0, 12) as $row) {
                if (!is_array($row)) {
                    continue;
                }
                $p = isset($row['proficiency']) ? trim((string) $row['proficiency']) : '';
                if (!isset($langLevels[$p])) {
                    $p = '';
                }
                $langs[] = [
                    'language' => isset($row['language']) ? trim((string) $row['language']) : '',
                    'proficiency' => $p,
                ];
            }
        }
        $out['languages'] = $langs;

        $out['references'] = $this->normalizeSectionList(
            $in['references'] ?? [],
            ['name', 'position', 'company', 'email', 'phone'],
            12,
            []
        );

        return $this->sanitizeCvData($out);
    }

    private function cvParseContractSkeleton(): array
    {
        return [
            'name' => '',
            'job_title' => '',
            'email' => '',
            'phone' => '',
            'city' => '',
            'country' => '',
            'address' => '',
            'summary' => '',
            'photo' => '',
            'experience' => [],
            'education' => [],
            'skills' => [],
            'certifications' => [],
            'awards' => [],
            'projects' => [],
            'languages' => [],
            'references' => [],
        ];
    }

    /**
     * @param  array<int, string>  $richKeys  Keys to run through sanitizeRichText
     * @return array<int, array<string, string>>
     */
    private function normalizeSectionList($list, array $allowedKeys, int $max, array $richKeys = []): array
    {
        if (!is_array($list)) {
            return [];
        }

        $richSet = array_fill_keys($richKeys, true);
        $out = [];
        foreach (array_slice($list, 0, $max) as $row) {
            if (!is_array($row)) {
                continue;
            }
            $item = [];
            foreach ($allowedKeys as $k) {
                $v = $row[$k] ?? '';
                $v = is_string($v) || is_numeric($v) ? trim((string) $v) : '';
                if (isset($richSet[$k])) {
                    $v = $this->sanitizeRichText($v);
                }
                $item[$k] = $v;
            }
            $out[] = $item;
        }

        return $out;
    }

    private function extractResumeText(string $absPath, string $ext): array
    {
        $ext = strtolower($ext);

        if ($ext === 'docx') {
            return [
                'method' => 'docx',
                'raw_text' => $this->extractDocxText($absPath),
                'warnings' => [],
            ];
        }

        if ($ext === 'pdf') {
            $text = $this->extractPdfTextViaPoppler($absPath);
            $clean = $this->normalizeExtractedText($text);

            // Heuristic: if too little text, treat as scanned and OCR.
            if (mb_strlen($clean) < 200) {
                $ocrText = $this->extractPdfTextViaVisionOcr($absPath);
                return [
                    'method' => 'vision_ocr_pdf',
                    'raw_text' => $this->normalizeExtractedText($ocrText),
                    'warnings' => ['PDF text extraction returned very little text; used OCR fallback.'],
                ];
            }

            return [
                'method' => 'pdf_text',
                'raw_text' => $clean,
                'warnings' => [],
            ];
        }

        // images → OCR
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            $ocrText = $this->extractImageTextViaVisionOcr($absPath);
            return [
                'method' => 'vision_ocr_image',
                'raw_text' => $this->normalizeExtractedText($ocrText),
                'warnings' => [],
            ];
        }

        throw new \RuntimeException('Unsupported file type: ' . $ext);
    }

    private function normalizeExtractedText(string $text): string
    {
        $t = str_replace(["\r\n", "\r"], "\n", (string) $text);
        // collapse 3+ newlines to 2
        $t = preg_replace("/\n{3,}/", "\n\n", $t) ?? $t;
        return trim($t);
    }

    private function extractPdfTextViaPoppler(string $absPath): string
    {
        // Requires poppler's pdftotext to be installed and on PATH.
        $tmpOut = tempnam(sys_get_temp_dir(), 'cv_pdf_');
        if ($tmpOut === false) {
            throw new \RuntimeException('Unable to create temp file');
        }

        // pdftotext writes to file; we read it back.
        $outFile = $tmpOut . '.txt';
        @unlink($outFile);

        $bin = $this->resolvePopplerBin('pdftotext', env('POPPLER_PDFTOTEXT'));
        $cmd = [$bin, '-layout', $absPath, $outFile];
        $proc = new \Symfony\Component\Process\Process($cmd);
        $proc->setTimeout(60);
        $proc->run();

        if (!$proc->isSuccessful()) {
            throw new \RuntimeException('pdftotext failed (bin=' . $bin . '): ' . $proc->getErrorOutput());
        }

        $text = is_file($outFile) ? file_get_contents($outFile) : '';
        @unlink($outFile);
        @unlink($tmpOut);

        return (string) ($text ?: '');
    }

    private function extractDocxText(string $absPath): string
    {
        if (!class_exists(\PhpOffice\PhpWord\IOFactory::class)) {
            throw new \RuntimeException('PHPWord is not installed');
        }

        $phpWord = \PhpOffice\PhpWord\IOFactory::load($absPath, 'Word2007');
        $parts = [];
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $el) {
                // best-effort: convert common element types to text
                if (method_exists($el, 'getText')) {
                    $parts[] = (string) $el->getText();
                } elseif ($el instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    $runText = '';
                    foreach ($el->getElements() as $runEl) {
                        if (method_exists($runEl, 'getText')) {
                            $runText .= (string) $runEl->getText();
                        }
                    }
                    if (trim($runText) !== '') $parts[] = $runText;
                } elseif ($el instanceof \PhpOffice\PhpWord\Element\Table) {
                    foreach ($el->getRows() as $row) {
                        $rowParts = [];
                        foreach ($row->getCells() as $cell) {
                            $cellText = '';
                            foreach ($cell->getElements() as $cellEl) {
                                if (method_exists($cellEl, 'getText')) {
                                    $cellText .= (string) $cellEl->getText() . ' ';
                                }
                            }
                            $rowParts[] = trim($cellText);
                        }
                        $line = trim(implode(' | ', array_filter($rowParts, fn($v) => $v !== '')));
                        if ($line !== '') $parts[] = $line;
                    }
                }
            }
        }
        return trim(implode("\n", array_filter(array_map('trim', $parts), fn($v) => $v !== '')));
    }

    private function visionClient(): \Google\Cloud\Vision\V1\Client\ImageAnnotatorClient
    {
        $keyFilePath = storage_path('app/keys/google-vision.json');
        if (!is_file($keyFilePath)) {
            throw new \RuntimeException('Google Vision key file not found at: ' . $keyFilePath);
        }
        return new \Google\Cloud\Vision\V1\Client\ImageAnnotatorClient([
            'credentials' => $keyFilePath,
        ]);
    }

    private function extractImageTextViaVisionOcr(string $absPath): string
    {
        $client = $this->visionClient();
        try {
            $imageData = file_get_contents($absPath);
            if ($imageData === false) throw new \RuntimeException('Unable to read image');

            $img = new \Google\Cloud\Vision\V1\Image();
            $img->setContent($imageData);

            $feature = new \Google\Cloud\Vision\V1\Feature();
            $feature->setType(\Google\Cloud\Vision\V1\Feature\Type::DOCUMENT_TEXT_DETECTION);

            $req = new \Google\Cloud\Vision\V1\AnnotateImageRequest();
            $req->setImage($img);
            $req->setFeatures([$feature]);

            $batch = new \Google\Cloud\Vision\V1\BatchAnnotateImagesRequest();
            $batch->setRequests([$req]);

            // GAPIC client uses batchAnnotateImages to perform OCR.
            $batchResp = $client->batchAnnotateImages($batch);
            $responses = $batchResp->getResponses();
            if (count($responses) < 1) return '';

            $first = $responses[0];
            $annotation = $first->getFullTextAnnotation();
            return $annotation ? (string) $annotation->getText() : '';
        } finally {
            $client->close();
        }
    }

    private function extractPdfTextViaVisionOcr(string $absPath): string
    {
        // MVP approach: rasterize PDF pages to images using poppler's pdftoppm, then OCR each page.
        // Requires pdftoppm on PATH.
        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'cv_pdf_' . Str::random(8);
        if (!@mkdir($tmpDir, 0777, true) && !is_dir($tmpDir)) {
            throw new \RuntimeException('Unable to create temp dir');
        }

        $prefix = $tmpDir . DIRECTORY_SEPARATOR . 'page';
        $bin = $this->resolvePopplerBin('pdftoppm', env('POPPLER_PDFTOPPM'));
        $cmd = [$bin, '-png', '-r', '200', $absPath, $prefix];
        $proc = new \Symfony\Component\Process\Process($cmd);
        $proc->setTimeout(120);
        $proc->run();
        if (!$proc->isSuccessful()) {
            throw new \RuntimeException('pdftoppm failed (bin=' . $bin . '): ' . $proc->getErrorOutput());
        }

        $files = glob($prefix . '-*.png') ?: [];
        sort($files, SORT_NATURAL);

        $all = [];
        foreach ($files as $img) {
            $all[] = $this->extractImageTextViaVisionOcr($img);
        }

        // cleanup
        foreach ($files as $img) @unlink($img);
        @rmdir($tmpDir);

        return trim(implode("\n\n", array_filter(array_map('trim', $all), fn($v) => $v !== '')));
    }

    private function resolvePopplerBin(string $baseName, $configuredPath = null): string
    {
        $configuredPath = is_string($configuredPath) ? trim($configuredPath) : '';
        $isWindows = DIRECTORY_SEPARATOR === '\\';
        $exe = $isWindows ? ($baseName . '.exe') : $baseName;

        $candidates = [];
        if ($configuredPath !== '') {
            $candidates[] = $configuredPath;
        }

        // Common Windows install locations (including user's provided folder pattern)
        if ($isWindows) {
            $candidates[] = 'C:\\poppler-25.12.0\\Library\\bin\\' . $exe;
            $candidates[] = 'C:\\poppler\\Library\\bin\\' . $exe;
            $candidates[] = 'C:\\Program Files\\poppler\\Library\\bin\\' . $exe;
            $candidates[] = 'C:\\Program Files (x86)\\poppler\\Library\\bin\\' . $exe;
        }

        // Fall back to relying on PATH
        $candidates[] = $baseName;

        foreach ($candidates as $p) {
            if ($p === $baseName) return $baseName;
            if (is_file($p)) return $p;
        }

        // If we got here, PATH fallback is last resort (will yield a clear error)
        return $baseName;
    }
    
    /**
     * Get user's saved CVs (soft-deleted excluded via UserCV global scope).
     *
     * Laravel Auth — middleware ensures user is authenticated.
     */
    public function getSavedCVs(Request $request)
    {
        // Get authenticated user ID using Laravel Auth
        $userId = Auth::id();
        
        try {
            $cvs = UserCV::where('user_id', $userId)
                ->orderBy('updated_at', 'desc')
                ->get(['id', 'title', 'template_slug', 'created_at', 'updated_at']);
            
            return response()->json([
                'success' => true,
                'cvs' => $cvs
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading resumes: ' . $e->getMessage(),
                'cvs' => []
            ], 500);
        }
    }

    /**
     * Projects page (saved resumes; soft-deleted excluded via UserCV global scope).
     * Auth middleware protects this route.
     */
    public function projects(Request $request)
    {
        $userId = Auth::id();

        $cvs = UserCV::where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->get(['id', 'title', 'template_slug', 'created_at', 'updated_at']);

        return view('cv.projects', [
            'cvs' => $cvs,
            'trashRetentionDays' => SiteSetting::getCvTrashRetentionDays(),
        ]);
    }

    /**
     * Trash page: soft-deleted CVs for the authenticated user (onlyTrashed).
     * Auth middleware protects this route.
     */
    public function trash(Request $request)
    {
        $userId = Auth::id();

        $cvs = UserCV::onlyTrashed()
            ->where('user_id', $userId)
            ->orderByDesc('deleted_at')
            ->get(['id', 'title', 'template_slug', 'created_at', 'updated_at', 'deleted_at']);

        return view('cv.trash', [
            'cvs' => $cvs,
            'trashRetentionDays' => SiteSetting::getCvTrashRetentionDays(),
        ]);
    }

    /**
     * Restore a soft-deleted CV from Trash (authenticated, owner-only).
     */
    public function restoreTrashedCv(Request $request, $lang, $id)
    {
        $userId = Auth::id();

        try {
            $cv = UserCV::onlyTrashed()
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();

            if (!$cv) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resume not found',
                ], 404);
            }

            $cv->restore();

            return response()->json([
                'success' => true,
                'message' => 'Resume restored',
                'cv' => [
                    'id' => $cv->id,
                    'title' => $cv->title,
                    'template_slug' => $cv->template_slug,
                    'updated_at' => $cv->updated_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error restoring resume: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Permanently delete a CV from Trash (authenticated, owner-only).
     */
    public function forceDeleteTrashedCv(Request $request, $lang, $id)
    {
        $userId = Auth::id();

        try {
            $cv = UserCV::onlyTrashed()
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();

            if (!$cv) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resume not found',
                ], 404);
            }

            $cv->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Resume permanently deleted',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting resume: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Load a specific saved CV (includes trashed so the builder can open items from Trash).
     *
     * Laravel Auth — middleware ensures user is authenticated.
     */
    public function loadCV(Request $request, $lang, $id)
    {
        // Get authenticated user ID using Laravel Auth
        $userId = Auth::id();
        
        try {
            $cv = UserCV::where('id', $id)
                ->where('user_id', $userId)
                ->first();

            if (!$cv) {
                $cv = UserCV::onlyTrashed()
                    ->where('id', $id)
                    ->where('user_id', $userId)
                    ->first();
            }

            if (!$cv) {
                // Non-trashed row with this id for another user → 403. Trashed → excluded here → 404.
                $cvExists = UserCV::where('id', $id)->exists();
                if ($cvExists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You do not have permission to access this resume'
                    ], 403);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Resume not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'cv' => [
                    'id' => $cv->id,
                    'title' => $cv->title,
                    'template_slug' => $cv->template_slug,
                    'cv_data' => $cv->cv_data
                ]
            ])->header('Cache-Control', 'private, no-store, no-cache, must-revalidate');
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading resume: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the title of a saved CV (authenticated).
     */
    public function updateTitle(Request $request, $lang, $id)
    {
        $userId = Auth::id();

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        try {
            $cv = UserCV::withTrashed()
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();
            if (!$cv) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resume not found'
                ], 404);
            }

            $cv->title = $request->input('title');
            $cv->save();

            return response()->json([
                'success' => true,
                'cv' => [
                    'id' => $cv->id,
                    'title' => $cv->title,
                    'updated_at' => $cv->updated_at,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating title: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft-delete a saved CV for the authenticated user (sets deleted_at; UserCV uses SoftDeletes).
     */
    public function deleteSaved(Request $request, $lang, $id)
    {
        $userId = Auth::id();

        try {
            $cv = UserCV::where('id', $id)->where('user_id', $userId)->first();
            if (!$cv) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resume not found'
                ], 404);
            }

            $cv->delete();

            return response()->json([
                'success' => true,
                'message' => 'Resume deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting resume: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Permanently delete an active saved CV (not in Trash). Used from Projects modal.
     */
    public function permanentDeleteSaved(Request $request, $lang, $id)
    {
        $userId = Auth::id();

        try {
            $cv = UserCV::where('id', $id)->where('user_id', $userId)->first();
            if (!$cv) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resume not found',
                ], 404);
            }

            $cv->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Resume permanently deleted',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting resume: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Duplicate a saved CV (same data & template). Title becomes {base}-copy01, {base}-copy02, …
     */
    public function duplicateSaved(Request $request, $lang, $id)
    {
        $userId = Auth::id();

        try {
            $source = UserCV::where('id', $id)->where('user_id', $userId)->first();
            if (!$source) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resume not found',
                ], 404);
            }

            $title = $this->nextDuplicateCvTitleForUser((string) ($source->title ?? 'My resume'), (int) $userId);

            $copy = UserCV::create([
                'user_id' => $userId,
                'template_slug' => $source->template_slug,
                'title' => $title,
                'cv_data' => $source->cv_data,
                'is_active' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Resume duplicated',
                'cv' => [
                    'id' => $copy->id,
                    'title' => $copy->title,
                    'template_slug' => $copy->template_slug,
                    'created_at' => $copy->created_at,
                    'updated_at' => $copy->updated_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error duplicating resume: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Next title in the form "{base}-copyNN" where base is the source title without a trailing -copyNN.
     */
    private function nextDuplicateCvTitleForUser(string $sourceTitle, int $userId): string
    {
        $base = preg_replace('/-copy\d+$/i', '', $sourceTitle);
        $base = trim($base);
        if ($base === '') {
            $base = 'My resume';
        }

        $pattern = '/^' . preg_quote($base, '/') . '-copy(\d+)$/i';

        $maxN = 0;
        $titles = UserCV::where('user_id', $userId)->pluck('title');
        foreach ($titles as $t) {
            if (preg_match($pattern, (string) $t, $m)) {
                $maxN = max($maxN, (int) $m[1]);
            }
        }

        $next = $maxN + 1;

        return $base . '-copy' . sprintf('%02d', $next);
    }
    
    /**
     * Export CV as PDF (active or trashed copy owned by the user).
     *
     * Laravel Auth — middleware ensures user is authenticated.
     */
    public function exportPDF(Request $request, $lang, $id)
    {
        $userId = Auth::id();

        try {
            $cv = $this->userCvActiveOrOwnedTrashed((int) $userId, $id);

            if (!$cv) {
                abort(404, 'Resume not found or you do not have permission to access it');
            }

            $template = CvTemplate::where('slug', $cv->template_slug)->where('is_active', true)->first();

            if (!$template) {
                abort(404, 'Template not found');
            }

            $data = $this->sanitizeCvData($cv->cv_data ?? []);
            $fullHtml = CvExportRenderer::renderHtml($cv->template_slug, $data, $cv->title ?? 'My resume');
            $pdf = CvExportRenderer::generatePdfBytes($fullHtml);
            $filename = CvExportRenderer::sanitizeExportFilename($cv->title ?? 'My_resume', 'pdf');

            return response($pdf, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'cv_id' => $id,
                'template' => $cv->template_slug ?? 'unknown',
            ]);

            if (strpos($e->getMessage(), 'Timeout') !== false) {
                abort(500, 'PDF generation timed out. Your resume may be too large. Please try reducing the content or contact support.');
            }

            abort(500, 'Error generating PDF: ' . $e->getMessage());
        }
    }

    /**
     * Live HTML preview for a saved CV (Projects / Trash). Includes trashed rows for the owner.
     *
     * Auth middleware ensures user is authenticated.
     */
    public function previewSaved(Request $request, $lang, $id)
    {
        $userId = Auth::id();

        $cv = $this->userCvActiveOrOwnedTrashed((int) $userId, $id);

        if (!$cv) {
            abort(404, 'Resume not found');
        }

        $templateSlug = (string) ($cv->template_slug ?? '');
        $template = CvTemplate::where('slug', $templateSlug)->where('is_active', true)->first();
        if (!$template) {
            abort(404, 'Template not found');
        }

        $templatePath = resource_path('views/cv/templates/' . $templateSlug);
        $templateBladePath = $templatePath . '/template.blade.php';
        if (!File::exists($templateBladePath)) {
            abort(404, 'Template file not found');
        }

        $data = $this->sanitizeCvData($cv->cv_data ?? []);
        $html = view('cv.templates.' . $templateSlug . '.template', ['data' => $data])->render();

        $cssPath = $templatePath . '/style.css';
        $cssContent = '';
        if (File::exists($cssPath)) {
            $cssContent = File::get($cssPath);
        }

        $fonts = '';
        if ($cssContent && preg_match_all('/@import\s+url\([^)]+\);/', $cssContent, $fontMatches)) {
            $fonts = '<style>' . implode("\n", $fontMatches[0]) . '</style>';
            $cssContent = preg_replace('/@import\s+url\([^)]+\);\s*/', '', $cssContent);
        }
        $css = '<style>' . $cssContent . '</style>';

        // Scale is used to fit an A4 canvas into a small iframe without scrollbars.
        $scale = (float) $request->query('scale', 0.35);
        if ($scale < 0.12) $scale = 0.12;
        if ($scale > 1.0) $scale = 1.0;
        $a4w = 794;  // px at 96dpi
        $a4h = 1123; // px at 96dpi
        $scaledW = (int) round($a4w * $scale);
        $scaledHFull = (int) round($a4h * $scale);
        $crop = (float) $request->query('crop', 1.0);
        if ($crop < 0.2) $crop = 0.2;
        if ($crop > 1.0) $crop = 1.0;
        $scaledH = (int) max(1, round($scaledHFull * $crop));

        $full = '<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Preview</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  ' . $fonts . '
  ' . $css . '
  <style>
    html, body {
      margin: 0;
      padding: 0;
      background: #fff;
      overflow: hidden;
      width: ' . $scaledW . 'px;
      height: ' . $scaledH . 'px;
    }
    .preview-viewport {
      width: ' . $scaledW . 'px;
      height: ' . $scaledH . 'px;
      overflow: hidden;
    }
    /* A4 canvas scaled down to match the iframe size */
    .preview-stage {
      width: ' . $a4w . 'px;
      height: ' . $a4h . 'px;
      transform: scale(' . $scale . ');
      transform-origin: top left;
    }
  </style>
</head>
<body>
  <div class="preview-viewport"><div class="preview-stage">' . $html . '</div></div>
</body>
</html>';

        return response($full, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }
    
    /**
     * Export current CV preview as PDF (without saving)
     */
    public function exportCurrentPDF(Request $request, $lang, $slug)
    {
        try {
            $data = $this->parseCvDataFromExportRequest($request);
            $template = CvTemplate::where('slug', $slug)->where('is_active', true)->first();

            if (!$template) {
                abort(404, 'Template not found');
            }

            $fullHtml = CvExportRenderer::renderHtml($slug, $data, $data['name'] ?? 'My resume');
            $pdf = CvExportRenderer::generatePdfBytes($fullHtml);
            $filename = CvExportRenderer::sanitizeExportFilename($data['name'] ?? 'My_resume', 'pdf');

            return response($pdf, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error (Current): ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'template' => $slug,
            ]);

            $errorMessage = 'Error generating PDF: ' . $e->getMessage();
            if (strpos($e->getMessage(), 'Timeout') !== false) {
                $errorMessage = 'PDF generation timed out. Your resume may be too large. Please try reducing the content or contact support.';
            }

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
            ], 500);
        }
    }

    /**
     * Export saved CV as PNG (single page) or ZIP of numbered PNGs (multi-page).
     */
    public function exportPNG(Request $request, $lang, $id)
    {
        $userId = Auth::id();

        try {
            $cv = $this->userCvActiveOrOwnedTrashed((int) $userId, $id);

            if (!$cv) {
                abort(404, 'Resume not found or you do not have permission to access it');
            }

            $template = CvTemplate::where('slug', $cv->template_slug)->where('is_active', true)->first();

            if (!$template) {
                abort(404, 'Template not found');
            }

            $data = $this->sanitizeCvData($cv->cv_data ?? []);
            $fullHtml = CvExportRenderer::renderHtml($cv->template_slug, $data, $cv->title ?? 'My resume');
            [$body, $contentType, $filename] = CvExportRenderer::buildPngDownload($fullHtml, $cv->title ?? 'My_resume');

            return response($body, 200)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (\Exception $e) {
            \Log::error('PNG Generation Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'cv_id' => $id,
                'template' => $cv->template_slug ?? 'unknown',
            ]);

            if (strpos($e->getMessage(), 'Timeout') !== false) {
                abort(500, 'PNG generation timed out. Your resume may be too large. Please try reducing the content or contact support.');
            }

            abort(500, 'Error generating PNG: ' . $e->getMessage());
        }
    }

    /**
     * Export current unsaved CV preview as PNG or ZIP (without saving).
     */
    public function exportCurrentPNG(Request $request, $lang, $slug)
    {
        try {
            $data = $this->parseCvDataFromExportRequest($request);
            $template = CvTemplate::where('slug', $slug)->where('is_active', true)->first();

            if (!$template) {
                abort(404, 'Template not found');
            }

            $fullHtml = CvExportRenderer::renderHtml($slug, $data, $data['name'] ?? 'My resume');
            [$body, $contentType, $filename] = CvExportRenderer::buildPngDownload($fullHtml, $data['name'] ?? 'My_resume');

            return response($body, 200)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Exception $e) {
            \Log::error('PNG Generation Error (Current): ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'template' => $slug,
            ]);

            $errorMessage = 'Error generating PNG: ' . $e->getMessage();
            if (strpos($e->getMessage(), 'Timeout') !== false) {
                $errorMessage = 'PNG generation timed out. Your resume may be too large. Please try reducing the content or contact support.';
            }

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
            ], 500);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function parseCvDataFromExportRequest(Request $request): array
    {
        $cvDataInput = $request->input('cv_data');

        if (is_string($cvDataInput)) {
            $data = json_decode($cvDataInput, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \InvalidArgumentException('Invalid resume data format');
            }
        } else {
            $data = $cvDataInput;
        }

        $data = $this->sanitizeCvData($data);

        if (empty($data) || !is_array($data)) {
            throw new \InvalidArgumentException('Resume data is required and must be valid');
        }

        return $data;
    }

    /**
     * Active CV for the user, or the same row if soft-deleted (preview / PDF from Trash).
     */
    private function userCvActiveOrOwnedTrashed(int $userId, $id): ?UserCV
    {
        $cv = UserCV::where('id', $id)->where('user_id', $userId)->first();
        if ($cv) {
            return $cv;
        }

        return UserCV::onlyTrashed()->where('id', $id)->where('user_id', $userId)->first();
    }
}
