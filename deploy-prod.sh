#Récupérer les sources
git pull origin master

#Récupérer les librairies
composer install

#Mettre à jour la base de données Drupal
drush updb -y

#Export des config de prod
drush csex prod -y

#Ajout des config de pro
git add config/prod
git commit -m 'Mise à jour des config de prod'
git push origin master

#Importer les configuration
drush cim -y

#Vidage des caches
drush cr 
