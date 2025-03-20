# Rate My Courier

**Rate My Courier** is a review service for courier stores, where users can add positive (Like) or negative (Dislike) votes.

## Installation

Follow the steps below to install and run the project:

### 1. Clone the Repository

```bash
git clone https://github.com/your-repo/rate-my-courier.git
cd rate-my-courier
```

### 2. Copy & Configure `.env`

```bash
cp .env.example .env
```

Set up your database parameters in the `.env` file.

### 3. Run the Application via Docker

If you have not installed Laravel Sail, you can run the project using Docker with the following command:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd)":/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest composer install --ignore-platform-reqs
```

### 4. Create an Alias for Sail

To make it easier to use, you can create an alias so you don’t have to type `./vendor/bin/sail` every time:

```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

You can add this command to your `~/.bashrc` or `~/.zshrc` file to make it available in every new terminal session.

### 5. Start Laravel Sail

```bash
sail up -d
```

### 6. Install Dependencies

```bash
sail composer install
```

### 7. Generate Application Key

```bash
sail artisan key:generate
```

### 8. Install and Seed the Database

```bash
sail artisan app:install-rate-my-courier
```

This command will create the necessary database tables and seed initial data.

## Running Tests

To execute the application tests:

```bash
sail test
```

## CLI Testing Environment

To test the application through the CLI:

```bash
sail artisan courier:playground
```

## API Documentation

You can find the API documentation here:

[API Documentation](http://localhost/docs/api#/)

## Application Usage

The application provides API endpoints for rating courier stores. Refer to the technical documentation for further details.

---

### Author
**ClickWeb - Kakolyris Konstantinos**
