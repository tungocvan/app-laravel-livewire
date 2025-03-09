<?php
namespace Modules\Quiz\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\UploadedFile;

class PdfUploadController extends Controller
{
    public function index()
    {
        $files = UploadedFile::all(); // Lấy tất cả file đã upload
        return view('uploaded_files.index', compact('files'));
    }
    public function upload(Request $request)
    {
        \Log::info('Upload request received', ['request' => $request->all()]);

        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($request->file('pdf')->isValid()) {
            $timestamp = now()->format('d_m_Y_H_i');
            $filename = "luyentap_{$timestamp}.pdf";

            $path = $request->file('pdf')->storeAs('pdfs', $filename);

            // Lưu đường dẫn vào bảng
            UploadedFile::create(['file_path' => $path]);

            return response()->json(['message' => 'Upload successful', 'path' => $path]);
        }

        return response()->json(['message' => 'Upload failed'], 400);
    }
}
