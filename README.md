# 📝 ExamSystem

A Laravel-based online examination management system supporting three user roles: **Admin**, **Lecturer**, and **Student**.

---

## Tech Stack

- **Backend:** Laravel 11, PHP 8.2
- **Database:** PostgreSQL
- **Frontend:** Blade, Tailwind CSS, Vanilla JavaScript
- **Auth:** Laravel Breeze / built-in auth

---

## Features

| Feature | Description |
|---|---|
| 👨‍💼 Admin Dashboard | Full system stats, recent users & exams, pending marking, class/subject overview |
| 👨‍🏫 Lecturer Dashboard | Exam summary, live exam monitor, open-text marking queue |
| 👨‍🎓 Student Dashboard | Lists all exams available to the student's class with real-time status |
| 📝 Exam Builder | Create exams with MCQ and open-text questions, correct answer marking, duration & schedule |
| 🏫 Class Management | Create classes, enroll students, assign subjects. Students can only be in one class |
| 📚 Subject Management | Manage subjects with active/inactive toggle, displayed as color-coded cards |
| 👥 User Management | Full CRUD with role assignment (admin / lecturer / student) and status control |
| ⏱️ Timed Exam Engine | Countdown timer with auto-submit on expiry. Timer turns red under 2 minutes |
| ✏️ Open Text Marking | Lecturers award marks to written answers. Total score recalculates automatically |
| 📊 Result & Review | Students see grade, score, percentage and full answer review after submission |

---

## User Roles

### Admin
- Full access to all modules
- System-wide stats (users, exams, submissions, classes, subjects)
- Manage all users, classes, subjects, and exams

### Lecturer
- Create, edit, and delete exams with questions
- Assign exams to one or more classes
- Mark open-text answers submitted by students
- View all classes and enrolled students (read-only)
- Monitor live ongoing exams from dashboard

### Student
- View only exams assigned to their enrolled class
- Take timed exams (MCQ and open-text)
- Auto-submit when time limit is reached
- View result and full answer review after submission

---

## Database Schema

| Table | Description |
|---|---|
| `users` | All users. `role`: admin \| lecturer \| student. `class_id` links students to a class |
| `school_classes` | Classes (model: `Kelas.php`). Students linked via `users.class_id` |
| `subjects` | Learning subjects with `name` and boolean `status` |
| `class_subject` | Pivot — many-to-many between `school_classes` and `subjects` |
| `exams` | Exam records with `subject_id`, `start`, `end`, `duration` (minutes), `status` |
| `class_exam` | Pivot — many-to-many between `exams` and `school_classes` |
| `questions` | Questions per exam. `type`: mcq \| open_text. `marks` column |
| `question_options` | Answer options for MCQ questions. `is_correct` boolean |
| `exam_attempts` | Tracks each student attempt. `started_at`, `submitted_at`, `total_score` |
| `student_answers` | MCQ uses `selected_option_id`; open text uses `answer_text`. `marks_awarded` for grading |

---

## Models & Relationships

```
User
  └─ belongsTo Kelas (class_id)

Kelas
  ├─ hasMany User (students)
  ├─ belongsToMany Subject (class_subject)
  └─ belongsToMany Exam (class_exam)

Subject
  ├─ belongsToMany Kelas
  └─ hasMany Exam

Exam
  ├─ belongsTo Subject
  ├─ belongsToMany Kelas (class_exam)
  ├─ hasMany Question
  └─ hasMany ExamAttempt

Question
  ├─ belongsTo Exam
  └─ hasMany QuestionOption

ExamAttempt
  ├─ belongsTo Exam
  ├─ belongsTo User
  └─ hasMany StudentAnswer

StudentAnswer
  ├─ belongsTo ExamAttempt
  ├─ belongsTo Question
  └─ belongsTo QuestionOption (selected_option_id)
```

---

## Installation

### Requirements
- PHP >= 8.2
- Composer
- MySQL 8 / MariaDB
- Node.js & npm

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/your-org/examsystem.git
cd examsystem

# 2. Install dependencies
composer install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
DB_DATABASE=examsystem
DB_USERNAME=root
DB_PASSWORD=your_password

# 5. Run migrations
php artisan migrate

# 6. Seed the database
php artisan db:seed

# 7. Serve
php artisan serve
```

---

## Seeders

| Seeder | Description |
|---|---|
| `UserSeeder` | Seeds admin, lecturer, and student accounts |
| `ClassSubjectSeeder` | Seeds 8 subjects, 5 classes, distributes existing students across classes |

```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=ClassSubjectSeeder
```

---

## Routes

### Admin & Lecturer
```
GET    /admin/dashboard                          Admin dashboard
GET    /lecturer/dashboard                       Lecturer dashboard
GET    /lecturer/classes                         View all classes and students

Resource /users                                  User CRUD
Resource /classes                                Class CRUD
Resource /subjects                               Subject CRUD
Resource /exams                                  Exam CRUD

GET    /exams/{exam}/marking                     Open text marking interface
POST   /answers/{answer}/mark                    Save mark for a student answer
```

### Student
```
GET    /student/dashboard                        Exam list for student's class
GET    /student/exams/{exam}/start               Start an exam attempt
POST   /student/exams/attempt/{attempt}/submit   Submit answers
GET    /student/exams/attempt/{attempt}/result   View result and answer review
```

---

## Exam Flow

```
Lecturer  →  Create exam with questions  →  Assign to class(es)  →  Set start/end + duration

Student   →  Sees exam on dashboard  →  Click Start  →  Answers within time limit
          →  Auto or manual submit  →  View result with answer review

Lecturer  →  Open marking page  →  Award marks to open-text answers
          →  Total score updates automatically
```

---

## Design Conventions

- All blade views are injected into `<main>{{ $slot }}</main>` — no repeated header/sidebar markup
- Modals toggled via `classList.add/remove('hidden')` and `classList.add/remove('flex')`
- Consistent design tokens:
  - Cards: `rounded-2xl`, border `#e2e8f0`
  - Gradient buttons: `#2563eb → #7c3aed`
  - Focus ring: `box-shadow: 0 0 0 3px rgba(37,99,235,0.1)`
- Avatar initials generated from first + last name initial with 5-color cycling palette
- Pagination dark mode fixed via `php artisan vendor:publish --tag=laravel-pagination`

---

## Default Credentials

| Role | Email | Password |
|---|---|---|
| Admin | admin1@gmail.com | password |
| Lecturer | lecturer1@gmail.com | password |
| Student | student1@gmail.com | password |

> ⚠️ Change all default passwords before deploying to production.

---

## License

MIT