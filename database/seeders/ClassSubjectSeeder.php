<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Subject;
use App\Models\User;

class ClassSubjectSeeder extends Seeder
{
    public function run(): void
    {
        // ── Subjects ──────────────────────────────
        Subject::insert([
            ['name' => 'Mathematics',        'status' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Science',            'status' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'English Language',   'status' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bahasa Malaysia',    'status' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'History',            'status' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Geography',          'status' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Islamic Education',  'status' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Physical Education', 'status' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $subjectIds = Subject::pluck('id');
        $students   = User::where('role', 'student')->get();

        // ── Classes ───────────────────────────────
        $classNames = [
            'Form 1 Bestari',
            'Form 1 Cemerlang',
            'Form 2 Bestari',
            'Form 2 Cemerlang',
            'Form 3 Bestari',
        ];

        // distribute existing students evenly across classes
        $chunks = $students->chunk(ceil($students->count() / count($classNames)));

        foreach ($classNames as $index => $name) {
            $kelas = Kelas::create(['name' => $name]);

            // assign 4 random subjects
            $kelas->subjects()->attach($subjectIds->random(4)->toArray());

            // assign students from this chunk
            if (isset($chunks[$index])) {
                $chunks[$index]->each(fn($student) => $student->update(['class_id' => $kelas->id]));
            }
        }
    }
}