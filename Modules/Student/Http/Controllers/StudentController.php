<?php

namespace Modules\Student\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use Modules\Quiz\Models\QuestionSet;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
         $this->middleware('permission:student-list|student-create|student-edit|student-delete', ['only' => ['index','show']]);
         $this->middleware('permission:student-create', ['only' => ['create','store']]);
         $this->middleware('permission:student-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:student-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $user = $request->user()->getRoleNames()[0];
        $monhoc = Option::get_option('quiz_monhoc', []);
        $khoilop = Option::get_option('quiz_khoilop', []);
        $capdo = Option::get_option('quiz_capdo', []);
        $loaicau = Option::get_option('quiz_loaicau', []);
        $dapan = Option::get_option('quiz_dapan', []);
        $user_id = $request->user()->id;
        $questionSet = QuestionSet::all();
        foreach ($questionSet as $key => $question) {

            $questionSet[$key]['category_topic_id'] = $monhoc[$question->category_topic_id];
            $questionSet[$key]['category_class_id'] = $khoilop[$question->category_class_id];
            // $btnEdit = "<button type='submit' class='btn btn-xs btn-default text-primary mx-1 shadow' name='edit' value='".$questionSet[$key]['id']."'>
            //     <i class='fa fa-lg fa-fw fa-pen'></i></button>";
            $btnEdit='';
            $btnDelete = "";
            // $btnDelete = "<button type='submit' class='btn btn-xs btn-default text-danger mx-1 shadow'  name='delete' value='$question->id'>
            //     <i class='fa fa-lg fa-fw fa-trash'></i></button>";
            $btnDetails = "<a class='btn btn-xs btn-default text-teal mx-1 shadow'  name='detail' href='/admin/question-set/$question->id'>
                Luyện tập</a>";
            // $btnDetails = "<button type='submit' class='btn btn-xs btn-default text-teal mx-1 shadow'  name='detail' value='".$questionSet[$key]['id']."'>
            //     <i class='fa fa-lg fa-fw fa-eye'></i></button>";

            $questionSet[$key]['action'] = $btnDetails.$btnEdit.$btnDelete  ;
        }
        //dd($questionSet);

        $data = [
            'monhoc' => $monhoc,
            'khoilop' => $khoilop,
            'capdo' => $capdo ,
            'loaicau' => $loaicau,
            'dapan' => $dapan,
            'user_id' => $user_id,
            'questionSet' => $questionSet
        ];

        //dd($user);
        return view('Student::student',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function result()
    {
        $files = UploadedFile::all(); // Lấy tất cả file đã upload
        foreach ($files as $key => $file) {
           $btnDetails = "<a href='/student/view-file/$file->id' class='btn btn-primary' target='_blank'>Xem</a>";
           $btnDelete = "<a href='/student/delete-file/$file->id' class='btn btn-primary'>Xóa</a>";
           $files[$key]['action'] = $btnDetails." ".$btnDelete; 
        }
        //dd($files);
        return view('Student::result',compact('files'));
    }
    public function viewFile($id)
    {
        $file = UploadedFile::findOrFail($id); // Tìm file theo ID
        $filePath = storage_path('app/' . $file->file_path); // Lấy đường dẫn file

        return response()->file($filePath); // Trả về file để trình duyệt hiển thị
    }
    public function deleteFile($id)
    {
            $UploadedFile = UploadedFile::find($id);
            $UploadedFile->delete();
            return redirect()->route('student.result')
                        ->with('success','Luyện tập đã xóa.');
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
