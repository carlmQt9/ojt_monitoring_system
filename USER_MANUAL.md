# PRMSU OJT Monitoring System — User Manual

**Institution:** President Ramon Magsaysay State University (PRMSU)
**Version:** 1.0 | **Date:** April 2026

---

## Table of Contents

- [Introduction](#introduction)
- [System Overview](#system-overview)
- [1 - Safety and Access](#1---safety-and-access)
- [2 - Getting Started](#2---getting-started)
- [3 - Student Guide](#3---student-guide)
- [4 - Supervisor Guide](#4---supervisor-guide)
- [5 - Coordinator Guide](#5---coordinator-guide)
- [6 - CCIT Head Guide](#6---ccit-head-guide)
  - [6.1 Dashboard Navigation](#61-dashboard-navigation)
  - [6.2 Overview](#62-overview)
  - [6.3 Users](#63-users)
  - [6.4 Analytics](#64-analytics)
  - [6.5 School Years](#65-school-years)
  - [6.6 School IDs](#66-school-ids)
  - [6.7 Reports](#67-reports)
  - [6.8 Manage Requirements](#68-manage-requirements)
  - [6.9 Settings](#69-settings)
- [7 - Email Notifications](#7---email-notifications)
- [8 - Troubleshooting](#8---troubleshooting)
- [9 - FAQs](#9---faqs)
- [Revision History](#revision-history)

---

## INTRODUCTION

The **PRMSU OJT Monitoring System** is a web-based platform that digitizes the entire On-the-Job Training process — from daily time-in/out with photo verification, to requirement submissions, evaluations, and certificate awarding. This manual covers all features for every user role.

---

## SYSTEM OVERVIEW

### User Roles

| Role | Description |
|---|---|
| **Student** | Records attendance, submits requirements, tracks hours and certificate |
| **Supervisor** | Approves records, evaluates interns, awards certificates |
| **Coordinator** | Oversees all students and companies, generates reports |
| **CCIT Head** | Full system admin — users, school years, IDs, analytics |

### Key Features

- Face-detection time-in/out with photo capture
- Auto session detection (Morning / Afternoon)
- 600-hour OJT tracking with overtime (OT) support
- Requirement submission and approval workflow
- Supervisor evaluation with star ratings
- Certificate awarding and DTR export
- System analytics and light/dark theme

---

## 1 - SAFETY AND ACCESS

- Keep your password private. Never share your account.
- Always click **Logout** on shared computers.
- Use Chrome or Edge for best compatibility.
- Allow camera access in your browser before timing in.
- Ensure good lighting when capturing your photo — avoid backlighting.
- Do not submit photos on behalf of another person.

---

## 2 - GETTING STARTED

### 2.1 Landing Page

Open the system URL in your browser. From the top navigation bar:
- Click **Log in** to access your account.
- Click **Register** to create a new account.
- Click the **moon/sun icon** to toggle light/dark theme.

---

### 2.2 Registration

1. Click **Register** in the navigation bar.
2. Fill in the form fields:

| Field | Notes |
|---|---|
| **Full Name** | 2–100 characters |
| **Email** | Unique; used as your login credential |
| **Role** | Click the dropdown → select Student / Supervisor / Coordinator / CCIT Head |
| **Company** | Click the dropdown → select your company *(Student & Supervisor only)* |
| **School Year** | Click the dropdown → select the current year marked ★ *(Student & Supervisor only)* |
| **School ID** | Type your school ID number *(Students only — must be on the pre-approved list)* |
| **Password** | 8–128 chars; must include uppercase, lowercase, number, and special character |
| **Confirm Password** | Re-type your password |
| **Terms** | Click the checkbox to agree |

> Selecting your role will show or hide fields automatically.

3. Click **Create Account**.

---

### 2.3 After Registration

| Role | What Happens |
|---|---|
| Student | Approved immediately — click **Log in** to access your account |
| Supervisor / Coordinator / CCIT Head | Account is pending — wait for CCIT Head approval before logging in |

---

### 2.4 Login

1. Click **Log in** in the navigation bar.
2. Type your **Email** and **Password**.
3. Click **Sign In** — you are redirected to your dashboard.

**If you see an error:**
- *"Invalid credentials"* — re-check your email and password.
- *"Pending approval"* — contact your CCIT Head.

---

### 2.5 Forgot Password

1. Click **Forgot Password?** on the login page.
2. Type your registered email address.
3. Click **Send Reset Link**.
4. Open your email → click the reset link → set a new password.
5. Click **Log in** and sign in with your new password.

---

### 2.6 Logout

1. Click **Logout** in the navigation or sidebar.
2. Click **Confirm** on the prompt.
3. You are redirected to the landing page.

---

## 3 - STUDENT GUIDE

### 3.1 Dashboard Navigation

Click any section in the navigation menu to switch views:

| Section | What You Can Do |
|---|---|
| **Overview** | View hours progress and charts |
| **Time In/Out** | Record your daily attendance |
| **History** | View past attendance records |
| **Requirements** | Submit OJT documents |
| **Reports** | View and upload reports |

---

### 3.2 Overview

Click **Overview** in the navigation. You will see:
- Total hours completed, hours remaining, progress percentage, and status.
- If you have completed 600 hours and your supervisor has awarded your certificate, it will be displayed here.

---

### 3.3 Time In / Out

Click **Time In/Out** in the navigation.

Sessions are auto-detected by server time:

| Session | Time |
|---|---|
| Morning | Before 12:50 PM |
| Afternoon | 12:50 PM onwards |

#### How to Time In

1. Click **Time In**.
2. The camera opens — an oval face guide appears with a **RED** frame.
3. Position your face inside the oval until the frame turns **GREEN**.
4. Click **Capture**.
5. Review your photo:
   - Click **Submit** if the photo is clear.
   - Click **Retake** to take another photo.

#### How to Time Out

1. Click **Time Out**.
2. Click **Confirm** on the modal.
3. The camera opens again — repeat the same face capture steps.
4. Click **Capture** → click **Submit**.

**Important rules:**
- You cannot time in twice for the same session.
- Forgot morning time-out → system auto times out at 12:00 PM.
- Forgot afternoon time-out → session is auto-denied the next day.
- Hours are only credited after your supervisor or coordinator approves the record.

#### Overtime (OT)

- Regular hours are capped at **8 hours/day**.
- If you exceed 8 hours, the system prompts you to submit an OT Letter before timing out.
- Click **Submit OT Letter** → upload the letter → click **Submit**.
- OT hours are credited only after the OT letter is approved.

---

### 3.4 History

1. Click **History** in the navigation.
2. Records are grouped by date. Each card shows AM In, AM Out, PM In, PM Out, status, and hours.
3. Click any **photo thumbnail** to view it full size.

| Status | Meaning |
|---|---|
| Pending | Awaiting supervisor/coordinator approval |
| Approved | Hours credited to your total |
| Denied | No hours credited; reason is shown |

---

### 3.5 Requirements

1. Click **Requirements** in the navigation.
2. Find the requirement you need to submit.
3. Click **Upload File** → select your file → click **Submit**.

**If a requirement is denied:**
1. Read the reason shown on the requirement.
2. Click **Resubmit** → select the corrected file → click **Submit**.

| Status | Meaning |
|---|---|
| Pending | Under review |
| Approved | Accepted |
| Denied | Rejected — click Resubmit to correct and resubmit |

---

### 3.6 Reports

1. Click **Reports** in the navigation.
2. Click a filter tab — **All**, **Pending**, **Approved**, or **Denied** — to filter the list.
3. To upload a new report: click **Upload** → select your file → click **Submit**.

---

### 3.7 Certificate

1. Click **Overview** in the navigation.
2. Once you have completed 600 hours and your supervisor has awarded your certificate, it will appear here.
3. Click the certificate image to view or save it.

---

## 4 - SUPERVISOR GUIDE

> Your account must be approved by the CCIT Head before you can log in.

### 4.1 Dashboard Navigation

Click any section in the navigation menu:

| Section | What You Can Do |
|---|---|
| **Overview** | View stats and charts for your interns |
| **Interns** | Manage, approve, and evaluate interns |
| **Certificates** | Award certificates to completed interns |

---

### 4.2 Overview

Click **Overview** in the navigation to see 4 summary stats and 4 charts covering intern progress, completion status, daily time-ins trend, and pending requirements.

---

### 4.3 Interns

1. Click **Interns** in the navigation.
2. Use the **search bar** to find a specific intern by name.
3. Click an **intern card** to expand it — four tabs appear.

---

#### Tab 1: Daily Logs

Click the **Daily Logs** tab on the expanded intern card.

**To approve a record:**
1. Find the record in the list.
2. Click **Approve** — hours are credited and the student receives an email.

**To approve all records for a day:**
1. Click **Approve All** on the day group — approves all sessions at once.

**To deny a record:**
1. Click **Deny** on the record.
2. Type a reason in the field.
3. Click **Confirm** — no hours are credited.

---

#### Tab 2: Time Edits

Click the **Time Edits** tab on the expanded intern card.

**To undo an approval:**
1. Find the approved record.
2. Click **Undo Approval**.
3. Click **Confirm** — record reverts to Pending and hours are deducted.

**To redo an undone record:**
1. Find the pending record.
2. Click **Redo Approval**.
3. Click **Confirm** — record is re-approved and hours are added back.

---

#### Tab 3: Requirements

Click the **Requirements** tab on the expanded intern card.

**To approve:**
1. Click **Approve** next to the requirement.

**To deny:**
1. Click **Deny** next to the requirement.
2. Type your feedback in the field.
3. Click **Confirm** — the student can see your feedback and resubmit.

---

#### Tab 4: Evaluation

Click the **Evaluation** tab on the expanded intern card.

> This tab is locked until the intern reaches 600 hours.

1. Type the intern's **Job Title**.
2. Set the **Evaluation Period** — click the From date field and To date field.
3. Click the **star rating** (1–5) for each of the 8 criteria:

| Criterion | Criterion |
|---|---|
| Attendance | Work Ethics |
| Communication | Time Management |
| Collaboration | Job Skills |
| Problem Solving | Employability |

4. Fill in the PRMSU-specific fields: Quality of Work, Quantity of Work, Job Knowledge, Working Relationships, Attendance & Dependability, Specific Achievements.
5. Type overall **Feedback** in the text area.
6. Click **Submit Evaluation**.
7. Click **Generate Final DTR** to download the intern's DTR report.

---

### 4.4 Certificates

1. Click **Certificates** in the navigation.
2. Find the intern in the list.
3. Click **Award Certificate**.
4. Click **Upload** → select the certificate image file.
5. Click **Confirm Award** — the student can now view the certificate on their dashboard.

---

## 5 - COORDINATOR GUIDE

> Your account must be approved by the CCIT Head before you can log in.

### 5.1 Dashboard Navigation

Click any section in the navigation menu:

| Section | What You Can Do |
|---|---|
| **Overview** | View system-wide analytics and charts |
| **Students** | Monitor all students, approve records, view DTR, view evaluations |
| **Reports & Requirements** | Review and approve/deny all student requirement submissions |
| **Companies** | Manage company records |

---

### 5.2 Overview

Click **Overview** in the navigation. You will see:
- Total students, completed students, pending approvals, and pending reports counts.
- **Student progress distribution** — how many students are in each range (0–25%, 26–50%, 51–75%, 76–100%).
- **Reports status** — count of approved, pending, and rejected reports.
- **Daily time-ins chart** — 7-day trend of student time-ins.
- **Top companies** — companies with the most active interns.

---

### 5.3 Students

1. Click **Students** in the navigation.
2. All students across all companies are listed in a table.

#### Searching and Filtering

- Type a student name in the **Search** bar to find them quickly.
- Click the **School Year** filter dropdown to show students from a specific year.
- Click the **Status** filter to show approved or pending students.

#### Student Table Columns

Each student row shows:
- Name and company
- Hours completed and progress percentage
- Pending logs and pending requirements count
- Status (Approved / Pending)
- Action buttons: **View DTR** and **Evaluation Rating**

#### Viewing a Student's DTR

1. Find the student in the table.
2. Click **View DTR** — a modal opens showing all approved time-in/out records for that student.
3. Click **Download** or **Print** to save the DTR.

#### Viewing a Student's Evaluation

1. Find the student in the table.
2. Click **Evaluation Rating** — a modal opens showing the evaluation submitted by the supervisor.
3. If the button shows 🔒 **Evaluation Rating**, the student has not yet completed the required hours and no evaluation exists yet.

#### Approving / Denying Time-In Records

1. Find the student in the table.
2. Click the student row to expand their daily log details.
3. Review the time-in and time-out records.

**To approve a record:**
1. Click **Approve** next to the record — hours are credited and the student receives an email.

**To approve all records for a day:**
1. Click **Approve All** on the day group.

**To deny a record:**
1. Click **Deny** next to the record.
2. Type a reason in the field.
3. Click **Confirm** — no hours are credited.

**To undo an approval:**
1. Find the approved record.
2. Click **Undo Approval** → click **Confirm** — record reverts to Pending and hours are deducted.

**To redo an undone record:**
1. Find the pending record marked as undone.
2. Click **Redo Approval** → click **Confirm** — record is re-approved and hours are added back.

---

### 5.4 Reports & Requirements

1. Click **Reports & Requirements** in the navigation.
2. All student requirement submissions are listed with student name, requirement title, file, submission date, and status.

**To approve a requirement:**
1. Find the submission in the list.
2. Click **Approve** — status changes to Approved.

**To deny a requirement:**
1. Click **Deny** next to the submission.
2. Type a reason or feedback for the student.
3. Click **Confirm** — the student can see the feedback and resubmit.

**Filtering requirements:**
- Click the **All / Pending / Approved / Denied** filter tabs to narrow the list.

---

### 5.5 Companies

#### To add a company:
1. Click **Companies** in the navigation.
2. Click **Add Company**.
3. Fill in: Name, Industry, Location, Contact Person, Contact Email, Contact Phone, Description (optional).
4. Click **Save**.

#### To archive a company:
1. Find the company card.
2. Click **Archive** → click **Confirm**.
3. To view archived companies, click the **Show Archived** toggle.

---

### 5.6 Generating Reports

1. Click **Students** in the navigation.
2. Find the student in the table.
3. Click **View DTR** to open the DTR modal.
4. Click **Download** or **Print** to save the report.

---

## 6 - CCIT HEAD GUIDE

> Your account must be approved by another CCIT Head or system administrator before you can log in.

### 6.1 Dashboard Navigation

Click any section in the navigation menu:

| Section | Purpose |
|---|---|
| **Overview** | View system-wide analytics |
| **Users** | Add, approve, and archive users |
| **Analytics** | View system-wide stats and charts |
| **School Years** | Create and manage school year cohorts |
| **School IDs** | Upload pre-approved student ID numbers |
| **Reports** | Access all system reports |
| **Manage Requirements** | Define required student submissions |
| **Settings** | Configure system settings |

---

### 6.2 Overview

Click **Overview** in the navigation to see:

**Summary Statistics:**
- **Total Users** — All registered users across all roles
- **Total Students** — Currently registered students
- **Active Programs** — Ongoing OJT programs
- **Completion Rate** — Overall system completion percentage

**Charts:**
- **Completion Status** (Donut Chart) — Shows completed, in progress, and not started students
- **Users by Role** (Bar Chart) — Distribution of students, supervisors, coordinators, and CCIT heads
- **Student Trend** (Line Chart) — 6-month student registration trend

Use the **School Year** filter in the top header to view data for a specific year or all years.

---

### 6.3 Users

Click **Users** in the navigation to manage all system users.

#### Searching and Filtering Users

- **Search Bar** — Type a name or email to find specific users
- **Role Filter** — Select All Roles / Student / Supervisor / Coordinator / CCIT Head
- **Approval Filter** — Select All Status / Pending / Approved

#### User Table Columns

Each user row displays:
- Name and email
- Role
- School ID (students only)
- Company (students and supervisors only)
- School Year (students and supervisors only)
- Status (Pending / Approved)
- Action buttons

#### Adding a New User

1. Click **+ Add User**.
2. Fill in the form fields:
   - **Name** — Full name (2–100 characters)
   - **Email** — Unique email address
   - **Role** — Select from dropdown
   - **Company** — Select company (for students and supervisors)
   - **School Year** — Select school year (for students and supervisors)
   - **School ID** — Type school ID (for students only)
   - **Password** — 8–128 characters with uppercase, lowercase, number, and special character
   - **Confirm Password** — Re-type password
3. Click **Save** — the user receives a welcome email with login instructions.

#### Approving Pending Users

**To approve a single user:**
1. Find the user with **Pending** status.
2. Click **Approve** → click **Confirm** — the user can now log in.

**To approve all pending users at once:**
1. Click **✓ Approve All Pending** at the top of the table.
2. Click **Confirm** — all pending users are approved simultaneously.

#### Editing a User

1. Find the user in the table.
2. Click **Edit** on the user row.
3. Update the fields as needed.
4. Click **Save** — changes are applied immediately.

#### Archiving a User

1. Find the user in the table.
2. Click **Archive** → click **Confirm**.
3. The user is moved to the archive and can no longer log in.

#### Viewing Archived Users

1. Click **🗑 Archive Trash** at the top of the page.
2. A modal opens showing all archived users.
3. To restore a user: click **Restore** → click **Confirm** — the user is reactivated.
4. To permanently delete: click **Delete** → click **Confirm** — this action cannot be undone.

---

### 6.4 Analytics

Click **Analytics** in the navigation to view detailed student progress tracking.

**At the top of the page:**
- A **School Year** dropdown filter — click it to filter students by school year.
- A **Search** bar — type a student name to find them quickly.

**Student Analytics Table shows:**

| Column | Description |
|---|---|
| **Student Name** | The student's full name |
| **Hours Completed** | Hours completed out of 600 (e.g., 600.0000/600.00) |
| **Progress** | A progress bar and percentage (e.g., 100.00%, 1.33%) |
| **Status** | **Completed** (green) or **In Progress** (blue) |
| **Actions** | **View DTR** button |

**To view a student's DTR:**
1. Find the student in the table.
2. Click **View DTR** — a modal opens showing the student's complete Daily Time Record.
3. Click **Download** or **Print** to save the DTR.

---

### 6.5 School Years

Click **School Years** in the navigation to manage academic year cohorts.

#### Adding a School Year

1. Click **+ Add School Year**.
2. Type the label (e.g., `2025-2026`, `2026-2027`).
3. Click **Save** — the school year is added to the list.

#### Setting the Active School Year

1. Find the school year in the list.
2. Click **Set as Active** → click **Confirm**.
3. The school year is now marked with a ★ star icon.
4. This year will be shown as the default during student and supervisor registration.

> **Note:** Only one school year can be active at a time. Setting a new active year will deactivate the previous one.

#### Editing a School Year

1. Find the school year in the list.
2. Click **Edit** on the school year row.
3. Update the label.
4. Click **Save**.

#### Archiving a School Year

1. Find the school year in the list.
2. Click **Archive** → click **Confirm**.
3. The school year is moved to the archive.

#### Viewing Archived School Years

1. Click **🗑 Show Archived** at the top of the page.
2. A modal opens showing all archived school years.
3. To restore: click **Restore** → click **Confirm**.
4. To permanently delete: click **Delete** → click **Confirm** — this action cannot be undone.

---

### 6.6 School IDs

Click **School IDs** in the navigation to manage pre-approved student ID numbers.

> Only students with an approved School ID (e.g. `23-1-2-0001`) can register.

#### Adding a Single School ID

1. Type the school ID number in the input field (e.g. `23-1-2-0001`).
2. Click **Add** — the ID is added to the list immediately.

#### Bulk Import (Multiple IDs at Once)

1. Click **▶ Bulk Import (paste multiple IDs)** to expand the bulk import field.
2. Paste multiple IDs — one per line.
3. Click **Import** — all IDs are added at once.

#### Searching School IDs

- Type in the **Search school IDs...** bar to find a specific ID.

#### School IDs Table Columns

| Column | Description |
|---|---|
| **School ID** | The ID number (e.g. `22-1-2-0255`) |
| **School Year** | The academic year the ID belongs to |
| **Status** | **Used** (orange) — claimed by a student / **Available** (green) — not yet used |
| **Added** | Date the ID was added to the system |
| **Action** | **Edit** and **Archive** buttons |

#### Editing a School ID

1. Find the ID in the table.
2. Click **Edit** — update the ID number or school year.
3. Click **Save**.

#### Archiving a School ID

1. Find the ID in the table.
2. Click **Archive** → click **Confirm** — the ID is removed from the active list.

#### Viewing Archived School IDs

1. Click **🗑 Archive Trash** at the top right of the page.
2. A modal opens showing all archived IDs.
3. To restore: click **Restore** → click **Confirm**.

---

---

### 6.7 Reports

Click **Reports** in the navigation. The page shows 3 report cards under **System Reports**.

| Report | Description | Action |
|---|---|---|
| **System Report** | All users, students, and OJT progress overview | Click **Export PDF** |
| **Student Progress** | Detailed OJT hours and completion status per student | Click **Export PDF** |
| **Attendance Report** | System-wide time-in/out and attendance records | Click **Export PDF** |

**To generate any report:**
1. Click **Reports** in the navigation.
2. Find the report card you need.
3. Click **Export PDF** — the report downloads as a PDF file.

Use the **School Year** filter at the top right to export reports for a specific year.

---

### 6.8 Manage Requirements

Click **Manage Requirements** in the navigation to define required student submissions.

#### Requirement Categories

- **Onboarding Requirements** — Documents submitted once at the start of OJT (e.g., MOA, Medical Certificate, Insurance)
- **Daily Submission Requirements** — Documents submitted regularly during OJT (e.g., Weekly Reports, Logbook)

#### Adding a Requirement

1. Click **+ Add Requirement**.
2. Fill in the form:
   - **Name** — Requirement title (e.g., "Memorandum of Agreement")
   - **Description** — Brief explanation of what is required (optional)
   - **Category** — Select Onboarding or Daily
   - **Max Files** — Maximum number of files students can upload (1–10)
   - **Sort Order** — Display order in the student's Requirements section (1, 2, 3, etc.)
3. Click **Save** — the requirement appears in all students' Requirements sections.

#### Editing a Requirement

1. Find the requirement in the list (under Onboarding or Daily section).
2. Click **Edit**.
3. Update the fields as needed.
4. Click **Save**.

#### Archiving a Requirement

1. Find the requirement in the list.
2. Click **Archive** → click **Confirm**.
3. The requirement is moved to the archive and no longer visible to students.

#### Viewing Archived Requirements

1. Click **🗑 Archive Trash** at the top of the page.
2. A modal opens showing all archived requirements.
3. To restore: click **Restore** → click **Confirm** — the requirement is reactivated.
4. To permanently delete: click **Delete** → click **Confirm** — this action cannot be undone.

#### Reordering Requirements

1. Edit the **Sort Order** field for each requirement.
2. Lower numbers appear first (1, 2, 3, etc.).
3. Click **Save** — the order is updated immediately.

---

### 6.9 Settings

Click **Settings** in the navigation to configure system-wide settings.

#### OJT Requirements

**Required Hours:**
- Set the total number of hours required for OJT completion (default: 600)
- Type the new value → click **Save Settings**

#### Email Settings

**Enable Email Notifications:**
- Toggle the checkbox to enable or disable all system email notifications
- When **checked** — emails are sent for registration, approvals, and other events
- When **unchecked** — no emails are sent (useful for testing or maintenance)
- Click **Save Settings** to apply changes

#### Saving Settings

1. Make your changes in any section.
2. Click **Save Settings** at the bottom of the form.
3. A success message appears confirming your changes.

> **Note:** Settings changes apply system-wide and affect all users immediately.

---

## 7 - EMAIL NOTIFICATIONS

| Event | Recipient | Content |
|---|---|---|
| Registration (Student) | Student | Welcome email with login instructions |
| Registration (Non-Student) | Supervisor / Coordinator / CCIT Head | Account pending approval notice |
| Time-In Approved | Student | Date and hours credited |

> If you do not receive an email, check your spam/junk folder.

---

## 8 - TROUBLESHOOTING

### Account is pending on login
- Your account has not been approved yet.
- Only **Supervisor**, **Coordinator**, and **CCIT Head** accounts require approval.
- Contact your **CCIT Head** and ask them to click **Approve** on your account under the Users section.

### Invalid credentials error
- Re-check your email address and password — passwords are **case-sensitive**.
- Make sure Caps Lock is not on.
- If you forgot your password, click **Forgot Password?** on the login page and follow the reset link sent to your email.

### School ID is rejected during registration
- Your school ID must be on the pre-approved list uploaded by the CCIT Head.
- Contact your **Coordinator** or **CCIT Head** and ask them to add your ID in the **School IDs** section.
- Each school ID can only be used once — if it was already used by another student, a new ID must be added.

### Camera is not working for time-in
- Click the **camera icon** in the browser address bar and select **Allow**.
- Use **Google Chrome** or **Microsoft Edge** — other browsers may not support camera access.
- Make sure no other application is currently using your camera.
- Refresh the page and try again.

### Face detection frame stays RED
- Ensure you are in a **well-lit area** — avoid sitting with a bright window or light source behind you.
- Center your face clearly inside the oval guide on screen.
- Remove hats, masks, or glasses that may be blocking your face.
- Move closer to or further from the camera to adjust framing.

### Hours are not updating after time-out
- Hours are only credited after your **supervisor or coordinator** clicks **Approve** on your time-in record.
- Check the **History** section — if your record shows **Pending**, it has not been approved yet.
- Contact your supervisor and ask them to review your pending records.

### Forgot to time out — Morning session
- The system automatically times you out at **12:00 PM** if you forget.
- Your morning hours up to 12:00 PM will be calculated and submitted for approval.

### Forgot to time out — Afternoon session
- If you log in the next day without having timed out from the afternoon session, that session is automatically **denied**.
- No hours are credited for that session.

### OT hours are not credited
- Overtime hours require an **OT Letter** to be submitted and approved.
- When you reach 8 hours for the day, click **Submit OT Letter**, upload the letter, and click **Submit**.
- OT hours will only be credited after your supervisor approves the OT letter.

### Evaluation form is locked
- The evaluation form is locked until the intern has completed **600 OJT hours**.
- Check the intern's progress — if they have not yet reached 600 hours, the form will remain locked.

### Company is not in the dropdown during registration
- Contact your **Coordinator** or **CCIT Head** and ask them to add the company in the **Companies** section.
- You cannot register until the company is added to the system.

### Certificate is not visible on the dashboard
- Two conditions must be met:
  - You must have completed **600 OJT hours**.
  - Your **supervisor** must have clicked **Award Certificate** and uploaded the certificate image.
- If both are met and the certificate is still not showing, log out and log back in to refresh your session.

### File upload error for requirements or reports
- Check that your file format is supported: **PDF, JPG, PNG, DOCX**.
- Make sure the file is not too large — try compressing it before uploading.
- Ensure you have a stable internet connection during the upload.
- Try using a different browser if the issue persists.

---

## 9 - FAQs

**Can I edit my time-in records?**
- No. All times are recorded by the server at the moment you submit. They cannot be manually altered.

**Why is my record still Pending?**
- Your supervisor or coordinator has not yet clicked **Approve**. Contact them directly to review your records.

**What is the password requirement?**
- 8–128 characters containing at least one uppercase letter, one lowercase letter, one number, and one special character (e.g., `@`, `#`, `!`).

**Can I register with the same email address twice?**
- No. Each email address can only be registered once in the system.

**How are OJT hours calculated?**
- Hours are calculated from your time-in to your time-out for each session.
- Regular hours are capped at **8 hours per day** across both sessions.
- Any hours beyond 8 in a day are counted as overtime (OT) and require an approved OT letter.

**Can a supervisor undo an approval?**
- Yes. Click the **Time Edits** tab on the intern's card, find the approved record, and click **Undo Approval**.

**How do I know when my record has been approved?**
- You will receive an **email notification**.
- The **History** section will show a green **Approved** badge on the record.

**Can I still time in after completing 600 hours?**
- No. Once you reach 600 hours, the Time In/Out panel is replaced by your certificate view.

**How do I generate a DTR?**
- **Students** — Click **Reports** in the navigation.
- **Supervisors** — Expand the intern's card → click the **Evaluation** tab → click **Generate Final DTR**.
- **Coordinators and CCIT Head** — Click **Students** → click **View DTR** next to the student.

**How do I switch between light and dark mode?**
- Click the **moon icon** (dark mode) or **sun icon** (light mode) in the top navigation bar on any page.

**What browsers are supported?**
- **Google Chrome** and **Microsoft Edge** are recommended for full compatibility, especially for camera-based time-in/out.

---

## REVISION HISTORY

| Version | Date | Changes |
|---|---|---|
| 1.0 | 2026-04-28 | Initial release |

---

*For support, contact your system administrator or coordinator.*
*PRMSU OJT Monitoring System — President Ramon Magsaysay State University*
