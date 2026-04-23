Se agregó manualmente el campo asignado en la tabla expedientes.
Script ejecutado:


ALTER TABLE expedientes 
ADD COLUMN asignado VARCHAR(255) NULL AFTER pretension_principal;


ALTER TABLE documentos 
ADD sujeto_id BIGINT NULL;



ALTER TABLE documentos 
MODIFY archivo VARCHAR(255) NULL;