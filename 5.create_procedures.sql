CREATE PROCEDURE DeleteAdmin
    @adminId INT
AS
BEGIN
    SET NOCOUNT ON;

    BEGIN TRANSACTION;

    DECLARE @adminCount INT;

   
    SELECT @adminCount = COUNT(*) FROM Admin;

   
    IF @adminCount > 1
    BEGIN
        
        DELETE FROM Admin WHERE aid = @adminId;
        COMMIT;
    END
    ELSE
    BEGIN
        ROLLBACK;
        THROW 50000, 'Cannot delete the only admin. At least one admin must be present.', 1;
    END;
END;
go

CREATE PROCEDURE DeleteStudent
	@sid INT 
AS
	DELETE FROM Student WHERE sid = @sid;
END;
go

CREATE PROCEDURE DeleteMajor
	@mid INT 
AS
BEGIN TRY
	BEGIN TRANSACTION
		
		--check if there is students in this course
		DECLARE @stnum INT;
			SELECT @stnum = COUNT(sid) 
			FROM Student AS s, Major AS m
			WHERE s.mid=m.mid

			IF @stnum > 0
			BEGIN
				THROW 1001, 'Cant Delete Major sine Students are assigned to it'
			END

			ELSE
			BEGIN
				DELETE FROM Major WHERE mid=@mid;
				GO
			END;

	COMMIT;
	--PRINT 'Transaction committed successfully.'; to the log
END TRY
BEGIN CATCH
	-- Log the error
	--PRINT 'Error: ' + ERROR_MESSAGE(); to the log
	ROLLBACK;
	--PRINT 'Transaction rolled back.'; to the log
END CATCH 
go

CREATE PROCEDURE DeleteMajor
    @mid INT,
	@error_message NVARCHAR(MAX) OUTPUT
AS
BEGIN
    BEGIN TRY
        BEGIN TRANSACTION;

        -- Check if there are students in this major
        DECLARE @stnum INT;
        SELECT @stnum = COUNT(sid)
        FROM Student AS s
        WHERE s.smajor = @mid;

        IF @stnum > 0
        BEGIN
            THROW 51001, 'Cannot delete major since students are assigned to it', 1;
        END
        ELSE
        BEGIN
            DELETE FROM Major WHERE mid = @mid;
        END;

        COMMIT;
        --PRINT 'Transaction committed successfully.'; 
    END TRY
    BEGIN CATCH
        -- Log the error
        --PRINT 'Error: ' + ERROR_MESSAGE(); 
		SET @error_message = ERROR_MESSAGE();
        ROLLBACK;
        --PRINT 'Transaction rolled back.'; 
    END CATCH;
END;
go

CREATE PROCEDURE InsertExam
    @xlabel VARCHAR(255),
    @fromhour TIME,
    @tohour TIME,
  @xdate DATE,
  @cid INT
AS
BEGIN
    SET NOCOUNT ON;  -- Add this line to suppress the additional result sets

    IF @fromhour >= @tohour
    BEGIN
        SELECT 'Error: From Date must be less than or equal to To Date' AS Result;
        RETURN;
    END
	ELSE
	BEGIN
    INSERT INTO Exam (xlabel, cid, fromhour, tohour, xdate)
    VALUES (@xlabel, @cid, @fromhour, @tohour, @xdate);

	--INSERT all the students to the StudentsExamReg that took a course with a cid in the course to the table
	
	EXEC InsertStEx @coid=@cid;


    SELECT 'Exam label added successfully!' AS Result;
	END
END;
go

CREATE PROCEDURE UpdateExam
	@xid INT,
    @xlabel VARCHAR(255),
    @fromhour TIME,
    @tohour TIME,
  @xdate DATE,
  @cid INT
   
AS
BEGIN
    SET NOCOUNT ON;

    IF @fromhour >= @tohour
    BEGIN
        SELECT 'Error: From Date must be less than or equal to To Date' AS Result;
        RETURN;
    END
	ELSE
	BEGIN
    UPDATE Exam SET xlabel = @xlabel, cid = @cid, fromhour = @fromhour, tohour = @tohour, xdate = @xdate WHERE xid = @xid;
    SELECT '' AS Result;

	
	--update the StudentExamReg table
	EXEC UpdateExSt @exid=@xid, @coid=@cid;
	
	

	END
END;
go

CREATE PROCEDURE InsertStEx 
	@coid INT

AS
BEGIN
	INSERT INTO StudentExamReg(sid, xid,st)
	
	SELECT DISTINCT sid, xid, st='0'
	FROM Student AS s, StudentCourses AS sc, Exam AS e
	WHERE s.sid = sc.student AND sc.course = @coid AND e.cid = sc.course AND e.status='not active'
	AND NOT EXISTS(
		SELECT 1
		FROM StudentExamReg AS ser
		WHERE ser.xid = e.xid
	) 
END
GO

CREATE PROCEDURE UpdateExSt 
	@exid INT, @coid INT

AS
BEGIN

	--we have to delete from the StudentExamRegistor All the old students and add the new students
	DELETE FROM StudentExamReg WHERE xid = @exid;

	--now insert the new students
	EXEC InsertStEx @coid=@coid;
END
GO