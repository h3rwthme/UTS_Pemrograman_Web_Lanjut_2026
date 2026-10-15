CREATE DATABASE IF NOT EXISTS PBL_TI_2026_B_FARKHANABDILLAH;
USE PBL_TI_2026_B_FARKHANABDILLAH;

CREATE TABLE IF NOT EXISTS account_type (
    id CHAR(36) PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    description TEXT,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS actions (
    id CHAR(36) PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    description TEXT,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS accounts (
    id CHAR(36) PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    password TEXT NOT NULL,
    account_type_id CHAR(36) NOT NULL UNIQUE,
    status VARCHAR(128) NOT NULL DEFAULT 'Aktif',
    identification_number VARCHAR(128) NOT NULL,
    identification_type ENUM('NIM', 'NIP') NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME NULL,
    FOREIGN KEY (account_type_id) REFERENCES account_type(id)
);

INSERT IGNORE INTO account_type (id, name, description, created_at, updated_at, deleted_at) VALUES
('a1b2c3d4-e5f6-4a7b-8c9d-0e1f2a3b4c5d', 'Admin', 'Pengelola sistem, punya akses penuh.', NOW(), NOW(), NULL),
('b2c3d4e5-f6a7-4b8c-9d0e-1f2a3b4c5d6e', 'Dosen', 'Akun untuk dosen (identitas NIP).', NOW(), NOW(), NULL),
('c3d4e5f6-a7b8-4c9d-0e1f-2a3b4c5d6e7f', 'Mahasiswa', 'Akun untuk mahasiswa (identitas NIM).', NOW(), NOW(), NULL);

INSERT IGNORE INTO actions (id, name, description, created_at, updated_at, deleted_at) VALUES
('d4e5f6a7-b8c9-4d0e-1f2a-3b4c5d6e7f8a', 'Create', 'Menambahkan data baru.', NOW(), NOW(), NULL),
('e5f6a7b8-c9d0-4e1f-2a3b-4c5d6e7f8a9b', 'Read', 'Melihat data.', NOW(), NOW(), NULL),
('f6a7b8c9-d0e1-4f2a-3b4c-5d6e7f8a9b0c', 'Update', 'Mengubah data yang sudah ada.', NOW(), NOW(), NULL),
('a7b8c9d0-e1f2-4a3b-4c5d-6e7f8a9b0c1d', 'Delete', 'Menghapus data (soft delete).', NOW(), NOW(), NULL);

INSERT IGNORE INTO accounts (id, name, email, password, account_type_id, status, identification_number, identification_type, created_at, updated_at, deleted_at) VALUES
('11111111-1111-4111-8111-111111111111', 'Administrator', 'admin@pnj.ac.id', '$2y$10$ELyhA6Wm9G7Tj55CwYBcDe8DD8OR62oZ4Cdrz2WL/iE.y.dFiuEBO', 'a1b2c3d4-e5f6-4a7b-8c9d-0e1f2a3b4c5d', 'Aktif', '520000000000000746', 'NIP', NOW(), NOW(), NULL),
('22222222-2222-4222-8222-222222222222', 'Farkhan Abdilah', 'farkhan@pnj.ac.id', '$2y$10$ELyhA6Wm9G7Tj55CwYBcDe8DD8OR62oZ4Cdrz2WL/iE.y.dFiuEBO', 'c3d4e5f6-a7b8-4c9d-0e1f-2a3b4c5d6e7f', 'Aktif', '2207421045', 'NIM', NOW(), NOW(), NULL);
