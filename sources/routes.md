# Routes de l'application

| URL                      | Méthode HTTP | Contrôleur           | Méthode            | Titre HTML                          | Commentaire                              |
| ------------------------ | ------------ | -------------------- | ------------------ | ----------------------------------- | ---------------------------------------- |
| `/`                      | `GET`        | `MainController`     | `home`             | Bienvenue sur O'flix                | Page d'accueil                           |
| `/theme/toggle`          | `GET`        | `MainController`     | `themeToggle`      | changement de theme                 | vchangement de theme                     |
| `/movie/{id}`            | `GET`        | `MovieController`    | `show`             | O'flix - Titre du film/série        | Page détails d'un film/série             |
| `/movie/list`            | `GET`        | `MovieController`    | `list`             | Liste des films et séries           | Affichage list filmms et series          |
| `/movie/{id}/review/add` | `GET/POST`   | `ReviewController`   | `add`              | Ajuter une critique                 |
| `/movie/genre/{id}`      | `GET`        | `MovieController`    | `listByGenre`      | Liste des films et séries par genre | Affichage list films et series par genre |
| `/movie/searching`       | `GET`        | `MovieController`    | `search`           | Recherche film ou série             | Résultat de la recherche                 |
| `/favorites`             | `GET`        | `FavoriteController` | `list`             | Favoris                             | Les favoris d'un user                    |
| `/favorites/add`         | `POST`       | `FavoriteController` | `add`              | Ajouter aux favoris                 | Les favoris d'un user                    |
| `/favorites/remove`      | `POST`       | `FavoriteController` | `remove`           | Supprimer des favoris               | Les favoris d'un user                    |
| `/api/movies`            | `GET`        | `ApiController`      | `moviesCollection` | Liste des fims                      | Liste des films en JSON                  |
