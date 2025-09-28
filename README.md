# Waste Collection Management API

Backend API for managing household waste collection. The API is built with Laravel, MongoDB, and Docker for containerized deployment. JWT authentication is used to secure several endpoints.  

## Setup
1. Clone repository  
    ```bash
    git clone https://github.com/yourusername/waste-collection-api.git  
    cd waste-collection-api  
    ```

2. Copy environment file
    ```bash
    cp .env.example .env  
    ```

3. Build and start containers  
    ```bash
    docker-compose up -d --build  
    ```

4. Generate application key and JWT secret  
    ```bash
    docker exec -it waste-collection-app php artisan key:generate
    docker exec -it waste-collection-app php artisan jwt:secret
    ```

5. Run Seeder Admin Account
    ```bash
    docker exec -it waste-collection-app php artisan db:seed
    ```
    
## Usage
- API Base URL: http://localhost:8000  
- Authentication via JWT:  
  Authorization: Bearer <token>  

## API Samples

### Login
POST /api/auth/login  
Body:  
{
  "email": "admin@example.com",
  "password": "password"
}

### Create Household
POST /api/households  
Body:  
{
  "owner_name": "Gibran",
  "address": "Jl. Merdeka Solo"
}

### Create Pickup
POST /api/pickups  
Body:  
{
  "household_id": "<household_id>",
  "type": "organic"
}

### Complete Pickup
PUT /api/pickups/{id}/complete  

### Confirm Payment
PUT /api/payments/{id}/confirm  

### Reports
GET /api/reports/waste-summary  
GET /api/reports/payment-summary  
GET /api/reports/households/{id}/history  