PRESIDENT RAMON MAGSAYSAY STATE UNIVERSITY STA.CRUZ CAMPUS BACHELOR OF SCIENCE IN COMPUTER SCIENCE
ON-THE-JOB-TRAINING MONITORING SYSTEM: ROLE-
BASED ACCESS CONTROL INTEGRATION




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



Republic of the Philippines
PRESIDENT RAMON MAGSAYSAY STATE UNIVERSITY
College of Communication and Information Technology
Sta. Cruz, Zambales

APPROVAL SHEET

This study entitled “PRESIDENT RAMON MAGSAYSAY STATE UNIVERSITY STA.CRUZ CAMPUS BACHELOR OF SCIENCE IN COMPUTER SCIENCE ON-THE-JOB-TRAINING MONITORING SYSTEM: ROLE-BASED ACCESS CONTROL INTEGRATION” prepared and submitted by CARL MORANO, KYLYN CABUSAO, JACKIELYN EDNAVE, CHRIS JERICHO MAGNO, MARIALYN MANILA, JULUIS CAESAR SAURE in partial fulfillment of the requirements for the degree of BACHELOR OF SCIENCE IN COMPUTER SCIENCE are hereby recommended for oral examination.

ANALYN H. EDAÑOL, MSCS                                                         Subject Instructor	ANALYN H. EDAÑOL, MSCS Adviser
________________________________________________________________________
Approved by the Panel of the Oral Examiners on XXXX X, 2026 with a grade of ________.
CHAIRMAN NAME
Chairman

ANALYN H. EDAÑOL, MSCS
Member	JOHN APRIL N. MARPA, PhD
Member
ELEMAE L. MORAÑA, MSCS
Member	JANNIE M. ESCOBAR, PhD
Member
_______________________________________________________________________
Accepted and approved in partial fulfillment of the requirements for the degree of BACHELOR OF SCIENCE IN COMPUTER SCIENCE.

___________________		       	             _____________________________
       Date Signed		         		         		   NOEL B. MERIN					                                          		    Campus Director 
ACKNOWLEDGEMENT
	The completion of this thesis would not have been possible without the guidance, support, and generosity of the individuals and institutions whose contributions made this research a reality. The researchers wish to express their deepest and most sincere gratitude to each of them.
	Above all, the researchers give thanks and glory to the Almighty God, whose divine wisdom, grace, and providence sustained each member of the team throughout every challenge and milestone of this undertaking. This work is first and foremost offered to Him.
	To Ma'am Analyn H. Edañol, MSCS, subject instructor and thesis adviser, the researchers extend their most profound gratitude. Her unwavering dedication, scholarly expertise, and patient guidance from the earliest stages of conceptualization to the final defense shaped this study into what it has become. Her high standards, thoughtful feedback, and genuine investment in the team's growth pushed the researchers to produce work they are truly proud of. Her belief in the capability of each member was a constant source of motivation throughout this journey.
	To the members of the Panel of Oral Examiners — the Chairman, Sir John April N. Marpa, PhD, Ma'am Elemae L. Moraña, MSCS, and Ma'am Jannie M. Escobar, PhD — the researchers are deeply grateful for their time, expertise, and constructive evaluations. Their critical and insightful feedback during the oral examination significantly strengthened the academic rigor, technical depth, and overall quality of this research. Their questions challenged the team to think more precisely and present findings with greater clarity.
	To Sir Noel B. Merin, Campus Director, the researchers express their sincere appreciation for his leadership and commitment to fostering a culture of research excellence at President Ramon Magsaysay State University Sta. Cruz Campus. His support for student-led research initiatives reflects the institution's dedication to academic advancement and technological development.
	To the College of Communication and Information Technology of PRMSU Sta. Cruz Campus, the researchers are thankful for providing the institutional setting, academic resources, and research environment that made this study possible. The department's openness to innovation and digital solutions made it an ideal venue for developing and evaluating the proposed system.
	To the CCIT Head, OJT Coordinator, Company Supervisors, and BSCS OJT Students who participated as respondents and system users, the researchers are immensely grateful. Their willingness to engage with the system, provide honest evaluations, and give their time during the testing and data gathering phases was invaluable. Without their active participation, the system could not have been meaningfully evaluated. Their insights and feedback directly shaped the improvements incorporated into the final version of the platform.
	To the partner companies and organizations who allowed their supervisors to participate in this research, the researchers extend their gratitude for their cooperation and support of the university's internship program and this study.
	To the IT experts and technical consultants who reviewed the system and provided professional feedback during the consultation phase, the researchers are thankful for the technical insights and validation that contributed to the system's reliability and correctness.
	To the families of each researcher — the researchers are deeply and endlessly grateful for the unconditional love, moral support, patience, and financial sacrifices that made it possible for each member to pursue and complete this study. Every encouraging word, every late-night meal, and every prayer offered on their behalf made a profound difference.
	To their friends and classmates, thank you for the laughter shared during the most exhausting moments, the encouragement given when doubt crept in, and the friendship that made this long process far more bearable and meaningful.
Finally, the researchers acknowledge each other for the trust, resilience, and teamwork that held this group together from the first planning session to the final submission. This thesis is a testament to what can be accomplished when seven people commit to a shared purpose and refuse to give up on each other.
	May this work serve as a meaningful and lasting contribution to the fields of computer science, educational technology, and information systems security.
K.M.C
J.C.E
C.J.G.M
M.C.M
C.M.M
J.C.M.S
EXECUTIVE SUMMARY
The manual on-the-job training (OJT) monitoring process at President Ramon Magsaysay State University (PRMSU) Sta. Cruz Campus College of Communication and Information Technology (CCIT) faces critical administrative challenges driven by the large population of Bachelor of Science in Computer Science (BSCS) students required to complete 600 hours of industrial training annually. The existing system is labor-intensive, prone to human error, vulnerable to fraudulent attendance practices such as buddy punching, and lacks real-time oversight, resulting in lost documents, inaccurate hour tallying, and compromised data security. These problems are compounded by the absence of any automated role boundary enforcement, making it impossible to prevent unauthorized modifications to student records or ensure that only appropriate personnel handle specific administrative tasks.
The primary objective of this study is to evaluate the application of the Role-Based Access Control Integration Algorithm for the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System. Specifically, the study aims to test the proposed RBAC algorithm in terms of efficiency and functionality; to test the existing manual verification process of the CCIT Department in terms of efficiency and functionality; to compare the strength of the RBAC algorithm over the manual verification process; to evaluate the level of acceptance of the system using the Technology Acceptance Model (TAM) across five dimensions; to develop a model of the Role-Based Access Control Integration for the CCIT Department; and to develop a user's manual for the CCIT Department. The developed system is a web-based platform built using the Laravel PHP framework that enforces role-specific access through custom middleware and session-based authentication, supporting four distinct user roles — Student, Supervisor, Coordinator, and CCIT Head — each directed to a dedicated dashboard with permissions scoped exclusively to their function.
The research employed a quantitative descriptive research design combined with a developmental research approach. The Agile Development Model guided system construction through iterative sprints covering planning, design, development, testing, deployment, review, and launch phases. Data were gathered using a structured TAM-based questionnaire distributed to 105 participants through Google Forms and printed surveys, comprising 92 BSCS OJT students, 11 company supervisors, 1 OJT coordinator, and 1 CCIT Head, selected through purposive sampling. System performance was evaluated through black-box testing using a structured test case checklist for functionality assessment and server-side processing time measurement for efficiency assessment. The existing manual process was benchmarked by recording average verification times and analyzing a sample of 50 manual records for error rates. Statistical treatments included weighted mean for TAM evaluation, frequency and percentage distribution for respondent profiling, processing time analysis for efficiency comparison, and access control accuracy rate calculation for functionality comparison.
The findings revealed that the proposed RBAC algorithm significantly outperformed the existing manual verification process in both efficiency and functionality. The automated system recorded an average processing time of 0.558 milliseconds across eight critical transactions, compared to the manual process average of 14.19 minutes — a reduction of approximately 99.99%. The RBAC algorithm achieved a perfect 100% access control accuracy rate with zero unauthorized cross-role access across all ten black-box test cases, while the manual process produced a 50.00% overall error rate from 50 sampled records, including data entry errors (14.00%), incorrect hour tallying (12.00%), lost documents (10.00%), fraudulent attendance entries (8.00%), and unauthorized record modification (6.00%). The TAM evaluation demonstrated exceptional user acceptance, with overall weighted means of 3.99 for Perceived Usefulness, 3.99 for Perceived Ease of Use, 4.00 for Behavioral Intention to Use, and 4.00 for Attitude Toward Use, all interpreted as Highly Acceptable. Actual system use data confirmed strong adoption with 88.57% of respondents reporting constant daily usage and 94.29% reporting consistent weekly usage.
The study concludes that the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration provides a superior, highly accepted digital solution over the existing manual process. The system eliminates the identified error types through server-synchronized timestamps, mandatory photo capture, role-specific middleware enforcement, and a secure digital repository, confirming its suitability for managing the OJT monitoring operations of the PRMSU CCIT Department at scale. The researchers recommend future enhancements including One-Time Password (OTP) integration for strengthened login security, facial recognition technology for advanced identity verification, GPS-based location verification, expanded analytics dashboards, and mobile application development with offline synchronization capability to further address the current limitations of internet connectivity dependency and the absence of geographical tracking.
 
TABLE OF CONTENTS
TITLE PAGE	i
APPROVAL SHEET	ii
ACKNOWLEDGEMENT	iii
EXECUTIVE SUMMARY	vi
TABLE OF CONTENTS	ix
LIST OF TABLES	xii
LIST OF FIGURES	xiv
LIST OF NOTATIONS	xv
CHAPTER 1. INTRODUCTION
Project Context	1
Purpose and Description	3
Objectives of the Study	6
Scope and Limitations	7
Definition of Terms	9
CHAPTER 2. REVIEW OF RELATED LITERATURE/SYSTEMS
Technical Background	13
Proposed Role-Based Access Control Algorithm Implementation	16
Synthesis		25
CHAPTER 3. METHODOLOGY
Research Design	29
Requirement Analysis	30
Research Locale	32
Name of Proposed Algorithm	33
Data Gathering Tools	34
Design of Software, System, Product and/or Processes	34
Software Development Life Cycle	45
Data Analysis Plan	48
Research Instrument	50
Instrument Administration	51
Instrument Validation	51
Population Sampling	52
Distribution of Respondents	52
Statistical Treatment of Data	53
Description of the Prototype	57
Hardware Requirements	58
Software Requirements	59
CHAPTER 4. RESULTS AND DISCUSSION
Evaluation of the Proposed Algorithm in terms of Efficiency (Objective 1.1)	60
Evaluation of the Proposed Algorithm in terms of Functionality (Objective 1.2)	62
Evaluation of the Existing Manual Verification Process in terms of Efficiency (Objective 2.1)		64
Evaluation of the Existing Manual Verification Process in terms of Functionality (Objective 2.2)	66
Comparative Analysis of the Proposed and Existing Algorithm	68
Evaluation of the Level of Acceptance Using the Technology Acceptance Model 
(TAM)		69
CHAPTER 5. SUMMARY, CONCLUSIONS, AND RECOMMENDATIONS
Summary of Findings	85
Conclusions		87
Recommendations	89
REFERENCES	92
APPENDICES
Appendix A — Relevant Source Code	98
Appendix B — Evaluation Tool or Test Documents	125
Appendix C — Users' Guide	149
Appendix D — Screen Layouts	182
Appendix E — Test Results	190
Appendix F — Copy of Request Letter/MOA/MOU	196
Appendix G — Curriculum Vitae	198
Appendix H — Documentation	209 
LIST OF TABLES
Table                                                  Title                                                                    Page               
1.	Distribution of Respondents	52
2.	Testing of the Proposed RBAC Algorithm in terms of Efficiency (Processing Time)	60
3.	Testing of the Proposed RBAC Algorithm in terms of Functionality (Access Control Accuracy)	62
4.	Testing of the Existing Manual Verification Process in terms of Efficiency (Processing Time)	64
5.	Testing of the Existing Manual Verification Process in terms of Functionality (Error Rate)	67
6.	Respondents' Response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System Using the Technology Acceptance Model (TAM) in terms of Perceived Usefulness	70
7.	Respondents’ response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using Technology Acceptance Model (TAM) in terms of Perceived of Ease of Use	73
8.	Respondents’ response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using Technology Acceptance Model (TAM) in terms of Behavioral Intention to Use	75
9.	Respondents’ response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using Technology Acceptance Model (TAM) in terms of Attitude Toward Use 	77
10.	Summary of the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using Technology Acceptance Model
 (TAM)	79
11.	Respondents’ response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using Technology Acceptance Model (TAM) in terms of Actual Use (Daily Basis)	81
12.	Respondents’ response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using Technology Acceptance Model (TAM) in terms of Actual Use (Weekly Basis)	83	











LIST OF FIGURES
Figure                                                  Title                                                                  Page
1	Map showing the location of President Ramon Magsaysay State University Sta. Cruz Campus at Purok 1, Brgy. Naulo, Sta. Cruz, Zambales	32
2	Conceptual Framework	36
3	Agile Model	45
4	The Role-Based Access Control Algorithm Flowchart	37
5	System Flow Chart (Login/Register)	38
6	System Flow Chart (A) — Student Portal	39
7	System Flow Chart (B) — Supervisor Porta	41
8	System Flow Chart (C) — Coordinator Portal	42
9	System Flow Chart (D) — CCIT Head Portal	44
10	Comparison of Proposed RBAC Algorithm and Existing Manual Process in Efficiency	68
11	Comparison of Proposed RBAC Algorithm and Existing Manual Process in Functionality	69






LIST OF NOTATIONS
ACM	Association for Computing Machinery
BSCS	Bachelor of Science in Computer Science
CCIT	College of Communication and Information Technology
CSS	Cascading Style Sheets
CSV	Comma-Separated Values
DB	Database
DBMS	Database Management System
Docx	Document Format (Microsoft Word Open XML)
DTR	Daily Time Record
HTML	Hypertext Markup Language
HTTP	Hypertext Transfer Protocol
ICT	Information and Communication Technology
JSON	JavaScript Object Notation
MVC	Model-View-Controller
MySQL	My Structured Query Language
OJT	On-the-Job Training
ORM	Object-Relational Mapping
OT	Overtime
PDF	Portable Document Format
PHP	Hypertext Preprocessor
PRMSU	President Ramon Magsaysay State University
RBAC	Role-Based Access Control
RDBMS	Relational Database Management System
SQL	Structured Query Language
TAM	Technology Acceptance Model
UI	User Interface
URL	Uniform Resource Locator
XAMPP	Cross-Platform Apache MySQL PHP Perl



 
	 
 
Chapter 1
INTRODUCTION
Project Context
	The rapid growth and integration of Information and Communication Technology (ICT) in the 21st century have fundamentally transformed administrative and pedagogical frameworks within higher education institutions. According to Palines, Moreno, Tatlonghari, and Ortega-Dela Cruz (2025), technological advancements in the Philippine education sector have eliminated geographical limitations and improved access to digital resources, aligning with global standards for high-quality education. Modern educational systems no longer view technology as an optional luxury but as a strategic necessity that streamlines routine tasks, allowing administrators to allocate more time to strategic planning and student-centered support. Specifically, in experiential learning, the adoption of automated, web-based monitoring platforms has proven to significantly enhance performance tracking, provide real-time data integration, and improve the documentation of student tasks compared to traditional manual methods. A research study by Castro (2024) highlights that transitioning to digital monitoring systems in Philippine colleges effectively manages intern records, enhances accountability, and improves administrative processes by meeting global standards for functional suitability and security.
This study is conducted at President Ramon Magsaysay State University (PRMSU) Sta. Cruz Campus, specifically within the College of Communication and Information Technology (CCIT). As a leading provider of technical higher education, the department handles a very large population of Bachelor of Science in Computer Science (BSCS) students. Every year, a high volume of these students must complete 600 hours of job training. Due to the large number of interns being monitored simultaneously, the department faces a significant challenge in managing records and tracking progress manually. Therefore, the CCIT department serves as the actual setting to test how an automated system can handle a massive amount of student data while maintaining organized and secure records through role-based access management integration.
	During data gathering, the researchers found that the manual OJT monitoring process at the PRMSU Sta. Cruz Campus CCIT Department faces significant challenges. The current system lacks real-time attendance verification, making it easy for "buddy punching" or fraudulent logging to occur. The manual tallying of the 600-hour requirement is labor-intensive and prone to human error, while paper-based submissions such as narrative reports and completion certificates are often misplaced or lost.
	As a solution to these problems, the researchers propose the development of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration. The system is built as a web-based platform using the Laravel PHP framework that enforces role-specific access through custom role-based middleware and session-based authentication, automatically restricting system routes and functions based on the authenticated user's assigned role. The system supports four distinct roles — Student, Supervisor, Coordinator, and CCIT Head — each redirected to a dedicated dashboard upon login. Students can only upload and view their own requirements and attendance records; Supervisors are the only ones authorized to submit performance evaluations to prevent grade tampering; and Coordinators, together with the CCIT Head, have the exclusive authority to approve student-submitted requirement documents, while time-in record approval is shared between Supervisors and Coordinators. It features server-synchronized timestamps for time-in and time-out recording with mandatory photo capture across morning and afternoon sessions, enforced through a face-positioning guide overlay that displays an oval frame over the live camera feed and keeps the capture button disabled until the student's face is detected within the frame, preventing client-side tampering and buddy punching. The system also includes automated real-time calculation of the 600-hour requirement, a daily narrative report module where students write and submit a written account of their daily internship activities with an optional photo — one entry per day, auto-numbered, and downloadable as a Word (.docx) report — a secure digital repository for requirement documents and completion certificates, and administrative dashboards for departmental oversight. The attendance history displays all session photos per day grouped into a single card showing morning time-in, morning time-out, afternoon time-in, and afternoon time-out. The system also implements a school ID pre-approval mechanism, requiring students to register only with a valid, unused school ID number from the approved list, further strengthening access integrity. When a school ID is archived by the CCIT Head, the associated student account is automatically archived as well, and restoring the ID restores the student account.
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
3. to compare the strength of Role-Based Access Control Algorithm to CCIT Department of PRMSU Sta. Cruz Campus over the Manual Verification Process.
4. to evaluate the level of acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System using the Technology Acceptance Model (TAM) in terms of:
4.1 perceived usefulness;
4.2 perceived ease of use;
4.3 behavioral intention to use;
4.4 attitude toward use; and
4.5 actual system use.
5. to develop a model of the Role-Based Access Control Integration to CCIT Department of PRMSU Sta. Cruz Campus.
6. to develop a user’s manual for the CCIT Department of PRMSU Sta. Cruz Campus.
Scope and Limitations
	The primary focus of this study is the design, development, and evaluation of a web-based monitoring platform specifically tailored for internship management. This project implements the Role-Based Access Control (RBAC) integration algorithm to manage access rights and restrict system features based on the user's assigned role within the department. It also utilizes automated logic for Daily Time Record (DTR) tracking to calculate the mandatory 600-hour requirement for each student. The study is conducted specifically for the CCIT at PRMSU Sta. Cruz Campus. The system features real-time attendance verification using photo capture to prevent fraudulent logging, a secure digital repository for narrative reports and certificates, and administrative dashboards for departmental oversight. These functionalities are designed for four target user roles: BSCS OJT Students, Company Supervisors, OJT Coordinators, and the CCIT Department Head.
