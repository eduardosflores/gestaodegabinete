/*
--Substituir o parâmetro:
<db>: nome do banco de dados
*/

use <db>;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `gab_agenda`
--
DROP TABLE IF EXISTS `gab_agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gab_agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `txt_obs` text,
  `color` varchar(7) DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gab_agenda_ext`
--

DROP TABLE IF EXISTS `gab_agenda_ext`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gab_agenda_ext` (
  `id_extensao` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `id_texto` int(10) unsigned NOT NULL,
  `txt_obs` text NOT NULL,
  PRIMARY KEY (`id_extensao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gab_atendimento`
--

DROP TABLE IF EXISTS `gab_atendimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gab_atendimento` (
  `cod_atendimento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dat_atendimento` date NOT NULL,
  `GAB_PESSOA_cod_pessoa` int(10) unsigned NOT NULL,
  `GAB_TIPO_ATENDIMENTO_cod_tipo` int(10) unsigned DEFAULT NULL,
  `GAB_STATUS_ATENDIMENTO_cod_status` int(10) unsigned DEFAULT NULL,
  `txt_detalhes` text,
  `dat_log` datetime DEFAULT NULL,
  `nom_usuario_log` varchar(20) DEFAULT NULL,
  `nom_operacao_log` varchar(20) DEFAULT NULL,
  `ind_status` char(1) NOT NULL,
  PRIMARY KEY (`cod_atendimento`),
  KEY `fk_cod_pessoa` (`GAB_PESSOA_cod_pessoa`),
  KEY `fk_cod_solicitacao` (`GAB_TIPO_ATENDIMENTO_cod_tipo`),
  KEY `fk_cod_status_atendimento` (`GAB_STATUS_ATENDIMENTO_cod_status`),
  CONSTRAINT `fk_cod_pessoa` FOREIGN KEY (`GAB_PESSOA_cod_pessoa`) REFERENCES `gab_pessoa` (`cod_pessoa`),
  CONSTRAINT `fk_cod_solicitacao` FOREIGN KEY (`GAB_TIPO_ATENDIMENTO_cod_tipo`) REFERENCES `gab_tipo_atendimento` (`cod_tipo`),
  CONSTRAINT `fk_cod_status_atendimento` FOREIGN KEY (`GAB_STATUS_ATENDIMENTO_cod_status`) REFERENCES `gab_status_atendimento` (`cod_status`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gab_documento`
--

