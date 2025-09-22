# ERP System - Laravel 12 with Filament v4

A comprehensive Enterprise Resource Planning (ERP) system built with Laravel 12 and Filament v4, starting with a complete Human Resources module.

## 🚀 Features

### Human Resources Module
- **Department Management**: Create, edit, and manage organizational departments
- **Position Management**: Define job positions with salary ranges and department associations
- **Employee Management**: Complete employee profiles with personal information, contact details, and employment data
- **User Integration**: Link employees to user accounts for system access
- **Advanced Filtering**: Search and filter capabilities across all modules
- **Responsive Design**: Modern, mobile-friendly interface

## 🛠️ Technology Stack

- **Backend**: Laravel 12
- **Admin Panel**: Filament v4
- **Database**: SQLite (configurable)
- **Frontend**: Livewire 3 + Alpine.js
- **UI Components**: Tailwind CSS

## 📋 Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js & NPM
- SQLite (or MySQL/PostgreSQL)

## 🔧 Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd erp-system
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration
The system is configured to use SQLite by default. Update your `.env` file if you want to use a different database:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 5. Run Migrations and Seeders
```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Assets
```bash
npm run build
```

### 7. Start the Application
```bash
php artisan serve
```

## 👤 Default Admin Account

After running the seeders, you can access the admin panel with:

- **URL**: `http://localhost:8000/admin`
- **Email**: `admin@example.com`
- **Password**: `admin123`

## 📊 Database Schema

### Departments Table
- `id` - Primary key
- `name` - Department name
- `description` - Department description
- `manager_id` - Foreign key to employees table
- `is_active` - Active status
- `created_at`, `updated_at` - Timestamps

### Positions Table
- `id` - Primary key
- `title` - Position title
- `description` - Position description
- `department_id` - Foreign key to departments table
- `salary_range_min` - Minimum salary
- `salary_range_max` - Maximum salary
- `is_active` - Active status
- `created_at`, `updated_at` - Timestamps

### Employees Table
- `id` - Primary key
- `employee_id` - Unique employee identifier
- `first_name` - Employee first name
- `last_name` - Employee last name
- `email` - Email address (unique)
- `phone` - Phone number
- `address` - Physical address
- `date_of_birth` - Date of birth
- `hire_date` - Employment start date
- `department_id` - Foreign key to departments table
- `position_id` - Foreign key to positions table
- `salary` - Current salary
- `status` - Employment status (active, inactive, terminated, on_leave)
- `emergency_contact_name` - Emergency contact name
- `emergency_contact_phone` - Emergency contact phone
- `user_id` - Foreign key to users table (optional)
- `created_at`, `updated_at` - Timestamps

## 🏗️ Project Structure

```
app/
├── Filament/
│   └── Resources/
│       ├── Departments/
│       │   ├── DepartmentResource.php
│       │   ├── Pages/
│       │   ├── Schemas/
│       │   │   └── DepartmentForm.php
│       │   └── Tables/
│       │       └── DepartmentsTable.php
│       ├── Positions/
│       │   ├── PositionResource.php
│       │   ├── Pages/
│       │   ├── Schemas/
│       │   │   └── PositionForm.php
│       │   └── Tables/
│       │       └── PositionsTable.php
│       └── Employees/
│           ├── EmployeeResource.php
│           ├── Pages/
│           ├── Schemas/
│           │   └── EmployeeForm.php
│           └── Tables/
│               └── EmployeesTable.php
├── Models/
│   ├── Department.php
│   ├── Employee.php
│   ├── Position.php
│   └── User.php
└── ...

database/
├── migrations/
│   ├── 2025_09_22_023419_create_departments_table.php
│   ├── 2025_09_22_023423_create_positions_table.php
│   ├── 2025_09_22_023425_create_employees_table.php
│   └── 2025_09_22_023519_add_manager_id_to_departments_table.php
└── seeders/
    ├── AdminUserSeeder.php
    └── DatabaseSeeder.php
```

## 🎯 Usage Guide

### Managing Departments
1. Navigate to **Departments** in the admin panel
2. Click **Create** to add a new department
3. Fill in the department name, description, and assign a manager
4. Set the active status
5. Save the department

### Managing Positions
1. Go to **Positions** in the admin panel
2. Click **Create** to add a new position
3. Enter position title, description, and select department
4. Set salary range (optional)
5. Save the position

### Managing Employees
1. Navigate to **Employees** in the admin panel
2. Click **Create** to add a new employee
3. Fill in personal information, contact details, and employment data
4. Select department and position (position options update based on department)
5. Set salary and employment status
6. Optionally link to a user account
7. Save the employee record

## 🔍 Key Features

### Form Validation
- Email uniqueness validation
- Employee ID uniqueness
- Required field validation
- Date validation (birth date cannot be in future)
- Dynamic position selection based on department

### Table Features
- Searchable columns
- Sortable data
- Advanced filtering
- Bulk actions
- Responsive design
- Status badges and icons

### Relationships
- Departments can have managers (employees)
- Positions belong to departments
- Employees belong to departments and positions
- Employees can be linked to user accounts

## 🚀 Development

### Adding New Modules
To add new ERP modules (e.g., Inventory, Sales, Finance):

1. Create models and migrations
2. Generate Filament resources
3. Configure forms and tables
4. Set up relationships
5. Add navigation items

### Customization
- Modify form components in `Schemas/` directories
- Customize table displays in `Tables/` directories
- Add custom actions and filters
- Extend models with additional relationships

## 📝 API Documentation

The system uses Filament's built-in API capabilities. All resources are automatically available via REST API endpoints when properly configured.

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
```

## 🔒 Security

- CSRF protection enabled
- Input validation on all forms
- SQL injection protection via Eloquent ORM
- XSS protection through Blade templating
- Secure password hashing

## 📈 Performance

- Database indexing on foreign keys
- Eager loading for relationships
- Optimized queries with proper joins
- Caching for frequently accessed data

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For support and questions:
- Check the [Laravel documentation](https://laravel.com/docs)
- Review [Filament documentation](https://filamentphp.com/docs)
- Create an issue in the repository

## 🔄 Version History

### v1.0.0 (Current)
- Initial release
- Human Resources module
- Department, Position, and Employee management
- Admin user seeder
- Complete CRUD operations
- Advanced filtering and search

## 🎯 Roadmap

### Planned Features
- [ ] Inventory Management Module
- [ ] Sales & CRM Module
- [ ] Financial Management Module
- [ ] Project Management Module
- [ ] Reporting & Analytics Dashboard
- [ ] Multi-language Support
- [ ] Advanced User Permissions
- [ ] API Documentation
- [ ] Mobile App Integration

---

**Built with ❤️ using Laravel 12 and Filament v4**