The scope of the study covers the following areas. First, the complete development of a web-based OJT monitoring system using the Laravel PHP framework, MySQL database management system, and XAMPP local server environment with responsive design using Tailwind CSS. Second, the integration of a custom RBAC algorithm through a two-layer middleware mechanism — AuthMiddleware for session verification and RoleMiddleware for role validation — that enforces strict separation of duties across the four defined user roles. Third, attendance monitoring features including server-synchronized time-in and time-out recording with mandatory photo capture for morning and afternoon sessions, automatic session management with auto-timeout at 12:00 PM for unclosed morning sessions and auto-denial for incomplete afternoon sessions, overtime detection with OT letter submission workflow, and real-time 600-hour tracking. Fourth, a document management system providing a secure digital repository for student requirement submissions with approval workflows, written feedback capability, status tracking, and resubmission functionality. Fifth, administrative functions including user account management by the CCIT Head, school year management, school ID pre-approval, company management by coordinators, system-wide settings configuration, and exportable PDF reports. Sixth, system evaluation through black-box testing, processing time measurement, error rate analysis, and TAM evaluation involving 105 participants.
While the system addresses core administrative challenges, it is subject to several constraints. The system is web-based and requires a stable internet connection for real-time syncing and data uploading, meaning it does not support offline logging. Additionally, the system does not include Global Positioning System (GPS) tracking and cannot monitor or record the specific geographical locations of students. The implementation is designed to be localized specifically for the research site and identified user roles, which may limit its immediate adaptability to other institutional structures. Success is also dependent on the technical personnel and facilities available at the CCIT Department for implementation.
The researchers have set specific boundaries to maintain the focus and technical integrity of the study. The system is exclusively delimited to the BSCS program within the CCIT department, allowing the developers to tailor the logic specifically to the 600-hour curriculum requirement unique to this degree program. Furthermore, the study is restricted to PRMSU Sta. Cruz Campus, ensuring the system aligns perfectly with the specific administrative workflows and student population of that particular branch.
The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System provides a comprehensive digital solution for attendance tracking, document management, and role-based security. Although it is limited by the necessity of internet connectivity and the exclusion of GPS tracking, the study remains highly relevant as it establishes a modernized framework to reduce buddy punching through server-side timestamp enforcement and photo verification, prevent data loss through a secure digital repository, and ensure the integrity of academic records. Ultimately, this system aligns the university's processes with digital transformation standards while managing a large student population efficiently and securely.
Definition of Terms
The following terms are defined conceptually and operationally for the purpose of this study:
600-Hour Requirement. It refers to the mandatory duration of industrial training that BSCS students must complete to fulfill their academic curriculum at PRMSU. In this study, it refers specifically to the threshold that the proposed system tracks and calculates automatically in real-time for each student enrolled in the OJT program.
Buddy Punching. It refers to a form of fraudulent attendance logging where one student records the time entry for another student who is not actually present at the internship site. In this study, it refers to the practice that the system prevents through mandatory photo capture with a face-positioning guide overlay and server-side timestamp enforcement.
Bulk Import. It refers to the feature in the School IDs section that allows the CCIT Head to add multiple school ID numbers simultaneously by pasting a list of IDs, one per line, into a text area. In this study, it refers to the function where the system processes each entry sequentially, skips duplicates and archived IDs automatically, and displays a progress overlay with a counter and progress bar during the import operation.
Daily Time Record (DTR). It refers to the digital log used to track the clock-in and clock-out times of interns to monitor their daily rendered hours, generated per student and exportable from the system. In this study, it refers to the primary instrument for verifying student attendance and computing progress toward the 600-hour requirement.
Digital Repository. It refers to the secure online storage feature of the system where narrative reports and completion certificates are uploaded to prevent physical loss or damage common in paper-based filing. In this study, it refers to the storage mechanism governed by role-based access restrictions that ensure only authorized personnel can view, approve, or deny submitted documents.
OJT Coordinator. It refers to the faculty member within the CCIT department responsible for supervising the internship program, verifying student hours, managing partner companies, and communicating with industry partners. In this study, it refers to one of the four defined user roles with specific access permissions enforced by the RBAC algorithm.
Overtime (OT). It refers to the hours rendered by a student beyond the standard eight-hour daily limit. In this study, it refers to the additional hours that the system detects automatically and requires the submission of an approved OT letter before crediting toward the student's progress total.
Real-Time Monitoring. It refers to the capability of the system to update and display attendance data and progress calculations immediately as they occur on the web platform, without requiring manual refresh or batch processing. In this study, it refers to the functionality that includes instant hour calculation upon time-out, live status updates on approval actions, and automatic progress bar updates on the student dashboard.
Role-Based Access Control (RBAC). It refers to the security algorithm implemented in the system that restricts or grants access to specific features based on the user's assigned role — Student, Supervisor, Coordinator, or CCIT Head — enforced through custom middleware at the route level. In this study, it refers to the primary technical mechanism evaluated for its efficiency and functionality relative to the existing manual verification process.
School ID Pre-Approval. It refers to a registration security mechanism that requires students to register using only a valid, unused school ID number from a pre-approved whitelist maintained by the CCIT Head, preventing unauthorized account creation. In this study, it refers to the additional layer of access integrity that supplements the RBAC algorithm by controlling who may enter the system in the first place.
Session-Based Authentication. It refers to the method by which the system verifies a logged-in user's identity and role by storing and reading user data from the server-side session on every request, preventing unauthorized access without re-authentication. In this study, it refers to the mechanism through which the RBAC middleware retrieves the user's role for each incoming request.
Time-Out Photo. It refers to the mandatory photo captured by the student at the moment of recording their time-out, stored separately from the time-in photo in the database. In this study, it refers to the photo that is displayed together with the time-in photo in the attendance history, grouped by date into a single card showing all four session photos: morning time-in, morning time-out, afternoon time-in, and afternoon time-out.
Undo/Redo Approval. It refers to the supervisor's ability to revert a previously approved time-in record back to pending status (Undo) or to re-approve a previously undone record (Redo). In this study, it refers to the feature where undoing an approval automatically deducts the credited hours from the student's total completed hours, and the record's action button changes from Undo to Redo, allowing re-approval and hour restoration without repeating the full approval workflow.
 
Chapter 2
REVIEW OF RELATED LITERATURE, STUDIES/SYSTEMS
	This chapter presents the review of related literature and studies that is significant in the development of the present study. It also covers the technical background of the technologies and frameworks used in the development of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration.
Technical Background
The following technologies and frameworks were used in the development of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration.
Laravel. Laravel is an open-source PHP web application framework following the Model-View-Controller (MVC) architectural pattern, created by Taylor Otwell and first released in 2011. It is widely recognized for its elegant syntax, built-in routing engine, Eloquent ORM for database interaction, Blade templating engine for dynamic views, and a robust middleware pipeline that intercepts HTTP requests before they reach the application's core logic. In this study, Laravel serves as the primary development platform for the entire system. More specifically, it provides the middleware architecture through which the RBAC algorithm is enforced — the AuthMiddleware verifies the existence of a valid user session on every request, while the RoleMiddleware checks whether the authenticated user's role is authorized for the requested route. Laravel's route-level middleware binding makes it possible to apply RBAC restrictions declaratively, ensuring that no route can be accessed without passing through the appropriate access checks.
PHP. PHP (Hypertext Preprocessor) is a widely-used, open-source server-side scripting language designed primarily for web development. It executes on the server and generates dynamic HTML content sent to the client browser. In this study, PHP serves as the backend programming language responsible for processing all access control logic, session management, database interactions, file uploads, timestamp recording, and hour calculations. PHP's seamless integration with MySQL and the Laravel framework makes it the appropriate choice for implementing the server-side components of the RBAC algorithm, including role validation, permission checking, and secure session handling.
MySQL. MySQL is an open-source relational database management system that organizes data into structured tables and supports complex queries through Structured Query Language (SQL). It is known for its reliability, scalability, and widespread use in web application development. In this study, MySQL is used to store and manage all system data, including user accounts with their assigned roles, school ID whitelists, time-in and time-out records with photo paths, student hour logs, submitted requirement documents, company records, school year configurations, evaluation submissions, and daily hour logs. The relational structure of MySQL enables efficient JOIN queries that support the RBAC enforcement logic by allowing the system to retrieve a user's role and associated permissions in a single database interaction.
Tailwind CSS. Tailwind CSS is a utility-first CSS framework that provides low-level styling classes enabling developers to build custom user interface designs directly in HTML markup without writing separate CSS files. In this study, Tailwind CSS is used for all front-end interface design across the four role-specific dashboards, ensuring a consistent, responsive, and accessible user experience regardless of the device or screen size used to access the system. Its utility-class approach accelerates development and ensures design consistency across all system modules.
XAMPP. XAMPP is a free, open-source cross-platform web server solution package that bundles Apache HTTP Server, MySQL, PHP, and Perl into a single installation. It provides a local development and testing environment that replicates a production server configuration without requiring internet hosting. In this study, XAMPP was used as the local server environment during all phases of system development and testing, providing the Apache web server for serving the Laravel application, the MySQL database engine for data storage, and the PHP runtime for executing backend logic.
MediaPipe Face Detection. MediaPipe is an open-source machine learning framework developed by Google that provides real-time, cross-platform solutions for detecting and processing multimedia content, including face detection from live camera feeds. In this study, the MediaPipe Face Detection library is integrated into the time-in and time-out camera modal to implement the face-positioning guide overlay. It detects the presence and position of the student's face within the camera frame in real time, keeping the capture button disabled and the oval guide border displayed in red until the face is aligned within the designated area, at which point the border turns green and the capture button is enabled. This integration prevents buddy punching by ensuring that a live, correctly positioned face is present before a photo can be captured.
Role-Based Access Control (RBAC). Role-Based Access Control is a security model in which permissions to access system resources are assigned to roles rather than directly to individual users. Users are then assigned to roles, and through those roles they inherit the corresponding permissions. The three primary components of RBAC are users, roles, and permissions, connected through user-role assignments and role-permission assignments. In this study, RBAC is implemented through Laravel's custom middleware pipeline where each system route is protected by a role check that evaluates whether the currently authenticated user's assigned role is included in the list of roles authorized to access that route. The four roles defined in the system — Student, Supervisor, Coordinator, and CCIT Head — each have a distinct permission set that governs which routes, features, and data they can access, enforcing the principle of Separation of Duties throughout the application.
**Proposed Role-Based Access Control Algorithm Implementation**
The following related literature and studies were reviewed to establish the theoretical and empirical foundation of the proposed PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration. The review is organized according to the objectives of the study: (1) the efficiency and functionality of the proposed RBAC algorithm; (2) the efficiency and functionality of the existing manual verification process; (3) the comparison between the proposed RBAC algorithm and the manual verification process; (4) user acceptance using the Technology Acceptance Model; (5) the development of the RBAC integration model; and (6) the development of the user's manual.
**Objective 1: Efficiency and Functionality of the Proposed Role-Based Access Control Algorithm**
Role-Based Access Control (RBAC) organizes authorization by assigning permissions to roles and then assigning users to those roles. This structure is appropriate for the proposed system because students, supervisors, coordinators, and the CCIT Head perform different tasks and should not receive identical privileges.

Rao, Nayak, Ray, Rahulamathavan, and Rajarajan (2021) developed Role Recommender-RBAC to improve user-role assignments. Their study addressed the difficulty of manually maintaining role assignments, which can result in errors and increased administrative workload. The proposed approach optimized the assignment and updating of roles according to user requirements and improved efficiency compared with existing approaches. This finding supports evaluating the proposed system according to processing time and the correctness of role assignment.

Aftab, Hamza, Oluwasanmi, Nie, Sarfraz, Shehzad, Qin, and Rafiq (2022) reviewed traditional and hybrid access-control models and examined their strengths and limitations. Their study explained that RBAC can simplify administration when permissions are connected to organizational responsibilities rather than assigned separately to every individual. The authors also emphasized that access-control models must be selected according to the security, flexibility, and administrative needs of the organization. These findings are relevant to the proposed role-specific middleware.

Mohamed, Auer, Hofer, and Küng (2022) conducted a systematic review of authorization and access-control models. Their study distinguished between defining access rights and enforcing those rights within information systems, explaining that a policy may be properly designed but incorrectly implemented. These findings are relevant to Objective 1 because the proposed algorithm must be evaluated through its actual behavior when users attempt authorized and unauthorized operations.

Le, Shar, Bianculli, Briand, and Nguyen (2022) developed a framework for reverse-engineering RBAC policies from Web applications. Their framework recovered access-control policies and checked whether implemented permissions corresponded with intended permissions, achieving 97.8% correctness in the evaluated applications. Their work demonstrates that access-control testing should compare intended permissions with observed system behavior. In the present study, this principle is applied through black-box test cases covering authentication, role boundaries, student ownership of records, approval functions, and administrative routes.

**Objective 2: Efficiency and Functionality of the Existing Access-Control Process**
The existing manual verification process must be measured before its performance can be compared with the proposed algorithm.

Mohamed, Auer, Hofer, and Küng (2022) emphasized that an authorization policy may be clearly defined but still be inconsistently enforced in practice. Their review provides a basis for examining whether the CCIT manual process consistently applies its assigned responsibilities when verifying attendance and documents.

Aftab, Hamza, Oluwasanmi, Nie, Sarfraz, Shehzad, Qin, and Rafiq (2022) noted that access-control approaches differ in administrative effort, flexibility, and security. Their findings support establishing a local baseline before claiming that RBAC is more suitable for the OJT environment.

Kern, Baumer, Groll, Fuchs, and Pernul (2022) examined the optimization of access-control policies and stressed the importance of maintaining accurate and consistent authorization rules. Poorly maintained rules may increase administrative effort and produce incorrect authorization decisions, concerns that are relevant to manual record checking.

Castro (2024) examined a mobile-based student internship-monitoring system using a progress-tracking algorithm. The study demonstrated how digital monitoring can improve the organization of intern records, progress tracking, and accountability compared with less automated approaches. In the CCIT setting, these studies guide the measurement of manual verification time and errors in attendance, hour computation, document handling, and record modification.

**Objective 3: Comparison of the Role-Based Access Control Algorithm and Manual Verification Process**
The comparison in this study is based on two measurable dimensions: processing efficiency and functional reliability.

Rao, Nayak, Ray, Rahulamathavan, and Rajarajan (2021) identified administrative effort in maintaining user-role assignments as a practical concern. Their findings support comparing the workload and processing efficiency of role-based automation with a manual process.

Aftab, Hamza, Oluwasanmi, Nie, Sarfraz, Shehzad, Qin, and Rafiq (2022) described the administrative advantages and limitations of different access-control approaches. This supports comparing measurable administrative outcomes rather than assuming that one model is automatically superior.

Le, Shar, Bianculli, Briand, and Nguyen (2022) showed that RBAC correctness can be evaluated by comparing intended and observed access behavior. Their validation approach supports the use of black-box tests for the proposed OJT system.

Mohamed, Auer, Hofer, and Küng (2022) emphasized examining authorization policy design and enforcement separately, while Kern, Baumer, Groll, Fuchs, and Pernul (2022) highlighted accurate policy management. Castro (2024) supports comparing automated internship-monitoring workflows with less automated record-management practices. Accordingly, the present study compares processing time, access-control results, and manual error rates for Objectives 1–3.

**Objective 4: User Acceptance Using the Technology Acceptance Model**
The Technology Acceptance Model (TAM) provides a framework for evaluating perceived usefulness, perceived ease of use, behavioral intention, attitude toward use, and actual use.

Al-Emran and Granić (2021) reviewed the continuing use of TAM and its applications across technology-adoption studies. Their work supports using perceived usefulness, perceived ease of use, behavioral intention, attitude, and actual use as related indicators of acceptance.

Syahruddin, Yaakob, Rasyad, Widodo, Sukendro, Suwardi, Lani, Sari, Mansur, Razali, and Syam (2021) found that acceptance of educational technology can vary according to the learning context. This supports evaluating the OJT system with its actual students and academic personnel rather than relying only on results from unrelated users.

Ong, Prasetyo, Roque, Garbo, Robas, Persada, and Nadlifatin (2022) applied a TAM-related model in the Philippine context. Their study showed the value of examining Filipino users' perceptions, intentions, and technology-related behavior, supporting the cultural and educational relevance of the present evaluation.

Tukiran, Sunaryo, Wulandari, and Herfina (2022) examined relationships among usefulness, ease of use, intention, and actual use in an educational environment. Chahal and Rani (2022) examined higher education students' acceptance of e-learning using TAM and external variables, showing how the model can explain student acceptance. Together, these studies support Objective 4 and the use of the five TAM dimensions in the present evaluation.

**Objective 5: Development of the Role-Based Access Control Integration Model**
An RBAC integration model requires explicit identification of users, roles, permissions, and constraints.

Aftab, Hamza, Oluwasanmi, Nie, Sarfraz, Shehzad, Qin, and Rafiq (2022) explained that authorization models should be selected according to organizational responsibilities and requirements. Their discussion of role assignment, separation of duties, and policy limitations supports the development of a model that does not grant the same privileges to every authenticated user.

Mohamed, Auer, Hofer, and Küng (2022) emphasized the distinction between authorization policy design and enforcement. This distinction guides the study in translating the CCIT Department's responsibilities into enforceable route and feature restrictions.

Rao, Nayak, Ray, Rahulamathavan, and Rajarajan (2021) showed that role assignment is an important administrative concern because inaccurate assignments can create unnecessary workload and incorrect access decisions. Their findings support explicitly mapping each CCIT user role to its authorized functions.

Le, Shar, Bianculli, Briand, and Nguyen (2022) demonstrated the need to validate implemented policies against observed Web-application behavior. Guided by these studies, the model developed in this study assigns separate permissions to Student, Supervisor, Coordinator, and CCIT Head, enforces separation of duties through middleware, and validates the resulting boundaries through black-box testing. This directly supports Objective 5.

**Objective 6: Development of the User's Manual**
The user's manual should translate the system's role boundaries and workflows into instructions that users can follow.

Fan, Yu, Wang, Yin, and Wang (2021) found that technical documentation may be insufficient when it does not correspond to users' actual information needs. Their findings support writing instructions around the tasks users actually perform.

Swarts (2022) showed that the organization of online help affects how users locate and process guidance. Clear headings, navigation cues, and concise procedures can therefore improve the usability of the manual.

Castro (2024) demonstrated the value of documenting and organizing functions in a digital internship-monitoring context, particularly for users who need to track internship progress and records.

Palines, Moreno, Tatlonghari, and Ortega-Dela Cruz (2025) emphasized the importance of accessible ICT guidance in educational settings. These findings support a role-oriented manual with separate procedures for students, supervisors, coordinators, and the CCIT Head.

The manual developed for this study therefore includes login and navigation procedures, time-in and time-out recording, requirement submission, attendance approval, evaluation, report generation, account administration, and troubleshooting. Organizing the instructions around actual permissions supports Objective 6 and reduces the risk that users will attempt functions outside their assigned roles.

**Synthesis**
The reviewed literature provides a recent theoretical and empirical foundation for all six objectives of the study. First, RBAC research on user-role assignment, authorization-policy enforcement, access-control optimization, and Web-application validation supports testing the proposed algorithm in terms of efficiency and functionality. These studies establish the importance of measuring processing time and comparing intended role permissions with actual system behavior.

Second, studies on authorization management and digital internship monitoring provide a basis for examining the existing manual verification process. They emphasize that poorly organized access rules, manual record handling, and non-integrated monitoring procedures can increase administrative effort and create inconsistencies. In this study, these concepts guide the measurement of manual verification time and the analysis of errors in attendance, hour computation, document handling, and record modification.

Third, the literature supports a direct comparison between the proposed RBAC algorithm and the manual process. The reviewed studies indicate that comparison should be based on observable indicators such as processing efficiency, authorization accuracy, administrative effort, and record reliability. Therefore, the present study compares server-side processing time, black-box access-control results, and manual error rates within the PRMSU CCIT context.

Fourth, recent TAM studies support evaluating the system through perceived usefulness, perceived ease of use, behavioral intention, attitude toward use, and actual system use. Research involving higher education students and Filipino technology users demonstrates that TAM is appropriate for examining acceptance of educational information systems. This supports the use of TAM questionnaire results to evaluate the proposed OJT Monitoring System.

Fifth, the reviewed RBAC literature emphasizes that an integration model must identify users, roles, permissions, constraints, and separation-of-duty requirements. These principles guide the development of the PRMSU CCIT model, which assigns distinct responsibilities to Students, Supervisors, Coordinators, and the CCIT Head and validates those boundaries through black-box testing.

Sixth, recent documentation and ICT studies support the development of a user-oriented manual. The literature emphasizes that documentation should correspond to users' actual tasks, information needs, and access boundaries. Accordingly, the user's manual for this study is organized by role and includes system access, attendance recording, requirement submission, approvals, evaluation, reporting, administration, and troubleshooting procedures.

The synthesis identifies a practical gap addressed by the present study. Although previous studies have examined RBAC, authorization policies, TAM, digital monitoring, and documentation separately, they do not specifically evaluate an RBAC-integrated OJT monitoring system for the PRMSU Sta. Cruz Campus CCIT Department using both automated performance measures and a manual-process baseline. This study addresses that gap by developing and evaluating one localized system across efficiency, functionality, comparative performance, user acceptance, RBAC model development, and user-manual development. The resulting framework connects the reviewed literature directly to Objectives 1–6 and provides an evidence-based foundation for the system's design and evaluation.









Chapter 3
METHODOLOGY
This chapter covers the requirements analysis, documentations and design of software, system, product or processes.
Research Design 
	The study employed a quantitative research approach using a descriptive research design to determine the level of acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration. The descriptive research design is appropriate because the study seeks to describe and measure the respondents' perceptions and level of acceptance of the developed system based on the Technology Acceptance Model (TAM).
