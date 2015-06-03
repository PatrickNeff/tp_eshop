Pour ajouter une colonne type d'adresse à la table adresse :


ALTER TABLE  `adresse` ADD  `type_adresse` VARCHAR( 40 ) NOT NULL AFTER  `client_id` ;
