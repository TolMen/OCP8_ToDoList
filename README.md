# ToDoList

> **Ce projet a été réalisé dans le cadre de mon apprentissage pour le parcours d'OpenClassrooms (Développeur d'application PHP/Symfony).**

ToDoList is a simple task management app that lets you create, view and organize to-do lists. <br>
It is a project designed to provide an intuitive interface for users who want to manage their daily tasks efficiently.

## Installation

<p><strong>1 - Git clone the project</strong></p>
<pre>
    <code>https://github.com/TolMen/OCP8_ToDoList</code>
</pre>

<p><strong>2 - Install libraries</strong></p>
<pre>
    <code>symfony console composer install</code>
</pre>

<p><strong>3 - Create database</strong></p>

- Update DATABASE_URL in the `.env` file with your database configuration:  
  `DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`

- Create the database:  
  `symfony console doctrine:database:create`

- Create database structure:  
  `symfony console doctrine:schema:update --force`

- Insert sample data (optional):  
  `symfony console doctrine:fixtures:load`

## Documentation

- [Contribution guidelines](https://github.com/TolMen/OCP8_ToDoList/blob/master/DossierProjet/CONTRIBUTING.md)
- [Technical documentation](https://github.com/TolMen/OCP8_ToDoList/blob/master/DossierProjet/DocumentationTechnique.md)
- [Project images](https://github.com/TolMen/OCP8_ToDoList/tree/master/DossierProjet/Design%20-%20Actuel)
- [Reports](https://github.com/TolMen/OCP8_ToDoList/tree/master/DossierProjet/Rapport)
- [UML](https://github.com/TolMen/OCP8_ToDoList/tree/master/DossierProjet/UML)

## Author

[TolMen](https://github.com/TolMen) - [LinkedIn](https://www.linkedin.com/in/jessyfrachisse/)

## License

This project is licensed under the MIT License. View the file [LICENSE](LICENSE) for more details.

Feel free to contact me with any questions or contributions. Enjoy exploring the project!
