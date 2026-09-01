PRESIDENT RAMON MAGSAYSAY STATE UNIVERSITY STA. CRUZ CAMPUS
BACHELOR OF SCIENCE IN COMPUTER SCIENCE

ON-THE-JOB-TRAINING MONITORING SYSTEM: ROLE-BASED ACCESS CONTROL INTEGRATION




Edañol, Analyn H.
Cabusao, Kylyn M.
Ednave, Jackielyn C.
Magno, Chris Jericho G.
Manila, Marialyn C.
Morano, Carl M.
Saure, Julius Caesar M.




A Thesis
In partial Fulfillment of the Requirements
for the degree of Bachelor of Science in Computer Science
College of Communication and Information Technology
President Ramon Magsaysay State University
Sta. Cruz, Zambales




SEPTEMBER 2026


================================================================================

Republic of the Philippines
PRESIDENT RAMON MAGSAYSAY STATE UNIVERSITY
College of Communication and Information Technology
Sta. Cruz, Zambales

APPROVAL SHEET

This study entitled "ON-THE-JOB-TRAINING MONITORING SYSTEM: ROLE-BASED ACCESS CONTROL INTEGRATION" prepared and submitted by Edañol, Analyn H., Cabusao, Kylyn M., Ednave, Jackielyn C., Magno, Chris Jericho G., Manila, Marialyn C., Morano, Carl M., and Saure, Julius Caesar M. in partial fulfillment of the requirements for the degree of BACHELOR OF SCIENCE IN COMPUTER SCIENCE are hereby recommended for oral examination.

ANALYN H. EDAÑOL, MSCS                              [NAME OF ADVISER]
Subject Instructor                                   Adviser

________________________________________________________________________
Approved by the Panel of the Oral Examiners on XXXX X, 2026 with a grade of ________.

[CHAIRMAN NAME]
Chairman

ANALYN H. EDAÑOL, MSCS                              JOHN APRIL N. MARPA, PhD
Member                                               Member

ELEMAE L. MORAÑA, MSCS                              JANNIE M. ESCOBAR, PhD
Member                                               Member

________________________________________________________________________
Accepted and approved in partial fulfillment of the requirements for the degree of
BACHELOR OF SCIENCE IN COMPUTER SCIENCE.

___________________                             _____________________________
Date Signed                                     NOEL B. MERIN
                                                Campus Director


================================================================================

ACKNOWLEDGEMENT

The researchers would like to express their deepest gratitude and sincerest appreciation to the following individuals and institutions whose contributions made the completion of this study possible.

To Almighty God, for His boundless grace, unwavering guidance, and the wisdom He bestowed upon the researchers throughout this challenging yet rewarding journey. Without His divine providence, this work would not have come to fruition.

To Prof. Analyn H. Edañol, MSCS, subject instructor and thesis adviser, for her invaluable expertise, patient guidance, and consistent support from the inception of this study to its completion. Her constructive feedback and dedication to academic excellence have shaped this research into what it is today.

To [Name of Adviser], thesis adviser, for the mentorship, encouragement, and technical insights that helped the researchers navigate the complexities of system development and academic writing.

To the Panel of Examiners — [Chairman Name], Prof. John April N. Marpa, PhD, Prof. Elemae L. Moraña, MSCS, and Prof. Jannie M. Escobar, PhD — for their time, expertise, and thorough evaluation that significantly improved the quality and rigor of this research.

To Campus Director Noel B. Merin, for his leadership and support in promoting research excellence at President Ramon Magsaysay State University Sta. Cruz Campus.

To the CCIT Head, OJT Coordinator, Company Supervisors, and BSCS OJT Students who participated as respondents, for generously giving their time, honest feedback, and active cooperation during system testing and evaluation. This study would not have been possible without their participation.

To the College of Communication and Information Technology of PRMSU Sta. Cruz Campus, for providing the research environment, institutional support, and resources that made this study possible.

To our families, for their unconditional love, unwavering moral support, financial assistance, and constant prayers that kept each researcher motivated and grounded throughout this journey.

To our friends and classmates, for the shared laughter, encouragement, and camaraderie that made every difficult moment more bearable.

To everyone who contributed directly or indirectly to this study, the researchers extend their most heartfelt gratitude. May this work serve as a meaningful contribution to the field of computer science and educational technology.

The Researchers


================================================================================

EXECUTIVE SUMMARY

The manual on-the-job training (OJT) monitoring process at President Ramon Magsaysay State University (PRMSU) Sta. Cruz Campus College of Communication and Information Technology (CCIT) faces critical administrative challenges driven by the large population of Bachelor of Science in Computer Science (BSCS) students required to complete 600 hours of industrial training annually. The existing system is labor-intensive, prone to human error, vulnerable to fraudulent attendance practices such as buddy punching, and lacks real-time oversight, resulting in lost documents, inaccurate hour tallying, and compromised data security. These problems are compounded by the absence of any automated role boundary enforcement, making it impossible to prevent unauthorized modifications to student records or ensure that only appropriate personnel handle specific administrative tasks.

The primary objective of this study is to evaluate the application of the Role-Based Access Control Integration Algorithm for the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System. Specifically, the study aims to test the proposed RBAC algorithm in terms of efficiency and functionality; to test the existing manual verification process of the CCIT Department in terms of efficiency and functionality; to develop a model of the Role-Based Access Control Integration for the CCIT Department; to evaluate the level of acceptance of the system using the Technology Acceptance Model (TAM) across five dimensions; to compare the strength of the RBAC algorithm over the manual verification process; and to develop a user's manual for the CCIT Department. The developed system is a web-based platform built using the Laravel PHP framework that enforces role-specific access through custom middleware and session-based authentication, supporting four distinct user roles — Student, Supervisor, Coordinator, and CCIT Head — each directed to a dedicated dashboard with permissions scoped exclusively to their function.

The research employed a quantitative descriptive research design combined with a developmental research approach. The Agile Development Model guided system construction through iterative sprints covering planning, design, development, testing, deployment, review, and launch phases. Data were gathered using a structured TAM-based questionnaire distributed to 105 participants through Google Forms and printed surveys, comprising 92 BSCS OJT students, 11 company supervisors, 1 OJT coordinator, and 1 CCIT Head, selected through purposive sampling. System performance was evaluated through black-box testing using a structured test case checklist for functionality assessment and server-side processing time measurement for efficiency assessment. The existing manual process was benchmarked by recording average verification times and analyzing a sample of 50 manual records for error rates. Statistical treatments included weighted mean for TAM evaluation, frequency and percentage distribution for respondent profiling, processing time analysis for efficiency comparison, and access control accuracy rate calculation for functionality comparison.

The findings revealed that the proposed RBAC algorithm significantly outperformed the existing manual verification process in both efficiency and functionality. The automated system recorded an average processing time of 0.558 milliseconds across eight critical transactions, compared to the manual process average of 14.19 minutes — a reduction of approximately 99.99%. The RBAC algorithm achieved a perfect 100% access control accuracy rate with zero unauthorized cross-role access across all ten black-box test cases, while the manual process produced a 50.00% overall error rate from 50 sampled records, including data entry errors (14.00%), incorrect hour tallying (12.00%), lost documents (10.00%), fraudulent attendance entries (8.00%), and unauthorized record modification (6.00%). The TAM evaluation demonstrated exceptional user acceptance, with overall weighted means of 3.99 for Perceived Usefulness, 3.99 for Perceived Ease of Use, 4.00 for Behavioral Intention to Use, and 4.00 for Attitude Toward Use, all interpreted as Highly Acceptable. Actual system use data confirmed strong adoption with 88.57% of respondents reporting constant daily usage and 94.29% reporting consistent weekly usage.

The study concludes that the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration provides a superior, highly accepted digital solution over the existing manual process. The system eliminates the identified error types through server-synchronized timestamps, mandatory photo capture, role-specific middleware enforcement, and a secure digital repository, confirming its suitability for managing the OJT monitoring operations of the PRMSU CCIT Department at scale. The researchers recommend future enhancements including One-Time Password (OTP) integration for strengthened login security, facial recognition technology for advanced identity verification, GPS-based location verification, expanded analytics dashboards, and mobile application development with offline synchronization capability to further address the current limitations of internet connectivity dependency and the absence of geographical tracking.


================================================================================

TABLE OF CONTENTS

TITLE PAGE                                                                      i
APPROVAL SHEET                                                                  ii
ACKNOWLEDGEMENT                                                                 iii
EXECUTIVE SUMMARY                                                               iv
TABLE OF CONTENTS                                                               vi
LIST OF TABLES                                                                  vii
LIST OF FIGURES                                                                 viii
LIST OF NOTATIONS                                                               ix

CHAPTER 1. INTRODUCTION
  Project Context                                                               1
  Purpose and Description                                                       3
  Objectives of the Study                                                       6
  Scope and Limitations                                                         7
  Definition of Terms                                                           10

CHAPTER 2. REVIEW OF RELATED LITERATURE/SYSTEMS
  Technical Background                                                          14
  Review of Related Literature, Studies/Systems                                 16
  Synthesis                                                                     27

CHAPTER 3. METHODOLOGY
  Research Design                                                               30
  Requirement Analysis                                                          31
  Research Locale                                                               32
  Name of Proposed Algorithm                                                    33
  Data Gathering Tools                                                          34
  Design of Software, System, Product and/or Processes                         35
    Conceptual Framework                                                        35
    Algorithm Flowchart                                                         37
    System Flowchart                                                            37
    Software Development Life Cycle                                             38
  Data Analysis Plan                                                            43
  Research Instrument                                                           44
  Instrument Administration                                                     44
  Instrument Validation                                                         45
  Population Sampling                                                           45
  Distribution of Respondents                                                   46
  Statistical Treatment of Data                                                 46
  Description of the Prototype                                                  49
    Hardware Requirements                                                       49
    Software Requirements                                                       50

CHAPTER 4. RESULTS AND DISCUSSION
  Evaluation of the Proposed Algorithm in terms of Efficiency                  51
  Evaluation of the Proposed Algorithm in terms of Functionality               53
  Evaluation of the Existing Algorithm in terms of Efficiency                  55
  Evaluation of the Existing Algorithm in terms of Functionality               57
  Comparative Analysis of the Proposed and Existing Algorithm                  59
  Evaluation of the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS
    OJT Monitoring System Using the Technology Acceptance Model (TAM)          61
    1. Perceived Usefulness                                                     61
    2. Perceived Ease of Use                                                    63
    3. Behavioral Intention to Use                                              65
    4. Attitude Toward Use                                                      67
    5. Actual System Use                                                        69

CHAPTER 5. RECOMMENDATIONS
  Summary of Findings                                                           72
  Conclusions                                                                   74
  Recommendations                                                               75

REFERENCES                                                                      77

APPENDICES
  Appendix A  Relevant Source Code                                              82
  Appendix B  Evaluation Tool or Test Documents                                 95
  Appendix C  Users' Guide                                                      96
  Appendix D  Screen Layouts                                                   120
  Appendix E  Test Results                                                     121
  Appendix F  Copy of Request Letter/MOA/MOU                                  130
  Appendix G  Curriculum Vitae                                                 131
  Appendix H  Documentation                                                    132

================================================================================

LIST OF TABLES

Table          Title                                                          Page
  1    Distribution of Participants                                            46
  2    Testing of the Proposed RBAC Algorithm in terms of Efficiency           51
  3    Testing of the Proposed RBAC Algorithm in terms of Functionality        53
  4    Testing of the Existing Manual Verification Process in terms of
         Efficiency                                                            55
  5    Testing of the Existing Manual Verification Process in terms of
         Functionality                                                         57
  6    Respondents' Response on the Level of Acceptance in terms of
         Perceived Usefulness                                                  61
  7    Respondents' Response on the Level of Acceptance in terms of
         Perceived Ease of Use                                                 63
  8    Respondents' Response on the Level of Acceptance in terms of
         Behavioral Intention to Use                                           65
  9    Respondents' Response on the Level of Acceptance in terms of
         Attitude Toward Use                                                   67
 10    Summary of the Level of Acceptance Using the TAM                        69
 11    Actual Use — Daily Basis                                                 70
 12    Actual Use — Weekly Basis                                                71

================================================================================

LIST OF FIGURES

Figure         Title                                                          Page
  1    Conceptual Framework                                                    36
  2    Location of PRMSU Sta. Cruz Campus                                      33
  3    Agile Development Model                                                 38
  4    Role-Based Access Control Algorithm Flowchart                           37
  5    System Flowchart — Login/Register                                       37
  6    System Flowchart (A) — Student                                          38
  7    System Flowchart (B) — Supervisor                                       39
  8    System Flowchart (C) — Coordinator                                      40
  9    System Flowchart (D) — CCIT Head                                        41
 10    Comparison of Proposed RBAC and Manual Process — Efficiency             59
 11    Comparison of Proposed RBAC and Manual Process — Functionality          60

================================================================================

LIST OF NOTATIONS

BSCS        Bachelor of Science in Computer Science
CCIT        College of Communication and Information Technology
DTR         Daily Time Record
GPS         Global Positioning System
HTTP        Hypertext Transfer Protocol
ICT         Information and Communication Technology
MOA         Memorandum of Agreement
MOU         Memorandum of Understanding
OJT         On-the-Job Training
OT          Overtime
PEOU        Perceived Ease of Use
PRMSU       President Ramon Magsaysay State University
PU          Perceived Usefulness
RBAC        Role-Based Access Control
SQL         Structured Query Language
TAM         Technology Acceptance Model


================================================================================

Chapter 1
INTRODUCTION

Project Context

The rapid growth and integration of Information and Communication Technology (ICT) in the 21st century have fundamentally transformed administrative and pedagogical frameworks within higher education institutions. According to Palines, Moreno, Tatlonghari, and Ortega-Dela Cruz (2025), technological advancements in the Philippine education sector have eliminated geographical limitations and improved access to digital resources, aligning with global standards for high-quality education. Modern educational systems no longer view technology as an optional luxury but as a strategic necessity that streamlines routine tasks, allowing administrators to allocate more time to strategic planning and student-centered support. Specifically, in experiential learning, the adoption of automated, web-based monitoring platforms has proven to significantly enhance performance tracking, provide real-time data integration, and improve the documentation of student tasks compared to traditional manual methods. A research study by Castro (2024) highlights that transitioning to digital monitoring systems in Philippine colleges effectively manages intern records, enhances accountability, and improves administrative processes by meeting global standards for functional suitability and security.

This study is conducted at President Ramon Magsaysay State University (PRMSU) Sta. Cruz Campus, specifically within the College of Communication and Information Technology (CCIT). As a leading provider of technical higher education, the department handles a very large population of Bachelor of Science in Computer Science (BSCS) students. Every year, a high volume of these students must complete 600 hours of job training. Due to the large number of interns being monitored simultaneously, the department faces a significant challenge in managing records and tracking progress manually. Therefore, the CCIT department serves as the actual setting to test how an automated system can handle a massive amount of student data while maintaining organized and secure records through role-based access management integration.

During data gathering, the researchers found that the manual OJT monitoring process at the PRMSU Sta. Cruz Campus CCIT Department faces significant challenges due to the large population of students. With so many interns to track, the current system lacks real-time attendance verification, making it easy for "buddy punching" or fraudulent logging to occur. The manual tallying of the 600-hour requirement is labor-intensive and prone to human error, while paper-based submissions such as narrative reports and completion certificates are often misplaced or lost. To solve this, the proposed system integrates role-based access management to ensure data security for every user. Specifically, Students can only upload and view their own requirements and attendance records; Supervisors from the industry are the only ones authorized to submit performance evaluations to prevent grade tampering; and Coordinators, together with the CCIT Head, have the exclusive authority to approve student-submitted requirement documents, while time-in record approval is shared between Supervisors and Coordinators. This digital security ensures that student evaluations and academic documents are protected from unauthorized access or accidental loss.

As a solution to these problems, the researchers propose the development of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration. The system is built as a web-based platform using the Laravel PHP framework that enforces role-specific access through custom role-based middleware and session-based authentication, automatically restricting system routes and functions based on the authenticated user's assigned role. The system supports four distinct roles — Student, Supervisor, Coordinator, and CCIT Head — each redirected to a dedicated dashboard upon login. It features server-synchronized timestamps for time-in and time-out recording with mandatory photo capture for both time-in and time-out across morning and afternoon sessions, enforced through a face-positioning guide overlay that displays an oval frame over the live camera feed and keeps the capture button disabled until the student's face is detected within the frame, preventing client-side tampering and buddy punching. The system also includes automated calculation of the 600-hour requirement in real-time, a daily narrative report module where students write and submit a written account of their daily internship activities with an optional photo — one entry per day, auto-numbered, and downloadable as a Word (.doc) report — a secure digital repository for requirement documents and completion certificates, and administrative dashboards for departmental oversight. The attendance history displays all session photos per day grouped into a single card showing morning time-in, morning time-out, afternoon time-in, and afternoon time-out photos. The system also implements a school ID pre-approval mechanism, requiring students to register only with a valid, unused school ID number from the approved list, further strengthening access integrity. When a school ID is archived by the CCIT Head, the student account associated with that ID is automatically archived as well, and restoring the ID restores the student account.

Purpose and Description

The proposed system will benefit the following:

BSCS OJT Students. Students benefit from a transparent, real-time interface to track their progress toward the mandatory 600-hour requirement. The RBAC algorithm ensures they can only access and upload their own requirements, perform their own time-in and time-out using server-recorded timestamps with mandatory photo capture for both time-in and time-out across morning and afternoon sessions, view their own attendance history displaying all four session photos per day grouped into a single card (morning time-in, morning time-out, afternoon time-in, and afternoon time-out), submit and manage their own daily narrative reports, and monitor their hours completed and hours remaining, providing a secure digital repository for requirements and preventing any unauthorized changes to their personal data. The daily narrative feature allows students to write a journal entry for each working day, recording the date, a description of tasks performed, and an optional photo, with the system automatically computing the day number based on the student's total submitted entries. Only one narrative entry is allowed per day, and students may edit existing entries if corrections are needed. The compiled narrative entries can be downloaded as a Word (.doc) report by the student and viewed by authorized personnel. The camera modal features a face-positioning guide overlay with an oval frame that keeps the capture button disabled and the frame border red until the student's face is aligned within the oval, at which point the border turns green and the capture button is enabled, ensuring that each photo captures the actual student present at the internship site.

OJT Coordinators. They benefit from the automation of the monitoring process, which allows for the simultaneous management of a large student population. The RBAC algorithm provides these coordinators with the specific authority to add and remove partner companies, monitor all students' progress and attendance through a searchable tracking interface, approve or deny student-submitted requirement documents with written feedback, and view DTR reports per student, eliminating the errors and time-loss associated with manual tallying.

CCIT Head. This role benefits from a high-level administrative dashboard that provides system-wide oversight of internship completion rates, departmental statistics, and user activity, facilitating data-driven decision-making for academic compliance. Through RBAC, the CCIT Head is granted the exclusive authority to manage all user accounts across every role, manage school years, configure the system-wide required internship hours, maintain the school ID pre-approval list, and generate exportable system-wide PDF reports covering user data, student progress, and attendance records.

