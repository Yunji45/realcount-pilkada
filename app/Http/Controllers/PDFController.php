<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Intervention\Image\Facades\Image;

class PDFController extends Controller
{
    public function index()
    {
        $title = "PDF OCR";
        return view('dashboard.admin.realcount.ocr.index', compact('title'));
    }

    public function upload(Request $request)
    {
        $title = "PDF OCR AFTER GENERATE";

        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10000'
        ]);

        $pdfPath = $request->file('pdf_file')->store('pdfs');
        $fullPdfPath = storage_path('app/' . $pdfPath);

        $pdf = new Pdf($fullPdfPath);
        $imagePath = storage_path('app/images');
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        // $data = [];
        // for ($page = 1; $page <= $pdf->getNumberOfPages(); $page++) {
        //     $imageName = 'pdf_image_page_' . $page . '.jpg';
        //     $imageFullPath = $imagePath . '/' . $imageName;
        //     $pdf->setPage($page)->saveImage($imageFullPath);

        //     // Ekstrak informasi yang dibutuhkan
        //     $data['lokasi'] = $this->extractLocation($imageFullPath);
        //     $data['data_pemilih'] = $this->extractPemilihData($imageFullPath);
        // }
        $data = [];

        // Hanya memproses halaman pertama
        $page = 1;
        $imageName = 'pdf_image_page_' . $page . '.jpg';
        $imageFullPath = $imagePath . '/' . $imageName;
        $pdf->setPage($page)->saveImage($imageFullPath);

        // Ekstrak informasi yang dibutuhkan dari halaman pertama
        $data['lokasi'] = $this->extractLocation($imageFullPath);
        $data['data_pemilih'] = $this->extractPemilihData($imageFullPath);

        return view('dashboard.admin.realcount.ocr.index', [
            'location_data' => $data['lokasi'],
            'pemilih_data' => $data['data_pemilih'],
            'title' => $title
        ]);
    }

    public function extractLocation($imagePath)
    {
        $ocr = new TesseractOCR($imagePath);
        $ocr->lang('ind');
        $ocr->allowlist(range('A', 'Z'), range('a', 'z'), ' ', '-', '/');

        $locationText = $ocr->run();

        $locationData = [
            'provinsi' => $this->matchPattern($locationText, '/Provinsi\s+(.*)/i'),
            'kabupaten' => $this->matchPattern($locationText, '/Kabupaten\/Kota\s+(.*)/i'),
            'dapil' => $this->matchPattern($locationText, '/Daerah Pemilihan\s+(.*)/i'),
            'kecamatan' => $this->matchPattern($locationText, '/Kecamatan\s+(.*)/i'),
            'kelurahan' => $this->matchPattern($locationText, '/Kelurahan\/Desa\s+(.*)/i'),
            'nomor_tps' => $this->matchPattern($locationText, '/Nomor TPS\s+(\d+)/i')
        ];

        return $locationData;
    }

    public function matchPattern($text, $pattern)
    {
        if (preg_match($pattern, $text, $matches)) {
            return $matches[1] ?? '';
        }
        return '';
    }

    public function extractPemilihData($imagePath)
    {
        $ocr = new TesseractOCR($imagePath);
        $ocr->lang('ind');
        $ocr->allowlist(range(0, 9)); // Hanya mengizinkan angka

        // Jalankan OCR untuk mengekstrak semua teks dari gambar
        $pemilihText = $ocr->run();
        $pemilihText = str_replace(['l', 'I'], '1', $pemilihText); // Mengganti "l" atau "I" dengan "1"


        // Debug untuk melihat hasil dari OCR
        Log::info('OCR Pemilih Text: ' . $pemilihText);

        // Ekstrak digit dari masing-masing kolom (Laki-laki, Perempuan, L+P) dan gabungkan
        $pemilihData = [
            'dpt_laki' => $this->getCombinedDigits($pemilihText, '/1. Jumlah pengguna hak pilih dalam Daftar Pemilih Tetap (DPT).*L\s(\d)\s(\d)\s(\d)/'),
            'dpt_perempuan' => $this->getCombinedDigits($pemilihText, '/1. Jumlah pengguna hak pilih dalam Daftar Pemilih Tetap (DPT).*P\s(\d)\s(\d)\s(\d)/'),
            'dpt_jumlah' => $this->getCombinedDigits($pemilihText, '/1. Jumlah pengguna hak pilih dalam Daftar Pemilih Tetap (DPT).*L\+P\s(\d)\s(\d)\s(\d)/'),

            // Pengguna Hak Pilih
            'dptb_laki' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih.*L\s(\d)\s(\d)\s(\d)/'),
            'dptb_perempuan' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih.*P\s(\d)\s(\d)\s(\d)/'),
            'dptb_jumlah' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih.*L\+P\s(\d)\s(\d)\s(\d)/'),

            // Pengguna Hak Pilih Khusus
            'dpk_laki' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih khusus.*L\s(\d)\s(\d)\s(\d)/'),
            'dpk_perempuan' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih khusus.*P\s(\d)\s(\d)\s(\d)/'),
            'dpk_jumlah' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih khusus.*L\+P\s(\d)\s(\d)\s(\d)/'),
        ];

        return $pemilihData;
    }

    // Fungsi untuk menggabungkan angka dari regex match
    private function getCombinedDigits($text, $pattern)
    {
        if (preg_match($pattern, $text, $matches)) {
            Log::info('Matched Digits: ' . implode('', array_slice($matches, 1)));
            return implode('', array_slice($matches, 1));
        }
        Log::info('No Match Found for Pattern: ' . $pattern);
        return '';
    }

}
