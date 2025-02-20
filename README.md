# 📋 ToDoList  

> **This project was created as part of my training in the OpenClassrooms curriculum (PHP/Symfony Application Developer).**  
> --> *Version : [Français](README_fr.md)* 📖  

## 📖 Description  

**ToDoList** is a simple task management app that allows users to create, view, and organize their to-do lists.  
This project was designed to provide an intuitive interface for users who want to efficiently manage their daily tasks. 

![Project Preview - ToDoList](screenshot.jpg)

## 🚀 Features  

- **Task creation and management** : Easily add, edit, and delete your tasks.  
- **Intuitive organization** : Sort tasks for better management.  
- **Smooth user interface** : Designed for easy and quick use.  
- **Structured database** : Secure storage for tasks.  

## 🚧 Installation  

### Prerequisites  

Before starting, make sure you have the following installed on your machine :  

- **PHP** (version 8.0 or higher)  
- **Symfony** (version 7 or higher)  
- **Composer**  
- **MySQL Database**  

### Installation Steps  

1. **Clone the repository**  
   Use Git to clone the project :  
   ```sh
   git clone https://github.com/TolMen/OCP8_ToDoList.git
   ```
2. **Install dependencies**  
   Run the following command to install the required libraries :  
   ```sh
   symfony console composer install
   ```

3. **Create the database**  
   Update the `.env` file to configure your database :  
   ```sh
   DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
   ```
   Then, execute the following commands :  
   ```sh
   symfony console doctrine:database:create
   symfony console doctrine:schema:update --force
   symfony console doctrine:fixtures:load  # Optional: insert sample data
   ```

## 📄 Documentation  

- [Contribution guidelines](https://github.com/TolMen/OCP8_ToDoList/blob/master/DossierProjet/CONTRIBUTING.md)  
- [Technical documentation](https://github.com/TolMen/OCP8_ToDoList/blob/master/DossierProjet/DocumentationTechnique.md)  
- [Project images](https://github.com/TolMen/OCP8_ToDoList/tree/master/DossierProjet/Design%20-%20Actuel)  
- [Reports](https://github.com/TolMen/OCP8_ToDoList/tree/master/DossierProjet/Rapport)  
- [UML diagrams](https://github.com/TolMen/OCP8_ToDoList/tree/master/DossierProjet/UML)  

---

Thank you for exploring this project.  
Feel free to explore, modify, and improve it ! ✨  

**For any questions or collaboration, feel free to contact me ! 📩**  

[TolMen](https://github.com/TolMen) - [LinkedIn](https://www.linkedin.com/in/jessyfrachisse/)  
