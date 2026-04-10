<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class CourseImportController extends Controller
{
    public function __construct(public CourseService $courseService)
    {
        
    }

    /**
     * Import courses from CSV file.
     */
    public function import(Request $request, Authenticatable $user)
    {
        if(!$user->can('add')){
            return response()->json(['message' => 'Forbidden access'], 403);
        }

        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        fgetcsv($handle, 1000, ','); // Assume header is 'name'

        $imported = 0;
        $errors = [];

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $name = trim($data[0] ?? '');
            if (empty($name)) {
                $errors[] = 'Empty name in row ' . ($imported + 2);
                continue;
            }

            try {
                $this->courseService->save(['name' => $name]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = 'Error importing row ' . ($imported + 2) . ': ' . $e->getMessage();
            }
        }

        fclose($handle);

        return response()->json([
            'message' => 'Import completed',
            'imported' => $imported,
            'errors' => $errors,
        ], 200);
    }
}