CREATE TRIGGER afterTeacherInsert
ON Teacher
AFTER INSERT
AS
BEGIN
    UPDATE Department 
    SET total_teachers = total_teachers + 1
    WHERE did IN (SELECT did FROM inserted);
END;
go

CREATE TRIGGER afterTeacherDelete
ON Teacher
AFTER DELETE
AS
BEGIN
    UPDATE Department 
    SET total_teachers = total_teachers - 1
    WHERE did IN (SELECT did FROM deleted);
END;
go

CREATE TRIGGER afterDepartmentRegister
ON FacDepReg
AFTER INSERT
AS
BEGIN
    UPDATE Faculty 
    SET total_departments = total_departments + 1
    WHERE fid IN (SELECT fid FROM inserted);
END;
go

CREATE TRIGGER afterDepartmentUnRegister
ON FacDepReg
AFTER DELETE
AS
BEGIN
    UPDATE Faculty 
    SET total_departments = total_departments - 1
    WHERE fid IN (SELECT fid FROM deleted);
END;
go

create trigger tr_insert_mark on MarkRegister for insert as
begin
    declare
       @numrows  int,
       @numnull  int,
       @errno    int,
       @errmsg   varchar(255),

	   @mark  int

    select  @numrows = @@rowcount
    if @numrows = 0  return
   
		set @mark = (select i.mark
					 from   inserted i)
					 
        if (@mark>= 50)   
		begin
			-- log: print 'The mark is: ' + CONVERT(VARCHAR(10), @mark)
			--update the obtained courses and credits in the student
			update Student 
				set ObtainedCourses = ObtainedCourses +1,
					ObtainedCredits = ObtainedCredits + (	select credits 
															from Course c, inserted i, Exam e
															where c.cid = e.cid AND i.xid=e.xid)
			from Student as s, inserted as i
			WHERE s.sid = i.sid

			
		end
		else print '...no action to take' 

    return

/*  Errors handling  */
error:
    --raiserror @errno @errmsg
    rollback  transaction
end
go

create trigger tr_update_mark on MarkRegister for update as
begin
    declare
       @numrows  int,
       @numnull  int,
       @errno    int,
       @errmsg   varchar(255),

	   @oldmark  int,
	   @newmark int

    select  @numrows = @@rowcount
    if @numrows = 0  return
   
		set @newmark = (select i.mark
					 from   inserted i)
		set @oldmark = (select d.mark
					 from	deleted d)
					 
        if (@oldmark < 50 AND @newmark>=50)   
		begin
			-- log: print 'The mark is: ' + CONVERT(VARCHAR(10), @mark)
			--update the obtained courses and credits in the student
			update Student 
				set ObtainedCourses = ObtainedCourses +1,
					ObtainedCredits = ObtainedCredits + (	select credits 
															from Course c, inserted i, Exam e
															where c.cid = e.cid AND i.xid=e.xid)
			from Student as s, inserted as i
			where s.sid = i.sid

			
		end
		else if (@oldmark>=50 AND @newmark<50)
		BEGIN
			update Student 
				set ObtainedCourses = ObtainedCourses -1,
					ObtainedCredits = ObtainedCredits - (	select credits 
															from Course c, inserted i, Exam e
															where c.cid = e.cid AND i.xid=e.xid)
			from Student as s, inserted as i
			where s.sid = i.sid

		END
		else if (@oldmark>=50 AND @newmark>=50) print 'no action'
		else print 'no action'

    return

/*  Errors handling  */
error:
    --raiserror @errno @errmsg
    rollback  transaction
end
go
