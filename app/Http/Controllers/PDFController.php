<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Intervention\Image\Facades\Image;

class PDFController extends Controller
{
    public function index()
    {
        $title = "Image OCR";
        return view('dashboard.admin.realcount.ocr.index', compact('title'));
    }

    public function upload(Request $request)
    {
        $title = "Image OCR AFTER GENERATE";

        // Validasi gambar yang diupload
        $request->validate([
            'image_file' => 'required|mimes:jpeg,jpg,png|max:5000'
        ]);

        // Simpan gambar yang diupload
        $imagePath = $request->file('image_file')->store('images');
        $fullImagePath = storage_path('app/' . $imagePath);

        // Ekstrak informasi dari gambar menggunakan TesseractOCR
        $data = [];
        $data['lokasi'] = $this->extractLocation($fullImagePath);
        $data['data_pemilih'] = $this->extractPemilihData($fullImagePath);

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
        $ocr->allowlist(range(0, 9));

        $pemilihText = $ocr->run();
        $pemilihText = str_replace(['l', 'I'], '1', $pemilihText);

        Log::info('OCR Pemilih Text: ' . $pemilihText);

        $pemilihData = [
            'dpt_laki' => $this->getCombinedDigits($pemilihText, '/1. Jumlah pengguna hak pilih dalam Daftar Pemilih Tetap (DPT).*L\s(\d)\s(\d)\s(\d)/'),
            'dpt_perempuan' => $this->getCombinedDigits($pemilihText, '/1. Jumlah pengguna hak pilih dalam Daftar Pemilih Tetap (DPT).*P\s(\d)\s(\d)\s(\d)/'),
            'dpt_jumlah' => $this->getCombinedDigits($pemilihText, '/1. Jumlah pengguna hak pilih dalam Daftar Pemilih Tetap (DPT).*L\+P\s(\d)\s(\d)\s(\d)/'),

            'dptb_laki' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih.*L\s(\d)\s(\d)\s(\d)/'),
            'dptb_perempuan' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih.*P\s(\d)\s(\d)\s(\d)/'),
            'dptb_jumlah' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih.*L\+P\s(\d)\s(\d)\s(\d)/'),

            'dpk_laki' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih khusus.*L\s(\d)\s(\d)\s(\d)/'),
            'dpk_perempuan' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih khusus.*P\s(\d)\s(\d)\s(\d)/'),
            'dpk_jumlah' => $this->getCombinedDigits($pemilihText, '/Jumlah pengguna hak pilih khusus.*L\+P\s(\d)\s(\d)\s(\d)/'),
        ];

        return $pemilihData;
    }

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
