**Bonjour! Ici tu trouveras tous les données nécéssaires pour l'évaluation de mon projet Skyforge.**

## Informations générales
**Etudiant**: Louay Belkhamsa

**Nom du projet**: Skyforge

**Thème**: Site pour la création de collections de pièces militaires (épées, arcs, armures, pistolets, etc...)

## Avancement:
Toutes les étapes du checklist sont normalement réalisée.
Vous pouvez consulter ce lien pour le [TODO.md](https://github.com/tsp-Ta1wan/Skyforge/blob/dev/TODO.md) 

## Erreurs/fonctionnalités manquantes:
Tous les fonctionnalités codées se compilent et marchent correctement sur mon environnement. 

## Nomenclature:
Inventaire = arsenal 

Objet = piece

## Mise en marche:
1.  
```
cd skyforge
rm -fr composer.lock symfony.lock vendor/ var/cache/
symfony composer install
symfony server:start
```

3. Sur votre navigateur ouvrez **http://localhost:8000/arsenal/list**

4. Naviguez sur l'application.
 
