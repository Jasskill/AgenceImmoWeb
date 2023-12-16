DELIMITER $$

CREATE PROCEDURE supprimer_reservation(idReservation INT)
BEGIN
DECLARE countDispoDerive INT;
BEGIN
SELECT COUNT(*) 
FROM reservation 
WHERE idDisponibilite IN (
    SELECT id 
    FROM disponibilite 
    WHERE derive = (
        SELECT idDisponibilite 
        FROM reservation
        WHERE id = idReservation));
IF (countDispoDerive < 0) THEN
    DELETE FROM disponibilite WHERE derive = (
        SELECT idDisponibilite 
        FROM reservation
        WHERE id = idReservation
    );