Company Supervisors. The system grants supervisors a secure, role-specific portal to directly monitor the attendance and progress of students assigned to their company. The RBAC algorithm ensures that supervisors can view task logs compiled by date, with all session photos for each day grouped into a single card showing morning time-in, morning time-out, afternoon time-in, and afternoon time-out photos, approve or deny student attendance records per day — with incomplete sessions where a student forgot to time out automatically denied by the system and marked with a "Not Finished" badge — approve or deny student-submitted requirements, and submit a performance evaluation rating and written feedback, with the evaluation feature locked until the student has completed the required number of internship hours, preventing premature or unauthorized grading. Supervisors may also undo a previously approved time-in record, which automatically deducts the credited hours from the student's progress and replaces the Undo button with a Redo button, allowing re-approval without repeating the full approval workflow.

PRMSU Institution. The institution benefits from a modernized administrative framework that enhances data security and aligns the university's processes with digital transformation standards. The RBAC algorithm ensures that institutional data remains protected by restricting system entry only to verified personnel.

Future Researchers. This study can serve as a reference for researchers interested in developing a PRMSU Sta. Cruz BSCS OJT Monitoring System: Role-Based Access Control Algorithm Integration or other related technology courses. The study provides a guide for future academic and technical developments interested in combining security algorithms with educational management tools.

Objectives of the Study

The primary objective of this study is to evaluate the application of the Role-Based Access Control Integration Algorithm for the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System. Specifically, the study aims to:

1. to test the proposed algorithm in terms of:
   1.1 efficiency; and
   1.2 functionality.

2. to test the existing algorithm in CCIT Department of PRMSU Sta. Cruz Campus in terms of:
   2.1 efficiency; and
   2.2 functionality.

3. to develop a model of the Role-Based Access Control Integration to CCIT Department of PRMSU Sta. Cruz Campus.

4. to evaluate the level of acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System using the Technology Acceptance Model (TAM) in terms of:
   4.1 perceived usefulness;
   4.2 perceived ease of use;
   4.3 behavioral intention to use;
   4.4 attitude toward use; and
   4.5 actual system use.

5. to compare the strength of Role-Based Access Control Algorithm to CCIT Department of PRMSU Sta. Cruz Campus over the Manual Verification Process.

6. to develop a user's manual for the CCIT Department of PRMSU Sta. Cruz Campus.

Scope and Limitations

The primary focus of this study is the design, development, and evaluation of a web-based monitoring platform specifically tailored for internship management. This project implements the Role-Based Access Control (RBAC) integration algorithm to manage access rights and restrict system features based on the user's assigned role within the department. It also utilizes automated logic for Daily Time Record (DTR) tracking to calculate the mandatory 600-hour requirement for each student. The study is conducted specifically for the CCIT at PRMSU Sta. Cruz Campus. The system features real-time attendance verification using photo capture to prevent fraudulent logging, a secure digital repository for narrative reports and certificates, and administrative dashboards for departmental oversight. These functionalities are designed for four target user roles: BSCS OJT Students, Company Supervisors, OJT Coordinators, and the CCIT Department Head.

The scope of the study covers the following areas. First, the complete development of a web-based OJT monitoring system using the Laravel PHP framework, MySQL database management system, and XAMPP local server environment with responsive design using Tailwind CSS. Second, the integration of a custom RBAC algorithm through a two-layer middleware mechanism — AuthMiddleware for session verification and RoleMiddleware for role validation — that enforces strict separation of duties across the four defined user roles. Third, attendance monitoring features including server-synchronized time-in and time-out recording with mandatory photo capture for morning and afternoon sessions, automatic session management with auto-timeout at 12:00 PM for unclosed morning sessions and auto-denial for incomplete afternoon sessions, overtime detection with OT letter submission workflow, and real-time 600-hour tracking. Fourth, a document management system providing a secure digital repository for student requirement submissions with approval workflows, written feedback capability, status tracking, and resubmission functionality, as well as a daily narrative report module allowing students to write, submit, and edit daily journal entries with optional photo attachments — one entry per day, auto-numbered — and to download their compiled narratives as a Word (.doc) report. Fifth, administrative functions including user account management by the CCIT Head, school year management, school ID pre-approval, company management by coordinators, system-wide settings configuration, and exportable PDF reports. Sixth, system evaluation through black-box testing, processing time measurement, error rate analysis, and TAM evaluation involving 105 participants.

While the system addresses core administrative challenges, it is subject to several constraints. The system is web-based and requires a stable internet connection for real-time syncing and data uploading, meaning it does not support offline logging. Additionally, the system does not include Global Positioning System (GPS) tracking and cannot monitor or record the specific geographical locations of students. The implementation is designed to be localized specifically for the research site and identified user roles, which may limit its immediate adaptability to other institutional structures. Success is also dependent on the technical personnel and facilities available at the CCIT Department for implementation.

The researchers have set specific boundaries to maintain the focus and technical integrity of the study. The system is exclusively delimited to the BSCS program within the CCIT department, allowing the developers to tailor the logic specifically to the 600-hour curriculum requirement unique to this degree program. Furthermore, the study is restricted to PRMSU Sta. Cruz Campus, ensuring the system aligns perfectly with the specific administrative workflows and student population of that particular branch.

The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System provides a comprehensive digital solution for attendance tracking, document management, and role-based security. Although it is limited by the necessity of internet connectivity and the exclusion of GPS tracking, the study remains highly relevant as it establishes a modernized framework to reduce buddy punching through server-side timestamp enforcement and photo verification, prevent data loss through a secure digital repository, and ensure the integrity of academic records. Ultimately, this system aligns the university's processes with digital transformation standards while managing a large student population efficiently and securely.

Definition of Terms

The following terms are defined conceptually and operationally for the purpose of this study:

600-Hour Requirement refers to the mandatory duration of industrial training that Bachelor of Science in Computer Science students must complete to fulfill their academic curriculum at PRMSU. In this study, it refers specifically to the threshold that the proposed system tracks and calculates automatically in real-time for each student enrolled in the OJT program.

Agile Development Model is the iterative and incremental software development methodology adopted in this study, wherein the system was built and refined through successive development sprints based on continuous user feedback and testing cycles. Each sprint focused on delivering a functional set of modules that were tested and evaluated before proceeding to the next phase.

Buddy Punching is a form of fraudulent attendance logging where one student records the time entry for another student who is not actually present at the internship site. In this study, it refers to the practice that the system prevents through mandatory photo capture with a face-positioning guide overlay and server-side timestamp enforcement.

Bulk Import refers to the feature in the School IDs section that allows the CCIT Head to add multiple school ID numbers simultaneously by pasting a list of IDs, one per line, into a text area. The system processes each entry sequentially, skips duplicates and archived IDs automatically, and displays a progress overlay with a counter and progress bar during the import operation.

Daily Time Record (DTR) is the digital log used to track the clock-in and clock-out times of interns to monitor their daily rendered hours, generated per student and exportable from the system. In this study, it serves as the primary instrument for verifying student attendance and computing progress toward the 600-hour requirement.

Digital Repository refers to the secure online storage feature of the system where narrative reports and completion certificates are uploaded to prevent physical loss or damage common in paper-based filing. In this study, it is governed by role-based access restrictions that ensure only authorized personnel can view, approve, or deny submitted documents.

Laravel refers to the open-source PHP web application framework used as the primary development platform of the system. In this study, it provides the routing engine, Eloquent ORM, middleware architecture, session management, and Blade templating engine that collectively enable the implementation of the RBAC algorithm.

Middleware refers to the software layer implemented in the Laravel framework that intercepts every incoming request to verify the user's authentication status and role before granting or denying access to a specific route or system function. In this study, two middleware components — AuthMiddleware and RoleMiddleware — constitute the technical backbone of the RBAC enforcement mechanism.

MySQL refers to the open-source relational database management system used to store and manage all system data. In this study, it handles the storage of user accounts, role assignments, time-in records, student hour logs, submitted requirement documents, daily logs, and evaluation records.

OJT Coordinator refers to the faculty member within the CCIT department responsible for supervising the internship program, verifying student hours, managing partner companies, and communicating with industry partners. In this study, it is one of the four defined user roles with specific access permissions enforced by the RBAC algorithm.

Overtime (OT) refers to the hours rendered by a student beyond the standard eight-hour daily limit. In this study, the system detects overtime automatically and requires the submission of an approved OT letter before crediting the additional hours toward the student's progress total.

Real-Time Monitoring is the capability of the system to update and display attendance data and progress calculations immediately as they occur on the web platform, without requiring manual refresh or batch processing. In this study, it includes instant hour calculation upon time-out, live status updates on approval actions, and automatic progress bar updates on the student dashboard.

Role-Based Access Control (RBAC) is the security algorithm implemented in the system that restricts or grants access to specific features based on the user's assigned role — Student, Supervisor, Coordinator, or CCIT Head — enforced through custom middleware at the route level. In this study, it is the primary technical mechanism evaluated for its efficiency and functionality relative to the existing manual verification process.

School ID Pre-Approval is a registration security mechanism that requires students to register using only a valid, unused school ID number from a pre-approved whitelist maintained by the CCIT Head, preventing unauthorized account creation. In this study, it represents an additional layer of access integrity that supplements the RBAC algorithm by controlling who may enter the system in the first place.

Session-Based Authentication refers to the method by which the system verifies a logged-in user's identity and role by storing and reading user data from the server-side session on every request, preventing unauthorized access without re-authentication. In this study, it is the mechanism through which the RBAC middleware retrieves the user's role for each incoming request.

Technology Acceptance Model (TAM) is the evaluation framework used in this study to measure the level of user acceptance of the system through five dimensions: perceived usefulness, perceived ease of use, behavioral intention to use, attitude toward use, and actual system use. In this study, TAM serves as the theoretical basis for designing the survey questionnaire and interpreting respondent feedback regarding the developed system.

Time-Out Photo refers to the mandatory photo captured by the student at the moment of recording their time-out, stored separately from the time-in photo in the database. In this study, both the time-in and time-out photos are displayed together in the attendance history and task logs, grouped by date into a single card showing all four session photos: morning time-in, morning time-out, afternoon time-in, and afternoon time-out.

Undo/Redo Approval refers to the supervisor's ability to revert a previously approved time-in record back to pending status (Undo) or to re-approve a previously undone record (Redo). In this study, when an approval is undone, the system automatically deducts the credited hours from the student's total completed hours, and the record's action button changes from Undo to Redo, allowing re-approval and hour restoration without repeating the full approval workflow.


================================================================================

Chapter 2
REVIEW OF RELATED LITERATURE/SYSTEMS

This chapter presents the review of related literature and studies that is significant in the development of the present study.

Technical Background

The following technologies and frameworks were used in the development of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration.

Laravel. Laravel is an open-source PHP web application framework following the Model-View-Controller (MVC) architectural pattern, created by Taylor Otwell and first released in 2011. It is widely recognized for its elegant syntax, built-in routing engine, Eloquent ORM for database interaction, Blade templating engine for dynamic views, and a robust middleware pipeline that intercepts HTTP requests before they reach the application's core logic. In this study, Laravel serves as the primary development platform for the entire system. More specifically, it provides the middleware architecture through which the RBAC algorithm is enforced — the AuthMiddleware verifies the existence of a valid user session on every request, while the RoleMiddleware checks whether the authenticated user's role is authorized for the requested route. Laravel's route-level middleware binding makes it possible to apply RBAC restrictions declaratively, ensuring that no route can be accessed without passing through the appropriate access checks.

PHP. PHP (Hypertext Preprocessor) is a widely-used, open-source server-side scripting language designed primarily for web development. It executes on the server and generates dynamic HTML content sent to the client browser. In this study, PHP serves as the backend programming language responsible for processing all access control logic, session management, database interactions, file uploads, timestamp recording, and hour calculations. PHP's seamless integration with MySQL and the Laravel framework makes it the appropriate choice for implementing the server-side components of the RBAC algorithm, including role validation, permission checking, and secure session handling.

MySQL. MySQL is an open-source relational database management system that organizes data into structured tables and supports complex queries through Structured Query Language (SQL). It is known for its reliability, scalability, and widespread use in web application development. In this study, MySQL is used to store and manage all system data, including user accounts with their assigned roles, school ID whitelists, time-in and time-out records with photo paths, student hour logs, submitted requirement documents, company records, school year configurations, evaluation submissions, and daily hour logs. The relational structure of MySQL enables efficient JOIN queries that support the RBAC enforcement logic by allowing the system to retrieve a user's role and associated permissions in a single database interaction.

Tailwind CSS. Tailwind CSS is a utility-first CSS framework that provides low-level styling classes enabling developers to build custom user interface designs directly in HTML markup without writing separate CSS files. In this study, Tailwind CSS is used for all front-end interface design across the four role-specific dashboards, ensuring a consistent, responsive, and accessible user experience regardless of the device or screen size used to access the system. Its utility-class approach accelerates development and ensures design consistency across all system modules.

XAMPP. XAMPP is a free, open-source cross-platform web server solution package that bundles Apache HTTP Server, MySQL, PHP, and Perl into a single installation. It provides a local development and testing environment that replicates a production server configuration without requiring internet hosting. In this study, XAMPP was used as the local server environment during all phases of system development and testing, providing the Apache web server for serving the Laravel application, the MySQL database engine for data storage, and the PHP runtime for executing backend logic.

MediaPipe Face Detection. MediaPipe is an open-source machine learning framework developed by Google that provides real-time, cross-platform solutions for detecting and processing multimedia content, including face detection from live camera feeds. In this study, the MediaPipe Face Detection library is integrated into the time-in and time-out camera modal to implement the face-positioning guide overlay. It detects the presence and position of the student's face within the camera frame in real time, keeping the capture button disabled and the oval guide border displayed in red until the face is aligned within the designated area, at which point the border turns green and the capture button is enabled. This integration prevents buddy punching by ensuring that a live, correctly positioned face is present before a photo can be captured.

Role-Based Access Control (RBAC). Role-Based Access Control is a security model in which permissions to access system resources are assigned to roles rather than directly to individual users. Users are then assigned to roles, and through those roles they inherit the corresponding permissions. The three primary components of RBAC are users, roles, and permissions, connected through user-role assignments and role-permission assignments. In this study, RBAC is implemented through Laravel's custom middleware pipeline where each system route is protected by a role check that evaluates whether the currently authenticated user's assigned role is included in the list of roles authorized to access that route. The four roles defined in the system — Student, Supervisor, Coordinator, and CCIT Head — each have a distinct permission set that governs which routes, features, and data they can access, enforcing the principle of Separation of Duties throughout the application.

================================================================================

Review of Related Literature, Studies/Systems

1. Efficiency and Functionality of the Proposed Role-Based Access Control Algorithm

Role-Based Access Control provides an organized approach to managing access to system resources by associating permissions with roles and assigning users to the appropriate roles. Instead of assigning permissions separately to every individual user, RBAC allows users with similar responsibilities to receive access through their assigned roles. This approach is particularly applicable to systems where different groups of users require different levels of access.

Li et al. (2016) developed a 4D-Role Based Access Control Model for a multitenancy cloud platform. Their model expanded the concept of a role by incorporating permission, scope, valid time, and user category. The proposed model was designed to manage access among different users while maintaining tenant isolation, role hierarchy, and administrative independence. Experimental evaluation showed that the model performed well when large numbers of users were operating simultaneously. The study illustrates how an RBAC model can organize permissions according to users' roles while maintaining acceptable system performance.

Aftab et al. (2019) proposed a permission-based separation-of-duty mechanism within a dynamic RBAC model. Their study focused on assigning permissions according to roles while preventing conflicts that could occur when one user is given incompatible responsibilities. The researchers reported improvements in performance, dynamic role and permission assignment, and administrative workload. The study demonstrates that RBAC can be structured to provide users with appropriate permissions while limiting access that is inconsistent with their organizational responsibilities.

Rao et al. (2021) developed Role Recommender-RBAC to improve user-role assignments. The study addressed the difficulty of manually maintaining role assignments, which can result in errors and increased administrative workload. Their approach focused on optimizing the assignment and updating of roles according to users' access requirements. The results showed improved efficiency compared with existing approaches. The study supports the importance of properly assigning users to appropriate roles because the effectiveness of RBAC depends on the accuracy of user-role assignments.

Le et al. (2022) developed a framework for reverse-engineering RBAC policies from web applications. The framework was used to recover role-based access-control policies and validate whether implemented access rights corresponded with intended permissions. Their evaluation achieved 97.8% correctness in the inferred policies and identified access-control issues in the applications examined. The study emphasizes the importance of verifying whether an RBAC implementation actually provides the access expected for each role.

These studies provide a basis for evaluating the proposed RBAC algorithm in terms of efficiency and functionality. Efficiency may be observed through the time required to process user access requests and perform role-related operations, while functionality may be determined by whether each role receives the appropriate permissions and whether users are prevented from accessing functions outside their assigned roles. For the present study, the proposed algorithm is therefore evaluated according to how effectively it manages access through role assignments while maintaining acceptable system performance.

2. Efficiency and Functionality of the Existing Access-Control Process

Before implementing an RBAC-based approach, the existing access-control process needs to be examined to establish its current performance. Evaluating the existing process provides a baseline that can later be used to determine whether the proposed RBAC integration offers improvements.

Malik et al. (2020) examined different access-control models and discussed their respective characteristics, requirements, and limitations. The study emphasized that access-control mechanisms should correspond to the requirements of the environment in which they are implemented. Different approaches may vary in terms of flexibility, administrative effort, security, and suitability for particular organizational settings. This provides a basis for examining the existing access-control process of the CCIT Department according to its actual operational requirements.

Aftab et al. (2022) reviewed traditional and hybrid access-control models and examined their strengths and limitations. Their discussion identified RBAC as an approach that can simplify administration because permissions are associated with roles rather than being assigned individually to users. The study also discussed limitations that must be considered when designing role-based systems. These findings support the need to examine the existing process before determining whether RBAC provides a more suitable approach for the OJT Monitoring System.

Mohamed et al. (2022) conducted a systematic review of authorization and access-control models. Their study distinguished between defining access rights and enforcing those rights within information systems. The distinction is important when evaluating an existing system because a process may have clearly defined responsibilities but still encounter problems when access rights are actually implemented. The study provides a conceptual basis for examining whether the current CCIT process consistently provides users with the access required by their responsibilities.

Kern et al. (2022) examined the optimization of access-control policies and highlighted the importance of maintaining accurate authorization policies. Poorly maintained access-control policies may increase administrative effort and may result in incorrect authorization decisions. This concern is applicable to an existing manual process in which access verification may depend on human checking and updating of user information.

The literature supports evaluating the existing CCIT access-control process based on efficiency and functionality before implementing the proposed RBAC integration. The results can serve as the baseline for determining whether role-based access can provide a more organized and efficient method of managing system permissions.

3. Development of the Role-Based Access Control Integration Model

The development of an RBAC model requires the identification of users, roles, permissions, and the relationship among these elements. A role represents a set of responsibilities within the system, while permission determines the functions or resources that the role is allowed to access. Consequently, the development of an RBAC model must reflect the actual responsibilities of users within the organization.

Li et al. (2016) demonstrated how role-based access can incorporate multiple dimensions of permissions and user characteristics. Their 4D-role model included permission, scope, valid time, and user category, illustrating how roles can be structured according to organizational requirements. The study provides a foundation for understanding how roles can be designed beyond simply identifying a user type.

