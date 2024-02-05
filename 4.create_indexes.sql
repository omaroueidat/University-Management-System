-- Index for foreign keys in Student table
CREATE INDEX IX_FK_Student_Faculty ON Student(sfaculty);
CREATE INDEX IX_FK_Student_Major ON Student(smajor);

-- Index for foreign keys in Course table
CREATE INDEX IX_FK_Course_Teacher ON Course(teacher);

-- Index for foreign keys in Major table
CREATE INDEX IX_FK_Major_Faculty ON Major(fid);

-- Index for foreign keys in MajorCourses table
CREATE INDEX IX_FK_MajorCourses_Major ON MajorCourses(mid);
CREATE INDEX IX_FK_MajorCourses_Course ON MajorCourses(cid);

-- Index for foreign keys in Teacher table
CREATE INDEX IX_FK_Teacher_Department ON Teacher(did);

-- Index for foreign keys in Exam table
CREATE INDEX IX_FK_Exam_Course ON Exam(cid);

-- Index for foreign keys in MarkRegister table
CREATE INDEX IX_FK_MarkRegister_Student ON MarkRegister(sid);
CREATE INDEX IX_FK_MarkRegister_Exam ON MarkRegister(xid);

-- Index for foreign keys in StudentCourses table
CREATE INDEX IX_FK_StudentCourses_Student ON StudentCourses(student);
CREATE INDEX IX_FK_StudentCourses_Course ON StudentCourses(course);

-- Index for foreign keys in StudentExamReg table
CREATE INDEX IX_FK_StudentExamReg_Student ON StudentExamReg(sid);
CREATE INDEX IX_FK_StudentExamReg_Exam ON StudentExamReg(xid);
