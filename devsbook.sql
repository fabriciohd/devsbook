-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.11-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para devsbook
CREATE DATABASE IF NOT EXISTS `devsbook` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `devsbook`;

-- Copiando estrutura para tabela devsbook.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela devsbook.posts: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `id_user`, `type`, `created_at`, `body`) VALUES
	(1, 1, 'text', '2020-04-27 03:32:58', 'Post de teste número 01.'),
	(2, 1, 'text', '2020-04-27 03:34:07', 'Post de Teste\r\n\r\n\r\nNúmero 02.\r\nUm post multilinha.'),
	(3, 1, 'text', '2020-04-27 03:37:59', '....'),
	(4, 1, 'text', '2020-04-29 00:38:54', 'Percebemos, cada vez mais, que a percepção das dificuldades deve passar por modificações independentemente do retorno esperado a longo prazo.'),
	(5, 1, 'photo', '2020-04-29 22:05:01', '1.jpg'),
	(6, 1, 'text', '2020-05-06 02:25:23', 'Ainda assim, existem dúvidas a respeito de como o fenômeno da Internet oferece uma interessante oportunidade para verificação do processo de comunicação como um todo.'),
	(7, 2, 'text', '2020-05-06 15:01:38', 'Nunca é demais lembrar o peso e o significado destes problemas, uma vez que o desafiador cenário globalizado assume importantes posições no estabelecimento das diretrizes de desenvolvimento para o futuro.');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Copiando estrutura para tabela devsbook.post_comments
CREATE TABLE IF NOT EXISTS `post_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela devsbook.post_comments: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `post_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_comments` ENABLE KEYS */;

-- Copiando estrutura para tabela devsbook.post_likes
CREATE TABLE IF NOT EXISTS `post_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela devsbook.post_likes: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `post_likes` DISABLE KEYS */;
INSERT INTO `post_likes` (`id`, `id_post`, `id_user`, `created_at`) VALUES
	(4, 6, 2, '2020-07-17 14:20:29'),
	(5, 5, 2, '2020-07-17 14:20:35'),
	(6, 7, 1, '2020-07-17 14:20:50'),
	(7, 6, 1, '2020-07-17 14:20:51');
/*!40000 ALTER TABLE `post_likes` ENABLE KEYS */;

-- Copiando estrutura para tabela devsbook.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `work` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `cover` varchar(100) NOT NULL DEFAULT 'cover.jpg',
  `token` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela devsbook.users: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `password`, `name`, `birthdate`, `city`, `work`, `avatar`, `cover`, `token`) VALUES
	(1, 'fabricio_hd@hotmail.com', '$2y$10$UNVYfev7de3UsvbX0HbLEeTLsArVhJ4kWtCDRbilgc0N.BkN7xlbq', 'Fabrício Cunha Chaves', '1997-06-29', 'Imperatriz', 'Programador', 'ffa42af86ec73ed96e3ab3268690d80b.jpg', 'a95f272f2331d287d3afc6285bdeb0c1.jpg', '748f6137ed5e5fab097b9f70c9e8e371'),
	(2, 'testador@gmail.com', '$2y$10$V62f99fK4Q.y1CT0Cn29wOJC7KbzcXPddKK9AMezPSPzD9BU680p.', 'Testador MVC', '1980-01-01', NULL, NULL, 'default.jpg', 'cover.jpg', 'fcdb6df139e0b23923b878bf04a73209');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Copiando estrutura para tabela devsbook.user_relations
CREATE TABLE IF NOT EXISTS `user_relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Copiando dados para a tabela devsbook.user_relations: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `user_relations` DISABLE KEYS */;
INSERT INTO `user_relations` (`id`, `user_from`, `user_to`) VALUES
	(5, 1, 2),
	(6, 2, 1);
/*!40000 ALTER TABLE `user_relations` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