DROP TABLE IF EXISTS `gab_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gab_documento` (
  `cod_documento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom_documento` varchar(100) DEFAULT NULL,
  `dat_ano` varchar(4) DEFAULT NULL,
  `dat_documento` date NOT NULL,
  `lnk_documento` varchar(500) DEFAULT NULL,
  `txt_assunto` text,
  `GAB_TIPO_DOCUMENTO_cod_tip_doc` int(10) unsigned DEFAULT NULL,
  `GAB_STATUS_DOCUMENTO_cod_status` int(10) unsigned DEFAULT NULL,
  `GAB_UNIDADE_DOCUMENTO_cod_uni_doc` int(10) unsigned DEFAULT NULL,
  `GAB_ATENDIMENTO_cod_atendimento` int(10) unsigned DEFAULT NULL,
  `dat_resposta` date DEFAULT NULL,
  `lnk_resposta` varchar(500) DEFAULT NULL,
  `txt_resposta` text,
  `dat_log` datetime DEFAULT NULL,
  `nom_usuario_log` varchar(20) DEFAULT NULL,
  `nom_operacao_log` varchar(20) DEFAULT NULL,
  `ind_status` char(1) NOT NULL,
  PRIMARY KEY (`cod_documento`),
  KEY `fk_cod_tip_doc` (`GAB_TIPO_DOCUMENTO_cod_tip_doc`),
  KEY `fk_cod_status_doc` (`GAB_STATUS_DOCUMENTO_cod_status`),
  KEY `fk_cod_uni_doc` (`GAB_UNIDADE_DOCUMENTO_cod_uni_doc`),
  KEY `fk_cod_atendimento` (`GAB_ATENDIMENTO_cod_atendimento`),
  CONSTRAINT `fk_cod_atendimento` FOREIGN KEY (`GAB_ATENDIMENTO_cod_atendimento`) REFERENCES `gab_atendimento` (`cod_atendimento`),
  CONSTRAINT `fk_cod_status_doc` FOREIGN KEY (`GAB_STATUS_DOCUMENTO_cod_status`) REFERENCES `gab_status_documento` (`cod_status`),
  CONSTRAINT `fk_cod_tip_doc` FOREIGN KEY (`GAB_TIPO_DOCUMENTO_cod_tip_doc`) REFERENCES `gab_tipo_documento` (`cod_tip_doc`),
  CONSTRAINT `fk_cod_uni_doc` FOREIGN KEY (`GAB_UNIDADE_DOCUMENTO_cod_uni_doc`) REFERENCES `gab_unidade_documento` (`cod_uni_doc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `gab_pessoa`
--

DROP TABLE IF EXISTS `gab_pessoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gab_pessoa` (
  `cod_pessoa` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ind_pessoa` enum('PF','PJ') NOT NULL,
  `nom_nome` varchar(150) NOT NULL,
  `nom_apelido` varchar(100) DEFAULT NULL,
  `nom_ocupacao` varchar(150) DEFAULT NULL,
  `dat_nascimento` date DEFAULT NULL,
  `cod_cpf_cnpj` varchar(18) DEFAULT NULL,
  `cod_ie` varchar(15) DEFAULT NULL,
  `cod_rg` varchar(12) DEFAULT NULL,
  `ind_sexo` char(1) DEFAULT NULL,
  `num_cep` varchar(10) DEFAULT NULL,
  `nom_endereco` varchar(250) DEFAULT NULL,
  `nom_numero` varchar(10) DEFAULT NULL,
  `nom_complemento` varchar(200) DEFAULT NULL,
  `nom_cidade` varchar(100) DEFAULT NULL,
  `nom_estado` char(2) DEFAULT NULL,
  `num_ddd_tel` tinyint(3) unsigned DEFAULT NULL,
  `num_tel` varchar(9) DEFAULT NULL,
  `num_ddd_cel` tinyint(3) unsigned DEFAULT NULL,
  `num_cel` varchar(10) DEFAULT NULL,
  `nom_email` varchar(100) DEFAULT NULL,
  `nom_rede_social` varchar(200) DEFAULT NULL,
  `img_foto` longblob,
  `ind_status` char(1) NOT NULL,
  `txt_obs` text,
  `dat_log` datetime DEFAULT NULL,
  `nom_usuario_log` varchar(20) DEFAULT NULL,
  `nom_operacao_log` varchar(20) DEFAULT NULL,
  `nom_re` varchar(150) DEFAULT NULL,
  `nom_bairro` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`cod_pessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=718 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `gab_status_atendimento`
--

DROP TABLE IF EXISTS `gab_status_atendimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gab_status_atendimento` (
  `cod_status` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom_status` varchar(150) NOT NULL,
  `ind_status` char(1) NOT NULL,
  PRIMARY KEY (`cod_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gab_status_documento`
--

DROP TABLE IF EXISTS `gab_status_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gab_status_documento` (
  `cod_status` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom_status` varchar(150) NOT NULL,
  `ind_status` char(1) NOT NULL,
  PRIMARY KEY (`cod_status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `gab_tipo_atendimento`
--

DROP TABLE IF EXISTS `gab_tipo_atendimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gab_tipo_atendimento` (
  `cod_tipo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom_tipo` varchar(150) NOT NULL,
  `ind_tipo` char(1) NOT NULL,
  PRIMARY KEY (`cod_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `gab_tipo_documento`
--

DROP TABLE IF EXISTS `gab_tipo_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gab_tipo_documento` (
  `cod_tip_doc` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom_tip_doc` varchar(150) NOT NULL,
  `ind_tip_doc` char(1) NOT NULL,
  PRIMARY KEY (`cod_tip_doc`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `gab_unidade_documento`
--

DROP TABLE IF EXISTS `gab_unidade_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gab_unidade_documento` (
  `cod_uni_doc` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom_uni_doc` varchar(150) NOT NULL,
  `ind_uni_doc` char(1) NOT NULL,
  PRIMARY KEY (`cod_uni_doc`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `gab_vereador`
--

DROP TABLE IF EXISTS `gab_vereador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gab_vereador` (
  `nom_vereador` varchar(150) DEFAULT NULL,
  `ind_sexo` char(1) DEFAULT NULL,
  `nom_endereco` varchar(100) DEFAULT NULL,
  `nom_numero` varchar(10) DEFAULT NULL,
  `nom_complemento` varchar(200) DEFAULT NULL,
  `nom_cidade` varchar(100) DEFAULT NULL,
  `nom_estado` char(2) DEFAULT NULL,
  `num_cep` char(9) DEFAULT NULL,
  `img_foto` longblob,
  `tip_foto` varchar(20) DEFAULT NULL,
  `tam_foto` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `nom_usuario` varchar(20) NOT NULL,
  `nom_senha` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `ind_status` char(1) NOT NULL,
  PRIMARY KEY (`nom_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;