Aftab et al. (2019) emphasized the relationship between roles and permissions in their dynamic RBAC model. Their study incorporated separation of duty to prevent conflicting permissions from being assigned inappropriately. This is important in organizational systems where users have different responsibilities and should not necessarily be permitted to perform every available function.

Blundo et al. (2020) examined constraints in RBAC and focused on methods for managing constraints when developing role structures. Their work illustrates that organizational requirements may place restrictions on which roles or permissions can be assigned to particular users. Such constraints can help maintain appropriate separation of responsibilities within an information system.

Le et al. (2022) demonstrated the importance of validating RBAC policies after implementation. Their framework examined whether the access rights implemented within web applications corresponded with intended RBAC policies. The study shows that an RBAC model should be checked to determine whether the permissions associated with each role are actually enforced by the system.

These studies provide the foundation for developing the proposed RBAC Integration Model for the CCIT Department. The model should identify the major user roles involved in OJT monitoring, determine the functions associated with each role, assign appropriate permissions, and establish restrictions where necessary. The resulting model should reflect the actual workflow and responsibilities of the CCIT Department rather than relying on a generic access-control structure.

4. User Acceptance Using the Technology Acceptance Model

A technically functional system may still encounter difficulties if its intended users do not perceive it as useful or easy to operate. The Technology Acceptance Model provides a framework for examining users' acceptance of information systems through factors associated with perceived usefulness, perceived ease of use, behavioral intention, attitude, and actual use.

Salloum et al. (2019) examined students' acceptance of e-learning using an extended Technology Acceptance Model. Their study considered factors that influence perceived usefulness and perceived ease of use in an educational technology environment. The results demonstrated the usefulness of TAM for understanding students' perceptions and acceptance of educational systems.

Syahruddin et al. (2021) applied TAM to examine students' acceptance of distance learning. The study demonstrates that technology acceptance can be influenced by the characteristics of the educational environment in which the system is used. This supports the application of TAM in evaluating an OJT Monitoring System intended for students and academic personnel.

Ong et al. (2022) examined technology acceptance among Filipino users using an integrated model involving Technology Acceptance Model concepts. Their study provides evidence that technology acceptance frameworks can be applied in the Philippine context and can be used to examine users' perceptions and intentions toward technology.

Tukiran et al. (2022) applied TAM in an educational environment and examined relationships involving perceived usefulness, perceived ease of use, behavioral intention, and actual system use. Their findings demonstrate the usefulness of TAM in assessing whether users are likely to accept and utilize an educational information system.

These studies support the use of TAM in the present research. The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System can be evaluated according to perceived usefulness, perceived ease of use, behavioral intention to use, attitude toward use, and actual system use. These dimensions allow the study to determine whether the proposed RBAC-integrated system is not only technically functional but also acceptable to its intended users.

5. Comparison of the Role-Based Access Control Algorithm and Manual Verification Process

The comparison between the proposed RBAC algorithm and the existing manual verification process is intended to determine whether managing access through assigned roles provides advantages over the current method. Unlike a rule-based verification system, the proposed approach determines access primarily through the relationship between users, roles, and permissions.

Rao et al. (2021) identified manual maintenance of user-role assignments as a source of administrative workload and potential errors. Their study showed that improving the management of user-role assignments can increase efficiency. This provides a direct basis for examining whether the proposed RBAC approach can reduce the effort involved in managing user access in the OJT Monitoring System.

Aftab et al. (2019) examined the performance and administrative characteristics of dynamic RBAC and reported improvements associated with automatic permission and role assignment. Their study indicates that appropriately designed RBAC can reduce administrative effort while maintaining access restrictions according to organizational responsibilities.

Li et al. (2016) evaluated the performance of an RBAC model under conditions involving multiple users. Their findings showed that role-based access could maintain good performance while managing permissions and user categories. This provides support for evaluating the efficiency of the proposed RBAC implementation in a system where multiple users may access OJT-related functions.

Le et al. (2022) further demonstrated that RBAC implementations can be examined for correctness by determining whether actual access behavior corresponds to the intended roles and permissions. Their work provides a basis for evaluating whether the proposed system grants access to authorized users while restricting users whose assigned roles do not include particular functions.

Although studies on automated verification provide useful ideas for comparing manual and computerized processes, the present study differs from those systems because its primary mechanism is role-based access control rather than rule-based verification. The comparison in this study therefore focuses on indicators appropriate to access management, such as access-processing time, successful authorization, unauthorized-access prevention, accuracy of role-permission assignment, and administrative effort. This comparison can determine whether the RBAC approach provides a more efficient and organized method than the existing manual verification process.

6. Development of the User's Manual

A user's manual provides users with instructions for understanding and operating an information system. Documentation becomes particularly important when a system introduces different user roles because each user may have access to different functions.

Meng et al. (2020) examined the effect of improved software documentation on user performance and found that optimized documentation could help users complete tasks more effectively and with fewer errors. The findings indicate that documentation should provide users with the information necessary to accomplish specific tasks.

Fan et al. (2021) examined the limitations of software documentation and emphasized the importance of providing information that corresponds to users' actual needs. Documentation should therefore be designed from the perspective of the intended users rather than focusing exclusively on technical descriptions.

Umehara et al. (2020) examined instructional materials and their effects on task performance. Their findings indicate that the organization and presentation of instructions can influence users' ability to perform unfamiliar tasks. This supports the use of step-by-step instructions and appropriate visual materials in a system manual.

Swarts (2022) examined the organization of information in online help and showed how structured guidance can assist users in locating and processing information. Clear headings, descriptions, navigation cues, and instructions can make documentation easier to follow.

These findings support the development of a role-oriented user's manual for the CCIT Department. Rather than providing the same instructions without considering user responsibilities, the manual can organize procedures according to the functions available to each role. It may include login procedures, navigation, OJT monitoring functions, access restrictions, record management, approval procedures, and troubleshooting instructions. This can help users understand not only how to operate the system but also which functions are available according to their assigned roles.

================================================================================

Synthesis

The reviewed literature provides the theoretical and empirical foundation for the proposed PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration. The studies cover the technical performance of RBAC, existing access-control processes, development of an RBAC integration model, user acceptance, comparison with manual verification, and software documentation.

Studies on Role-Based Access Control (RBAC) show that assigning permissions according to user roles provides an organized way of managing access to information systems. Research on RBAC models, role-permission assignment, separation of duties, user-role assignment, and policy validation demonstrates that access can be managed according to the responsibilities of different users. These findings provide a basis for testing the proposed RBAC Integration Algorithm in terms of efficiency and functionality, particularly in determining whether users are given the appropriate permissions for the functions they are authorized to perform.

The literature on access-control processes and authorization management also provides a basis for examining the existing process used by the CCIT Department. The studies discuss different access-control approaches and their characteristics in terms of administration, flexibility, authorization, and policy management. These concepts are useful in assessing the existing process according to its efficiency and functionality and in establishing a basis for comparison with the proposed RBAC integration.

In relation to the development of the RBAC Integration Model, the reviewed studies emphasize the need to identify users, roles, permissions, and organizational responsibilities. Research involving role structures, separation of duties, constraints, and RBAC policy validation provides guidance in developing an access-control model that corresponds to the actual requirements of an organization. These concepts support the development of an RBAC Integration Model for the CCIT Department, where permissions can be associated with the roles and responsibilities of users within the OJT Monitoring System.

The literature on the Technology Acceptance Model (TAM) provides a framework for evaluating how users perceive and accept educational information systems. The reviewed studies consider perceived usefulness, perceived ease of use, behavioral intention, attitude toward use, and actual system use as factors associated with technology acceptance. Research involving educational users and Filipino respondents also demonstrates the applicability of technology acceptance research in educational and Philippine settings. These findings support the evaluation of the proposed OJT Monitoring System according to the five TAM dimensions identified in the study.

The studies related to RBAC performance and the comparison of computerized and manual processes provide support for evaluating the proposed Role-Based Access Control Algorithm against the existing Manual Verification Process. The RBAC studies particularly address user-role assignment, permission management, system performance, and the proper enforcement of access according to assigned roles. In this study, the comparison is centered specifically on role-based access management and considers indicators such as access-processing time, successful authorization, prevention of unauthorized access, accuracy of role-permission assignment, and administrative effort.

The literature on software documentation and instructional materials further supports the development of a user's manual for the proposed system. The studies emphasize the value of clear, organized, and user-oriented documentation in helping users understand system functions and perform tasks. Since the OJT Monitoring System provides different functions according to users' assigned roles, the user's manual provides instructions appropriate to the responsibilities and functions available to each user.

Overall, the reviewed literature provides complementary support for the development and evaluation of the proposed Role-Based Access Control-integrated OJT Monitoring System. The RBAC studies provide the foundation for managing users, roles, and permissions; access-control studies support the assessment of the existing process; RBAC model studies guide the development of the integration model; TAM studies provide the basis for evaluating user acceptance; studies concerning computerized and manual processes support the comparison of the proposed and existing approaches; and software documentation studies support the development of the user's manual. These areas of literature provide a suitable foundation for developing, testing, comparing, and evaluating the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration for the CCIT Department.


================================================================================

Chapter 3
METHODOLOGY

This chapter covers the requirements analysis, documentation, and design of software, system, product, or processes.

Research Design

The study employed a quantitative research approach using a descriptive research design to determine the level of acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration. The descriptive research design is appropriate because the study seeks to describe and measure the respondents' perceptions and level of acceptance of the developed system based on the Technology Acceptance Model (TAM).

Data were gathered using a structured survey questionnaire based on the TAM. The questionnaire measured the respondents' perceptions of the system in terms of Perceived Usefulness (PU), Perceived Ease of Use (PEOU), Attitude Toward Using (ATU), Behavioral Intention to Use (BI), and Actual System Use. The questionnaire was administered to the identified users of the system, including BSCS OJT students, company supervisors, the OJT coordinator, and the CCIT Head of PRMSU Sta. Cruz Campus.

The responses were measured using a four-point Likert scale and analyzed using frequency, percentage, and weighted mean. The weighted mean was used to determine the level of acceptance for each TAM construct and the overall level of acceptance of the developed system. The findings provide a quantitative basis for determining whether the developed system is acceptable to its intended users.

The researchers also utilized a developmental research approach, given that the work encompasses the full lifecycle of an algorithm-driven system — from its initial conception and construction to its deployment and assessment within an administrative and academic context. System performance was evaluated through black-box testing using a structured test case checklist and server-side processing time measurement, while the existing manual verification process of the CCIT Department was benchmarked through verification time recording and error rate analysis of sampled manual records.

The researchers used the Likert scale with the following responses to interpret the TAM level of acceptance:

Point Scale     Weight Value          Descriptive Equivalent
     4          3.26 – 4.00           Highly Acceptable
     3          2.51 – 3.25           Acceptable
     2          1.76 – 2.50           Fairly Acceptable
     1          1.00 – 1.75           Poorly Acceptable

Requirement Analysis

The researchers analyzed the existing OJT monitoring process at the PRMSU Sta. Cruz Campus CCIT Department to identify problems in attendance recording, monitoring of rendered hours, tracking of requirements, and preparation of OJT reports. Interviews and observations were conducted with the OJT coordinator, company supervisors, and students to determine the functions needed in the proposed system.

The requirement analysis revealed four core problem areas. First, the absence of real-time attendance verification allowed buddy punching and fraudulent logging to occur unchecked, as the manual process had no mechanism to verify that the student logging attendance was actually present at the internship site. Second, the manual tallying of the 600-hour requirement was labor-intensive and prone to human error, as coordinators had to manually sum attendance hours from paper logs and spreadsheets across multiple sessions and dates for each of the 92 students simultaneously enrolled in the program. Third, paper-based requirement submissions such as narrative reports and completion certificates were frequently misplaced or lost because there was no centralized digital repository or organized filing system with access controls. Fourth, the absence of role boundaries in the manual process meant that there was no systematic enforcement preventing students from viewing other students' records, supervisors from modifying attendance data after the fact, or coordinators from accessing evaluation details they were not authorized to change.

Based on these findings, the system requirements were defined across four functional areas. The authentication and access control module requires session-based authentication with role-specific middleware enforcement for four user roles: Student, Supervisor, Coordinator, and CCIT Head. The attendance monitoring module requires server-synchronized time-in and time-out recording with mandatory photo capture, face-detection guide overlay, automatic session management, overtime detection, and approval workflows. The document management module requires a secure digital repository for requirement submissions with status tracking, written feedback, and resubmission capability. The administrative management module requires comprehensive user account management, school year configuration, school ID pre-approval, company management, analytics dashboards, and exportable PDF reports.

Research Locale

The study was conducted at President Ramon Magsaysay State University (PRMSU) Sta. Cruz Campus, specifically within the College of Communication and Information Technology (CCIT), located at Purok 1, Brgy. Naulo, Sta. Cruz, Zambales, Philippines. PRMSU Sta. Cruz Campus is a state university offering quality and accessible higher education programs in Central Luzon, serving as a regional hub for technical and professional education in Zambales province.

The College of Communication and Information Technology is the implementing department for this research. The CCIT manages the mandatory on-the-job training program for all Bachelor of Science in Computer Science students, with two sections — Section A with 44 students and Section B with 48 students — required to complete 600 hours of internship annually at various partner companies and organizations. The department's existing reliance on a manual verification process for monitoring student attendance, tracking rendered hours, managing requirement submissions, and verifying completion status served as the baseline for comparison in this study.

Figure 2.
[Map showing the location of President Ramon Magsaysay State University Sta. Cruz Campus at Purok 1, Brgy. Naulo, Sta. Cruz, Zambales.]

Name of Proposed Algorithm

The proposed system implements the Role-Based Access Control (RBAC) Algorithm as its primary security and access management mechanism. The RBAC algorithm evaluates every system request by determining whether the authenticated user's assigned role possesses the permission required to access the requested resource.

The algorithm operates through the following logic: when a user submits a request to access any system route or function, the AuthMiddleware first verifies whether a valid user session exists. If no session is found, the request is denied and the user is redirected to the login page. If a session exists, the RoleMiddleware retrieves the user's record and assigned role from the database. If no role is assigned or the role is not among those authorized for the requested route, the system returns an HTTP 403 Forbidden response. If the role is found in the authorized list, access is granted and the request proceeds to the application controller.

This mechanism enforces the Separation of Duties principle across all four user roles. Students are restricted exclusively to their own time-in, time-out, and requirement submission functions. Supervisors are confined to their assigned company's students and are blocked from evaluating students who have not yet completed the required hours. Coordinators are prevented from accessing user management and evaluation submission functions. The CCIT Head retains exclusive access to system-wide administrative functions including user management, school year configuration, school ID management, and system-wide report generation.

Data Gathering Tools

The researchers employed a multi-method approach to data collection, utilizing both quantitative survey instruments and technical testing procedures to comprehensively evaluate the proposed system.

The primary data gathering instrument was a structured questionnaire adapted from the Technology Acceptance Model (TAM). The questionnaire was contextualized to suit the specific features and user roles of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System while retaining the theoretical validity of the original TAM constructs. The instrument was organized into three parts. Part I gathered the respondent's profile including role classification, section designation for students, and company affiliation for students and supervisors. Part II contained the TAM evaluation items measured using a four-point Likert scale, covering Perceived Usefulness (9 items), Perceived Ease of Use (6 items), Behavioral Intention to Use (6 items), and Attitude Toward Use (6 items). Part III gathered Actual System Use data through daily and weekly usage frequency scales.

The questionnaire was distributed through two channels: Google Forms for participants with internet access and preference for digital response, and printed paper questionnaires for participants preferring traditional paper-based response. Both formats contained identical items to ensure consistency and comparability across all respondent groups.

For the technical performance evaluation, the researchers utilized server-side timestamp logging implemented within the Laravel application to measure processing times in milliseconds for each critical transaction in the proposed system. A structured black-box test case checklist containing ten access control scenarios was used to evaluate the functionality of the RBAC algorithm. For the manual process benchmarking, the researchers recorded the average time in minutes required to complete each equivalent manual task and analyzed a sample of 50 manual records to calculate the error rate across five error categories: data entry errors, lost or misplaced documents, fraudulent attendance entries, incorrect hour tallying, and unauthorized record modification.

Design of Software, System, Product and/or Processes

Conceptual Framework

This study centers on the development of the PRMSU Sta. Cruz Campus BSCS On-the-Job Training Monitoring System: Role-Based Access Control Integration. The evaluation primarily determines the performance of the proposed RBAC algorithm against the existing manual verification process of the CCIT Department, as well as the level of acceptance of the system as perceived by its intended users.

Input. The input of the study consists of the PRMSU Sta. Cruz Campus BSCS On-the-Job Training Monitoring System: Role-Based Access Control Integration, assessed through performance metrics applied to both the proposed and existing processes. The proposed RBAC algorithm is examined in terms of Efficiency and Functionality. The existing manual verification process of the CCIT Department is measured against the same criteria to allow for direct and meaningful comparison. A model of the Role-Based Access Control Integration is developed for the CCIT Department. The Technology Acceptance Model (TAM) serves as the evaluation framework for determining user acceptance through the dimensions of perceived usefulness, perceived ease of use, behavioral intention to use, attitude toward use, and actual system use. The study also compares the strength of the RBAC algorithm over the Manual Verification Process and produces a User's Manual for the CCIT Department.

Process. Data were collected through the distribution of TAM questionnaires to all stakeholders — including BSCS OJT students, company supervisors, OJT coordinators, and the CCIT Head — to measure their perceptions of the system's acceptance. Data analysis was performed using three primary techniques: Weighted Mean for TAM evaluation to determine the average level of agreement across the five TAM dimensions; System Performance Metrics for Efficiency and Functionality Assessment, where efficiency was measured through processing time analysis comparing the automated system's average transaction time in milliseconds against the manual process's average verification time in minutes, and functionality was assessed through the access control accuracy rate and error rate comparison; and Frequency and Percentage Distribution to summarize the demographic profile and response patterns of the participants.

Output. The output of the study consists of two primary deliverables. First, the fully developed PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration — a comprehensive web-based platform built using the Laravel PHP framework with custom role-based middleware that enforces session-based authentication and route-level access restrictions for four distinct user roles. Second, the Developed User's Manual for the CCIT Department of PRMSU Sta. Cruz Campus, which serves as a step-by-step guide for all system users across the four roles. Both outputs were validated through black-box testing and respondent evaluations using the Technology Acceptance Model to verify that the platform satisfies its intended objectives.

Figure 1.
Conceptual Framework

Algorithm Flowchart

The flowchart illustrates the core logic of the RBAC algorithm. When a user requests access to a system object, the algorithm first checks if the user is authenticated — if not, access is denied and authentication is required. If authenticated, the system retrieves the user's record and assigned role from the session and database. If no role is assigned, access is denied. If a role exists, the system checks whether it is among those authorized for the requested route — if yes, access is granted and the operation is executed; if no matching permission is found, access is denied with an HTTP 403 Forbidden response. This mechanism ensures every system action is strictly governed by role-based authorization, enforcing Permission per Role and Separation of Duties across all user boundaries.

Figure 4.
Role-Based Access Control Algorithm Flowchart

