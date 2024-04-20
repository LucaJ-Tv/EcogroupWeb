-- -----------------------------------------------------
-- Schema eco_group
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `eco_group` DEFAULT CHARACTER SET utf8 ;
USE `eco_group` ;

-- -----------------------------------------------------
-- Table `eco_group`.`dimensioni`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`dimensioni` (
  `dimensione` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`dimensione`),
  UNIQUE INDEX `dimensione_UNIQUE` (`dimensione` ASC));


-- -----------------------------------------------------
-- Table `eco_group`.`aziende`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`aziende` (
  `codAzienda` INT(11) NOT NULL AUTO_INCREMENT,
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
  UNIQUE INDEX `codAzienda_UNIQUE` (`codAzienda` ASC),
  INDEX `fk_AZIENDA_DIMENSIONE1_idx` (`DIMENSIONE_dimensione` ASC),
  CONSTRAINT `fk_AZIENDA_DIMENSIONE1`
    FOREIGN KEY (`DIMENSIONE_dimensione`)
    REFERENCES `eco_group`.`dimensioni` (`dimensione`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`categorie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`categorie` (
  `codCategoria` INT(11) NOT NULL AUTO_INCREMENT,
  `nomeCategoria` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`codCategoria`),
  UNIQUE INDEX `idCATEGORIA_UNIQUE` (`nomeCategoria` ASC));


-- -----------------------------------------------------
-- Table `eco_group`.`codici_cer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`codici_cer` (
  `codiceCER` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`codiceCER`),
  UNIQUE INDEX `codiceCER_UNIQUE` (`codiceCER` ASC));


-- -----------------------------------------------------
-- Table `eco_group`.`codici_azienda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`codici_azienda` (
  `AZIENDE_codAzienda` INT(11) NOT NULL,
  `CODICI_CER_codiceCER` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`AZIENDE_codAzienda`, `CODICI_CER_codiceCER`),
  INDEX `fk_CODICI_AZIENDA_AZIENDE1_idx` (`AZIENDE_codAzienda` ASC),
  INDEX `fk_CODICI_AZIENDA_CODICI_CER1_idx` (`CODICI_CER_codiceCER` ASC),
  CONSTRAINT `fk_CODICI_AZIENDA_AZIENDE1`
    FOREIGN KEY (`AZIENDE_codAzienda`)
    REFERENCES `eco_group`.`aziende` (`codAzienda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CODICI_AZIENDA_CODICI_CER1`
    FOREIGN KEY (`CODICI_CER_codiceCER`)
    REFERENCES `eco_group`.`codici_cer` (`codiceCER`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`moderatori`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`moderatori` (
  `codModeratore` INT(11) NOT NULL AUTO_INCREMENT,
  `mail` VARCHAR(128) NOT NULL,
  `username` VARCHAR(64) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`codModeratore`),
  UNIQUE INDEX `mail_UNIQUE` (`mail` ASC),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `codModeratore_UNIQUE` (`codModeratore` ASC));


-- -----------------------------------------------------
-- Table `eco_group`.`domande`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`domande` (
  `codDomanda` INT(11) NOT NULL AUTO_INCREMENT,
  `positiva` TINYINT(4) NOT NULL,
  `testo` VARCHAR(1024) NOT NULL,
  `CATEGORIE_idCATEGORIA` VARCHAR(100) NOT NULL,
  `moderatori_codModeratore` INT(11) NOT NULL,
  PRIMARY KEY (`codDomanda`),
  UNIQUE INDEX `codDomanda_UNIQUE` (`codDomanda` ASC),
  INDEX `fk_DOMANDE_CATEGORIE1_idx` (`CATEGORIE_idCATEGORIA` ASC),
  INDEX `fk_domande_moderatori1_idx` (`moderatori_codModeratore` ASC),
  CONSTRAINT `fk_DOMANDE_CATEGORIE1`
    FOREIGN KEY (`CATEGORIE_idCATEGORIA`)
    REFERENCES `eco_group`.`categorie` (`nomeCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_domande_moderatori1`
    FOREIGN KEY (`moderatori_codModeratore`)
    REFERENCES `eco_group`.`moderatori` (`codModeratore`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`questionari`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`questionari` (
  `codQuestionario` INT(11) NOT NULL AUTO_INCREMENT,
  `titolo` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`codQuestionario`),
  UNIQUE INDEX `codQuestionario_UNIQUE` (`codQuestionario` ASC),
  UNIQUE INDEX `titolo_UNIQUE` (`titolo` ASC));


-- -----------------------------------------------------
-- Table `eco_group`.`sezioni`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`sezioni` (
  `nome` VARCHAR(255) NOT NULL,
  `questionari_codQuestionario` INT(11) NOT NULL,
  PRIMARY KEY (`nome`, `questionari_codQuestionario`),
  INDEX `fk_sezioni_questionari1_idx` (`questionari_codQuestionario` ASC),
  CONSTRAINT `fk_sezioni_questionari1`
    FOREIGN KEY (`questionari_codQuestionario`)
    REFERENCES `eco_group`.`questionari` (`codQuestionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`domande_questionari`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`domande_questionari` (
  `codDomandaQuestionario` INT(11) NOT NULL AUTO_INCREMENT,
  `numeroDomanda` INT(11) NOT NULL,
  `peso` DOUBLE NOT NULL,
  `DOMANDE_codDomanda` INT(11) NOT NULL,
  `sezioni_nome` VARCHAR(255) NOT NULL,
  `sezioni_questionari_codQuestionario` INT(11) NOT NULL,
  PRIMARY KEY (`codDomandaQuestionario`),
  UNIQUE INDEX `codDomandaQuestionario_UNIQUE` (`codDomandaQuestionario` ASC),
  INDEX `fk_DOMANDA_QUESTIONARIO_DOMANDE1_idx` (`DOMANDE_codDomanda` ASC),
  INDEX `fk_domande_questionari_sezioni1_idx` (`sezioni_nome` ASC, `sezioni_questionari_codQuestionario` ASC),
  CONSTRAINT `fk_DOMANDA_QUESTIONARIO_DOMANDE1`
    FOREIGN KEY (`DOMANDE_codDomanda`)
    REFERENCES `eco_group`.`domande` (`codDomanda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_domande_questionari_sezioni1`
    FOREIGN KEY (`sezioni_nome` , `sezioni_questionari_codQuestionario`)
    REFERENCES `eco_group`.`sezioni` (`nome` , `questionari_codQuestionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`modifiche`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`modifiche` (
  `idModifica` INT(11) NOT NULL AUTO_INCREMENT,
  `descrizione` VARCHAR(255) NULL DEFAULT NULL,
  `MODERATORI_codModeratore` INT(11) NOT NULL,
  `QUESTIONARI_codQuestionario` INT(11) NOT NULL,
  PRIMARY KEY (`idModifica`),
  UNIQUE INDEX `idModifica_UNIQUE` (`idModifica` ASC),
  INDEX `fk_MODIFICHE_MODERATORI1_idx` (`MODERATORI_codModeratore` ASC),
  INDEX `fk_MODIFICHE_QUESTIONARI1_idx` (`QUESTIONARI_codQuestionario` ASC),
  CONSTRAINT `fk_MODIFICHE_MODERATORI1`
    FOREIGN KEY (`MODERATORI_codModeratore`)
    REFERENCES `eco_group`.`moderatori` (`codModeratore`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_MODIFICHE_QUESTIONARI1`
    FOREIGN KEY (`QUESTIONARI_codQuestionario`)
    REFERENCES `eco_group`.`questionari` (`codQuestionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`questionari_compilati`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`questionari_compilati` (
  `codQuestionarioCompilato` INT(11) NOT NULL AUTO_INCREMENT,
  `dataCompilazione` DATE NOT NULL,
  `QUESTIONARI_codQuestionario` INT(11) NOT NULL,
  `aziende_codAzienda` INT(11) NOT NULL,
  PRIMARY KEY (`codQuestionarioCompilato`, `aziende_codAzienda`),
  UNIQUE INDEX `codQuestionarioCompilato_UNIQUE` (`codQuestionarioCompilato` ASC),
  INDEX `fk_QUESTIONARI_COMPILATI_QUESTIONARI1_idx` (`QUESTIONARI_codQuestionario` ASC),
  INDEX `fk_questionari_compilati_aziende1_idx` (`aziende_codAzienda` ASC),
  CONSTRAINT `fk_QUESTIONARI_COMPILATI_QUESTIONARI1`
    FOREIGN KEY (`QUESTIONARI_codQuestionario`)
    REFERENCES `eco_group`.`questionari` (`codQuestionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_questionari_compilati_aziende1`
    FOREIGN KEY (`aziende_codAzienda`)
    REFERENCES `eco_group`.`aziende` (`codAzienda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`risposte`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`risposte` (
  `codRisposta` INT(11) NOT NULL,
  `punteggio` DOUBLE NOT NULL,
  `QUESTIONARI_COMPILATI_codQuestionarioCompilato` INT(11) NOT NULL,
  `DOMANDE_QUESTIONARI_codDomandaQuestionario` INT(11) NOT NULL,
  PRIMARY KEY (`codRisposta`, `QUESTIONARI_COMPILATI_codQuestionarioCompilato`, `DOMANDE_QUESTIONARI_codDomandaQuestionario`),
  INDEX `fk_RISPOSTE_DOMANDE_QUESTIONARI1_idx` (`DOMANDE_QUESTIONARI_codDomandaQuestionario` ASC),
  INDEX `fk_RISPOSTE_QUESTIONARI_COMPILATI1` (`QUESTIONARI_COMPILATI_codQuestionarioCompilato` ASC),
  CONSTRAINT `fk_RISPOSTE_DOMANDE_QUESTIONARI1`
    FOREIGN KEY (`DOMANDE_QUESTIONARI_codDomandaQuestionario`)
    REFERENCES `eco_group`.`domande_questionari` (`codDomandaQuestionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_RISPOSTE_QUESTIONARI_COMPILATI1`
    FOREIGN KEY (`QUESTIONARI_COMPILATI_codQuestionarioCompilato`)
    REFERENCES `eco_group`.`questionari_compilati` (`codQuestionarioCompilato`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `eco_group`.`scelte`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eco_group`.`scelte` (
  `codScelta` INT NOT NULL AUTO_INCREMENT,
  `valore` VARCHAR(128) NOT NULL,
  `peso` DOUBLE NOT NULL,
  `domande_codDomanda` INT(11) NOT NULL,
  INDEX `fk_scelte_domande1_idx` (`domande_codDomanda` ASC),
  PRIMARY KEY (`codScelta`),
  CONSTRAINT `fk_scelte_domande1`
    FOREIGN KEY (`domande_codDomanda`)
    REFERENCES `eco_group`.`domande` (`codDomanda`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);