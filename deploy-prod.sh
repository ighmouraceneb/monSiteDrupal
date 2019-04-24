#Récupérer les sources
git pull origin master

#Récupérer les librairies
composer install

#Mettre à jour la base de données Drupal
drush updb -y

#Export des config de prod
drush csex prod -y

#Importer les configuration
drush cim -y

#Vidage des caches
drush cr 
