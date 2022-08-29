

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for accion
-- ----------------------------
DROP TABLE IF EXISTS `accion`;
CREATE TABLE `accion`  (
  `id_accion` int NOT NULL AUTO_INCREMENT,
  `cod_accion` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cod_programa_ac` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `descr_accion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `orden_accion` int NOT NULL,
  PRIMARY KEY (`id_accion`) USING BTREE,
  UNIQUE INDEX `cod_accion_UNIQUE`(`cod_accion`) USING BTREE,
  INDEX `fk_accion_programa1_idx`(`cod_programa_ac`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of accion
-- ----------------------------
INSERT INTO `accion` VALUES (1, '20220808093601', '20220808091931', 'Ejecución de operativos de interdicción al narcotráfico para el secuestro e incautación de cocaína, marihuana y sustancias químicas controladas, destrucción de fábricas, laboratorios, secuestro de hoja de coca desviada y aprehensión de personas,', 1);
INSERT INTO `accion` VALUES (2, '20220808093842', '20220808091931', 'Ejecución de operaciones coordinadas y simultáneas en frontera contra el tráfico internacional de drogas con países de la región y de interés estratégico.', 2);
INSERT INTO `accion` VALUES (3, '20220808093938', '20220808091931', 'Desarticulación y debilitación económica y logística de organizaciones criminales dedicadas al tráfico ilícito de drogas, mediante el uso de técnicas, tecnología y medios de investigación en delitos de narcotráfico y delitos conexos.', 3);
INSERT INTO `accion` VALUES (4, '20220808104354', '20220808091931', 'Especialización, capacitación, actualización y fortalecimiento de las capacidades técnicas y operativas de servidores públicos policiales en tareas y acciones de inteligencia, investigación, interdicción y prevención de delitos de narcotráfico para integrarlos a la lucha contra el narcotráfico en el CEIAGAVA, CACDD, CIEIIPA y otros de las especialidades', 4);
INSERT INTO `accion` VALUES (5, '20220808104420', '20220808091931', 'Realización de estudios técnicos y científicos de casos investigados por tráfico ilícito de sustancias controladas y utilización de insumos realizados por la DGFELCN - CITESC.', 5);
INSERT INTO `accion` VALUES (6, '20220808104445', '20220808091931', 'Gestión del fortalecimiento institucional a través de proyectos o requerimientos de equipamiento, tecnología e infraestructura para tareas, acciones y actividades de las unidades y grupos especiales de la DGFELCN.', 6);
INSERT INTO `accion` VALUES (7, '20220808104503', '20220808091931', 'Aplicación de instrumentos de investigación de la Ley de Lucha Contra el Tráfico Ilícito de Sustancias Controladas Ley N° 913, en colaboración eficaz e intervención de telecomunicaciones en delitos de narcotráfico.', 7);
INSERT INTO `accion` VALUES (8, '20220809082318', '20220808092334', 'Realización de procesos de fiscalización a empresas    que    manipulan    sustancias químicas  controladas  sujetas  al  control internacional con equipos multidisciplinarios a nivel nacional.', 1);
INSERT INTO `accion` VALUES (9, '20220809082520', '20220808092334', 'Implementación de una plataforma tecnológica de información para que coadyuven en el control y fiscalización de las sustancias químicas controladas.', 2);
INSERT INTO `accion` VALUES (10, '20220809082531', '20220808092334', 'Coordinación y cooperación con entidades estratégicas a nivel nacional (ADUANA, IMPUESTOS, SEGIP, ANH, Funda empresa y otros) para mejorar el control y fiscalización del desvío de sustancias químicas controladas.', 3);
INSERT INTO `accion` VALUES (11, '20220809082540', '20220808092334', 'Actualización de la normativa en tasas, sanciones, multas u otras que fortalecen el accionar de la fiscalización de sustancias químicas controladas.', 4);
INSERT INTO `accion` VALUES (12, '20220809082549', '20220808092334', 'Supervisión, control de la importación, exportación, producción de sustancias químicas controladas a personas naturales o jurídicas a nivel nacional.', 5);
INSERT INTO `accion` VALUES (13, '20220809082558', '20220808092334', 'Fortalecimiento institucional con apertura de sucursal de AGEMED de vigilancia y control en ciudades capitales en coordinación con DIRCABI (Santa Cruz).', 6);
INSERT INTO `accion` VALUES (14, '20220809082604', '20220808092334', 'Actualización y/o especialización al personal de AGEMED en fiscalización e inspección a Laboratorios industriales farmacéuticos e importadoras que fabrican, manejan o manipulan sustancias controladas, en coordinación con los SEDES, a nivel nacional.', 7);
INSERT INTO `accion` VALUES (15, '20220809082611', '20220808092334', 'Fiscalización a laboratorios industriales farmacéuticos e importadoras, relacionados con los inventarios y registros de estupefacientes y psicotrópicos a toda la cadena de suministro (fabricación, importación, almacenamiento, distribución y comercialización).', 8);
INSERT INTO `accion` VALUES (16, '20220809082617', '20220808092334', 'Implementación de un sistema de seguimiento y vigilancia a las recetas y recetario electrónico de psicotrópicos y estupefacientes en establecimientos farmacéuticos públicos y privados a nivel nacional.', 9);
INSERT INTO `accion` VALUES (17, '20220809082650', '20220808092356', 'Elaboración y remisión de informes de inteligencia financiera y patrimonial de personas naturales y/o jurídicas involucradas en delitos de ganancias ilícitas vinculadas al narcotráfico y delitos conexos a requerimiento del Ministerio Público, de conformidad a las atribuciones de la Unidad de Investigación Financiera y fortalecer los mecanismos de coordinación institucional para el cumplimiento de estas atribuciones en la investigación de casos de legitimación de ganancias ilícitas.', 1);
INSERT INTO `accion` VALUES (18, '20220809082656', '20220808092356', 'Gestión y suscripción de convenios de cooperación interinstitucional con entidades que conforman el CPI para fortalecer las atribuciones de la UIF en el marco de la prevención, detección y represión de la LGI, narcotráfico y delitos conexos.', 2);
INSERT INTO `accion` VALUES (19, '20220809082703', '20220808092356', 'Gestión de desarrollo y fortalecimiento de mecanismos e instrumentos que permitan prevenir, identificar y reprimir la legitimación de ganancias ilícitas vinculadas al narcotráfico y delitos conexos.', 3);
INSERT INTO `accion` VALUES (20, '20220809082711', '20220808092356', 'Investigación e inteligencia policial de casos por legitimación de ganancias ilícitas y delitos conexos vinculados al narcotráfico.', 4);
INSERT INTO `accion` VALUES (21, '20220809082716', '20220808092356', 'Realización de acciones policiales de pérdida de dominio en delitos de narcotráfico en etapa pre procesal.', 5);
INSERT INTO `accion` VALUES (22, '20220809082741', '20220808092412', 'Realización del saneamiento administrativo de bienes vinculados a delitos de tráfico ilícito de sustancias controladas.', 1);
INSERT INTO `accion` VALUES (23, '20220809082747', '20220808092412', 'Monetización de bienes, vinculados a delitos de tráfico ilícito de sustancias controladas.', 2);
INSERT INTO `accion` VALUES (24, '20220809082755', '20220808092412', 'Efectivización del saneamiento legal de los bienes administrados por la DIRCABI para su posterior monetización.', 3);
INSERT INTO `accion` VALUES (25, '20220809082804', '20220808092412', 'Sustanciación y patrocinio de procesos de pérdida de dominio de bienes vinculados a delitos de tráfico ilícito de sustancias controladas donde DIRCABI es parte.', 4);
INSERT INTO `accion` VALUES (26, '20220809082812', '20220808092412', 'Fortalecimiento normativo para una adecuada administración de la DIRCABI a través de implementación de manuales.', 5);
INSERT INTO `accion` VALUES (27, '20220809082822', '20220808092412', 'Desarrollo e implementación del sistema informático integrado de bienes.', 6);
INSERT INTO `accion` VALUES (28, '20220809082927', '20220808092556', 'Racionalización de cultivos excedentarios de coca, con diálogo y concertación en zonas autorizadas.', 1);
INSERT INTO `accion` VALUES (29, '20220809082934', '20220808092556', 'Erradicación de cultivos ilegales en zonas no autorizadas, parques nacionales y área protegidas.', 2);
INSERT INTO `accion` VALUES (30, '20220809082939', '20220808092556', 'Coordinación y seguimiento al monitoreo de cultivos de coca en Bolivia, realizado por la UNODC.', 3);
INSERT INTO `accion` VALUES (31, '20220809082946', '20220808092556', 'Aplicación de medidas del control territorial con operaciones de reconocimiento e implementación de campamentos móviles en zonas de expansión.', 4);
INSERT INTO `accion` VALUES (32, '20220809083043', '20220808092615', 'Implementación de mecanismos de control social en la producción de hoja de coca en el Trópico de Cochabamba y Apolo, Caranavi y Yungas de La Paz.', 1);
INSERT INTO `accion` VALUES (33, '20220809083054', '20220808092615', 'Coordinación, control y seguimiento a la aplicación del control social en el Trópico de Cochabamba y los Yungas de La Paz, en base a reportes geográficos consolidados de cultivos de coca.', 2);
INSERT INTO `accion` VALUES (34, '20220809083100', '20220808092615', 'Consolidación de la delimitación de zonas autorizadas enmarcadas en la normativa vigente.', 3);
INSERT INTO `accion` VALUES (35, '20220809083107', '20220808092615', 'Actualización de sistema de monitoreo y seguimiento de cultivos excedentarios de coca – SYSCOCA.', 4);
INSERT INTO `accion` VALUES (36, '20220809083122', '20220808092634', 'Articulación institucional para la adaptación y mitigación de impactos socioeconómico y ambiental en zonas de racionalización y erradicación de cultivos excedentarios de coca.', 1);
INSERT INTO `accion` VALUES (37, '20220809083128', '20220808092634', 'Gestión e implementación de proyectos o acciones productivas, obras civiles, equipamiento y medio ambiente.', 2);
INSERT INTO `accion` VALUES (38, '20220809083159', '20220808092708', 'Consolidación del funcionamiento de la Red de Prevención Integral, Tratamiento, Rehabilitación y Reintegración de Personas con Adicciones y su entorno.', 1);
INSERT INTO `accion` VALUES (39, '20220809083209', '20220808092708', 'Elaboración de un plan nacional de la reducción de la demanda (prevención, tratamiento, rehabilitación y reintegración), en coordinación con todas las entidades involucradas.', 2);
INSERT INTO `accion` VALUES (40, '20220809083216', '20220808092708', 'Promoción de movilizaciones y acciones sobre prevención del consumo de drogas desde el ámbito de la educación, familia, comunidad y salud pública para promover estilos de vida saludable, factores de protección en el marco de la seguridad ciudadana.', 3);
INSERT INTO `accion` VALUES (41, '20220809083224', '20220808092708', 'Realización de estudios epidemiológicos de caracterización del consumo de drogas en población general, poblaciones específicas y género (escolares, universitarios, laboral, poblaciones vulnerables), de manera integral con las instituciones involucradas.', 4);
INSERT INTO `accion` VALUES (42, '20220809083232', '20220808092708', 'Sensibilización de la prevención del consumo de drogas y otros estupefacientes en unidades educativas del nivel secundario del Estado Plurinacional.', 5);
INSERT INTO `accion` VALUES (43, '20220809083250', '20220808092708', 'Realización de encuentros de prevención del consumo de drogas y delito a padres de familia, juntas de vecinos y sociedad en área urbana y/o rural.', 6);
INSERT INTO `accion` VALUES (44, '20220809083301', '20220808092708', 'Realización de asistencia técnica en el ámbito familiar y comunitario en los Gobiernos Autónomos Municipales.', 7);
INSERT INTO `accion` VALUES (45, '20220809083308', '20220808092708', 'Capacitación en prevención del consumo de drogas para servidores públicos policiales de la DGFELCN.', 8);
INSERT INTO `accion` VALUES (46, '20220809083315', '20220808092708', 'Socialización de programas y acciones respecto a la prevención del consumo de drogas, dentro de los grupos vulnerables (privados de libertad) al interior de los centros penitenciarios y centros provinciales de toda Bolivia.', 9);
INSERT INTO `accion` VALUES (47, '20220809083331', '20220808092720', 'Elaboración e implementación de protocolos de tratamiento, rehabilitación y reintegración.', 1);
INSERT INTO `accion` VALUES (48, '20220809083352', '20220808092720', 'Elaboración de la normativa para la acreditación y funcionamiento de servicios de tratamiento, rehabilitación y reintegración para personas con hábitos disfuncionales, adictivos o drogodependientes.', 2);
INSERT INTO `accion` VALUES (49, '20220809083358', '20220808092720', 'Consolidación del funcionamiento de Centros Comunitarios de Salud Mental y Adicciones (tratamiento, rehabilitación y reintegración)', 3);
INSERT INTO `accion` VALUES (50, '20220809083405', '20220808092720', 'Implementación y/o fortalecimiento de las áreas especializadas para tratamiento, rehabilitación y reintegración, de los grupos vulnerables (privados de libertad) con problemas de adicción, que se encuentran al interior de los Centros Penitenciarios y Centros provinciales de toda Bolivia.', 4);
INSERT INTO `accion` VALUES (51, '20220809083413', '20220808092720', 'Elaboración y socialización de investigación respecto al tratamiento, rehabilitación y reintegración de personas con adicciones y su entorno.', 5);
INSERT INTO `accion` VALUES (52, '20220809083452', '20220808092905', 'Consolidación de reuniones de comisiones mixtas con países limítrofes y de la región en asistencia técnica, intercambio de información, experiencias, tecnología y coordinación, para afianzar la lucha contra el narcotráfico en la región.', 1);
INSERT INTO `accion` VALUES (53, '20220809083459', '20220808092905', 'Promociones de reuniones de comisiones mixtas con países estratégicos a nivel internacional para procurar y fortalecer la lucha contra el narcotráfico a nivel regional y mundial, en asistencia técnica, intercambio de información, experiencias, tecnología y cooperación.', 2);
INSERT INTO `accion` VALUES (54, '20220809083504', '20220808092905', 'Gestión, promoción y participación de capacitación, por especialidad, para contar con actualización técnica, especialización profesional, en coordinación con instituciones involucradas en la temática de drogas, para fortalecer la lucha contra el narcotráfico y delitos conexos con países de la región.', 3);
INSERT INTO `accion` VALUES (55, '20220809083522', '20220808092920', 'Articulación de una propuesta regional para alcanzar la consolidación y fortalecimiento del Centro Regional de Inteligencia Antinarcóticos (CERIAN) como un ente de alcance internacional.', 1);
INSERT INTO `accion` VALUES (56, '20220809083527', '20220808092920', 'Coordinación y participación en programas y/o proyectos de cooperación bilateral, regional y multilateral.', 2);
INSERT INTO `accion` VALUES (57, '20220809083533', '20220808092920', 'Gestión, promoción y participación en capacitaciones, por especialidad, para una debida actualización técnica y especialización profesional, en coordinación con las instituciones involucradas en la temática de drogas, para fortalecer la lucha contra el narcotráfico y delitos conexos con organismos de la región y multilaterales.', 3);
INSERT INTO `accion` VALUES (58, '20220809083539', '20220808092920', 'Participación en reuniones o eventos de organismos multilaterales, para socializar la política sectorial y resultados alcanzados de la Estrategia 2021-2025 de Bolivia, asimismo participar para definir y acordar políticas, planes, programas, proyectos y acciones, sobre la problemática mundial de drogas en el ámbito multilateral.', 4);

-- ----------------------------
-- Table structure for actividad
-- ----------------------------
DROP TABLE IF EXISTS `actividad`;
CREATE TABLE `actividad`  (
  `id_actividad` int NOT NULL AUTO_INCREMENT,
  `cod_actividad` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cod_accion_act` char(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `descr_actividad` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `orden_actividad` int NOT NULL,
  PRIMARY KEY (`id_actividad`) USING BTREE,
  UNIQUE INDEX `cod_actividad_UNIQUE`(`cod_actividad`) USING BTREE,
  INDEX `fk_actividad_accion1_idx`(`cod_accion_act`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of actividad
-- ----------------------------

-- ----------------------------
-- Table structure for areas_instituciones
-- ----------------------------
DROP TABLE IF EXISTS `areas_instituciones`;
CREATE TABLE `areas_instituciones`  (
  `id_responsables` int NOT NULL AUTO_INCREMENT,
  `codigo_area_inst` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cod_institucion_area` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `sigla_areas_inst` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `nombre_areas_inst` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `descrp_areas_inst` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id_responsables`) USING BTREE,
  UNIQUE INDEX `codigo_area_inst_UNIQUE`(`codigo_area_inst`) USING BTREE,
  INDEX `fk_areas_instituciones_instituciones1_idx`(`cod_institucion_area`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of areas_instituciones
-- ----------------------------

-- ----------------------------
-- Table structure for carpeta
-- ----------------------------
DROP TABLE IF EXISTS `carpeta`;
CREATE TABLE `carpeta`  (
  `id_carpeta` int NOT NULL AUTO_INCREMENT,
  `codigo_carpeta` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cod_meta_carp` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nombre` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_carpeta`) USING BTREE,
  UNIQUE INDEX `codigo_carpeta`(`codigo_carpeta`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of carpeta
-- ----------------------------

-- ----------------------------
-- Table structure for coordinador
-- ----------------------------
DROP TABLE IF EXISTS `coordinador`;
CREATE TABLE `coordinador`  (
  `id_coordinador` int NOT NULL AUTO_INCREMENT,
  `cod_quien_necesita` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cod_meta_coord` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_coordinador`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 326 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of coordinador
-- ----------------------------
INSERT INTO `coordinador` VALUES (1, '20220808093601', '20220815091453');
INSERT INTO `coordinador` VALUES (2, '20220808093601', '20220815091454');
INSERT INTO `coordinador` VALUES (3, '20220808093601', '20220815091455');
INSERT INTO `coordinador` VALUES (4, '20220808093601', '20220815091456');
INSERT INTO `coordinador` VALUES (5, '20220808093601', '20220815091457');
INSERT INTO `coordinador` VALUES (6, '20220808093842', '20220815091712');
INSERT INTO `coordinador` VALUES (7, '20220808093842', '20220815091713');
INSERT INTO `coordinador` VALUES (8, '20220808093842', '20220815091714');
INSERT INTO `coordinador` VALUES (9, '20220808093842', '20220815091715');
INSERT INTO `coordinador` VALUES (10, '20220808093842', '20220815091716');
INSERT INTO `coordinador` VALUES (11, '20220808093938', '20220815091731');
INSERT INTO `coordinador` VALUES (12, '20220808093938', '20220815091732');
INSERT INTO `coordinador` VALUES (13, '20220808093938', '20220815091733');
INSERT INTO `coordinador` VALUES (14, '20220808093938', '20220815091734');
INSERT INTO `coordinador` VALUES (15, '20220808093938', '20220815091735');
INSERT INTO `coordinador` VALUES (16, '20220808104354', '20220815091755');
INSERT INTO `coordinador` VALUES (17, '20220808104354', '20220815091756');
INSERT INTO `coordinador` VALUES (18, '20220808104354', '20220815091757');
INSERT INTO `coordinador` VALUES (19, '20220808104354', '20220815091758');
INSERT INTO `coordinador` VALUES (20, '20220808104354', '20220815091759');
INSERT INTO `coordinador` VALUES (21, '20220808104420', '20220817103617');
INSERT INTO `coordinador` VALUES (22, '20220808104420', '20220817103618');
INSERT INTO `coordinador` VALUES (23, '20220808104420', '20220817103619');
INSERT INTO `coordinador` VALUES (24, '20220808104420', '20220817103620');
INSERT INTO `coordinador` VALUES (25, '20220808104420', '20220817103621');
INSERT INTO `coordinador` VALUES (26, '20220808104445', '20220817103656');
INSERT INTO `coordinador` VALUES (27, '20220808104445', '20220817103657');
INSERT INTO `coordinador` VALUES (28, '20220808104445', '20220817103658');
INSERT INTO `coordinador` VALUES (29, '20220808104445', '20220817103659');
INSERT INTO `coordinador` VALUES (30, '20220808104445', '20220817103660');
INSERT INTO `coordinador` VALUES (31, '20220808104503', '20220817103727');
INSERT INTO `coordinador` VALUES (32, '20220808104503', '20220817103728');
INSERT INTO `coordinador` VALUES (33, '20220808104503', '20220817103729');
INSERT INTO `coordinador` VALUES (34, '20220808104503', '20220817103730');
INSERT INTO `coordinador` VALUES (35, '20220808104503', '20220817103731');
INSERT INTO `coordinador` VALUES (36, '20220809082318', '20220817103933');
INSERT INTO `coordinador` VALUES (37, '20220809082318', '20220817103934');
INSERT INTO `coordinador` VALUES (38, '20220809082318', '20220817103935');
INSERT INTO `coordinador` VALUES (39, '20220809082318', '20220817103936');
INSERT INTO `coordinador` VALUES (40, '20220809082318', '20220817103937');
INSERT INTO `coordinador` VALUES (41, '20220809082520', '20220817104110');
INSERT INTO `coordinador` VALUES (42, '20220809082520', '20220817104111');
INSERT INTO `coordinador` VALUES (43, '20220809082520', '20220817104112');
INSERT INTO `coordinador` VALUES (44, '20220809082520', '20220817104113');
INSERT INTO `coordinador` VALUES (45, '20220809082520', '20220817104114');
INSERT INTO `coordinador` VALUES (46, '20220809082531', '20220817104131');
INSERT INTO `coordinador` VALUES (47, '20220809082531', '20220817104132');
INSERT INTO `coordinador` VALUES (48, '20220809082531', '20220817104133');
INSERT INTO `coordinador` VALUES (49, '20220809082531', '20220817104134');
INSERT INTO `coordinador` VALUES (50, '20220809082531', '20220817104135');
INSERT INTO `coordinador` VALUES (51, '20220809082540', '20220817104235');
INSERT INTO `coordinador` VALUES (52, '20220809082540', '20220817104236');
INSERT INTO `coordinador` VALUES (53, '20220809082540', '20220817104237');
INSERT INTO `coordinador` VALUES (54, '20220809082540', '20220817104238');
INSERT INTO `coordinador` VALUES (55, '20220809082540', '20220817104239');
INSERT INTO `coordinador` VALUES (56, '20220809082549', '20220817104312');
INSERT INTO `coordinador` VALUES (57, '20220809082549', '20220817104313');
INSERT INTO `coordinador` VALUES (58, '20220809082549', '20220817104314');
INSERT INTO `coordinador` VALUES (59, '20220809082549', '20220817104315');
INSERT INTO `coordinador` VALUES (60, '20220809082549', '20220817104316');
INSERT INTO `coordinador` VALUES (61, '20220809082558', '20220817104339');
INSERT INTO `coordinador` VALUES (62, '20220809082558', '20220817104340');
INSERT INTO `coordinador` VALUES (63, '20220809082558', '20220817104341');
INSERT INTO `coordinador` VALUES (64, '20220809082558', '20220817104342');
INSERT INTO `coordinador` VALUES (65, '20220809082558', '20220817104343');
INSERT INTO `coordinador` VALUES (66, '20220809082604', '20220817104407');
INSERT INTO `coordinador` VALUES (67, '20220809082604', '20220817104408');
INSERT INTO `coordinador` VALUES (68, '20220809082604', '20220817104409');
INSERT INTO `coordinador` VALUES (69, '20220809082604', '20220817104410');
INSERT INTO `coordinador` VALUES (70, '20220809082604', '20220817104411');
INSERT INTO `coordinador` VALUES (71, '20220809082611', '20220817104451');
INSERT INTO `coordinador` VALUES (72, '20220809082611', '20220817104452');
INSERT INTO `coordinador` VALUES (73, '20220809082611', '20220817104453');
INSERT INTO `coordinador` VALUES (74, '20220809082611', '20220817104454');
INSERT INTO `coordinador` VALUES (75, '20220809082611', '20220817104455');
INSERT INTO `coordinador` VALUES (76, '20220809082617', '20220817104519');
INSERT INTO `coordinador` VALUES (77, '20220809082617', '20220817104520');
INSERT INTO `coordinador` VALUES (78, '20220809082617', '20220817104521');
INSERT INTO `coordinador` VALUES (79, '20220809082617', '20220817104522');
INSERT INTO `coordinador` VALUES (80, '20220809082617', '20220817104523');
INSERT INTO `coordinador` VALUES (81, '20220809082650', '20220817104557');
INSERT INTO `coordinador` VALUES (82, '20220809082650', '20220817104558');
INSERT INTO `coordinador` VALUES (83, '20220809082650', '20220817104559');
INSERT INTO `coordinador` VALUES (84, '20220809082650', '20220817104560');
INSERT INTO `coordinador` VALUES (85, '20220809082650', '20220817104561');
INSERT INTO `coordinador` VALUES (86, '20220809082656', '20220817105034');
INSERT INTO `coordinador` VALUES (87, '20220809082656', '20220817105035');
INSERT INTO `coordinador` VALUES (88, '20220809082656', '20220817105036');
INSERT INTO `coordinador` VALUES (89, '20220809082656', '20220817105037');
INSERT INTO `coordinador` VALUES (90, '20220809082656', '20220817105038');
INSERT INTO `coordinador` VALUES (91, '20220809082703', '20220817105101');
INSERT INTO `coordinador` VALUES (92, '20220809082703', '20220817105102');
INSERT INTO `coordinador` VALUES (93, '20220809082703', '20220817105103');
INSERT INTO `coordinador` VALUES (94, '20220809082703', '20220817105104');
INSERT INTO `coordinador` VALUES (95, '20220809082703', '20220817105105');
INSERT INTO `coordinador` VALUES (96, '20220809082711', '20220817105208');
INSERT INTO `coordinador` VALUES (97, '20220809082711', '20220817105209');
INSERT INTO `coordinador` VALUES (98, '20220809082711', '20220817105210');
INSERT INTO `coordinador` VALUES (99, '20220809082711', '20220817105211');
INSERT INTO `coordinador` VALUES (100, '20220809082711', '20220817105212');
INSERT INTO `coordinador` VALUES (101, '20220809082716', '20220817105233');
INSERT INTO `coordinador` VALUES (102, '20220809082716', '20220817105234');
INSERT INTO `coordinador` VALUES (103, '20220809082716', '20220817105235');
INSERT INTO `coordinador` VALUES (104, '20220809082716', '20220817105236');
INSERT INTO `coordinador` VALUES (105, '20220809082716', '20220817105237');
INSERT INTO `coordinador` VALUES (106, '20220809082741', '20220817105340');
INSERT INTO `coordinador` VALUES (107, '20220809082741', '20220817105341');
INSERT INTO `coordinador` VALUES (108, '20220809082741', '20220817105342');
INSERT INTO `coordinador` VALUES (109, '20220809082741', '20220817105343');
INSERT INTO `coordinador` VALUES (110, '20220809082741', '20220817105344');
INSERT INTO `coordinador` VALUES (111, '20220809082747', '20220817105438');
INSERT INTO `coordinador` VALUES (112, '20220809082747', '20220817105439');
INSERT INTO `coordinador` VALUES (113, '20220809082747', '20220817105440');
INSERT INTO `coordinador` VALUES (114, '20220809082747', '20220817105441');
INSERT INTO `coordinador` VALUES (115, '20220809082747', '20220817105442');
INSERT INTO `coordinador` VALUES (116, '20220809082755', '20220817105517');
INSERT INTO `coordinador` VALUES (117, '20220809082755', '20220817105518');
INSERT INTO `coordinador` VALUES (118, '20220809082755', '20220817105519');
INSERT INTO `coordinador` VALUES (119, '20220809082755', '20220817105520');
INSERT INTO `coordinador` VALUES (120, '20220809082755', '20220817105521');
INSERT INTO `coordinador` VALUES (121, '20220809082804', '20220817105548');
INSERT INTO `coordinador` VALUES (122, '20220809082804', '20220817105549');
INSERT INTO `coordinador` VALUES (123, '20220809082804', '20220817105550');
INSERT INTO `coordinador` VALUES (124, '20220809082804', '20220817105551');
INSERT INTO `coordinador` VALUES (125, '20220809082804', '20220817105552');
INSERT INTO `coordinador` VALUES (126, '20220809082812', '20220817105617');
INSERT INTO `coordinador` VALUES (127, '20220809082812', '20220817105618');
INSERT INTO `coordinador` VALUES (128, '20220809082812', '20220817105619');
INSERT INTO `coordinador` VALUES (129, '20220809082812', '20220817105620');
INSERT INTO `coordinador` VALUES (130, '20220809082812', '20220817105621');
INSERT INTO `coordinador` VALUES (131, '20220809082822', '20220817105644');
INSERT INTO `coordinador` VALUES (132, '20220809082822', '20220817105645');
INSERT INTO `coordinador` VALUES (133, '20220809082822', '20220817105646');
INSERT INTO `coordinador` VALUES (134, '20220809082822', '20220817105647');
INSERT INTO `coordinador` VALUES (135, '20220809082822', '20220817105648');
INSERT INTO `coordinador` VALUES (136, '20220809082927', '20220817110226');
INSERT INTO `coordinador` VALUES (137, '20220809082927', '20220817110227');
INSERT INTO `coordinador` VALUES (138, '20220809082927', '20220817110228');
INSERT INTO `coordinador` VALUES (139, '20220809082927', '20220817110229');
INSERT INTO `coordinador` VALUES (140, '20220809082927', '20220817110230');
INSERT INTO `coordinador` VALUES (141, '20220809082934', '20220817110355');
INSERT INTO `coordinador` VALUES (142, '20220809082934', '20220817110356');
INSERT INTO `coordinador` VALUES (143, '20220809082934', '20220817110357');
INSERT INTO `coordinador` VALUES (144, '20220809082934', '20220817110358');
INSERT INTO `coordinador` VALUES (145, '20220809082934', '20220817110359');
INSERT INTO `coordinador` VALUES (146, '20220809082939', '20220817110518');
INSERT INTO `coordinador` VALUES (147, '20220809082939', '20220817110519');
INSERT INTO `coordinador` VALUES (148, '20220809082939', '20220817110520');
INSERT INTO `coordinador` VALUES (149, '20220809082939', '20220817110521');
INSERT INTO `coordinador` VALUES (150, '20220809082939', '20220817110522');
INSERT INTO `coordinador` VALUES (151, '20220809082946', '20220817110956');
INSERT INTO `coordinador` VALUES (152, '20220809082946', '20220817110957');
INSERT INTO `coordinador` VALUES (153, '20220809082946', '20220817110958');
INSERT INTO `coordinador` VALUES (154, '20220809082946', '20220817110959');
INSERT INTO `coordinador` VALUES (155, '20220809082946', '20220817110960');
INSERT INTO `coordinador` VALUES (156, '20220809083043', '20220817111049');
INSERT INTO `coordinador` VALUES (157, '20220809083043', '20220817111050');
INSERT INTO `coordinador` VALUES (158, '20220809083043', '20220817111051');
INSERT INTO `coordinador` VALUES (159, '20220809083043', '20220817111052');
INSERT INTO `coordinador` VALUES (160, '20220809083043', '20220817111053');
INSERT INTO `coordinador` VALUES (161, '20220809083054', '20220817111920');
INSERT INTO `coordinador` VALUES (162, '20220809083054', '20220817111921');
INSERT INTO `coordinador` VALUES (163, '20220809083054', '20220817111922');
INSERT INTO `coordinador` VALUES (164, '20220809083054', '20220817111923');
INSERT INTO `coordinador` VALUES (165, '20220809083054', '20220817111924');
INSERT INTO `coordinador` VALUES (166, '20220809083100', '20220817113004');
INSERT INTO `coordinador` VALUES (167, '20220809083100', '20220817113005');
INSERT INTO `coordinador` VALUES (168, '20220809083100', '20220817113006');
INSERT INTO `coordinador` VALUES (169, '20220809083100', '20220817113007');
INSERT INTO `coordinador` VALUES (170, '20220809083100', '20220817113008');
INSERT INTO `coordinador` VALUES (171, '20220809083107', '20220817113201');
INSERT INTO `coordinador` VALUES (172, '20220809083107', '20220817113202');
INSERT INTO `coordinador` VALUES (173, '20220809083107', '20220817113203');
INSERT INTO `coordinador` VALUES (174, '20220809083107', '20220817113204');
INSERT INTO `coordinador` VALUES (175, '20220809083107', '20220817113205');
INSERT INTO `coordinador` VALUES (176, '20220809083122', '20220817113313');
INSERT INTO `coordinador` VALUES (177, '20220809083122', '20220817113314');
INSERT INTO `coordinador` VALUES (178, '20220809083122', '20220817113315');
INSERT INTO `coordinador` VALUES (179, '20220809083122', '20220817113316');
INSERT INTO `coordinador` VALUES (180, '20220809083122', '20220817113317');
INSERT INTO `coordinador` VALUES (181, '20220809083128', '20220817113732');
INSERT INTO `coordinador` VALUES (182, '20220809083128', '20220817113733');
INSERT INTO `coordinador` VALUES (183, '20220809083128', '20220817113734');
INSERT INTO `coordinador` VALUES (184, '20220809083128', '20220817113735');
INSERT INTO `coordinador` VALUES (185, '20220809083128', '20220817113736');
INSERT INTO `coordinador` VALUES (186, '20220809083159', '20220817114000');
INSERT INTO `coordinador` VALUES (187, '20220809083159', '20220817114001');
INSERT INTO `coordinador` VALUES (188, '20220809083159', '20220817114002');
INSERT INTO `coordinador` VALUES (189, '20220809083159', '20220817114003');
INSERT INTO `coordinador` VALUES (190, '20220809083159', '20220817114004');
INSERT INTO `coordinador` VALUES (191, '20220809083209', '20220817114656');
INSERT INTO `coordinador` VALUES (192, '20220809083209', '20220817114657');
INSERT INTO `coordinador` VALUES (193, '20220809083209', '20220817114658');
INSERT INTO `coordinador` VALUES (194, '20220809083209', '20220817114659');
INSERT INTO `coordinador` VALUES (195, '20220809083209', '20220817114660');
INSERT INTO `coordinador` VALUES (196, '20220809083216', '20220817114910');
INSERT INTO `coordinador` VALUES (197, '20220809083216', '20220817114911');
INSERT INTO `coordinador` VALUES (198, '20220809083216', '20220817114912');
INSERT INTO `coordinador` VALUES (199, '20220809083216', '20220817114913');
INSERT INTO `coordinador` VALUES (200, '20220809083216', '20220817114914');
INSERT INTO `coordinador` VALUES (201, '20220809083216', '20220817115000');
INSERT INTO `coordinador` VALUES (202, '20220809083216', '20220817115001');
INSERT INTO `coordinador` VALUES (203, '20220809083216', '20220817115002');
INSERT INTO `coordinador` VALUES (204, '20220809083216', '20220817115003');
INSERT INTO `coordinador` VALUES (205, '20220809083216', '20220817115004');
INSERT INTO `coordinador` VALUES (206, '20220809083216', '20220817115040');
INSERT INTO `coordinador` VALUES (207, '20220809083216', '20220817115041');
INSERT INTO `coordinador` VALUES (208, '20220809083216', '20220817115042');
INSERT INTO `coordinador` VALUES (209, '20220809083216', '20220817115043');
INSERT INTO `coordinador` VALUES (210, '20220809083216', '20220817115044');
INSERT INTO `coordinador` VALUES (211, '20220809083216', '20220817115225');
INSERT INTO `coordinador` VALUES (212, '20220809083216', '20220817115226');
INSERT INTO `coordinador` VALUES (213, '20220809083216', '20220817115227');
INSERT INTO `coordinador` VALUES (214, '20220809083216', '20220817115228');
INSERT INTO `coordinador` VALUES (215, '20220809083216', '20220817115229');
INSERT INTO `coordinador` VALUES (216, '20220809083216', '20220817115252');
INSERT INTO `coordinador` VALUES (217, '20220809083216', '20220817115253');
INSERT INTO `coordinador` VALUES (218, '20220809083216', '20220817115254');
INSERT INTO `coordinador` VALUES (219, '20220809083216', '20220817115255');
INSERT INTO `coordinador` VALUES (220, '20220809083216', '20220817115256');
INSERT INTO `coordinador` VALUES (221, '20220809083216', '20220817115325');
INSERT INTO `coordinador` VALUES (222, '20220809083216', '20220817115326');
INSERT INTO `coordinador` VALUES (223, '20220809083216', '20220817115327');
INSERT INTO `coordinador` VALUES (224, '20220809083216', '20220817115328');
INSERT INTO `coordinador` VALUES (225, '20220809083216', '20220817115329');
INSERT INTO `coordinador` VALUES (226, '20220809083224', '20220818121107');
INSERT INTO `coordinador` VALUES (227, '20220809083224', '20220818121108');
INSERT INTO `coordinador` VALUES (228, '20220809083224', '20220818121109');
INSERT INTO `coordinador` VALUES (229, '20220809083224', '20220818121110');
INSERT INTO `coordinador` VALUES (230, '20220809083224', '20220818121111');
INSERT INTO `coordinador` VALUES (231, '20220809083232', '20220818121343');
INSERT INTO `coordinador` VALUES (232, '20220809083232', '20220818121344');
INSERT INTO `coordinador` VALUES (233, '20220809083232', '20220818121345');
INSERT INTO `coordinador` VALUES (234, '20220809083232', '20220818121346');
INSERT INTO `coordinador` VALUES (235, '20220809083232', '20220818121347');
INSERT INTO `coordinador` VALUES (236, '20220809083232', '20220818121413');
INSERT INTO `coordinador` VALUES (237, '20220809083232', '20220818121414');
INSERT INTO `coordinador` VALUES (238, '20220809083232', '20220818121415');
INSERT INTO `coordinador` VALUES (239, '20220809083232', '20220818121416');
INSERT INTO `coordinador` VALUES (240, '20220809083232', '20220818121417');
INSERT INTO `coordinador` VALUES (241, '20220809083232', '20220818121444');
INSERT INTO `coordinador` VALUES (242, '20220809083232', '20220818121445');
INSERT INTO `coordinador` VALUES (243, '20220809083232', '20220818121446');
INSERT INTO `coordinador` VALUES (244, '20220809083232', '20220818121447');
INSERT INTO `coordinador` VALUES (245, '20220809083232', '20220818121448');
INSERT INTO `coordinador` VALUES (246, '20220809083250', '20220818121515');
INSERT INTO `coordinador` VALUES (247, '20220809083250', '20220818121516');
INSERT INTO `coordinador` VALUES (248, '20220809083250', '20220818121517');
INSERT INTO `coordinador` VALUES (249, '20220809083250', '20220818121518');
INSERT INTO `coordinador` VALUES (250, '20220809083250', '20220818121519');
INSERT INTO `coordinador` VALUES (251, '20220809083301', '20220818121549');
INSERT INTO `coordinador` VALUES (252, '20220809083301', '20220818121550');
INSERT INTO `coordinador` VALUES (253, '20220809083301', '20220818121551');
INSERT INTO `coordinador` VALUES (254, '20220809083301', '20220818121552');
INSERT INTO `coordinador` VALUES (255, '20220809083301', '20220818121553');
INSERT INTO `coordinador` VALUES (256, '20220809083308', '20220818121728');
INSERT INTO `coordinador` VALUES (257, '20220809083308', '20220818121729');
INSERT INTO `coordinador` VALUES (258, '20220809083308', '20220818121730');
INSERT INTO `coordinador` VALUES (259, '20220809083308', '20220818121731');
INSERT INTO `coordinador` VALUES (260, '20220809083308', '20220818121732');
INSERT INTO `coordinador` VALUES (261, '20220809083315', '20220818121944');
INSERT INTO `coordinador` VALUES (262, '20220809083315', '20220818121945');
INSERT INTO `coordinador` VALUES (263, '20220809083315', '20220818121946');
INSERT INTO `coordinador` VALUES (264, '20220809083315', '20220818121947');
INSERT INTO `coordinador` VALUES (265, '20220809083315', '20220818121948');
INSERT INTO `coordinador` VALUES (266, '20220809083331', '20220818122034');
INSERT INTO `coordinador` VALUES (267, '20220809083331', '20220818122035');
INSERT INTO `coordinador` VALUES (268, '20220809083331', '20220818122036');
INSERT INTO `coordinador` VALUES (269, '20220809083331', '20220818122037');
INSERT INTO `coordinador` VALUES (270, '20220809083331', '20220818122038');
INSERT INTO `coordinador` VALUES (271, '20220809083352', '20220818122056');
INSERT INTO `coordinador` VALUES (272, '20220809083352', '20220818122057');
INSERT INTO `coordinador` VALUES (273, '20220809083352', '20220818122058');
INSERT INTO `coordinador` VALUES (274, '20220809083352', '20220818122059');
INSERT INTO `coordinador` VALUES (275, '20220809083352', '20220818122060');
INSERT INTO `coordinador` VALUES (276, '20220809083358', '20220818122122');
INSERT INTO `coordinador` VALUES (277, '20220809083358', '20220818122123');
INSERT INTO `coordinador` VALUES (278, '20220809083358', '20220818122124');
INSERT INTO `coordinador` VALUES (279, '20220809083358', '20220818122125');
INSERT INTO `coordinador` VALUES (280, '20220809083358', '20220818122126');
INSERT INTO `coordinador` VALUES (281, '20220809083405', '20220818122240');
INSERT INTO `coordinador` VALUES (282, '20220809083405', '20220818122241');
INSERT INTO `coordinador` VALUES (283, '20220809083405', '20220818122242');
INSERT INTO `coordinador` VALUES (284, '20220809083405', '20220818122243');
INSERT INTO `coordinador` VALUES (285, '20220809083405', '20220818122244');
INSERT INTO `coordinador` VALUES (286, '20220809083413', '20220818122311');
INSERT INTO `coordinador` VALUES (287, '20220809083413', '20220818122312');
INSERT INTO `coordinador` VALUES (288, '20220809083413', '20220818122313');
INSERT INTO `coordinador` VALUES (289, '20220809083413', '20220818122314');
INSERT INTO `coordinador` VALUES (290, '20220809083413', '20220818122315');
INSERT INTO `coordinador` VALUES (291, '20220809083452', '20220818123014');
INSERT INTO `coordinador` VALUES (292, '20220809083452', '20220818123015');
INSERT INTO `coordinador` VALUES (293, '20220809083452', '20220818123016');
INSERT INTO `coordinador` VALUES (294, '20220809083452', '20220818123017');
INSERT INTO `coordinador` VALUES (295, '20220809083452', '20220818123018');
INSERT INTO `coordinador` VALUES (296, '20220809083459', '20220818123132');
INSERT INTO `coordinador` VALUES (297, '20220809083459', '20220818123133');
INSERT INTO `coordinador` VALUES (298, '20220809083459', '20220818123134');
INSERT INTO `coordinador` VALUES (299, '20220809083459', '20220818123135');
INSERT INTO `coordinador` VALUES (300, '20220809083459', '20220818123136');
INSERT INTO `coordinador` VALUES (301, '20220809083504', '20220818123312');
INSERT INTO `coordinador` VALUES (302, '20220809083504', '20220818123313');
INSERT INTO `coordinador` VALUES (303, '20220809083504', '20220818123314');
INSERT INTO `coordinador` VALUES (304, '20220809083504', '20220818123315');
INSERT INTO `coordinador` VALUES (305, '20220809083504', '20220818123316');
INSERT INTO `coordinador` VALUES (306, '20220809083522', '20220818123455');
INSERT INTO `coordinador` VALUES (307, '20220809083522', '20220818123456');
INSERT INTO `coordinador` VALUES (308, '20220809083522', '20220818123457');
INSERT INTO `coordinador` VALUES (309, '20220809083522', '20220818123458');
INSERT INTO `coordinador` VALUES (310, '20220809083522', '20220818123459');
INSERT INTO `coordinador` VALUES (311, '20220809083527', '20220818123722');
INSERT INTO `coordinador` VALUES (312, '20220809083527', '20220818123723');
INSERT INTO `coordinador` VALUES (313, '20220809083527', '20220818123724');
INSERT INTO `coordinador` VALUES (314, '20220809083527', '20220818123725');
INSERT INTO `coordinador` VALUES (315, '20220809083527', '20220818123726');
INSERT INTO `coordinador` VALUES (316, '20220809083533', '20220818123934');
INSERT INTO `coordinador` VALUES (317, '20220809083533', '20220818123935');
INSERT INTO `coordinador` VALUES (318, '20220809083533', '20220818123936');
INSERT INTO `coordinador` VALUES (319, '20220809083533', '20220818123937');
INSERT INTO `coordinador` VALUES (320, '20220809083533', '20220818123938');
INSERT INTO `coordinador` VALUES (321, '20220809083539', '20220818124055');
INSERT INTO `coordinador` VALUES (322, '20220809083539', '20220818124056');
INSERT INTO `coordinador` VALUES (323, '20220809083539', '20220818124057');
INSERT INTO `coordinador` VALUES (324, '20220809083539', '20220818124058');
INSERT INTO `coordinador` VALUES (325, '20220809083539', '20220818124059');

-- ----------------------------
-- Table structure for documentos
-- ----------------------------
DROP TABLE IF EXISTS `documentos`;
CREATE TABLE `documentos`  (
  `id_documentos` int NOT NULL AUTO_INCREMENT,
  `cod_meta_doc` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `documentos_tipo` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `documentos_descripcion` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `cod_documento_fis` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `usuario_doc` varchar(35) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_doc` date NOT NULL,
  `cod_carpeta_doc` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_documentos`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of documentos
-- ----------------------------

-- ----------------------------
-- Table structure for entidad
-- ----------------------------
DROP TABLE IF EXISTS `entidad`;
CREATE TABLE `entidad`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sigla` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of entidad
-- ----------------------------
INSERT INTO `entidad` VALUES (1, 'Dirección General de la Fuerza Especial de Lucha Contra el Narcotráfico', 'DGFELCN');
INSERT INTO `entidad` VALUES (2, 'Viceministerio de Defensa Social y Sustancias Controladas', 'VDS');
INSERT INTO `entidad` VALUES (3, 'Ministerio de Salud', 'Min. Salud');
INSERT INTO `entidad` VALUES (4, 'Dirección General de Registro, Control y administración de Bienes Incautados', 'DIRCABI');
INSERT INTO `entidad` VALUES (5, 'Agencia Estatal De Medicamentos Y Tecnologías En Salud', 'AGEMED');
INSERT INTO `entidad` VALUES (6, 'Unidad de Investigaciones Financieras', 'UIF');
INSERT INTO `entidad` VALUES (7, 'Dirección General de Sustancias Controladas', 'DGSC');
INSERT INTO `entidad` VALUES (8, 'Comando Estratégico Operacional “Tte. Gironda”', 'CEO');
INSERT INTO `entidad` VALUES (9, 'Viceministerio de Coca y Desarrollo Integral', 'VCDI');
INSERT INTO `entidad` VALUES (10, 'Oficina de las Naciones Unidas contra la Droga y el Delito', 'UNODC');
INSERT INTO `entidad` VALUES (11, 'Organizaciones Sociales', 'Org. Soc.');
INSERT INTO `entidad` VALUES (12, 'Servicio Nacional de Áreas Protegidas', 'SERNAP');
INSERT INTO `entidad` VALUES (13, 'Dirección General de Defensa Social', 'DIGEDES');
INSERT INTO `entidad` VALUES (14, 'Fondo Nacional de Desarrollo Integral', 'FONADIN');
INSERT INTO `entidad` VALUES (15, 'Ministerio de Educación', 'Min. Educ.');
INSERT INTO `entidad` VALUES (16, 'Unidad de Prevención Contra el Consumo de Drogas', 'UPCCD');
INSERT INTO `entidad` VALUES (17, 'Viceministerio de Seguridad Ciudadana', 'VSC');
INSERT INTO `entidad` VALUES (18, 'Observatorio Boliviano de Seguridad Ciudadana y lucha contra las Drogas', 'OBSCD');
INSERT INTO `entidad` VALUES (19, 'Dirección General de Régimen Penitenciario', 'DGRP');
INSERT INTO `entidad` VALUES (20, 'Unidad de Política Antidroga y Cooperación Internacional', 'UPACI');
INSERT INTO `entidad` VALUES (21, 'Ministerio de Relaciones Exteriores', 'Min. RR.EE.');

-- ----------------------------
-- Table structure for financiador
-- ----------------------------
DROP TABLE IF EXISTS `financiador`;
CREATE TABLE `financiador`  (
  `id_financiador` int NOT NULL AUTO_INCREMENT,
  `cod_finnanciador` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `sigla_financiador` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `nombre_financiador` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `descripcion_financiador` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `fechreg_financiador` date NULL DEFAULT NULL,
  PRIMARY KEY (`id_financiador`) USING BTREE,
  UNIQUE INDEX `nombre_UNIQUE`(`nombre_financiador`) USING BTREE,
  UNIQUE INDEX `cod_finnanciador_UNIQUE`(`cod_finnanciador`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of financiador
-- ----------------------------
INSERT INTO `financiador` VALUES (1, '20220808104616', NULL, 'PLAN DE ACCIÓN 2021-2025', '-', '2022-08-08');

-- ----------------------------
-- Table structure for imagenesadicionales
-- ----------------------------
DROP TABLE IF EXISTS `imagenesadicionales`;
CREATE TABLE `imagenesadicionales`  (
  `id_image_adi` int NOT NULL AUTO_INCREMENT,
  `codigo_img_adicional` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_image_adi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of imagenesadicionales
-- ----------------------------

-- ----------------------------
-- Table structure for indicador
-- ----------------------------
DROP TABLE IF EXISTS `indicador`;
CREATE TABLE `indicador`  (
  `id_indicador` int NOT NULL AUTO_INCREMENT,
  `cod_indicador` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cod_financiador_ind` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `descr_indicador` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `pond_2021` float NOT NULL,
  `pond_2022` float NOT NULL,
  `pond_2023` float NOT NULL,
  `pond_2024` float NOT NULL,
  `pond_2025` float NOT NULL,
  `descrp_img_indicador` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_img_indicador` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `indicador_orden` int NOT NULL,
  PRIMARY KEY (`id_indicador`) USING BTREE,
  UNIQUE INDEX `cod_indicador_UNIQUE`(`cod_indicador`) USING BTREE,
  INDEX `fk_indicador_financiador1_idx`(`cod_financiador_ind`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of indicador
-- ----------------------------
INSERT INTO `indicador` VALUES (1, '20220815091244', '20220808104616', 'Número de organizaciones criminales desarticuladas, dedicadas al tráfico ilícito de sustancias controladas.', 0, 0, 0, 0, 0, '', '', 1);
INSERT INTO `indicador` VALUES (2, '20220815091257', '20220808104616', 'Hectáreas racionalizadas/erradicadas de cultivos excedentarios de coca, para estabilizar la superficie de cultivos de coca permitida por la normativa vigente.', 0, 0, 0, 0, 0, '', '', 2);
INSERT INTO `indicador` VALUES (3, '20220815091308', '20220808104616', 'Tasa de prevalencia de consumo de drogas en población general, para que favorezcan el desarrollo de estilos de vida saludable con enfoque bio psico-social-educativo, comunitario y de salud pública.', 0, 0, 0, 0, 0, '', '', 3);
INSERT INTO `indicador` VALUES (4, '20220815091320', '20220808104616', 'Número de acuerdos y/o compromisos suscritos a nivel bilateral.', 0, 0, 0, 0, 0, '', '', 4);

-- ----------------------------
-- Table structure for instituciones
-- ----------------------------
DROP TABLE IF EXISTS `instituciones`;
CREATE TABLE `instituciones`  (
  `id_institucion` int NOT NULL AUTO_INCREMENT,
  `cod_institucion` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `sigla_institucion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `nombre_institucion` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `descr_institucion` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id_institucion`) USING BTREE,
  UNIQUE INDEX `cod_institucion_UNIQUE`(`cod_institucion`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of instituciones
-- ----------------------------

-- ----------------------------
-- Table structure for login
-- ----------------------------
DROP TABLE IF EXISTS `login`;
CREATE TABLE `login`  (
  `id_login` int NOT NULL AUTO_INCREMENT,
  `cod_cliente_login` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `usuario_login` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `contrasenia` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `nivel` int NULL DEFAULT NULL,
  `estado` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `fecha_reg_log` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_entidad` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_login`) USING BTREE,
  UNIQUE INDEX `usuario_login`(`usuario_login`) USING BTREE,
  UNIQUE INDEX `cod_cliente_login`(`cod_cliente_login`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of login
-- ----------------------------
INSERT INTO `login` VALUES (1, '20220101000001', 'admin', '0260d013f126a53b332d4c2006d7416767954f7650bbddbd14a794679b87bd8b', 3, 'A', '2022-01-01', 'obscd@yopmail.com', NULL);

-- ----------------------------
-- Table structure for meta
-- ----------------------------
DROP TABLE IF EXISTS `meta`;
CREATE TABLE `meta`  (
  `id_meta` int NOT NULL AUTO_INCREMENT,
  `cod_meta` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cod_indicador_meta` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `gestion` int NULL DEFAULT NULL,
  `descr_meta` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `presupuesto_meta` double NULL DEFAULT NULL,
  `presupuesto_eje_meta` double NOT NULL,
  `ponderacion` double NULL DEFAULT NULL,
  `fecha_ini` date NULL DEFAULT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  `cumplimiento_meta` int NULL DEFAULT NULL,
  `respuesta_real_decumpl` int NULL DEFAULT NULL,
  `meta_estado` int NOT NULL DEFAULT 0,
  `meta_estd_sit` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descrp_img_meta` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_img_meta` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_meta`) USING BTREE,
  UNIQUE INDEX `cod_meta_UNIQUE`(`cod_meta`) USING BTREE,
  INDEX `fk_meta_indicador1_idx`(`cod_indicador_meta`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 326 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of meta
-- ----------------------------
INSERT INTO `meta` VALUES (1, '20220815091453', '20220815091244', 2021, 'Número de operativos de interdicción al narcotráfico ejecutados', NULL, 0, 100, '0000-00-00', '0000-00-00', 10000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (2, '20220815091454', '20220815091244', 2022, 'Número de operativos de interdicción al narcotráfico ejecutados', NULL, 0, 100, '0000-00-00', '0000-00-00', 10000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (3, '20220815091455', '20220815091244', 2023, 'Número de operativos de interdicción al narcotráfico ejecutados', NULL, 0, 100, '0000-00-00', '0000-00-00', 9000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (4, '20220815091456', '20220815091244', 2024, 'Número de operativos de interdicción al narcotráfico ejecutados', NULL, 0, 100, '0000-00-00', '0000-00-00', 9000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (5, '20220815091457', '20220815091244', 2025, 'Número de operativos de interdicción al narcotráfico ejecutados', NULL, 0, 100, '0000-00-00', '0000-00-00', 9000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (6, '20220815091712', '20220815091244', 2021, 'Número de operaciones coordinadas y simultaneas efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (7, '20220815091713', '20220815091244', 2022, 'Número de operaciones coordinadas y simultaneas efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (8, '20220815091714', '20220815091244', 2023, 'Número de operaciones coordinadas y simultaneas efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (9, '20220815091715', '20220815091244', 2024, 'Número de operaciones coordinadas y simultaneas efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (10, '20220815091716', '20220815091244', 2025, 'Número de operaciones coordinadas y simultaneas efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (11, '20220815091731', '20220815091244', 2021, 'Número de organizaciones criminales desarticuladas', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (12, '20220815091732', '20220815091244', 2022, 'Número de organizaciones criminales desarticuladas', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (13, '20220815091733', '20220815091244', 2023, 'Número de organizaciones criminales desarticuladas', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (14, '20220815091734', '20220815091244', 2024, 'Número de organizaciones criminales desarticuladas', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (15, '20220815091735', '20220815091244', 2025, 'Número de organizaciones criminales desarticuladas', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (16, '20220815091755', '20220815091244', 2021, 'Número de efectivos capacitados especializados y entrenados', NULL, 0, 100, '0000-00-00', '0000-00-00', 410, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (17, '20220815091756', '20220815091244', 2022, 'Número de efectivos capacitados especializados y entrenados', NULL, 0, 100, '0000-00-00', '0000-00-00', 410, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (18, '20220815091757', '20220815091244', 2023, 'Número de efectivos capacitados especializados y entrenados', NULL, 0, 100, '0000-00-00', '0000-00-00', 410, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (19, '20220815091758', '20220815091244', 2024, 'Número de efectivos capacitados especializados y entrenados', NULL, 0, 100, '0000-00-00', '0000-00-00', 410, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (20, '20220815091759', '20220815091244', 2025, 'Número de efectivos capacitados especializados y entrenados', NULL, 0, 100, '0000-00-00', '0000-00-00', 410, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (21, '20220817103617', '20220815091244', 2021, 'Número de estudios técnicos científicos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (22, '20220817103618', '20220815091244', 2022, 'Número de estudios técnicos científicos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (23, '20220817103619', '20220815091244', 2023, 'Número de estudios técnicos científicos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (24, '20220817103620', '20220815091244', 2024, 'Número de estudios técnicos científicos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (25, '20220817103621', '20220815091244', 2025, 'Número de estudios técnicos científicos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (26, '20220817103656', '20220815091244', 2021, 'Número de proyectos y/o requerimientos de fortalecimiento institucional efectuados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (27, '20220817103657', '20220815091244', 2022, 'Número de proyectos y/o requerimientos de fortalecimiento institucional efectuados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (28, '20220817103658', '20220815091244', 2023, 'Número de proyectos y/o requerimientos de fortalecimiento institucional efectuados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (29, '20220817103659', '20220815091244', 2024, 'Número de proyectos y/o requerimientos de fortalecimiento institucional efectuados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (30, '20220817103660', '20220815091244', 2025, 'Número de proyectos y/o requerimientos de fortalecimiento institucional efectuados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (31, '20220817103727', '20220815091244', 2021, 'Número de instrumentos de investigación aplicados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (32, '20220817103728', '20220815091244', 2022, 'Número de instrumentos de investigación aplicados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (33, '20220817103729', '20220815091244', 2023, 'Número de instrumentos de investigación aplicados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (34, '20220817103730', '20220815091244', 2024, 'Número de instrumentos de investigación aplicados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (35, '20220817103731', '20220815091244', 2025, 'Número de instrumentos de investigación aplicados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (36, '20220817103933', '20220815091244', 2021, 'Número de procesos de fiscalización a empresas efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 20, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (37, '20220817103934', '20220815091244', 2022, 'Número de procesos de fiscalización a empresas efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 25, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (38, '20220817103935', '20220815091244', 2023, 'Número de procesos de fiscalización a empresas efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 30, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (39, '20220817103936', '20220815091244', 2024, 'Número de procesos de fiscalización a empresas efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 35, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (40, '20220817103937', '20220815091244', 2025, 'Número de procesos de fiscalización a empresas efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (41, '20220817104110', '20220815091244', 2021, 'Porcentaje de implementación de la plataforma tecnológica.', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (42, '20220817104111', '20220815091244', 2022, 'Porcentaje de implementación de la plataforma tecnológica.', NULL, 0, 100, '0000-00-00', '0000-00-00', 70, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (43, '20220817104112', '20220815091244', 2023, 'Porcentaje de implementación de la plataforma tecnológica.', NULL, 0, 100, '0000-00-00', '0000-00-00', 90, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (44, '20220817104113', '20220815091244', 2024, 'Porcentaje de implementación de la plataforma tecnológica.', NULL, 0, 100, '0000-00-00', '0000-00-00', 100, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (45, '20220817104114', '20220815091244', 2025, 'Porcentaje de implementación de la plataforma tecnológica.', NULL, 0, 100, '0000-00-00', '0000-00-00', 100, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (46, '20220817104131', '20220815091244', 2021, 'Número de convenios y/o acuerdos suscritos.', NULL, 0, 100, '0000-00-00', '0000-00-00', 3, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (47, '20220817104132', '20220815091244', 2022, 'Número de convenios y/o acuerdos suscritos.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (48, '20220817104133', '20220815091244', 2023, 'Número de convenios y/o acuerdos suscritos.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (49, '20220817104134', '20220815091244', 2024, 'Número de convenios y/o acuerdos suscritos.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (50, '20220817104135', '20220815091244', 2025, 'Número de convenios y/o acuerdos suscritos.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (51, '20220817104235', '20220815091244', 2021, 'Número de normas propuestas', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (52, '20220817104236', '20220815091244', 2022, 'Número de normas propuestas', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (53, '20220817104237', '20220815091244', 2023, 'Número de normas propuestas', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (54, '20220817104238', '20220815091244', 2024, 'Número de normas propuestas', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (55, '20220817104239', '20220815091244', 2025, 'Número de normas propuestas', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (56, '20220817104312', '20220815091244', 2021, 'Número de autorizaciones previas otorgadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 1200, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (57, '20220817104313', '20220815091244', 2022, 'Número de autorizaciones previas otorgadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 1220, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (58, '20220817104314', '20220815091244', 2023, 'Número de autorizaciones previas otorgadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 1230, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (59, '20220817104315', '20220815091244', 2024, 'Número de autorizaciones previas otorgadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 1240, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (60, '20220817104316', '20220815091244', 2025, 'Número de autorizaciones previas otorgadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 1250, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (61, '20220817104339', '20220815091244', 2021, 'Número de sucursales aperturados', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (62, '20220817104340', '20220815091244', 2022, 'Número de sucursales aperturados', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (63, '20220817104341', '20220815091244', 2023, 'Número de sucursales aperturados', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (64, '20220817104342', '20220815091244', 2024, 'Número de sucursales aperturados', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (65, '20220817104343', '20220815091244', 2025, 'Número de sucursales aperturados', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (66, '20220817104407', '20220815091244', 2021, 'Número de profesionales en inspección y fiscalización capacitados', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (67, '20220817104408', '20220815091244', 2022, 'Número de profesionales en inspección y fiscalización capacitados', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (68, '20220817104409', '20220815091244', 2023, 'Número de profesionales en inspección y fiscalización capacitados', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (69, '20220817104410', '20220815091244', 2024, 'Número de profesionales en inspección y fiscalización capacitados', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (70, '20220817104411', '20220815091244', 2025, 'Número de profesionales en inspección y fiscalización capacitados', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (71, '20220817104451', '20220815091244', 2021, 'Número de empresas que importan y/o fabrican medicamentos fiscalizados', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (72, '20220817104452', '20220815091244', 2022, 'Número de empresas que importan y/o fabrican medicamentos fiscalizados', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (73, '20220817104453', '20220815091244', 2023, 'Número de empresas que importan y/o fabrican medicamentos fiscalizados', NULL, 0, 100, '0000-00-00', '0000-00-00', 6, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (74, '20220817104454', '20220815091244', 2024, 'Número de empresas que importan y/o fabrican medicamentos fiscalizados', NULL, 0, 100, '0000-00-00', '0000-00-00', 8, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (75, '20220817104455', '20220815091244', 2025, 'Número de empresas que importan y/o fabrican medicamentos fiscalizados', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (76, '20220817104519', '20220815091244', 2021, 'Porcentaje de implementación del sistema', NULL, 0, 100, '0000-00-00', '0000-00-00', 20, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (77, '20220817104520', '20220815091244', 2022, 'Porcentaje de implementación del sistema', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (78, '20220817104521', '20220815091244', 2023, 'Porcentaje de implementación del sistema', NULL, 0, 100, '0000-00-00', '0000-00-00', 60, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (79, '20220817104522', '20220815091244', 2024, 'Porcentaje de implementación del sistema', NULL, 0, 100, '0000-00-00', '0000-00-00', 80, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (80, '20220817104523', '20220815091244', 2025, 'Porcentaje de implementación del sistema', NULL, 0, 100, '0000-00-00', '0000-00-00', 100, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (81, '20220817104557', '20220815091244', 2021, 'Número de informes de inteligencia financiera y patrimonial anuales elaborados y remitidas sobre delitos de ganancias ilícitas vinculadas al narcotráfico y delitos conexos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (82, '20220817104558', '20220815091244', 2022, 'Número de informes de inteligencia financiera y patrimonial anuales elaborados y remitidas sobre delitos de ganancias ilícitas vinculadas al narcotráfico y delitos conexos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (83, '20220817104559', '20220815091244', 2023, 'Número de informes de inteligencia financiera y patrimonial anuales elaborados y remitidas sobre delitos de ganancias ilícitas vinculadas al narcotráfico y delitos conexos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (84, '20220817104560', '20220815091244', 2024, 'Número de informes de inteligencia financiera y patrimonial anuales elaborados y remitidas sobre delitos de ganancias ilícitas vinculadas al narcotráfico y delitos conexos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (85, '20220817104561', '20220815091244', 2025, 'Número de informes de inteligencia financiera y patrimonial anuales elaborados y remitidas sobre delitos de ganancias ilícitas vinculadas al narcotráfico y delitos conexos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (86, '20220817105034', '20220815091244', 2021, 'Número de convenios suscritos entre las entidades del CPI y la UIF', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (87, '20220817105035', '20220815091244', 2022, 'Número de convenios suscritos entre las entidades del CPI y la UIF', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (88, '20220817105036', '20220815091244', 2023, 'Número de convenios suscritos entre las entidades del CPI y la UIF', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (89, '20220817105037', '20220815091244', 2024, 'Número de convenios suscritos entre las entidades del CPI y la UIF', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (90, '20220817105038', '20220815091244', 2025, 'Número de convenios suscritos entre las entidades del CPI y la UIF', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (91, '20220817105101', '20220815091244', 2021, 'Número de normativa elaborada', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (92, '20220817105102', '20220815091244', 2022, 'Número de normativa elaborada', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (93, '20220817105103', '20220815091244', 2023, 'Número de normativa elaborada', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (94, '20220817105104', '20220815091244', 2024, 'Número de normativa elaborada', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (95, '20220817105105', '20220815091244', 2025, 'Número de normativa elaborada', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (96, '20220817105208', '20220815091244', 2021, 'Número de investigaciones e inteligencia policial de casos de legitimación de ganancias ilícitas efectuadas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 36, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (97, '20220817105209', '20220815091244', 2022, 'Número de investigaciones e inteligencia policial de casos de legitimación de ganancias ilícitas efectuadas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 36, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (98, '20220817105210', '20220815091244', 2023, 'Número de investigaciones e inteligencia policial de casos de legitimación de ganancias ilícitas efectuadas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 36, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (99, '20220817105211', '20220815091244', 2024, 'Número de investigaciones e inteligencia policial de casos de legitimación de ganancias ilícitas efectuadas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 36, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (100, '20220817105212', '20220815091244', 2025, 'Número de investigaciones e inteligencia policial de casos de legitimación de ganancias ilícitas efectuadas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 36, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (101, '20220817105233', '20220815091244', 2021, 'Número de informes conclusivos en etapa pre-procesal, efectuados', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (102, '20220817105234', '20220815091244', 2022, 'Número de informes conclusivos en etapa pre-procesal, efectuados', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (103, '20220817105235', '20220815091244', 2023, 'Número de informes conclusivos en etapa pre-procesal, efectuados', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (104, '20220817105236', '20220815091244', 2024, 'Número de informes conclusivos en etapa pre-procesal, efectuados', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (105, '20220817105237', '20220815091244', 2025, 'Número de informes conclusivos en etapa pre-procesal, efectuados', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (106, '20220817105340', '20220815091244', 2021, 'Número de bienes saneados administrativo', NULL, 0, 100, '0000-00-00', '0000-00-00', 150, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (107, '20220817105341', '20220815091244', 2022, 'Número de bienes saneados administrativo', NULL, 0, 100, '0000-00-00', '0000-00-00', 158, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (108, '20220817105342', '20220815091244', 2023, 'Número de bienes saneados administrativo', NULL, 0, 100, '0000-00-00', '0000-00-00', 165, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (109, '20220817105343', '20220815091244', 2024, 'Número de bienes saneados administrativo', NULL, 0, 100, '0000-00-00', '0000-00-00', 174, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (110, '20220817105344', '20220815091244', 2025, 'Número de bienes saneados administrativo', NULL, 0, 100, '0000-00-00', '0000-00-00', 182, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (111, '20220817105438', '20220815091244', 2021, 'Cantidad de ingresos por concepto de monetización en bolivianos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1800000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (112, '20220817105439', '20220815091244', 2022, 'Cantidad de ingresos por concepto de monetización en bolivianos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1864500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (113, '20220817105440', '20220815091244', 2023, 'Cantidad de ingresos por concepto de monetización en bolivianos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1931318, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (114, '20220817105441', '20220815091244', 2024, 'Cantidad de ingresos por concepto de monetización en bolivianos', NULL, 0, 100, '0000-00-00', '0000-00-00', 2000536, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (115, '20220817105442', '20220815091244', 2025, 'Cantidad de ingresos por concepto de monetización en bolivianos', NULL, 0, 100, '0000-00-00', '0000-00-00', 2072243, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (116, '20220817105517', '20220815091244', 2021, 'Número de casos de bienes saneados legal', NULL, 0, 100, '0000-00-00', '0000-00-00', 35, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (117, '20220817105518', '20220815091244', 2022, 'Número de casos de bienes saneados legal', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (118, '20220817105519', '20220815091244', 2023, 'Número de casos de bienes saneados legal', NULL, 0, 100, '0000-00-00', '0000-00-00', 45, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (119, '20220817105520', '20220815091244', 2024, 'Número de casos de bienes saneados legal', NULL, 0, 100, '0000-00-00', '0000-00-00', 50, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (120, '20220817105521', '20220815091244', 2025, 'Número de casos de bienes saneados legal', NULL, 0, 100, '0000-00-00', '0000-00-00', 55, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (121, '20220817105548', '20220815091244', 2021, 'Número de casos de perdida de dominio', NULL, 0, 100, '0000-00-00', '0000-00-00', 35, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (122, '20220817105549', '20220815091244', 2022, 'Número de casos de perdida de dominio', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (123, '20220817105550', '20220815091244', 2023, 'Número de casos de perdida de dominio', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (124, '20220817105551', '20220815091244', 2024, 'Número de casos de perdida de dominio', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (125, '20220817105552', '20220815091244', 2025, 'Número de casos de perdida de dominio', NULL, 0, 100, '0000-00-00', '0000-00-00', 45, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (126, '20220817105617', '20220815091244', 2021, 'Número de manuales aprobados para su aplicación', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (127, '20220817105618', '20220815091244', 2022, 'Número de manuales aprobados para su aplicación', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (128, '20220817105619', '20220815091244', 2023, 'Número de manuales aprobados para su aplicación', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (129, '20220817105620', '20220815091244', 2024, 'Número de manuales aprobados para su aplicación', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (130, '20220817105621', '20220815091244', 2025, 'Número de manuales aprobados para su aplicación', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (131, '20220817105644', '20220815091244', 2021, 'Porcentaje de avance en el desarrollo del sistema', NULL, 0, 100, '0000-00-00', '0000-00-00', 30, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (132, '20220817105645', '20220815091244', 2022, 'Porcentaje de avance en el desarrollo del sistema', NULL, 0, 100, '0000-00-00', '0000-00-00', 60, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (133, '20220817105646', '20220815091244', 2023, 'Porcentaje de avance en el desarrollo del sistema', NULL, 0, 100, '0000-00-00', '0000-00-00', 90, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (134, '20220817105647', '20220815091244', 2024, 'Porcentaje de avance en el desarrollo del sistema', NULL, 0, 100, '0000-00-00', '0000-00-00', 100, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (135, '20220817105648', '20220815091244', 2025, 'Porcentaje de avance en el desarrollo del sistema', NULL, 0, 100, '0000-00-00', '0000-00-00', 100, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (136, '20220817110226', '20220815091257', 2021, 'Hectáreas de superficie racionalizada de cultivos excedentarios', NULL, 0, 100, '0000-00-00', '0000-00-00', 6500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (137, '20220817110227', '20220815091257', 2022, 'Hectáreas de superficie racionalizada de cultivos excedentarios', NULL, 0, 100, '0000-00-00', '0000-00-00', 7000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (138, '20220817110228', '20220815091257', 2023, 'Hectáreas de superficie racionalizada de cultivos excedentarios', NULL, 0, 100, '0000-00-00', '0000-00-00', 7000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (139, '20220817110229', '20220815091257', 2024, 'Hectáreas de superficie racionalizada de cultivos excedentarios', NULL, 0, 100, '0000-00-00', '0000-00-00', 7000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (140, '20220817110230', '20220815091257', 2025, 'Hectáreas de superficie racionalizada de cultivos excedentarios', NULL, 0, 100, '0000-00-00', '0000-00-00', 7000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (141, '20220817110355', '20220815091257', 2021, 'Hectáreas de superficie erradicada de cultivos excedentarios', NULL, 0, 100, '0000-00-00', '0000-00-00', 2500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (142, '20220817110356', '20220815091257', 2022, 'Hectáreas de superficie erradicada de cultivos excedentarios', NULL, 0, 100, '0000-00-00', '0000-00-00', 3000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (143, '20220817110357', '20220815091257', 2023, 'Hectáreas de superficie erradicada de cultivos excedentarios', NULL, 0, 100, '0000-00-00', '0000-00-00', 3000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (144, '20220817110358', '20220815091257', 2024, 'Hectáreas de superficie erradicada de cultivos excedentarios', NULL, 0, 100, '0000-00-00', '0000-00-00', 3000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (145, '20220817110359', '20220815091257', 2025, 'Hectáreas de superficie erradicada de cultivos excedentarios', NULL, 0, 100, '0000-00-00', '0000-00-00', 3000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (146, '20220817110518', '20220815091257', 2021, 'Número de Informes de Monitoreo UNODC', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (147, '20220817110519', '20220815091257', 2022, 'Número de Informes de Monitoreo UNODC', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (148, '20220817110520', '20220815091257', 2023, 'Número de Informes de Monitoreo UNODC', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (149, '20220817110521', '20220815091257', 2024, 'Número de Informes de Monitoreo UNODC', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (150, '20220817110522', '20220815091257', 2025, 'Número de Informes de Monitoreo UNODC', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (151, '20220817110956', '20220815091257', 2021, 'Número de operaciones de control territorial', NULL, 0, 100, '0000-00-00', '0000-00-00', 5000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (152, '20220817110957', '20220815091257', 2022, 'Número de operaciones de control territorial', NULL, 0, 100, '0000-00-00', '0000-00-00', 5000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (153, '20220817110958', '20220815091257', 2023, 'Número de operaciones de control territorial', NULL, 0, 100, '0000-00-00', '0000-00-00', 5000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (154, '20220817110959', '20220815091257', 2024, 'Número de operaciones de control territorial', NULL, 0, 100, '0000-00-00', '0000-00-00', 5000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (155, '20220817110960', '20220815091257', 2025, 'Número de operaciones de control territorial', NULL, 0, 100, '0000-00-00', '0000-00-00', 5000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (156, '20220817111049', '20220815091257', 2021, 'Número de reglamentos implementados', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (157, '20220817111050', '20220815091257', 2022, 'Número de reglamentos implementados', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (158, '20220817111051', '20220815091257', 2023, 'Número de reglamentos implementados', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (159, '20220817111052', '20220815091257', 2024, 'Número de reglamentos implementados', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (160, '20220817111053', '20220815091257', 2025, 'Número de reglamentos implementados', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (161, '20220817111920', '20220815091257', 2021, 'Número de reportes con identificación de sindicatos que aplican el control social.', NULL, 0, 100, '0000-00-00', '0000-00-00', 120, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (162, '20220817111921', '20220815091257', 2022, 'Número de reportes con identificación de sindicatos que aplican el control social.', NULL, 0, 100, '0000-00-00', '0000-00-00', 120, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (163, '20220817111922', '20220815091257', 2023, 'Número de reportes con identificación de sindicatos que aplican el control social.', NULL, 0, 100, '0000-00-00', '0000-00-00', 120, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (164, '20220817111923', '20220815091257', 2024, 'Número de reportes con identificación de sindicatos que aplican el control social.', NULL, 0, 100, '0000-00-00', '0000-00-00', 120, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (165, '20220817111924', '20220815091257', 2025, 'Número de reportes con identificación de sindicatos que aplican el control social.', NULL, 0, 100, '0000-00-00', '0000-00-00', 120, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (166, '20220817113004', '20220815091257', 2021, 'Número de zonas autorizadas delimitadas geográficamente', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (167, '20220817113005', '20220815091257', 2022, 'Número de zonas autorizadas delimitadas geográficamente', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (168, '20220817113006', '20220815091257', 2023, 'Número de zonas autorizadas delimitadas geográficamente', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (169, '20220817113007', '20220815091257', 2024, 'Número de zonas autorizadas delimitadas geográficamente', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (170, '20220817113008', '20220815091257', 2025, 'Número de zonas autorizadas delimitadas geográficamente', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (171, '20220817113201', '20220815091257', 2021, 'Número de sistema, actualizado', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (172, '20220817113202', '20220815091257', 2022, 'Número de sistema, actualizado', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (173, '20220817113203', '20220815091257', 2023, 'Número de sistema, actualizado', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (174, '20220817113204', '20220815091257', 2024, 'Número de sistema, actualizado', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (175, '20220817113205', '20220815091257', 2025, 'Número de sistema, actualizado', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (176, '20220817113313', '20220815091257', 2021, 'Número de reuniones de coordinación interinstitucional, efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 4, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (177, '20220817113314', '20220815091257', 2022, 'Número de reuniones de coordinación interinstitucional, efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 4, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (178, '20220817113315', '20220815091257', 2023, 'Número de reuniones de coordinación interinstitucional, efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 4, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (179, '20220817113316', '20220815091257', 2024, 'Número de reuniones de coordinación interinstitucional, efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 4, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (180, '20220817113317', '20220815091257', 2025, 'Número de reuniones de coordinación interinstitucional, efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 4, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (181, '20220817113732', '20220815091257', 2021, 'Número de proyectos o acciones productivas, obras civiles, equipamiento y medio ambiente, efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (182, '20220817113733', '20220815091257', 2022, 'Número de proyectos o acciones productivas, obras civiles, equipamiento y medio ambiente, efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (183, '20220817113734', '20220815091257', 2023, 'Número de proyectos o acciones productivas, obras civiles, equipamiento y medio ambiente, efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (184, '20220817113735', '20220815091257', 2024, 'Número de proyectos o acciones productivas, obras civiles, equipamiento y medio ambiente, efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (185, '20220817113736', '20220815091257', 2025, 'Número de proyectos o acciones productivas, obras civiles, equipamiento y medio ambiente, efectuadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (186, '20220817114000', '20220815091308', 2021, 'Número de reglamento de funcionamiento de la Red', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (187, '20220817114001', '20220815091308', 2022, 'Número de reglamento de funcionamiento de la Red', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (188, '20220817114002', '20220815091308', 2023, 'Número de reglamento de funcionamiento de la Red', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (189, '20220817114003', '20220815091308', 2024, 'Número de reglamento de funcionamiento de la Red', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (190, '20220817114004', '20220815091308', 2025, 'Número de reglamento de funcionamiento de la Red', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (191, '20220817114656', '20220815091308', 2021, 'Número de plan elaborado y aprobado.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (192, '20220817114657', '20220815091308', 2022, 'Número de plan elaborado y aprobado.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (193, '20220817114658', '20220815091308', 2023, 'Número de plan elaborado y aprobado.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (194, '20220817114659', '20220815091308', 2024, 'Número de plan elaborado y aprobado.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (195, '20220817114660', '20220815091308', 2025, 'Número de plan elaborado y aprobado.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (196, '20220817114910', '20220815091308', 2021, 'Número de promoción de estilos de vida saludable en ciudades capitales, ámbito de la salud', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (197, '20220817114911', '20220815091308', 2022, 'Número de promoción de estilos de vida saludable en ciudades capitales, ámbito de la salud', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (198, '20220817114912', '20220815091308', 2023, 'Número de promoción de estilos de vida saludable en ciudades capitales, ámbito de la salud', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (199, '20220817114913', '20220815091308', 2024, 'Número de promoción de estilos de vida saludable en ciudades capitales, ámbito de la salud', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (200, '20220817114914', '20220815091308', 2025, 'Número de promoción de estilos de vida saludable en ciudades capitales, ámbito de la salud', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (201, '20220817115000', '20220815091308', 2021, 'Número de unidades educativas sensibilizadas sobre la prevención de consumo de drogas, ámbito educativo', NULL, 0, 100, '0000-00-00', '0000-00-00', 50, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (202, '20220817115001', '20220815091308', 2022, 'Número de unidades educativas sensibilizadas sobre la prevención de consumo de drogas, ámbito educativo', NULL, 0, 100, '0000-00-00', '0000-00-00', 50, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (203, '20220817115002', '20220815091308', 2023, 'Número de unidades educativas sensibilizadas sobre la prevención de consumo de drogas, ámbito educativo', NULL, 0, 100, '0000-00-00', '0000-00-00', 50, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (204, '20220817115003', '20220815091308', 2024, 'Número de unidades educativas sensibilizadas sobre la prevención de consumo de drogas, ámbito educativo', NULL, 0, 100, '0000-00-00', '0000-00-00', 50, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (205, '20220817115004', '20220815091308', 2025, 'Número de unidades educativas sensibilizadas sobre la prevención de consumo de drogas, ámbito educativo', NULL, 0, 100, '0000-00-00', '0000-00-00', 50, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (206, '20220817115040', '20220815091308', 2021, 'Número de promoción de estilos de vida saludable en Gobiernos Autónomos Municipales, ámbito familiar y comunitario', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (207, '20220817115041', '20220815091308', 2022, 'Número de promoción de estilos de vida saludable en Gobiernos Autónomos Municipales, ámbito familiar y comunitario', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (208, '20220817115042', '20220815091308', 2023, 'Número de promoción de estilos de vida saludable en Gobiernos Autónomos Municipales, ámbito familiar y comunitario', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (209, '20220817115043', '20220815091308', 2024, 'Número de promoción de estilos de vida saludable en Gobiernos Autónomos Municipales, ámbito familiar y comunitario', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (210, '20220817115044', '20220815091308', 2025, 'Número de promoción de estilos de vida saludable en Gobiernos Autónomos Municipales, ámbito familiar y comunitario', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (211, '20220817115225', '20220815091308', 2021, 'Número de estudiantes prevenidos en consumo de drogas', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (212, '20220817115226', '20220815091308', 2022, 'Número de estudiantes prevenidos en consumo de drogas', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (213, '20220817115227', '20220815091308', 2023, 'Número de estudiantes prevenidos en consumo de drogas', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (214, '20220817115228', '20220815091308', 2024, 'Número de estudiantes prevenidos en consumo de drogas', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (215, '20220817115229', '20220815091308', 2025, 'Número de estudiantes prevenidos en consumo de drogas', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (216, '20220817115252', '20220815091308', 2021, 'Número de movilizaciones estudiantiles de prevención del consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (217, '20220817115253', '20220815091308', 2022, 'Número de movilizaciones estudiantiles de prevención del consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (218, '20220817115254', '20220815091308', 2023, 'Número de movilizaciones estudiantiles de prevención del consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (219, '20220817115255', '20220815091308', 2024, 'Número de movilizaciones estudiantiles de prevención del consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (220, '20220817115256', '20220815091308', 2025, 'Número de movilizaciones estudiantiles de prevención del consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (221, '20220817115325', '20220815091308', 2021, 'Número de promoción de estilos de vida saludable en ciudades capitales, ámbito de la seguridad ciudadana.', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (222, '20220817115326', '20220815091308', 2022, 'Número de promoción de estilos de vida saludable en ciudades capitales, ámbito de la seguridad ciudadana.', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (223, '20220817115327', '20220815091308', 2023, 'Número de promoción de estilos de vida saludable en ciudades capitales, ámbito de la seguridad ciudadana.', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (224, '20220817115328', '20220815091308', 2024, 'Número de promoción de estilos de vida saludable en ciudades capitales, ámbito de la seguridad ciudadana.', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (225, '20220817115329', '20220815091308', 2025, 'Número de promoción de estilos de vida saludable en ciudades capitales, ámbito de la seguridad ciudadana.', NULL, 0, 100, '0000-00-00', '0000-00-00', 5, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (226, '20220818121107', '20220815091308', 2021, 'Número de estudios elaborados', NULL, 0, 100, '0000-00-00', '0000-00-00', 3, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (227, '20220818121108', '20220815091308', 2022, 'Número de estudios elaborados', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (228, '20220818121109', '20220815091308', 2023, 'Número de estudios elaborados', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (229, '20220818121110', '20220815091308', 2024, 'Número de estudios elaborados', NULL, 0, 100, '0000-00-00', '0000-00-00', 3, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (230, '20220818121111', '20220815091308', 2025, 'Número de estudios elaborados', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (231, '20220818121343', '20220815091308', 2021, 'Número de maestras y maestros de Unidades Educativas del nivel secundario sensibilizados sobre prevención consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (232, '20220818121344', '20220815091308', 2022, 'Número de maestras y maestros de Unidades Educativas del nivel secundario sensibilizados sobre prevención consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (233, '20220818121345', '20220815091308', 2023, 'Número de maestras y maestros de Unidades Educativas del nivel secundario sensibilizados sobre prevención consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (234, '20220818121346', '20220815091308', 2024, 'Número de maestras y maestros de Unidades Educativas del nivel secundario sensibilizados sobre prevención consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (235, '20220818121347', '20220815091308', 2025, 'Número de maestras y maestros de Unidades Educativas del nivel secundario sensibilizados sobre prevención consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (236, '20220818121413', '20220815091308', 2021, 'Número de padres y madres sensibilizados sobre prevención del consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (237, '20220818121414', '20220815091308', 2022, 'Número de padres y madres sensibilizados sobre prevención del consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (238, '20220818121415', '20220815091308', 2023, 'Número de padres y madres sensibilizados sobre prevención del consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (239, '20220818121416', '20220815091308', 2024, 'Número de padres y madres sensibilizados sobre prevención del consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (240, '20220818121417', '20220815091308', 2025, 'Número de padres y madres sensibilizados sobre prevención del consumo de drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 500, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (241, '20220818121444', '20220815091308', 2021, 'Número de Directores de Unidades Educativas sensibilizados para la aplicación del Protocolo de Prevención y Actuación ante la Presencia, Tenencia, Consumo y Microtráfico de Drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (242, '20220818121445', '20220815091308', 2022, 'Número de Directores de Unidades Educativas sensibilizados para la aplicación del Protocolo de Prevención y Actuación ante la Presencia, Tenencia, Consumo y Microtráfico de Drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (243, '20220818121446', '20220815091308', 2023, 'Número de Directores de Unidades Educativas sensibilizados para la aplicación del Protocolo de Prevención y Actuación ante la Presencia, Tenencia, Consumo y Microtráfico de Drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (244, '20220818121447', '20220815091308', 2024, 'Número de Directores de Unidades Educativas sensibilizados para la aplicación del Protocolo de Prevención y Actuación ante la Presencia, Tenencia, Consumo y Microtráfico de Drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (245, '20220818121448', '20220815091308', 2025, 'Número de Directores de Unidades Educativas sensibilizados para la aplicación del Protocolo de Prevención y Actuación ante la Presencia, Tenencia, Consumo y Microtráfico de Drogas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1000, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (246, '20220818121515', '20220815091308', 2021, 'Número de personas sensibilizadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 200, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (247, '20220818121516', '20220815091308', 2022, 'Número de personas sensibilizadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 200, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (248, '20220818121517', '20220815091308', 2023, 'Número de personas sensibilizadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 200, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (249, '20220818121518', '20220815091308', 2024, 'Número de personas sensibilizadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 200, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (250, '20220818121519', '20220815091308', 2025, 'Número de personas sensibilizadas', NULL, 0, 100, '0000-00-00', '0000-00-00', 200, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (251, '20220818121549', '20220815091308', 2021, 'Número de Gobiernos Autónomos Municipales cuentan con asistencia técnica.', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (252, '20220818121550', '20220815091308', 2022, 'Número de Gobiernos Autónomos Municipales cuentan con asistencia técnica.', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (253, '20220818121551', '20220815091308', 2023, 'Número de Gobiernos Autónomos Municipales cuentan con asistencia técnica.', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (254, '20220818121552', '20220815091308', 2024, 'Número de Gobiernos Autónomos Municipales cuentan con asistencia técnica.', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (255, '20220818121553', '20220815091308', 2025, 'Número de Gobiernos Autónomos Municipales cuentan con asistencia técnica.', NULL, 0, 100, '0000-00-00', '0000-00-00', 10, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (256, '20220818121728', '20220815091308', 2021, 'Número de cursos de formación', NULL, 0, 100, '0000-00-00', '0000-00-00', 3, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (257, '20220818121729', '20220815091308', 2022, 'Número de cursos de formación', NULL, 0, 100, '0000-00-00', '0000-00-00', 3, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (258, '20220818121730', '20220815091308', 2023, 'Número de cursos de formación', NULL, 0, 100, '0000-00-00', '0000-00-00', 3, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (259, '20220818121731', '20220815091308', 2024, 'Número de cursos de formación', NULL, 0, 100, '0000-00-00', '0000-00-00', 3, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (260, '20220818121732', '20220815091308', 2025, 'Número de cursos de formación', NULL, 0, 100, '0000-00-00', '0000-00-00', 3, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (261, '20220818121944', '20220815091308', 2021, 'Número de talleres efectuados', NULL, 0, 100, '0000-00-00', '0000-00-00', 3, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (262, '20220818121945', '20220815091308', 2022, 'Número de talleres efectuados', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (263, '20220818121946', '20220815091308', 2023, 'Número de talleres efectuados', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (264, '20220818121947', '20220815091308', 2024, 'Número de talleres efectuados', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (265, '20220818121948', '20220815091308', 2025, 'Número de talleres efectuados', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (266, '20220818122034', '20220815091308', 2021, 'Número de protocolos elaborados e implementados', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (267, '20220818122035', '20220815091308', 2022, 'Número de protocolos elaborados e implementados', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (268, '20220818122036', '20220815091308', 2023, 'Número de protocolos elaborados e implementados', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (269, '20220818122037', '20220815091308', 2024, 'Número de protocolos elaborados e implementados', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (270, '20220818122038', '20220815091308', 2025, 'Número de protocolos elaborados e implementados', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (271, '20220818122056', '20220815091308', 2021, 'Número de normas elaboradas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (272, '20220818122057', '20220815091308', 2022, 'Número de normas elaboradas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (273, '20220818122058', '20220815091308', 2023, 'Número de normas elaboradas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (274, '20220818122059', '20220815091308', 2024, 'Número de normas elaboradas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (275, '20220818122060', '20220815091308', 2025, 'Número de normas elaboradas.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (276, '20220818122122', '20220815091308', 2021, 'Número de Centros Implementados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (277, '20220818122123', '20220815091308', 2022, 'Número de Centros Implementados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 3, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (278, '20220818122124', '20220815091308', 2023, 'Número de Centros Implementados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (279, '20220818122125', '20220815091308', 2024, 'Número de Centros Implementados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 3, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (280, '20220818122126', '20220815091308', 2025, 'Número de Centros Implementados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (281, '20220818122240', '20220815091308', 2021, 'Número de áreas implementados y fortalecidos, Centros Penitenciarios.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (282, '20220818122241', '20220815091308', 2022, 'Número de áreas implementados y fortalecidos, Centros Penitenciarios.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (283, '20220818122242', '20220815091308', 2023, 'Número de áreas implementados y fortalecidos, Centros Penitenciarios.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (284, '20220818122243', '20220815091308', 2024, 'Número de áreas implementados y fortalecidos, Centros Penitenciarios.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (285, '20220818122244', '20220815091308', 2025, 'Número de áreas implementados y fortalecidos, Centros Penitenciarios.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (286, '20220818122311', '20220815091308', 2021, 'Número de estudio elaborado y socializado.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (287, '20220818122312', '20220815091308', 2022, 'Número de estudio elaborado y socializado.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (288, '20220818122313', '20220815091308', 2023, 'Número de estudio elaborado y socializado.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (289, '20220818122314', '20220815091308', 2024, 'Número de estudio elaborado y socializado.', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (290, '20220818122315', '20220815091308', 2025, 'Número de estudio elaborado y socializado.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (291, '20220818123014', '20220815091320', 2021, 'Número de acuerdos suscritos con países,', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (292, '20220818123015', '20220815091320', 2022, 'Número de acuerdos suscritos con países,', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (293, '20220818123016', '20220815091320', 2023, 'Número de acuerdos suscritos con países,', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (294, '20220818123017', '20220815091320', 2024, 'Número de acuerdos suscritos con países,', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (295, '20220818123018', '20220815091320', 2025, 'Número de acuerdos suscritos con países,', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (296, '20220818123132', '20220815091320', 2021, 'Número de acuerdos suscritos con países estratégicos', NULL, 0, 100, '0000-00-00', '0000-00-00', 0, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (297, '20220818123133', '20220815091320', 2022, 'Número de acuerdos suscritos con países estratégicos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (298, '20220818123134', '20220815091320', 2023, 'Número de acuerdos suscritos con países estratégicos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (299, '20220818123135', '20220815091320', 2024, 'Número de acuerdos suscritos con países estratégicos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (300, '20220818123136', '20220815091320', 2025, 'Número de acuerdos suscritos con países estratégicos', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (301, '20220818123312', '20220815091320', 2021, 'Número de informes anuales presentados, sobre servidores públicos y policiales actualizados, capacitados y especializados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (302, '20220818123313', '20220815091320', 2022, 'Número de informes anuales presentados, sobre servidores públicos y policiales actualizados, capacitados y especializados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (303, '20220818123314', '20220815091320', 2023, 'Número de informes anuales presentados, sobre servidores públicos y policiales actualizados, capacitados y especializados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (304, '20220818123315', '20220815091320', 2024, 'Número de informes anuales presentados, sobre servidores públicos y policiales actualizados, capacitados y especializados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (305, '20220818123316', '20220815091320', 2025, 'Número de informes anuales presentados, sobre servidores públicos y policiales actualizados, capacitados y especializados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (306, '20220818123455', '20220815091320', 2021, 'Porcentaje de consolidación y fortalecimiento del CERIAN', NULL, 0, 100, '0000-00-00', '0000-00-00', 20, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (307, '20220818123456', '20220815091320', 2022, 'Porcentaje de consolidación y fortalecimiento del CERIAN', NULL, 0, 100, '0000-00-00', '0000-00-00', 30, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (308, '20220818123457', '20220815091320', 2023, 'Porcentaje de consolidación y fortalecimiento del CERIAN', NULL, 0, 100, '0000-00-00', '0000-00-00', 40, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (309, '20220818123458', '20220815091320', 2024, 'Porcentaje de consolidación y fortalecimiento del CERIAN', NULL, 0, 100, '0000-00-00', '0000-00-00', 50, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (310, '20220818123459', '20220815091320', 2025, 'Porcentaje de consolidación y fortalecimiento del CERIAN', NULL, 0, 100, '0000-00-00', '0000-00-00', 100, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (311, '20220818123722', '20220815091320', 2021, 'Número de Informes anual presentados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (312, '20220818123723', '20220815091320', 2022, 'Número de Informes anual presentados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (313, '20220818123724', '20220815091320', 2023, 'Número de Informes anual presentados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (314, '20220818123725', '20220815091320', 2024, 'Número de Informes anual presentados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (315, '20220818123726', '20220815091320', 2025, 'Número de Informes anual presentados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (316, '20220818123934', '20220815091320', 2021, 'Número de informes anuales presentados, sobre servidores públicos y policiales actualizados, capacitados y especializados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (317, '20220818123935', '20220815091320', 2022, 'Número de informes anuales presentados, sobre servidores públicos y policiales actualizados, capacitados y especializados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (318, '20220818123936', '20220815091320', 2023, 'Número de informes anuales presentados, sobre servidores públicos y policiales actualizados, capacitados y especializados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (319, '20220818123937', '20220815091320', 2024, 'Número de informes anuales presentados, sobre servidores públicos y policiales actualizados, capacitados y especializados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (320, '20220818123938', '20220815091320', 2025, 'Número de informes anuales presentados, sobre servidores públicos y policiales actualizados, capacitados y especializados.', NULL, 0, 100, '0000-00-00', '0000-00-00', 1, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (321, '20220818124055', '20220815091320', 2021, 'Número de reuniones y/o eventos asistidos.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (322, '20220818124056', '20220815091320', 2022, 'Número de reuniones y/o eventos asistidos.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (323, '20220818124057', '20220815091320', 2023, 'Número de reuniones y/o eventos asistidos.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (324, '20220818124058', '20220815091320', 2024, 'Número de reuniones y/o eventos asistidos.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');
INSERT INTO `meta` VALUES (325, '20220818124059', '20220815091320', 2025, 'Número de reuniones y/o eventos asistidos.', NULL, 0, 100, '0000-00-00', '0000-00-00', 2, 0, 1, '', '', '');

-- ----------------------------
-- Table structure for meta_usaurios
-- ----------------------------
DROP TABLE IF EXISTS `meta_usaurios`;
CREATE TABLE `meta_usaurios`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `meta_login` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cod_meta_mtus` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 574 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of meta_usaurios
-- ----------------------------
INSERT INTO `meta_usaurios` VALUES (1, 'DGFELCN', '20220812110643');
INSERT INTO `meta_usaurios` VALUES (2, 'DGFELCN', '20220812110644');
INSERT INTO `meta_usaurios` VALUES (3, 'DGFELCN', '20220812110645');
INSERT INTO `meta_usaurios` VALUES (4, 'DGFELCN', '20220812110646');
INSERT INTO `meta_usaurios` VALUES (5, 'DGFELCN', '20220812110647');
INSERT INTO `meta_usaurios` VALUES (6, 'DGFELCN', '20220815090956');
INSERT INTO `meta_usaurios` VALUES (7, 'DGFELCN', '20220815090957');
INSERT INTO `meta_usaurios` VALUES (8, 'DGFELCN', '20220815090958');
INSERT INTO `meta_usaurios` VALUES (9, 'DGFELCN', '20220815090959');
INSERT INTO `meta_usaurios` VALUES (10, 'DGFELCN', '20220815090960');
INSERT INTO `meta_usaurios` VALUES (11, 'DGFELCN', '20220815091453');
INSERT INTO `meta_usaurios` VALUES (12, 'DGFELCN', '20220815091454');
INSERT INTO `meta_usaurios` VALUES (13, 'DGFELCN', '20220815091455');
INSERT INTO `meta_usaurios` VALUES (14, 'DGFELCN', '20220815091456');
INSERT INTO `meta_usaurios` VALUES (15, 'DGFELCN', '20220815091457');
INSERT INTO `meta_usaurios` VALUES (16, 'DGFELCN', '20220815091712');
INSERT INTO `meta_usaurios` VALUES (17, 'DGFELCN', '20220815091713');
INSERT INTO `meta_usaurios` VALUES (18, 'DGFELCN', '20220815091714');
INSERT INTO `meta_usaurios` VALUES (19, 'DGFELCN', '20220815091715');
INSERT INTO `meta_usaurios` VALUES (20, 'DGFELCN', '20220815091716');
INSERT INTO `meta_usaurios` VALUES (21, 'DGFELCN', '20220815091731');
INSERT INTO `meta_usaurios` VALUES (22, 'DGFELCN', '20220815091732');
INSERT INTO `meta_usaurios` VALUES (23, 'DGFELCN', '20220815091733');
INSERT INTO `meta_usaurios` VALUES (24, 'DGFELCN', '20220815091734');
INSERT INTO `meta_usaurios` VALUES (25, 'DGFELCN', '20220815091735');
INSERT INTO `meta_usaurios` VALUES (26, 'DGFELCN', '20220815091755');
INSERT INTO `meta_usaurios` VALUES (27, 'DGFELCN', '20220815091756');
INSERT INTO `meta_usaurios` VALUES (28, 'DGFELCN', '20220815091757');
INSERT INTO `meta_usaurios` VALUES (29, 'DGFELCN', '20220815091758');
INSERT INTO `meta_usaurios` VALUES (30, 'DGFELCN', '20220815091759');
INSERT INTO `meta_usaurios` VALUES (31, 'DGFELCN', '20220817103617');
INSERT INTO `meta_usaurios` VALUES (32, 'DGFELCN', '20220817103618');
INSERT INTO `meta_usaurios` VALUES (33, 'DGFELCN', '20220817103619');
INSERT INTO `meta_usaurios` VALUES (34, 'DGFELCN', '20220817103620');
INSERT INTO `meta_usaurios` VALUES (35, 'DGFELCN', '20220817103621');
INSERT INTO `meta_usaurios` VALUES (36, 'DGFELCN', '20220817103656');
INSERT INTO `meta_usaurios` VALUES (37, 'DGFELCN', '20220817103657');
INSERT INTO `meta_usaurios` VALUES (38, 'DGFELCN', '20220817103658');
INSERT INTO `meta_usaurios` VALUES (39, 'DGFELCN', '20220817103659');
INSERT INTO `meta_usaurios` VALUES (40, 'DGFELCN', '20220817103660');
INSERT INTO `meta_usaurios` VALUES (41, 'DGFELCN', '20220817103727');
INSERT INTO `meta_usaurios` VALUES (42, 'DGFELCN', '20220817103728');
INSERT INTO `meta_usaurios` VALUES (43, 'DGFELCN', '20220817103729');
INSERT INTO `meta_usaurios` VALUES (44, 'DGFELCN', '20220817103730');
INSERT INTO `meta_usaurios` VALUES (45, 'DGFELCN', '20220817103731');
INSERT INTO `meta_usaurios` VALUES (46, 'DGSC', '20220817103933');
INSERT INTO `meta_usaurios` VALUES (47, 'DGSC', '20220817103934');
INSERT INTO `meta_usaurios` VALUES (48, 'DGSC', '20220817103935');
INSERT INTO `meta_usaurios` VALUES (49, 'DGSC', '20220817103936');
INSERT INTO `meta_usaurios` VALUES (50, 'DGSC', '20220817103937');
INSERT INTO `meta_usaurios` VALUES (51, 'DGSC', '20220817104110');
INSERT INTO `meta_usaurios` VALUES (52, 'DGSC', '20220817104111');
INSERT INTO `meta_usaurios` VALUES (53, 'DGSC', '20220817104112');
INSERT INTO `meta_usaurios` VALUES (54, 'DGSC', '20220817104113');
INSERT INTO `meta_usaurios` VALUES (55, 'DGSC', '20220817104114');
INSERT INTO `meta_usaurios` VALUES (56, 'DGSC', '20220817104131');
INSERT INTO `meta_usaurios` VALUES (57, 'DGSC', '20220817104132');
INSERT INTO `meta_usaurios` VALUES (58, 'DGSC', '20220817104133');
INSERT INTO `meta_usaurios` VALUES (59, 'DGSC', '20220817104134');
INSERT INTO `meta_usaurios` VALUES (60, 'DGSC', '20220817104135');
INSERT INTO `meta_usaurios` VALUES (61, 'DGSC', '20220817104235');
INSERT INTO `meta_usaurios` VALUES (62, 'DGSC', '20220817104236');
INSERT INTO `meta_usaurios` VALUES (63, 'DGSC', '20220817104237');
INSERT INTO `meta_usaurios` VALUES (64, 'DGSC', '20220817104238');
INSERT INTO `meta_usaurios` VALUES (65, 'DGSC', '20220817104239');
INSERT INTO `meta_usaurios` VALUES (66, 'DGSC', '20220817104312');
INSERT INTO `meta_usaurios` VALUES (67, 'DGSC', '20220817104313');
INSERT INTO `meta_usaurios` VALUES (68, 'DGSC', '20220817104314');
INSERT INTO `meta_usaurios` VALUES (69, 'DGSC', '20220817104315');
INSERT INTO `meta_usaurios` VALUES (70, 'DGSC', '20220817104316');
INSERT INTO `meta_usaurios` VALUES (71, 'AGEMED', '20220817104339');
INSERT INTO `meta_usaurios` VALUES (72, 'AGEMED', '20220817104340');
INSERT INTO `meta_usaurios` VALUES (73, 'AGEMED', '20220817104341');
INSERT INTO `meta_usaurios` VALUES (74, 'AGEMED', '20220817104342');
INSERT INTO `meta_usaurios` VALUES (75, 'AGEMED', '20220817104343');
INSERT INTO `meta_usaurios` VALUES (76, 'AGEMED', '20220817104407');
INSERT INTO `meta_usaurios` VALUES (77, 'AGEMED', '20220817104408');
INSERT INTO `meta_usaurios` VALUES (78, 'AGEMED', '20220817104409');
INSERT INTO `meta_usaurios` VALUES (79, 'AGEMED', '20220817104410');
INSERT INTO `meta_usaurios` VALUES (80, 'AGEMED', '20220817104411');
INSERT INTO `meta_usaurios` VALUES (81, 'AGEMED', '20220817104451');
INSERT INTO `meta_usaurios` VALUES (82, 'AGEMED', '20220817104452');
INSERT INTO `meta_usaurios` VALUES (83, 'AGEMED', '20220817104453');
INSERT INTO `meta_usaurios` VALUES (84, 'AGEMED', '20220817104454');
INSERT INTO `meta_usaurios` VALUES (85, 'AGEMED', '20220817104455');
INSERT INTO `meta_usaurios` VALUES (86, 'AGEMED', '20220817104519');
INSERT INTO `meta_usaurios` VALUES (87, 'AGEMED', '20220817104520');
INSERT INTO `meta_usaurios` VALUES (88, 'AGEMED', '20220817104521');
INSERT INTO `meta_usaurios` VALUES (89, 'AGEMED', '20220817104522');
INSERT INTO `meta_usaurios` VALUES (90, 'AGEMED', '20220817104523');
INSERT INTO `meta_usaurios` VALUES (91, 'UIF', '20220817104557');
INSERT INTO `meta_usaurios` VALUES (92, 'UIF', '20220817104558');
INSERT INTO `meta_usaurios` VALUES (93, 'UIF', '20220817104559');
INSERT INTO `meta_usaurios` VALUES (94, 'UIF', '20220817104560');
INSERT INTO `meta_usaurios` VALUES (95, 'UIF', '20220817104561');
INSERT INTO `meta_usaurios` VALUES (96, 'UIF', '20220817105034');
INSERT INTO `meta_usaurios` VALUES (97, 'UIF', '20220817105035');
INSERT INTO `meta_usaurios` VALUES (98, 'UIF', '20220817105036');
INSERT INTO `meta_usaurios` VALUES (99, 'UIF', '20220817105037');
INSERT INTO `meta_usaurios` VALUES (100, 'UIF', '20220817105038');
INSERT INTO `meta_usaurios` VALUES (101, 'UIF', '20220817105101');
INSERT INTO `meta_usaurios` VALUES (102, 'UIF', '20220817105102');
INSERT INTO `meta_usaurios` VALUES (103, 'UIF', '20220817105103');
INSERT INTO `meta_usaurios` VALUES (104, 'UIF', '20220817105104');
INSERT INTO `meta_usaurios` VALUES (105, 'UIF', '20220817105105');
INSERT INTO `meta_usaurios` VALUES (106, 'DGFELCN', '20220817105208');
INSERT INTO `meta_usaurios` VALUES (107, 'DGFELCN', '20220817105209');
INSERT INTO `meta_usaurios` VALUES (108, 'DGFELCN', '20220817105210');
INSERT INTO `meta_usaurios` VALUES (109, 'DGFELCN', '20220817105211');
INSERT INTO `meta_usaurios` VALUES (110, 'DGFELCN', '20220817105212');
INSERT INTO `meta_usaurios` VALUES (111, 'DGFELCN', '20220817105233');
INSERT INTO `meta_usaurios` VALUES (112, 'DGFELCN', '20220817105234');
INSERT INTO `meta_usaurios` VALUES (113, 'DGFELCN', '20220817105235');
INSERT INTO `meta_usaurios` VALUES (114, 'DGFELCN', '20220817105236');
INSERT INTO `meta_usaurios` VALUES (115, 'DGFELCN', '20220817105237');
INSERT INTO `meta_usaurios` VALUES (116, 'DIRCABI', '20220817105340');
INSERT INTO `meta_usaurios` VALUES (117, 'DIRCABI', '20220817105341');
INSERT INTO `meta_usaurios` VALUES (118, 'DIRCABI', '20220817105342');
INSERT INTO `meta_usaurios` VALUES (119, 'DIRCABI', '20220817105343');
INSERT INTO `meta_usaurios` VALUES (120, 'DIRCABI', '20220817105344');
INSERT INTO `meta_usaurios` VALUES (121, 'DIRCABI', '20220817105438');
INSERT INTO `meta_usaurios` VALUES (122, 'DIRCABI', '20220817105439');
INSERT INTO `meta_usaurios` VALUES (123, 'DIRCABI', '20220817105440');
INSERT INTO `meta_usaurios` VALUES (124, 'DIRCABI', '20220817105441');
INSERT INTO `meta_usaurios` VALUES (125, 'DIRCABI', '20220817105442');
INSERT INTO `meta_usaurios` VALUES (126, 'DIRCABI', '20220817105517');
INSERT INTO `meta_usaurios` VALUES (127, 'DIRCABI', '20220817105518');
INSERT INTO `meta_usaurios` VALUES (128, 'DIRCABI', '20220817105519');
INSERT INTO `meta_usaurios` VALUES (129, 'DIRCABI', '20220817105520');
INSERT INTO `meta_usaurios` VALUES (130, 'DIRCABI', '20220817105521');
INSERT INTO `meta_usaurios` VALUES (131, 'DIRCABI', '20220817105548');
INSERT INTO `meta_usaurios` VALUES (132, 'DIRCABI', '20220817105549');
INSERT INTO `meta_usaurios` VALUES (133, 'DIRCABI', '20220817105550');
INSERT INTO `meta_usaurios` VALUES (134, 'DIRCABI', '20220817105551');
INSERT INTO `meta_usaurios` VALUES (135, 'DIRCABI', '20220817105552');
INSERT INTO `meta_usaurios` VALUES (136, 'DIRCABI', '20220817105617');
INSERT INTO `meta_usaurios` VALUES (137, 'DIRCABI', '20220817105618');
INSERT INTO `meta_usaurios` VALUES (138, 'DIRCABI', '20220817105619');
INSERT INTO `meta_usaurios` VALUES (139, 'DIRCABI', '20220817105620');
INSERT INTO `meta_usaurios` VALUES (140, 'DIRCABI', '20220817105621');
INSERT INTO `meta_usaurios` VALUES (141, 'DIRCABI', '20220817105644');
INSERT INTO `meta_usaurios` VALUES (142, 'DIRCABI', '20220817105645');
INSERT INTO `meta_usaurios` VALUES (143, 'DIRCABI', '20220817105646');
INSERT INTO `meta_usaurios` VALUES (144, 'DIRCABI', '20220817105647');
INSERT INTO `meta_usaurios` VALUES (145, 'DIRCABI', '20220817105648');
INSERT INTO `meta_usaurios` VALUES (146, 'CEO', '20220817110226');
INSERT INTO `meta_usaurios` VALUES (147, 'CEO', '20220817110227');
INSERT INTO `meta_usaurios` VALUES (148, 'CEO', '20220817110228');
INSERT INTO `meta_usaurios` VALUES (149, 'CEO', '20220817110229');
INSERT INTO `meta_usaurios` VALUES (150, 'CEO', '20220817110230');
INSERT INTO `meta_usaurios` VALUES (151, 'VCDI', '20220817110226');
INSERT INTO `meta_usaurios` VALUES (152, 'VDS', '20220817110226');
INSERT INTO `meta_usaurios` VALUES (153, 'VCDI', '20220817110227');
INSERT INTO `meta_usaurios` VALUES (154, 'VDS', '20220817110227');
INSERT INTO `meta_usaurios` VALUES (155, 'VCDI', '20220817110228');
INSERT INTO `meta_usaurios` VALUES (156, 'VDS', '20220817110228');
INSERT INTO `meta_usaurios` VALUES (157, 'VCDI', '20220817110229');
INSERT INTO `meta_usaurios` VALUES (158, 'VDS', '20220817110229');
INSERT INTO `meta_usaurios` VALUES (159, 'VCDI', '20220817110230');
INSERT INTO `meta_usaurios` VALUES (160, 'VDS', '20220817110230');
INSERT INTO `meta_usaurios` VALUES (161, 'CEO', '20220817110355');
INSERT INTO `meta_usaurios` VALUES (162, 'CEO', '20220817110356');
INSERT INTO `meta_usaurios` VALUES (163, 'CEO', '20220817110357');
INSERT INTO `meta_usaurios` VALUES (164, 'CEO', '20220817110358');
INSERT INTO `meta_usaurios` VALUES (165, 'CEO', '20220817110359');
INSERT INTO `meta_usaurios` VALUES (166, 'VCDI', '20220817110355');
INSERT INTO `meta_usaurios` VALUES (167, 'VDS', '20220817110355');
INSERT INTO `meta_usaurios` VALUES (168, 'VCDI', '20220817110356');
INSERT INTO `meta_usaurios` VALUES (169, 'VDS', '20220817110356');
INSERT INTO `meta_usaurios` VALUES (170, 'VCDI', '20220817110357');
INSERT INTO `meta_usaurios` VALUES (171, 'VDS', '20220817110357');
INSERT INTO `meta_usaurios` VALUES (172, 'VCDI', '20220817110358');
INSERT INTO `meta_usaurios` VALUES (173, 'VDS', '20220817110358');
INSERT INTO `meta_usaurios` VALUES (174, 'VCDI', '20220817110359');
INSERT INTO `meta_usaurios` VALUES (175, 'VDS', '20220817110359');
INSERT INTO `meta_usaurios` VALUES (176, 'VDS', '20220817110518');
INSERT INTO `meta_usaurios` VALUES (177, 'VDS', '20220817110519');
INSERT INTO `meta_usaurios` VALUES (178, 'VDS', '20220817110520');
INSERT INTO `meta_usaurios` VALUES (179, 'VDS', '20220817110521');
INSERT INTO `meta_usaurios` VALUES (180, 'VDS', '20220817110522');
INSERT INTO `meta_usaurios` VALUES (181, 'CEO', '20220817110518');
INSERT INTO `meta_usaurios` VALUES (182, 'VCDI', '20220817110518');
INSERT INTO `meta_usaurios` VALUES (183, 'UNODC', '20220817110518');
INSERT INTO `meta_usaurios` VALUES (184, 'CEO', '20220817110519');
INSERT INTO `meta_usaurios` VALUES (185, 'VCDI', '20220817110519');
INSERT INTO `meta_usaurios` VALUES (186, 'UNODC', '20220817110519');
INSERT INTO `meta_usaurios` VALUES (187, 'CEO', '20220817110520');
INSERT INTO `meta_usaurios` VALUES (188, 'VCDI', '20220817110520');
INSERT INTO `meta_usaurios` VALUES (189, 'UNODC', '20220817110520');
INSERT INTO `meta_usaurios` VALUES (190, 'CEO', '20220817110521');
INSERT INTO `meta_usaurios` VALUES (191, 'VCDI', '20220817110521');
INSERT INTO `meta_usaurios` VALUES (192, 'UNODC', '20220817110521');
INSERT INTO `meta_usaurios` VALUES (193, 'CEO', '20220817110522');
INSERT INTO `meta_usaurios` VALUES (194, 'VCDI', '20220817110522');
INSERT INTO `meta_usaurios` VALUES (195, 'UNODC', '20220817110522');
INSERT INTO `meta_usaurios` VALUES (196, 'CEO', '20220817110956');
INSERT INTO `meta_usaurios` VALUES (197, 'CEO', '20220817110957');
INSERT INTO `meta_usaurios` VALUES (198, 'CEO', '20220817110958');
INSERT INTO `meta_usaurios` VALUES (199, 'CEO', '20220817110959');
INSERT INTO `meta_usaurios` VALUES (200, 'CEO', '20220817110960');
INSERT INTO `meta_usaurios` VALUES (201, 'VDS', '20220817111049');
INSERT INTO `meta_usaurios` VALUES (202, 'VDS', '20220817111050');
INSERT INTO `meta_usaurios` VALUES (203, 'VDS', '20220817111051');
INSERT INTO `meta_usaurios` VALUES (204, 'VDS', '20220817111052');
INSERT INTO `meta_usaurios` VALUES (205, 'VDS', '20220817111053');
INSERT INTO `meta_usaurios` VALUES (206, 'VCDI', '20220817111049');
INSERT INTO `meta_usaurios` VALUES (207, 'Org. Soc.', '20220817111049');
INSERT INTO `meta_usaurios` VALUES (208, 'VCDI', '20220817111050');
INSERT INTO `meta_usaurios` VALUES (209, 'Org. Soc.', '20220817111050');
INSERT INTO `meta_usaurios` VALUES (210, 'VCDI', '20220817111051');
INSERT INTO `meta_usaurios` VALUES (211, 'Org. Soc.', '20220817111051');
INSERT INTO `meta_usaurios` VALUES (212, 'VCDI', '20220817111052');
INSERT INTO `meta_usaurios` VALUES (213, 'Org. Soc.', '20220817111052');
INSERT INTO `meta_usaurios` VALUES (214, 'VCDI', '20220817111053');
INSERT INTO `meta_usaurios` VALUES (215, 'Org. Soc.', '20220817111053');
INSERT INTO `meta_usaurios` VALUES (216, 'VDS', '20220817111920');
INSERT INTO `meta_usaurios` VALUES (217, 'VDS', '20220817111921');
INSERT INTO `meta_usaurios` VALUES (218, 'VDS', '20220817111922');
INSERT INTO `meta_usaurios` VALUES (219, 'VDS', '20220817111923');
INSERT INTO `meta_usaurios` VALUES (220, 'VDS', '20220817111924');
INSERT INTO `meta_usaurios` VALUES (221, 'VCDI', '20220817111920');
INSERT INTO `meta_usaurios` VALUES (222, 'Org. Soc.', '20220817111920');
INSERT INTO `meta_usaurios` VALUES (223, 'VCDI', '20220817111921');
INSERT INTO `meta_usaurios` VALUES (224, 'Org. Soc.', '20220817111921');
INSERT INTO `meta_usaurios` VALUES (225, 'VCDI', '20220817111922');
INSERT INTO `meta_usaurios` VALUES (226, 'Org. Soc.', '20220817111922');
INSERT INTO `meta_usaurios` VALUES (227, 'VCDI', '20220817111923');
INSERT INTO `meta_usaurios` VALUES (228, 'Org. Soc.', '20220817111923');
INSERT INTO `meta_usaurios` VALUES (229, 'VCDI', '20220817111924');
INSERT INTO `meta_usaurios` VALUES (230, 'Org. Soc.', '20220817111924');
INSERT INTO `meta_usaurios` VALUES (231, 'VCDI', '20220817113004');
INSERT INTO `meta_usaurios` VALUES (232, 'VCDI', '20220817113005');
INSERT INTO `meta_usaurios` VALUES (233, 'VCDI', '20220817113006');
INSERT INTO `meta_usaurios` VALUES (234, 'VCDI', '20220817113007');
INSERT INTO `meta_usaurios` VALUES (235, 'VCDI', '20220817113008');
INSERT INTO `meta_usaurios` VALUES (236, 'VDS', '20220817113004');
INSERT INTO `meta_usaurios` VALUES (237, 'SERNAP', '20220817113004');
INSERT INTO `meta_usaurios` VALUES (238, 'VDS', '20220817113005');
INSERT INTO `meta_usaurios` VALUES (239, 'SERNAP', '20220817113005');
INSERT INTO `meta_usaurios` VALUES (240, 'VDS', '20220817113006');
INSERT INTO `meta_usaurios` VALUES (241, 'SERNAP', '20220817113006');
INSERT INTO `meta_usaurios` VALUES (242, 'VDS', '20220817113007');
INSERT INTO `meta_usaurios` VALUES (243, 'SERNAP', '20220817113007');
INSERT INTO `meta_usaurios` VALUES (244, 'VDS', '20220817113008');
INSERT INTO `meta_usaurios` VALUES (245, 'SERNAP', '20220817113008');
INSERT INTO `meta_usaurios` VALUES (246, 'VDS', '20220817113201');
INSERT INTO `meta_usaurios` VALUES (247, 'VDS', '20220817113202');
INSERT INTO `meta_usaurios` VALUES (248, 'VDS', '20220817113203');
INSERT INTO `meta_usaurios` VALUES (249, 'VDS', '20220817113204');
INSERT INTO `meta_usaurios` VALUES (250, 'VDS', '20220817113205');
INSERT INTO `meta_usaurios` VALUES (251, 'DIGEDES', '20220817113201');
INSERT INTO `meta_usaurios` VALUES (252, 'DIGEDES', '20220817113202');
INSERT INTO `meta_usaurios` VALUES (253, 'DIGEDES', '20220817113203');
INSERT INTO `meta_usaurios` VALUES (254, 'DIGEDES', '20220817113204');
INSERT INTO `meta_usaurios` VALUES (255, 'DIGEDES', '20220817113205');
INSERT INTO `meta_usaurios` VALUES (256, 'VDS', '20220817113313');
INSERT INTO `meta_usaurios` VALUES (257, 'VDS', '20220817113314');
INSERT INTO `meta_usaurios` VALUES (258, 'VDS', '20220817113315');
INSERT INTO `meta_usaurios` VALUES (259, 'VDS', '20220817113316');
INSERT INTO `meta_usaurios` VALUES (260, 'VDS', '20220817113317');
INSERT INTO `meta_usaurios` VALUES (261, 'VCDI', '20220817113313');
INSERT INTO `meta_usaurios` VALUES (262, 'FONADIN', '20220817113313');
INSERT INTO `meta_usaurios` VALUES (264, 'Org. Soc.', '20220817113313');
INSERT INTO `meta_usaurios` VALUES (265, 'VCDI', '20220817113314');
INSERT INTO `meta_usaurios` VALUES (266, 'FONADIN', '20220817113314');
INSERT INTO `meta_usaurios` VALUES (268, 'Org. Soc.', '20220817113314');
INSERT INTO `meta_usaurios` VALUES (269, 'VCDI', '20220817113315');
INSERT INTO `meta_usaurios` VALUES (270, 'FONADIN', '20220817113315');
INSERT INTO `meta_usaurios` VALUES (272, 'Org. Soc.', '20220817113315');
INSERT INTO `meta_usaurios` VALUES (273, 'VCDI', '20220817113316');
INSERT INTO `meta_usaurios` VALUES (274, 'FONADIN', '20220817113316');
INSERT INTO `meta_usaurios` VALUES (275, 'Org. Soc.', '20220817113316');
INSERT INTO `meta_usaurios` VALUES (276, 'VCDI', '20220817113317');
INSERT INTO `meta_usaurios` VALUES (277, 'FONADIN', '20220817113317');
INSERT INTO `meta_usaurios` VALUES (278, 'Org. Soc.', '20220817113317');
INSERT INTO `meta_usaurios` VALUES (279, 'VCDI', '20220817113732');
INSERT INTO `meta_usaurios` VALUES (280, 'VCDI', '20220817113733');
INSERT INTO `meta_usaurios` VALUES (281, 'VCDI', '20220817113734');
INSERT INTO `meta_usaurios` VALUES (282, 'VCDI', '20220817113735');
INSERT INTO `meta_usaurios` VALUES (283, 'VCDI', '20220817113736');
INSERT INTO `meta_usaurios` VALUES (284, 'FONADIN', '20220817113732');
INSERT INTO `meta_usaurios` VALUES (285, 'Org. Soc.', '20220817113732');
INSERT INTO `meta_usaurios` VALUES (286, 'FONADIN', '20220817113733');
INSERT INTO `meta_usaurios` VALUES (287, 'Org. Soc.', '20220817113733');
INSERT INTO `meta_usaurios` VALUES (288, 'FONADIN', '20220817113734');
INSERT INTO `meta_usaurios` VALUES (289, 'Org. Soc.', '20220817113734');
INSERT INTO `meta_usaurios` VALUES (290, 'FONADIN', '20220817113735');
INSERT INTO `meta_usaurios` VALUES (291, 'Org. Soc.', '20220817113735');
INSERT INTO `meta_usaurios` VALUES (292, 'FONADIN', '20220817113736');
INSERT INTO `meta_usaurios` VALUES (293, 'Org. Soc.', '20220817113736');
INSERT INTO `meta_usaurios` VALUES (294, 'Min. Salud', '20220817114000');
INSERT INTO `meta_usaurios` VALUES (295, 'Min. Salud', '20220817114001');
INSERT INTO `meta_usaurios` VALUES (296, 'Min. Salud', '20220817114002');
INSERT INTO `meta_usaurios` VALUES (297, 'Min. Salud', '20220817114003');
INSERT INTO `meta_usaurios` VALUES (298, 'Min. Salud', '20220817114004');
INSERT INTO `meta_usaurios` VALUES (299, 'Min. Salud', '20220817114656');
INSERT INTO `meta_usaurios` VALUES (300, 'Min. Salud', '20220817114657');
INSERT INTO `meta_usaurios` VALUES (301, 'Min. Salud', '20220817114658');
INSERT INTO `meta_usaurios` VALUES (302, 'Min. Salud', '20220817114659');
INSERT INTO `meta_usaurios` VALUES (303, 'Min. Salud', '20220817114660');
INSERT INTO `meta_usaurios` VALUES (304, 'Min. Educ.', '20220817114656');
INSERT INTO `meta_usaurios` VALUES (305, 'VDS', '20220817114656');
INSERT INTO `meta_usaurios` VALUES (306, 'UPCCD', '20220817114656');
INSERT INTO `meta_usaurios` VALUES (307, 'Min. Educ.', '20220817114657');
INSERT INTO `meta_usaurios` VALUES (308, 'VDS', '20220817114657');
INSERT INTO `meta_usaurios` VALUES (309, 'UPCCD', '20220817114657');
INSERT INTO `meta_usaurios` VALUES (310, 'Min. Educ.', '20220817114658');
INSERT INTO `meta_usaurios` VALUES (311, 'VDS', '20220817114658');
INSERT INTO `meta_usaurios` VALUES (312, 'UPCCD', '20220817114658');
INSERT INTO `meta_usaurios` VALUES (313, 'Min. Educ.', '20220817114659');
INSERT INTO `meta_usaurios` VALUES (314, 'VDS', '20220817114659');
INSERT INTO `meta_usaurios` VALUES (315, 'UPCCD', '20220817114659');
INSERT INTO `meta_usaurios` VALUES (316, 'Min. Educ.', '20220817114660');
INSERT INTO `meta_usaurios` VALUES (317, 'VDS', '20220817114660');
INSERT INTO `meta_usaurios` VALUES (318, 'UPCCD', '20220817114660');
INSERT INTO `meta_usaurios` VALUES (319, 'Min. Salud', '20220817114910');
INSERT INTO `meta_usaurios` VALUES (320, 'Min. Salud', '20220817114911');
INSERT INTO `meta_usaurios` VALUES (321, 'Min. Salud', '20220817114912');
INSERT INTO `meta_usaurios` VALUES (322, 'Min. Salud', '20220817114913');
INSERT INTO `meta_usaurios` VALUES (323, 'Min. Salud', '20220817114914');
INSERT INTO `meta_usaurios` VALUES (324, 'Min. Educ.', '20220817115000');
INSERT INTO `meta_usaurios` VALUES (325, 'Min. Educ.', '20220817115001');
INSERT INTO `meta_usaurios` VALUES (326, 'Min. Educ.', '20220817115002');
INSERT INTO `meta_usaurios` VALUES (327, 'Min. Educ.', '20220817115003');
INSERT INTO `meta_usaurios` VALUES (328, 'Min. Educ.', '20220817115004');
INSERT INTO `meta_usaurios` VALUES (329, 'VDS', '20220817115040');
INSERT INTO `meta_usaurios` VALUES (330, 'VDS', '20220817115041');
INSERT INTO `meta_usaurios` VALUES (331, 'VDS', '20220817115042');
INSERT INTO `meta_usaurios` VALUES (332, 'VDS', '20220817115043');
INSERT INTO `meta_usaurios` VALUES (333, 'VDS', '20220817115044');
INSERT INTO `meta_usaurios` VALUES (334, 'DIGEDES', '20220817115040');
INSERT INTO `meta_usaurios` VALUES (335, 'UPCCD', '20220817115040');
INSERT INTO `meta_usaurios` VALUES (336, 'DIGEDES', '20220817115041');
INSERT INTO `meta_usaurios` VALUES (337, 'UPCCD', '20220817115041');
INSERT INTO `meta_usaurios` VALUES (338, 'DIGEDES', '20220817115042');
INSERT INTO `meta_usaurios` VALUES (339, 'UPCCD', '20220817115042');
INSERT INTO `meta_usaurios` VALUES (340, 'DIGEDES', '20220817115043');
INSERT INTO `meta_usaurios` VALUES (341, 'UPCCD', '20220817115043');
INSERT INTO `meta_usaurios` VALUES (342, 'DIGEDES', '20220817115044');
INSERT INTO `meta_usaurios` VALUES (343, 'UPCCD', '20220817115044');
INSERT INTO `meta_usaurios` VALUES (344, 'DGFELCN', '20220817115225');
INSERT INTO `meta_usaurios` VALUES (345, 'DGFELCN', '20220817115226');
INSERT INTO `meta_usaurios` VALUES (346, 'DGFELCN', '20220817115227');
INSERT INTO `meta_usaurios` VALUES (347, 'DGFELCN', '20220817115228');
INSERT INTO `meta_usaurios` VALUES (348, 'DGFELCN', '20220817115229');
INSERT INTO `meta_usaurios` VALUES (349, 'DGFELCN', '20220817115252');
INSERT INTO `meta_usaurios` VALUES (350, 'DGFELCN', '20220817115253');
INSERT INTO `meta_usaurios` VALUES (351, 'DGFELCN', '20220817115254');
INSERT INTO `meta_usaurios` VALUES (352, 'DGFELCN', '20220817115255');
INSERT INTO `meta_usaurios` VALUES (353, 'DGFELCN', '20220817115256');
INSERT INTO `meta_usaurios` VALUES (354, 'VSC', '20220817115325');
INSERT INTO `meta_usaurios` VALUES (355, 'VSC', '20220817115326');
INSERT INTO `meta_usaurios` VALUES (356, 'VSC', '20220817115327');
INSERT INTO `meta_usaurios` VALUES (357, 'VSC', '20220817115328');
INSERT INTO `meta_usaurios` VALUES (358, 'VSC', '20220817115329');
INSERT INTO `meta_usaurios` VALUES (359, 'OBSCD', '20220818121107');
INSERT INTO `meta_usaurios` VALUES (360, 'OBSCD', '20220818121108');
INSERT INTO `meta_usaurios` VALUES (361, 'OBSCD', '20220818121109');
INSERT INTO `meta_usaurios` VALUES (362, 'OBSCD', '20220818121110');
INSERT INTO `meta_usaurios` VALUES (363, 'OBSCD', '20220818121111');
INSERT INTO `meta_usaurios` VALUES (364, 'Min. Salud', '20220818121107');
INSERT INTO `meta_usaurios` VALUES (365, 'VDS', '20220818121107');
INSERT INTO `meta_usaurios` VALUES (366, 'Min. Educ.', '20220818121107');
INSERT INTO `meta_usaurios` VALUES (367, 'Min. Salud', '20220818121108');
INSERT INTO `meta_usaurios` VALUES (368, 'VDS', '20220818121108');
INSERT INTO `meta_usaurios` VALUES (369, 'Min. Educ.', '20220818121108');
INSERT INTO `meta_usaurios` VALUES (370, 'Min. Salud', '20220818121109');
INSERT INTO `meta_usaurios` VALUES (371, 'VDS', '20220818121109');
INSERT INTO `meta_usaurios` VALUES (372, 'Min. Educ.', '20220818121109');
INSERT INTO `meta_usaurios` VALUES (373, 'Min. Salud', '20220818121110');
INSERT INTO `meta_usaurios` VALUES (374, 'VDS', '20220818121110');
INSERT INTO `meta_usaurios` VALUES (375, 'Min. Educ.', '20220818121110');
INSERT INTO `meta_usaurios` VALUES (376, 'Min. Salud', '20220818121111');
INSERT INTO `meta_usaurios` VALUES (377, 'VDS', '20220818121111');
INSERT INTO `meta_usaurios` VALUES (378, 'Min. Educ.', '20220818121111');
INSERT INTO `meta_usaurios` VALUES (379, 'Min. Educ.', '20220818121343');
INSERT INTO `meta_usaurios` VALUES (380, 'Min. Educ.', '20220818121344');
INSERT INTO `meta_usaurios` VALUES (381, 'Min. Educ.', '20220818121345');
INSERT INTO `meta_usaurios` VALUES (382, 'Min. Educ.', '20220818121346');
INSERT INTO `meta_usaurios` VALUES (383, 'Min. Educ.', '20220818121347');
INSERT INTO `meta_usaurios` VALUES (384, 'Min. Educ.', '20220818121413');
INSERT INTO `meta_usaurios` VALUES (385, 'Min. Educ.', '20220818121414');
INSERT INTO `meta_usaurios` VALUES (386, 'Min. Educ.', '20220818121415');
INSERT INTO `meta_usaurios` VALUES (387, 'Min. Educ.', '20220818121416');
INSERT INTO `meta_usaurios` VALUES (388, 'Min. Educ.', '20220818121417');
INSERT INTO `meta_usaurios` VALUES (389, 'Min. Educ.', '20220818121444');
INSERT INTO `meta_usaurios` VALUES (390, 'Min. Educ.', '20220818121445');
INSERT INTO `meta_usaurios` VALUES (391, 'Min. Educ.', '20220818121446');
INSERT INTO `meta_usaurios` VALUES (392, 'Min. Educ.', '20220818121447');
INSERT INTO `meta_usaurios` VALUES (393, 'Min. Educ.', '20220818121448');
INSERT INTO `meta_usaurios` VALUES (394, 'DGFELCN', '20220818121515');
INSERT INTO `meta_usaurios` VALUES (395, 'DGFELCN', '20220818121516');
INSERT INTO `meta_usaurios` VALUES (396, 'DGFELCN', '20220818121517');
INSERT INTO `meta_usaurios` VALUES (397, 'DGFELCN', '20220818121518');
INSERT INTO `meta_usaurios` VALUES (398, 'DGFELCN', '20220818121519');
INSERT INTO `meta_usaurios` VALUES (399, 'VDS', '20220818121549');
INSERT INTO `meta_usaurios` VALUES (400, 'VDS', '20220818121550');
INSERT INTO `meta_usaurios` VALUES (401, 'VDS', '20220818121551');
INSERT INTO `meta_usaurios` VALUES (402, 'VDS', '20220818121552');
INSERT INTO `meta_usaurios` VALUES (403, 'VDS', '20220818121553');
INSERT INTO `meta_usaurios` VALUES (404, 'DIGEDES', '20220818121549');
INSERT INTO `meta_usaurios` VALUES (405, 'UPCCD', '20220818121549');
INSERT INTO `meta_usaurios` VALUES (406, 'DIGEDES', '20220818121550');
INSERT INTO `meta_usaurios` VALUES (407, 'UPCCD', '20220818121550');
INSERT INTO `meta_usaurios` VALUES (408, 'DIGEDES', '20220818121551');
INSERT INTO `meta_usaurios` VALUES (409, 'UPCCD', '20220818121551');
INSERT INTO `meta_usaurios` VALUES (410, 'DIGEDES', '20220818121552');
INSERT INTO `meta_usaurios` VALUES (411, 'UPCCD', '20220818121552');
INSERT INTO `meta_usaurios` VALUES (412, 'DIGEDES', '20220818121553');
INSERT INTO `meta_usaurios` VALUES (413, 'UPCCD', '20220818121553');
INSERT INTO `meta_usaurios` VALUES (414, 'VDS', '20220818121728');
INSERT INTO `meta_usaurios` VALUES (415, 'VDS', '20220818121729');
INSERT INTO `meta_usaurios` VALUES (416, 'VDS', '20220818121730');
INSERT INTO `meta_usaurios` VALUES (417, 'VDS', '20220818121731');
INSERT INTO `meta_usaurios` VALUES (418, 'VDS', '20220818121732');
INSERT INTO `meta_usaurios` VALUES (419, 'DIGEDES', '20220818121728');
INSERT INTO `meta_usaurios` VALUES (420, 'UPCCD', '20220818121728');
INSERT INTO `meta_usaurios` VALUES (421, 'DIGEDES', '20220818121729');
INSERT INTO `meta_usaurios` VALUES (422, 'UPCCD', '20220818121729');
INSERT INTO `meta_usaurios` VALUES (423, 'DIGEDES', '20220818121730');
INSERT INTO `meta_usaurios` VALUES (424, 'UPCCD', '20220818121730');
INSERT INTO `meta_usaurios` VALUES (425, 'DIGEDES', '20220818121731');
INSERT INTO `meta_usaurios` VALUES (426, 'UPCCD', '20220818121731');
INSERT INTO `meta_usaurios` VALUES (427, 'DIGEDES', '20220818121732');
INSERT INTO `meta_usaurios` VALUES (428, 'UPCCD', '20220818121732');
INSERT INTO `meta_usaurios` VALUES (429, 'DGRP', '20220818121944');
INSERT INTO `meta_usaurios` VALUES (430, 'DGRP', '20220818121945');
INSERT INTO `meta_usaurios` VALUES (431, 'DGRP', '20220818121946');
INSERT INTO `meta_usaurios` VALUES (432, 'DGRP', '20220818121947');
INSERT INTO `meta_usaurios` VALUES (433, 'DGRP', '20220818121948');
INSERT INTO `meta_usaurios` VALUES (434, 'Min. Salud', '20220818122034');
INSERT INTO `meta_usaurios` VALUES (435, 'Min. Salud', '20220818122035');
INSERT INTO `meta_usaurios` VALUES (436, 'Min. Salud', '20220818122036');
INSERT INTO `meta_usaurios` VALUES (437, 'Min. Salud', '20220818122037');
INSERT INTO `meta_usaurios` VALUES (438, 'Min. Salud', '20220818122038');
INSERT INTO `meta_usaurios` VALUES (439, 'Min. Salud', '20220818122056');
INSERT INTO `meta_usaurios` VALUES (440, 'Min. Salud', '20220818122057');
INSERT INTO `meta_usaurios` VALUES (441, 'Min. Salud', '20220818122058');
INSERT INTO `meta_usaurios` VALUES (442, 'Min. Salud', '20220818122059');
INSERT INTO `meta_usaurios` VALUES (443, 'Min. Salud', '20220818122060');
INSERT INTO `meta_usaurios` VALUES (444, 'Min. Salud', '20220818122122');
INSERT INTO `meta_usaurios` VALUES (445, 'Min. Salud', '20220818122123');
INSERT INTO `meta_usaurios` VALUES (446, 'Min. Salud', '20220818122124');
INSERT INTO `meta_usaurios` VALUES (447, 'Min. Salud', '20220818122125');
INSERT INTO `meta_usaurios` VALUES (448, 'Min. Salud', '20220818122126');
INSERT INTO `meta_usaurios` VALUES (449, 'DGRP', '20220818122240');
INSERT INTO `meta_usaurios` VALUES (450, 'DGRP', '20220818122241');
INSERT INTO `meta_usaurios` VALUES (451, 'DGRP', '20220818122242');
INSERT INTO `meta_usaurios` VALUES (452, 'DGRP', '20220818122243');
INSERT INTO `meta_usaurios` VALUES (453, 'DGRP', '20220818122244');
INSERT INTO `meta_usaurios` VALUES (454, 'OBSCD', '20220818122311');
INSERT INTO `meta_usaurios` VALUES (455, 'OBSCD', '20220818122312');
INSERT INTO `meta_usaurios` VALUES (456, 'OBSCD', '20220818122313');
INSERT INTO `meta_usaurios` VALUES (457, 'OBSCD', '20220818122314');
INSERT INTO `meta_usaurios` VALUES (458, 'OBSCD', '20220818122315');
INSERT INTO `meta_usaurios` VALUES (459, 'Min. Salud', '20220818122311');
INSERT INTO `meta_usaurios` VALUES (460, 'Min. Salud', '20220818122312');
INSERT INTO `meta_usaurios` VALUES (461, 'Min. Salud', '20220818122313');
INSERT INTO `meta_usaurios` VALUES (462, 'Min. Salud', '20220818122314');
INSERT INTO `meta_usaurios` VALUES (463, 'Min. Salud', '20220818122315');
INSERT INTO `meta_usaurios` VALUES (464, 'VDS', '20220818123014');
INSERT INTO `meta_usaurios` VALUES (465, 'VDS', '20220818123015');
INSERT INTO `meta_usaurios` VALUES (466, 'VDS', '20220818123016');
INSERT INTO `meta_usaurios` VALUES (467, 'VDS', '20220818123017');
INSERT INTO `meta_usaurios` VALUES (468, 'VDS', '20220818123018');
INSERT INTO `meta_usaurios` VALUES (469, 'DIGEDES', '20220818123014');
INSERT INTO `meta_usaurios` VALUES (470, 'UPACI', '20220818123014');
INSERT INTO `meta_usaurios` VALUES (471, 'DIGEDES', '20220818123015');
INSERT INTO `meta_usaurios` VALUES (472, 'UPACI', '20220818123015');
INSERT INTO `meta_usaurios` VALUES (473, 'DIGEDES', '20220818123016');
INSERT INTO `meta_usaurios` VALUES (474, 'UPACI', '20220818123016');
INSERT INTO `meta_usaurios` VALUES (475, 'DIGEDES', '20220818123017');
INSERT INTO `meta_usaurios` VALUES (476, 'UPACI', '20220818123017');
INSERT INTO `meta_usaurios` VALUES (477, 'DIGEDES', '20220818123018');
INSERT INTO `meta_usaurios` VALUES (478, 'UPACI', '20220818123018');
INSERT INTO `meta_usaurios` VALUES (479, 'VDS', '20220818123132');
INSERT INTO `meta_usaurios` VALUES (480, 'VDS', '20220818123133');
INSERT INTO `meta_usaurios` VALUES (481, 'VDS', '20220818123134');
INSERT INTO `meta_usaurios` VALUES (482, 'VDS', '20220818123135');
INSERT INTO `meta_usaurios` VALUES (483, 'VDS', '20220818123136');
INSERT INTO `meta_usaurios` VALUES (484, 'DIGEDES', '20220818123132');
INSERT INTO `meta_usaurios` VALUES (485, 'UPACI', '20220818123132');
INSERT INTO `meta_usaurios` VALUES (486, 'DIGEDES', '20220818123133');
INSERT INTO `meta_usaurios` VALUES (487, 'UPACI', '20220818123133');
INSERT INTO `meta_usaurios` VALUES (488, 'DIGEDES', '20220818123134');
INSERT INTO `meta_usaurios` VALUES (489, 'UPACI', '20220818123134');
INSERT INTO `meta_usaurios` VALUES (490, 'DIGEDES', '20220818123135');
INSERT INTO `meta_usaurios` VALUES (491, 'UPACI', '20220818123135');
INSERT INTO `meta_usaurios` VALUES (492, 'DIGEDES', '20220818123136');
INSERT INTO `meta_usaurios` VALUES (493, 'UPACI', '20220818123136');
INSERT INTO `meta_usaurios` VALUES (494, 'VDS', '20220818123312');
INSERT INTO `meta_usaurios` VALUES (495, 'VDS', '20220818123313');
INSERT INTO `meta_usaurios` VALUES (496, 'VDS', '20220818123314');
INSERT INTO `meta_usaurios` VALUES (497, 'VDS', '20220818123315');
INSERT INTO `meta_usaurios` VALUES (498, 'VDS', '20220818123316');
INSERT INTO `meta_usaurios` VALUES (499, 'DIGEDES', '20220818123312');
INSERT INTO `meta_usaurios` VALUES (500, 'UPACI', '20220818123312');
INSERT INTO `meta_usaurios` VALUES (501, 'DIGEDES', '20220818123313');
INSERT INTO `meta_usaurios` VALUES (502, 'UPACI', '20220818123313');
INSERT INTO `meta_usaurios` VALUES (503, 'DIGEDES', '20220818123314');
INSERT INTO `meta_usaurios` VALUES (504, 'UPACI', '20220818123314');
INSERT INTO `meta_usaurios` VALUES (505, 'DIGEDES', '20220818123315');
INSERT INTO `meta_usaurios` VALUES (506, 'UPACI', '20220818123315');
INSERT INTO `meta_usaurios` VALUES (507, 'DIGEDES', '20220818123316');
INSERT INTO `meta_usaurios` VALUES (508, 'UPACI', '20220818123316');
INSERT INTO `meta_usaurios` VALUES (509, 'VDS', '20220818123455');
INSERT INTO `meta_usaurios` VALUES (510, 'VDS', '20220818123456');
INSERT INTO `meta_usaurios` VALUES (511, 'VDS', '20220818123457');
INSERT INTO `meta_usaurios` VALUES (512, 'VDS', '20220818123458');
INSERT INTO `meta_usaurios` VALUES (513, 'VDS', '20220818123459');
INSERT INTO `meta_usaurios` VALUES (514, 'DIGEDES', '20220818123455');
INSERT INTO `meta_usaurios` VALUES (515, 'UPACI', '20220818123455');
INSERT INTO `meta_usaurios` VALUES (516, 'Min. RR.EE.', '20220818123455');
INSERT INTO `meta_usaurios` VALUES (517, 'DIGEDES', '20220818123456');
INSERT INTO `meta_usaurios` VALUES (518, 'UPACI', '20220818123456');
INSERT INTO `meta_usaurios` VALUES (519, 'Min. RR.EE.', '20220818123456');
INSERT INTO `meta_usaurios` VALUES (520, 'DIGEDES', '20220818123457');
INSERT INTO `meta_usaurios` VALUES (521, 'UPACI', '20220818123457');
INSERT INTO `meta_usaurios` VALUES (522, 'Min. RR.EE.', '20220818123457');
INSERT INTO `meta_usaurios` VALUES (523, 'DIGEDES', '20220818123458');
INSERT INTO `meta_usaurios` VALUES (524, 'UPACI', '20220818123458');
INSERT INTO `meta_usaurios` VALUES (525, 'Min. RR.EE.', '20220818123458');
INSERT INTO `meta_usaurios` VALUES (526, 'DIGEDES', '20220818123459');
INSERT INTO `meta_usaurios` VALUES (527, 'UPACI', '20220818123459');
INSERT INTO `meta_usaurios` VALUES (528, 'Min. RR.EE.', '20220818123459');
INSERT INTO `meta_usaurios` VALUES (529, 'VDS', '20220818123722');
INSERT INTO `meta_usaurios` VALUES (530, 'VDS', '20220818123723');
INSERT INTO `meta_usaurios` VALUES (531, 'VDS', '20220818123724');
INSERT INTO `meta_usaurios` VALUES (532, 'VDS', '20220818123725');
INSERT INTO `meta_usaurios` VALUES (533, 'VDS', '20220818123726');
INSERT INTO `meta_usaurios` VALUES (534, 'DIGEDES', '20220818123722');
INSERT INTO `meta_usaurios` VALUES (535, 'UPACI', '20220818123722');
INSERT INTO `meta_usaurios` VALUES (536, 'DIGEDES', '20220818123723');
INSERT INTO `meta_usaurios` VALUES (537, 'UPACI', '20220818123723');
INSERT INTO `meta_usaurios` VALUES (538, 'DIGEDES', '20220818123724');
INSERT INTO `meta_usaurios` VALUES (539, 'UPACI', '20220818123724');
INSERT INTO `meta_usaurios` VALUES (540, 'DIGEDES', '20220818123725');
INSERT INTO `meta_usaurios` VALUES (541, 'UPACI', '20220818123725');
INSERT INTO `meta_usaurios` VALUES (542, 'DIGEDES', '20220818123726');
INSERT INTO `meta_usaurios` VALUES (543, 'UPACI', '20220818123726');
INSERT INTO `meta_usaurios` VALUES (544, 'VDS', '20220818123934');
INSERT INTO `meta_usaurios` VALUES (545, 'VDS', '20220818123935');
INSERT INTO `meta_usaurios` VALUES (546, 'VDS', '20220818123936');
INSERT INTO `meta_usaurios` VALUES (547, 'VDS', '20220818123937');
INSERT INTO `meta_usaurios` VALUES (548, 'VDS', '20220818123938');
INSERT INTO `meta_usaurios` VALUES (549, 'DIGEDES', '20220818123934');
INSERT INTO `meta_usaurios` VALUES (550, 'UPACI', '20220818123934');
INSERT INTO `meta_usaurios` VALUES (551, 'DIGEDES', '20220818123935');
INSERT INTO `meta_usaurios` VALUES (552, 'UPACI', '20220818123935');
INSERT INTO `meta_usaurios` VALUES (553, 'DIGEDES', '20220818123936');
INSERT INTO `meta_usaurios` VALUES (554, 'UPACI', '20220818123936');
INSERT INTO `meta_usaurios` VALUES (555, 'DIGEDES', '20220818123937');
INSERT INTO `meta_usaurios` VALUES (556, 'UPACI', '20220818123937');
INSERT INTO `meta_usaurios` VALUES (557, 'DIGEDES', '20220818123938');
INSERT INTO `meta_usaurios` VALUES (558, 'UPACI', '20220818123938');
INSERT INTO `meta_usaurios` VALUES (559, 'VDS', '20220818124055');
INSERT INTO `meta_usaurios` VALUES (560, 'VDS', '20220818124056');
INSERT INTO `meta_usaurios` VALUES (561, 'VDS', '20220818124057');
INSERT INTO `meta_usaurios` VALUES (562, 'VDS', '20220818124058');
INSERT INTO `meta_usaurios` VALUES (563, 'VDS', '20220818124059');
INSERT INTO `meta_usaurios` VALUES (564, 'DIGEDES', '20220818124055');
INSERT INTO `meta_usaurios` VALUES (565, 'UPACI', '20220818124055');
INSERT INTO `meta_usaurios` VALUES (566, 'DIGEDES', '20220818124056');
INSERT INTO `meta_usaurios` VALUES (567, 'UPACI', '20220818124056');
INSERT INTO `meta_usaurios` VALUES (568, 'DIGEDES', '20220818124057');
INSERT INTO `meta_usaurios` VALUES (569, 'UPACI', '20220818124057');
INSERT INTO `meta_usaurios` VALUES (570, 'DIGEDES', '20220818124058');
INSERT INTO `meta_usaurios` VALUES (571, 'UPACI', '20220818124058');
INSERT INTO `meta_usaurios` VALUES (572, 'DIGEDES', '20220818124059');
INSERT INTO `meta_usaurios` VALUES (573, 'UPACI', '20220818124059');

-- ----------------------------
-- Table structure for pilar
-- ----------------------------
DROP TABLE IF EXISTS `pilar`;
CREATE TABLE `pilar`  (
  `id_pilar` int NOT NULL AUTO_INCREMENT,
  `cod_pilar` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `titulo_pilar` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `descr_pilar` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `orden_pilar` int NOT NULL,
  PRIMARY KEY (`id_pilar`) USING BTREE,
  UNIQUE INDEX `cod_pilar_UNIQUE`(`cod_pilar`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pilar
-- ----------------------------
INSERT INTO `pilar` VALUES (1, '20220808084539', 'Control del tráfico ilícito de sustancias controladas', 'Fortalecer y aplicar medidas de control contra el tráfico ilícito de drogas y delitos conexos, para desarticular organizaciones criminales dedicadas a la producción y tráfico ilícito internacional de sustancias controladas, afectando la capacidad económica y logística, con pérdida de dominio de bienes en favor del Estado, y prevención, detección y control de legitimación de ganancias ilícitas, adoptando medidas para prevenir el desvío de estupefacientes, psicoactivos y sustancias químicas controladas.', 1);
INSERT INTO `pilar` VALUES (2, '20220808084603', 'Control de la expansión de cultivos de coca', 'Controlar la expansión de cultivos de coca mediante tareas de racionalización, con aplicación del Control Social de los productores de hoja de coca en zonas autorizadas y erradicación en zonas no autorizadas (áreas protegidas y reservas forestales) en todo el territorio nacional, respetando los derechos humanos y la Madre Tierra.', 2);
INSERT INTO `pilar` VALUES (3, '20220808085113', 'Diseño e implementación de la política integral de prevención de consumo de drogas en el ámbito de la salud, educación, familia y comunitario', 'Desarrollar y promover programas, acciones integrales de prevenión universal selectiva e indicada del consumo de drogas, con intervención temprana, tratamiento, rehabilitación y reintegración de personas con adicciones y su entorno, generando estilos de vida saludable y bienestar social en bolivianas y bolivianos, familias y comunidad con un enfoque biopsicosocial y de salud pública, en el marco del respeto de los derechos humanos, con enfoque de género.', 3);
INSERT INTO `pilar` VALUES (4, '20220808085219', 'Regionalización de la lucha contra el narcotráfico y coordinación internacional', 'Regionalizar la lucha contra el narcotráfico y afianzar la coordinación internacional, control fronterizo aéreo, terrestre y fluvial, intercambio de información, investigación, cooperación tecnológica y asistencia técnica, para desarticular a organizaciones criminales dedicadas al tráfico internacional de sustancias controladas, en el marco de la responsabilidad común y compartida.', 4);

-- ----------------------------
-- Table structure for programa
-- ----------------------------
DROP TABLE IF EXISTS `programa`;
CREATE TABLE `programa`  (
  `id_programa` int NOT NULL AUTO_INCREMENT,
  `cod_programa` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cod_pilar_pro` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `titulo_programa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `descr_programa` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `orden_programa` int NOT NULL,
  PRIMARY KEY (`id_programa`) USING BTREE,
  UNIQUE INDEX `cod_programa_UNIQUE`(`cod_programa`) USING BTREE,
  INDEX `fk_programa_pilar_idx`(`cod_pilar_pro`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of programa
-- ----------------------------
INSERT INTO `programa` VALUES (1, '20220808091931', '20220808084539', 'Control, interdicción e investigación al narcotráfico', 'Fortalecer las medidas de control, interdicción, investigación y tecnología, para la desarticulación de organizaciones criminales narcotraficantes afectando la capacidad económica y logística, reducción del tráfico ilícito de sustancias controladas en la fase de producción, tránsito y comercialización y tráfico internacional, efectuando operaciones de inteligencia, interdicción e investigación a nivel nacional y en frontera de manera eficaz y coordinada.', 1);
INSERT INTO `programa` VALUES (2, '20220808092334', '20220808084539', 'Control, fiscalización y vigilancia de sutancias químicas controladas', 'Aplicar medidas integrales de control, fiscalización y vigilancia, para prevenir el ingreso y desvió a actividades ilícitas de sustancias químicas controladas, precursores químicos, productos farmacéuticos psicotrópicos y estupefacientes, en fase de importación, exportación, producción, comercialización y transporte a nivel nacional.', 2);
INSERT INTO `programa` VALUES (3, '20220808092356', '20220808084539', 'Prevención, detección y control de legitimación de ganancias ilícitas', 'Realizar acciones efectivas de investigación e inteligencia policial y análisis financiero patrimonial, para afectar la logística y capacidad económica de personas y organizaciones criminales a través de la prevención, detección y control de la legitimación de ganancias ilícitas provenientes del narcotráfico y delitos conexos.', 3);
INSERT INTO `programa` VALUES (4, '20220808092412', '20220808084539', 'Administración de bienes incautados y confiscados', 'Optimizar la administración de bienes incautados y confiscados al narcotráfico, efectivizando el saneamiento, monetización para la transferencia de recursos y bienes al Estado, enmarcados en la transparencia, normativa nacional y estándares internacionales.', 4);
INSERT INTO `programa` VALUES (5, '20220808092556', '20220808084603', 'Reducción de cultivos excedentarios de coca', 'Efectivizar la racionalización en zonas autorizadas y erradicación en zonas no autorizadas (Áreas Protegidas y reservas forestales), para reducir los cultivos excedentarios de coca, en todo el territorio nacional en el marco de diálogo, concertación, respeto a los derechos humanos y de la madre tierra.', 1);
INSERT INTO `programa` VALUES (6, '20220808092615', '20220808084603', 'Apoyo al control social de la producción de la hoja de coca', 'Apoyar a las organizaciones sociales productoras de hoja de coca con mecanismos para que ejerzan el control social garantizando la producción a los niveles permitidos en la normativa vigente en zonas autorizadas.', 2);
INSERT INTO `programa` VALUES (7, '20220808092634', '20220808084603', 'Reducción y mitigación de impactos socioeconómicos y ambientales', 'Reducir y mitigar el impacto sobre las familias y áreas afectadas por la reducción de cultivos excedentarios de coca en zonas autorizadas y zonas de riesgo de expansión, a través de proyectos productivos, obras civiles, equipamiento y medio ambiente.', 3);
INSERT INTO `programa` VALUES (8, '20220808092708', '20220808085113', 'Prevención del consumo de drogas', 'Desarrollar, promover y consolidar las acciones integrales de prevención del consumo de drogas y de reducción de daños, en el ámbito de la salud, educación, familia y comunidad, con la articulación de las instituciones nacionales, departamentales, municipales y la sociedad civil organizada, respetando los derechos humanos, de la niñez, identidad y género.', 1);
INSERT INTO `programa` VALUES (9, '20220808092720', '20220808085113', 'Tratamiento, rehabilitación y reintegración', 'Establecer, promover y fortalecer el acceso a tratamiento, rehabilitación y reintegración de personas con adicciones y su entorno, a nivel nacional y departamental, desarrollando modelos integrales y teniendo en cuenta estándares de calidad aceptados internacionalmente.', 2);
INSERT INTO `programa` VALUES (10, '20220808092905', '20220808085219', 'Coordinación bilateral', 'Afianzar y promover acuerdos bilaterales con países estratégicos, para fortalecer la lucha contra el narcotráfico y delitos conexos en el marco de los principios de responsabilidad común y compartida.', 1);
INSERT INTO `programa` VALUES (11, '20220808092920', '20220808085219', 'Regionalización y coordinación multilateral', 'Fortalecer las acciones de cooperación y coordinación multilateral para consolidar las capacidades nacionales, desarticular las organizaciones criminales del narcotráfico, enfrentar efectivamente el tráfico ilícito de sustancias controladas delitos conexos y reducción de la demanda, con asistencia técnica y judicial mutua en el marco de los principios de responsabilidad común y compartida.', 2);

-- ----------------------------
-- Table structure for responsable
-- ----------------------------
DROP TABLE IF EXISTS `responsable`;
CREATE TABLE `responsable`  (
  `id_responsable` int NOT NULL AUTO_INCREMENT,
  `cod_responsable_de` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `codigo_ente_responsable` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_responsable`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of responsable
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
