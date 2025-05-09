-- Crear usuario administrador
CREATE USER admin_facturacion IDENTIFIED BY Admin123;
GRANT CONNECT, RESOURCE, DBA TO admin_facturacion;
-- Crear usuario con permisos específicos
CREATE USER usuario_consulta IDENTIFIED BY Usuario123;
GRANT CONNECT, RESOURCE TO usuario_consulta;

-- Crear rol de administrador
CREATE ROLE ROLE_DBA_FACTURACION;

-- Otorgar todos los privilegios al rol
GRANT ALL PRIVILEGES TO ROLE_DBA_FACTURACION;

-- Asignar rol a admin_facturacion
GRANT CONNECT TO admin_facturacion;
GRANT ROLE_DBA_FACTURACION TO admin_facturacion;

-- Crear rol con permisos limitados
CREATE ROLE ROLE_OPERADOR_FACTURACION;
--Crear perfil
CREATE PROFILE FIDE_PROYECTO_FINAL_PROF LIMIT
                    SESSIONS_PER_USER 1
                    IDLE_TIME 30
                    FAILED_LOGIN_ATTEMPTS 3
                    PASSWORD_LOCK_TIME 30;
            

-- Otorgar permisos a cada tabla del esquema ADMIN_FACTURACION
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_CAJA_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_USUARIO_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_TIPO_USUARIO_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_PRODUCTO_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_CATEGORIA_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_EMPLEADO_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_PUESTO_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_SALARIOS_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_FACTURACION_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_REABASTECIMIENTO_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_REPORTE_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_TIENDA_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_INVENTARIO_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_DIRECCION_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_PROVINCIA_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_CANTON_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_DISTRITO_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_CORREO_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_TELEFONO_TB TO ROLE_OPERADOR_FACTURACION;
GRANT SELECT, INSERT, UPDATE, DELETE ON ADMIN_FACTURACION.FIDE_FIDELIZACION_TB TO ROLE_OPERADOR_FACTURACION;

-- Crear usuario operador y asignar rol
CREATE USER operador_facturacion IDENTIFIED BY Operador123;
GRANT CONNECT TO operador_facturacion;
GRANT ROLE_OPERADOR_FACTURACION TO operador_facturacion;
--ASIGNAR EL PERFIL    
ALTER USER operador_facturacion PROFILE FIDE_PROYECTO_FINAL_PROF;
--DESBLOQUEAR USUARIO
ALTER USER operador_facturacion ACCOUNT UNLOCK;
--CREAR TABLESPACE
CREATE TABLESPACE FIDE_PROYECTO_FINAL_TBS
DATAFILE 'C:\Oracle\oradata\XE\FIDE_PROYECTO_FINAL_TBS' SIZE 800M;
/