# Refactorisation et Migration de Pawcalypse

## Objectifs Généraux
- Migrer le projet **Pawcalypse** vers une structure **MVP** (Model-View-Presenter) tout en respectant les principes **SOLID**.
- Réutiliser la structure existante tout en identifiant et corrigeant les problèmes liés à la maintenabilité, la performance et l’architecture.
- Nettoyer le code et migrer les éléments de l’ancien dossier (`old`) vers la nouvelle structure orientée objet et **Twig**.
- Ajouter les fonctionnalités manquantes comme la gestion des sessions.
- Optimiser les fichiers Twig en éliminant les restes de PHP.
- Finaliser la migration en validant que le projet est opérationnel.

---

## Étape 1 : Audit et Analyse

### Analyser la structure actuelle
- Identifier les dépendances entre fichiers et composants.
- Vérifier si les routes sont correctement définies dans `Router.php` et `AdminRoutes.php`.
- Inspecter les contrôleurs (`AdminController.php`, `LoginController.php`, `UserController.php`) pour détecter :
  - La redondance.
  - Les violations des principes SOLID.
- Analyser les modèles dans `app/models` et `old/models` pour vérifier leur alignement avec la structure MVP.
- Identifier la présence de logique métier dans les vues Twig.

### Cartographier les éléments du dossier `old`
- Lister les fichiers à migrer (ex. : `add_mission.php`, `Missions.php`, etc.).
- Vérifier si les modèles du dossier `old` peuvent être intégrés ou réécrits dans la structure orientée objet.

### Lister les problèmes existants
- Utilisation du PHP dans les fichiers Twig.
- Gestion incohérente des erreurs dans `old/config/whoops.php`.
- Absence de gestion centralisée des sessions.

---

## Étape 2 : Préparation et Structuration

### Mettre en place une méthodologie
- Découper les tâches par priorité (migration, refactorisation, ajout de fonctionnalités).
- Définir une structure uniforme pour les modèles, les contrôleurs et les vues.

---

## Étape 3 : Migration des Éléments Anciens

### Fichiers de configuration
- Migrer les paramètres utiles de `old/config/config.php` vers une structure propre dans le projet principal.

### Migration des anciens modèles
- Réécrire les modèles de `old/models` (`Missions.php`, `Resources.php`, etc.) en suivant une approche orientée objet.
- Regrouper les modèles dans `app/models` avec des entités correspondant aux tables de la base de données.
- Vérifier les requêtes SQL dans les anciens modèles et les adapter pour PDO si nécessaire.

### Migration des anciennes fonctions
- Transférer et intégrer la logique des fichiers comme `add_mission.php` et `update_missions.php` dans les contrôleurs ou services appropriés.
- Supprimer le dossier `old/functions` une fois la migration terminée.

### Nettoyage des anciens fichiers Twig
- Éliminer les restes de PHP dans les vues.
- Structurer les vues avec des blocs héritables (ex. : `base` pour `header/footer`).

---

## Étape 4 : Refactorisation et Optimisation

### Contrôleurs
- Refactoriser les contrôleurs (`AdminController`, `LoginController`, `UserController`) pour suivre les principes SOLID :
  - **Responsabilité unique** : chaque méthode doit avoir un rôle précis.
  - **Injection de dépendances** : injecter Twig et les modèles nécessaires via le constructeur.
- Supprimer toute redondance en regroupant les méthodes similaires dans des classes utilitaires ou des services.

### Base de données
- Créer une classe de gestion de la connexion à la base de données pour remplacer les connexions directes dans les anciens fichiers.

### Gestion des sessions
- Ajouter une classe utilitaire pour les sessions dans `app/services`.
- Intégrer une gestion centralisée des sessions.

---

## Étape 5 : Optimisation des Vues avec Twig

### Nettoyer les fichiers Twig
- Supprimer tout PHP encore présent.
- Organiser les blocs Twig pour une meilleure réutilisabilité (ex. : inclure `header.html.twig` et `footer.html.twig` dans les autres fichiers).

### Uniformiser les fichiers
- Centraliser les styles dans `public/assets`.
- Supprimer tout HTML ou CSS redondant.

---

## Étape 6 : Tests et Validation

### Tests unitaires
- Mettre à jour les tests pour le routeur dans `tests/RouterTest.php`.
- Ajouter des tests pour valider la gestion des sessions, les contrôleurs et les modèles.

### Validation de bout en bout
- Tester l’ensemble des routes pour vérifier la correspondance avec les contrôleurs et les vues.
- Valider le bon fonctionnement des sessions et de la persistance des données.

---

## Livrables Finalisés
- Une structure **MVP** respectant les principes **SOLID**.
- Un projet fonctionnel avec des modèles orientés objet et une gestion centralisée des sessions.
- Des vues propres et optimisées, sans PHP résiduel.
- Une documentation pour aider les développeurs à ajouter des routes, des contrôleurs ou des modèles.
