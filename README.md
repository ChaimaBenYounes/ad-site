# Site_Annonce
git clone https://github.com/ChaimaBenYounes/Site_Annonce.git
//Configuring the Database and Entity
php bin/console doctrine:database:create
php bin/console make:entity --regenerate
php bin/console make:migration
php bin/console doctrine:migrations:migrate

//Vérifiez  mapping :
php bin/console doctrine:schema:validate
php bin/console doctrine:mapping:info
