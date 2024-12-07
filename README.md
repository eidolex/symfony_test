# Matchable Checkout

This project implements a checkout page for Matchable, allowing clients to book personal training sessions for padel, fitness, or tennis.

## Architecture and Design Choices

1. Frontend:
   - Vue.js: Chosen for its simplicity and reactivity, making it easy to create dynamic user interfaces.
   - Tailwind CSS: Used for rapid UI development with utility-first classes.

2. Backend:
   - Symfony (PHP): Provides a robust framework for building scalable and maintainable applications.
   - Doctrine ORM: Used for database interactions and entity management.

3. Database:
   - MySQL: Chosen for its easier to maintain and upgrade

4. API:
   - RESTful API design for communication between frontend and backend.

## Setup Instructions

### Prerequisites

- PHP 8.0 or higher
- Composer
- Node.js and npm
- MYSQL

### Backend Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/eidolex/symfony_test.git
   cd symfony_test
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Set up the database:
   - Create a new MYSQL database
   - Copy `.env` to `.env.local` and update the `DATABASE_URL` with your database credentials, if you want to test email update `MAILER_DSN=smtp://testing:********bab9@sandbox.smtp.mailtrap.io:2525`

4. Run migrations:
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. Seed the database
    ```bash
    php bin/console doctrine:fixtures:load
    ```

6. Start the Symfony development server:
   ```bash
   symfony server:start
   ```

### Frontend Setup

1. Navigate to the frontend directory:
   ```
   cd frontend
   ```

2. Install npm dependencies:
   ```
   npm install
   ```

3. Start the Vue development server:
   ```
   npm run dev
   ```

4. Open your browser and navigate to `http://localhost:8080` to view the application.

## Sample .env File

```
APP_ENV=dev
APP_SECRET=your_app_secret_here

DATABASE_URL="postgresql://user:password@127.0.0.1:5432/matchable_checkout?serverVersion=13&charset=utf8"
```

Replace `user`, `password`, and the database name with your actual PostgreSQL credentials.