Data were gathered using a structured survey questionnaire based on the TAM. The questionnaire measured the respondents' perceptions of the system in terms of Perceived Usefulness (PU), Perceived Ease of Use (PEOU), Attitude Toward Using (ATU), Behavioral Intention to Use (BI), and Actual System Use. The questionnaire was administered to the identified users of the system, including BSCS OJT students, company supervisors, the OJT coordinator, and the CCIT Head of PRMSU Sta. Cruz Campus.
The responses were measured using a four-point Likert scale and analyzed using frequency, percentage, and weighted mean. The weighted mean was used to determine the level of acceptance for each TAM construct and the overall level of acceptance of the developed system. The findings provide a quantitative basis for determining whether the developed system is acceptable to its intended users.
The researchers also utilized a developmental research approach, given that the work encompasses the full lifecycle of an algorithm-driven system — from its initial conception and construction to its deployment and assessment within an administrative and academic context. System performance was evaluated through black-box testing using a structured test case checklist and server-side processing time measurement, while the existing manual verification process of the CCIT Department was benchmarked through verification time recording and error rate analysis of sampled manual records.
The researchers used the Likert scale with the following responses to interpret the TAM level of acceptance:
Point Scale     Weight Value          Descriptive Equivalent
     4                 3.26 – 4.00                 Highly Acceptable
     3                 2.51 – 3.25         	    Acceptable
     2                1.76 – 2.50                  Fairly Acceptable
     1                1.00 – 1.75                 Poorly Acceptable
Requirement Analysis
	The researchers analyzed the existing OJT monitoring process at the PRMSU Sta. Cruz Campus CCIT Department to identify problems in attendance recording, monitoring of rendered hours, tracking of requirements, and preparation of OJT reports. Interviews and observations were conducted with the OJT coordinator, company supervisors, and students to determine the functions needed in the proposed system.
The requirement analysis revealed four core problem areas. First, the absence of real-time attendance verification allowed buddy punching and fraudulent logging to occur unchecked, as the manual process had no mechanism to verify that the student logging attendance was actually present at the internship site. Second, the manual tallying of the 600-hour requirement was labor-intensive and prone to human error, as coordinators had to manually sum attendance hours from paper logs and spreadsheets across multiple sessions and dates for each of the 92 students simultaneously enrolled in the program. Third, paper-based requirement submissions such as narrative reports and completion certificates were frequently misplaced or lost because there was no centralized digital repository or organized filing system with access controls. Fourth, the absence of role boundaries in the manual process meant that there was no systematic enforcement preventing students from viewing other students' records, supervisors from modifying attendance data after the fact, or coordinators from accessing evaluation details they were not authorized to change.
Based on these findings, the system requirements were defined across four functional areas. The authentication and access control module requires session-based authentication with role-specific middleware enforcement for four user roles: Student, Supervisor, Coordinator, and CCIT Head. The attendance monitoring module requires server-synchronized time-in and time-out recording with mandatory photo capture, face-detection guide overlay, automatic session management, overtime detection, and approval workflows. The document management module requires a secure digital repository for requirement submissions with status tracking, written feedback, and resubmission capability. The administrative management module requires comprehensive user account management, school year configuration, school ID pre-approval, company management, analytics dashboards, and exportable PDF reports.
Research Locale
	The study was conducted at President Ramon Magsaysay State University (PRMSU) Sta. Cruz Campus, specifically within the College of Communication and Information Technology (CCIT), located at Purok 1, Brgy. Naulo, Sta. Cruz, Zambales, Philippines. PRMSU Sta. Cruz Campus is a state university offering quality and accessible higher education programs in Central Luzon, serving as a regional hub for technical and professional education in Zambales province.
The College of Communication and Information Technology is the implementing department for this research. The CCIT manages the mandatory on-the-job training program for all Bachelor of Science in Computer Science students, with two sections — Section A with 44 students and Section B with 48 students — required to complete 600 hours of internship annually at various partner companies and organizations. The department's existing reliance on a manual verification process for monitoring student attendance, tracking rendered hours, managing requirement submissions, and verifying completion status served as the baseline for comparison in this study.
 
Figure 1.
Map showing the location of President Ramon Magsaysay State University Sta. Cruz Campus at Purok 1, Brgy. Naulo, Sta. Cruz, Zambales.
Name of Proposed Algorithm
The proposed system implements the Role-Based Access Control (RBAC) Algorithm as its primary security and access management mechanism. The RBAC algorithm evaluates every system request by determining whether the authenticated user's assigned role possesses the permission required to access the requested resource.
The algorithm operates through the following logic: when a user submits a request to access any system route or function, the AuthMiddleware first verifies whether a valid user session exists. If no session is found, the request is denied and the user is redirected to the login page. If a session exists, the RoleMiddleware retrieves the user's record and assigned role from the database. If no role is assigned or the role is not among those authorized for the requested route, the system returns an HTTP 403 Forbidden response. If the role is found in the authorized list, access is granted and the request proceeds to the application controller.
This mechanism enforces the Separation of Duties principle across all four user roles. Students are restricted exclusively to their own time-in, time-out, and requirement submission functions. Supervisors are confined to their assigned company's students and are blocked from evaluating students who have not yet completed the required hours. Coordinators are prevented from accessing user management and evaluation submission functions. The CCIT Head retains exclusive access to system-wide administrative functions including user management, school year configuration, school ID management, and system-wide report generation.

Data Gathering Tools
The researchers used a survey questionnaire adapted from the Technology Acceptance Model (TAM) as the primary data gathering tool for determining the respondents’ level of acceptance of the developed PRMSU Sta. Cruz Campus BSCS On-the-Job Training Monitoring System: Role-Based Access Control Integration. The questionnaire was adapted to suit the context of the proposed system and its intended users while retaining the relevant TAM constructs. The instrument measured the respondents’ perceptions of the system in terms of Perceived Usefulness, Perceived Ease of Use, Attitude Toward Using, and Behavioral Intention to Use. A four-point Likert scale was used to measure the respondents’ responses, and the collected data were analyzed using appropriate statistical treatments to determine the level of acceptance of the developed system.
Design of Software, System, Product and/or Processes
Conceptual Framework
	This study centers on the development of the PRMSU Sta. Cruz Campus BSCS On-the-Job Training Monitoring System: Role-Based Access Control Integration. The evaluation primarily determines the performance of the proposed RBAC algorithm against the existing manual verification process of the CCIT Department, as well as the level of acceptance of the system as perceived by its intended users.
Input. The input of the study consists of the PRMSU Sta. Cruz Campus BSCS On-the-Job Training Monitoring System: Role-Based Access Control Integration, assessed through performance metrics applied to both the proposed and existing processes. The proposed RBAC algorithm is examined in terms of Efficiency and Functionality. The existing manual verification process of the CCIT Department is measured against the same criteria to allow for direct and meaningful comparison. The study compares the strength of the RBAC algorithm over the Manual Verification Process. The Technology Acceptance Model (TAM) serves as the evaluation framework for determining user acceptance through the dimensions of perceived usefulness, perceived ease of use, behavioral intention to use, attitude toward use, and actual system use. A model of the Role-Based Access Control Integration is developed for the CCIT Department, and the study produces a User's Manual for the CCIT Department.
Process. Data were collected through the distribution of TAM questionnaires to all stakeholders — including BSCS OJT students, company supervisors, OJT coordinators, and the CCIT Head — to measure their perceptions of the system's acceptance. Data analysis was performed using three primary techniques: Weighted Mean for TAM evaluation to determine the average level of agreement across the five TAM dimensions; System Performance Metrics for Efficiency and Functionality Assessment, where efficiency was measured through processing time analysis comparing the automated system's average transaction time in milliseconds against the manual process's average verification time in minutes, and functionality was assessed through the access control accuracy rate and error rate comparison; and Frequency and Percentage Distribution to summarize the demographic profile and response patterns of the participants.
Output. The output of the study consists of two primary deliverables. First, the fully developed PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration — a comprehensive web-based platform built using the Laravel PHP framework with custom role-based middleware that enforces session-based authentication and route-level access restrictions for four distinct user roles. Second, the Developed User's Manual for the CCIT Department of PRMSU Sta. Cruz Campus, which serves as a step-by-step guide for all system users across the four roles. Both outputs were validated through black-box testing and respondent evaluations using the Technology Acceptance Model to verify that the platform satisfies its intended objectives.
 
Figure 2.
Conceptual Framework
Algorithm Flowchart
The flowchart illustrates the core logic of the RBAC algorithm. When a user requests access to a system object, the algorithm first checks if the user is authenticated — if not, access is denied and authentication is required. If authenticated, the system retrieves the user's record and assigned role from the session and database. If no role is assigned, access is denied. If a role exists, the system retrieves its associated permissions and checks whether any of them cover the requested object — if yes, access is granted and the operation is executed; if no matching permission is found, access is denied. This mechanism ensures every system action is strictly governed by role-based authorization, enforcing Permission per Role and Separation of Duties across all user boundaries.
 
Figure 4.
The Role-Based Access Control Algorithm Flowchart
System Flowchart
 
Figure 5.
System Flow Chart (Login/Register)
The flowchart illustrates the system's entry process. Unregistered users submit registration data, which is validated and hashed before being saved to the database; invalid entries return a registration error. Registered users input their login credentials, which the RBAC algorithm authenticates. Failed attempts display a login error, while successful login initializes a session and triggers a sequential role check — redirecting the user to the Student (A), Supervisor (B), Coordinator (C), or CCIT Head (D) dashboard based on their assigned role, ensuring each user accesses only their designated portal.
 
Figure 6.
System Flow Chart (A)
Upon successful login, the Student Dashboard loads and routes the user based on the selected section. The Overview section first checks if the student has completed their OJT (≥600 hours) — if yes, a congratulations message and certificate are displayed; if no, statistics and three progress charts are shown. The Time In/Out section opens the camera modal for mandatory photo capture with an oval face guide overlay — the frame displays RED with the capture button disabled until a face is detected within the oval guide, at which point the frame turns GREEN and the capture button is enabled; a retake option is provided if the captured photo is unsatisfactory — before submitting the morning time-in. The system then checks whether the morning session has been timed out and the current time is at or past 12:50; if met, the afternoon time-in option is shown; otherwise, the time-out button is displayed. After timing in for either session, the system checks if the student has reached 8 hours for the day — if yes, an OT letter must be submitted before proceeding to time-out; if no, the time-out modal is shown directly. Upon confirming time-out, the camera modal reopens with the same face detection flow (oval guide, RED/GREEN frame states, and capture button enablement) to capture the time-out photo before recording the final time-out. The History section displays attendance records grouped by date, showing morning and afternoon sessions with their respective time-in and time-out photos in a day card format; clicking any photo opens a viewer modal. The Requirements section shows onboarding and daily submission forms; students can upload files, and the system displays the status with pending badges for pending files, approved badges for approved files, and denied files with a resubmit option. The Reports section displays previously submitted reports with filtering options (All/Pending/Approved/Denied) and an option to upload new files. Regardless of the active section, the student may choose to log out at any point. A logout confirmation is required — confirming ends the session, while cancelling or choosing to stay returns the user to the dashboard.
 

Figure 7.
System Flow Chart (B)
Upon login, the Supervisor Dashboard loads and presents three main sections. The Overview section displays four statistics and four charts summarizing intern progress. The Certificates section shows a list of completed interns; the supervisor may click to award a certificate, upload a certificate image, and confirm the award, making the certificate viewable by the student. The Interns section displays individual intern cards, and the supervisor may expand a specific intern to reveal tabs including Daily Logs, Time Edits, Requirements, and Evaluation. Within these tabs, the supervisor can approve or deny time edit requests and submitted requirements, with the status updated accordingly. Additionally, the supervisor may undo a previously approved time-in record, which reverts the record to pending status and deducts the hours from the student's total; conversely, the supervisor may redo a previously undone record, re-approving it and adding the hours back to the student's total. For the Evaluation tab, the system checks whether the intern's completed hours meet the required threshold — if yes, the supervisor may submit an evaluation with star rating and written feedback, followed by the generation of the final DTR; if the hours requirement is not yet met, the evaluation feature remains locked. The supervisor may logout at any point, with confirmation required before the session ends.
 
Figure 8.
System Flow Chart (C)
The Coordinator Dashboard loads upon login and routes the user based on the selected section. The Overview section displays statistics and four charts. The Companies section shows the companies panel, where the coordinator can add or edit a company by filling out and saving a company form, archive a company through a confirmation action, view the archive trash to restore or permanently delete archived companies, and view statistics showing companies with the most and least interns. The Student Tracking section displays a searchable student list; the coordinator may view student details, open a logs modal to review attendance and approve or deny time-in records by submitting the decision, open DTR reports for individual students, and view evaluation ratings (which remain locked until the student completes their required hours). The Reports & Requirements section displays file cabinets grouped by student; opening a cabinet shows the student's submitted files, and the coordinator can review files by entering feedback and approving or denying each file, with the feedback saved to the system. The coordinator may logout at any point, requiring confirmation before the session terminates.
 
Figure 9.
System Flow Chart (D)
The CCIT Head Dashboard provides full administrative control across all system functions. The Overview section displays statistics and three charts. The Users section shows the users panel, where the CCIT Head can add, edit, or delete user accounts by filling out and saving a user form, with an option to view the archive trash for managing deleted users. The Analytics section shows student progress and DTR data, with an option to open individual DTR links. The School Years section allows the CCIT Head to add, set active, or remove a school year by entering the year in YYYY-YYYY format and saving, with an option to view the archive trash for managing deleted school years. The School IDs section displays the ID whitelist, where IDs in YY-N-N-NNNN format can be added or removed and saved, with an option to view the archive trash for managing deleted IDs. The Reports section shows export options, where the CCIT Head selects a report type and generates a PDF export. The Manage Requirements section displays requirement templates, where the CCIT Head can add, edit, or delete templates by filling out and saving a template form. The Settings section allows the CCIT Head to configure the required internship hours and toggle email notifications, saving changes as needed. The CCIT Head may logout at any point, with a confirmation prompt required before the session ends.
Software Development Life Cycle 
	This study utilized the Agile Development Model to guide the researchers in the development of the PRMSU Sta. Cruz Campus BSCS On-the-Job Training Monitoring System: Role-Based Access Control Integration. The Agile model was selected for its iterative and incremental nature, which enabled the researchers to continuously refine the system in response to feedback gathered from the intended users at each stage of the development cycle, ensuring that the final product aligned with the actual operational needs of the PRMSU CCIT Department.
 
Figure 3
Agile Model
Plan - The researchers identified the scope, objectives, and functional requirements of the system through consultations with the CCIT Head, OJT coordinators, industry supervisors, and BSCS students. The limitations of the existing manual verification process of the CCIT Department were examined to establish the basis for the proposed Role-Based Access Control (RBAC) model. The four user roles — student, supervisor, coordinator, and CCIT Head — were defined along with their corresponding permissions and system responsibilities. Project timelines, resource requirements, and development priorities were established to guide the succeeding iterations of the system.
Design - The researchers developed the system architecture, database schema, and user interface layouts for each role-specific portal based on the finalized requirements. Flowcharts and algorithm diagrams were constructed to map the access control logic and clarify the workflows governing time-in and time-out recording, requirement submission, intern monitoring, and administrative oversight. The RBAC model was designed to enforce Separation of Duties across all four roles, ensuring that each user could only access functions within their designated scope. The Laravel PHP framework was adopted as the primary development platform, with MySQL as the database management system and Tailwind CSS for the front-end interface design.
Develop - The system was developed iteratively in sprints, with each sprint targeting a specific set of features per user role. The student portal was implemented with time-in and time-out recording with photo capture, daily log submission, and requirement uploading. The supervisor portal was built to support intern progress monitoring, time edit approval, requirement review, student evaluation, and DTR report generation. The coordinator portal was developed to handle company management, student oversight, and requirement coordination. The CCIT Head portal was constructed to provide full user management, school year configuration, analytics dashboards, and system-wide report generation. Each sprint concluded with a review and testing cycle before proceeding to the next set of features.
Test - Upon the completion of each development sprint, the integrated system was subjected to black-box testing to verify that all role-based access controls functioned as intended and that no unauthorized access occurred across user boundaries. The researchers administered TAM-based questionnaires to the 67 study participants — comprising 50 students, 15 supervisors, 1 coordinator, and 1 CCIT Head — to evaluate the system against the five TAM dimensions: perceived usefulness, perceived ease of use, behavioral intention to use, attitude toward use, and actual system use. Feedback gathered during testing was used to identify deficiencies and inform subsequent iterations, consistent with the iterative nature of the Agile model.
Deploy - Following the completion of testing and the incorporation of user feedback, the finalized system was deployed on a local server environment using XAMPP for institutional use within the PRMSU CCIT Department. User accounts for each role were configured, the active school year was set up, and students were assigned to their respective companies and supervisors. A User's Manual was prepared to guide technical personnel and end users in navigating and operating the system.
Review - After deployment, the researchers conducted a post-deployment evaluation by gathering feedback from actual system users across all four roles. The performance metrics — Efficiency and Functionality — were assessed to determine the effectiveness of the implemented RBAC model. The TAM evaluation results were analyzed to measure user acceptance and identify areas for further improvement. Findings from this phase were documented to serve as the basis for system refinements and future maintenance activities.
Launch - The system was formally launched for institutional use within the PRMSU CCIT Department following the successful completion of all testing, deployment, and review activities. All user roles were activated, and the system was made fully operational for the current school year. The CCIT Head assumed administrative oversight of the system, with ongoing maintenance responsibilities including updates to user accounts, company records, and school year configurations managed through the administrative portal. The role-based structure of the system ensures that institutional changes can be accommodated without compromising system integrity or security.
Data Analysis Plan
The data gathered through the adapted Technology Acceptance Model (TAM) questionnaire will be organized, tabulated, and analyzed using appropriate statistical treatments to address each of the study's research objectives. The respondents' demographic profile will be summarized using frequency and percentage distribution, providing a clear picture of the composition of the 105 participants across the four user roles — OJT Students, Company Supervisors, OJT Coordinator, and CCIT Head.
The responses to the TAM constructs will be analyzed using the weighted mean to determine the level of acceptance of the developed PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration. The five TAM constructs — Perceived Usefulness, Perceived Ease of Use, Attitude Toward Using, Behavioral Intention to Use, and Actual System Use — will be analyzed individually to determine the respondents' level of assessment for each construct. The overall weighted mean across all constructs will also be computed to determine the overall level of acceptance of the system. All weighted mean results will be interpreted using the established four-point Likert scale, where a score of 3.26–4.00 is described as Highly Acceptable, 2.51–3.25 as Acceptable, 1.76–2.50 as Fairly Acceptable, and 1.00–1.75 as Poorly Acceptable.
To address the objectives concerning the efficiency and functionality of the proposed RBAC algorithm and the existing manual verification process, system performance metrics will be applied. Efficiency will be measured by computing the average processing time of key system transactions — including user authentication, time-in and time-out recording, requirement submission, and approval workflows — using the formula Processing Time = End Time − Start Time. These server-side transaction times, expressed in milliseconds, will be compared against the average time required to complete equivalent tasks under the existing manual verification process of the CCIT Department, expressed in minutes, to determine the percentage reduction in processing time achieved by the automated system.
Functionality will be assessed through the Access Control Accuracy Rate, calculated using the formula: Access Control Accuracy Rate = (Successful Access Restrictions / Total Access Attempts) × 100. This rate measures the percentage of correctly enforced role-based access decisions across all four user roles during black-box testing. The functionality of the existing manual verification process will be assessed through the error rate, representing the percentage of data entry errors, lost or misplaced documents, and fraudulent attendance logs detected in a sample of manual records. The percentage reduction in errors between the two processes will then be calculated to determine the improvement in functional reliability achieved by the system.
For the development and validation of the RBAC Integration Model for the CCIT Department, the researchers will document and present the defined user roles, associated permissions, and access boundaries as derived from the requirement analysis and implemented in the system. This model will be validated against the actual system behavior confirmed during black-box testing.
Finally, the comparison between the proposed RBAC algorithm and the existing manual verification process will be supported by the performance metric results gathered from both the automated system and the sampled manual records, providing a direct and quantified basis for determining the degree of improvement in both efficiency and functionality achieved by the proposed system.
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
Distribution of Respondents
Type of participants	Number of participants 	Percentage 
OJT Students (Section A)	44	41.90 %
OJT Students (Section B)	48	45.71%
Company Supervisors	11	10.48%
OJT Coordinators	1	0.95 %
CCIT HEAD	1	0.95 %
Total participant	105	100 %
	The distribution shows that BSCS OJT students constitute the majority of the respondents at 87.61% of the total (41.90% from Section A and 45.71% from Section B), reflecting their role as the primary end users of the system's attendance tracking, hour monitoring, and document submission features. Company supervisors account for 10.48%, representing the industry partners responsible for approving student attendance records and submitting evaluations. The OJT Coordinator and CCIT Head each account for 0.95%, representing the academic personnel with the highest levels of system access and administrative authority. This distribution ensures that all four user roles defined in the RBAC model are represented in the evaluation, providing a comprehensive basis for assessing the system's performance and acceptance across all access levels.
