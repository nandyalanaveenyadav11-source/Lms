<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = auth()->user()->certificates()->with('course')->get();
        return view('trainee.certificates.index', compact('certificates'));
    }

    public function download(\App\Models\Certificate $certificate)
    {
        if ($certificate->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate->load('user', 'course'),
        ]);

        return $pdf->download('Certificate-' . $certificate->course->title . '.pdf');
    }

    public function show(\App\Models\Certificate $certificate)
    {
        if ($certificate->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate->load('user', 'course'),
        ]);

        return $pdf->stream('Certificate-' . $certificate->course->title . '.pdf');
    }
}
