-- Database: `demo` and php web application user
CREATE DATABASE demo;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON demo.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE demo;

-- Table structure for table `animals`
CREATE TABLE IF NOT EXISTS `animals` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `speciesName` VARCHAR(100) NOT NULL,
    `age` INT NOT NULL,
    `importDate` DATE NOT NULL,
    `imageFileName` VARCHAR(150) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


-- Dumping data for table `animals`
INSERT INTO `animals` (`id`, `speciesName`, `age`, `importDate`, `imageFileName`) VALUES
(1, 'Branta canadensis', 10, '2020-10-23', 'CanadaGoose.png'),
(2, 'Sciurus carolinensis', 2, '2022-11-11', 'Squirrel.png'),
(3, 'Alces alces', 3, '2020-12-13', 'Moose.png');