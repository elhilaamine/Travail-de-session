-- Table for types of dishes
CREATE TABLE IF NOT EXISTS types_plats (
    id INT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

-- Table for types of cuisines
CREATE TABLE IF NOT EXISTS types_cuisines (
    id INT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

-- Table for recipes
CREATE TABLE IF NOT EXISTS recettes (
    id INT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    temps_de_preparation VARCHAR(255) NOT NULL,
    type_de_plat INT,
    type_de_cuisine INT,
    desc_courte TEXT,
    image_url VARCHAR(255),
    FOREIGN KEY (type_de_plat) REFERENCES types_plats(id),
    FOREIGN KEY (type_de_cuisine) REFERENCES types_cuisines(id)
);

-- Table for ingredients
CREATE TABLE IF NOT EXISTS ingredients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recette_id INT,
    nom VARCHAR(255) NOT NULL,
    quantite VARCHAR(255),
    quantite_equivalente VARCHAR(255),
    FOREIGN KEY (recette_id) REFERENCES recettes(id)
);

-- Table for preparation steps
CREATE TABLE IF NOT EXISTS etapes_de_preparation (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recette_id INT,
    etape TEXT,
    etape_numero INT,
    FOREIGN KEY (recette_id) REFERENCES recettes(id)
);

CREATE TABLE IF NOT EXISTS usagers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    nom_utilisateur VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);