# 🍎 Fruitmart - E-commerce Platform

Fruitmart is a modern, responsive e-commerce platform built with Laravel and Tailwind CSS, designed specifically for managing and selling fresh fruits online. The platform features a robust admin panel for managing products, categories, and users.

## 🌟 Features

### Admin Dashboard
- User management system
- Product catalog management
- Category organization
- Sales analytics and reporting
- Order processing

### Frontend
- Responsive design
- Product listings with filtering
- Shopping cart functionality
- User authentication
- Order tracking

### Technical Stack
- **Backend**: Laravel 10.x
- **Frontend**: 
  - Blade templating
  - Tailwind CSS
  - Alpine.js
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Admin Panel**: AdminLTE

## 🚀 Getting Started

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 5.7+

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/fruitmart.git
   cd fruitmart
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   npm run build
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup**
   - Create a MySQL database
   - Update `.env` with your database credentials
   - Run migrations and seeders:
     ```bash
     php artisan migrate --seed
     ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

## 🔐 Default Admin Credentials
- **Email**: admin@fruitmart.com
- **Password**: password

## 📂 Project Structure

```
fruitmart/
├── app/                # Application core
├── config/             # Configuration files
├── database/           # Migrations and seeders
├── public/             # Publicly accessible files
├── resources/          # Views and assets
│   ├── js/             # JavaScript files
│   ├── css/            # CSS files
│   └── views/          # Blade templates
│       └── backend/    # Admin panel views
└── routes/             # Application routes
```

## 🛠 Development

### Compile Assets
```bash
npm run dev
```

### Run Tests
```bash
php artisan test
```

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📧 Contact

For any inquiries, please contact [your-email@example.com](mailto:your-email@example.com)

---

Built with ❤️ by [Your Name]
