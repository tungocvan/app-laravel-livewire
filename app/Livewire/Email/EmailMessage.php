<?php

namespace App\Livewire\Email;
use Illuminate\Support\Facades\Mail;
use Livewire\WithFileUploads;
use Livewire\Component;

class EmailMessage extends Component
{
    use WithFileUploads;
    public $photo;
    public $photos; // Mảng file upload
    public $uploadedFiles = []; // Lưu tên file sau khi upload
    public $pathDirectory= 'uploads';
    public $messages = []; // Thông báo
    public $to;
    public $subject;
    // public function save()    {
       
    //     if ($this->photo) {
    //         $path = $this->photo->store('photos', 'public'); // Lưu file vào storage/app/public/photos
    //         return response()->json(['message' => 'Upload thành công!', 'path' => $path]);
    //     }

    //     return response()->json(['error' => 'Không có file!'], 400);
    // }
    public function saveFiles()
    {
        // Kiểm tra xem có file nào không
        if (empty($this->photos)) {
            $this->messages[] = "Vui lòng chọn file!";
            return;
        }

        // Validate tất cả các file
        $this->validate([
            'photos.*' => 'file|max:10240', // Mỗi file tối đa 10MB
        ]);

        foreach ($this->photos as $index => $photo) {
            if (!isset($this->uploadedFiles[$index])) {
                $this->uploadImage($index);
            }
        }

        //dd($this->uploadedFiles); // "uploads/cccd-matsau.jpg"

        // Gửi sự kiện về client báo upload thành công
        // $this->dispatchBrowserEvent('upload-success', ['files' => $this->uploadedFiles]);
    }
    public function uploadImage($index)
    {
        if (!isset($this->photos[$index]) || isset($this->uploadedFiles[$index])) return;

        $photo = $this->photos[$index];
        $filename = $photo->getClientOriginalName();

        // Lưu file vào storage/public/uploads
        $path = $photo->storeAs($this->pathDirectory, $filename, 'public');

        // Lưu trạng thái đã upload
        $this->uploadedFiles[$index] = $path;
        $this->messages[] = "Ảnh '{$filename}' đã upload thành công!";
    }
    public function SendMail($data){
        // dd($data);
       // dd($this->to);
       dd($this->uploadedFiles);
        $to = $this->to ?? 'tungocvan@gmail.com';   
        $cc = '';    
        $content = $data ?? '<h3>This is test mail<h3>';
        $subject = $this->subject ?? 'Email send from tungocvan1@gmail.com'; 
        try {
            Mail::html($content , function ($message) use ($to,$cc,$content, $subject) {
                $message->to($to)
                        ->subject($subject);
            });
        } catch (\Exception $e) {
            return 'Đã gửi mail thất bại';
        }

        return 'Đã gửi mail thành công';
    }
    public function render()
    {
        return view('livewire.email.email-message');
    }
}