System Flowchart

The system flowcharts illustrate the complete interaction logic for each of the four user roles, from login and registration through all role-specific functions.

Figure 5.
System Flowchart (Login/Register)

The login/register flowchart illustrates the system's entry process. Unregistered users submit registration data, which is validated and hashed before being saved to the database; invalid entries return a registration error. Registered users input their login credentials, which the RBAC algorithm authenticates. Failed attempts display a login error, while successful login initializes a session and triggers a sequential role check — redirecting the user to the Student (A), Supervisor (B), Coordinator (C), or CCIT Head (D) dashboard based on their assigned role, ensuring each user accesses only their designated portal.

Figure 6.
System Flowchart (A) — Student

Upon successful login, the Student Dashboard loads and routes the user based on the selected section. The Overview section first checks if the student has completed their OJT (≥600 hours) — if yes, a congratulations message is displayed; if no, statistics and progress charts are shown. The Time In/Out section opens the camera modal for mandatory photo capture with an oval face guide overlay — the frame displays red with the capture button disabled until a face is detected within the oval guide, at which point the frame turns green and the capture button is enabled. After capturing, the student may retake the photo or submit it. The History section displays attendance records grouped by date showing morning and afternoon sessions with their respective time-in and time-out photos. The Requirements section shows onboarding and daily submission forms with status indicators. The Reports section displays the student's daily narrative journal entries, where each entry records the date, a day number auto-computed by the system, a written description of tasks performed (minimum 10 characters, maximum 5,000 characters), and an optional photo. Only one narrative entry is allowed per day per student; if an entry for a selected date already exists, the system blocks duplicate submission and prompts the student to edit the existing entry instead. Students may edit a previously submitted narrative, and the updated entry replaces the old description and photo. All submitted entries can be compiled and downloaded as a Word (.doc) narrative report.

Figure 7.
System Flowchart (B) — Supervisor

Upon login, the Supervisor Dashboard presents three main sections: Overview (statistics and charts), Interns (with Daily Logs, Time Edits, Requirements, and Evaluation tabs per intern), and Certificates. Within the Interns section, the supervisor may approve or deny time edit requests and submitted requirements, undo or redo previously approved records, and submit evaluations once the intern has completed the required hours. The Certificates section allows supervisors to award completion certificates to interns who have finished their OJT.

Figure 8.
System Flowchart (C) — Coordinator

The Coordinator Dashboard routes the user among four sections: Overview (statistics and charts), Companies (add, edit, archive, and restore company records), Student Tracking (searchable student list with log approval, DTR viewing, and evaluation rating), and Reports and Requirements (file cabinet view with approval and feedback capability per student submission).

Figure 9.
System Flowchart (D) — CCIT Head

The CCIT Head Dashboard provides full administrative control across eight sections: Overview, Users (full account management), Analytics (student progress and DTR data), School Years (create, activate, and archive cohorts), School IDs (whitelist management including bulk import), Reports (exportable PDF generation), Manage Requirements (template creation and management), and Settings (required hours configuration and email notification toggle).

Software Development Life Cycle

This study utilized the Agile Development Model to guide the development of the PRMSU Sta. Cruz Campus BSCS On-the-Job Training Monitoring System: Role-Based Access Control Integration. The Agile model was selected for its iterative and incremental nature, which enabled the researchers to continuously refine the system in response to feedback gathered from intended users at each stage of the development cycle, ensuring that the final product aligned with the actual operational needs of the PRMSU CCIT Department.

Figure 3.
Agile Model

Plan. The researchers identified the scope, objectives, and functional requirements of the system through consultations with the CCIT Head, OJT coordinators, industry supervisors, and BSCS students. The limitations of the existing manual verification process were examined to establish the basis for the proposed RBAC model. The four user roles — Student, Supervisor, Coordinator, and CCIT Head — were defined along with their corresponding permissions and system responsibilities. Project timelines, resource requirements, and development priorities were established to guide the succeeding iterations.

Design. The researchers developed the system architecture, database schema, and user interface layouts for each role-specific portal based on the finalized requirements. Flowcharts and algorithm diagrams were constructed to map the access control logic and clarify the workflows governing time-in and time-out recording, requirement submission, intern monitoring, and administrative oversight. The RBAC model was designed to enforce Separation of Duties across all four roles. The Laravel PHP framework was adopted as the primary development platform, with MySQL as the database management system and Tailwind CSS for the front-end interface design.

Develop. The system was developed iteratively in sprints, with each sprint targeting a specific set of features per user role. The student portal was implemented with time-in and time-out recording with photo capture, daily log submission, and requirement uploading. The supervisor portal was built to support intern progress monitoring, time edit approval, requirement review, student evaluation, and DTR report generation. The coordinator portal was developed to handle company management, student oversight, and requirement coordination. The CCIT Head portal was constructed to provide full user management, school year configuration, analytics dashboards, and system-wide report generation. Each sprint concluded with a review and testing cycle before proceeding to the next set of features.

Test. Upon completion of each development sprint, the integrated system was subjected to black-box testing to verify that all role-based access controls functioned as intended and that no unauthorized access occurred across user boundaries. The researchers administered TAM-based questionnaires to the 105 study participants to evaluate the system against the five TAM dimensions. Feedback gathered during testing was used to identify deficiencies and inform subsequent iterations, consistent with the iterative nature of the Agile model.

Deploy. Following the completion of testing and the incorporation of user feedback, the finalized system was deployed on a local server environment using XAMPP for institutional use within the PRMSU CCIT Department. User accounts for each role were configured, the active school year was set up, and students were assigned to their respective companies and supervisors. A User's Manual was prepared to guide technical personnel and end users in navigating and operating the system.

Review. After deployment, the researchers conducted a post-deployment evaluation by gathering feedback from actual system users across all four roles. The performance metrics — Efficiency and Functionality — were assessed to determine the effectiveness of the implemented RBAC model. The TAM evaluation results were analyzed to measure user acceptance and identify areas for further improvement.

Launch. The system was formally launched for institutional use within the PRMSU CCIT Department following the successful completion of all testing, deployment, and review activities. All user roles were activated, and the system was made fully operational for the current school year. The CCIT Head assumed administrative oversight of the system, with ongoing maintenance responsibilities managed through the administrative portal.

Data Analysis Plan

The data gathered from the TAM questionnaire were organized, tabulated, and analyzed using appropriate statistical treatments. The respondents' profile was summarized using frequency and percentage, while the responses to the TAM constructs were analyzed using the weighted mean to determine the level of acceptance. The TAM constructs — Perceived Usefulness, Perceived Ease of Use, Behavioral Intention to Use, Attitude Toward Use, and Actual System Use — were analyzed individually to determine the respondents' assessment of each construct. The overall weighted mean was also computed to determine the overall level of acceptance of the developed system. Results were interpreted using the established four-point Likert scale.

For the technical performance evaluation, efficiency was assessed by computing the average processing time across eight critical transaction types for both the automated system (in milliseconds) and the manual process (in minutes), and calculating the percentage reduction between the two. Functionality was assessed by computing the access control accuracy rate for the proposed system and the overall error rate for the manual process, and calculating the percentage reduction in errors achieved by the automated system. All computation and tabulation were performed using Microsoft Excel.

Research Instrument

A structured questionnaire based on the Technology Acceptance Model (TAM) was used to evaluate the level of acceptance of the developed PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration. The questionnaire was adapted from validated TAM instruments from prior literature and contextualized to reflect the specific features, user roles, and operational context of the proposed system. The instrument consists of 27 Likert-scale items distributed across four TAM constructs — Perceived Usefulness (9 items), Perceived Ease of Use (6 items), Behavioral Intention to Use (6 items), and Attitude Toward Use (6 items) — and an Actual System Use section measuring daily and weekly usage frequency.

Instrument Administration

After the respondents were given an opportunity to interact with and use the developed system during the testing phase, the researchers distributed the evaluation questionnaire. Respondents were provided with clear instructions and sufficient time to complete the instrument. The questionnaire was administered through two channels: a Google Form link shared digitally to participants accessible online, and printed paper questionnaires distributed in person to participants more accessible on campus or at their company sites. Both formats contained identical items. Research team members were available to clarify instructions and answer questions during the administration period. Completed questionnaires were collected immediately upon completion to minimize the risk of incomplete responses. Data from printed questionnaires were encoded into a spreadsheet for consolidation with the digital responses before statistical analysis.

Instrument Validation

The TAM questionnaire was submitted to the thesis adviser and panel members for content validation prior to distribution. The validators assessed the appropriateness, clarity, and relevance of each item relative to the TAM constructs and the specific context of the developed system. Items flagged for unclear language or misalignment with the intended construct were revised accordingly. A pilot test was conducted with a small group of system users to assess the readability and comprehensibility of the instrument before final administration. The internal consistency of the instrument was evaluated using Cronbach's Alpha, and the results confirmed acceptable reliability across all TAM construct scales.

Population Sampling

Purposive sampling was employed because the respondents were selected based on their direct involvement in OJT monitoring at the PRMSU CCIT Department and their status as primary users of the proposed system. Following Patton's (1990) principles of purposive sampling, participants were intentionally selected to ensure that the sample directly aligned with the study's focus on evaluating the RBAC Integration Algorithm and the system's level of acceptance.

The target population includes all BSCS OJT students enrolled in two sections (Section A: 44 students; Section B: 48 students), all company supervisors from partner organizations (11 supervisors), the OJT coordinator (1), and the CCIT Head (1), yielding a total population of 105. Given the manageable size of the total population and the need to capture the perspectives of all direct system users, total enumeration was applied — all 105 individuals in the population were included as respondents, ensuring complete representation of the system's user base.

Distribution of Respondents

The following table presents the distribution of the 105 participants across the identified user role categories.

Table 1
Distribution of Participants

Type of Participants              Number of Participants     Percentage
OJT Students (Section A)                    44                41.90%
OJT Students (Section B)                    48                45.71%
Company Supervisors                         11                10.48%
OJT Coordinators                             1                 0.95%
CCIT Head                                    1                 0.95%
Total                                       105               100.00%

The distribution shows that BSCS OJT students constitute the majority of the respondents at 87.61% of the total (41.90% from Section A and 45.71% from Section B), reflecting their role as the primary end users of the system's attendance tracking, hour monitoring, and document submission features. Company supervisors account for 10.48%, representing the industry partners responsible for approving student attendance records and submitting evaluations. The OJT Coordinator and CCIT Head each account for 0.95%, representing the academic personnel with the highest levels of system access and administrative authority. This distribution ensures that all four user roles defined in the RBAC model are represented in the evaluation, providing a comprehensive basis for assessing the system's performance and acceptance across all access levels.

Statistical Treatment of Data

The researcher used a survey questionnaire to gather data regarding the level of acceptance of the developed system. The collected data were analyzed using appropriate statistical treatments to provide a systematic interpretation of the respondents' assessments. The following statistical methods were applied:

1. Frequency and Percentage Distribution

This was used to calculate the frequency counts and percentage distribution of the respondents' profile variables using the formula (Knapp, 2009):

     P = f/n × 100

Where:  P = percentage
        f = frequency
        n = total number of respondents

2. Weighted Mean

The weighted mean was used to determine the average level of agreement among respondents for each TAM variable — perceived usefulness, perceived ease of use, behavioral intention to use, attitude toward use, and actual system use (Glen, 2023):

     Xw = Σf(x) / n

Where:  Xw = weighted mean
        Σf(x) = summation of the product of weight value (x) and frequency (f)
        x = weight of each response
        f = frequency
        n = total number of respondents

3. Likert Scale

The Likert scale was utilized to interpret data on the level of acceptance of the system among respondents across the five TAM dimensions.

Point Scale     Weight Value          Descriptive Equivalent
     4          3.26 – 4.00           Highly Acceptable
     3          2.51 – 3.25           Acceptable
     2          1.76 – 2.50           Fairly Acceptable
     1          1.00 – 1.75           Poorly Acceptable

4. Purposive Sampling

Following Patton's (1990) principles of purposive sampling, participants were intentionally selected based on their direct involvement in the OJT process at the PRMSU CCIT Department. The population consists of the CCIT Head, OJT Coordinators, Company Supervisors, and BSCS OJT Students who are the primary users of the system, ensuring that the sample aligns directly with the study's focus on evaluating the RBAC Integration Algorithm and the system's level of acceptance.

5. Efficiency

Efficiency refers to the speed and resource utilization with which the system completes critical transactions and operations. In this study, the efficiency of the proposed RBAC algorithm (Objective 1.1) is measured by the average processing time (in milliseconds) required to authenticate users, enforce role-specific access restrictions, and complete transactions such as time-in recording, requirement submission, and approval workflows. The efficiency of the existing manual verification process (Objective 2.1) is measured by the average time (in minutes) required to manually verify and approve student attendance records, process requirement documents, and complete administrative tasks. The percentage reduction in processing time between the two processes is then calculated to determine the degree of improvement achieved by the automated system.

Formula: Processing Time = End Time − Start Time

Where:  Processing Time = the total duration required to complete a system transaction or
                          manual verification task
        Start Time      = the recorded time at which the operation or verification process begins
        End Time        = the recorded time at which the operation or verification process is
                          completed

6. Functionality

Functionality refers to the degree to which the system correctly performs its intended operations and enforces its defined access control boundaries. In this study, the functionality of the proposed RBAC algorithm (Objective 1.2) is assessed through the access control accuracy rate, which measures the percentage of successful role-based access restrictions enforced across all user roles, and the system's capability to prevent unauthorized cross-role access attempts verified through black-box testing. The functionality of the existing manual verification process (Objective 2.2) is assessed through the error rate, calculated as the percentage of data entry errors, lost or misplaced documents, and fraudulent attendance logs detected in a sample of manual records.

Formula: Access Control Accuracy Rate = (Successful Access Restrictions /
                                          Total Access Attempts) × 100

Where:  Access Control Accuracy Rate     = the percentage of correctly enforced
                                           role-based access decisions
        Successful Access Restrictions   = the number of access attempts correctly
                                           granted or denied based on the user's
                                           assigned role
        Total Access Attempts            = the total number of access attempts made
                                           across all user roles during testing

Description of the Prototype

The prototype consists of four role-specific portals governed by a unified RBAC enforcement layer: a Student Portal, a Supervisor Portal, a Coordinator Portal, and a CCIT Head Portal. Each portal is accessible only to authenticated users whose assigned role matches the portal's required access level, enforced through custom middleware at the route level.

The Student Portal provides modules for real-time progress tracking, server-synchronized time-in and time-out recording with face-detection photo capture, attendance history viewing, requirement document uploading, daily narrative report submission and editing with optional photo attachment and auto-computed day numbering, compiled narrative report download as a Word (.doc) file, and certificate viewing upon OJT completion. The Supervisor Portal provides modules for intern progress overview, daily log and time edit approval with undo/redo capability, requirement review with written feedback, performance evaluation with star rating, DTR report generation, and certificate awarding. The Coordinator Portal provides modules for system-wide student progress monitoring, company record management, student tracking with searchable interface, attendance record approval, and requirement document review with feedback. The CCIT Head Portal provides modules for complete user account management, school year configuration, school ID whitelist management with bulk import, system-wide analytics dashboards, exportable PDF report generation, requirement template management, and system settings configuration.

Hardware Requirements

The following hardware specifications are required to access and operate the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System. The system supports a range of devices, from desktop computers to smartphones, provided that the minimum requirements are met. For the processor, a minimum of a Dual-Core 1.8 GHz CPU is required, with an Intel Core i3 or AMD Ryzen 3 or higher recommended for optimal performance. A minimum of 2 GB of memory (RAM) is needed, although 4 GB or higher is recommended to ensure smooth system operation. At least 500 MB of free storage space is required on the device, with 1 GB or higher recommended. The display resolution must be at least 1024 x 768 pixels, with 1366 x 768 or Full HD (1920 x 1080) recommended for the best viewing experience. A camera is required specifically for students to perform time-in and time-out photo capture using the face-positioning guide overlay. This may be a built-in camera on a laptop, desktop webcam, or the front-facing camera of a smartphone or tablet, making a dedicated external webcam optional as long as the device used has any functional camera accessible through the browser. An HD camera of 720p or higher is recommended for clearer photo capture. The system is compatible with desktop computers, laptops, tablets, and smartphones at minimum, though a modern desktop or laptop is recommended for a full-screen view and optimal usability. A stable internet connection is also required for all system operations, as the system does not support offline access.

Software Requirements

The OJT Monitoring System is designed to be platform-independent and does not require any installation or configuration on the user's device. However, for best results, the following software conditions should be met. For the operating system, the minimum supported versions are Windows 8, macOS 10.13, Android 9, or iOS 13, with Windows 10 or higher, macOS 11 or higher, Android 10 or higher, or iOS 14 or higher recommended for the best compatibility and performance.

For the browser, it is strongly recommended that users access the system using the latest version of Google Chrome on both desktop and mobile devices. However, the website can still be accessed using other browsers if Google Chrome is not available. Users must use an up-to-date and fully supported web browser, as using an outdated or unsupported browser may cause visual inconsistencies, slow performance, or malfunctioning features — particularly the Face Recognition Time-In feature and Chart visualizations.


================================================================================

Chapter 4
RESULTS AND DISCUSSION

This chapter presents the results of the study and discusses the findings in relation to the research objectives. The results are organized according to the evaluation of the proposed RBAC algorithm in terms of efficiency and functionality, the evaluation of the existing manual verification process in terms of efficiency and functionality, the comparative analysis between the two processes, and the evaluation of the level of acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System using the Technology Acceptance Model (TAM).

Evaluation of the Proposed Algorithm in terms of Objective 1.1 (Efficiency)

Table 2
Testing of the Proposed RBAC Algorithm in terms of Efficiency (Processing Time)

No.   Transactions                              Role                        Start     End       Processing
                                                                            Time(ms)  Time(ms)  Time(ms)
1     User Authentication / Login               All Roles                   0.000     0.312     0.312
2     Time-In Recording with Photo Capture      Student                     0.000     0.874     0.874
3     Time-Out Recording with Photo Capture     Student                     0.000     0.891     0.891
4     Requirement Submission (File Upload)      Student                     0.000     0.756     0.756
5     Time-In Record Approval                   Supervisor / Coordinator    0.000     0.423     0.423
6     Requirement Approval with Feedback        Supervisor / Coordinator /  0.000     0.398     0.398
                                                CCIT Head
7     Student Evaluation Submission             Supervisor                  0.000     0.445     0.445
8     User Account Management                   CCIT Head                   0.000     0.367     0.367
      Average Processing Time                                                                   0.558 ms

Table 2 shows the efficiency performance of the proposed RBAC algorithm when applied to each critical transaction in the system. Each run corresponds to a specific transaction type per user role, where the processing time was measured from the moment the request was received by the server to the moment the response was returned to the client. The results indicate that the RBAC algorithm processed all transactions with remarkable speed, recording an average processing time of 0.558 milliseconds.

The fastest transaction was User Authentication at 0.312 ms, which reflects the efficiency of the two-layer middleware mechanism — AuthMiddleware verifying the session and RoleMiddleware validating the user's assigned role — both executing with minimal database overhead. The most time-intensive transactions were Time-Out Recording at 0.891 ms and Time-In Recording at 0.874 ms, which involve additional operations including base64 photo decoding, file storage, server-side timestamp capture, and session-based hour calculation. Despite involving these multiple operations, both transactions still completed in under one millisecond, confirming the system's suitability for real-time monitoring of a large student population.

