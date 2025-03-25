<?php

namespace App\Livewire\Email;
use Illuminate\Support\Facades\Mail;
use Livewire\WithFileUploads;
use Livewire\Component;

class EmailMessage extends Component
{
    use WithFileUploads;
    public $photo;
    public $to;
    public $subject;
    public function save()
    {
        if ($this->photo) {
            $path = $this->photo->store('photos', 'public'); // Lưu file vào storage/app/public/photos
            return response()->json(['message' => 'Upload thành công!', 'path' => $path]);
        }

        return response()->json(['error' => 'Không có file!'], 400);
    }
    
    public function SendMail($data){
        // dd($data);
       // dd($this->to);
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
