# Documentation technique

Cette documentation vise à fournir une vue d'ensemble des principales fonctionnalités de l'application, 
en mettant en lumière les fichiers clés à modifier, le processus d'authentification, et l'endroit où les utilisateurs sont stockés. <br>
Cela aidera les nouveaux développeurs à comprendre rapidement le fonctionnement de l'application.

## Structure de l'application

L'application Symfony suit une architecture MVC (Modèle-Vue-Contrôleur). <br>
Ce qui signifie que les données, l'interface utilisateur et la logique métier sont séparées. <br>
Voici les principaux dossiers et fichiers à connaître :

- **src/** : Contient le code source de l'application
- **public/** : Contient les images, le code JavaScript & CSS, ainsi que le favicon
- **templates/** : Contient les fichiers de vue (Twig) pour le rendu des pages.
- **config/** : Contient les fichiers de configuration de l'applications.
- **composer.json** : Contient la liste des dépendances et leur versions.

## Modifications des Fichiers

### -- Controllers --

Emplacement : src/Controller/

- DefaultController.php : Contient la fonction pour affiché la page d'accueil
- TaskController.php : Contient les méthodes pour gérer les tâches
- UserController.php : Contient les méthodes pour gérer les utilisateurs
- SecurityController.php : Gère l'authentification des utilisateurs


Pourquoi les modifier ?

- Ajouter des fonctionnalités au tâches et utilisateurs
- Ajouter de la sécurité

<br>

### -- Modèles --

Emplacement : src/Entity/

- Tag.php : Représente l'entité des tags (étiquette)
- Task.php : Représente l'entité des tâches
- User.php : Représente l'entité des utilisateurs


Pourquoi les modifier ?

- Ajouter des propriétés spécifiques
- Ajuster les propriétés existantes

<br>

### -- Templates (Vue) --

Emplacement : templates/

- component/footer.html.twig : Possède le footer
- component/navbar.html.twig : Possède la barre de navigation
  
- default/index.html.twig : Affiche la page d'accueil
  
- security/login.html.twig : Affiche la page de connexion
  
- task/create.html.twig : Affiche la page de création d'une tâche
- task/edit.html.twig : Affiche la page d'édition d'une tâche
- task/list.html.twig : Affiche la page de la liste des tâches
  
- user/edit.html.twig : Affiche la page de création d'un utilisateur
- user/list.html.twig : Affiche la page d'édition d'un utilisateur
- user/register.html.twig : Affiche la page de la liste des utilisateurs
  
- base.html.twig : Possède le code basic HTML et les liens


Pourquoi les modifier ?

- Améliorer l'interface
- Ajouter des éléments graphiques
- Modifier le flux de navigation

<br>

### -- Security Voter Interface --

Emplacement : src/Security/Voter/

- AccessVoter.php : Contient la méthode qui vérifie si un utilisateur a accès à une fonction
    -- allUser = ROLE_USER ou ROLE_ADMIN
    -- manage = ROLE_ADMIN


Pourquoi les modifier ?

- Ajouter des votes pour contrôler plus d'actions
- Ajouter des permissions

<br>

## Fonctionnalités de l’application

### Authentification

L'authentification dans Symfony est généralement gérée par le composant de sécurité. <br><br>
Voici comment elle fonctionne dans l'application :

**Configuration** 

Dans le fichier config/packages/security.yaml, vous définissez le système d'authentification. <br>
Cela inclut :

- La définition de la ressource de connexion (formulaire de connexion).
- Les encodages de mots de passe.
- Les rôles et les niveaux d'accès.

<br>

**Formulaire de connexion**

- Le formulaire envoie les données (nom d'utilisateur et mot de passe) à SecurityController, qui vérifie les informations d'identification.

<br>

**Gestion des sessions**

- Une fois l'utilisateur authentifié, une session est créée pour garder l'utilisateur connecté. <br>
- Symfony utilise des cookies pour gérer les sessions.

<br>

**Protection des routes**

- Dans les fichiers des controllers, vous pouvez spécifier quelles routes sont accessibles uniquement aux utilisateurs authentifiés.

## Stockage des Utilisateurs

### Base de Données

Les utilisateurs sont stockés dans une table de la base de données, généralement appelée `users`. <br>
Les informations suivantes sont enregistrées :

- `id` : Identifiant unique de l'utilisateur
- `username` : Nom d'utilisateur
- `email` : Adresse email
- `password` : Mot de passe hashé
- `roles` : Rôles de l'utilisateur

### Migrations en Base de données

La configuration de la connexion à la base de données se trouve dans un fichier .env (généralement en développement, on utilise .env.local).
Les migrations de la base de données sont gérées via la commande `php bin/console doctrine:schema:update --force`, permettant ainsi des modifications de la structure de la base de données sans perte de données.

## Conclusion

Cette documentation technique fournit un aperçu de la structure de l'application, 
des fichiers à modifier, du processus d'authentification et du stockage des utilisateurs. <br>
En suivant ces indications, vous devrait être en mesure de naviguer et de modifier le code de manière efficace.

---

Pour toute question ou clarification, n'hésitez pas à consulter la documentation officielle de Symfony.
