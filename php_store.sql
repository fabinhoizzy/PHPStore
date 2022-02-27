-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 25-Fev-2022 às 16:36
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `php_store`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(50) UNSIGNED NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(250) DEFAULT NULL,
  `nome_completo` varchar(250) DEFAULT NULL,
  `morada` varchar(250) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `purl` varchar(50) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `email`, `senha`, `nome_completo`, `morada`, `cidade`, `telefone`, `purl`, `activo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'contatofabinhoizzy@gmail.com', '$2y$10$r/vAA3mgmXp/2HlkX8drW.5CUgYrQm0tUWV11uR2I3rfyuDIcTzWS', 'Fábio da SIlva Alves', 'Quadra 99 lt 04  Lago Azul', 'Novo Gama', '61 99999 5555', NULL, 1, '2022-02-09 19:57:58', '2022-02-22 18:16:46', NULL),
(2, 'larissacampos575@gmail.com', '$2y$10$Y/E5Ns84Tk.QBa89zX8DcO0YJfh0Geash/m.bdfiOaMzkAxad.Xcy', 'larissa', 'la', 'novo gama', '', 'w4cvIsfowLVZ', 1, '2022-02-18 20:58:54', '2022-02-18 21:00:38', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(10) UNSIGNED NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `nome_produto` varchar(50) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `imagem` varchar(200) DEFAULT NULL,
  `preco` decimal(6,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `visivel` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `categoria`, `nome_produto`, `descricao`, `imagem`, `preco`, `stock`, `visivel`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'homen', 'Camisa Vermelha', 'Camisa muito confortável!!', 'tshirt_vermelha.png', '45.70', 100, 1, '2021-02-06 19:45:18', '2021-02-06 19:50:10', NULL),
(2, 'homen', 'Camisa Azul bonita', 'Camisa muito confortável!!', 'tshirt_azul.png', '55.25', 100, 1, '2021-02-06 19:45:18', '2021-02-06 19:50:10', NULL),
(3, 'homen', 'Camisa Verde', 'Camisa muito confortável!!', 'tshirt_verde.png', '35.15', 0, 1, '2021-02-06 19:45:18', '2021-02-06 19:50:10', NULL),
(4, 'homen', 'Camisa Amarela', 'Camisa muito confortável!!', 'tshirt_amarela.png', '32.20', 100, 1, '2021-02-06 19:45:18', '2021-02-06 19:50:10', NULL),
(5, 'mulher', 'Vestido Vermelho', 'afasdgd asdgasdg asdg sadgsdg sdg asdgas sdg dsga sdg asdg asdg aa', 'dress_vermelho.png', '75.20', 100, 1, '2021-02-06 19:45:18', '2021-02-06 19:50:10', NULL),
(6, 'mulher', 'Vestido Azul', 'afasdgd asdgasdg asdg sadgsdg sdg asdgas sdg dsga sdg asdg asdg aa', 'dress_azul.png', '86.00', 100, 1, '2021-02-06 19:45:18', '2021-02-06 19:50:10', NULL),
(7, 'mulher', 'Vestido Verde', 'afasdgd asdgasdg asdg sadgsdg sdg asdgas sdg dsga sdg asdg asdg aa', 'dress_verde.png', '48.85', 100, 1, '2021-02-06 19:45:18', '2021-02-06 19:50:10', NULL),
(8, 'mulher', 'Vestido Amarelo', 'afasdgd asdgasdg asdg sadgsdg sdg asdgas sdg dsga sdg asdg asdg aa', 'dress_amarelo.png', '46.85', 100, 1, '2021-02-06 19:45:18', '2021-02-06 19:50:10', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
