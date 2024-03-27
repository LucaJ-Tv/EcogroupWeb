-- MySQL Workbench Forward Engineering
-- -----------------------------------------------------
-- Schema eco_group
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema eco_group
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `eco_group` DEFAULT CHARACTER SET utf8 ;
USE `eco_group` ;

-- -----------------------------------------------------
-- Table `eco_group`.`CATEGORIE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`CATEGORIE` (
  `codCategoria` INT NOT NULL AUTO_INCREMENT,
  `nomeCategoria` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`codCategoria`),
  UNIQUE INDEX `idCATEGORIA_UNIQUE` (`nomeCategoria` ASC));


-- -----------------------------------------------------
-- Table `eco_group`.`MODERATORI`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`MODERATORI` (
  `codModeratore` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(64) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`codModeratore`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `codModeratore_UNIQUE` (`codModeratore` ASC));


-- -----------------------------------------------------
-- Table `eco_group`.`DOMANDE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`DOMANDE` (
  `codDomanda` INT NOT NULL AUTO_INCREMENT,
  `positiva` TINYINT NOT NULL,
  `testo` VARCHAR(512) NOT NULL,
  `CATEGORIE_idCATEGORIA` VARCHAR(100) NOT NULL,
  `SCELTE_DOMANDE_codScelta` INT NOT NULL,
  `MODERATORI_username` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`codDomanda`),
  UNIQUE INDEX `codDomanda_UNIQUE` (`codDomanda` ASC),
  INDEX `fk_DOMANDE_CATEGORIE1_idx` (`CATEGORIE_idCATEGORIA` ASC) ,
  INDEX `fk_DOMANDE_MODERATORI1_idx` (`MODERATORI_username` ASC),
  CONSTRAINT `fk_DOMANDE_CATEGORIE1`
    FOREIGN KEY (`CATEGORIE_idCATEGORIA`)
    REFERENCES `eco_group`.`CATEGORIE` (`nomeCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_DOMANDE_MODERATORI1`
    FOREIGN KEY (`MODERATORI_username`)
    REFERENCES `eco_group`.`MODERATORI` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table `eco_group`.`SCELTE_POSSIBILI`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`SCELTE_POSSIBILI` (
  `codSceltePossibili` INT NOT NULL,
  `DOMANDE_codDomanda` INT NOT NULL,
  PRIMARY KEY (`codSceltePossibili`),
  INDEX `fk_SCELTE_POSSIBILI_DOMANDE1_idx` (`DOMANDE_codDomanda` ASC),
  CONSTRAINT `fk_SCELTE_POSSIBILI_DOMANDE1`
    FOREIGN KEY (`DOMANDE_codDomanda`)
    REFERENCES `eco_group`.`DOMANDE` (`codDomanda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`SCELTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`SCELTE` (
  `valore` VARCHAR(128) NOT NULL,
  `peso` DOUBLE NOT NULL,
  `SCELTE_POSSIBILI_SCELTE_DOMANDE_codScelta` INT NOT NULL,
  PRIMARY KEY (`valore`, `peso`),
  INDEX `fk_SCELTE_SCELTE_POSSIBILI1_idx` (`SCELTE_POSSIBILI_SCELTE_DOMANDE_codScelta` ASC),
  CONSTRAINT `fk_SCELTE_SCELTE_POSSIBILI1`
    FOREIGN KEY (`SCELTE_POSSIBILI_SCELTE_DOMANDE_codScelta`)
    REFERENCES `eco_group`.`SCELTE_POSSIBILI` (`codSceltePossibili`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`QUESTIONARI`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`QUESTIONARI` (
  `codQuestionario` INT NOT NULL AUTO_INCREMENT,
  `titolo` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`codQuestionario`),
  UNIQUE INDEX `codQuestionario_UNIQUE` (`codQuestionario` ASC),
  UNIQUE INDEX `titolo_UNIQUE` (`titolo` ASC));


-- -----------------------------------------------------
-- Table `eco_group`.`DOMANDE_QUESTIONARI`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`DOMANDE_QUESTIONARI` (
  `codDomandaQuestionario` INT NOT NULL,
  `numeroDomanda` INT NOT NULL,
  `peso` DOUBLE NOT NULL,
  `DOMANDE_codDomanda` INT NOT NULL,
  `QUESTIONARIO_codQuestionario` INT NOT NULL,
  PRIMARY KEY (`codDomandaQuestionario`),
  UNIQUE INDEX `codDomandaQuestionario_UNIQUE` (`codDomandaQuestionario` ASC),
  INDEX `fk_DOMANDA_QUESTIONARIO_DOMANDE1_idx` (`DOMANDE_codDomanda` ASC),
  INDEX `fk_DOMANDA_QUESTIONARIO_QUESTIONARIO1_idx` (`QUESTIONARIO_codQuestionario` ASC),
  UNIQUE INDEX `numeroDomanda_UNIQUE` (`numeroDomanda` ASC),
  CONSTRAINT `fk_DOMANDA_QUESTIONARIO_DOMANDE1`
    FOREIGN KEY (`DOMANDE_codDomanda`)
    REFERENCES `eco_group`.`DOMANDE` (`codDomanda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_DOMANDA_QUESTIONARIO_QUESTIONARIO1`
    FOREIGN KEY (`QUESTIONARIO_codQuestionario`)
    REFERENCES `eco_group`.`QUESTIONARI` (`codQuestionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`DIMENSIONI`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`DIMENSIONI` (
  `dimensione` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`dimensione`),
  UNIQUE INDEX `dimensione_UNIQUE` (`dimensione` ASC));


-- -----------------------------------------------------
-- Table `eco_group`.`AZIENDE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`AZIENDE` (
  `codAzienda` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(128) NOT NULL,
  `mail` VARCHAR(128) NOT NULL,
  `citta` VARCHAR(45) NOT NULL,
  `cap` VARCHAR(45) NOT NULL,
  `codAteco` VARCHAR(45) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  `DIMENSIONE_dimensione` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`codAzienda`),
  UNIQUE INDEX `mail_UNIQUE` (`mail` ASC),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  INDEX `fk_AZIENDA_DIMENSIONE1_idx` (`DIMENSIONE_dimensione` ASC),
  UNIQUE INDEX `codAzienda_UNIQUE` (`codAzienda` ASC),
  CONSTRAINT `fk_AZIENDA_DIMENSIONE1`
    FOREIGN KEY (`DIMENSIONE_dimensione`)
    REFERENCES `eco_group`.`DIMENSIONI` (`dimensione`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`CODICI_CER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`CODICI_CER` (
  `codiceCER` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`codiceCER`),
  UNIQUE INDEX `codiceCER_UNIQUE` (`codiceCER` ASC));


-- -----------------------------------------------------
-- Table `eco_group`.`CODICI_AZIENDA`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`CODICI_AZIENDA` (
  `AZIENDE_codAzienda` INT NOT NULL,
  `CODICI_CER_codiceCER` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`AZIENDE_codAzienda`, `CODICI_CER_codiceCER`),
  INDEX `fk_CODICI_AZIENDA_AZIENDE1_idx` (`AZIENDE_codAzienda` ASC),
  INDEX `fk_CODICI_AZIENDA_CODICI_CER1_idx` (`CODICI_CER_codiceCER` ASC),
  CONSTRAINT `fk_CODICI_AZIENDA_AZIENDE1`
    FOREIGN KEY (`AZIENDE_codAzienda`)
    REFERENCES `eco_group`.`AZIENDE` (`codAzienda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CODICI_AZIENDA_CODICI_CER1`
    FOREIGN KEY (`CODICI_CER_codiceCER`)
    REFERENCES `eco_group`.`CODICI_CER` (`codiceCER`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`QUESTIONARI_COMPILATI`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`QUESTIONARI_COMPILATI` (
  `codQuestionarioCompilato` INT NOT NULL AUTO_INCREMENT,
  `dataCompilazione` DATE NOT NULL,
  `QUESTIONARI_codQuestionario` INT NOT NULL,
  `AZIENDE_username` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`codQuestionarioCompilato`, `AZIENDE_username`),
  UNIQUE INDEX `codQuestionarioCompilato_UNIQUE` (`codQuestionarioCompilato` ASC),
  INDEX `fk_QUESTIONARI_COMPILATI_QUESTIONARI1_idx` (`QUESTIONARI_codQuestionario` ASC),
  INDEX `fk_QUESTIONARI_COMPILATI_AZIENDE1_idx` (`AZIENDE_username` ASC),
  CONSTRAINT `fk_QUESTIONARI_COMPILATI_QUESTIONARI1`
    FOREIGN KEY (`QUESTIONARI_codQuestionario`)
    REFERENCES `eco_group`.`QUESTIONARI` (`codQuestionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_QUESTIONARI_COMPILATI_AZIENDE1`
    FOREIGN KEY (`AZIENDE_username`)
    REFERENCES `eco_group`.`AZIENDE` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`RISPOSTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`RISPOSTE` (
  `codRisposta` INT NOT NULL,
  `valore` VARCHAR(128) NULL,
  `QUESTIONARI_COMPILATI_codQuestionarioCompilato` INT NOT NULL,
  `DOMANDE_QUESTIONARI_codDomandaQuestionario` INT NOT NULL,
  PRIMARY KEY (`codRisposta`, `QUESTIONARI_COMPILATI_codQuestionarioCompilato`, `DOMANDE_QUESTIONARI_codDomandaQuestionario`),
  INDEX `fk_RISPOSTE_DOMANDE_QUESTIONARI1_idx` (`DOMANDE_QUESTIONARI_codDomandaQuestionario` ASC),
  CONSTRAINT `fk_RISPOSTE_QUESTIONARI_COMPILATI1`
    FOREIGN KEY (`QUESTIONARI_COMPILATI_codQuestionarioCompilato`)
    REFERENCES `eco_group`.`QUESTIONARI_COMPILATI` (`codQuestionarioCompilato`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_RISPOSTE_DOMANDE_QUESTIONARI1`
    FOREIGN KEY (`DOMANDE_QUESTIONARI_codDomandaQuestionario`)
    REFERENCES `eco_group`.`DOMANDE_QUESTIONARI` (`codDomandaQuestionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`MODIFICHE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`MODIFICHE` (
  `idModifica` INT NOT NULL AUTO_INCREMENT,
  `descrizione` VARCHAR(255) NULL,
  `MODERATORI_codModeratore` INT NOT NULL,
  `QUESTIONARI_codQuestionario` INT NOT NULL,
  PRIMARY KEY (`idModifica`),
  UNIQUE INDEX `idModifica_UNIQUE` (`idModifica` ASC),
  INDEX `fk_MODIFICHE_MODERATORI1_idx` (`MODERATORI_codModeratore` ASC),
  INDEX `fk_MODIFICHE_QUESTIONARI1_idx` (`QUESTIONARI_codQuestionario` ASC),
  CONSTRAINT `fk_MODIFICHE_MODERATORI1`
    FOREIGN KEY (`MODERATORI_codModeratore`)
    REFERENCES `eco_group`.`MODERATORI` (`codModeratore`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_MODIFICHE_QUESTIONARI1`
    FOREIGN KEY (`QUESTIONARI_codQuestionario`)
    REFERENCES `eco_group`.`QUESTIONARI` (`codQuestionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);