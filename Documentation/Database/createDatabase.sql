-- -----------------------------------------------
-- Schema phppostulation
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `phppostulation` DEFAULT CHARACTER SET utf8 ;
USE `phppostulation` ;

-- -----------------------------------------------------
-- Table `phppostulation`.`profile`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `phppostulation`.`profile` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`));

-- -----------------------------------------------------
-- Table `phppostulation`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `phppostulation`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NOT NULL,
  `secondname` VARCHAR(45) NULL,
  `p_surname` VARCHAR(45) NOT NULL,
  `m_surname` VARCHAR(45) NULL,
  `birthdate` DATE NOT NULL,
  `rut_number` INT NOT NULL,
  `rut_digit` VARCHAR(45) NOT NULL,
  `password` VARCHAR(150) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `profile_id` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_profile_idx` (`profile_id` ASC),
  CONSTRAINT `fk_user_profile`
    FOREIGN KEY (`profile_id`)
    REFERENCES `phppostulation`.`profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Insert table Profile
-- -----------------------------------------------------
INSERT INTO `profile` (`id`, `name`, `description`) VALUES 
(NULL, 'Administrador', 'Usuario encargado de administrar la gestión del sistema.'), 
(NULL, 'Doctor', 'Usuario con permisos para gestionar el sistema de salud.'), 
(NULL, 'Cliente', 'Usuario genérico para utilizar los servicios odontológicos del sistema.');