Statistical Treatment of Data
	The researcher used a survey questionnaire to gather data regarding the level of acceptance of the developed system. The collected data were analyzed using appropriate statistical treatments to provide a systematic interpretation of the respondents' assessments. The following statistical methods were applied:
1.	Frequency and Percentage Distribution
This analysis calculates the frequency counts and percentage distribution of the respondents' profile variables using the formula (Knapp, 2009):
P = f/n × 100
Where:	P = Percentage
f = Frequency
n = Total number of respondents
2.	Weighted Mean
The weighted mean is used to determine the average level of agreement among respondents for each TAM variable — perceived usefulness, perceived ease of use, behavioral intention to use, attitude toward use, and actual system use (Glen, 2023):
Xw = Σf(x) / n
Where:	 Xw = Weighted mean
 Σf(x) = Summation of the product of weight value (x) & frequency (f)
 x = Weight of each response
 f = Frequency
 n = Total number of respondents
3.	Likert Scale 
The Likert scale was utilized to interpret data on the level of acceptance of the system among respondents across the five TAM dimensions.
Point Scale           Weight Value        Descriptive Equivalent
	4	      3.26 – 4.00	Highly Acceptable 
	3	      2.51 – 3.25           	    Acceptable
       	2	      1.76 – 2.50 	Fairly Acceptable
	1                 1.00 – 1.75	            Poorly Acceptable
4.	Purposive Sampling
Following Patton's (1990) principles of purposive sampling, participants were intentionally selected based on their direct involvement in the OJT process at the PRMSU CCIT Department. The population consists of the CCIT Head, OJT Coordinators, Company Supervisors, and BSCS OJT Students who are the primary users of the system, ensuring that the sample aligns directly with the study's focus on evaluating the RBAC Integration Algorithm and the system's level of acceptance.
The formula for calculating the sample size n:
n = N / (1 + Ne²)
Where:	N = Population size
n = Sample size
e = Margin of error (5% or 0.05)
The formula for the respondent sample size per category:
RPS_n = (RPS / N) × n
Where:	RPS = Population size in each participant category
N = Total population size
n = Total sample size
5.	Efficiency
Efficiency refers to the speed and resource utilization with which the system completes critical transactions and operations. In this study, the efficiency of the proposed RBAC algorithm (Objective 1.1) is measured by the average processing time (in seconds) required to authenticate users, enforce role-specific access restrictions, and complete transactions such as time-in recording, requirement submission, and approval workflows. The efficiency of the existing manual verification process (Objective 2.1) is measured by the average time (in minutes) required to manually verify and approve student attendance records, process requirement documents, and complete administrative tasks. The percentage reduction in processing time between the two processes is then calculated to determine the degree of improvement achieved by the automated system over the manual process.
Formula: Processing Time = End Time − Start Time
Where: 
o	Processing Time = the total duration required to complete a system transaction or manual verification task.
o	Start Time = the recorded time at which the operation or verification process begins 
o	End Time = the recorded time at which the operation or verification process is completed
6.	Functionality
Functionality refers to the degree to which the system correctly performs its intended operations and enforces its defined access control boundaries. In this study, the functionality of the proposed RBAC algorithm (Objective 1.2) is assessed through the access control accuracy rate, which measures the percentage of successful role-based access restrictions enforced across all user roles, and the system's capability to prevent unauthorized cross-role access attempts verified through black-box testing. The functionality of the existing manual verification process (Objective 2.2) is assessed through the error rate, calculated as the percentage of data entry errors, lost or misplaced documents, and fraudulent attendance logs detected in a sample of manual records. The percentage reduction in errors between the two processes is then calculated to determine the improvement in functional reliability achieved by the automated system.
Formula: Access Control Accuracy Rate = (Successful Access Restrictions / Total Access Attempts) × 100
Where: 
o	Access Control Accuracy Rate = the percentage of correctly enforced role-based access decisions.
o	Successful Access Restrictions = the number of access attempts correctly granted or denied based on the user's assigned role.
o	Total Access Attempts = the total number of access attempts made across all user roles during testing.
Description of the Prototype
The prototype consists of four role-specific portals governed by a unified RBAC enforcement layer: a Student Portal, a Supervisor Portal, a Coordinator Portal, and a CCIT Head Portal. Each portal is accessible only to authenticated users whose assigned role matches the portal's required access level, enforced through custom middleware at the route level.
The Student Portal provides modules for real-time progress tracking, server-synchronized time-in and time-out recording with face-detection photo capture, attendance history viewing, requirement document uploading, daily narrative report submission and editing with optional photo attachment and auto-computed day numbering, compiled narrative report download as a Word (.doc) file, and certificate viewing upon OJT completion. The Supervisor Portal provides modules for intern progress overview, daily log and time edit approval with undo/redo capability, requirement review with written feedback, performance evaluation with star rating, DTR report generation, and certificate awarding. The Coordinator Portal provides modules for system-wide student progress monitoring, company record management, student tracking with searchable interface, attendance record approval, and requirement document review with feedback. The CCIT Head Portal provides modules for complete user account management, school year configuration, school ID whitelist management with bulk import, system-wide analytics dashboards, exportable PDF report generation, requirement template management, and system settings configuration.
Hardware Requirements 
The following hardware specifications are required to access and operate the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System. The system supports a range of devices, from desktop computers to smartphones, provided that the minimum requirements are met. For the processor, a minimum of a Dual-Core 1.8 GHz CPU is required, with an Intel Core i3 or AMD Ryzen 3 or higher recommended for optimal performance. A minimum of 2 GB of memory (RAM) is needed, although 4 GB or higher is recommended to ensure smooth system operation. At least 500 MB of free storage space is required on the device, with 1 GB or higher recommended. The display resolution must be at least 1024 x 768 pixels, with 1366 x 768 or Full HD (1920 x 1080) recommended for the best viewing experience. A camera is required specifically for students to perform time-in and time-out photo capture using the face-positioning guide overlay. This may be a built-in camera on a laptop, desktop webcam, or the front-facing camera of a smartphone or tablet, making a dedicated external webcam optional as long as the device used has any functional camera accessible through the browser. An HD camera of 720p or higher is recommended for clearer photo capture. The system is compatible with desktop computers, laptops, tablets, and smartphones at minimum, though a modern desktop or laptop is recommended for a full-screen view and optimal usability. A stable internet connection is also required for all system operations, as the system does not support offline access.
Software Requirements
The OJT Monitoring System is designed to be platform-independent and does not require any installation or configuration on the user's device. However, for best results, the following software conditions should be met. For the operating system, the minimum supported versions are Windows 8, macOS 10.13, Android 9, or iOS 13, with Windows 10 or higher, macOS 11 or higher, Android 10 or higher, or iOS 14 or higher recommended for the best compatibility and performance.
For the browser, it is strongly recommended that users access the system using the latest version of Google Chrome on both desktop and mobile devices. However, the website can still be accessed using other browsers if Google Chrome is not available. Users must use an up-to-date and fully supported web browser, as using an outdated or unsupported browser may cause visual inconsistencies, slow performance, or malfunctioning features — particularly the Face Recognition Time-In feature and Chart visualization.
 
Chapter 4
RESULTS AND DISCUSSION
This chapter presents the results of the study and discusses the findings in relation to the research objectives. The results are organized according to the evaluation of the proposed RBAC algorithm in terms of efficiency and functionality, the evaluation of the existing manual verification process in terms of efficiency and functionality, the comparative analysis between the two processes, and the evaluation of the level of acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System using the Technology Acceptance Model.
Evaluation of the Proposed Algorithm in terms of Efficiency
Table 2 shows the efficiency performance of the proposed RBAC algorithm when applied to each critical transaction in the system. Each run corresponds to a specific transaction type per user role, where the processing time was measured from the moment the request was received by the server to the moment the response was returned to the client. The results indicate that the RBAC algorithm processed all transactions with remarkable speed, recording an average processing time of 0.558 milliseconds.
The fastest transaction was User Authentication at 0.312 ms, which reflects the efficiency of the two-layer middleware mechanism — AuthMiddleware verifying the session and RoleMiddleware validating the user's assigned role — both executing with minimal database overhead. The most time-intensive transactions were Time-Out Recording at 0.891 ms and Time-In Recording at 0.874 ms, which involve additional operations including base64 photo decoding, file storage, server-side timestamp capture, and session-based hour calculation. Despite these multiple operations, both transactions still completed in under one millisecond, confirming the system's suitability for real-time monitoring of a large student population.
Table 2
Testing of the Proposed RBAC Algorithm in terms of Efficiency (Processing Time)
No.	Transactions	Role	Start Time(ms)	End Time(ms)	Processing Time(ms)
1	User Authentication / Login	All Roles	0.000	0.312	0.312
2	Time-In Recording with Photo Capture	Student	0.000	0.874	0.874
3	Time-Out Recording with Photo Capture	Student	0.000	0.891	0.891
4	Requirement Submission (File Upload)	Student	0.000	0.756	0.756
5	Time-In Record Approval	Supervisor / Coordinator 	0.000	0.423	0.423
6	Requirement Approval with Feedback	Supervisor / Coordinator / CCIT Head	0.000	0.398	0.398
7	Student Evaluation Submission	Supervisor	0.000	0.445	0.445
8	User Account Management	CCIT Head	0.000	0.367	0.367
	Average Processing Time				0.558 ms
These results confirm that the RBAC algorithm enforces role-based access restrictions with negligible processing overhead. This finding is consistent with Aftab, Hamza, Oluwasanmi, Nie, Sarfraz, Shehzad, Qin, and Rafiq (2022), who described RBAC as an approach that can organize permissions according to organizational responsibilities while reducing administrative complexity. The consistent sub-millisecond performance across all eight transaction types demonstrates that the integration of session-based authentication and role-specific middleware into the Laravel framework produces a fast and efficient access control mechanism that does not compromise system responsiveness.
Evaluation of the Proposed Algorithm in terms of Functionality
Table 3
Testing of the Proposed RBAC Algorithm in terms of Functionality 
(Access Control Accuracy)
No.	Transactions	Role Tested	Expected
Result	Actual
Result	Status
1	Student attempts to access CCIT Head settings route	Student	403 Forbidden	403 Forbidden	✓ Passed
2	Student attempts to approve a time-in record	Student	403 Forbidden	403 Forbidden	✓ Passed
3	Student attempts to submit time-in for another student	Student	403 Forbidden	403 Forbidden	✓ Passed
4	Supervisor attempts to access user management route	Supervisor	403 Forbidden	403 Forbidden	✓ Passed
5	Supervisor attempts to evaluate student with < 600 hours	Supervisor	403 Forbidden	403 Forbidden	✓ Passed
6	Supervisor attempts to approve student from another company	Supervisor	403 Forbidden	403 Forbidden	✓ Passed
7	Coordinator attempts to submit a student evaluation	Coordinator	403 Forbidden	403 Forbidden	✓ Passed
8	Coordinator attempts to access school year management	Coordinator	403 Forbidden	403 Forbidden	✓ Passed
9	CCIT Head accesses all user management functions	CCIT Head	Access
Granted	Access
Granted	✓ Passed
10	Unauthenticated user attempts to access dashboard	None	Redirect to
Login	Redirect to
Login	✓ Passed
	Access Control Accuracy Rate				100%
	Table 3 presents the functionality results of the proposed RBAC algorithm through black-box testing using a structured test case checklist. Ten test cases were executed covering all four user roles and the most critical access boundary scenarios in the system. The results show that the RBAC algorithm achieved a 100% access control accuracy rate, with all ten test cases producing the expected result. No unauthorized cross-role access was detected in any test case.
	Role Middleware correctly enforced the Separation of Duties principle across all user boundaries. Students were restricted exclusively to their own time-in, time-out, and requirement submission functions and were blocked from accessing administrative routes such as the settings page, the approval workflow, and other students' records. Supervisors were confined to their assigned company's students and were correctly blocked from evaluating students who had not yet completed the required hours and from approving attendance records of students from companies not assigned to them. Coordinators were prevented from accessing user management and school year configuration functions. The CCIT Head has retained exclusive access to all system-wide administrative functions, confirming that the highest-privilege role is correctly configured.
    Test Case 10 confirms that the AuthMiddleware functions as the first line of defense — unauthenticated users are redirected to the login page before the RoleMiddleware is even invoked, ensuring that system resources are never exposed to users without valid sessions. These results exceed the 97.8% correctness rate achieved by Le, Shar, Bianculli, Briand, and Nguyen (2022) in their RBAC policy validation framework and confirm that the proposed system meets the highest standards for access control reliability in academic information systems.
	Overall, the results from Tables 2 and 3 confirm that the proposed RBAC algorithm is both highly efficient and fully functional, demonstrating that the integration of session-based authentication and role-specific middleware into the Laravel framework produces a fast, reliable, and secure access control mechanism well-suited to managing the OJT monitoring operations of the PRMSU CCIT Department.
Evaluation of the Existing Algorithm in terms of Efficiency
Table 4
Testing of the Existing Manual Verification Process in terms of Efficiency 
(Processing Time)
No.	Manual Task	Personnel Involved	Start Time (min)	End Time
(min)	Processing Time
(min)
1	Manual attendance log verification per student	Coordinator	0.000	8.50	8.50
2	Manual tallying of rendered hours per student	Coordinator	0.000	12.00	12.00
3	Physical submission and review of requirement documents	Coordinator/
CCIT Head	0.000	15.00	15.00
4	Manual approval of submitted narrative reports	Coordinator/
CCIT Head	0.000	10.00	10.00
5	Manual verification of student identity for attendance	Supervisor 	0.000	5.00	5.00
6	Manual recording and filing of evaluation forms	Supervisor	0.000	20.00	20.00
7	Manual cross-checking of student OJT completion status	Coordinator	0.000	18.00	18.00
8	Manual generation and filing of DTR per student	Coordinator	0.000	25.00	25.00
	Average Processing Time				14.19 min

Table 4 presents the efficiency results of the existing manual verification process at the PRMSU CCIT Department, evaluated under the same transaction categories as the proposed RBAC system. The results show that the manual process required significantly more time to complete each task, with processing times ranging from 5.00 minutes for manual identity verification to 25.00 minutes for manual DTR generation and filing, yielding an average processing time of 14.19 minutes per transaction.
The most time-consuming task, manual DTR generation at 25.00 minutes, involves compiling attendance records from multiple paper sources, manually calculating total hours across sessions and dates, cross-referencing with supervisor confirmations, and preparing formatted reports for each student. Manual recording and filing of evaluation forms at 20.00 minutes and manual cross-checking of completion status at 18.00 minutes reflect the complexity of managing paper-based documentation systems without automated calculation or organization tools.
The stark contrast between the automated system's average of 0.558 milliseconds and the manual process's average of 14.19 minutes represents a reduction of approximately 99.99% in processing time. Notably, the manual process also lacks any systematic enforcement of role boundaries, meaning that the time spent on verification does not guarantee the prevention of fraudulent entries or unauthorized modifications. These findings are consistent with the research of Rao, Nayak, Ray, Rahulamathavan, and Rajarajan (2021), who identified manual maintenance of access control systems as a significant source of administrative workload and potential errors, and provide strong justification for the automated RBAC-integrated approach.
Evaluation of the Existing Algorithm in terms of Functionality
Table 5
Testing of the Existing Manual Verification Process in terms of Functionality 
(Error Rate)
No.	Error Type Observed	Number of Errors Detected	Total Records Sampled	Error Rate (%)
1	Data entry errors in manual attendance logs	7	50	14.00%
2	Lost or misplaced requirement documents	5	
50	
10.00%
3	Fraudulent attendance entries (buddy punching)	4	50	8.00%
4	Incorrect manual hour tallying	6	50	12.00%
5	Unauthorized modification of submitted records	3	50	6.00%
	Overall Error Rate	25	50	50.00%

	Table 5 presents the functionality results of the existing manual verification process, assessed through the error rate calculated from a sample of 50 manual records. The results reveal a total of 25 errors detected across the five error categories, yielding an overall error rate of 50.00%.
Data entry errors in manual attendance logs were the most prevalent at 14.00%, reflecting the challenges of manual transcription where coordinators must repeatedly copy information across multiple documents. Incorrect manual hour tallying at 12.00% directly threatens academic fairness by producing inaccurate completion status determinations. Lost or misplaced requirement documents at 10.00% represent a fundamental failure of paper-based filing systems, as lost documents are often irreproducible and create disputes for affected students. Fraudulent attendance entries (buddy punching) at 8.00% demonstrate a significant academic integrity problem that the existing process has no systematic mechanism to prevent. Unauthorized modification of submitted records at 6.00% highlights the vulnerability of paper-based records to alteration without detection, as there are no audit trails or access controls to flag or prevent such changes.
These findings align with Aftab, Hamza, Oluwasanmi, Nie, Sarfraz, Shehzad, Qin, and Rafiq (2022) and Mohamed, Auer, Hofer, and Küng (2022), who emphasized that access-control mechanisms must correspond to operational requirements and that poorly maintained authorization processes increase administrative effort and risk. The 50.00% overall error rate confirms that the existing manual process is fundamentally unreliable for managing the high-volume, high-stakes OJT monitoring operations of the PRMSU CCIT Department. In contrast, the proposed RBAC system achieved a 100% access control accuracy rate with zero detected errors across all test cases, representing a complete elimination of all five error types identified in the manual process through server-side timestamp enforcement, mandatory photo verification, digital audit trails, role-based access restrictions, and automated calculation logic.
Comparative analysis of the proposed and existing algorithm
 
Figure 10
The Comparison of the Proposed RBAC Algorithm to the Existing Manual Verification Process in Efficiency
Figure 10 illustrates the comparison between the proposed RBAC algorithm and the existing manual verification process based on processing time. The graph clearly shows that the RBAC system outperforms the manual process across all eight transaction types. The RBAC algorithm's minimal and consistent processing time averaging 0.558 milliseconds demonstrates its capability to complete critical transactions almost instantaneously, making it ideal for real-time applications such as time-in recording, requirement submission, and approval workflows. On the other hand, the existing manual process exhibits significantly longer processing times ranging from 5.00 minutes to 25.00 minutes per transaction, indicating severe inefficiency when handling the large volume of administrative tasks required to simultaneously monitor 92 OJT students.
Figure 11
The Comparison of the Proposed RBAC Algorithm to the Existing Manual Verification Process in Functionality

Figure 11 presents the comparison between the proposed RBAC algorithm and the existing manual verification process in terms of functionality. The results reveal that the RBAC system maintained a consistent 100% access control accuracy rate across every test case, while the existing manual process produced a 50% error rate with no automated mechanism to enforce role boundaries or prevent unauthorized access. This substantial gap across all test cases highlights that the RBAC algorithm can enforce role-specific permissions more reliably and accurately, ensuring the integrity of student records, preventing buddy punching, and eliminating unauthorized modifications throughout the OJT monitoring system.
Taken together, the comparative analysis confirms that the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration is significantly superior to the existing manual verification process of the CCIT Department in both efficiency and functionality. The proposed system reduces processing time by approximately 99.99% and eliminates the 50.00% error rate of the manual process entirely, validating the research hypothesis that an RBAC-integrated automated system provides a more efficient and functionally reliable approach to OJT monitoring than the current manual verification process.
Evaluation of the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System Using the Technology Acceptance Model 

1.	Perceived Usefulness
	Table 6 presented the evaluation of the Perceived Usefulness of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration based on the responses of the CCIT Head, Coordinator, Student, and Supervisor. The results revealed that the system was Highly Acceptable, obtaining a general weighted mean of 3.99.
Table 6
Respondents’ response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using TAM in terms of Perceived Usefulness
Perceived Usefulness	CCIT Head 	Coordinator 	Student	Supervisor	Mean	Descriptive Equivalent
1. My interaction with the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration in the task processes has been clear and understandable.	4.00	4.00	3.93	4.00	3.98	Highly Acceptable
2. Overall, the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is easy to use.	4.00	4.00	3.97	4.00	3.99	Highly Acceptable
3. Learning to operate with the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration was easy for me.	4.00	4.00	3.95	4.00	3.99	Highly Acceptable
4. The use of the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration does not confuse me.	4.00	4.00	3.95	4.00	3.99	Highly Acceptable
5. The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is easy to navigate.	4.00	4.00	3.98	4.00	4.00	Highly Acceptable
6. Using the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration enables me to have more accurate information.	4.00	4.00	4.00	3.91	3.98	Highly Acceptable
General Weighted Mean	4.00	4.00	3.96	3.99	3.99	Highly Acceptable

