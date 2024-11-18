# Check-list d'avancement du projet

| N° étape | Tâche à faire | Statut | Séance de début prévisionnel | État |
|----------|---------------|--------|------------------------------|------|
| 1        | Prise de connaissance du cahier des charges | OBLIGATOIRE | TP 3 | DONE     |
| 2        | Initialisation du projet Symfony | OBLIGATOIRE | TP 3 |      |
| 3        | Gestion du code source avec Git | RECOMMANDÉ |  |      |
| 4        | Ajout au modèle des données des entités liées [inventaire] et [objet] minimales | OBLIGATOIRE | TP 3 | DONE     |
| 4.1      | - Entité [inventaire] | '' | '' | DONE     |
| 4.2      | - Entité [objet] | '' | '' |  DONE    |
| 4.3      | - Association 1-N entre [inventaire] et [objet] | '' | '' |  DONE    |
| 4.4      | - Propriétés non-essentielles des [objets] (optionnel) | OPTIONNEL | 2ème moitié de projet | DONE     |
| 5        | Ajout de données de tests chargeables avec les fixtures | OBLIGATOIRE | TP 3 |DONE      |
|          | - Pour [inventaire] | | |DONE      |
|          | - Pour [objet] | | |DONE      |
| 6        | Création des pages du "front-office" de consultation des [inventaires] | | | DONE     |
|          | - Consultation de la liste de tous les inventaires (dans un premier temps) | OBLIGATOIRE | TP 4 | DONE     |
|          | - Consultation d'une fiche d'[inventaire] à partir de la liste | OBLIGATOIRE | TP 4 | DONE     |
| 7        | Utilisation de gabarits pour les pages de consultation du front-office | OBLIGATOIRE | TP 5 | DONE     |
|          | - Consultation d'un [objet] | | | DONE     |
|          | - Consultation de la liste des [objets] d'un [inventaire] | | | DONE     |
|          | - Navigation d'un [inventaire] vers la consultation de ses [objets] | | | DONE     |
| 8        | Intégration d'une mise en forme CSS avec Bootstrap dans les gabarits Twig | OBLIGATOIRE | TP 6 | DONE     |
| 9        | Ajout de l'entité membre et du lien membre - [inventaire] | OBLIGATOIRE | TP 3/4 | DONE     |
|          | - Ajout de membre au modèle des données | | | DONE     |
|          | - Ajout de l'association 1-1 entre membre et son inventaire | | | DONE     |
| 10       | Intégration de menus de navigation | OBLIGATOIRE | | DONE     |
| 11       | Ajout de l'entité [galerie] au modèle des données et de l'association M-N avec [objet] | OBLIGATOIRE | | DONE     |
| 12       | Ajout d'un contrôleur CRUD pour [galerie] | OBLIGATOIRE | TP 7 | DONE     |
| 13       | Ajout de fonctions CRUD pour [objet] | OBLIGATOIRE | |  DONE    |
| 14       | Ajout de la consultation des [objets] depuis les [galeries] publiques | OBLIGATOIRE | | DONE     |
| 15       | Consultation de la liste des seuls inventaires d'un membre dans le front-office | OBLIGATOIRE | | DONE     |
| 16       | Contextualisation de la création d'un [objet] en fonction de l'[inventaire] | OBLIGATOIRE | | DONE     |
| 17       | Ajout de la gestion de la mise en ligne d'images pour des photos dans les [objet] | OBLIGATOIRE | TP 8 |  DONE    |
| 18       | Ajout de l'authentification | OBLIGATOIRE | TP 8 | DONE     |
| 19       | Affichage des seules galeries publiques | OBLIGATOIRE | | DONE     |
| 20       | Contextualisation de la création d'une [galerie] en fonction du membre | OPTIONNEL | |      |
| 21       | Contextualisation de l'ajout d'un [objet] à une [galerie] | OPTIONNEL | |      |
| 22       | Utilisation des messages flash pour les CRUDs | OPTIONNEL | |      |
| 23       | Ajout d'une gestion de marque-pages/panier dans le front-office | OPTIONNEL | TP 8 |      |
| 24       | Protection de l'accès aux données à leurs seuls propriétaires | OPTIONNEL | TP 8 |      |
| 25       | Contextualisation du chargement des données en fonction de l'utilisateur connecté | OPTIONNEL | |      |
