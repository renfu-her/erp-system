<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeSalary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all employees
        $employees = Employee::all();

        if ($employees->isEmpty()) {
            $this->command->info('No employees found. Please run EmployeeSeeder first.');
            return;
        }

        // Common salary components
        $salaryComponents = [
            'Base Salary',
            'Housing Allowance',
            'Transportation Allowance',
            'Meal Allowance',
            'Performance Bonus',
            'Overtime Pay',
            'Health Insurance',
            'Retirement Contribution',
        ];

        foreach ($employees as $employee) {
            // Add base salary for each employee
            EmployeeSalary::create([
                'employee_id' => $employee->id,
                'name' => 'Base Salary',
                'salary' => rand(3000, 8000), // Random base salary between 3000-8000
                'is_active' => true,
                'effective_date' => $employee->hire_date,
                'notes' => 'Base monthly salary',
            ]);

            // Add 1-3 additional salary components randomly
            $additionalComponents = collect($salaryComponents)
                ->reject(fn($component) => $component === 'Base Salary')
                ->random(rand(1, 3));

            foreach ($additionalComponents as $component) {
                $amount = match($component) {
                    'Housing Allowance' => rand(500, 1500),
                    'Transportation Allowance' => rand(200, 500),
                    'Meal Allowance' => rand(300, 800),
                    'Performance Bonus' => rand(1000, 3000),
                    'Overtime Pay' => rand(0, 1000),
                    'Health Insurance' => rand(200, 500),
                    'Retirement Contribution' => rand(300, 800),
                    default => rand(200, 1000),
                };

                EmployeeSalary::create([
                    'employee_id' => $employee->id,
                    'name' => $component,
                    'salary' => $amount,
                    'is_active' => true,
                    'effective_date' => $employee->hire_date,
                    'notes' => "Monthly {$component}",
                ]);
            }
        }

        $this->command->info('Employee salary components created successfully!');
    }
}