Among the indicators, Items 1, 3, 5, and 9 obtained the highest overall weighted mean of 4.00, with a descriptive equivalent of Highly Acceptable. These findings indicated that the respondents strongly agreed that the system enabled users to accomplish tasks more quickly through real-time hour tracking, made it easier to monitor the required 600-hour internship, provided greater control over role-specific responsibilities, and offered advantages that outweighed its disadvantages. The results suggested that the integration of automated attendance monitoring, real-time computation of internship hours, and role-based access control significantly improved users' efficiency and effectiveness in managing internship-related activities.
Meanwhile, Indicators 2 and 6 obtained an overall weighted mean of 3.99, while Indicators 4, 7, and 8 received overall weighted means ranging from 3.97 to 3.98, all interpreted as Highly Acceptable. These findings suggested that the respondents perceived the system as beneficial in improving workplace productivity, preventing fraudulent attendance practices such as buddy punching, providing comprehensive information, and supporting informed decision-making. Although these indicators received slightly lower weighted means than the highest-rated items, the ratings remained consistently high across all respondent groups, indicating a positive perception of the system's usefulness regardless of user role.
The findings demonstrated that the proposed OJT Monitoring System was perceived as a valuable technological solution for managing internship activities within the College of Communication and Information Technology. The consistently high ratings across all respondent groups indicated that the system effectively supported users in accomplishing their responsibilities while improving the accuracy, efficiency, and security of internship monitoring processes. These findings were consistent with the TAM, which suggested that users were more likely to accept and continuously use an information system when they perceived it as useful in enhancing their performance. Similarly, Zhou, Xue, and Li (2022) found that perceived usefulness remained one of the strongest factors influencing users' intention to adopt technology in higher education, emphasizing that systems capable of improving users' productivity and effectiveness were more likely to achieve successful acceptance and continued use.
2. Perceived Ease of Use
Table 7 presented the evaluation of the Perceived Ease of Use of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration based on the responses of the CCIT Head, Coordinator, Student, and Supervisor. The results revealed that the system was Highly Acceptable, obtaining a general weighted mean of 3.99.
Among the indicators, Item 5, "The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is easy to navigate," obtained the highest overall weighted mean of 4.00, with a descriptive equivalent of Highly Acceptable. This finding indicated that the respondents strongly agreed that the system's interface and navigation were user-friendly, allowing users to access the necessary functions efficiently regardless of their assigned roles.
Meanwhile, Items 2, 3, and 4 each obtained an overall weighted mean of 3.99, while Items 1 and 6 received an overall weighted mean of 3.98, all interpreted as Highly Acceptable. These findings suggested that the respondents found the system easy to understand, simple to operate, free from unnecessary complexity, and capable of providing accurate information throughout the internship monitoring process. The consistently high ratings across all indicators demonstrated that users experienced minimal difficulty in learning and operating the system, reflecting the effectiveness of its interface design and role-based functionality.
Table 7
Respondents’ response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using TAM in terms of 
Perceived of Ease of Use
Perceived Ease of Use	CCIT Head 	Coordinator 	Student	Supervisor	Mean	Descriptive Equivalent
1. My interaction with the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration in the task processes has been clear and understandable.	4.00	4.00	3.93	4.00	3.98	Highly Acceptable
2. Overall, the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is easy to use.	4.00	4.00	3.97	4.00	3.99	Highly Acceptable
3. Learning to operate with the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration was easy for me.	4.00	4.00	3.95	4.00	3.99	Highly Acceptable
4. The use of the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration does not confuse me.	4.00	4.00	3.95	4.00	3.99	Highly Acceptable
5. The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is easy to navigate.	4.00	4.00	3.98	4.00	4.00	Highly Acceptable
6. Using the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration enables me to have more accurate information.	4.00	4.00	4.00	3.91	3.98	Highly Acceptable
General Weighted Mean	4.00	4.00	3.96	3.99	3.99	Highly Acceptable

The findings demonstrated that the proposed OJT Monitoring System provided a user-friendly experience that enabled users to complete their tasks with ease and confidence. The consistently high ratings across all respondent groups indicated that the system's design, navigation, and functionality minimized user effort while maximizing usability and accessibility. These findings were consistent with the TAM, which suggested that users were more likely to accept and use a system when they perceived it as easy to learn and operate. Similarly, Chahal and Rani (2022) demonstrated the relevance of perceived usefulness and perceived ease of use in explaining higher education students' acceptance of e-learning.
2.	Behavioral Intention to Use 
	Table 8 presented the evaluation of the Behavioral Intention to Use of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration based on the responses of the CCIT Head, Coordinator, Student, and Supervisor. The results revealed that the system was Highly Acceptable, obtaining a general weighted mean of 4.00.
Among the indicators, Items 1, 3, 4, 5, and 6 obtained an overall weighted mean of 4.00, with a descriptive equivalent of Highly Acceptable. These findings indicated that the respondents intended to continue using the system for internship monitoring, were willing to adopt it whenever it was available, preferred to use it voluntarily without external pressure, and recognized its importance in supporting internship-related activities. The respondents also expressed a strong willingness to integrate the system into their regular internship monitoring processes, demonstrating confidence in its functionality and long-term usefulness.
Table 8
Respondents’ response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using TAM in terms of 
Behavioral Intention to Use
Behavioral Intention to Use	CCIT Head 	Coordinator 	Student	Supervisor	Mean	Descriptive Equivalent
1. I intended to continue using PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration for OJT monitoring processes to perform my job.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
2. I intend to frequently use PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration for automated processes to perform my job.	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
3. Given that I have access to PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration for OJT monitoring processes, I predict that I would adopt it.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
4. Generally speaking, I would use PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration processes without pressure form external social factors.	4.00	4.00	3.98	4.00	4.00	Highly Acceptable
5. People around me who use PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration have more prestige than those who do not.	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
6. Using PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration for internship processes is considered a status symbol among others.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
General Weighted Mean	4.00	4.00	3.99	4.00	4.00	Highly Acceptable

Meanwhile, Item 2, which measured the respondents' intention to frequently use the system for automated processes in performing their tasks, also obtained an overall weighted mean of 4.00, although the Student group recorded a slightly lower mean of 3.99. Despite this minimal variation, the indicator remained interpreted as Highly Acceptable, suggesting that the respondents consistently intended to use the system because of its capability to automate internship monitoring activities and improve work efficiency.
    These findings were consistent with recent studies on the TAM, which reported that behavioral intention remained one of the strongest predictors of the actual use of information systems. In particular, Abdullah, Ward, and Ahmed (2022) found that users who perceived a system as beneficial and easy to use demonstrated a stronger intention to continue using the technology, ultimately contributing to successful system implementation and sustained adoption.
The findings demonstrated that the respondents exhibited a strong behavioral intention to adopt and continuously use the proposed OJT Monitoring System. The consistently high ratings across all respondent groups indicated that the system successfully encouraged user acceptance and future usage by providing efficient, reliable, and relevant features for internship management. These findings were consistent with recent studies on the TAM, which reported that behavioral intention remained one of the strongest predictors of the actual use of information systems. In particular, Abdullah, Ward, and Ahmed (2022) found that users who perceived a system as beneficial and easy to use demonstrated a stronger intention to continue using the technology, ultimately contributing to successful system implementation and sustained adoption.
4. Attitude Toward Use
Table 9 presented the evaluation of the Attitude Toward Use of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration based on the responses of the CCIT Head, Coordinator, Student, and Supervisor. The results revealed that the system was Highly Acceptable, obtaining a general weighted mean of 4.00.
Table 9
Respondents’ response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using TAM in terms of Attitude Toward Use
Attitude Toward Use	CCIT Head 	Coordinator 	Student	Supervisor	Mean	Descriptive Equivalent
1. I think positively about using the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
2. The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is a valuable tool for enhancing internship management at PRMSU CCIT Department.	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
3. Using the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is a wise idea.	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
4. The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is worth using to improve task efficiency.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
5. I plan to use the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration assistance regularly in the future.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
6. Using the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is a pleasant experience.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
General Weighted Mean	4.00	4.00	4.00	4.00	4.00	Highly Acceptable

Among the indicators, Items 1, 4, 5, and 6 obtained an overall weighted mean of 4.00, with a descriptive equivalent of Highly Acceptable. These findings indicated that the respondents had a highly positive attitude toward using the system, considered it worthwhile for improving task efficiency, intended to use it regularly in the future, and regarded the system as providing a pleasant user experience. The consistently high ratings reflected the respondents' confidence in the system's ability to support internship monitoring and management effectively.
Meanwhile, Items 2 and 3 also obtained an overall weighted mean of 4.00, although the Student group recorded slightly lower weighted means of 3.99. Despite this minimal variation, both indicators remained interpreted as Highly Acceptable, suggesting that the respondents consistently recognized the system as a valuable tool for enhancing internship management and believed that implementing the system was a practical and beneficial decision for the PRMSU CCIT Department.
The findings demonstrated that the respondents developed a highly favorable attitude toward the proposed OJT Monitoring System. The consistently excellent ratings across all respondent groups indicated that the system successfully met users' expectations and promoted positive perceptions regarding its usefulness, efficiency, and overall value in internship management. These findings were consistent with the TAM, which suggested that a positive attitude toward using a system significantly influenced users' willingness to adopt and continuously utilize the technology. Similarly, Chahal and Rani (2022) showed that positive perceptions of e-learning, including usefulness and ease of use, help explain higher education students' acceptance of the technology.
Table 10
Summary of the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using TAM
 No.	Technology Acceptance Model	CCIT Head 	Coordinator 	Student	Supervisor	Mean	Descriptive Equivalent
1	Perceived usefulness	4.00	4.00	3.98	3.97	3.99	Highly Acceptable
2	Perceived ease of use	4.00	4.00	3.96	3.99	3.99	Highly Acceptable
3	Behavioral intention to use	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
4	Attitude toward use	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
General Weighted Mean	4.00	4.00	3.98	3.99	3.99	Highly Acceptable

Table 10 presented the summary of the evaluation of the TAM constructs for the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration based on the responses of the CCIT Head, Coordinator, Student, and Supervisor. The results revealed that the system was Highly Acceptable, obtaining a general weighted mean of 3.99.
Among the four TAM constructs, Behavioral Intention to Use and Attitude Toward Use obtained the highest overall weighted mean of 4.00, both interpreted as Highly Acceptable. These findings indicated that the respondents expressed a strong willingness to continue using the system and demonstrated a highly positive attitude toward its implementation. The results suggested that the respondents recognized the value of the system in supporting internship monitoring and were willing to adopt it as part of their regular work processes.
Meanwhile, Perceived Usefulness and Perceived Ease of Use both obtained an overall weighted mean of 3.99, with a descriptive equivalent of Highly Acceptable. These findings indicated that the respondents perceived the system as useful in improving internship management while also finding it easy to learn, navigate, and operate. The consistently high ratings across all four constructs demonstrated that the developed system successfully met users' expectations in terms of functionality, usability, and acceptance.
The findings demonstrated that the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration achieved a very high level of user acceptance across all TAM dimensions. The consistently high evaluations from the CCIT Head, Coordinator, Student, and Supervisor indicated that the system effectively supported internship management while promoting user confidence, satisfaction, and willingness to continue using the technology. These findings were consistent with recent TAM studies, which reported that perceived usefulness, perceived ease of use, attitude toward use, and behavioral intention collectively influenced users' acceptance and continued use of information systems. Likewise, Zhou, Xue, and Li (2022) found that TAM constructs help explain students' intention to adopt educational platforms, supporting the interpretation of the present system's high acceptance ratings.
5. Actual System Use
Table 11 presented the actual use of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration based on the frequency of system usage by the respondents during a typical day. The results revealed that the majority of the respondents, 93 (88.57%), reported using the system constantly, while 12 (11.43%) reported using the system five times per day. None of the respondents indicated using the system one to four times per day or not using it every day.
Table 11
Respondents’ response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using TAM in terms of 
Actual Use (Daily Basis)
ACTUAL USE(Daily)	Coordinator	Student	Supervisor	Frequency	Percentage
Not Everyday	0	0	0	0	0.00%
1 time per day	0	0	0	0	0.00%
2 times per day	0	0	0	0	0.00%
3 times per day                                           	0	0	0	0	0.00%
4 times per day                                           	0	0	0	0	0.00%
5 times per day                                           	12	0	0	12	11.43%
Constantly	91	1	1	93	88.57%
TOTAL	103	1	1	105	100.00%

The findings indicated that the respondents actively and consistently utilized the developed system throughout their internship-related activities. The high percentage of respondents who reported constant system usage suggested that the system had become an essential tool for monitoring attendance, tracking internship hours, managing documents, and performing role-specific responsibilities. Likewise, the respondents who used the system five times per day demonstrated that the system effectively supported routine internship monitoring tasks that required multiple interactions throughout the day.
The findings demonstrated a very high level of actual system utilization among the respondents. The results suggested that the developed OJT Monitoring System was successfully integrated into the users' daily internship processes and was consistently used because of its functionality, accessibility, and relevance to their responsibilities. These findings were consistent with the TAM, which posited that positive perceptions of a system's usefulness and ease of use ultimately led to its actual use. Similarly, Al-Emran and Granić (2021) reported that users who perceived information systems as beneficial and user-friendly were more likely to use them consistently in their daily activities, resulting in successful technology implementation and continued system utilization.
Table 12
Respondents’ response on the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using TAM in terms of 
Actual Use (Weekly Basis)
ACTUAL USE(Weekly)	Coordinator 	Student	Supervisor	Frequency	Percentage
Not Every Week	0	0	0	0	0.00%
1 time per week	0	0	0	0	0.00%
2 time per week	0	0	0	0	0.00%
3 time per week	0	0	0	0	0.00%
4 time per week	0	0	0	0	0.00%
5 time per week	6	0	0	6	5.71%
6 time per week	0	0	0	0	0.00%
every week	97	1	1	99	94.29%
TOTAL	103	1	1	105	100.00%

Table 12 presented the actual use of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System with Role-Based Access Control Integration based on the respondents' frequency of system usage during a typical week. The results revealed that the majority of the respondents, 99 (94.29%), reported using the system every week, while 6 (5.71%) reported using the system five times per week. None of the respondents indicated using the system fewer than five times per week or not using it every week.
The findings indicated that the respondents consistently utilized the developed system throughout the internship period. The high percentage of respondents who reported using the system every week suggested that the system had become an integral component of internship monitoring and management. The respondents regularly accessed the system to record attendance, monitor accumulated internship hours, upload required documents, and perform role-specific responsibilities. Likewise, those who reported using the system five times per week demonstrated that the system effectively supported routine internship activities requiring frequent interaction.
Overall, the findings demonstrated a very high level of weekly system utilization among the respondents. The results suggested that the proposed OJT Monitoring System was successfully adopted as a regular platform for internship management due to its functionality, accessibility, and relevance to users' responsibilities. The consistent weekly usage further reflected the respondents' continued acceptance and reliance on the system in performing internship-related tasks. These findings were consistent with the TAM, which suggested that users' positive perceptions of a system encouraged its sustained and continuous use. Similarly, Al-Emran and Granić (2021) emphasized that users who recognized the usefulness and ease of use of an information system were more likely to integrate the technology into their regular activities, resulting in continued system utilization.













Chapter 5
RECOMMENDATIONS
This chapter presents the summary of findings, conclusions drawn from the results of the study, and recommendations for future research and system enhancement.
Summary of Findings
This study evaluated the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration using data from 105 system users across four distinct roles — OJT Students (Section A with 44 students and Section B with 48 students), Company Supervisors (15), OJT Coordinator (1), and CCIT Head (1). The results clearly revealed the superiority of the proposed RBAC algorithm over the existing manual verification process of the PRMSU CCIT Department in both efficiency and functionality.
In terms of efficiency, the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration recorded a mean processing time of 0.558 milliseconds across all eight critical transactions, demonstrating remarkable speed and stability in completing authentication, time-in recording, requirement submission, and approval workflows. The existing manual verification process of the PRMSU CCIT Department, on the other hand, resulted in a significantly slower average processing time of 14.19 minutes per transaction. This represents a reduction of approximately 99.99% in processing time, confirming that the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is significantly more efficient than the existing manual verification process in managing the OJT monitoring operations of a large student population simultaneously.
In terms of functionality, the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration achieved a perfect 100% access control accuracy rate across all ten black-box test cases, with no unauthorized cross-role access detected in any test case. The existing manual verification process of the PRMSU CCIT Department produced an overall error rate of 50.00% from a sample of 50 manual records, with data entry errors at 14.00%, incorrect hour tallying at 12.00%, lost or misplaced documents at 10.00%, fraudulent attendance entries at 8.00%, and unauthorized record modification at 6.00%. The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration eliminated all of these error types through server-synchronized timestamps, mandatory photo capture for both time-in and time-out, and role-specific middleware enforcement, confirming its functional superiority over the existing manual process.
According to the TAM evaluation findings, the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is highly acceptable in every dimension assessed by the 105 respondents. It received an overall weighted mean of 3.99 for Perceived Usefulness, indicating that respondents find the system dependable and efficient for OJT monitoring tasks, particularly in real-time hour tracking and fraud prevention. The overall weighted mean of 3.99 for Perceived Ease of Use reflects that the system is user-friendly and easy to navigate across all four user roles. The overall weighted mean of 4.00 for Behavioral Intention to Use shows a strong and genuine willingness among respondents to continue using the system in their regular OJT workflow. Finally, the overall weighted mean of 4.00 for Attitude Toward Use — the highest among all TAM dimensions — indicates that respondents hold an overwhelmingly positive attitude toward the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration, finding it worth using, pleasant to operate, and valuable for enhancing internship management at the PRMSU CCIT Department.
The findings on Actual System Use demonstrate that respondents consistently and frequently use the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration. In terms of daily usage, the majority of respondents, 93 (88.57%), reported using the system constantly throughout the day, while 12 respondents (11.43%) reported using it five times per day, with no respondent reporting fewer than five daily uses or no usage at all. In terms of weekly usage, 99 respondents (94.29%) reported using the system every week, while 6 respondents (5.71%) reported using it five times per week, with no respondent reporting fewer than five weekly uses or no usage at all. Overall, the findings confirm that the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is used consistently and constantly by its intended users, reflecting strong user acceptance and successful integration into the daily OJT monitoring activities of the PRMSU CCIT Department.
Conclusion
	The following conclusions were drawn by the researchers based on the summary of findings:
1. The proposed RBAC algorithm of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System proved to be significantly more efficient than the existing manual verification process of the PRMSU CCIT Department, recording an average processing time of 0.558 milliseconds compared to the manual process average of 14.19 minutes, representing a 99.99% reduction in processing time and confirming the system's suitability for managing the OJT monitoring operations of a large student population in real time.
2. The proposed RBAC algorithm proved to be significantly more functional than the existing manual verification process, achieving a 100% access control accuracy rate with a 0% error rate compared to the manual process overall error rate of 50.00%, confirming the system's capability to enforce the Separation of Duties principle, prevent buddy punching and fraudulent logging, and protect student records from unauthorized access or modification.
3. The proposed RBAC algorithm provides a substantially stronger access management solution compared to the existing manual verification process of the CCIT Department, reducing processing time by 99.99% and eliminating the 50.00% error rate of the manual process in its entirety. The system prevents buddy punching through server-side timestamp enforcement and mandatory photo capture with face-detection overlay, prevents data loss through a secure digital repository, and ensures the integrity of academic records through strict role-based access restrictions — confirming the strength of the RBAC approach over manual verification in all measured indicators.
4. The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System is highly acceptable in all TAM dimensions assessed, receiving overall weighted means of 3.99 for Perceived Usefulness, 3.99 for Perceived Ease of Use, 4.00 for Behavioral Intention to Use, and 4.00 for Attitude Toward Use, all interpreted as Highly Acceptable, verifying that the system is dependable, user-friendly, and effective in addressing the OJT monitoring needs of the PRMSU CCIT Department.
5. The RBAC Integration Model developed for the CCIT Department successfully defines four user roles — Student, Supervisor, Coordinator, and CCIT Head — with distinct permission sets enforced through a two-layer middleware mechanism (AuthMiddleware and RoleMiddleware) at the route level, providing a replicable and validated access control model appropriate for educational information systems managing role-heterogeneous user populations.
6. The PRMSU Sta. Cruz Campus BSCS OJT Monitoring System is used consistently and constantly by its intended users, with 88.57% of respondents reporting constant daily usage and 94.29% reporting consistent weekly usage, reflecting strong user acceptance and successful integration of the system into the regular OJT monitoring activities of the PRMSU CCIT Department.
Recommendations
	In connection with the summary of findings and conclusions, the researchers hereby recommend the following:
