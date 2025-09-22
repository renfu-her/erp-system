<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create departments
        $departments = [
            ['name' => 'Human Resources', 'description' => 'HR Department'],
            ['name' => 'Information Technology', 'description' => 'IT Department'],
            ['name' => 'Finance', 'description' => 'Finance Department'],
            ['name' => 'Marketing', 'description' => 'Marketing Department'],
            ['name' => 'Operations', 'description' => 'Operations Department'],
        ];

        foreach ($departments as $deptData) {
            Department::create($deptData);
        }

        // Create positions
        $positions = [
            ['title' => 'HR Manager', 'department_id' => 1, 'salary_range_min' => 5000, 'salary_range_max' => 7000],
            ['title' => 'HR Specialist', 'department_id' => 1, 'salary_range_min' => 3000, 'salary_range_max' => 4500],
            ['title' => 'Software Developer', 'department_id' => 2, 'salary_range_min' => 4000, 'salary_range_max' => 6000],
            ['title' => 'System Administrator', 'department_id' => 2, 'salary_range_min' => 3500, 'salary_range_max' => 5000],
            ['title' => 'Financial Analyst', 'department_id' => 3, 'salary_range_min' => 3500, 'salary_range_max' => 5000],
            ['title' => 'Accountant', 'department_id' => 3, 'salary_range_min' => 3000, 'salary_range_max' => 4500],
            ['title' => 'Marketing Manager', 'department_id' => 4, 'salary_range_min' => 4500, 'salary_range_max' => 6500],
            ['title' => 'Marketing Specialist', 'department_id' => 4, 'salary_range_min' => 3000, 'salary_range_max' => 4500],
            ['title' => 'Operations Manager', 'department_id' => 5, 'salary_range_min' => 5000, 'salary_range_max' => 7000],
            ['title' => 'Operations Coordinator', 'department_id' => 5, 'salary_range_min' => 3000, 'salary_range_max' => 4500],
        ];

        foreach ($positions as $posData) {
            Position::create($posData);
        }

        // Create sample employees
        $employees = [
            [
                'employee_id' => 'EMP001',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@company.com',
                'phone' => '+1234567890',
                'hire_date' => '2023-01-15',
                'department_id' => 1,
                'position_id' => 1,
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP002',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@company.com',
                'phone' => '+1234567891',
                'hire_date' => '2023-02-20',
                'department_id' => 2,
                'position_id' => 3,
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP003',
                'first_name' => 'Mike',
                'last_name' => 'Johnson',
                'email' => 'mike.johnson@company.com',
                'phone' => '+1234567892',
                'hire_date' => '2023-03-10',
                'department_id' => 3,
                'position_id' => 5,
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP004',
                'first_name' => 'Sarah',
                'last_name' => 'Wilson',
                'email' => 'sarah.wilson@company.com',
                'phone' => '+1234567893',
                'hire_date' => '2023-04-05',
                'department_id' => 4,
                'position_id' => 7,
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP005',
                'first_name' => 'David',
                'last_name' => 'Brown',
                'email' => 'david.brown@company.com',
                'phone' => '+1234567894',
                'hire_date' => '2023-05-12',
                'department_id' => 5,
                'position_id' => 9,
                'status' => 'active',
            ],
        ];

        foreach ($employees as $empData) {
            Employee::create($empData);
        }

        $this->command->info('Sample employees created successfully!');
    }
}