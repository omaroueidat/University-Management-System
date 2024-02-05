/*==============================================================*/
/* Create Firiegn Keys Constraint                               */
/*==============================================================*/


-- Add foreign key for Student table
ALTER TABLE Student
ADD CONSTRAINT FK_Student_Faculty
FOREIGN KEY (sfaculty) REFERENCES Faculty(fid);
go
ALTER TABLE Student
ADD CONSTRAINT FK_Student_Major
FOREIGN KEY (smajor) REFERENCES Major(mid);
go
-- Add foreign key for Course table
ALTER TABLE Course
ADD CONSTRAINT FK_Course_Teacher
FOREIGN KEY (teacher) REFERENCES Teacher(tid);
go
-- Add foreign key for Major table
ALTER TABLE Major
ADD CONSTRAINT FK_Major_Faculty
FOREIGN KEY (fid) REFERENCES Faculty(fid);
go
-- Add foreign key for MajorCourses table
ALTER TABLE MajorCourses
ADD CONSTRAINT FK_MajorCourses_Major
FOREIGN KEY (mid) REFERENCES Major(mid);
go
ALTER TABLE MajorCourses
ADD CONSTRAINT FK_MajorCourses_Course
FOREIGN KEY (cid) REFERENCES Course(cid);
go
-- Add foreign key for Teacher table
ALTER TABLE Teacher
ADD CONSTRAINT FK_Teacher_Department
FOREIGN KEY (did) REFERENCES Department(did);
go
-- Add foreign key for Exam table
ALTER TABLE Exam
ADD CONSTRAINT FK_Exam_Course
FOREIGN KEY (cid) REFERENCES Course(cid);
go
-- Add foreign key for MarkRegister table
ALTER TABLE MarkRegister
ADD CONSTRAINT FK_MarkRegister_Student
FOREIGN KEY (sid) REFERENCES Student(sid);
go
ALTER TABLE MarkRegister
ADD CONSTRAINT FK_MarkRegister_Exam
FOREIGN KEY (xid) REFERENCES Exam(xid);
go
-- Add foreign key for StudentCourses table
ALTER TABLE StudentCourses
ADD CONSTRAINT FK_StudentCourses_Student
FOREIGN KEY (student) REFERENCES Student(sid);
go
ALTER TABLE StudentCourses
ADD CONSTRAINT FK_StudentCourses_Course
FOREIGN KEY (course) REFERENCES Course(cid);
go
-- Add foreign key for StudentExamReg table
ALTER TABLE StudentExamReg
ADD CONSTRAINT FK_StudentExamReg_Student
FOREIGN KEY (sid) REFERENCES Student(sid);
go
ALTER TABLE StudentExamReg
ADD CONSTRAINT FK_StudentExamReg_Exam
FOREIGN KEY (xid) REFERENCES Exam(xid);
go



ALTER TABLE Department
ADD CONSTRAINT CHK_TotalTeachers CHECK (total_teachers >= 0);
go

ALTER TABLE Faculty
ADD CONSTRAINT CHK_TotalDeps CHECK (total_departments >= 0);
go

ALTER TABLE Course
ADD CONSTRAINT fk_tid
FOREIGN KEY (tid)
REFERENCES Teacher(tid)
ON DELETE SET NULL;
go

ALTER TABLE FacDepReg
ADD CONSTRAINT fk_fid
FOREIGN KEY (fid)
REFERENCES Faculty(fid)
ON DELETE CASCADE;
go

ALTER TABLE Exam
ADD CONSTRAINT fk_cid
FOREIGN KEY (cid)
REFERENCES Course(cid)
ON DELETE CASCADE;

ALTER TABLE StudentCourses
ADD CONSTRAINT fk_scid
FOREIGN KEY (course)
REFERENCES Course(cid)
ON DELETE CASCADE;


ALTER TABLE MajorCourses
ADD CONSTRAINT fk_mcid
FOREIGN KEY (cid)
REFERENCES Course(cid)
ON DELETE CASCADE;

-- Add a default constraint to the column
ALTER TABLE Student
ADD CONSTRAINT DF_ObtainedCourses DEFAULT 0 FOR ObtainedCourses;

-- Add a default constraint to the column
ALTER TABLE Student
ADD CONSTRAINT DF_ObtainedCredits DEFAULT 0 FOR ObtainedCredits;

ALTER TABLE StudentExamReg
ADD CONSTRAINT fk_dxid
FOREIGN KEY (xid)
REFERENCES Exam(xid)
ON DELETE CASCADE;

ALTER TABLE StudentExamReg
ADD CONSTRAINT fk_student
FOREIGN KEY (sid)
REFERENCES Student(sid)
ON DELETE CASCADE;

ALTER TABLE MarkRegister
ADD CONSTRAINT fk_mxid
FOREIGN KEY (xid)
REFERENCES Exam(xid)
ON DELETE CASCADE;

ALTER TABLE MarkRegister
ADD CONSTRAINT fk_csid
FOREIGN KEY (sid)
REFERENCES Student(sid)
ON DELETE CASCADE;

ALTER TABLE StudentCourses
ADD CONSTRAINT fk_scrid
FOREIGN KEY (student)
REFERENCES Student(sid)
ON DELETE CASCADE;