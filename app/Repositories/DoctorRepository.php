<?php 

namespace App\Repositories;

use App\Models\Doctor;

class DoctorRepository
{
    public function getAll(array $fields)
    {
        return Doctor::select($fields)->with(['specialist', 'hospital'])->latest()->paginate(10);
    }

    public function getById(int $id, array $fields)
    {
        return Doctor::select($fields)->with(['specialist', 'hospital', 'bookingTransactions.user'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Doctor::create($data);
    }

    public function update(int $id, array $data)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($data);
        return $doctor;
    }

    public function delete(int $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
    }

    public function filterBySpecialistAndHospital(int $hospitalId, int $specialistId)
    {
        return Doctor::with(['specialist', 'hospital'])
            ->where('hospital_id', $hospitalId)
            ->where('specialist_id', $specialistId)
            // ->paginate(10);
            ->get();
    }
}