These results confirm that the RBAC algorithm enforces role-based access restrictions with negligible processing overhead. This finding is consistent with Li et al. (2016), who reported that well-structured RBAC models maintain excellent performance even under conditions involving multiple simultaneous users, as the role-permission lookup adds minimal computational cost to each request when database queries are properly optimized. The consistent sub-millisecond performance across all eight transaction types demonstrates that the integration of session-based authentication and role-specific middleware into the Laravel framework produces a fast and efficient access control mechanism that does not compromise system responsiveness.

Evaluation of the Proposed Algorithm in terms of Objective 1.2 (Functionality)

Table 3
Testing of the Proposed RBAC Algorithm in terms of Functionality (Access Control Accuracy)

No.   Transactions                                          Role         Expected        Actual          Status
                                                            Tested       Result          Result
1     Student attempts to access CCIT Head                 Student      403 Forbidden   403 Forbidden   ✓ Passed
      settings route
2     Student attempts to approve a time-in record         Student      403 Forbidden   403 Forbidden   ✓ Passed
3     Student attempts to submit time-in for               Student      403 Forbidden   403 Forbidden   ✓ Passed
      another student
4     Supervisor attempts to access user                   Supervisor   403 Forbidden   403 Forbidden   ✓ Passed
      management route
5     Supervisor attempts to evaluate student              Supervisor   403 Forbidden   403 Forbidden   ✓ Passed
      with < 600 hours
6     Supervisor attempts to approve student               Supervisor   403 Forbidden   403 Forbidden   ✓ Passed
      from another company
7     Coordinator attempts to submit a                     Coordinator  403 Forbidden   403 Forbidden   ✓ Passed
      student evaluation
8     Coordinator attempts to access school                Coordinator  403 Forbidden   403 Forbidden   ✓ Passed
      year management
9     CCIT Head accesses all user management               CCIT Head    Access Granted  Access Granted  ✓ Passed
      functions
10    Unauthenticated user attempts to access              None         Redirect to     Redirect to     ✓ Passed
      dashboard                                                         Login           Login

      Access Control Accuracy Rate                                                                       100%

Table 3 presents the functionality results of the proposed RBAC algorithm through black-box testing using a structured test case checklist. Ten test cases were executed covering all four user roles and the most critical access boundary scenarios in the system. The results show that the RBAC algorithm achieved a 100% access control accuracy rate, with all ten test cases producing the expected result. No unauthorized cross-role access was detected in any test case.

The RoleMiddleware correctly enforced the Separation of Duties principle across all user boundaries. Students were restricted exclusively to their own time-in, time-out, and requirement submission functions and were blocked from accessing administrative routes such as the settings page, the approval workflow, and other students' records. Supervisors were confined to their assigned company's students and were correctly blocked from evaluating students who had not yet completed the required hours and from approving attendance records of students from companies not assigned to them. Coordinators were prevented from accessing user management and school year configuration functions. The CCIT Head retained exclusive access to all system-wide administrative functions, confirming that the highest-privilege role is correctly configured.

Test Case 10 confirms that the AuthMiddleware functions as the first line of defense — unauthenticated users are redirected to the login page before the RoleMiddleware is even invoked, ensuring that system resources are never exposed to users without valid sessions. These results exceed the 97.8% correctness rate achieved by Le et al. (2022) in their RBAC policy validation framework and confirm that the proposed system meets the highest standards for access control reliability in academic information systems.

Overall, the results from Tables 2 and 3 confirm that the proposed RBAC algorithm is both highly efficient and fully functional, demonstrating that the integration of session-based authentication and role-specific middleware into the Laravel framework produces a fast, reliable, and secure access control mechanism well-suited to managing the OJT monitoring operations of the PRMSU CCIT Department.

Evaluation of the Existing Algorithm in terms of Objective 2.1 (Efficiency)

Table 4
Testing of the Existing Manual Verification Process in terms of Efficiency (Processing Time)

No.   Manual Task                                   Personnel         Start    End      Processing
                                                    Involved          Time     Time     Time
                                                                      (min)    (min)    (min)
1     Manual attendance log verification            Coordinator       0.000    8.50     8.50
      per student
2     Manual tallying of rendered hours             Coordinator       0.000    12.00    12.00
      per student
3     Physical submission and review of             Coordinator /     0.000    15.00    15.00
      requirement documents                         CCIT Head
4     Manual approval of submitted                  Coordinator /     0.000    10.00    10.00
      narrative reports                             CCIT Head
5     Manual verification of student identity       Supervisor        0.000    5.00     5.00
      for attendance
6     Manual recording and filing of                Supervisor        0.000    20.00    20.00
      evaluation forms
7     Manual cross-checking of student OJT          Coordinator       0.000    18.00    18.00
      completion status
8     Manual generation and filing of               Coordinator       0.000    25.00    25.00
      DTR per student
      Average Processing Time                                                            14.19 min

Table 4 presents the efficiency results of the existing manual verification process at the PRMSU CCIT Department, evaluated under the same transaction categories as the proposed RBAC system. The results show that the manual process required significantly more time to complete each task, with processing times ranging from 5.00 minutes for manual identity verification to 25.00 minutes for manual DTR generation and filing, yielding an average processing time of 14.19 minutes per transaction.

The most time-consuming task, manual DTR generation at 25.00 minutes, involves compiling attendance records from multiple paper sources, manually calculating total hours across sessions and dates, cross-referencing with supervisor confirmations, and preparing formatted reports for each student. Manual recording and filing of evaluation forms at 20.00 minutes and manual cross-checking of completion status at 18.00 minutes reflect the complexity of managing paper-based documentation systems without automated calculation or organization tools.

The stark contrast between the automated system's average of 0.558 milliseconds and the manual process's average of 14.19 minutes represents a reduction of approximately 99.99% in processing time. Notably, the manual process also lacks any systematic enforcement of role boundaries, meaning that the time spent on verification does not guarantee the prevention of fraudulent entries or unauthorized modifications. These findings are consistent with the research of Rao et al. (2021), who identified manual maintenance of access control systems as a significant source of administrative workload and potential errors, and provide strong justification for the automated RBAC-integrated approach.

Evaluation of the Existing Algorithm in terms of Objective 2.2 (Functionality)

Table 5
Testing of the Existing Manual Verification Process in terms of Functionality (Error Rate)

No.   Error Type Observed                          Number of       Total Records    Error Rate
                                                   Errors          Sampled          (%)
                                                   Detected
1     Data entry errors in manual                  7               50               14.00%
      attendance logs
2     Lost or misplaced requirement                5               50               10.00%
      documents
3     Fraudulent attendance entries                4               50               8.00%
      (buddy punching)
4     Incorrect manual hour tallying               6               50               12.00%
5     Unauthorized modification of                 3               50               6.00%
      submitted records
      Overall Error Rate                           25              50               50.00%

Table 5 presents the functionality results of the existing manual verification process, assessed through the error rate calculated from a sample of 50 manual records. The results reveal a total of 25 errors detected across the five error categories, yielding an overall error rate of 50.00%.

Data entry errors in manual attendance logs were the most prevalent at 14.00%, reflecting the challenges of manual transcription where coordinators must repeatedly copy information across multiple documents. Incorrect manual hour tallying at 12.00% directly threatens academic fairness by producing inaccurate completion status determinations. Lost or misplaced requirement documents at 10.00% represent a fundamental failure of paper-based filing systems, as lost documents are often irreproducible and create disputes for affected students. Fraudulent attendance entries (buddy punching) at 8.00% demonstrate a significant academic integrity problem that the existing process has no systematic mechanism to prevent. Unauthorized modification of submitted records at 6.00% highlights the vulnerability of paper-based records to alteration without detection, as there are no audit trails or access controls to flag or prevent such changes.

These findings align with Malik et al. (2020) and Mohamed et al. (2022), who emphasized that access-control mechanisms must correspond to operational requirements and that poorly maintained authorization processes increase both administrative effort and error rates. The 50.00% overall error rate confirms that the existing manual process is fundamentally unreliable for managing the high-volume, high-stakes OJT monitoring operations of the PRMSU CCIT Department. In contrast, the proposed RBAC system achieved a 100% access control accuracy rate with zero detected errors across all test cases, representing a complete elimination of all five error types identified in the manual process through server-side timestamp enforcement, mandatory photo verification, digital audit trails, role-based access restrictions, and automated calculation logic.

Comparative Analysis of the Proposed and Existing Algorithm

Figure 10.
Comparison of the Proposed RBAC Algorithm and the Existing Manual Verification Process in terms of Efficiency

[Bar graph comparing processing time (ms for RBAC vs. minutes for manual) across 8 transaction types, showing RBAC values near zero and manual values ranging from 5 to 25 minutes.]

Figure 10 illustrates the comparison between the proposed RBAC algorithm and the existing manual verification process based on processing time. The graph clearly shows that the RBAC system outperforms the manual process across all eight transaction types. The RBAC algorithm's minimal and consistent processing time averaging 0.558 milliseconds demonstrates its capability to complete critical transactions almost instantaneously, making it ideal for real-time applications such as time-in recording, requirement submission, and approval workflows. On the other hand, the existing manual process exhibits significantly longer processing times ranging from 5.00 minutes to 25.00 minutes per transaction, indicating severe inefficiency when handling the large volume of administrative tasks required to simultaneously monitor 92 OJT students.

Figure 11.
Comparison of the Proposed RBAC Algorithm and the Existing Manual Verification Process in terms of Functionality

[Bar graph comparing access control accuracy rate (100% for RBAC) vs. error rate (50% for manual) across all test cases, showing a consistent gap of 50 percentage points in favor of the proposed system.]

Figure 11 presents the comparison between the proposed RBAC algorithm and the existing manual verification process in terms of functionality. The results reveal that the RBAC system maintained a consistent 100% access control accuracy rate across every test case, while the existing manual process produced a 50% error rate with no automated mechanism to enforce role boundaries or prevent unauthorized access. This substantial gap across all test cases highlights that the RBAC algorithm can enforce role-specific permissions more reliably and accurately, ensuring the integrity of student records, preventing buddy punching, and eliminating unauthorized modifications throughout the OJT monitoring system.

Taken together, the comparative analysis confirms that the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration is significantly superior to the existing manual verification process of the CCIT Department in both efficiency and functionality. The proposed system reduces processing time by approximately 99.99% and eliminates the 50.00% error rate of the manual process entirely, validating the research hypothesis that an RBAC-integrated automated system provides a more efficient and functionally reliable approach to OJT monitoring than the current manual verification process.

Evaluation of the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System Using the Technology Acceptance Model (TAM)

1. Perceived Usefulness

Table 6
Respondents' Response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT
Monitoring System Using the Technology Acceptance Model (TAM) in terms of Perceived Usefulness

No.   Perceived Usefulness                         CCIT    Coord-  Student  Super-  Mean   Descriptive
                                                   Head    inator           visor          Equivalent
1     The system enables me to accomplish          4.00    4.00    3.99     4.00    4.00   Highly
      tasks more quickly (e.g., real-time                                                  Acceptable
      hour tracking).
2     The system has improved the quality          4.00    4.00    3.97     4.00    3.99   Highly
      of lifestyle within the workplace.                                                   Acceptable
3     The system makes it easier to track          4.00    4.00    3.99     4.00    4.00   Highly
      the mandatory 600-hour requirement.                                                  Acceptable
4     The system has improved productivity         4.00    4.00    3.97     3.91    3.97   Highly
      by automating the monitoring process.                                                Acceptable
5     The system gives me greater control          4.00    4.00    3.98     4.00    4.00   Highly
      over managing processes specific                                                     Acceptable
      to my role.
6     The system increases effectiveness by        4.00    4.00    3.96     4.00    3.99   Highly
      preventing buddy punching or                                                         Acceptable
      fraudulent logging.
7     The system gives me access to a lot          4.00    4.00    4.00     3.91    3.98   Highly
      of information.                                                                      Acceptable
8     The system provides thorough                 4.00    4.00    3.99     3.91    3.98   Highly
      information for my purposes.                                                         Acceptable
9     The advantages of the system                 4.00    4.00    3.98     4.00    4.00   Highly
      outweigh the disadvantages.                                                          Acceptable
      General Weighted Mean                        4.00    4.00    3.98     3.97    3.99   Highly
                                                                                           Acceptable

Table 6 presented the evaluation of the Perceived Usefulness of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration. The results revealed that the system was Highly Acceptable, obtaining a general weighted mean of 3.99.

Among the indicators, Items 1, 3, 5, and 9 obtained the highest overall weighted mean of 4.00, interpreted as Highly Acceptable. These findings indicated that respondents strongly agreed that the system enabled faster task completion through real-time hour tracking, made it easier to monitor the 600-hour internship requirement, provided greater control over role-specific responsibilities, and offered advantages that outweighed its disadvantages. Items 2 and 6 obtained an overall weighted mean of 3.99, while Items 4, 7, and 8 received overall weighted means ranging from 3.97 to 3.98, all interpreted as Highly Acceptable.

The findings demonstrated that the proposed OJT Monitoring System was perceived as a valuable technological solution for managing internship activities within the CCIT. The consistently high ratings across all respondent groups indicated that the system effectively supported users in accomplishing their responsibilities while improving accuracy, efficiency, and security. These findings are consistent with the Technology Acceptance Model, which posits that users are more likely to accept and continuously use an information system when they perceive it as useful in enhancing their performance. Similarly, Zhou et al. (2022) found that perceived usefulness remained one of the strongest factors influencing users' intention to adopt technology in higher education, emphasizing that systems capable of improving productivity are more likely to achieve successful acceptance.

2. Perceived Ease of Use

Table 7
Respondents' Response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT
Monitoring System Using the Technology Acceptance Model (TAM) in terms of Perceived Ease of Use

No.   Perceived Ease of Use                        CCIT    Coord-  Student  Super-  Mean   Descriptive
                                                   Head    inator           visor          Equivalent
1     My interaction with the system in            4.00    4.00    3.93     4.00    3.98   Highly
      task processes has been clear and                                                    Acceptable
      understandable.
2     Overall, the system is easy to use.          4.00    4.00    3.97     4.00    3.99   Highly
                                                                                           Acceptable
3     Learning to operate the system was           4.00    4.00    3.95     4.00    3.99   Highly
      easy for me.                                                                         Acceptable
4     The system does not confuse me.              4.00    4.00    3.95     4.00    3.99   Highly
                                                                                           Acceptable
5     The system is easy to navigate.              4.00    4.00    3.98     4.00    4.00   Highly
                                                                                           Acceptable
6     Using the system enables me to have          4.00    4.00    4.00     3.91    3.98   Highly
      more accurate information.                                                           Acceptable
      General Weighted Mean                        4.00    4.00    3.96     3.99    3.99   Highly
                                                                                           Acceptable

Table 7 presented the evaluation of the Perceived Ease of Use of the system. The results revealed that the system was Highly Acceptable, obtaining a general weighted mean of 3.99.

Among the indicators, Item 5 — "The system is easy to navigate" — obtained the highest overall weighted mean of 4.00, indicating that respondents strongly agreed that the system's interface and navigation are user-friendly and allow efficient access to necessary functions regardless of assigned role. Items 2, 3, and 4 each obtained an overall weighted mean of 3.99, while Items 1 and 6 received 3.98, all interpreted as Highly Acceptable. These findings suggested that respondents found the system easy to understand, simple to operate, free from unnecessary complexity, and capable of providing accurate information throughout the internship monitoring process.

The findings demonstrated that the proposed OJT Monitoring System provided a user-friendly experience that enabled users to complete tasks with ease and confidence. These findings are consistent with the Technology Acceptance Model, which posits that users are more likely to accept and use a system when they perceive it as easy to learn and operate. Al-Emran, Arpaci, and Salloum (2020) emphasized that perceived ease of use significantly influences users' acceptance and continued use of information systems, particularly when systems are designed with intuitive interfaces and straightforward interactions.

3. Behavioral Intention to Use

Table 8
Respondents' Response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT
Monitoring System Using the Technology Acceptance Model (TAM) in terms of Behavioral Intention to Use

No.   Behavioral Intention to Use                  CCIT    Coord-  Student  Super-  Mean   Descriptive
                                                   Head    inator           visor          Equivalent
1     I intend to continue using the system        4.00    4.00    4.00     4.00    4.00   Highly
      for OJT monitoring processes.                                                        Acceptable
2     I intend to frequently use the system        4.00    4.00    3.99     4.00    4.00   Highly
      for automated processes in my work.                                                  Acceptable
3     Given access to the system, I predict        4.00    4.00    4.00     4.00    4.00   Highly
      that I would adopt it.                                                               Acceptable
4     I would use the system without               4.00    4.00    3.98     4.00    4.00   Highly
      pressure from external social factors.                                               Acceptable
5     People around me who use the system          4.00    4.00    3.99     4.00    4.00   Highly
      have more prestige than those who                                                    Acceptable
      do not.
6     Using the system for internship              4.00    4.00    4.00     4.00    4.00   Highly
      processes is considered a status                                                     Acceptable
      symbol among others.
      General Weighted Mean                        4.00    4.00    3.99     4.00    4.00   Highly
                                                                                           Acceptable

Table 8 presented the evaluation of the Behavioral Intention to Use of the system. The results revealed that the system was Highly Acceptable, obtaining a general weighted mean of 4.00 — the highest among all TAM constructs.

All six indicators obtained an overall weighted mean of 4.00, with the exception of Item 4 (Student mean: 3.98) and Item 2 (Student mean: 3.99), both still interpreted as Highly Acceptable. These findings indicated that respondents intended to continue using the system for internship monitoring, were willing to adopt it whenever available, preferred to use it voluntarily without external pressure, and recognized the system's value in supporting internship activities. The perfect or near-perfect scores across all respondent groups demonstrate strong and genuine willingness to integrate the system into regular OJT workflow.

The findings are consistent with recent studies on TAM, which reported that behavioral intention remains one of the strongest predictors of actual information system use. Abdullah et al. (2022) found that users who perceived a system as both beneficial and easy to use demonstrated a stronger intention to continue using the technology, ultimately contributing to successful system implementation and sustained adoption.

4. Attitude Toward Use

Table 9
Respondents' Response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT
Monitoring System Using the Technology Acceptance Model (TAM) in terms of Attitude Toward Use

No.   Attitude Toward Use                          CCIT    Coord-  Student  Super-  Mean   Descriptive
                                                   Head    inator           visor          Equivalent
1     I think positively about using               4.00    4.00    4.00     4.00    4.00   Highly
      the system.                                                                          Acceptable
2     The system is a valuable tool for            4.00    4.00    3.99     4.00    4.00   Highly
      enhancing internship management                                                      Acceptable
      at PRMSU CCIT.
3     Using the system is a wise idea.             4.00    4.00    3.99     4.00    4.00   Highly
                                                                                           Acceptable
4     The system is worth using to improve         4.00    4.00    4.00     4.00    4.00   Highly
      task efficiency.                                                                     Acceptable
5     I plan to use the system regularly           4.00    4.00    4.00     4.00    4.00   Highly
      in the future.                                                                       Acceptable
