/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50731
 Source Host           : localhost:3306
 Source Schema         : bd_produccion_inn

 Target Server Type    : MySQL
 Target Server Version : 50731
 File Encoding         : 65001

 Date: 02/07/2021 18:00:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for fibras
-- ----------------------------
DROP TABLE IF EXISTS `fibras`;
CREATE TABLE `fibras`  (
  `idFibra` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estado` bit(1) NULL DEFAULT NULL,
  PRIMARY KEY (`idFibra`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of fibras
-- ----------------------------
INSERT INTO `fibras` VALUES (1, '1IN00001', 'Papel Blanco Impreso', b'1');
INSERT INTO `fibras` VALUES (2, '1IN00003', 'Color', b'1');
INSERT INTO `fibras` VALUES (3, '1IN00005', 'Termo Mecanico', b'1');
INSERT INTO `fibras` VALUES (4, '1IN00006', 'Merma Conversion', b'1');
INSERT INTO `fibras` VALUES (5, '1IN00048', 'Tetrapack', b'1');
INSERT INTO `fibras` VALUES (6, '1IN00073', 'Folder', b'1');
INSERT INTO `fibras` VALUES (7, '1IN00074', 'Prensa', b'1');
INSERT INTO `fibras` VALUES (8, NULL, 'Carton reciclaje', b'1');
INSERT INTO `fibras` VALUES (9, NULL, 'Etiqueta', b'1');

-- ----------------------------
-- Table structure for maquinas
-- ----------------------------
DROP TABLE IF EXISTS `maquinas`;
CREATE TABLE `maquinas`  (
  `idMaquina` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estado` bit(1) NULL DEFAULT NULL,
  PRIMARY KEY (`idMaquina`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of maquinas
-- ----------------------------
INSERT INTO `maquinas` VALUES (1, 'yankee', b'1');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NULL DEFAULT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `orden` tinyint(3) NULL DEFAULT NULL,
  `icono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  INDEX `id_menu`(`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 38 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (9, 0, 'Inicio', '/home', 1, 'icon-home');
INSERT INTO `menu` VALUES (24, 0, 'Configuración', '/configuracion', 3, 'icon-settings');
INSERT INTO `menu` VALUES (23, 0, 'Produccion', '/produccion', 2, 'icon-bar-chart-2');
INSERT INTO `menu` VALUES (14, 24, 'Menu', '/menu', 4, 'icon-menu');
INSERT INTO `menu` VALUES (15, 0, 'Usuario', '/usuario', 5, 'icon-user');
INSERT INTO `menu` VALUES (25, 24, 'Turnos', '/turnos', 1, 'icon-clock');
INSERT INTO `menu` VALUES (19, 24, 'Rol', '/rol', 2, 'icon-user-check');
INSERT INTO `menu` VALUES (27, 29, 'Mi Inventario', '/inventario', 1, 'icon-box');
INSERT INTO `menu` VALUES (26, 23, 'Ordenes', '/orden-produccion', 1, 'icon-box');
INSERT INTO `menu` VALUES (28, 29, 'Fibras', '/fibras', 2, '/home');
INSERT INTO `menu` VALUES (29, 0, 'Inventario', '/inventario', 4, 'icon-box');
INSERT INTO `menu` VALUES (36, 35, 'Nueva Maquina', 'maquina/nueva', 1, '/icon-home');
INSERT INTO `menu` VALUES (30, 28, 'Agregar Fibra', 'fibras/nueva', 1, '/icon-home');
INSERT INTO `menu` VALUES (31, 28, 'Lista de Fibras', '/fibras', 2, '/icon-home');
INSERT INTO `menu` VALUES (35, 24, 'Maquinas', '/maquinas', 3, '/icon-home');
INSERT INTO `menu` VALUES (34, 23, 'Productos', '/productos', 2, '/icon-home');
INSERT INTO `menu` VALUES (37, 35, 'Lista de Maquinas', '/maquinas', 2, '/icon-home');

-- ----------------------------
-- Table structure for menu_rol
-- ----------------------------
DROP TABLE IF EXISTS `menu_rol`;
CREATE TABLE `menu_rol`  (
  `menu_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  INDEX `menu_id`(`menu_id`) USING BTREE,
  INDEX `rol_id`(`rol_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of menu_rol
-- ----------------------------
INSERT INTO `menu_rol` VALUES (14, 1);
INSERT INTO `menu_rol` VALUES (10, 1);
INSERT INTO `menu_rol` VALUES (11, 1);
INSERT INTO `menu_rol` VALUES (12, 1);
INSERT INTO `menu_rol` VALUES (13, 1);
INSERT INTO `menu_rol` VALUES (19, 4);
INSERT INTO `menu_rol` VALUES (23, 4);
INSERT INTO `menu_rol` VALUES (19, 1);
INSERT INTO `menu_rol` VALUES (9, 2);
INSERT INTO `menu_rol` VALUES (10, 2);
INSERT INTO `menu_rol` VALUES (11, 2);
INSERT INTO `menu_rol` VALUES (12, 2);
INSERT INTO `menu_rol` VALUES (13, 2);
INSERT INTO `menu_rol` VALUES (20, 1);
INSERT INTO `menu_rol` VALUES (9, 3);
INSERT INTO `menu_rol` VALUES (11, 3);
INSERT INTO `menu_rol` VALUES (9, 1);
INSERT INTO `menu_rol` VALUES (23, 1);
INSERT INTO `menu_rol` VALUES (24, 1);
INSERT INTO `menu_rol` VALUES (15, 1);
INSERT INTO `menu_rol` VALUES (14, 2);
INSERT INTO `menu_rol` VALUES (25, 1);
INSERT INTO `menu_rol` VALUES (26, 1);
INSERT INTO `menu_rol` VALUES (9, 5);
INSERT INTO `menu_rol` VALUES (23, 5);
INSERT INTO `menu_rol` VALUES (24, 5);
INSERT INTO `menu_rol` VALUES (15, 5);
INSERT INTO `menu_rol` VALUES (26, 5);
INSERT INTO `menu_rol` VALUES (14, 5);
INSERT INTO `menu_rol` VALUES (19, 5);
INSERT INTO `menu_rol` VALUES (25, 5);
INSERT INTO `menu_rol` VALUES (27, 1);
INSERT INTO `menu_rol` VALUES (28, 1);
INSERT INTO `menu_rol` VALUES (29, 1);
INSERT INTO `menu_rol` VALUES (30, 1);
INSERT INTO `menu_rol` VALUES (31, 1);
INSERT INTO `menu_rol` VALUES (32, 1);
INSERT INTO `menu_rol` VALUES (33, 1);
INSERT INTO `menu_rol` VALUES (34, 1);
INSERT INTO `menu_rol` VALUES (35, 1);
INSERT INTO `menu_rol` VALUES (36, 1);
INSERT INTO `menu_rol` VALUES (37, 1);

-- ----------------------------
-- Table structure for orden_produccion
-- ----------------------------
DROP TABLE IF EXISTS `orden_produccion`;
CREATE TABLE `orden_produccion`  (
  `idOrden` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numOrden` int(11) NOT NULL,
  `producto` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFinal` date NULL DEFAULT NULL,
  `horaInicio` time NOT NULL,
  `horaFinal` time NULL DEFAULT NULL,
  `estado` bit(1) NULL DEFAULT NULL,
  PRIMARY KEY (`idOrden`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of orden_produccion
-- ----------------------------
INSERT INTO `orden_produccion` VALUES (2, 4445, 1, 31, '2021-06-28', '2021-07-03', '06:00:00', '18:00:00', b'1');
INSERT INTO `orden_produccion` VALUES (3, 4446, 1, 31, '2021-07-02', '2021-07-02', '08:20:00', '18:00:00', b'1');
INSERT INTO `orden_produccion` VALUES (4, 4447, 1, 31, '2021-07-02', '2021-07-02', '18:00:00', '18:00:00', b'1');

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos`  (
  `idProducto` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estado` bit(1) NULL DEFAULT NULL,
  PRIMARY KEY (`idProducto`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES (1, 'Papel Toalla', b'1');
INSERT INTO `productos` VALUES (2, 'Papel Toalla', b'1');
INSERT INTO `productos` VALUES (3, 'Papel Toalla', b'0');
INSERT INTO `productos` VALUES (4, 'Papel generico', b'1');

-- ----------------------------
-- Table structure for rol
-- ----------------------------
DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rol
-- ----------------------------
INSERT INTO `rol` VALUES (1, 'Admin', '2021-02-25 17:15:56', '2021-02-25 17:15:56');
INSERT INTO `rol` VALUES (2, 'usuario', '2021-02-26 09:30:49', '2021-02-26 09:30:49');
INSERT INTO `rol` VALUES (3, 'general', '2021-05-25 11:29:02', '2021-05-25 11:29:02');
INSERT INTO `rol` VALUES (4, 'usuario general', '2021-05-25 16:36:27', '2021-05-25 16:36:27');
INSERT INTO `rol` VALUES (5, 'JEFE DE TURNO', '2021-06-22 16:35:30', '2021-06-22 16:35:30');

-- ----------------------------
-- Table structure for turnos
-- ----------------------------
DROP TABLE IF EXISTS `turnos`;
CREATE TABLE `turnos`  (
  `idTurno` int(11) NOT NULL AUTO_INCREMENT,
  `turno` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `horaInicio` time NULL DEFAULT NULL,
  `horaFinal` time NULL DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`idTurno`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of turnos
-- ----------------------------
INSERT INTO `turnos` VALUES (14, 'Matutino', '06:00:00', '18:00:00', 'Horario Matutino', b'1');
INSERT INTO `turnos` VALUES (19, 'Nocturno', '18:00:00', '06:00:00', 'Horario Nocturno', b'1');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `apellidos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `id_grupo` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username`) USING BTREE,
  INDEX `users_id_grupo_foreign`(`id_grupo`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'user', 'user', 'user', '$2y$10$K3qRcvEzt.Vq1UcsgyhTUe/4uMJiM3kvgTSjEv65bdcdUB3O3pcI2', '2021-02-25', 'none', 1, 0, '2021-02-25 17:15:28', '2021-02-25 17:15:28');
INSERT INTO `users` VALUES (2, 'admin', 'admin', 'admin', '$2y$10$K3qRcvEzt.Vq1UcsgyhTUe/4uMJiM3kvgTSjEv65bdcdUB3O3pcI2', '2021-02-25', 'none', 1, 0, '2021-02-25 17:16:16', '2021-02-25 17:16:16');
INSERT INTO `users` VALUES (31, 'Sofia', 'Lopez', 'sofia.lopez', '$2y$10$JvVZtqFMBrW2Q4h2MKzPAu6.EwAOarOTPN9YXxLck/y.MLJTY2iJu', '2021-01-01', 'none', 1, 0, '2021-06-23 12:57:27', '2021-06-23 12:57:27');
INSERT INTO `users` VALUES (30, 'Pedro Pablo', 'Lopez Hernandez', 'pablo.lopez', '$2y$10$uhu12TFFm2e3Q.V/0AJ7UeYYC7e3Vj9AeMVJhyit4EL8EJKdX7T16', '2021-01-01', 'none', 1, 0, '2021-06-23 09:37:30', '2021-06-23 09:37:30');

-- ----------------------------
-- Table structure for usuario_rol
-- ----------------------------
DROP TABLE IF EXISTS `usuario_rol`;
CREATE TABLE `usuario_rol`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `estado` bit(1) NULL DEFAULT NULL,
  INDEX `id`(`id`) USING BTREE,
  INDEX `rol_id`(`rol_id`) USING BTREE,
  INDEX `usuario_id`(`usuario_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of usuario_rol
-- ----------------------------
INSERT INTO `usuario_rol` VALUES (1, 1, 3, b'1');
INSERT INTO `usuario_rol` VALUES (2, 1, 2, NULL);
INSERT INTO `usuario_rol` VALUES (3, 2, 4, NULL);
INSERT INTO `usuario_rol` VALUES (4, 2, 22, NULL);
INSERT INTO `usuario_rol` VALUES (5, 1, 23, NULL);
INSERT INTO `usuario_rol` VALUES (6, 3, 24, NULL);
INSERT INTO `usuario_rol` VALUES (7, 1, 25, NULL);
INSERT INTO `usuario_rol` VALUES (8, 5, 26, NULL);
INSERT INTO `usuario_rol` VALUES (9, 5, 27, NULL);
INSERT INTO `usuario_rol` VALUES (10, 5, 28, NULL);
INSERT INTO `usuario_rol` VALUES (11, 5, 29, NULL);
INSERT INTO `usuario_rol` VALUES (12, 5, 30, NULL);
INSERT INTO `usuario_rol` VALUES (13, 5, 31, NULL);

SET FOREIGN_KEY_CHECKS = 1;
