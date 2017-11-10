<?php

namespace App\Http\Controllers;

use App\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Helper;
use App\Course;
use App\AttachmentRevision;

class AttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['create', 'store', 'enable', 'disable']);
        $this->prefix = config('cache.prefix');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) 
        {
            if ($request->new == 'true')
            {
                $course_id = $request->course_id;
                $path = Storage::put('files/'.$course_id, $request->file('attachment'));    // store the file
                
                if ($request->filename) {
                    $filename = $request->filename;
                } else {
                    $filename = $request->attachment->getClientOriginalName();
                } 

                $extension = strtolower($request->attachment->extension());

                $attachment = Attachment::create([                      // insert into table "attachment"
                    'course_id' => $request->course_id,
                    'filename' => $filename,
                    'extension' => $extension,
                    'description' => $request->description,
                ]);
                $currRevision = 0;

            } else {
                $attachment = Attachment::find($request->attachment_id);
                if (strtolower($request->attachment->extension()) != $attachment->extension) {
                    session()->flash('messageAlertType','alert-danger');
                    session()->flash('message','File extension does not match previous revision. Upload is not allowed');
                    return redirect()->back();
                }

                $path = Storage::put('files/'.$request->course_id, $request->file('attachment'));    // store the file
                $currRevision = AttachmentRevision::where('attachment_id', '=', $request->attachment_id)->pluck('revision')->max();
            }

            $attachment_revision = AttachmentRevision::create([          // insert into table "attachment_revision"
                'attachment_id' => $attachment->id,
                'path' => $path,
                'revision' => $currRevision+1,
            ]);

            $key = $this->prefix.'AllCourses'; 
            Cache::forget($key);                // forget this key (course_number)
            
            session()->flash('messageAlertType','alert-sucess');
            session()->flash('message','File is uploaded sucessfully');
            return redirect()->back();


        } else {
            session()->flash('messageAlertType','alert-warning');
            session()->flash('message','This is NO attachment');
        }
        return redirect()->back();
    }

    /**
     * Download, Enable & Disable a file (attachment_revision) for download
     *
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request)
    {
        switch($request->action)
        {
            case "download": 
                $id = $request->revision_id;
                $file = AttachmentRevision::with('attachment')->find($id);

                if ($file->disabled && !Helper::admin())
                {
                    session()->flash('messageAlertType','alert-warning');
                    session()->flash('message','This revision is disabled, please download other versions');
                    return redirect()->back();
                } else {
                    $content = storage_path('app/'.$file->path);
                    $headers = array(       // AT-Pending: it works without headers, just following the Laravel document
                                  'Content-Type: application/'.$file->attachment->extension,
                                );
                    return  response()->download($content, $file->attachment->filename, $headers);
                }
                break;
            case "enable":
                $id = $request->revision_id;
                $file = AttachmentRevision::with('attachment')->find($id);
                $file->disabled = false;
                $file->save();

                $key = $this->prefix.'AllCourses';  
                Cache::forget($key);                // forget this key (course_number)

                session()->flash('messageAlertType','alert-info');
                session()->flash('message','File is enabled for downloading');
                return redirect()->back();
            case "disable":
                $id = $request->revision_id;
                $file = AttachmentRevision::with('attachment')->find($id);
                $file->disabled = true;
                $file->save();

                $key = $this->prefix.'AllCourses'; 
                Cache::forget($key);                // forget this key (course_number)

                session()->flash('messageAlertType','alert-warning');
                session()->flash('message','File is disabled for downloading');
                return redirect()->back();
                break;
            default:
                session()->flash('messageAlertType','alert-warning');
                session()->flash('message','Unkown Instruction');
                return redirect()->back();
        }
        return redirect()->back();

    }

}
