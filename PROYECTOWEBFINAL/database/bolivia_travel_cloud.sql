-- BoliviaTravel Cloud - Script de base de datos
-- Motor: InnoDB | Charset: utf8mb4

CREATE DATABASE IF NOT EXISTS bolivia_travel_cloud
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE bolivia_travel_cloud;

CREATE TABLE operadores (
    id_operador BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_comercial VARCHAR(150) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    estado VARCHAR(30) NOT NULL DEFAULT 'activo',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE roles (
    id_rol BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(80) NOT NULL,
    descripcion VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE usuarios (
    id_usuario BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_operador BIGINT UNSIGNED NOT NULL,
    id_rol BIGINT UNSIGNED NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_usuarios_operador FOREIGN KEY (id_operador) REFERENCES operadores(id_operador) ON DELETE CASCADE,
    CONSTRAINT fk_usuarios_rol FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE clientes (
    id_cliente BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_operador BIGINT UNSIGNED NOT NULL,
    nombres VARCHAR(150) NOT NULL,
    telefono VARCHAR(30) NULL,
    correo VARCHAR(150) NULL,
    nacionalidad VARCHAR(80) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_clientes_operador FOREIGN KEY (id_operador) REFERENCES operadores(id_operador) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE paquetes_turisticos (
    id_paquete BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_operador BIGINT UNSIGNED NOT NULL,
    nombre_paquete VARCHAR(150) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    cupo_maximo INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_paquetes_operador FOREIGN KEY (id_operador) REFERENCES operadores(id_operador) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE disponibilidad (
    id_disponibilidad BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_paquete BIGINT UNSIGNED NOT NULL,
    fecha DATE NOT NULL,
    cupos_disponibles INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uq_paquete_fecha (id_paquete, fecha),
    CONSTRAINT fk_disponibilidad_paquete FOREIGN KEY (id_paquete) REFERENCES paquetes_turisticos(id_paquete) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE reservas (
    id_reserva BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_cliente BIGINT UNSIGNED NOT NULL,
    id_disponibilidad BIGINT UNSIGNED NOT NULL,
    estado ENUM('pendiente','confirmada','cancelada','completada') NOT NULL DEFAULT 'pendiente',
    monto_total DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_reservas_cliente FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE RESTRICT,
    CONSTRAINT fk_reservas_disponibilidad FOREIGN KEY (id_disponibilidad) REFERENCES disponibilidad(id_disponibilidad) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pagos (
    id_pago BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_reserva BIGINT UNSIGNED NOT NULL,
    metodo_pago VARCHAR(50) NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    estado_pago ENUM('pendiente','pagado','rechazado') NOT NULL DEFAULT 'pendiente',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_pagos_reserva FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE comprobantes (
    id_comprobante BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_pago BIGINT UNSIGNED NOT NULL,
    ruta_archivo VARCHAR(255) NOT NULL,
    fecha_subida TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_comprobantes_pago FOREIGN KEY (id_pago) REFERENCES pagos(id_pago) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO roles (nombre_rol, descripcion, created_at, updated_at) VALUES
('Administrador', 'Acceso total al operador turístico', NOW(), NOW()),
('Operador', 'Gestión diaria de paquetes, clientes y reservas', NOW(), NOW());
