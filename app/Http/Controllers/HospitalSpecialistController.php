<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachSpecialistRequest;
use App\Services\HospitalService;
use Illuminate\Http\Request;

class HospitalSpecialistController extends Controller
{
     private $hospitalService;

    public function __construct(HospitalService $hospitalService)
    {
        $this->hospitalService = $hospitalService;
    }

    public function attach(AttachSpecialistRequest $request, int $hospitalId)
    {
        $validatedData = $request->validated();

        $this->hospitalService->attachSpecialist(
            $hospitalId,
            $validatedData['specialist_id'],
        );

        return response()->json(['message' => 'Specialist attached successfully']);
    }

    public function detach(int $hospitalId, int $specialistId)
    {
        $this->hospitalService->detachSpecialist($hospitalId, $specialistId);
        return response()->json(['message' => 'Specialist detached successfully']);
    }
}{
    //
}
