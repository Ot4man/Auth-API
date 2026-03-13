# Auth-API 🔐

Une API REST robuste développée avec **Laravel** pour la gestion de l'authentification et des profils utilisateurs. Entièrement sécurisée via **Laravel Sanctum**.

---

## 🚀 Fonctionnalités

- **Authentification complète** : Inscription, Connexion, Déconnexion.
- **Gestion de Profil** : Consultation, mise à jour des informations et suppression du compte.
- **Sécurité** : Routes protégées par token, hachage des mots de passe.
- **Validation** : Contrôle strict des données d'entrée.

---

## 🛠️ Installation

### Prérequis
- PHP >= 8.2
- Composer
- MariaDB / MySQL ou SQLite

### Étapes d'installation

1. **Cloner le projet**
   ```bash
   git clone <votre-repo-url>
   cd Auth-API
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   ```

3. **Configurer l'environnement**
   ```bash
   cp .env.example .env
   ```
   *Note : Configurez votre base de données dans le fichier `.env`.*

4. **Générer la clé d'application**
   ```bash
   php artisan key:generate
   ```

5. **Lancer les migrations**
   ```bash
   php artisan migrate
   ```

6. **Lancer le serveur**
   ```bash
   php artisan serve
   ```
   L'API sera accessible sur `http://127.0.0.1:8000`.

---

## 📖 Documentation de l'API

### Authentification (Publique)

#### 1. Inscription
- **Route** : `POST /api/register`
- **Body (JSON)** :
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Réponse (201)** : `{"message": "Account created successfully"}`

#### 2. Connexion
- **Route** : `POST /api/login`
- **Body (JSON)** :
  ```json
  {
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Réponse (200)** : 
  ```json
  {
    "message": "Login successful",
    "token": "1|AbCde..."
  }
  ```

---

### Gestion du Profil (Protégée)
*Note : Toutes ces routes nécessitent un header `Authorization: Bearer <token>`.*

#### 3. Consulter son profil
- **Route** : `GET /api/me`
- **Réponse (200)** : `{"message": "Profile fetched successfully", "data": {...}}`

#### 4. Modifier son profil
- **Route** : `PUT /api/me`
- **Body (JSON)** : `{"name": "New Name", "email": "new@example.com"}`
- **Réponse (200)** : `{"message": "Profile updated successfully"}`

#### 5. Changer le mot de passe
- **Route** : `PUT /api/me/password`
- **Body (JSON)** :
  ```json
  {
    "current_password": "old_password",
    "new_password": "new_password123",
    "new_password_confirmation": "new_password123"
  }
  ```
- **Réponse (200)** : `{"message": "Password updated successfully"}`

#### 6. Déconnexion
- **Route** : `POST /api/logout`
- **Réponse (200)** : `{"message": "Logout successful"}`

#### 7. Supprimer son compte
- **Route** : `DELETE /api/me`
- **Réponse (200)** : `{"message": "Account deleted successfully"}`

---

## 🧪 Scénario de Test (Postman)

1. **Inscription** : `POST /api/register` avec des données valides.
2. **Connexion** : `POST /api/login` pour récupérer le `token`.
3. **Accès refusé** : `GET /api/me` sans token (doit retourner 401).
4. **Accès autorisé** : `GET /api/me` avec le token dans le Bearer.
5. **Mise à jour** : `PUT /api/me` pour changer le nom.
6. **Sécurité** : `PUT /api/me/password` pour changer le mot de passe.
7. **Déconnexion** : `POST /api/logout`.
8. **Vérification** : `GET /api/me` avec l'ancien token (doit échouer).

---

## ⚠️ Codes Retours Communs

| Code | Signification | Message Type |
|---|---|---|
| **200/201** | Succès | Opération réussie |
| **401** | Unauthorized | Token absent ou invalide |
| **422** | Unprocessable Entity | Erreur de validation (ex: mot de passe trop court) |
| **500** | Server Error | Erreur interne du serveur |
