-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/10/2026 às 14:49
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cancela`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `acessos`
--

CREATE TABLE `acessos` (
  `id` int(11) NOT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `data_acesso` date NOT NULL,
  `hora_acesso` time NOT NULL,
  `evento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `acessos`
--

INSERT INTO `acessos` (`id`, `professor_id`, `data_acesso`, `hora_acesso`, `evento`) VALUES
(1, NULL, '2026-09-07', '14:27:18', 'CANCELA_ABRIU'),
(2, NULL, '2026-09-07', '15:33:35', 'CANCELA_ABRIU'),
(3, NULL, '2026-09-07', '15:40:44', 'CANCELA_ABRIU'),
(4, NULL, '2026-09-07', '15:40:48', 'CANCELA_FECHOU'),
(5, NULL, '2026-09-07', '15:42:50', 'CANCELA_ABRIU'),
(6, NULL, '2026-09-07', '15:42:54', 'CANCELA_FECHOU'),
(7, NULL, '2026-09-07', '15:44:13', 'CANCELA_ABRIU'),
(8, NULL, '2026-09-07', '15:44:17', 'CANCELA_FECHOU'),
(9, NULL, '2026-09-07', '15:47:19', 'CANCELA_ABRIU'),
(10, NULL, '2026-09-07', '15:47:24', 'CANCELA_FECHOU'),
(11, NULL, '2026-09-07', '15:52:57', 'CANCELA_ABRIU'),
(12, NULL, '2026-09-07', '15:53:01', 'CANCELA_FECHOU'),
(13, NULL, '2026-09-07', '16:00:48', 'CANCELA_ABRIU'),
(14, NULL, '2026-09-07', '16:00:53', 'CANCELA_FECHOU'),
(15, NULL, '2026-09-07', '16:06:38', 'CANCELA_ABRIU'),
(16, NULL, '2026-09-07', '16:06:43', 'CANCELA_FECHOU'),
(17, NULL, '2026-09-07', '16:07:43', 'CANCELA_ABRIU'),
(18, NULL, '2026-09-07', '16:07:48', 'CANCELA_FECHOU'),
(19, NULL, '2026-09-07', '16:19:43', 'CANCELA_ABRIU'),
(20, NULL, '2026-09-07', '16:19:48', 'CANCELA_FECHOU'),
(21, NULL, '2026-09-07', '16:26:01', 'CANCELA_ABRIU'),
(22, NULL, '2026-09-07', '16:26:06', 'CANCELA_FECHOU'),
(23, NULL, '2026-09-07', '16:26:14', 'CANCELA_ABRIU'),
(24, NULL, '2026-09-07', '16:26:18', 'CANCELA_FECHOU'),
(25, NULL, '2026-09-07', '16:30:39', 'CANCELA_ABRIU'),
(26, NULL, '2026-09-07', '16:30:43', 'CANCELA_FECHOU'),
(27, NULL, '2026-09-07', '16:30:59', 'CANCELA_ABRIU'),
(28, NULL, '2026-09-07', '16:31:03', 'CANCELA_FECHOU'),
(29, 1, '2026-09-07', '17:29:53', 'CANCELA_ABRIU'),
(30, 1, '2026-09-07', '17:32:50', 'CANCELA_ABRIU'),
(31, 3, '2026-09-07', '17:40:24', 'CANCELA_ABRIU'),
(32, 1, '2026-09-07', '19:30:10', 'CANCELA_ABRIU'),
(33, 2, '2026-09-07', '19:33:54', 'CANCELA_ABRIU'),
(34, 1, '2026-09-07', '19:37:57', 'CANCELA_ABRIU'),
(35, 1, '2026-09-07', '19:59:48', 'CANCELA_ABRIU'),
(36, 3, '2026-09-07', '20:08:56', 'CANCELA_ABRIU'),
(37, 3, '2026-09-07', '20:27:37', 'CANCELA_ABRIU'),
(38, 1, '2026-09-08', '21:25:10', 'CANCELA_ABRIU'),
(39, 2, '2026-09-08', '21:56:01', 'CANCELA_ABRIU'),
(40, 1, '2026-09-08', '22:17:54', 'CANCELA_ABRIU'),
(41, 3, '2026-09-08', '22:18:26', 'CANCELA_ABRIU'),
(42, 1, '2026-09-08', '22:58:19', 'CANCELA_ABRIU'),
(43, 1, '2026-09-29', '18:20:47', 'CANCELA_ABRIU'),
(44, 1, '2026-09-29', '18:27:50', 'CANCELA_ABRIU'),
(45, 2, '2026-09-29', '18:28:08', 'CANCELA_ABRIU'),
(46, 3, '2026-09-29', '18:29:13', 'CANCELA_ABRIU'),
(47, 5, '2026-09-29', '18:30:06', 'CANCELA_ABRIU'),
(48, 1, '2026-10-01', '14:48:39', 'CANCELA_ABRIU'),
(49, 1, '2026-10-01', '14:50:38', 'CANCELA_ABRIU'),
(50, 1, '2026-10-01', '14:51:54', 'CANCELA_ABRIU');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professores`
--

CREATE TABLE `professores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `tipo` varchar(20) NOT NULL DEFAULT 'Professor',
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professores`
--

INSERT INTO `professores` (`id`, `nome`, `codigo`, `tipo`, `ativo`) VALUES
(1, 'Professor Wesley', '1234', 'Professor', 1),
(2, 'Professor João', '2580', 'Professor', 1),
(3, 'Professora Maria', '3690', 'Professor', 1),
(4, 'Ratinho', '001', 'Professor', 0),
(5, 'Cátia Mendes', '002', 'Aluno', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `acessos`
--
ALTER TABLE `acessos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acessos`
--
ALTER TABLE `acessos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
