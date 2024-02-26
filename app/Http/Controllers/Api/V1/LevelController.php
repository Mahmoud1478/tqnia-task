<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SaveReadRequest;
use App\Http\Resources\LevelResource;
use App\Http\Resources\UnitResource;
use App\Models\Lesson;
use App\Models\Level;
use App\Services\Api\Response\HasApiResponse;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    use HasApiResponse;

    public function index()
    {
        $levels = Level::where('is_active', 1)
            ->withCount([
                'units',
                'lessons',
                'reads as user_lesson_reads' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ])
            ->get();
        return $this->successResponse(LevelResource::collection($levels), '');
    }


    public function units(Level $level)
    {
        $units = $level->units()->with('lessons')->get();
        return $this->successResponse(UnitResource::collection($units), '');
    }


    public function reads(Lesson $lesson)
    {
        $lesson->reads()->create([
            'user_id' => auth()->id(),
            'level_id' => $lesson->unit->level_id,
        ]);
        return $this->successMessageResponse(__('تم الحفظ بنجاح !'));
    }
}