6     Using the system is a pleasant               4.00    4.00    4.00     4.00    4.00   Highly
      experience.                                                                          Acceptable
      General Weighted Mean                        4.00    4.00    4.00     4.00    4.00   Highly
                                                                                           Acceptable

Table 9 presented the evaluation of the Attitude Toward Use of the system. The results revealed that the system was Highly Acceptable, obtaining a general weighted mean of 4.00 — the highest among all TAM constructs alongside Behavioral Intention to Use.

All six indicators obtained an overall weighted mean of 4.00 across all respondent groups, with the exception of Items 2 and 3 where the Student group recorded slightly lower weighted means of 3.99. Despite this minimal variation, both indicators remained Highly Acceptable, suggesting that respondents consistently recognized the system as a valuable tool for internship management and believed its implementation was a practical and beneficial decision for the PRMSU CCIT Department.

The findings demonstrated that respondents developed a highly favorable attitude toward the proposed OJT Monitoring System. These findings are consistent with TAM literature indicating that a positive attitude toward using a system significantly influences users' willingness to adopt and continuously utilize the technology. Nguyen, Tran, and Nguyen (2023) reported that users with favorable attitudes toward educational information systems were more likely to sustain their use of the technology, particularly when the systems enhanced productivity, simplified work processes, and improved the overall user experience.

5. Summary of TAM Results

Table 10
Summary of the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring
System Using the Technology Acceptance Model (TAM)

No.   Technology Acceptance Model         CCIT    Coord-  Student  Super-  Mean   Descriptive
      Construct                           Head    inator           visor          Equivalent
1     Perceived Usefulness                4.00    4.00    3.98     3.97    3.99   Highly Acceptable
2     Perceived Ease of Use               4.00    4.00    3.96     3.99    3.99   Highly Acceptable
3     Behavioral Intention to Use         4.00    4.00    3.99     4.00    4.00   Highly Acceptable
4     Attitude Toward Use                 4.00    4.00    4.00     4.00    4.00   Highly Acceptable
      General Weighted Mean               4.00    4.00    3.98     3.99    3.99   Highly Acceptable

Table 10 presented the summary evaluation of all four TAM constructs. The results revealed a general weighted mean of 3.99, interpreted as Highly Acceptable across all respondent groups.

Behavioral Intention to Use and Attitude Toward Use obtained the highest overall weighted mean of 4.00, indicating that respondents expressed the strongest agreement in their willingness to continue using the system and in their positive overall attitude toward its implementation. Perceived Usefulness and Perceived Ease of Use both obtained an overall weighted mean of 3.99, confirming that respondents perceived the system as useful in improving internship management while also finding it easy to learn, navigate, and operate.

The consistently high evaluations from all four respondent groups — CCIT Head, Coordinator, Student, and Supervisor — confirm that the developed system successfully met users' expectations across all TAM dimensions. These findings are consistent with Al-Emran, Arpaci, and Salloum (2020), who concluded that perceived usefulness, perceived ease of use, attitude toward use, and behavioral intention collectively influence users' acceptance and continued use of information systems across educational environments.

6. Actual System Use

Table 11
Respondents' Response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT
Monitoring System Using the Technology Acceptance Model (TAM) in terms of Actual Use (Daily Basis)

ACTUAL USE (Daily)         Coordinator   Student   Supervisor   Frequency   Percentage
Not Everyday                     0           0          0            0         0.00%
1 time per day                   0           0          0            0         0.00%
2 times per day                  0           0          0            0         0.00%
3 times per day                  0           0          0            0         0.00%
4 times per day                  0           0          0            0         0.00%
5 times per day                 12           0          0           12        11.43%
Constantly                      91           1          1           93        88.57%
TOTAL                          103           1          1          105       100.00%

Table 11 presented the actual daily use of the system. The majority of respondents — 93 (88.57%) — reported using the system constantly throughout the day, while 12 respondents (11.43%) reported using the system five times per day. No respondent reported using the system fewer than five times per day or not using it daily.

The high percentage of respondents reporting constant daily usage indicates that the system has become an integral tool for routine internship monitoring activities, including recording time-in and time-out, monitoring accumulated hours, reviewing pending approvals, and managing student submissions. These findings demonstrate that the system was successfully integrated into users' daily work processes across all respondent roles.

Table 12
Respondents' Response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT
Monitoring System Using the Technology Acceptance Model (TAM) in terms of Actual Use (Weekly Basis)

ACTUAL USE (Weekly)        Coordinator   Student   Supervisor   Frequency   Percentage
Not Every Week                   0           0          0            0         0.00%
1 time per week                  0           0          0            0         0.00%
2 times per week                 0           0          0            0         0.00%
3 times per week                 0           0          0            0         0.00%
4 times per week                 0           0          0            0         0.00%
5 times per week                 6           0          0            6         5.71%
6 times per week                 0           0          0            0         0.00%
Every week                      97           1          1           99        94.29%
TOTAL                          103           1          1          105       100.00%

Table 12 presented the actual weekly use of the system. The majority of respondents — 99 (94.29%) — reported using the system every week consistently, while 6 respondents (5.71%) reported using it five times per week. No respondent reported using the system fewer than five times per week or not using it weekly.

The findings indicate that respondents consistently utilized the developed system throughout the internship period, regularly accessing it to record attendance, monitor accumulated hours, upload required documents, and perform role-specific responsibilities. The near-universal weekly usage confirms that the system has been successfully adopted as a regular platform for internship management, reflecting strong user acceptance and sustained engagement.

These findings on Actual System Use are consistent with the Technology Acceptance Model, which posits that positive perceptions of usefulness and ease of use ultimately lead to actual system use. Al-Emran and Granić (2021) emphasized that users who recognize the usefulness and ease of use of an information system are more likely to integrate the technology into their regular activities, resulting in continued system utilization. The data from Tables 11 and 12 confirm this pathway, as the high levels of perceived usefulness (3.99) and perceived ease of use (3.99) found in the TAM evaluation directly correspond to the high levels of actual daily and weekly system usage reported by the respondents.


================================================================================

Chapter 5
RECOMMENDATIONS

This chapter presents the summary of findings, conclusions drawn from the results of the study, and recommendations for future research and system enhancement.

Summary of Findings

This study evaluated the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration using data from 105 system users across four distinct roles — OJT Students (Section A with 44 students and Section B with 48 students), Company Supervisors (15), OJT Coordinator (1), and CCIT Head (1). The following findings were obtained:

1. Efficiency of the Proposed RBAC Algorithm (Objective 1.1)

The proposed RBAC algorithm of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System recorded an average processing time of 0.558 milliseconds across all eight critical transactions. The fastest transaction was User Authentication at 0.312 ms, reflecting the efficiency of the two-layer middleware mechanism. The most resource-intensive transactions were Time-Out Recording at 0.891 ms and Time-In Recording at 0.874 ms, both involving additional operations including base64 photo decoding, file storage, server-side timestamp capture, and session-based hour calculation. Despite these additional operations, all transactions completed in under one millisecond, confirming the algorithm's capacity for real-time performance at scale.

2. Functionality of the Proposed RBAC Algorithm (Objective 1.2)

The proposed RBAC algorithm achieved a perfect 100% access control accuracy rate across all ten black-box test cases. No unauthorized cross-role access was detected in any test case. The RoleMiddleware correctly enforced the Separation of Duties principle across all user boundaries — Students were restricted to their own functions, Supervisors were confined to their assigned company's students and blocked from evaluating students below the hour threshold, Coordinators were prevented from accessing user management and evaluation functions, and the CCIT Head retained exclusive access to all administrative functions. Unauthenticated users were correctly redirected to the login page before any role check was invoked.

3. Efficiency of the Existing Manual Verification Process (Objective 2.1)

The existing manual verification process of the PRMSU CCIT Department recorded an average processing time of 14.19 minutes per transaction across eight equivalent task categories. Processing times ranged from 5.00 minutes for manual student identity verification to 25.00 minutes for manual DTR generation and filing. The manual process also lacks any systematic enforcement of role boundaries, meaning the time spent on verification does not guarantee the prevention of fraudulent entries or unauthorized modifications.

4. Functionality of the Existing Manual Verification Process (Objective 2.2)

The existing manual verification process produced an overall error rate of 50.00% from a sample of 50 manual records. Specific error rates were: data entry errors (14.00%), incorrect manual hour tallying (12.00%), lost or misplaced requirement documents (10.00%), fraudulent attendance entries or buddy punching (8.00%), and unauthorized modification of submitted records (6.00%). These findings confirm that the existing process is fundamentally unreliable for managing the high-volume OJT monitoring operations of the CCIT Department.

5. Comparative Analysis (Objective 5)

The comparative analysis confirmed the clear superiority of the proposed RBAC algorithm over the existing manual verification process. In terms of efficiency, the automated system reduces processing time by approximately 99.99% — from an average of 14.19 minutes per transaction to 0.558 milliseconds. In terms of functionality, the proposed system eliminates the 50.00% overall error rate of the manual process entirely, achieving a 100% access control accuracy rate with zero detected errors, representing a 100% reduction in access control failures and a complete elimination of all five error categories identified in the manual process.

6. Level of Acceptance Using TAM (Objective 4)

The TAM evaluation demonstrated exceptionally high user acceptance across all four constructs and all respondent groups. Perceived Usefulness obtained an overall weighted mean of 3.99 (Highly Acceptable), with respondents strongly agreeing that the system enables faster task completion, makes it easier to track the 600-hour requirement, provides greater role-specific control, and prevents buddy punching. Perceived Ease of Use obtained an overall weighted mean of 3.99 (Highly Acceptable), with respondents confirming that the system is easy to navigate, learn, and operate. Behavioral Intention to Use obtained an overall weighted mean of 4.00 (Highly Acceptable), reflecting strong willingness to continue using the system and adopt it as a regular part of internship monitoring workflow. Attitude Toward Use obtained an overall weighted mean of 4.00 (Highly Acceptable), with respondents holding an overwhelmingly positive attitude toward the system, finding it worth using, pleasant to operate, and valuable for enhancing internship management. The overall general weighted mean across all four TAM constructs was 3.99, interpreted as Highly Acceptable.

7. Actual System Use (Objective 4.5)

In terms of daily usage, 93 respondents (88.57%) reported using the system constantly throughout the day, while 12 respondents (11.43%) reported using it five times per day. No respondent reported fewer than five daily uses or no daily use. In terms of weekly usage, 99 respondents (94.29%) reported using the system every week consistently, while 6 respondents (5.71%) reported using it five times per week. No respondent reported fewer than five weekly uses or no weekly use. These results confirm strong, consistent, and sustained system adoption across all user roles.

Conclusions

The following conclusions were drawn by the researchers based on the summary of findings:

1. The proposed RBAC algorithm of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System proved to be significantly more efficient than the existing manual verification process of the PRMSU CCIT Department, recording an average processing time of 0.558 milliseconds compared to the manual process average of 14.19 minutes, representing a 99.99% reduction in processing time and confirming the system's suitability for managing the OJT monitoring operations of a large student population in real time.

2. The proposed RBAC algorithm proved to be significantly more functional than the existing manual verification process, achieving a 100% access control accuracy rate with a 0% error rate compared to the manual process overall error rate of 50.00%, confirming the system's capability to enforce the Separation of Duties principle, prevent buddy punching and fraudulent logging, and protect student records from unauthorized access or modification.

3. The RBAC Integration Model developed for the CCIT Department successfully defines four user roles — Student, Supervisor, Coordinator, and CCIT Head — with distinct permission sets enforced through a two-layer middleware mechanism (AuthMiddleware and RoleMiddleware) at the route level, providing a replicable and validated access control model appropriate for educational information systems managing role-heterogeneous user populations.

4. The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System is highly acceptable in all TAM dimensions assessed, receiving overall weighted means of 3.99 for Perceived Usefulness, 3.99 for Perceived Ease of Use, 4.00 for Behavioral Intention to Use, and 4.00 for Attitude Toward Use, all interpreted as Highly Acceptable, verifying that the system is dependable, user-friendly, and effective in addressing the OJT monitoring needs of the PRMSU CCIT Department.

5. The proposed RBAC algorithm provides a substantially stronger access management solution compared to the existing manual verification process of the CCIT Department, reducing processing time by 99.99% and eliminating the 50.00% error rate of the manual process in its entirety. The system prevents buddy punching through server-side timestamp enforcement and mandatory photo capture with face-detection overlay, prevents data loss through a secure digital repository, and ensures the integrity of academic records through strict role-based access restrictions — confirming the strength of the RBAC approach over manual verification in all measured indicators.

6. The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System is used consistently and constantly by its intended users, with 88.57% of respondents reporting constant daily usage and 94.29% reporting consistent weekly usage, reflecting strong user acceptance and successful integration of the system into the regular OJT monitoring activities of the PRMSU CCIT Department.

Recommendations

In connection with the summary of findings and conclusions, the researchers hereby recommend the following:

1. To further enhance the login security of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration, it is recommended to integrate a One-Time Password (OTP) system sent to the student's registered email address as an additional authentication step during the login process. The system already has a fully functional email notification infrastructure through its existing email helper, making the addition of OTP-based verification a natural and low-overhead enhancement that would further strengthen the system's first layer of security against unauthorized account access.

2. To further enhance the attendance verification capability of the system, it is recommended to explore the integration of facial recognition technology into the time-in and time-out photo capture process, replacing the current oval face guide overlay with an automated face matching algorithm that verifies the identity of the student against their registered profile photo, further strengthening the system's defense against buddy punching and fraudulent attendance logging beyond the current mandatory photo capture mechanism.

3. To further enhance the geographical verification capability of the system, it is recommended to implement a GPS-based location verification feature that records the geographical coordinates of the student at the time of time-in and time-out, providing an additional layer of attendance authenticity verification beyond the existing mandatory photo capture and server-side timestamp mechanism. This directly addresses the current limitation identified in Chapter 1, wherein GPS tracking was explicitly excluded from the scope of the study.

4. To further enhance the reporting capability of the system, it is recommended to expand the existing report generation module to include exportable analytics dashboards covering internship completion trends, company performance ratings, and school year comparisons, enabling the CCIT Head and OJT Coordinators to make more informed, data-driven decisions for future internship program planning beyond the current PDF export functionality.

5. To further enhance the accessibility of the system, it is recommended to develop a dedicated mobile application version of the system that supports offline logging with automatic synchronization upon reconnection to the internet, directly addressing the current limitation identified in Chapter 1 wherein the system requires a stable internet connection for all transactions and does not support offline logging.

6. To future researchers, it is recommended to replicate this study in other departments and campuses of PRMSU or in other universities to validate the generalizability of the RBAC integration model and the TAM findings across different institutional contexts, student populations, and OJT program structures. The research instrument, algorithm design, and evaluation framework developed in this study may serve as a validated foundation for such replications or extensions.


================================================================================

REFERENCES

Abdullah, F., Ward, R., & Ahmed, E. (2022). Investigating the influence of the Technology Acceptance Model on behavioral intention toward information systems: A systematic literature review. Education and Information Technologies, 27(5), 6137–6163. https://doi.org/10.1007/s10639-021-10885-2

Aftab, M. U., Hamza, A., Oluwasanmi, A., Nie, X., Sarfraz, M. S., Shehzad, D., Qin, Z., & Rafiq, A. (2022). Traditional and hybrid access control models: A detailed survey. Security and Communication Networks, 2022, Article 1560885. https://doi.org/10.1155/2022/1560885

Aftab, M. U., Qin, Z., Hundera, N. W., Ariyo, O., Zakria, Son, N. T., & Dinh, T. V. (2019). Permission-based separation of duty in dynamic role-based access control model. Symmetry, 11(5), 669. https://doi.org/10.3390/sym11050669

Al-Emran, M., Arpaci, I., & Salloum, S. A. (2020). An empirical examination of continuous intention to use m-learning: An integrated model. Education and Information Technologies, 25(4), 2899–2918. https://doi.org/10.1007/s10639-019-10094-2

Al-Emran, M., & Granić, A. (2021). Is it still valid or outdated? A bibliometric analysis of the Technology Acceptance Model and its applications from 2010 to 2020. In Recent advances in technology acceptance models and theories. Springer. https://doi.org/10.1007/978-3-030-64987-6_1

Batra, G., Atluri, V., Vaidya, J., & Sural, S. (2018). Enabling the deployment of ABAC policies in RBAC systems. In Lecture Notes in Computer Science (Vol. 10980, pp. 51–68). Springer. https://doi.org/10.1007/978-3-319-95729-6_4

Blundo, C., Cimato, S., & Siniscalchi, L. (2020). Managing constraints in role based access control. IEEE Access, 8, 140497–140511. https://doi.org/10.1109/ACCESS.2020.3011310

Castro, E. G. M. (2024). Mobile-based student internship monitoring system using progress tracking algorithm. International Research Journal on Advanced Science Hub (IRJASH), 6(8), 204–209. https://doi.org/10.47392/IRJASH.2024.029

Damasceno, C. D. N., Masiero, P. C., & Simao, A. (2018). Similarity testing for role-based access control systems. Journal of Software Engineering Research and Development, 6, Article 1. https://doi.org/10.1186/s40411-017-0045-x

Fan, Q., Yu, Y., Wang, T., Yin, G., & Wang, H. (2021). Why API documentation is insufficient for developers: An empirical study. Science China Information Sciences, 64, 119102. https://doi.org/10.1007/s11432-019-9880-8

Glen, S. (2023). Weighted mean: Definition, formula and how to find it. Statistics How To. https://www.statisticshowto.com/probability-and-statistics/statistics-definitions/weighted-mean/

Kern, S., Baumer, T., Groll, S., Fuchs, L., & Pernul, G. (2022). Optimization of access control policies. Journal of Information Security and Applications, 70, 103301. https://doi.org/10.1016/j.jisa.2022.103301

Knapp, T. R. (2009). Percentages: The most useful statistics ever invented. Retrieved from https://www.statlit.org/pdf/2009KnappPercentages.pdf

Le, H. T., Shar, L. K., Bianculli, D., Briand, L. C., & Nguyen, C. D. (2022). Automated reverse engineering of role-based access control policies of Web applications. Journal of Systems and Software, 184, 111109. https://doi.org/10.1016/j.jss.2021.111109

Li, J., Liao, Z., Zhang, C., & Shi, Y. (2016). A 4D-role based access control model for multitenancy cloud platform. Mathematical Problems in Engineering, 2016, Article 2935638. https://doi.org/10.1155/2016/2935638

Malik, A. K., Emmanuel, N., Zafar, S., Khattak, H. A., Raza, B., Khan, S., Al-Bayatti, A. H., Alassafi, M. O., Alfakeeh, A. S., & Alqarni, M. A. (2020). From conventional to state-of-the-art IoT access control models. Electronics, 9(10), 1693. https://doi.org/10.3390/electronics9101693

Meng, M., Steinhardt, S. M., & Schubert, A. (2020). Optimizing API documentation: Some guidelines and effects. In Proceedings of the 38th ACM International Conference on Design of Communication (pp. 24:1–24:11). Association for Computing Machinery. https://doi.org/10.1145/3380851.3416759

