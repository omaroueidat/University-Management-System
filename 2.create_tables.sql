/*==============================================================*/
/* Table: Student                                               */
/*==============================================================*/
create table Student (
    sid int IDENTITY(1, 1) not null,
    sname varchar(30) null,
    bdate datetime null,
    address varchar(50) null,
    phone varchar(24) null,
    semail varchar(30) null,
    sfaculty int null,
    smajor int null,
    image varchar(50) null,
    nationality varchar(40) null,
    academic varchar(50) null,
    ffname varchar(30) null,
    flanme varchar(30) null,
    mname varchar(30) null,
    alt_phone int null,
    emcontact varchar(30) null,
    emcontactnum int null,
    admission_date datetime  null,
    ObtainedCourses int  null,
    ObtainedCredits int  null,
    gender varchar(6) null,
    
    
    
    
    
    constraint PK_STUDENT primary key (sid)
)
go
    /*==============================================================*/
    /* Table: Course                                                */
    /*==============================================================*/
    create table Course (
        cid int IDENTITY(1, 1) not null,
        teacher int not null,
        ccode varchar(10) not null,
        cname varchar(50) not null,
        hours int not null,
        credits int not null,
        constraint PK_COURSE primary key (cid)
    )
go
    /*==============================================================*/
    /* Table: Department                                            */
    /*==============================================================*/
    create table Department (
        did int IDENTITY(1, 1) not null,
        dname varchar(30) not null,
        total_teachers int not null,
        constraint PK_DEPARTMENT primary key (did)
    )
go
    /*==============================================================*/
    /* Table: Faculty                                               */
    /*==============================================================*/
    create table Faculty (
        fid int IDENTITY(1, 1) not null,
        fname varchar(30) not null,
        total_departments int not null,
        constraint PK_FACULTY primary key (fid)
    )
go
    /*==============================================================*/
    /* Table: FacDepReg                                             */
    /*==============================================================*/
    create table FacDepReg (
        fid int not null,
        did int not null,
        id int IDENTITY(1, 1) not null,
        constraint PK_FACDEPREG primary key (fid, did)
    )
go
    /*==============================================================*/
    /* Table: Major                                                 */
    /*==============================================================*/
    create table Major (
        mid int IDENTITY(1, 1) not null,
        mname varchar(30) not null,
        req_sems int not null,
        fid int not null,
        constraint PK_MAJOR primary key (mid)
    )
go
    /*==============================================================*/
    /* Table: MajorCourses                                          */
    /*==============================================================*/
    create table MajorCourses (
        mid int not null,
        cid int not null,
        constraint PK_MAJORCOURSES primary key (mid, cid)
    )
go
    /*==============================================================*/
    /* Table: Teacher                                               */
    /*==============================================================*/
    create table Teacher (
        tid int IDENTITY(1, 1) not null,
        tname varchar(30) not null,
        address varchar(50) not null,
        phone varchar(24) not null,
        speciality varchar(30) not null,
        did int not null,
        constraint PK_TEACHER primary key (tid)
    )
go
    /*==============================================================*/
    /* Table: Exam                                                  */
    /*==============================================================*/
    create table Exam (
        xid int IDENTITY(1, 1) not null,
        xlabel varchar(30) null,
        fromhour datetime null,
        tohour datetime null,
        xdate datetime null,
        cid int null,
        constraint PK_EXAM primary key (xid)
    )
go
    /*==============================================================*/
    /* Adding Computed Status for the exam table                    */
    /*==============================================================*/
ALTER TABLE
    Exam
ADD
    status AS CASE
        WHEN CONVERT(DATE, GETDATE()) < xdate THEN 'not active'
        WHEN CONVERT(DATE, GETDATE()) = xdate
        AND CONVERT(TIME, GETDATE()) < fromhour THEN 'not active'
        WHEN CONVERT(DATE, GETDATE()) = xdate
        AND CONVERT(TIME, GETDATE()) > tohour THEN 'expired'
        WHEN CONVERT(DATE, GETDATE()) = xdate
        AND CONVERT(TIME, GETDATE()) >= fromhour
        AND CONVERT(TIME, GETDATE()) <= tohour THEN 'active'
        WHEN CONVERT(DATE, GETDATE()) > xdate THEN 'expired'
    END;

go
    /*==============================================================*/
    /* Table: Admin                                                 */
    /*==============================================================*/
    create table Admin (
        aid int IDENTITY(1, 1) not null,
        aname varchar(255) null,
        username varchar(255) null,
        phone int null,
        email varchar(200) null,
        apassword varchar(200) null,
        reg_date datetime null,
        constraint PK_ADMIN primary key (aid)
    )
go


    /*==============================================================*/
    /* Table: MarkRegister                                          */
    /*==============================================================*/
    create table MarkRegister (
        sid int not null,
        xid int not null,
        mark decimal(6, 2) null,
        constraint PK_MARKREGISTER primary key (sid, xid)
    )
go
    /*==============================================================*/
    /* Table: StudentCourses                                        */
    /*==============================================================*/
    create table StudentCourses (
        student int not null,
        course int not null,
        constraint PK_STUDENTCOURSES primary key (student, course)
    )
go
    /*==============================================================*/
    /* Table: StudentExamReg                                        */
    /*==============================================================*/
    CREATE TABLE StudentExamReg(
        sid INT NOT NULL,
        xid INT NOT NULL,
        st INT NOT NULL constraint PK_STUDENTEXAMREG PRIMARY KEY (sid, xid)
    )