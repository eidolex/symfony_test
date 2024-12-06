### Backend Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/matchable-checkout.git
   cd matchable-checkout
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Set up the database:
   - Create a new MYSQL database
   - Copy `.env` to `.env.local` and update the `DATABASE_URL` with your database credentials

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
   npm run serve
   ```

4. Open your browser and navigate to `http://localhost:8080` to view the application.

## Sample .env File

```
APP_ENV=dev
APP_SECRET=your_app_secret_here

DATABASE_URL="postgresql://user:password@127.0.0.1:5432/matchable_checkout?serverVersion=13&charset=utf8"
```

Replace `user`, `password`, and the database name with your actual PostgreSQL credentials.