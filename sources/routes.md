# Routes de l'application

| URL                    | Méthode HTTP | Contrôleur        | Méthode     | Titre HTML                   | Commentaire                  |
| ---------------------- | ------------ | ----------------- | ----------- | ---------------------------- | ---------------------------- |
| `/`                    | `GET`        | `MainController`  | `home`      | Bienvenue sur O'flix         | Page d'accueil               |
| `/movie/{id}`          | `GET`        | `MovieController` | `movieShow` | O'flix - Titre du film/série | Page détails d'un film/série |
| `/user/{id}/favorites` | `GET`        | `UserController`  | `favorite`  | O'flix - {User} favorites    | Les favoris d'un user        |
| `/search/{searching}`  | `GET`        | `MainController`  | `search`    | O'flix - {Searching}         | Résultat de la recherche     |