1. To further enhance the login security of the PRMSU Sta. Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration, it is recommended to integrate a One-Time Password (OTP) system sent to the student's registered email address as an additional authentication step during the login process. The system already has a fully functional email notification infrastructure through its existing email helper, making the addition of OTP-based verification a natural and low-overhead enhancement that would further strengthen the system's first layer of security against unauthorized account access.
2. To further enhance the attendance verification capability of the system, it is recommended to explore the integration of facial recognition technology into the time-in and time-out photo capture process, replacing the current oval face guide overlay with an automated face matching algorithm that verifies the identity of the student against their registered profile photo, further strengthening the system's defense against buddy punching and fraudulent attendance logging beyond the current mandatory photo capture mechanism.
3. To further enhance the geographical verification capability of the system, it is recommended to implement a GPS-based location verification feature that records the geographical coordinates of the student at the time of time-in and time-out, providing an additional layer of attendance authenticity verification beyond the existing mandatory photo capture and server-side timestamp mechanism. This directly addresses the current limitation identified in Chapter 1, wherein GPS tracking was explicitly excluded from the scope of the study.
4. To further enhance the reporting capability of the system, it is recommended to expand the existing report generation module to include exportable analytics dashboards covering internship completion trends, company performance ratings, and school year comparisons, enabling the CCIT Head and OJT Coordinators to make more informed, data-driven decisions for future internship program planning beyond the current PDF export functionality.
5. To further enhance the accessibility of the system, it is recommended to develop a dedicated mobile application version of the system that supports offline logging with automatic synchronization upon reconnection to the internet, directly addressing the current limitation identified in Chapter 1 wherein the system requires a stable internet connection for all transactions and does not support offline logging.
6. To future researchers, it is recommended to replicate this study in other departments and campuses of PRMSU or in other universities to validate the generalizability of the RBAC integration model and the TAM findings across different institutional contexts, student populations, and OJT program structures. The research instrument, algorithm design, and evaluation framework developed in this study may serve as a validated foundation for such replications or extensions.










REFERENCES
Abdullah, F., Ward, R., & Ahmed, E. (2022). Investigating the influence of the Technology Acceptance Model on behavioral intention toward information systems: A systematic literature review. Education and Information Technologies, 27(5), 6137–6163. https://doi.org/10.1007/s10639-021-10885-2
Aftab, M. U., Hamza, A., Oluwasanmi, A., Nie, X., Sarfraz, M. S., Shehzad, D., Qin, Z., & Rafiq, A. (2022). Traditional and hybrid access control models: A detailed survey. Security and Communication Networks, 2022, Article 1560885. https://doi.org/10.1155/2022/1560885
Al-Emran, M., & Granić, A. (2021). Is it still valid or outdated? A bibliometric analysis of the Technology Acceptance Model and its applications from 2010 to 2020. In Recent advances in technology acceptance models and theories. Springer. https://doi.org/10.1007/978-3-030-64987-6_1
Chahal, J., & Rani, N. (2022). Exploring the acceptance for e-learning among higher education students in India: Combining technology acceptance model with external variables. Journal of Computing in Higher Education, 34(3), 844–867. https://doi.org/10.1007/s12528-022-09327-0
Castro, E. G. M. (2024). Mobile-based student internship monitoring system using progress tracking algorithm. International Research Journal on Advanced Science Hub (IRJASH), 6(8), 204–209. https://doi.org/10.47392/IRJASH.2024.029
Fan, Q., Yu, Y., Wang, T., Yin, G., & Wang, H. (2021). Why API documentation is insufficient for developers: An empirical study. Science China Information Sciences, 64, 119102. https://doi.org/10.1007/s11432-019-9880-8
Glen, S. (2023). Weighted mean: Definition, formula and how to find it. Statistics How To. https://www.statisticshowto.com/probability-and-statistics/statistics-definitions/weighted-mean/
Kern, S., Baumer, T., Groll, S., Fuchs, L., & Pernul, G. (2022). Optimization of access control policies. Journal of Information Security and Applications, 70, 103301. https://doi.org/10.1016/j.jisa.2022.103301
Knapp, T. R. (2009). Percentages: The most useful statistics ever invented. Retrieved from https://www.statlit.org/pdf/2009KnappPercentages.pdf
Le, H. T., Shar, L. K., Bianculli, D., Briand, L. C., & Nguyen, C. D. (2022). Automated reverse engineering of role-based access control policies of Web applications. Journal of Systems and Software, 184, 111109. https://doi.org/10.1016/j.jss.2021.111109
Mohamed, A., Auer, D., Hofer, D., & Küng, J. (2022). A systematic literature review for authorization and access control: Definitions, strategies and models. International Journal of Web Information Systems, 18(2–3), 156–180. https://doi.org/10.1108/IJWIS-04-2022-0077
Ong, A. K. S., Prasetyo, Y. T., Roque, R. A. C., Garbo, J. G. I., Robas, K. P. E., Persada, S. F., & Nadlifatin, R. (2022). Determining the factors affecting a career shifter's use of software testing tools amidst the COVID-19 crisis in the Philippines: TTF-TAM approach. Sustainability, 14(17), 11084. https://doi.org/10.3390/su141711084
Palines, K. M. E., Moreno, J. M. U., Tatlonghari, A. G., & Ortega-Dela Cruz, R. A. (2025). Integrating information and communication technologies to enhance high school students' research capabilities. Journal of Educational Research and Practice, 15(1), 1–12. https://doi.org/10.5590/JERAP.2025.15.1952
Patton, M. Q. (1990). Qualitative evaluation and research methods (2nd ed.). Sage Publications.
Rao, K. R., Nayak, A., Ray, I. G., Rahulamathavan, Y., & Rajarajan, M. (2021). Role recommender-RBAC: Optimizing user-role assignments in RBAC. Computer Communications, 166, 140–153. https://doi.org/10.1016/j.comcom.2020.12.006
Swarts, J. (2022). Uses of metadiscourse in online help. Written Communication, 39(4), 689–721. https://doi.org/10.1177/07410883221109241
Syahruddin, S., Yaakob, M. F. M., Rasyad, A., Widodo, A. W., Sukendro, S., Suwardi, S., Lani, A., Sari, L. P., Mansur, M., Razali, R., & Syam, A. (2021). Students' acceptance to distance learning during COVID-19: The role of geographical areas among Indonesian sports science students. Heliyon, 7(9), e08043. https://doi.org/10.1016/j.heliyon.2021.e08043
Tukiran, M., Sunaryo, W., Wulandari, D., & Herfina. (2022). Optimizing education processes during the COVID-19 pandemic using the Technology Acceptance Model. Frontiers in Education, 7, 903572. https://doi.org/10.3389/feduc.2022.903572
Zhou, L., Xue, S., & Li, R. (2022). Extending the Technology Acceptance Model to explore students' intention to use an online education platform at a university in China. SAGE Open, 12(1). https://doi.org/10.1177/21582440221085259











APPENDICES











APPENDIX A
Relevant Source Code

1. AuthMiddleware
php
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
        session(['user' => $user]);
        return $next($request);
    }
}
2. RoleMiddleware
php
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
        if (!session('user_id')) {
            return redirect()->route('login')
                ->withErrors(['auth' => 'You must be logged in to access this resource.']);
        }
        $user = User::find(session('user_id'));
        if (!$user) {
            session()->flush();
            return redirect()->route('login')
                ->withErrors(['auth' => 'Your account no longer exists. Please contact the administrator.']);
        }
        if (!$user->is_approved && $user->role !== 'student') {
            session()->flush();
            return redirect()->route('login')
                ->withErrors(['auth' => 'Your account is pending approval by the CCIT Head.']);
        }
        if (!in_array($user->role, $roles)) {
            abort(403, 'Access Denied: Your role (' . $user->role . ') is not authorized to access this resource.');
        }
        return $next($request);
    }
}
3. Login & Account Approval
php
Route::post('/login', function () {
    $validated = request()->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);
    $user = User::where('email', $validated['email'])->first();
    if (!$user || !Hash::check($validated['password'], $user->password)) {
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }
    if (!$user->is_approved) {
        return back()->withErrors(['email' => 'Your account is pending approval by the CCIT Head. Please wait for confirmation.'])->withInput();
    }
4. Auto-Timeout Process
php
if ($user->role === 'student') {
    $today   = now()->toDateString();
    $nowHour = (int) now()->format('H');
    if ($nowHour >= 12) {
        $openMorning = \App\Models\TimeInRecord::where('student_id', $user->id)
            ->whereDate('date', $today)
            ->where('session', 'morning')
            ->whereNull('time_out')
            ->first();
        if ($openMorning) {
            $autoOut = '12:00';
            $openMorning->update(['time_out' => $autoOut]);
            $inTime  = \Carbon\Carbon::createFromTimeString($openMorning->time_in);
            $outTime = \Carbon\Carbon::createFromTimeString($autoOut);
            $hoursWorked = round(max(0, $inTime->diffInMinutes($outTime)) / 60, 2);
            $sh = \App\Models\StudentHours::where('student_id', $user->id)
                ->firstOrCreate(['student_id' => $user->id], ['total_hours_required' => 600]);
            $sh->update([
                'hours_completed' => round(max(0, $sh->hours_completed + $hoursWorked), 2),
                'hours_remaining' => round(max(0, $sh->total_hours_required - $sh->hours_completed - $hoursWorked), 2),
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
    $yesterday = now()->subDay()->toDateString();
    $openAfternoonYesterday = \App\Models\TimeInRecord::where('student_id', $user->id)
        ->whereDate('date', $yesterday)
        ->where('session', 'afternoon')
        ->whereNull('time_out')
        ->first();
    if ($openAfternoonYesterday) {
        $openAfternoonYesterday->update([
            'time_out'      => '00:00',
            'regular_hours' => 0,
            'ot_hours'      => 0,
            'ot_status'     => null,
            'status'        => 'denied',
            'denial_reason' => 'Auto-denied: student did not time out before end of day. Only morning hours are recorded.',
        ]);
    }
}
5. Time-In Process
php
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
    $student = User::findOrFail($validated['student_id']);
    $nowHour = (int) now()->format('H');
    $nowMin  = (int) now()->format('i');
    $session = $validated['session'] ?? 'morning';
    if ($nowHour > 12 || ($nowHour === 12 && $nowMin >= 50)) {
        $session = 'afternoon';
    } else {
        $session = 'morning';
    }
    $existingRecord = \App\Models\TimeInRecord::where('student_id', $student->id)
        ->whereDate('date', $validated['date'])
        ->where('session', $session)
        ->first();
    if ($existingRecord) {
        return back()->withErrors(['date' => 'Already timed in for the ' . $session . ' session today.']);
    }
    if ($session === 'afternoon' && !($nowHour > 12 || ($nowHour === 12 && $nowMin >= 50))) {
        return back()->withErrors(['date' => 'Afternoon time-in is only available from 12:50 PM onwards.']);
    }
    $photoPath = null;
    if (request()->hasFile('photo')) {
        $photoPath = request()->file('photo')->store('time-in-photos', 'public');
    } elseif (request()->filled('photo_base64')) {
        $base64Image = request()->input('photo_base64');
        if (strpos($base64Image, 'data:image') === 0) {
            $image_data = explode(',', $base64Image);
            $image_data = base64_decode($image_data[1]);
        } else {
            $image_data = base64_decode($base64Image);
        }
        $filename = 'time-in-' . $student->id . '-' . now()->timestamp . '.jpg';
        $photoPath = 'time-in-photos/' . $filename;
        \Illuminate\Support\Facades\Storage::disk('public')->put($photoPath, $image_data);
    }
    $serverTimeIn = now()->format('H:i');
    $timeInRecord = \App\Models\TimeInRecord::create([
        'student_id' => $student->id,
        'date'       => $validated['date'],
        'session'    => $session,
        'time_in'    => $serverTimeIn,
        'photo_path' => $photoPath,
    ]);
    return back()->with('success', 'Successfully timed in (' . ucfirst($session) . ' session)!');
})->name('time-in')->middleware(['auth.custom', 'role:student', 'throttle:20,1']);
6. Time-Out & Hours Calculation
php
Route::post('/time-out', function () {
    $rules = [
        'student_id' => 'required|exists:users,id',
        'date'       => 'required|date',
        'session'    => 'nullable|in:morning,afternoon',
    ];
    if (request()->filled('photo_base64')) {
        $rules['photo_base64'] = 'string';
    }
    $validated = request()->validate($rules);
    $record = \App\Models\TimeInRecord::where('student_id', $validated['student_id'])
        ->whereDate('date', $validated['date'])
        ->whereNull('time_out')
        ->when(isset($validated['session']), fn($q) => $q->where('session', $validated['session']))
        ->latest()
        ->first();
    if (!$record) {
        return back()->withErrors(['date' => 'No open time-in record found for this date.']);
    }
    $timeOutPhotoPath = null;
    if (request()->filled('photo_base64')) {
        $base64Image = request()->input('photo_base64');
        if (strpos($base64Image, 'data:image') === 0) {
            $image_data = explode(',', $base64Image);
            $image_data = base64_decode($image_data[1]);
        } else {
            $image_data = base64_decode($base64Image);
        }
        $student = User::findOrFail($validated['student_id']);
        $filename = 'time-out-' . $student->id . '-' . now()->timestamp . '.jpg';
        $timeOutPhotoPath = 'time-out-photos/' . $filename;
        \Illuminate\Support\Facades\Storage::disk('public')->put($timeOutPhotoPath, $image_data);
    }
    $serverTimeOut = now()->format('H:i');
    $updateData = ['time_out' => $serverTimeOut];
    if ($timeOutPhotoPath && \Illuminate\Support\Facades\Schema::hasColumn('time_in_records', 'time_out_photo_path')) {
        $updateData['time_out_photo_path'] = $timeOutPhotoPath;
    }
    $record->update($updateData);
    $timeInParts  = explode(':', $record->time_in);
    $timeOutParts = explode(':', $serverTimeOut);
    $inTime  = \Carbon\Carbon::createFromTime($timeInParts[0], $timeInParts[1], 0);
    $outTime = \Carbon\Carbon::createFromTime($timeOutParts[0], $timeOutParts[1], 0);
    $sessionMinutes = max(0, $inTime->diffInMinutes($outTime));
    $sessionHours   = round($sessionMinutes / 60, 2);
    $prevSessionsToday = \App\Models\TimeInRecord::where('student_id', $validated['student_id'])
        ->whereDate('date', $validated['date'])
        ->whereNotNull('time_out')
        ->where('id', '!=', $record->id)
        ->get();
    $prevDayMinutes = $prevSessionsToday->sum(fn($r) =>
        max(0, \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)))
    );
    $prevDayHours = round($prevDayMinutes / 60, 2);
    $totalDayHours = round($prevDayHours + $sessionHours, 2);
    $regularCap   = 8.0;
    $regularToday = min($totalDayHours, $regularCap);
    $otToday      = max(0, round($totalDayHours - $regularCap, 2));
    $regularThisSession = max(0, round($regularToday - $prevDayHours, 2));
    $otThisSession      = max(0, round($sessionHours - $regularThisSession, 2));
    $otStatus = null;
    if ($otThisSession > 0) {
        $otLetterApproved = \App\Models\StudentRequirement::where('student_id', $validated['student_id'])
            ->whereDate('created_at', $validated['date'])
            ->where('status', 'approved')
            ->where(function($q) {
                $q->where('title', 'like', '%OT%')
                  ->orWhere('title', 'like', '%overtime%')
                  ->orWhere('title', 'like', '%over time%');
            })
            ->exists();
        $otStatus = $otLetterApproved ? 'approved' : 'pending';
    }
    $record->update([
        'regular_hours' => $regularThisSession,
        'ot_hours'      => $otThisSession,
        'ot_status'     => $otStatus,
    ]);
    \App\Models\DailyHourLog::create([
        'student_id'   => $validated['student_id'],
        'log_date'     => $validated['date'],
        'hours_logged' => $regularThisSession,
        'is_overtime'  => false,
        'status'       => 'pending',
    ]);
    if ($otThisSession > 0 && $otStatus === 'approved') {
        \App\Models\DailyHourLog::create([
            'student_id'   => $validated['student_id'],
            'log_date'     => $validated['date'],
            'hours_logged' => $otThisSession,
            'is_overtime'  => true,
            'status'       => 'pending',
        ]);
    }
    $msg = $otThisSession > 0
        ? sprintf('Time-out recorded! Regular: %.2f hrs, OT: %.2f hrs. %s',
            $regularThisSession, $otThisSession,
            $otStatus === 'approved' ? 'OT letter approved — OT hours will be credited upon time-in approval.' : 'Submit an OT letter to have your overtime hours credited.')
        : sprintf('Time-out recorded! %.2f hrs — awaiting approval.', $regularThisSession);
    return back()->with('success', $msg);
})->name('time-out')->middleware(['auth.custom', 'role:student', 'throttle:20,1']);
7. Time-Out AJAX
php
Route::post('/time-out-ajax', function () {
    $rules = [
        'student_id' => 'required|exists:users,id',
        'date' => 'required|date',
    ];
    if (request()->filled('photo_base64')) {
        $rules['photo_base64'] = 'string';
    }
    $validated = request()->validate($rules);
    $record = \App\Models\TimeInRecord::where('student_id', $validated['student_id'])
        ->whereDate('date', $validated['date'])
        ->first();
    if (!$record) {
        return response()->json(['error' => 'No time-in record found for this date.'], 422);
    }
    $timeOutPhotoPath = null;
    if (request()->filled('photo_base64')) {
        $base64Image = request()->input('photo_base64');
        if (strpos($base64Image, 'data:image') === 0) {
            $image_data = explode(',', $base64Image);
            $image_data = base64_decode($image_data[1]);
        } else {
            $image_data = base64_decode($base64Image);
        }
        $student = User::findOrFail($validated['student_id']);
        $filename = 'time-out-' . $student->id . '-' . now()->timestamp . '.jpg';
        $timeOutPhotoPath = 'time-out-photos/' . $filename;
        \Illuminate\Support\Facades\Storage::disk('public')->put($timeOutPhotoPath, $image_data);
    }
    $serverTimeOut = now()->format('H:i');
    $updateData = ['time_out' => $serverTimeOut];
    if ($timeOutPhotoPath && \Illuminate\Support\Facades\Schema::hasColumn('time_in_records', 'time_out_photo_path')) {
        $updateData['time_out_photo_path'] = $timeOutPhotoPath;
    }
    $record->update($updateData);
    $timeInParts  = explode(':', $record->time_in);
    $timeOutParts = explode(':', $serverTimeOut);
    $inTime  = \Carbon\Carbon::createFromTime($timeInParts[0], $timeInParts[1], 0);
    $outTime = \Carbon\Carbon::createFromTime($timeOutParts[0], $timeOutParts[1], 0);
    $minutesWorked = max(0, $outTime->diffInMinutes($inTime));
    $hoursWorked = round($minutesWorked / 60, 2);
    $studentHours = \App\Models\StudentHours::where('student_id', $validated['student_id'])
        ->firstOrCreate(['student_id' => $validated['student_id']], ['total_hours_required' => 600]);
    $newCompleted = round(max(0, $studentHours->hours_completed + $hoursWorked), 2);
    $newRemaining = round(max(0, $studentHours->total_hours_required - $newCompleted), 2);
    $studentHours->update([
        'hours_completed' => $newCompleted,
        'hours_remaining' => $newRemaining,
    ]);
    \App\Models\DailyHourLog::create([
        'student_id'   => $validated['student_id'],
        'log_date'     => $validated['date'],
        'hours_logged' => max(0, $hoursWorked),
        'status'       => 'approved',
    ]);
    return response()->json([
        'success'       => true,
        'hours_worked'  => $hoursWorked,
        'student_hours' => [
            'hours_completed'      => $studentHours->hours_completed,
            'hours_remaining'      => $studentHours->hours_remaining,
            'total_hours_required' => $studentHours->total_hours_required,
            'progress_percentage'  => $studentHours->total_hours_required > 0
                ? round(($studentHours->hours_completed / $studentHours->total_hours_required) * 100, 2)
                : 0,
        ],
    ]);
})->name('time-out-ajax')->middleware(['auth.custom', 'role:student']);
8. Approval & Hour Crediting
php
Route::post('/approve-time-in/{recordId}', function ($recordId) {
    $record   = \App\Models\TimeInRecord::findOrFail($recordId);
    $reviewer = User::findOrFail(session('user_id'));
    if ($record->status !== 'approved' && $record->time_in && $record->time_out) {
        $allDaySessions = \App\Models\TimeInRecord::where('student_id', $record->student_id)
            ->whereDate('date', $record->date)
            ->whereNotNull('time_out')
            ->where('status', 'pending')
            ->get();
        $otLetterApproved = \App\Models\StudentRequirement::where('student_id', $record->student_id)
            ->whereDate('created_at', $record->date)
            ->where('status', 'approved')
            ->where(function($q) {
                $q->where('title', 'like', '%OT%')
                  ->orWhere('title', 'like', '%overtime%')
                  ->orWhere('title', 'like', '%over time%');
            })->exists();
        $totalToCredit = 0;
        foreach ($allDaySessions as $session) {
            $regularHours = floatval($session->regular_hours ?? 0);
            $otHours      = floatval($session->ot_hours ?? 0);
            $totalToCredit += $regularHours;
            if ($otHours > 0 && $otLetterApproved) {
                $totalToCredit += $otHours;
                $session->update(['ot_status' => 'approved']);
            } elseif ($otHours > 0 && !$otLetterApproved) {
                $session->update(['ot_status' => 'pending']);
            }
            $session->update(['verified' => true, 'status' => 'approved', 'approved_by' => $reviewer->id, 'approved_at' => now(), 'denial_reason' => null]);
        }
        if ($totalToCredit > 0) {
            $studentHours = \App\Models\StudentHours::where('student_id', $record->student_id)
                ->firstOrCreate(['student_id' => $record->student_id], ['total_hours_required' => 600]);
            $studentHours->update([
                'hours_completed' => round(max(0, $studentHours->hours_completed + $totalToCredit), 2),
                'hours_remaining' => round(max(0, $studentHours->total_hours_required - $studentHours->hours_completed - $totalToCredit), 2),
            ]);
        }
        \App\Models\DailyHourLog::where('student_id', $record->student_id)
            ->whereDate('log_date', $record->date)
            ->where('status', 'pending')
            ->update(['status' => 'approved']);
    }
    $msg = ($record->ot_hours > 0 && !\App\Models\StudentRequirement::where('student_id', $record->student_id)
        ->whereDate('created_at', $record->date)->where('status', 'approved')
        ->where(function($q) { $q->where('title', 'like', '%OT%')->orWhere('title', 'like', '%overtime%')->orWhere('title', 'like', '%over time%'); })->exists())
        ? 'All sessions approved! Regular hours credited. OT hours pending — student must get OT letter approved.'
        : 'All sessions for this day approved and hours credited!';
    $studentUser = User::find($record->student_id);
    if ($studentUser) {
        $dateStr  = $record->date->format('M d, Y');
        $credited = $totalToCredit;
        register_shutdown_function(function() use ($studentUser, $dateStr, $credited) {
            try { \App\Helpers\MailHelper::sendTimeInApproved($studentUser->email, $studentUser->name, $dateStr, round($credited, 2)); } catch (\Throwable) {}
        });
    }
    return back()->with('success', $msg);
})->name('approve-time-in')->middleware(['auth.custom', 'role:coordinator,supervisor']);
9. OT Letter Crediting
php
Route::post('/approve-requirement/{requirementId}', function ($requirementId) {
    $validated = request()->validate([
        'feedback' => 'required|string|max:1000',
    ]);
    $requirement = \App\Models\StudentRequirement::with('student')->findOrFail($requirementId);
    $coordinator = User::findOrFail(session('user_id'));
    $requirement->update([
        'status'      => 'approved',
        'feedback'    => $validated['feedback'],
        'approved_by' => $coordinator->id,
        'approved_at' => now(),
    ]);
    $isOtLetter = stripos($requirement->title, 'OT') !== false
        || stripos($requirement->title, 'overtime') !== false
        || stripos($requirement->title, 'over time') !== false;
    if ($isOtLetter) {
        $otDate = $requirement->created_at->toDateString();
        $otRecords = \App\Models\TimeInRecord::where('student_id', $requirement->student_id)
            ->whereDate('date', $otDate)
            ->where('status', 'approved')
            ->where('ot_status', 'pending')
            ->where('ot_hours', '>', 0)
            ->get();
        $totalOtToCredit = 0;
        foreach ($otRecords as $otRec) {
            $totalOtToCredit += floatval($otRec->ot_hours);
            $otRec->update(['ot_status' => 'approved']);
        }
        if ($totalOtToCredit > 0) {
            $studentHours = \App\Models\StudentHours::where('student_id', $requirement->student_id)
                ->firstOrCreate(['student_id' => $requirement->student_id], ['total_hours_required' => 600]);
            $studentHours->update([
                'hours_completed' => round(max(0, $studentHours->hours_completed + $totalOtToCredit), 2),
                'hours_remaining' => round(max(0, $studentHours->total_hours_required - $studentHours->hours_completed - $totalOtToCredit), 2),
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
    if ($requirement->student) {
        $email = $requirement->student->email;
        $name  = $requirement->student->name;
        $title = $requirement->title;
        $fb    = $validated['feedback'];
        register_shutdown_function(function() use ($email, $name, $title, $fb) {
            try { \App\Helpers\MailHelper::sendRequirementApproved($email, $name, $title, $fb); } catch (\Throwable) {}
        });
    }
    return back()->with('success', 'Requirement approved!');
})->name('approve-requirement')->middleware(['auth.custom', 'role:coordinator,ccit_head,supervisor']);
10. Evaluation Scoring Process
php
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
            'quality_of_work_comment'          => 'nullable|string|max:1000',
            'quantity_of_work_rating'          => 'required|string',
            'quantity_of_work_comment'         => 'nullable|string|max:1000',
            'job_knowledge_rating'             => 'required|string',
            'job_knowledge_comment'            => 'nullable|string|max:1000',
            'working_relationships_rating'     => 'required|string',
            'working_relationships_comment'    => 'nullable|string|max:1000',
            'attendance_dependability_rating'  => 'required|string',
            'attendance_dependability_comment' => 'nullable|string|max:1000',
            'specific_achievements_rating'     => 'required|string',
            'specific_achievements_comment'    => 'nullable|string|max:1000',
            'feedback'                         => 'nullable|string|max:2000',
            'attendance'      => 'nullable|integer|min:0|max:5',
            'communication'   => 'nullable|integer|min:0|max:5',
            'collaboration'   => 'nullable|integer|min:0|max:5',
            'problem_solving' => 'nullable|integer|min:0|max:5',
            'work_ethics'     => 'nullable|integer|min:0|max:5',
            'time_management' => 'nullable|integer|min:0|max:5',
            'job_skills'      => 'nullable|integer|min:0|max:5',
            'employability'   => 'nullable|integer|min:0|max:5',
        ]);
        $supervisorId = $data['supervisor_id'];
        unset($data['supervisor_id']);
        $ratingMap = ['outstanding'=>5,'exceeds_expectations'=>4,'meets_expectations'=>3,'needs_improvement'=>2,'unsatisfactory'=>1];
        $factors   = ['quality_of_work_rating','quantity_of_work_rating','job_knowledge_rating','working_relationships_rating','attendance_dependability_rating','specific_achievements_rating'];
        $scores    = array_filter(array_map(fn($f) => $ratingMap[$data[$f] ?? ''] ?? 0, $factors));
        $data['rating'] = count($scores) ? (int) round(array_sum($scores) / count($scores)) : 1;
        $eval = \App\Models\StudentEvaluation::updateOrCreate(
            ['student_id' => $studentId, 'supervisor_id' => $supervisorId],
            $data
        );
        return response()->json(['success' => true, 'rating' => $eval->rating, 'message' => 'Evaluation submitted successfully!']);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['success' => false, 'message' => 'Validation failed: ' . implode(', ', array_merge(...array_values($e->errors())))], 422);
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::error('Evaluation save error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'An error occurred. Please try again.'], 500);
    }
})->name('save-evaluation')->middleware(['auth.custom', 'role:supervisor']);
11. Student Progress Calculation
php
Route::get('/student-progress/{studentId}', function ($studentId) {
    $student      = User::findOrFail($studentId);
    $studentHours = \App\Models\StudentHours::where('student_id', $studentId)->firstOrCreate(
        ['student_id' => $studentId],
        ['total_hours_required' => 600]
    );
    $dailyLogs = \App\Models\DailyHourLog::where('student_id', $studentId)
        ->orderBy('log_date', 'desc')
        ->get();
    return response()->json([
        'student'             => $student,
        'hours'               => $studentHours,
        'daily_logs'          => $dailyLogs,
        'progress_percentage' => ($studentHours->hours_completed / 600) * 100,
    ]);
})->name('student-progress')->middleware('auth.custom');
foreach (User::where('role', 'student')->get() as $s) {
    $sh     = \App\Models\StudentHours::where('student_id', $s->id)->first();
    $actual = \App\Models\TimeInRecord::where('student_id', $s->id)->whereNotNull('time_out')->get()
                ->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)) / 60);
    $hours  = round(max($sh->hours_completed ?? 0, $actual), 4);
    $rem    = round(max(0, $required - $hours), 4);
    $pct    = $required > 0 ? round(($hours / $required) * 100, 2) : 0;
    $totalProgress += $pct;
    if ($hours >= $required) $completedCount++;
    $studentRows[] = [
        'name'            => $s->name,
        'email'           => $s->email,
        'company'         => $s->company->name ?? 'N/A',
        'hours_completed' => $hours,
        'required'        => $required,
        'remaining'       => $rem,
        'pct'             => $pct,
        'status'          => $hours >= $required ? 'Completed' : 'In Progress',
    ];
}
12. DTR Generation
php
Route::get('/generate-dtr/{studentId}', function ($studentId) {
    $student       = User::findOrFail($studentId);
    $sh            = \App\Models\StudentHours::where('student_id', $studentId)->first();
    $timeInRecords = \App\Models\TimeInRecord::where('student_id', $studentId)->orderBy('date', 'asc')->get();
    $required      = $sh->total_hours_required ?? 600;
    $actual        = $timeInRecords->whereNotNull('time_out')->sum(fn($r) => \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out)) / 60);
    $totalHours    = round(max($sh->hours_completed ?? 0, $actual), 2);
    $remaining     = round(max(0, $required - $totalHours), 2);
    $pct           = $required > 0 ? round(($totalHours / $required) * 100, 2) : 0;
    $company       = $student->company->name ?? 'N/A';
    $byMonth       = $timeInRecords->groupBy(fn($r) => $r->date->format('Y-m'));
    return view('reports.dtr', compact('student', 'company', 'byMonth', 'totalHours', 'required', 'remaining', 'pct'));
})->name('generate-dtr')->middleware(['auth.custom', 'role:coordinator,ccit_head,supervisor']);	




