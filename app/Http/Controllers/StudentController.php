<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // …other actions…

    /**
     * Delete a student and cascade–remove his requirements/logs/uploads.
     */
    public function destroy($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        // requirements and their stored files
        \App\Models\StudentRequirement::where('student_id', $student->id)
            ->each(function ($req) {
                if ($req->file_path) {
                    Storage::disk('public')->delete($req->file_path);
                }
                $req->delete();
            });

        // other related tables
        \App\Models\DailyHourLog::where('student_id', $student->id)->delete();
        \App\Models\TimeInRecord::where('student_id', $student->id)->delete();
        \App\Models\StudentHours::where('student_id', $student->id)->delete();

        $student->delete();

        return redirect()->back()->with('success',
            'Student removed successfully along with all related data.');
    }
}
