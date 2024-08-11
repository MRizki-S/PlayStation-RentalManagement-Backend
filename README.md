# PlayStation Rental Management Backend

Welcome to the **PlayStation Rental Management Backend** repository! This repository contains the APIs and documentation needed for the PlayStation rental management system using Laravel.

## Description

This repository includes:

- **API Endpoints**: APIs needed to interact with the PlayStation rental system. These APIs handle various functionalities, including PlayStation data management, rentals, and users.
- **UML Folder**: Contains UML diagrams that depict the structure and relationships between system components. These diagrams aid in understanding and developing the system.

## Repository Structure

Here is the main structure of this repository:

- `img-Uml/`: Contains UML diagram files for the system, including class diagrams, use case diagrams, and sequence diagrams.
- `Laravel-Ps`: 
  - `app/`: Contains Laravel application code, including models, controllers, and services.
    - `Http/Controllers/`: Contains controllers that manage API logic.
    - `Models/`: Contains models that interact with the database.
  - `routes/`: Contains route files to define API routes.
    - `api.php`: Contains routes for the APIs used in the system.

## Setup and Installation

To get started with this backend, you need to set up your local development environment. Follow these steps:

1. **Clone Repository:**

   ```bash
   git clone https://github.com/MRizki-S/PlayStation-RentalManagement-Backend.git

2. **Instal Dependensi:**<br>
    Navigate to the project directory and install the necessary dependencies.

    ```bash
    cd PlayStation-RentalManagement-Backend
    composer install

3. **Konfigurasi Environment:**<br>
    Copy the .env.example file to .env and adjust the configuration as needed.

    ```bash
    cp .env.example .env

4. **Generate Key Aplikasi:**<br>
    Run the following command to generate the application key.

    ```bash
    php artisan key:generate

5. **Jalankan Migrasi Database:**<br>
     Run migrations to create the necessary database structure.

    ```bash
    php artisan migrate

6. **Jalankan Aplikasi:**<br>
    Start the application with the following command

    ```bash
    php artisan serve

  ## Contribution
  If you would like to contribute to this project, please open the issue tracker to report issues or provide suggestions. Pull requests are highly welcome!