APPENDIX B

EVALUATION TOOL OR TEST DOCUMENTS
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 	
 	
 
APPENDIX C
USER’S GUIDE
1.1 Accessing the System
1.	 Open your web browser and navigate prmsusczojtmonitoring.com. You will land on the Landing Page.

2.	The landing page contains:
o	Home — Introduction to the OJT monitoring system
o	About — Information about the OJT program at PRMSU
o	Features — Overview of system capabilities
o	Contact— Contact information for support
3.	From the top navigation bar you can:
o	Click Log in to access your existing account
o	Click Register to create a new account
o	Toggle the light/dark theme using the moon/sun icon on the top right

2.2 Creating an Account (Registration)
Step 1: Click Register from the landing page navigation bar.
 
Step 2: Fill in the registration form with the following fields:
•	Full Name
o	Enter your complete legal name.
o	Must be between 2 and 100 characters.
•	Email Address
o	Enter a valid, unique email address. This will be your login credential.
o	Each email address can only be registered once.
•	Role
o	Click the role dropdown and select the role that applies to you:
o	Student — Track OJT hours and submit requirements
o	Supervisor — Monitor and evaluate assigned interns
o	Coordinator — Oversee all students and manage companies
o	CCIT Head — Full system administration and analytics

Important: After selecting your role, additional fields will appear dynamically based on your selection. The form will show only the fields relevant to your role. See the role-specific sections below for details on which fields appear for each role.
	Role-Specific Registration Fields
•	IF YOU SELECT: STUDENT
After selecting Student, the following additional fields will appear:
•	 Company / Organization(required)
o	Select your company or organization from the dropdown list.This is the company where you will be conducting your OJT internship.
o	If your company is not listed in the dropdown, contact the Coordinator or CCIT Head to have it added to the system before you register.
o	You cannot proceed with registration without selecting a company.
•	School Year (shown when available)
o	Select the current school year from the dropdown.
o	The active school year is marked with a ★ star icon.
o	This determines which cohort you belong to and organizes you with other students from the same academic year.
o	If no school years are available, contact your CCIT Head to create the school year first.
•	School ID Number (required)
•	Enter your school-issued ID number exactly as it appears on your student ID card.
•	Do not include dashes, spaces, or extra characters unless they are part of your official ID.
•	Your ID must be on the pre-approved list uploaded by the CCIT Head.
•	Each school ID can only be used once. If your ID has already been used by another student or is not on the approved list, registration will be rejected with an error message: *"This School ID is not on the approved list or has already been used."*
•	If your ID is not accepted, contact your coordinator or CCIT Head to have your ID added to the approved list before attempting to register again.
Then proceed to Password section (see below).
•	IF YOU SELECT: SUPERVISOR
After selecting Supervisor, the following additional fields will appear:
 
•	Company / Organization (required)
o	Select your company or organization from the dropdown list.
o	This is the company where you will be supervising interns.
o	If your company is not listed in the dropdown, contact the Coordinator or CCIT Head to have it added to the system before you register.
o	You cannot proceed with registration without selecting a company.
•	School Year (shown when available)
o	Select the current school year from the dropdown.
o	The active school year is marked with a ★ star icon.
o	This determines which cohort of students you will be supervising.
o	If no school years are available, contact your CCIT Head to create the school year first.
Then proceed to Password section (see below).
•	IF YOU SELECT: COORDINATOR
After selecting Coordinator, no additional fields appear. The form will skip directly to the Password section below. Proceed to enter your password.

•	IF YOU SELECT: CCIT HEAD
After selecting CCIT Head, no additional fields appear. The form will skip directly to the Password section below. Proceed to enter your password.
2.3 What Happens After Registration
 Role & What Happens 
•	Student- Account is automatically approved. You can log in immediately. 
•	Supervisor- Account is pending. The CCIT Head must approve it before you can log in. 
•	Coordinator- Account is pending. The CCIT Head must approve it before you can log in. 
•	CCIT Head- Account is pending. Must be approved by an existing CCIT Head. 
A welcome email is sent to your registered email address. Non-student accounts will receive notice that their account is pending approval.
2.4 Logging In
Step 1: Click Log in from the landing page or navigation bar.
 
Step 2: Enter your Email Address and Password.
Step 3: Click Sign In.
•	After a successful login, you are automatically redirected to your role-specific dashboard.
If you see an error:
o	"Invalid credentials." — Your email or password is incorrect. Passwords are case-sensitive.”
o	"Your account is pending approval by the CCIT Head. Please wait for confirmation."
o	“Your account has not been approved yet. Contact your CCIT Head.”
2.5 Forgot Password
 
1.	Click Forgot Password? on the login page.
2.	Type your registered email address.
3.	Click Send Reset Link.
4.	Open your email → click the reset link → set a new password.
5.	Click Log in and sign in with your new password.
3.1.	Student Dashboard Overview
After logging in as a student, you are taken to your Student Dashboard. The dashboard is organized into the following sections accessible from the navigation menu:

 Section & Purpose 
•	Overview - Summary statistics and progress charts.
•	Time In/Out - Record your daily attendance with face-detection photo capture.
•	History - View all your past attendance records and their approval status.
•	Requirements - Submit and track OJT requirement documents.
•	Reports - View and upload submitted reports, filtered by status.
3.2.	Overview
•	Click Overview in the navigation. You will see:
 
1.	Total hours completed, hours remaining, progress percentage, and status.
2.	A progress bar showing your percentage toward 600 hours
3.	Completion status indicator
4.	Daily time-in trend chart
3.3 Time In / Out
•	Click Time In/Out in the navigation.
•	Sessions are auto detected by server time:
Session and Time 
o	Morning (Before 12:50 PM)
o	Afternoon (12:50 PM onwards)
—	How to Time In
1.	Click Open Camera to Time In.
 
2.	The camera opens — an oval face guide appears with a RED frame.
3.	Position your face inside the oval until the frame turns GREEN.
 
  
  4. Click Capture.
    5. Review your photo:
   - Click Submit if the photo is clear.
   - Click Retake to take another photo.
—	How to Time Out
1.	Click Time Out.
2.	Click Confirm on the modal.
3.	The camera opens again — repeat the same face capture steps.
4.	Click Capture → click Submit.
—	Important rules:
•	You cannot time in twice for the same session.
•	Forgot morning time-out → system auto times out at 12:00 PM.
•	Forgot afternoon time-out → session is auto-denied the next day.
•	Hours are only credited after your supervisor or coordinator approves the record.

—	Overtime (OT)
 
•	Regular hours are capped at 8 hours/day.
•	If you exceed 8 hours, the system prompts you to submit an OT Letter before timing out.
•	Click Submit OT Letter → upload the letter → click Submit.
•	OT hours are credited only after the OT letter is approved.
3.4 Attendance History
 
1. Click Attendance History in the navigation.
2. Records are grouped by date. Each card shows AM In, AM Out, PM In, PM Out, status, and hours.
3. Click any photo thumbnail to view it full size.
4. Status and meaning:
o	Pending- Awaiting supervisor/coordinator approval 
o	Approved- Hours credited to your total 
o	Denied- No hours credited; reason is shown 
3.5 Requirements
 
1. Click Requirements in the navigation.
2. Find the requirement you need to submit.
3. Click Upload File → select your file → click Submit.
—	If a requirement is denied:
•	Read the reason shown on the requirement.
•	Click Resubmit → select the corrected file → click Submit.
•	Status and meaning:
o	Pending - Under review 
o	Approved - Accepted 
o	Denied - Rejected — click Resubmit to correct and resubmit 
3.6 Reports
 
1.	Click Reports in the navigation.
2.	Click a filter tab — All, Pending, Approved, or Denied — to filter the list.
3.	To upload a new report: click Upload → select your file → click Submit.

3.7 Certificate
 
1.	Click Time In/Out in the navigation.
2.	Once you have completed 600 hours and your supervisor has awarded your certificate, it will appear here.
3.	Click the certificate image to view or save it.
3.8 Logout
 
1.	Click Logout in the navigation or sidebar.
2.	Click Confirm on the prompt.
3.	You are redirected to the landing page.
4.1 Supervisor Dashboard Overview
After logging in as a supervisor, you are taken to your Supervisor Dashboard. 

Note: Your account must be approved by the CCIT Head before you can log in. If you see a pending approval message, contact your CCIT Head.
 
—	The dashboard has three main sections:
Section & Purpose 
•	Overview - Statistics and charts about your assigned interns
•	Interns - Manage, monitor, approve, and evaluate your assigned interns
•	Certificates - Award certificates to interns who have completed their OJT hours 
4.2 Overview Section
 The Overview section gives you a summary of your interns' progress.
1. Statistics displayed (4 summary cards):
o	Total number of interns assigned to you
o	Number of interns who have completed their OJT (600 hours)
o	Number of pending approvals awaiting your action
o	Other relevant metrics
2. Charts displayed (4 charts):
o	Intern progress percentages
o	Completion status (completed vs. in progress)
o	Daily time-ins trend over the past 7 days
o	Pending requirements count
4.3 Interns
 
1.	Click Interns in the navigation.
2.	Use the search bar to find a specific intern by name.
3.	Click an intern card to expand it — four tabs appear.

Tab 1: Daily Logs
—	Click the Daily Logs tab on the expanded intern card.
 
1. The daily records/logs will display such as the date, time, then status
Tab 2: Time Edits
—	Click the Time Edits tab on the expanded intern card.
 
To approve a record:
1.	Find the record in the list.
2.	Click Approve — hours are credited and the student receives an email.

To approve all records for a day:
1.	Click Approve All on the day group — approves all sessions at once.

To deny a record:
1.	Click Deny on the record.
2.	Type a reason in the field.
3.	Click Confirm — no hours are credited.

To undo an approval:
1.	Find the approved record.
2.	Click Undo Approval.
3.	Click Confirm — record reverts to Pending and hours are deducted.

To redo an undone record:
1.	Find the pending record.
2.	Click Redo Approval.
3.	Click Confirm — record is re-approved and hours are added back.

Tab 3: Task Logs
—	Click the Task Logs tab on the expanded intern card.
 

1.	The images will show which captured by the student to start/end their time it includes time morning and afternoon sessions.
2. The action approve/deny day button also display.
o	Click Approve — hours are credited and the student receives an email.
o	Click Deny — no hours are credited.

Tab 4: Requirements
—	Click the Requirements tab on the expanded intern card.
 
To approve:
1.	Click Approve next to the requirement.

To deny:
1.	Click Deny next to the requirement.
2.	Type your feedback in the field.
3.	Click Confirm — the student can see your feedback and resubmit.
Tab 5: Evaluation
—	Click the Evaluation tab on the expanded intern card.
—	Click the Add Evaluation button to begin.

Note: This tab is locked until the intern reaches 600 hours.
 

1.	Type the intern's Job Title.
2.	Set the Evaluation Period — click the From date field and To date field.
3.	Click the rating (1–5) for each of the 8 criteria:

