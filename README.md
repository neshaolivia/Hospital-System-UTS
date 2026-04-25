# HOSPITAL_SYSTEM



## Tech Stack

**Framework & Library:** Laravel

**Database:** MySQL

# Installation

Clone Project

```bash
  git clone https://github.com/neshaolivia/Hospital-System-UTS.git
  cd Hospital-System-UTS
```

Open & Install Project

```bash
  composer install  
  npm install

  cp .env.example .env

  php artisan migrate
  # atau  
  php artisan migrate --seed
  # atau
  php artisan migrate:fresh --seed

  php artisan key:generate
```

## Run Locally

Open Terminal

```bash
  composer run dev
```
