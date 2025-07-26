# Customer Satisfaction Score – Monorepo
Customer Satisfaction Score (CSAT) is a key performance indicator that measures how satisfied customers are with a company’s products, services, or experiences.
- **Formula**:  
  `CSAT = (Number of Satisfied Customers / Total Responses) × 100`
- **Segmentation**:
  - Typically, uses a 1–5 scale:
    - Satisfied = 4–5
    - Neutral = 3
    - Dissatisfied = 1–2
- **Use Case**: Measures short-term satisfaction with a product/service.

## Tech Stack
- **composer** (dependency manager)
- **Language:** PHP
- **Database:** MySQL 8.0
- **Architecture:** Domain-Driven Design Architecture
- **React** (frontend UI for users)
- **Docker** (optional for Containerized development)

## Project Structure
```bash
csat-app/
│── api-service/               # API Service
│   ├── bin/                   # CLI tools or scripts
│   ├── config/                # App configuration files
│   ├── migrations/            # Database migration scripts
│   ├── public/                # Entry point
│   │   ├── index.php          # Starts HTTP API
│   ├── src/
│   │   ├── Application/       # Application logic/use cases
│   │   ├── Domain/            # Domain models and interfaces
│   │   ├── Infrastructure/    # Database and external service integrations
│   │   ├── Interface/         # API controllers
│
├── web-user/                  # Frontend UI for users (React)
│
│── .gitignore                 # .gitignore file
│── README.md                  # You are here
```

## Project Status
> **Note:** This project is **under active development**.  
> Some features may be incomplete or subject to change.  
> You're welcome to explore or provide feedback!