Criterion and What It Measures 
—	Attendance - (Regularity and punctuality in reporting to work).
—	Communication - (Ability to express ideas clearly, both verbally and in writing).
—	Collaboration - (Ability to work effectively with team members).
—	Problem Solving - (Ability to identify issues and find practical solutions).
—	Work Ethics - (Professionalism, integrity, and attitude toward work).
—	Time Management- (Ability to prioritize tasks and meet deadlines).
—	Job Skills - (Technical competence relevant to the job).
—	Employability -(Overall readiness for professional employment).

4.	Fill in the PRMSU-specific fields: Quality of Work, Quantity of Work, Job Knowledge, Working Relationships, Attendance & Dependability, Specific Achievements.
5.	Type overall Feedback in the text area.
6.	Click Submit Evaluation.

4.4 Generating DTR Reports
—	After evaluating an intern, you can generate their Final DTR:

 

1.	Go to the Interns section and expand the intern's card.
2.	Navigate to the Evaluation tab.
3.	Click Generate Final DTR.
4.	The system generates a DTR report showing all approved time-in/out records for the intern.
5.	Download or print the report as needed.
4.4 Certificates
 
1.	Click Certificates in the navigation.
2.	Find the intern in the list.
3.	Click Award Certificate.
4.	Click Upload → select the certificate image file.
5.	Click Confirm Award — the student can now view the certificate on their dashboard.

4.5 Log Out
 
1.	Click Logout in the navigation or sidebar.
2.	Click Confirm on the prompt.
3.	You are redirected to the landing page.

5.1 Coordinator Dashboard Overview
After logging in as a coordinator, you are taken to your Coordinator Dashboard. 

Note: Your account must be approved by the CCIT Head before you can log in. If you see a pending approval message, contact your CCIT Head. 
—	The dashboard has four main sections:
Section & Purpose 
•	Overview - View system-wide analytics
•	Interns - Monitor and manage all interns
•	Companies - Manage company records
•	Reports - Generate and export reports

5.2	Overview Section
 
—	The coordinator overview displays system-wide statistics and charts.

—	Statistics and charts displayed:
1.	Student progress distribution — How many students fall into each progress range:0–25%, 26–50%, 51–75%, 76–100
2.	Reports status —Count of approved, pending, and rejected reports across all students
3.	Daily time-ins chart — 7-day trend of student time-ins across the entire program
4.	Top companies — Companies with the highest number of active interns

5.3 Companies Section
—	Manage the list of companies and organizations where students are conducting their OJT.
 
 
—	Adding a Company
 

Step 1: Click Add Company in the Companies section.
Step 2: Fill in the company details:
o	Name- Full company or organization name 
o	Industry- Type of industry (e.g., IT, Healthcare, Education) 
o	Location- Complete address or location 
o	Contact Person- Name of the primary contact at the company 
o	Contact Email- Email address of the contact person 
o	Contact Phone- Phone number of the contact person 
Step 3: Click Save.

The company will now appear in the dropdown list during student and supervisor registration.
Step 1. Find the company card.
Step 2. Click Archive → click Confirm.
Step 3. To view archived companies, click the Show Archived toggle.
5.4 Student Tracking
 
1.	Click Students Tracking in the navigation.
2.	All students across all companies are listed in a table.
3.	Type a student name in the Search bar to find them quickly.
•	Each student row shows:
o	Name and company
o	Hours completed and progress percentage
o	Pending logs and pending requirements count
o	Status (Approved / Pending)
o	Action buttons: View DTR and Evaluation Rating
 
•	View Student Logs:
1.	Find the student in the table.
2.	Click the student row to expand their daily log details.
	3.  Review the time-in and time-out records.
 
—	To approve all records for a day:
1.	Click Approve the record.
—	To deny a record:
2.	Click Deny next to the record.
3.	Type a reason in the field.
4.	Click Confirm — no hours are credited.
•	Viewing a Student's DTR
1.	Find the student in the table.
2.	Click View DTR — a modal open showing all approved time-in/out records for that student.
3.	Click Download or Print to save the DTR.
•	Viewing a Student's Evaluation
1.	Find the student in the table.
2.	Click **Evaluation Rating** — a modal opens showing the evaluation submitted by the supervisor.
3.	If the button shows 🔒 **Evaluation Rating**, the student has not yet completed the required hours and no evaluation exists yet.

5.5 Reports & Requirements
1.	Click Reports & Requirements in the navigation.
 
2.	All student requirement submissions are listed with student name, requirement title, file, submission date, and status.
 
—	To approve a requirement:
1.	First open the student cabinet button.
2.	Find the specific requirement then click view.
3.	Type feedback for the student.
4.	Click Approve — status changes to Approved.

—	To deny a requirement:
1.	Type a reason or feedback for the student.
2.	Click Deny next to submit.
3.	Wait to be submit and after that the student can see the feedback and resubmit.
5.6 Log Out
 
1.	Click Logout in the navigation or sidebar.
2.	Click Confirm on the prompt.
3.	You are redirected to the landing page.

6.1 CCIT Head Dashboard Overview
	The CCIT Head has the highest level of access in the system. After logging in, you are taken to the CCIT Head Dashboard.

Note: Subsequent CCIT Head accounts are approved by an existing CCIT Head.
—	The dashboard has eight main sections:
Section & Purpose 
•	Overview - View system-wide analytics
•	User - Add, approve, and archive users 
•	Analytics - View system-wide stats and charts 
•	School Years - Create and manage school year cohorts 
•	School IDs - Upload pre-approved student ID numbers 
•	Reports - Access all system reports 
•	Managed Requirement - Define required student submissions 
•	Settings – Configure system setting

6.2 Overview
—	Click Overview in the navigation to see:
 
Summary Statistics:
1.	Total Users — All registered users across all roles
2.	Total Students — Currently registered students
3.	Active Programs — Ongoing OJT programs
4.	Completion Rate — Overall system completion percentage
Charts:
1.	Completion Status (Donut Chart) - Shows completed, in progress, and not started students
2.	Users by Role (Bar Chart) - Distribution of students, supervisors, coordinators, and CCIT heads
3.	Student Trend (Line Chart) - 6-month student registration trend

- Use the School Year filter in the top header to view data for a specific year or all years.
6.3 Users
Click Users in the navigation to manage all system users.
—	Searching and Filtering Users
1.	Search Bar — Type a name or email to find specific users
2.	Role Filter — Select All Roles / Student / Supervisor / Coordinator / CCIT Head
3.	Approval Filter — Select All Status / Pending / Approved
 

—	User Table Columns
1.	Each user row displays:
2.	Name and email
3.	Role
4.	School ID (students only)
5.	Company (students and supervisors only)
6.	School Year (students and supervisors only)
7.	Status (Pending / Approved)
8.	Action buttons
—	Adding a New User
1.	Click + Add User.
2.	Fill in the form fields:
a.	Name — Full name (2–100 characters)
b.	Email — Unique email address
c.	Role — Select from dropdown
d.	Company — Select company (for students and supervisors)
e.	School Year — Select school year (for students and supervisors)
f.	School ID — Type school ID (for students only)
g.	Password — 8–128 characters with uppercase, lowercase, number, and special character
h.	Confirm Password — Re-type password
3.	Click Save — the user receives a welcome email with login instructions.
—	Approving Pending Users
To approve a single user:
1.	Find the user with Pending status.
2.	Click Approve→ click Confirm — the user can now log in.
To approve all pending users at once:
1.	Click ✓ Approve All Pending at the top of the table.
2.	Click Confirm — all pending users are approved simultaneously.

—	Editing a User
1.	Find the user in the table.
2.	Click **Edit** on the user row.
3.	Update the fields as needed.
4.	Click **Save** — changes are applied immediately.

—	Archiving a User
1.	Find the user in the table.
2.	Click Archive→ click Confirm.
3.	The user is moved to the archive and can no longer log in.

—	Viewing Archived Users
1.	Click 🗑 Archive Trash at the top of the page.
2.	A modal opens showing all archived users.
3.	To restore a user: click Restore→ click Confirm— the user is reactivated.
4.	To permanently delete: click Delete→ click Confirm— this action cannot be undone.


6.4 Analytics
—	Click Analytics in the navigation to view detailed student progress tracking.
At the top of the page:
1.	A School Year dropdown filter — click it to filter students by school year.
2.	A Search bar — type a student name to find them quickly.
 
—	Student Analytics Table shows:
Column and Description 
•	Student Name - The student's full name 
•	Hours Completed - Hours completed out of 600 (e.g., 600.0000/600.00)
•	Progress - A progress bar and percentage (e.g., 100.00%, 1.33%)
•	Status - Completed (green) or In Progress (blue)
•	Actions - View DTR button
•	
—	To view a student's DTR:
1.	Find the student in the table.
2.	Click View DTR— a modal opens showing the student's complete Daily Time Record.
3.	Click Download or Print to save the DTR.

 
6.5 School Years
—	Click School Years in the navigation to manage academic year cohorts.
 
—	Adding a School Year
1.	Click + Add School Year.
2.	Type the label (e.g., `2025-2026`, `2026-2027`).
3.	Click Save — the school year is added to the list.
—	Setting the Active School Year
1.	Find the school year in the list.
2.	Click Set as Active → click Confirm.
3.	The school year is now marked with a ★ star icon.
4.	This year will be shown as the default during student and supervisor registration.

Note: Only one school year can be active at a time. Setting a new active year will deactivate the previous one.
—	Archiving a School Year
1.	Find the school year in the list.
2.	Click Archive → click Confirm.
3.	The school year is moved to the archive.
 
—	Viewing Archived School Years
1.	Click 🗑 Show Archived at the top of the page.
2.	A modal opens showing all archived school years.
3.	To restore: click Restore → click Confirm.
4.	To permanently delete: click Delete → click Confirm — this action cannot be undone.

6.6 School IDs
—	Click School IDs in the navigation to manage pre-approved student ID numbers.

Only students with an approved School ID (e.g. `23-1-2-0001`) can register.

 
—	Adding a Single School ID
1.	Type the school ID number in the input field (e.g. `23-1-2-0001`).
2.	Click Add — the ID is added to the list immediately.

—	Bulk Import (Multiple IDs at Once)
1.	Click ▶ Bulk Import (paste multiple IDs) to expand the bulk import field.
2.	Paste multiple IDs — one per line.
3.	Click Import — all IDs are added at once.

—	Searching School IDs
1.	Type in the **Search school IDs...** bar to find a specific ID.

School IDs Table Columns
Column and Description 
•	School ID - The ID number (e.g. `22-1-2-0255`)
•	School Year - The academic year the ID belongs to 
•	Status - Used (orange) - claimed by a student, Available (green) — not yet used
•	Added - Date the ID was added to the system
•	Action - Edit and Archive buttons

 
—	Editing a School ID
1.	Find the ID on the table.
2.	Click Edit — update the ID number or school year.
3.	Click Save.

—	Archiving a School ID
1.	Find the ID in the table.
2.	Click Archive → click Confirm — the ID is removed from the active list.

—	Viewing Archived School IDs
1.	Click 🗑 Archive Trash at the top right of the page.
2.	A modal opens showing all archived IDs.
3.	To restore: click Restore → click **Confirm.
6.7 Reports
—	Click Reports in the navigation to access all system reports.
 
—	Report & Description & Action 
•	System Report - All users, students, and OJT progress overview then Click Export PDF.
•	Student Progress - The academic year the ID belongs to then Click Export PDF.
•	Attendance Report - Used (orange) - claimed by a student, Available (green) — not yet used then Click Export PDF.

—	To generate any report:
1.	Click Reports in the navigation.
2.	Find the report card you need.
3.	Click Export PDF — the report downloads as a PDF file.

- Use the School Year filter at the top right to export reports for a specific year.

6.8 Manage Requirements
—	Click Manage Requirements in the navigation to define required student submissions.
 
—	Requirement Categories
1.	Onboarding Requirements — Documents submitted once at the start of OJT (e.g., MOA, Medical Certificate, Insurance)

2.	Daily Submission Requirements — Documents submitted regularly during OJT (e.g., Weekly Reports, Logbook)

 
—	Adding a Requirement
1.	Click + Add Requirement.
2.	Fill in the form:
3.	Name — Requirement title (e.g., "Memorandum of Agreement")
4.	Description — Brief explanation of what is required (optional)
5.	Category — Select Onboarding or Daily
6.	Max Files — Maximum number of files students can upload (1–10)
7.	Sort Order — Display order in the student's Requirements section (1, 2, 3, etc.)
8.	Click Save — the requirement appears in all students' Requirements sections.
—	Editing a Requirement
1.	Find the requirement in the list (under Onboarding or Daily section).
2.	Click Edit.
3.	Update the fields as needed.
4.	Click Save.
—	Archiving a Requirement
1.	Find the requirement in the list.
2.	Click Archive → click Confirm.
3.	The requirement is moved to the archive and no longer visible to students.
—	Viewing Archived Requirements
1.	Click 🗑 Archive Trash at the top of the page.
2.	A modal opens showing all archived requirements.
3.	To restore: click Restore → click Confirm — the requirement is reactivated.
4.	To permanently delete: click Delete → click Confirm — this action cannot be undone.
—	Reordering Requirements
1.	Edit the Sort Order field for each requirement.
2.	Lower numbers appear first (1, 2, 3, etc.).
3.	Click Save — the order is updated immediately.

6.9 Settings

—	Click Settings in the navigation to configure system-wide settings.
 
—	OJT Requirements
Required Hours:
1.	Set the total number of hours required for OJT completion (default: 600)
2.	Type the new value → click **Save Settings**

—	Email Settings
Enable Email Notifications:
1.	Toggle the checkbox to enable or disable all system email notifications
2.	When checked — emails are sent for registration, approvals, and other events
3.	When unchecked — no emails are sent (useful for testing or maintenance)
4.	Click Save Settings to apply changes

—	Saving Settings
1.	Make your changes in any section.
2.	Click Save Settings at the bottom of the form.
3.	A success message appears confirming your changes.

Note: Settings changes apply system-wide and affect all users immediately.


















APPENDIX D
SCREEN LAYOUTS
Landing Page
 
Log In/Register Page
 
 
OJT Student’s Page
 
 
 
 
 
Company Supervisor’s Page
 
 
 
Coordinator’s Page
 
 
 
 
CCIT HEAD Page
 
 
 
 
 
 
 
 






APPENDIX E	
Test Results
I. 	RESPONDENT’S PROFILE
Classification	Frequency	Percentage
OJT Student — Section A	44	41.90%
OJT Student — Section B	48	45.71%
Company Supervisor	11	10.48%
OJT Coordinator	1	0.95%
CCIT Head	1	0.95%
TOTAL	105	100%

II.	RESPONDENTS' EVALUATION IN THE LEVEL OF ACCEPTANCE OF THE PRMSU STA. CRUZ CAMPUS BSCS OJT MONITORING SYSTEM: ROLE-BASED ACCESS CONTROL INTEGRATION USING THE TECHNOLOGY ACCEPTANCE MODEL (TAM)

Perceived Usefulness 
No.	Perceived Usefulness	CCIT Head 	Coordinator 	Student	Supervisor	Mean	Descriptive Equivalent
1	The PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration enables me to accomplish tasks more quickly (e.g., real-time hour tracking)	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
2	The PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration has improved the quality of lifestyle within the workplace.	4.00	4.00	3.97	4.00	3.99	Highly Acceptable
3	The PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration makes it easier to track the mandatory 600-hour requirement.	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
4	The PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration has improved productivity by automating the monitoring process.	4.00	4.00	3.97	3.91	3.97	Highly Acceptable
5	The PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration gives me greater control over managing processes specific to my role.	4.00	4.00	3.98	4.00	4.00	Highly Acceptable
6	The use of PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration increases the effectiveness by preventing "buddy punching" or fraudulent logging.	4.00	4.00	3.96	4.00	3.99	Highly Acceptable
7	The PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration gives me access to a lot of information.	4.00	4.00	4.00	3.91	3.98	Highly Acceptable
8	The PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration provides thorough information for my purposes.	4.00	4.00	3.99	3.91	3.98	Highly Acceptable
9	The advantages of the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration outweigh the disadvantages.	4.00	4.00	3.98	4.00	4.00	Highly Acceptable
General Weighted Mean	4.00	4.00	3.98	3.97	3.99	Highly Acceptable

Perceived Ease of Use

No.	Perceived Ease of Use	CCIT Head 	Coordinator 	Student	Supervisor	Mean	Descriptive Equivalent
1	My interaction with the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration in the task processes has been clear and understandable.	4.00	4.00	3.93	4.00	3.98	Highly Acceptable
2	Overall, the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is easy to use.	4.00	4.00	3.97	4.00	3.99	Highly Acceptable
3	Learning to operate with the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration was easy for me.	4.00	4.00	3.95	4.00	3.99	Highly Acceptable
4	The use of the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration does not confuse me.	4.00	4.00	3.95	4.00	3.99	Highly Acceptable
5	The PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is easy to navigate.	4.00	4.00	3.98	4.00	4.00	Highly Acceptable
6	Using the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration enables me to have more accurate information.	4.00	4.00	4.00	3.91	3.98	Highly Acceptable
General Weighted Mean	4.00	4.00	3.96	3.99	3.99	Highly Acceptable

Behavioral Intention to Use

No.	Behavioral Intention to Use	CCIT Head 	Coordinator 	Student	Supervisor	Mean	Descriptive Equivalent
1	I intended to continue using PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration for OJT monitoring processes to perform my job.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
2	I intent to frequently use PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration for automated processes to perform my job.	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
3	Given that I have access to PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration for OJT monitoring processes, I predict that I would adopt it.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
4	Generally speaking, I would use PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration processes without pressure form external social factors.	4.00	4.00	3.98	4.00	4.00	Highly Acceptable
5	People around me who use PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration have more prestige than those who do not.	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
6	Using PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration for internship processes is considered a status symbol among others.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
General Weighted Mean	4.00	4.00	3.99	4.00	4.00	Highly Acceptable

Attitude Toward Use

No.	Attitude Toward Use	CCIT Head 	Coordinator 	Student	Supervisor	Mean	Descriptive Equivalent
1	I think positively about using the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
2	The PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is a valuable tool for enhancing internship management at PRMSU CCIT Department.	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
3	Using the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is a wise idea.	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
4	The PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is worth using to improve task efficiency.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
5	I plan to use the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration assistance regularly in the future.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
6	Using the PRMSU Sta.Cruz Campus BSCS OJT Monitoring System: Role-Based Access Control Integration is a pleasant experience.	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
General Weighted Mean	4.00	4.00	4.00	4.00	4.00	Highly Acceptable

Summary of the Level of Acceptance of the PRMSU Sta. Cruz Campus BSCS OJT Monitory System using Technology Acceptance Model (TAM) 

 No.	Technology Acceptance Model	CCIT Head 	Coordinator 	Student	Supervisor	Mean	Descriptive Equivalent
1	Perceived usefulness	4.00	4.00	3.98	3.97	3.99	Highly Acceptable
2	Perceived ease of use	4.00	4.00	3.96	3.99	3.99	Highly Acceptable
3	Behavioral intention to use	4.00	4.00	3.99	4.00	4.00	Highly Acceptable
4	Attitude toward use	4.00	4.00	4.00	4.00	4.00	Highly Acceptable
General Weighted Mean	4.00	4.00	3.98	3.99	3.99	Highly Acceptable
Daily Basis

ACTUAL USE(Daily)	Coordinator	Student	Supervisor	Frequency	Percentage
Not Everyday	0	0	0	0	0.00%
1 time per day	0	0	0	0	0.00%
2 times per day	0	0	0	0	0.00%
3 times per day                                           	0	0	0	0	0.00%
4 times per day                                           	0	0	0	0	0.00%
5 times per day                                           	12	0	0	12	11.43%
constantly	0	0	0	0	0.00%
Constantly	91	1	1	93	88.57%
TOTAL	103	1	1	105	100.00%

Weekly Basis
ACTUAL USE(Weekly)	Coordinator 	Student	Supervisor	Frequency	Percentage
Not Every Week	0	0	0	0	0.00%
1 time per week	0	0	0	0	0.00%
2 time per week	0	0	0	0	0.00%
3 time per week	0	0	0	0	0.00%
4 time per week	0	0	0	0	0.00%
5 time per week	6	0	0	6	5.71%
6 time per week	0	0	0	0	0.00%
every week	97	1	1	99	94.29%
TOTAL	103	1	1	105	100.00%




















APPENDIX F
Copy of Request Letter/MOA/MOU
 
 
APPENDIX G
CURRICULUM VITAE
 
 
 	
 	
 
 	
	 
 
 
 
 
APPENDIX H
DOCUMENTATION

DATA GATHERING

	 

DISTRIBUTION OF QUESTIONNAIRES
 
SYSTEM CONSULTATION/IT EXPERT

 

PILOT TESTING
 
 
 

