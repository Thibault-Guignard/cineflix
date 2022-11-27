# Routes de l'application

## Front

| URL                      | Méthode HTTP | Contrôleur         | Méthode           | Titre HTML                          | Commentaire                              |
| ------------------------ | ------------ | ------------------ | ----------------- | ----------------------------------- | ---------------------------------------- |
| `/`                      | `GET`        | `MainController`   | `home`            | Bienvenue sur Cinéflix              | Page d'accueil                           |
| `/theme/toggle`          | `GET`        | `MainController`   | `themeToggle`     | changement de theme                 | Changement de theme                      |
| `/favorites`             | `GET`        | `MainController`   | `favorites`       | Favoris                             | Les favoris d'un user                    |
| `/favorites`             | `POST`       | `MainController`   | `favorites`       | Ajouter aux favoris                 | Les favoris d'un user                    |
| `/favorites/delete`      | `POST`       | `MainController`   | `deleteFavorites` | Supprimer des favoris               | Les favoris d'un user                    |
| `/login`                 | `GET/POST`        | `LoginController`  | `index`           | Connexion                           | Page de connexion                        |
| `/movie/{slug}`            | `GET`        | `MovieController`  | `show`            | Cinéflix - Titre du film/série      | Page détails d'un film/série             |
| `/movie/list`            | `GET`        | `MovieController`  | `list`            | Liste des films et séries           | Affichage list filmms et series          |
| `/movie/genre/{id}`      | `GET`        | `MovieController`  | `listByGenre`     | Liste des films et séries par genre | Affichage list films et series par genre |
| `/movie/{slug}/review/add` | `GET/POST`   | `ReviewController` | `add`             | Ajuter une critique                 |
| *WIP* `/movie/searching` | `GET`        | `MovieController`  | `search`          | Recherche film ou série             | Résultat de la recherche                 |


## API

| URL            | Méthode HTTP | Contrôleur      | Méthode            | Titre HTML     | Commentaire             |
| -------------- | ------------ | --------------- | ------------------ | -------------- | ----------------------- |
| `/movies`      | `GET`        | `ApiController` | `moviesCollection` | Liste des fims | Liste des films en JSON |
| `/movies/{id}` | `GET`        | `ApiController` | `moviesCollection` | Titre du film  | Donné du film donnée    |

## BACK

| URL           | Méthode HTTP | Contrôleur      | Méthode            | Titre HTML     | Commentaire             |
| ------------- | ------------ | --------------- | ------------------ | -------------- | ----------------------- |
| `movie`       | `GET`        | `ApiController` | `moviesCollection` | Liste des fims | Liste des films en JSON |
| `movies/{id}` | `GET`        | `ApiController` | `moviesCollection` | Titre du film  | Donné du film donnée    |
