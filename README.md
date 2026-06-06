# Todo App — Backend Laravel

API REST pour la gestion de tâches.

## Technologies
- Laravel 11
- MySQL
- Laravel Sanctum

## Installation

```bash
git clone https://github.com/votre-username/todo-app-backend.git
cd todo-app-backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## Endpoints API

| Méthode | Route | Description |
|---|---|---|
| POST | /api/register | Inscription |
| POST | /api/login | Connexion |
| POST | /api/logout | Déconnexion |
| GET | /api/tasks | Liste des tâches |
| POST | /api/tasks | Créer une tâche |
| PUT | /api/tasks/{id} | Modifier une tâche |
| DELETE | /api/tasks/{id} | Supprimer une tâche |
