# 📋 ToDoList  

> **Ce projet a été réalisé dans le cadre de mon apprentissage pour le parcours d'OpenClassrooms (Développeur d'application PHP/Symfony).**  
> --> *Version : [English](README.md)* 📖  

## 📖 Description  

**ToDoList** est une application de gestion de tâches simple qui permet aux utilisateurs de créer, visualiser et organiser leurs listes de tâches.  
Ce projet a été conçu pour offrir une interface intuitive aux utilisateurs souhaitant gérer efficacement leurs tâches quotidiennes. 

![Aperçu du projet ToDoList](screenshot.jpg)

## 🚀 Fonctionnalités  

- **Création et gestion des tâches** : Ajoutez, modifiez et supprimez vos tâches en toute simplicité.  
- **Organisation intuitive** : Classement des tâches pour une meilleure gestion.  
- **Interface utilisateur fluide** : Conçue pour une utilisation simple et rapide.  
- **Base de données structurée** : Stockage sécurisé des tâches.  

## 🚧 Installation  

### Prérequis  

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :  

- **PHP** (version 8.0 ou supérieure)  
- **Symfony** (version 7 ou supérieure)  
- **Composer**  
- **Base de données MySQL**  

### Étapes d'installation  

1. **Cloner le dépôt**  
   Utilisez Git pour cloner le projet :  
   ```sh
   git clone https://github.com/TolMen/OCP8_ToDoList.git
   ```
2. **Installer les dépendances**  
   Exécutez la commande suivante pour installer les bibliothèques nécessaires :  
   ```sh
   symfony console composer install
   ```

3. **Créer la base de données**  
   Modifiez le fichier `.env` pour configurer votre base de données :  
   ```sh
   DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
   ```
   Ensuite, exécutez les commandes suivantes :  
   ```sh
   symfony console doctrine:database:create
   symfony console doctrine:schema:update --force
   symfony console doctrine:fixtures:load  # Optionnel : insérer des données fictives
   ```

## 📄 Documentation  

- [Contribution guidelines](https://github.com/TolMen/OCP8_ToDoList/blob/master/DossierProjet/CONTRIBUTING.md)  
- [Documentation technique](https://github.com/TolMen/OCP8_ToDoList/blob/master/DossierProjet/DocumentationTechnique.md)  
- [Images du projet](https://github.com/TolMen/OCP8_ToDoList/tree/master/DossierProjet/Design%20-%20Actuel)  
- [Rapports](https://github.com/TolMen/OCP8_ToDoList/tree/master/DossierProjet/Rapport)  
- [Diagrammes UML](https://github.com/TolMen/OCP8_ToDoList/tree/master/DossierProjet/UML)  

---

Merci d'explorer ce projet.  
N'hésitez pas à l'explorer, le modifier et l'améliorer ! ✨  

**Pour toute question ou collaboration, n'hésitez pas à me contacter ! 📩**  

[TolMen](https://github.com/TolMen) - [LinkedIn](https://www.linkedin.com/in/jessyfrachisse/)  