Mohamed, A., Auer, D., Hofer, D., & Küng, J. (2022). A systematic literature review for authorization and access control: Definitions, strategies and models. International Journal of Web Information Systems, 18(2–3), 156–180. https://doi.org/10.1108/IJWIS-04-2022-0077

Nguyen, T. T., Tran, T. H., & Nguyen, H. T. (2023). Factors influencing users' continuance intention toward information systems: An extended technology acceptance model perspective. Education and Information Technologies, 28(9), 11637–11659. https://doi.org/10.1007/s10639-023-11624-6

Ong, A. K. S., Prasetyo, Y. T., Roque, R. A. C., Garbo, J. G. I., Robas, K. P. E., Persada, S. F., & Nadlifatin, R. (2022). Determining the factors affecting a career shifter's use of software testing tools amidst the COVID-19 crisis in the Philippines: TTF-TAM approach. Sustainability, 14(17), 11084. https://doi.org/10.3390/su141711084

Palines, K. M. E., Moreno, J. M. U., Tatlonghari, A. G., & Ortega-Dela Cruz, R. A. (2025). Integrating information and communication technologies to enhance high school students' research capabilities. Journal of Educational Research and Practice, 15(1), 1–12. https://doi.org/10.5590/JERAP.2025.15.1952

Patton, M. Q. (1990). Qualitative evaluation and research methods (2nd ed.). Sage Publications.

Rao, K. R., Nayak, A., Ray, I. G., Rahulamathavan, Y., & Rajarajan, M. (2021). Role recommender-RBAC: Optimizing user-role assignments in RBAC. Computer Communications, 166, 140–153. https://doi.org/10.1016/j.comcom.2020.12.006

Salloum, S. A., Alhamad, A. Q. M., Al-Emran, M., Monem, A. A., & Shaalan, K. (2019). Exploring students' acceptance of e-learning through the development of a comprehensive technology acceptance model. IEEE Access, 7, 128445–128462. https://doi.org/10.1109/ACCESS.2019.2939467

Swarts, J. (2022). Uses of metadiscourse in online help. Written Communication, 39(4), 689–721. https://doi.org/10.1177/07410883221109241

Syahruddin, S., Yaakob, M. F. M., Rasyad, A., Widodo, A. W., Sukendro, S., Suwardi, S., Lani, A., Sari, L. P., Mansur, M., Razali, R., & Syam, A. (2021). Students' acceptance to distance learning during COVID-19: The role of geographical areas among Indonesian sports science students. Heliyon, 7(9), e08043. https://doi.org/10.1016/j.heliyon.2021.e08043

Tukiran, M., Sunaryo, W., Wulandari, D., & Herfina. (2022). Optimizing education processes during the COVID-19 pandemic using the Technology Acceptance Model. Frontiers in Education, 7, 903572. https://doi.org/10.3389/feduc.2022.903572

Umehara, S., Oshima, T., Ishigaki, A., & Yasui, S. (2020). Effect of an instruction manual using an e-learning system on the improvement of assembly work. In Proceedings of the 2020 9th International Congress on Advanced Applied Informatics (IIAI-AAI) (pp. 785–790). IEEE. https://doi.org/10.1109/IIAI-AAI50415.2020.00155

Zhou, L., Xue, S., & Li, R. (2022). Extending the Technology Acceptance Model to explore students' intention to use an online education platform at a university in China. SAGE Open, 12(1). https://doi.org/10.1177/21582440221085259


================================================================================

APPENDICES

================================================================================

Appendix A
Relevant Source Code

1. AuthMiddleware

<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user session exists
        if (!session('user_id')) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please log in.'
                ], 401);
            }
            return redirect()->route('login')
                ->withErrors(['auth' => 'You must be logged in to access this page.']);
        }

        // Verify user still exists in database
        $user = User::find(session('user_id'));

        if (!$user) {
            session()->flush();
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'User account not found.'
                ], 401);
            }
            return redirect()->route('login')
                ->withErrors(['auth' => 'Your account no longer exists.']);
        }

        // Sync session with latest user data
        session(['user' => $user]);

        return $next($request);
    }
}

--------------------------------------------------------------------------------

2. RoleMiddleware

<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Step 1: Check if user is authenticated
        if (!session('user_id')) {
            return redirect()->route('login')
                ->withErrors(['auth' => 'You must be logged in to access this resource.']);
        }

        // Step 2: Retrieve authenticated user from database
        $user = User::find(session('user_id'));

        if (!$user) {
            session()->flush();
            return redirect()->route('login')
                ->withErrors(['auth' => 'Your account no longer exists.']);
        }

        // Step 3: Check if user is approved (except for students who are auto-approved)
        if (!$user->is_approved && $user->role !== 'student') {
            session()->flush();
            return redirect()->route('login')
                ->withErrors(['auth' => 'Your account is pending approval by the CCIT Head.']);
        }

        // Step 4: RBAC Algorithm - Check if user's role is in the allowed roles list
        if (!in_array($user->role, $roles)) {
            abort(403, 'Access Denied: Your role (' . $user->role .
                  ') is not authorized to access this resource.');
        }

        // Step 5: Access granted - proceed to the requested resource
        return $next($request);
    }
}

--------------------------------------------------------------------------------

3. Login and Account Approval

Route::post('/login', function () {
    $validated = request()->validate([
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ]);

    $user = User::where('email', $validated['email'])->first();

    if (!$user || !Hash::check($validated['password'], $user->password)) {
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    if (!$user->is_approved) {
        return back()->withErrors(['email' =>
            'Your account is pending approval by the CCIT Head. Please wait for confirmation.'])
            ->withInput();
    }
    // Store user in session and redirect to role-specific dashboard
    session(['user_id' => $user->id, 'user' => $user]);

    return match($user->role) {
        'student'     => redirect()->route('student.dashboard'),
        'supervisor'  => redirect()->route('supervisor.dashboard'),
        'coordinator' => redirect()->route('coordinator.dashboard'),
        'ccit_head'   => redirect()->route('ccit_head.dashboard'),
        default       => redirect()->route('login')
    };
});

--------------------------------------------------------------------------------

4. Auto-Timeout Process

// Auto-timeout: if student forgot to time out before lunch
if ($user->role === 'student') {
    $today   = now()->toDateString();
    $nowHour = (int) now()->format('H');

    // Morning auto-timeout at 12:00
    if ($nowHour >= 12) {
        $openMorning = \App\Models\TimeInRecord::where('student_id', $user->id)
            ->whereDate('date', $today)
            ->where('session', 'morning')
            ->whereNull('time_out')
            ->first();
        if ($openMorning) {
            $autoOut = '12:00';
            $openMorning->update(['time_out' => $autoOut]);
            $inTime      = \Carbon\Carbon::createFromTimeString($openMorning->time_in);
            $outTime     = \Carbon\Carbon::createFromTimeString($autoOut);
            $hoursWorked = round(max(0, $inTime->diffInMinutes($outTime)) / 60, 2);
            $sh = \App\Models\StudentHours::where('student_id', $user->id)
                ->firstOrCreate(['student_id' => $user->id], ['total_hours_required' => 600]);
            $sh->update([
                'hours_completed' => round(max(0, $sh->hours_completed + $hoursWorked), 2),
                'hours_remaining' => round(max(0, $sh->total_hours_required
                                    - $sh->hours_completed - $hoursWorked), 2),
            ]);
            \App\Models\DailyHourLog::create([
                'student_id'   => $user->id,
                'log_date'     => $today,
                'hours_logged' => $hoursWorked,
                'is_overtime'  => false,
                'status'       => 'approved',
            ]);
        }
    }
}

--------------------------------------------------------------------------------

5. Time-In Process

Route::post('/time-in', function () {
    $rules = [
        'student_id' => 'required|exists:users,id',
        'date'       => 'required|date',
        'session'    => 'nullable|in:morning,afternoon',
    ];

    if (request()->hasFile('photo')) {
        $rules['photo'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
    } elseif (!request()->filled('photo_base64')) {
        $rules['photo_base64'] = 'required_without:photo';
    }

    $validated = request()->validate($rules);
    $student   = User::findOrFail($validated['student_id']);

    // Auto-detect session based on server time
    $nowHour = (int) now()->format('H');
    $nowMin  = (int) now()->format('i');
    $session = ($nowHour > 12 || ($nowHour === 12 && $nowMin >= 50))
               ? 'afternoon' : 'morning';

    // Check if already timed in for this session today
    $existingRecord = \App\Models\TimeInRecord::where('student_id', $student->id)
        ->whereDate('date', $validated['date'])
        ->where('session', $session)
        ->first();

    if ($existingRecord) {
        return back()->withErrors(['date' =>
            'Already timed in for the ' . $session . ' session today.']);
    }

    // Store the photo (base64 or file upload)
    $photoPath = null;
    if (request()->hasFile('photo')) {
        $photoPath = request()->file('photo')->store('time-in-photos', 'public');
    } elseif (request()->filled('photo_base64')) {
        $base64Image = request()->input('photo_base64');
        $image_data  = base64_decode(explode(',', $base64Image)[1] ?? $base64Image);
        $filename    = 'time-in-' . $student->id . '-' . now()->timestamp . '.jpg';
        $photoPath   = 'time-in-photos/' . $filename;
        \Illuminate\Support\Facades\Storage::disk('public')->put($photoPath, $image_data);
    }

    // Always use server time to prevent client tampering
    $serverTimeIn = now()->format('H:i');

    \App\Models\TimeInRecord::create([
        'student_id' => $student->id,
        'date'       => $validated['date'],
        'session'    => $session,
        'time_in'    => $serverTimeIn,
        'photo_path' => $photoPath,
    ]);

    return back()->with('success', 'Successfully timed in (' . ucfirst($session) . ' session)!');
})->name('time-in')->middleware(['auth.custom', 'role:student', 'throttle:20,1']);

--------------------------------------------------------------------------------

6. Time-Out and Hours Calculation

Route::post('/time-out', function () {
    $validated = request()->validate([
        'student_id'   => 'required|exists:users,id',
        'date'         => 'required|date',
        'session'      => 'nullable|in:morning,afternoon',
        'photo_base64' => 'nullable|string',
    ]);

    $record = \App\Models\TimeInRecord::where('student_id', $validated['student_id'])
        ->whereDate('date', $validated['date'])
        ->whereNull('time_out')
        ->when(isset($validated['session']),
               fn($q) => $q->where('session', $validated['session']))
        ->latest()
        ->first();

    if (!$record) {
        return back()->withErrors(['date' => 'No open time-in record found for this date.']);
    }

    // Store time-out photo if provided
    $timeOutPhotoPath = null;
    if (request()->filled('photo_base64')) {
        $base64Image     = request()->input('photo_base64');
        $image_data      = base64_decode(explode(',', $base64Image)[1] ?? $base64Image);
        $student         = User::findOrFail($validated['student_id']);
        $filename        = 'time-out-' . $student->id . '-' . now()->timestamp . '.jpg';
        $timeOutPhotoPath = 'time-out-photos/' . $filename;
        \Illuminate\Support\Facades\Storage::disk('public')->put($timeOutPhotoPath, $image_data);
    }

    $serverTimeOut = now()->format('H:i');
    $record->update(array_filter([
        'time_out'            => $serverTimeOut,
        'time_out_photo_path' => $timeOutPhotoPath,
    ]));

    // Calculate hours for this session
    $inTime         = \Carbon\Carbon::createFromTimeString($record->time_in);
    $outTime        = \Carbon\Carbon::createFromTimeString($serverTimeOut);
    $sessionHours   = round(max(0, $inTime->diffInMinutes($outTime)) / 60, 2);

    // Apply 8-hour daily cap; anything beyond is overtime
    $prevDayHours       = round(\App\Models\TimeInRecord::where('student_id',
                              $validated['student_id'])
                              ->whereDate('date', $validated['date'])
                              ->whereNotNull('time_out')
                              ->where('id', '!=', $record->id)
                              ->get()
                              ->sum(fn($r) => max(0, \Carbon\Carbon::parse($r->time_in)
                                  ->diffInMinutes(\Carbon\Carbon::parse($r->time_out)))) / 60, 2);

    $totalDayHours      = round($prevDayHours + $sessionHours, 2);
    $regularThisSession = max(0, round(min($totalDayHours, 8.0) - $prevDayHours, 2));
    $otThisSession      = max(0, round($sessionHours - $regularThisSession, 2));

    $record->update([
        'regular_hours' => $regularThisSession,
        'ot_hours'      => $otThisSession,
        'ot_status'     => $otThisSession > 0 ? 'pending' : null,
    ]);

    // Create pending daily log — hours credited only after supervisor/coordinator approval
    \App\Models\DailyHourLog::create([
        'student_id'   => $validated['student_id'],
        'log_date'     => $validated['date'],
        'hours_logged' => $regularThisSession,
        'is_overtime'  => false,
        'status'       => 'pending',
    ]);

    return back()->with('success', sprintf(
        'Time-out recorded! %.2f hrs — awaiting approval.', $regularThisSession));
})->name('time-out')->middleware(['auth.custom', 'role:student', 'throttle:20,1']);

--------------------------------------------------------------------------------

7. Approval and Hour Crediting

Route::post('/approve-time-in/{recordId}', function ($recordId) {
    $record   = \App\Models\TimeInRecord::findOrFail($recordId);
    $reviewer = User::findOrFail(session('user_id'));

    if ($record->status !== 'approved' && $record->time_in && $record->time_out) {
        $allDaySessions = \App\Models\TimeInRecord::where('student_id', $record->student_id)
            ->whereDate('date', $record->date)
            ->whereNotNull('time_out')
            ->where('status', 'pending')
            ->get();

        $otLetterApproved = \App\Models\StudentRequirement::where('student_id',
                                $record->student_id)
            ->whereDate('created_at', $record->date)
            ->where('status', 'approved')
            ->where(fn($q) => $q->where('title', 'like', '%OT%')
                ->orWhere('title', 'like', '%overtime%')
                ->orWhere('title', 'like', '%over time%'))
            ->exists();

        $totalToCredit = 0;
        foreach ($allDaySessions as $session) {
            $regularHours  = floatval($session->regular_hours ?? 0);
            $otHours       = floatval($session->ot_hours ?? 0);
            $totalToCredit += $regularHours;
            if ($otHours > 0 && $otLetterApproved) {
                $totalToCredit += $otHours;
                $session->update(['ot_status' => 'approved']);
            }
            $session->update([
                'verified'      => true,
                'status'        => 'approved',
                'approved_by'   => $reviewer->id,
                'approved_at'   => now(),
                'denial_reason' => null,
            ]);
        }

        if ($totalToCredit > 0) {
            $studentHours = \App\Models\StudentHours::where('student_id', $record->student_id)
                ->firstOrCreate(['student_id' => $record->student_id],
                                ['total_hours_required' => 600]);
            $studentHours->update([
                'hours_completed' => round(max(0,
                    $studentHours->hours_completed + $totalToCredit), 2),
                'hours_remaining' => round(max(0,
                    $studentHours->total_hours_required
                    - $studentHours->hours_completed - $totalToCredit), 2),
            ]);
        }

        \App\Models\DailyHourLog::where('student_id', $record->student_id)
            ->whereDate('log_date', $record->date)
            ->where('status', 'pending')
            ->update(['status' => 'approved']);
    }

    return back()->with('success', 'All sessions for this day approved and hours credited!');
})->name('approve-time-in')->middleware(['auth.custom', 'role:coordinator,supervisor']);

--------------------------------------------------------------------------------

8. OT Letter Crediting (Requirement Approval)

Route::post('/approve-requirement/{requirementId}', function ($requirementId) {
    $validated   = request()->validate(['feedback' => 'required|string|max:1000']);
    $requirement = \App\Models\StudentRequirement::with('student')->findOrFail($requirementId);
    $coordinator = User::findOrFail(session('user_id'));

    $requirement->update([
        'status'      => 'approved',
        'feedback'    => $validated['feedback'],
        'approved_by' => $coordinator->id,
        'approved_at' => now(),
    ]);

    // If this is an OT letter, credit pending OT hours for the student
    $isOtLetter = stripos($requirement->title, 'OT') !== false
               || stripos($requirement->title, 'overtime') !== false
               || stripos($requirement->title, 'over time') !== false;

    if ($isOtLetter) {
        $otDate    = $requirement->created_at->toDateString();
        $otRecords = \App\Models\TimeInRecord::where('student_id', $requirement->student_id)
            ->whereDate('date', $otDate)
            ->where('status', 'approved')
            ->where('ot_status', 'pending')
            ->where('ot_hours', '>', 0)
            ->get();

        $totalOtToCredit = $otRecords->sum(fn($r) => floatval($r->ot_hours));
        foreach ($otRecords as $otRec) {
            $otRec->update(['ot_status' => 'approved']);
        }

        if ($totalOtToCredit > 0) {
            $studentHours = \App\Models\StudentHours::where('student_id',
                                $requirement->student_id)
                ->firstOrCreate(['student_id' => $requirement->student_id],
                                ['total_hours_required' => 600]);
            $studentHours->update([
                'hours_completed' => round(max(0,
                    $studentHours->hours_completed + $totalOtToCredit), 2),
                'hours_remaining' => round(max(0,
                    $studentHours->total_hours_required
                    - $studentHours->hours_completed - $totalOtToCredit), 2),
            ]);
            \App\Models\DailyHourLog::create([
                'student_id'   => $requirement->student_id,
                'log_date'     => $otDate,
                'hours_logged' => $totalOtToCredit,
                'is_overtime'  => true,
                'status'       => 'approved',
            ]);
        }
    }

    return back()->with('success', 'Requirement approved!');
})->name('approve-requirement')
  ->middleware(['auth.custom', 'role:coordinator,ccit_head,supervisor']);

--------------------------------------------------------------------------------

9. Evaluation Scoring Process

Route::post('/save-evaluation/{studentId}', function ($studentId) {
    try {
        $data = request()->validate([
            'supervisor_id'                    => 'required|integer',
            'rating'                           => 'nullable|integer|min:0|max:5',
            'evaluation_date'                  => 'nullable|date',
            'period_from'                      => 'nullable|date',
            'period_to'                        => 'nullable|date',
            'job_title'                        => 'nullable|string|max:255',
            'quality_of_work_rating'           => 'required|string',
            'quantity_of_work_rating'          => 'required|string',
            'job_knowledge_rating'             => 'required|string',
            'working_relationships_rating'     => 'required|string',
            'attendance_dependability_rating'  => 'required|string',
            'specific_achievements_rating'     => 'required|string',
            'feedback'                         => 'nullable|string|max:2000',
            'attendance'                       => 'nullable|integer|min:0|max:5',
            'communication'                    => 'nullable|integer|min:0|max:5',
            'collaboration'                    => 'nullable|integer|min:0|max:5',
            'problem_solving'                  => 'nullable|integer|min:0|max:5',
            'work_ethics'                      => 'nullable|integer|min:0|max:5',
            'time_management'                  => 'nullable|integer|min:0|max:5',
            'job_skills'                       => 'nullable|integer|min:0|max:5',
            'employability'                    => 'nullable|integer|min:0|max:5',
        ]);

        $supervisorId = $data['supervisor_id'];
        unset($data['supervisor_id']);

        // Auto-derive overall rating from PRMSU factor ratings
        $ratingMap = [
            'outstanding'          => 5,
            'exceeds_expectations' => 4,
            'meets_expectations'   => 3,
            'needs_improvement'    => 2,
            'unsatisfactory'       => 1,
        ];
        $factors = [
            'quality_of_work_rating', 'quantity_of_work_rating',
            'job_knowledge_rating', 'working_relationships_rating',
            'attendance_dependability_rating', 'specific_achievements_rating',
        ];
        $scores      = array_filter(array_map(
                           fn($f) => $ratingMap[$data[$f] ?? ''] ?? 0, $factors));
        $data['rating'] = count($scores)
                          ? (int) round(array_sum($scores) / count($scores)) : 1;

        $eval = \App\Models\StudentEvaluation::updateOrCreate(
            ['student_id' => $studentId, 'supervisor_id' => $supervisorId],
            $data
        );

        return response()->json([
            'success' => true,
            'rating'  => $eval->rating,
            'message' => 'Evaluation submitted successfully!',
        ]);
    } catch (\Throwable $e) {
        return response()->json(['success' => false,
            'message' => 'An error occurred. Please try again.'], 500);
    }
})->name('save-evaluation')->middleware(['auth.custom', 'role:supervisor']);

--------------------------------------------------------------------------------

10. Student Progress Calculation

Route::get('/student-progress/{studentId}', function ($studentId) {
    $student      = User::findOrFail($studentId);
    $studentHours = \App\Models\StudentHours::where('student_id', $studentId)
        ->firstOrCreate(['student_id' => $studentId], ['total_hours_required' => 600]);
    $dailyLogs    = \App\Models\DailyHourLog::where('student_id', $studentId)
        ->orderBy('log_date', 'desc')->get();

    return response()->json([
        'student'             => $student,
        'hours'               => $studentHours,
        'daily_logs'          => $dailyLogs,
        'progress_percentage' => ($studentHours->hours_completed /
                                  $studentHours->total_hours_required) * 100,
    ]);
})->name('student-progress')->middleware('auth.custom');

--------------------------------------------------------------------------------

11. DTR Generation

Route::get('/generate-dtr/{studentId}', function ($studentId) {
    $student        = User::findOrFail($studentId);
    $sh             = \App\Models\StudentHours::where('student_id', $studentId)->first();
    $timeInRecords  = \App\Models\TimeInRecord::where('student_id', $studentId)
                          ->orderBy('date', 'asc')->get();
    $required       = $sh->total_hours_required ?? 600;
    $actual         = $timeInRecords->whereNotNull('time_out')
                          ->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)
                              ->diffInMinutes(\Carbon\Carbon::parse($r->time_out)) / 60);
    $totalHours     = round(max($sh->hours_completed ?? 0, $actual), 2);
    $remaining      = round(max(0, $required - $totalHours), 2);
    $pct            = $required > 0 ? round(($totalHours / $required) * 100, 2) : 0;
    $company        = $student->company->name ?? 'N/A';
    $byMonth        = $timeInRecords->groupBy(fn($r) => $r->date->format('Y-m'));

    return view('reports.dtr',
        compact('student', 'company', 'byMonth', 'totalHours', 'required', 'remaining', 'pct'));
})->name('generate-dtr')->middleware(['auth.custom', 'role:coordinator,ccit_head,supervisor']);

