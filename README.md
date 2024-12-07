# Matchable Checkout

This project implements a checkout page for Matchable, allowing clients to book personal training sessions for padel, fitness, or tennis.

## Architecture and Design Choices

1. Frontend:
   - Nuxt.js (easier to setup then vue.js as it includes tools where vue.js need manual setup)
   - Tailwind CSS: for rapid development (as doesn't need to think css class name and better browser support)

2. Backend:
   - Symfony (PHP): Provides a robust framework for building scalable and maintainable applications.
   - Doctrine ORM: Used for database interactions and entity management.

3. Database:
   - MySQL: Chosen for its easier to maintain and upgrade (unlike postgres which is painful to upgrade and permission management is a mess and current project don't benefit that much using postgres)

4. API:
   - RESTful API design for communication between frontend and backend.

## Setup Instructions

### Docker setup

1. build docker image
```bash
docker compose build
```

2. Run docker image
```bash
docker compose up -d
```

3. Setup database
```bash
docker compose exec backend-php php bin/console doctrine:migrations:migrate
docker compose exec backend-php php bin/console doctrine:fixtures:load
```

4. Open to the frontend with url [http://localhost:3000](http://localhost:3000)

5. To check the mail open url [http://localhost:8025](http://localhost:8025)

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

4. Open your browser and navigate to `http://localhost:3000` to view the application.

## Sample .env File

```
APP_ENV=dev
APP_SECRET=your_app_secret_here

DATABASE_URL="mysql://user:password@127.0.0.1:3306/database_name?serverVersion=8.0.32&charset=utf8mb4"

MAILER_DSN=smtp://'smtp_username':'smtp_password'@smtp_host:smtp_port
```

Replace `user`, `password`, and the `database_name` with your actual MYSQL credentials.
Replace `smtp_username`, `smtp_password`, `smtp_host` and the `smtp_port` with your smtp provider.