================================================================================

Appendix B
Evaluation Tool or Test Documents

PRESIDENT RAMON MAGSAYSAY STATE UNIVERSITY
STA. CRUZ CAMPUS
College of Communication and Information Technology

TECHNOLOGY ACCEPTANCE MODEL (TAM) EVALUATION QUESTIONNAIRE

For the:
PRMSU STA. CRUZ CAMPUS BSCS ON-THE-JOB TRAINING MONITORING SYSTEM:
ROLE-BASED ACCESS CONTROL INTEGRATION

Dear Respondent:

Greetings!

We are fourth-year Bachelor of Science in Computer Science students conducting a thesis study entitled "PRMSU Sta. Cruz Campus BSCS On-the-Job Training Monitoring System: Role-Based Access Control Integration."

This questionnaire aims to evaluate the level of acceptance of the developed system using the Technology Acceptance Model (TAM). Your honest responses will greatly help us determine the effectiveness and usability of the system.

All information provided will be treated with strict confidentiality and used solely for the purposes of this research.

Thank you for your valuable time and cooperation.

Respectfully yours,
Edañol, Analyn H.
Cabusao, Kylyn M.
Ednave, Jackielyn C.
Magno, Chris Jericho G.
Manila, Marialyn C.
Morano, Carl M.
Saure, Julius Caesar M.

------------------------------------------------------------------------

PART I: RESPONDENT PROFILE

Please check (✓) the appropriate box.

Role:
( ) OJT Student — Section A
( ) OJT Student — Section B
( ) Company Supervisor
( ) OJT Coordinator
( ) CCIT Head

Company/Organization (if applicable): ___________________________________

------------------------------------------------------------------------

PART II: TECHNOLOGY ACCEPTANCE MODEL EVALUATION

Instructions: Please rate your level of agreement with each statement by placing a check (✓)
in the appropriate column.

Rating Scale:
4 = Strongly Agree (Highly Acceptable)
3 = Agree (Acceptable)
2 = Disagree (Fairly Acceptable)
1 = Strongly Disagree (Poorly Acceptable)

A. PERCEIVED USEFULNESS

No.  Statement                                                        4    3    2    1
1    The system enables me to accomplish tasks more quickly
     (e.g., real-time hour tracking).                               ( )  ( )  ( )  ( )
2    The system has improved the quality of work within
     my responsibilities.                                           ( )  ( )  ( )  ( )
3    The system makes it easier to track the mandatory
     600-hour requirement.                                          ( )  ( )  ( )  ( )
4    The system has improved productivity by automating
     the monitoring process.                                        ( )  ( )  ( )  ( )
5    The system gives me greater control over managing
     processes specific to my role.                                 ( )  ( )  ( )  ( )
6    The system increases effectiveness by preventing
     buddy punching or fraudulent logging.                          ( )  ( )  ( )  ( )
7    The system gives me access to a lot of information
     relevant to my work.                                           ( )  ( )  ( )  ( )
8    The system provides thorough information for
     my purposes.                                                   ( )  ( )  ( )  ( )
9    The advantages of the system outweigh its
     disadvantages.                                                 ( )  ( )  ( )  ( )

B. PERCEIVED EASE OF USE

No.  Statement                                                        4    3    2    1
1    My interaction with the system in task processes has
     been clear and understandable.                                 ( )  ( )  ( )  ( )
2    Overall, the system is easy to use.                            ( )  ( )  ( )  ( )
3    Learning to operate the system was easy for me.               ( )  ( )  ( )  ( )
4    The system does not confuse me.                                ( )  ( )  ( )  ( )
5    The system is easy to navigate.                                ( )  ( )  ( )  ( )
6    Using the system enables me to have more accurate
     information.                                                   ( )  ( )  ( )  ( )

C. BEHAVIORAL INTENTION TO USE

No.  Statement                                                        4    3    2    1
1    I intend to continue using the system for OJT
     monitoring processes.                                          ( )  ( )  ( )  ( )
2    I intend to frequently use the system for automated
     processes in my work.                                          ( )  ( )  ( )  ( )
3    Given access to the system, I predict that I would
     adopt it.                                                      ( )  ( )  ( )  ( )
4    I would use the system without pressure from external
     social factors.                                                ( )  ( )  ( )  ( )
5    People around me who use the system have more
     prestige than those who do not.                                ( )  ( )  ( )  ( )
6    Using the system for internship processes is considered
     a status symbol among others.                                  ( )  ( )  ( )  ( )

D. ATTITUDE TOWARD USE

No.  Statement                                                        4    3    2    1
1    I think positively about using the system.                     ( )  ( )  ( )  ( )
2    The system is a valuable tool for enhancing internship
     management at PRMSU CCIT.                                      ( )  ( )  ( )  ( )
3    Using the system is a wise idea.                               ( )  ( )  ( )  ( )
4    The system is worth using to improve task efficiency.          ( )  ( )  ( )  ( )
5    I plan to use the system regularly in the future.              ( )  ( )  ( )  ( )
6    Using the system is a pleasant experience.                     ( )  ( )  ( )  ( )

------------------------------------------------------------------------

PART III: ACTUAL SYSTEM USE

E. DAILY USAGE FREQUENCY
How often do you use the system on a typical day?
( ) Not everyday
( ) 1 time per day
( ) 2 times per day
( ) 3 times per day
( ) 4 times per day
( ) 5 times per day
( ) Constantly (multiple times throughout the day)

F. WEEKLY USAGE FREQUENCY
How often do you use the system in a typical week?
( ) Not every week
( ) 1 time per week
( ) 2 times per week
( ) 3 times per week
( ) 4 times per week
( ) 5 times per week
( ) 6 times per week
( ) Every week (consistently)

------------------------------------------------------------------------

OPTIONAL COMMENTS OR SUGGESTIONS:
Please share any additional feedback about the system:

___________________________________________________________________
___________________________________________________________________
___________________________________________________________________

Thank you for your participation!

For Researchers' Use Only:
Date Administered: _______________
Respondent Code:  _______________
Data Encoded by:  _______________

================================================================================

Appendix C
Users' Guide

[See the full Users' Guide included in the original paper. The guide covers the following
sections, organized by user role:]

1.1  Accessing the System (Landing Page)
2.2  Creating an Account (Registration) — including role-specific fields
2.3  What Happens After Registration
2.4  Logging In
2.5  Forgot Password

3.1  Student Dashboard Overview
3.2  Overview Section
3.3  Time In / Out (including face-detection capture workflow)
3.4  Attendance History
3.5  Requirements
3.6  Reports (Daily Narrative — submit, edit, and download daily journal entries as Word .doc)
3.7  Certificate
3.8  Logout

4.1  Supervisor Dashboard Overview
4.2  Overview Section
4.3  Interns — Daily Logs, Time Edits (Approve/Deny/Undo/Redo), Task Logs,
     Requirements, Evaluation (with 8 criteria and PRMSU rating fields)
4.4  Generating DTR Reports
4.4  Certificates
4.5  Log Out

5.1  Coordinator Dashboard Overview
5.2  Overview Section
5.3  Companies Section (Add, Edit, Archive, Restore)
5.4  Student Tracking (View Logs, Approve/Deny, View DTR, View Evaluation)
5.5  Reports and Requirements
5.6  Log Out

6.1  CCIT Head Dashboard Overview
6.2  Overview
6.3  Users (Add, Approve, Edit, Archive, View Archive Trash)
6.4  Analytics
6.5  School Years (Add, Set Active, Archive, Restore)
6.6  School IDs (Add Single, Bulk Import, Edit, Archive, Restore)
6.7  Reports (System Report, Student Progress, Attendance Report — Export PDF)
6.8  Manage Requirements (Onboarding and Daily categories)
6.9  Settings (Required Hours, Email Notifications)

7.0  Email Notifications Summary

[Full step-by-step instructions with screen reference labels for each section
are included in the printed/submitted copy of this document.]

================================================================================

Appendix D
Screen Layouts

[This appendix contains the screen layout screenshots of the system organized by role:]

- Landing Page
- Log In / Register Page
- OJT Student Dashboard (Overview, Time In/Out, History, Requirements, Reports)
- Company Supervisor Dashboard (Overview, Interns, Certificates)
- Coordinator Dashboard (Overview, Companies, Student Tracking, Reports & Requirements)
- CCIT Head Dashboard (Overview, Users, Analytics, School Years, School IDs, Reports,
  Manage Requirements, Settings)

[Actual screenshots are included in the printed/submitted copy of this document.]

================================================================================

Appendix E
Test Results

I. RESPONDENT'S PROFILE

Classification                  Frequency    Percentage
OJT Student — Section A            44          41.90%
OJT Student — Section B            48          45.71%
Company Supervisor                 11          10.48%
OJT Coordinator                     1           0.95%
CCIT Head                           1           0.95%
TOTAL                             105         100.00%

------------------------------------------------------------------------

II. RESPONDENTS' EVALUATION IN THE LEVEL OF ACCEPTANCE OF THE PRMSU STA. CRUZ
    CAMPUS BSCS OJT MONITORING SYSTEM: ROLE-BASED ACCESS CONTROL INTEGRATION
    USING THE TECHNOLOGY ACCEPTANCE MODEL (TAM)

PERCEIVED USEFULNESS

No.  Item                                        CCIT   Coord  Student  Supv   Mean   DE
1    Accomplish tasks more quickly               4.00   4.00   3.99     4.00   4.00   HA
2    Improved quality of work                    4.00   4.00   3.97     4.00   3.99   HA
3    Easier to track 600-hour requirement        4.00   4.00   3.99     4.00   4.00   HA
4    Improved productivity via automation        4.00   4.00   3.97     3.91   3.97   HA
5    Greater control over role-specific tasks    4.00   4.00   3.98     4.00   4.00   HA
6    Prevents buddy punching                     4.00   4.00   3.96     4.00   3.99   HA
7    Access to a lot of information              4.00   4.00   4.00     3.91   3.98   HA
8    Provides thorough information               4.00   4.00   3.99     3.91   3.98   HA
9    Advantages outweigh disadvantages           4.00   4.00   3.98     4.00   4.00   HA
     General Weighted Mean                       4.00   4.00   3.98     3.97   3.99   HA

HA = Highly Acceptable    DE = Descriptive Equivalent

PERCEIVED EASE OF USE

No.  Item                                        CCIT   Coord  Student  Supv   Mean   DE
1    Clear and understandable interaction        4.00   4.00   3.93     4.00   3.98   HA
2    Overall easy to use                         4.00   4.00   3.97     4.00   3.99   HA
3    Easy to learn                               4.00   4.00   3.95     4.00   3.99   HA
4    Does not confuse                            4.00   4.00   3.95     4.00   3.99   HA
5    Easy to navigate                            4.00   4.00   3.98     4.00   4.00   HA
6    Enables more accurate information           4.00   4.00   4.00     3.91   3.98   HA
     General Weighted Mean                       4.00   4.00   3.96     3.99   3.99   HA

BEHAVIORAL INTENTION TO USE

No.  Item                                        CCIT   Coord  Student  Supv   Mean   DE
1    Intend to continue using                    4.00   4.00   4.00     4.00   4.00   HA
2    Intend to frequently use                    4.00   4.00   3.99     4.00   4.00   HA
3    Would adopt given access                    4.00   4.00   4.00     4.00   4.00   HA
4    Would use without external pressure         4.00   4.00   3.98     4.00   4.00   HA
5    Users have more prestige                    4.00   4.00   3.99     4.00   4.00   HA
6    Considered a status symbol                  4.00   4.00   4.00     4.00   4.00   HA
     General Weighted Mean                       4.00   4.00   3.99     4.00   4.00   HA

ATTITUDE TOWARD USE

No.  Item                                        CCIT   Coord  Student  Supv   Mean   DE
1    Think positively about using it             4.00   4.00   4.00     4.00   4.00   HA
2    Valuable tool for internship management     4.00   4.00   3.99     4.00   4.00   HA
3    Using it is a wise idea                     4.00   4.00   3.99     4.00   4.00   HA
4    Worth using to improve efficiency           4.00   4.00   4.00     4.00   4.00   HA
5    Plan to use regularly in the future         4.00   4.00   4.00     4.00   4.00   HA
6    Pleasant experience                         4.00   4.00   4.00     4.00   4.00   HA
     General Weighted Mean                       4.00   4.00   4.00     4.00   4.00   HA

SUMMARY — LEVEL OF ACCEPTANCE USING TAM

No.  TAM Construct                               CCIT   Coord  Student  Supv   Mean   DE
1    Perceived Usefulness                        4.00   4.00   3.98     3.97   3.99   HA
2    Perceived Ease of Use                       4.00   4.00   3.96     3.99   3.99   HA
3    Behavioral Intention to Use                 4.00   4.00   3.99     4.00   4.00   HA
4    Attitude Toward Use                         4.00   4.00   4.00     4.00   4.00   HA
     General Weighted Mean                       4.00   4.00   3.98     3.99   3.99   HA

ACTUAL USE — DAILY BASIS

Usage Frequency          Coordinator  Student  Supervisor  Frequency  Percentage
Not Everyday                  0          0         0           0         0.00%
1 time per day                0          0         0           0         0.00%
2 times per day               0          0         0           0         0.00%
3 times per day               0          0         0           0         0.00%
4 times per day               0          0         0           0         0.00%
5 times per day              12          0         0          12        11.43%
Constantly                   91          1         1          93        88.57%
TOTAL                       103          1         1         105       100.00%

ACTUAL USE — WEEKLY BASIS

Usage Frequency          Coordinator  Student  Supervisor  Frequency  Percentage
Not Every Week                0          0         0           0         0.00%
1 time per week               0          0         0           0         0.00%
2 times per week              0          0         0           0         0.00%
3 times per week              0          0         0           0         0.00%
4 times per week              0          0         0           0         0.00%
5 times per week              6          0         0           6         5.71%
6 times per week              0          0         0           0         0.00%
Every week                   97          1         1          99        94.29%
TOTAL                       103          1         1         105       100.00%

================================================================================

Appendix F
Copy of Request Letter/MOA/MOU

[This appendix contains the following documents in the printed/submitted copy:]

- Official request letter addressed to the CCIT Head and Campus Director
  requesting permission to conduct the study at PRMSU Sta. Cruz Campus

- Memorandum of Agreement (MOA) between PRMSU Sta. Cruz Campus and
  partner companies/organizations for the OJT monitoring system deployment

- Memorandum of Understanding (MOU) with partner companies confirming
  their participation as respondents and system users for the evaluation phase

================================================================================

Appendix G
Curriculum Vitae

[This appendix contains the curriculum vitae of all seven researchers:]

EDAÑOL, ANALYN H.
[Curriculum vitae to be attached]

CABUSAO, KYLYN M.
[Curriculum vitae to be attached]

EDNAVE, JACKIELYN C.
[Curriculum vitae to be attached]

MAGNO, CHRIS JERICHO G.
[Curriculum vitae to be attached]

MANILA, MARIALYN C.
[Curriculum vitae to be attached]

MORANO, CARL M.
[Curriculum vitae to be attached]

SAURE, JULIUS CAESAR M.
[Curriculum vitae to be attached]

================================================================================

Appendix H
Documentation

DATA GATHERING
[Photos of the researchers conducting interviews and observations with the CCIT Head,
OJT Coordinator, and students during the requirements analysis phase.]

DISTRIBUTION OF QUESTIONNAIRES
[Photos of the researchers distributing and administering the TAM evaluation questionnaire
to the respondents — OJT students, company supervisors, the OJT coordinator, and the
CCIT Head — through both printed paper forms and Google Forms sessions.]

SYSTEM CONSULTATION / IT EXPERT
[Photos and documentation of the system consultation sessions with IT experts and
the thesis adviser, including review of the system architecture, RBAC implementation,
middleware logic, and user interface design.]

PILOT TESTING
[Photos of the pilot testing sessions where a subset of users interacted with the
developed system, including time-in/time-out demonstrations with the face-detection
camera overlay, requirement submission workflows, and approval process walkthroughs.
Pilot test feedback was incorporated into the final system before full deployment.]

================================================================================
END OF DOCUMENT
================================================================================
